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
$ip = "";
//contains con variable which establishes connection to database
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

		if (isset ($_GET['id']) && isset ($_GET['marker'])) {

			$id=$_GET['id'];
			$marker = $_GET['marker'];
			if ($marker=="deleteUser") {
				$deleteQuery1 = "DELETE FROM user WHERE id =".$id ;
				$runDeleteQuery1 = mysqli_query($con,$deleteQuery1);
				echo "deleted successfully";
			}else{
				echo "Database Error";
			}

		} else if (isset ($_GET['marker']))	{

			$marker = $_GET['marker'];

			if ($marker=="display") {

				$query = "";
				$userList = array ();
				if (isset($uploader)) {
					if (strcasecmp($uploader,"admin")==0) {
						$query =  "SELECT * FROM user ORDER BY id DESC" ;
					}
					$runQuery = mysqli_query($con,$query);
				}

				if ($runQuery) {
					while ($row = $runQuery->fetch_assoc()) {
						if (strcasecmp($row['department'],"admin")!=0) {
							$userList[]= $row;	
						}	
					}
					mysqli_close($con);
					if (!empty($userList)) {
						Print (json_encode($userList));
					}else {
						echo "no users";
					}
				}

			}else if ($marker == "lockAccount") {

				$id = $_POST['id'];
				$to = $_POST['departmentEmail'];
				$department = $_POST['department'];
				$subject = "Account Suspended";
				$msg = "Your account has been temporarily susupended. Please contact the administrator";
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
				<h3 style='color:#1a75ff'>Dear ".$department.":</h3>
				<p style='color:#666666; word-wrap: break-word;'>".$msg."</p>
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

				$deleteQuery1 = "UPDATE user SET status ='locked', privilege = 'locked' WHERE id = '$id'" ;
				$runDeleteQuery1 = mysqli_query($con,$deleteQuery1);

				mail($to,$subject,$emailTemplate,$headers);
				echo "success";	

			mysqli_close($con);

			}if ($marker == "unlockAccount") {

				$id = $_POST['id'];
				$to = $_POST['departmentEmail'];
				$department = $_POST['department'];
				$subject = "Account Unlocked";
				$msg = "Your account has been granted access. Please login with required credentials";
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
				<h3 style='color:#1a75ff'>Dear ".$department.":</h3>
				<p style='color:#666666; word-wrap: break-word;'>".$msg."</p>
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

				$deleteQuery1 = "UPDATE user SET status ='good', privilege = 'user' WHERE id = '$id'" ;
				$runDeleteQuery1 = mysqli_query($con,$deleteQuery1);

				mail($to,$subject,$emailTemplate,$headers);
				echo "success";	

			mysqli_close($con);

			}
		} 

	}

}

?>