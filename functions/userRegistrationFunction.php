<?php
include 'phpTimeoutLimit.php';
session_start ();
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$idNumber = $_POST['idNumber'];
$username = $_POST['username'];
$departmentEmail = $_POST['departmentEmail'];
$password = hash ('sha256', $_POST['password']);
$department = $_POST['department'];

$con = "";
$ip = "";
//contains connection variable to database
include 'databaseConnect.php';

//contains ip variable with ip address of web server
include 'websiteIp.php';
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

		$flag = "";
		while ($row = $runQuery->fetch_assoc()) {

			if (strcasecmp($row['username'],$username)==0) {
				$flag = 1;
			} else if (strcasecmp($row['departmentemail'],$departmentEmail)==0) {
				$flag = 2;
			} else if (strcasecmp($row['department'],$department)==0) {
				$flag = 3;
			}
		}

		if ($flag == 1) {
			echo "usernameErr";
		} else if ($flag == 2) {
			echo "emailErr";
		}else if ($flag == 3) {
			echo "departmentErr";
		}else{

			$status = "verifyUser: ".bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
			$privilege = "verify";
			$query = "INSERT INTO user  (firstname,lastname,idnumber,username,departmentemail,password,department,privilege,status) VALUES ('$firstName','$lastName','$idNumber','$username','$departmentEmail','$password','$department','$privilege','$status')";
			$runQuery = mysqli_query($con,$query);

			$query = "INSERT INTO messages  (username,department,departmentemail,subject,msg,status,age) VALUES ('newUser','newUser','newUser','newUser','newUser','newUser','new')";
			$runQuery = mysqli_query($con,$query);
			
			$to = $departmentEmail;
			$subject = "email confirmation";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: <do-not-reply-UnifyUtechJa.com>' . "\r\n";
			$emailTemplate = "
				<html>
					<head>
					</head>
					<body>
						<div style=' width:100%; background-color:#1a75ff;'>
							<a href='".$ip."/unifyWeb/index.php' style=' text-decoration: none;'><h1 style='font-style: italic; color:#ffffff;'>Unify</h1></a>
						</div>
						<hr style='background-color:#000066; margin-top:-20px; height:7px; border:0;'>
						<hr style=' background-color:#ffd11a; margin-top:-8px; height:7px; border:0;'>
						<div style='background-color:#ffffff; width:100%; margin-top:-8px;'>
							<br>
							<h2 style='color:#1a75ff; text-align:center;''>Almost Complete !</h2>
							<p style='color:#666666;'>click the link to complete registration: <a href='".$ip."/unifyWeb/functions/loginFunction.php?confirmation=".$status."'> click me</a></p>
							<br><br><br><br><br>
							<p style='color:#666666;'>Do not reply to this email</p>
							<p style='color:#666666;'>For quiries <a href='".$ip."/unifyWeb/functions/submitQueries.php'> click me</a></p>
							<br>
						</div>
						<div style=' width:100%; margin-top:-15px ;background-color:#1a75ff;'>
							<br>
							<center><p style='color:#ffffff'> copyright at www.UnifyUtechJa.com</p></center>
							<br>
						</div>
					</body>
				</html>
			";
			mail($to,$subject,$emailTemplate,$headers);

			$query = "SELECT * FROM user WHERE department = 'admin'";
			$runQuery = mysqli_query($con,$query);
			$row = $runQuery->fetch_assoc();

			$to = $row['departmentemail'];
			$subject = "User Registration";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: <do-not-reply-UnifyUtechJa.com>' . "\r\n";
			$emailTemplate = "
				<html>
					<head>
					</head>
					<body>
						<div style=' width:100%; background-color:#1a75ff;'>
							<a href='".$ip."/unifyWeb/index.php' style=' text-decoration: none;'><h1 style='font-style: italic; color:#ffffff;'>Unify</h1></a>
						</div>
						<hr style='background-color:#000066; margin-top:-20px; height:7px; border:0;'>
						<hr style=' background-color:#ffd11a; margin-top:-8px; height:7px; border:0;'>
						<div style='background-color:#ffffff; width:100%; margin-top:-8px;'>
							<br>
							<h2 style='color:#1a75ff;''>Dear Administrator:</h2>
							<p style='color:#666666;'>A new user has registered please login and review their details</p>
							<br><br><br><br><br>
							<p style='color:#666666;'>Do not reply to this email</p>
							<p style='color:#666666;'>For quiries <a href='".$ip."/unifyWeb/functions/submitQueries.php'> click me</a></p>
							<br>
						</div>
						<div style=' width:100%; margin-top:-15px ;background-color:#1a75ff;'>
							<br>
							<center><p style='color:#ffffff'> copyright at www.UnifyUtechJa.com</p></center>
							<br>
						</div>
					</body>
				</html>
			";
			setcookie('newUser', true, time() + (315360000 * 1), "/"); 
			mail($to,$subject,$emailTemplate,$headers);




















			echo "success";
		}	
		mysqli_close($con);

	}
}

?>