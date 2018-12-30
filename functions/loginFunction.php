<?php
include 'phpTimeoutLimit.php';

if (isset($_GET['action'])=="destroy") {
	
	if (isset($_SERVER['HTTP_COOKIE'])) {
		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		foreach($cookies as $cookie) {
			$parts = explode('=', $cookie);
			$name = trim($parts[0]);
			setcookie($name, '', time()-1000);
			setcookie($name, '', time()-1000, '/');
		}
	}

	//echo "loginPage";
	header('Location: /unifyWeb/login.php');
	
}else {

	$con = "";
	//containes con variable to database
	include 'databaseConnect.php';

	if (!$con) {

		echo 'not connected to server';
		mysqli_close($con);


	} else {

		if (!mysqli_select_db($con,'unify')) {
			
			echo 'Database  not selected';
			mysqli_close($con);
			
		} else {

			session_start ();

			if (isset($_GET['confirmation'])) {

				$confirmationString = $_GET['confirmation'];
				$privilege = "user";
				$status = "good";
				$query = "select * from user";
				$runQuery = mysqli_query($con,$query);
				$valid=0;

				while ($row = $runQuery->fetch_assoc()) {

					if ($row['status'] == $confirmationString && $_COOKIE['passwordRecoveryId'] == $row['status']) {					
						$valid=1;
						break;
					}
				}

				if ($valid = 1) {
					$query = "update user set privilege='$privilege',status='$status' where status='$confirmationString'";
					$runQuery = mysqli_query($con,$query);
					mysqli_close($con);
					header('Location: /unifyWeb/login.php?user=true');
				}else {
					header("Refresh: 4; url=/unifyWeb/index.php");
					echo "<h2 style='color:red;'>WARNING! you are not authorised</h2>";
					echo "you will be redirected to the home page";
					exit;
					mysqli_close($con);
				}

			}else {

				$username = $_POST['username'];
				$password = $_POST['password'];

				$query = "select * from user";
				$runQuery = mysqli_query($con,$query);
				$valid=0;
				$profileName = "";

				while ($row = $runQuery->fetch_assoc()) {

					if ((strcasecmp($row['username'],$username)==0 || strcasecmp($row['departmentemail'],$username)==0)  && $row['password'] == hash ( 'sha256', $password ) && (strcasecmp($row['privilege'],"user")==0 || strcasecmp($row['privilege'],"admin")==0)) {
						$profileName = $row['username'];				
						$valid=1;
						break;
					} else if ((strcasecmp($row['username'],$username)==0 || strcasecmp($row['departmentemail'],$username)==0) && $row['password'] == hash ( 'sha256', $password ) && strpos($row['privilege'],'verify') !== false) {
						$valid=2;
						break;
					}else if ( (strcasecmp($row['username'],$username)==0 || strcasecmp($row['departmentemail'],$username)==0) && $row['password'] == hash ( 'sha256', $password ) && ($row['privilege'] == "locked" || $row['status'] == "locked")) {
						$valid=3;
						break;
					}
				}

				if ($valid==1) {
					//$_SESSION['login'] = "active";
					setcookie('activeSession', true, time() + (21600 * 1), "/"); 
					setcookie('profileName', $profileName, time() + (21600 * 1), "/"); 
					setcookie('userId', $row['id'], time() + (21600 * 1), "/"); 
					setcookie('eventId', $row['department'], time() + (21600 * 1), "/"); 

					$department = $row['department'];

					$query = "select * from messages";
					$runQuery = mysqli_query($con,$query);
					$valid = 0;

					while ($row = $runQuery->fetch_assoc()) {
						if ($row['age'] == "new") {
							setcookie('newMessage', $row['age'], time() + (21600 * 1), "/"); 
						}
						if ($row['status'] == "newUser") {					
							$valid = 1;
						}
					}

					$query = "DELETE FROM messages WHERE status = 'newUser'" ;
					$runQuery = mysqli_query($con,$query);
					mysqli_close($con);

					if ($valid == 1 && $department == "admin") {
						setcookie('newUser', 'newUser', time() + (21600 * 1), "/");
						echo "newUserSuccess";
					}else{
						echo "success";
					}
					//deletes expired data from database
					include 'deleteExpiredData.php';
					exit;
				} else if ($valid==2) {
					echo "partiallyRegisteredErr";
				} else if ($valid==3) {
					echo "accountLocked";
				}else{
					echo "invalid";
					mysqli_close($con);
				}

			}
		}
	}
}

?>