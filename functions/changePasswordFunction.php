<?php
session_start ();
$userId = $_GET['userId'];
$oldPassword = $_POST['oldPassword'];
$newPassword = $_POST['newPassword'];

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


		$displayQuery = "select * from user";
		$runQuery = mysqli_query($con,$displayQuery);

		$count = mysqli_num_rows($runQuery);


		$flag = "";
		while ($row = $runQuery->fetch_assoc()) {

			if (hash ('sha256',$oldPassword) == $row['password']) {

				$flag= 1;
			}
		}

		if ($flag==1) {

			$hashed_password = hash ( 'sha256', $newPassword );
				
			$query = "update user set password='$hashed_password' where id='$userId'";
			$runQuery = mysqli_query($con,$query);
			mysqli_close($con);
			echo "success";
			exit;

		} else {

			echo "oldPasswordErr";
			mysqli_close($con);
			exit;

		}	

	}
}

?>