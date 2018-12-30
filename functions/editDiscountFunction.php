	<?php
session_start ();
$discountName = $_POST['discountName'];
$venue = $_POST['discountVenue'];
$details = $_POST['discountDetails'];
$uploadDate = date("Y-m-d");
$discountDate = $_POST['discountDate'];
$id='';
$valid=0;
$eventId='';
$uploader='';
$type="event";
$discountImageUrl = "";
$userid = 0;

set_time_limit(300);

//trim ($latitude,$longitude);

if (isset ($_COOKIE['userId'])) {
	
	$id= $_COOKIE['userId'];
}

if (isset($_GET['id'])){
	$id = $_GET['id'];
}

if (isset ($_COOKIE['profileName'])) {

	$uploader= $_COOKIE['profileName'];

}

if (isset ($_COOKIE['eventId'])) {

	$eventId= $_COOKIE['eventId'];

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

		if (isset($_FILES['discountImg']['tmp_name'])) {

			$image = addslashes (file_get_contents($_FILES['discountImg']['tmp_name']));
			$imageSize = getimagesize ($_FILES['discountImg']['tmp_name']);

			if ($imageSize==false) {

				echo "imageErr";

			} else {

				$query = "update discounts set name='$discountName',venue='$venue',details='$details',image='$image',date='$discountDate' where id=".$id;
			}
		} else {

			$query = "update discounts set name='$discountName',venue='$venue',details='$details',date='$discountDate' where id=".$id;

		}
		$runQuery = mysqli_query($con,$query);
		echo "success";
		mysqli_close($con);
		exit;	

	}
}

?>