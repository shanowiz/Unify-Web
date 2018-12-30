<?php

$con = "";
$id = 1;
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

		if (isset($_FILES['firstImage']['tmp_name'])) {
			$image = addslashes (file_get_contents($_FILES['firstImage']['tmp_name']));
			$query = "UPDATE home_images SET firstimage = '$image' WHERE id = '$id'";
			//INSERT INTO home_images VALUES ('$firstimage') ON DUPLICATE KEY UPDATE `firstimage`='$firstimage'
			$runQuery = mysqli_query($con,$query);
		}
		if (isset($_FILES['secondImage']['tmp_name'])) {
			$image = addslashes (file_get_contents($_FILES['secondImage']['tmp_name']));
			$query = "UPDATE home_images SET secondimage = '$image' WHERE id = '$id'";
			//REPLACE INTO home_images SET firstname = '$image'
			$runQuery = mysqli_query($con,$query);
		}
		if (isset($_FILES['thirdImage']['tmp_name'])) {
			$image = addslashes (file_get_contents($_FILES['thirdImage']['tmp_name']));
			$query = "UPDATE home_images SET thirdimage = '$image' WHERE id = '$id'";
			//REPLACE INTO home_images SET firstname = '$image'
			$runQuery = mysqli_query($con,$query);
		}

		echo "success";
		mysqli_close($con);
		exit;

	}
}

?>