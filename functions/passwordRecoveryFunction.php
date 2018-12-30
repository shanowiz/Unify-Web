<?php
include 'phpTimeoutLimit.php';

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

		if (isset($_GET['confirmation'])) {

			$confirmation = $_GET['confirmation'];

			$query = "select * from user";
			$runQuery = mysqli_query($con,$query);

			$flag = 0;
			$id = 0;
			while ($row = $runQuery->fetch_assoc()) {

				if ($row['status'] == $confirmation){
					$flag = 1;
					$id = $row['id'];
				}
			}

			if ($flag == 1) {
				session_start ();
				$_SESSION['passwordResetAccess'] = true;
				header('Location: /unifyWeb/resetPassword.php?id='.$id.'&confirmation='.$confirmation);
			} else{	
				header("Refresh: 4; url=/unifyWeb/index.php");
				echo "<h2 style='color:red;'>WARNING! you are not authorised</h2>";
				echo "you will be redirected to the home page";
				exit;
			}	
			mysqli_close($con);

		} if (isset($_GET['action'])) {
			$action = $_GET['action'];

			if ($action == "upload") {
				$userId = $_POST['userId'];
				$confirmation = $_POST['confirmation'];
				$status = "good";
				$newPassword = hash ('sha256', $_POST['newPassword']);
				$query =  "SELECT * FROM user WHERE id='$userId'" ;
				$runQuery = mysqli_query($con,$query);
				$row = $runQuery->fetch_assoc(); 

				if ($row['password'] == $newPassword) { 
					echo "oldPasswordErr";
				}else if ($row['status'] == $confirmation) {
					$query = "update user set password='$newPassword',status='$status' where id='$userId'";
					$runQuery = mysqli_query($con,$query);
					echo "uploadSuccess";
					mysqli_close($con);
				}else {
					header("Refresh: 4; url=/unifyWeb/index.php");
					echo "<h2 style='color:red;'>WARNING! you are not authorised</h2>";
					echo "you will be redirected to the home page";
					exit;
					mysqli_close($con);
				}		
			}else if ($action == "sendLink") {
				$email = $_POST['email'];
				$query =  "SELECT * FROM user WHERE departmentemail='$email'" ;
				$runQuery = mysqli_query($con,$query);
				$row = $runQuery->fetch_assoc();

				if ($runQuery && $row['departmentemail'] == $email) {


					$status = "resetPassword: ".bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
					$query = "update user set status='$status' where departmentemail='$email'";
					$runQuery = mysqli_query($con,$query);
					setcookie('passwordRecoveryId', $status, time() + (7200 * 1), "/"); 
					$to = $email;
					$subject = "password reset";
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
					<h2 style='color:#1a75ff; text-align:center'>Almost Complete !</h2>
					<p style='color:#666666;'>click the link to reset your password: <a href='".$ip."/unifyWeb/functions/passwordRecoveryFunction.php?confirmation=".$status."'> click me</a></p>
					<br><br><br><br><br>
					<p style='color:#666666;'>Do not reply to this email</p>
					<p style='color:#666666;'>For quiries <a href='".$ip."/unifyWeb/functions/submitQueries.php'> click me</a></p>
					<br>
					</div>
					<div style=' width:100%; background-color:#1a75ff;'>
					<br>
					<center><p style='color:#ffffff; word-wrap: break-word;'>copyright at www.UnifyUtechJa.com</p></center>
					<br>
					</div>
					</body>
					</html>
					";

					mail($to,$subject,$emailTemplate,$headers);
					echo "linkSent";
				}else {
					echo "userEmailErr";
				}
			}else {
				header("Refresh: 4; url=/unifyWeb/index.php");
				echo "<h2 style='color:red;'>WARNING! you are not authorised</h2>";
				echo "you will be redirected to the home page";
				exit;
				mysqli_close($con);
			}
		}else {
			header("Refresh: 4; url=/unifyWeb/index.php");
			echo "<h2 style='color:red;'>WARNING! you are not authorised</h2>";
			echo "you will be redirected to the home page";
			exit;
			mysqli_close($con);
		}

	}
}

?>