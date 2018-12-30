<?php
session_start ();
$eventName = $_POST['eventName'];
$venue = $_POST['eventVenue'];
$details = $_POST['eventDetails'];
$cost = $_POST['eventCost'];
$startTime = date("g:i a", strtotime($_POST['startTime']));
$endTime = date("g:i a", strtotime($_POST['endTime']));
//$image = $_FILES['eventImg']['tmp_name'];
$uploadDate = date("Y-m-d");
$eventDate = $_POST['eventDate'];
$id= $_POST['eventId'];
$valid=0;
$eventId='';
$uploader='';
$type="event";
$eventImageUrl = "";
$userid = 0;

set_time_limit(300);

//trim ($latitude,$longitude);

if (isset ($_COOKIE['profileName'])) {

	$uploader= $_COOKIE['profileName'];

}

$con = "";
//contains connection variable to database
include 'databaseConnect.php';

if (!$con) {
	
	echo 'not connected to server';
	mysqli_close($con);
	session_destroy ();

	
} else {

	if (!mysqli_select_db($con,'unify')) {

		echo 'Database  not selected';
		mysqli_close($con);
		session_destroy ();

	} else {


		$displayQuery = "select * from events";
		$runQuery = mysqli_query($con,$displayQuery);

		$count = mysqli_num_rows($runQuery);

		$i = 0;
		$flag = "";

		while ($i<$count) {

			$row = $runQuery->fetch_assoc();

			if (($row['eventdate'] == $eventDate and $row['venue'] == $venue) and (($row['starttime'] == $startTime) || ($startTime > $row['starttime'] and $startTime < $row['endtime']) || ($endTime > $startTime)) and $row['id'] != $id)   {

				$flag = "roomBooked";
				break;
			} else if ($row['name'] == $eventName and $row['id'] != $id) {

				$flag = "eventNameDuplicate";
				break;

			}

			$i++;	
		}

		if ($flag=="roomBooked") {

			echo "eventCollisionErr";

		} else if ($flag=="eventNameDuplicate") {

			echo "eventNameErr";

		} else {

			if (isset($_FILES['eventImg']['tmp_name'])) {

				$image = addslashes (file_get_contents($_FILES['eventImg']['tmp_name']));
				$imageSize = getimagesize ($_FILES['eventImg']['tmp_name']);

				if ($imageSize==false) {

					echo "imageErr";

				} else {

					$query = "update events set name='$eventName',venue='$venue',details='$details',cost='$cost',starttime='$startTime',endtime='$endTime',image='$image',eventdate='$eventDate' where id=".$id;
				}
			} else {

				$query = "update events set name='$eventName',venue='$venue',details='$details',cost='$cost',starttime='$startTime',endtime='$endTime',eventdate='$eventDate' where id=".$id;

			}
			$runQuery = mysqli_query($con,$query);

											
			mysqli_close($con);

			echo "success";
			exit;

			}	

		}
	}

	?>