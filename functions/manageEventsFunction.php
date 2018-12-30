<?php
include 'phpTimeoutLimit.php';
SESSION_START ();
//$_SESSION['login']="active";

$id = '';
$eventsList = array ();

if (isset ($_COOKIE['profileName'])) {


	$id= $_COOKIE['profileName'];

}
if (isset($_COOKIE['eventId'])) {
	
	$uploader= $_COOKIE['eventId'];
	
}

$con = "";
//contains con variable which establishes connection to database
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

		if (isset ($_GET['id']) && isset ($_GET['marker'])) {

			$id=$_GET['id'];
			$marker = $_GET['marker'];
			if ($marker=="deleteEvent") {
				$deleteQuery1 = "DELETE FROM events WHERE id =".$id ;
				$runDeleteQuery1 = mysqli_query($con,$deleteQuery1);
				echo "deleted successfully";
			}else{
				echo "Database Error";
			}

		} else if (isset ($_GET['marker']))	{

			$marker = $_GET['marker'];

			if ($marker=="display") {

				$query = "";
				$eventsList = array ();
				if (isset($uploader)) {
					if (strcasecmp($uploader,"admin")==0) {
						$query =  "SELECT * FROM events ORDER BY id DESC" ;
					}else {
						$query =  "SELECT * FROM events WHERE uploader='$id' ORDER BY id DESC" ;
					}
					$runQuery = mysqli_query($con,$query);
				}

				if ($runQuery) {
					while ($row = $runQuery->fetch_assoc()) {

						if (empty($row['image'])){
							$row['image']="../unifyWeb/assets/img/noImage.png";
						}else{
							$row['image']="functions/displayImage.php?id=".$row['id'];			
						}
						$eventsList[]= $row;

					}
					mysqli_close($con);
					if (!empty($eventsList)) {
						Print (json_encode($eventsList));
					}else {
						echo "no events";
					}
				}

			}
		} 









	}

}

?>