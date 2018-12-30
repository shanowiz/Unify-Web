<?php



$con = mysqli_connect('localhost','root','');

if (!$con) {
	
	echo 'not connected to server';
	mysqli_close($con);
	
	
} else {

	if (!mysqli_select_db($con,'unify')) {
		
		echo 'Database  not selected';
		mysqli_close($con);
		
	} else {
		
		if (isset ($_POST['fcm_token'])) {
			
			$fcm_token = $_POST['fcm_token'];
			
			$query = "INSERT INTO fcm_info (fcm_token) VALUES ('$fcm_token')";
			$runQuery = mysqli_query($con,$query);
			mysqli_close($con);
		}
		
	}
}


?>