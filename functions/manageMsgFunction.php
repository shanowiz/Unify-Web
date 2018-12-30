<?php
session_start ();
$marker = $_GET['marker'];
$department = "";
$userId = "";
$username = "";

$con = "";
$ip = "";
//contains connection variable to database
include 'databaseConnect.php';
include 'phpTimeoutLimit.php';

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

		if ($marker == "sendUserMsg") {

			$departmentEmail = $_POST['departmentEmail'];
			$subject = $_POST['subject'];
			$msg = $_POST['userMsg'];
			$valid = 0;

			$query = "select * from messages";
			$runQuery = mysqli_query($con,$query);

			while ($row = $runQuery->fetch_assoc()) {

				if ($departmentEmail == $row['departmentemail']) {
					$valid = 1;
					break;
				}

			}

			if ($valid == 1) {

				if (strcasecmp($department,"union")==0) {
					$department = "students union";
				}

				/*$plaintext = $msg;
				$key = hash ('sha256', $departmentEmail);
				$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
				$iv = openssl_random_pseudo_bytes($ivlen);
				$ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
				$hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
				$ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );*/


				$query = "INSERT INTO messages  (userid,username,department,departmentemail,subject,msg,status,age) VALUES ('$userId','$username','$department','$departmentEmail','$subject','$msg','sent','new')";
				$runQuery = mysqli_query($con,$query);

				$to = $departmentEmail;
				$subject = $subject;
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

				mail($to,$subject,$emailTemplate,$headers);
				echo "success";	
				mysqli_close($con);
			}else {
				echo "emailErr";
			}

		} if ($marker == "sendAdminMsg") {

			$email = $_POST['email'];
			$subject = $_POST['subject'];
			$msg= $_POST['userMsg'];
			$name= $_POST['name'];

			/*$plaintext = $msg;
			$key = hash ('sha256', $email);
			$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
			$iv = openssl_random_pseudo_bytes($ivlen);
			$ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
			$hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
			$ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );*/

			$query = "INSERT INTO messages  (userid,username,department,departmentemail,subject,msg,status,age) VALUES ('0','$name','visitor','$email','$subject','$msg','received','new')";
			$runQuery = mysqli_query($con,$query);

			if ($runQuery) {
				echo "success";
			}

		} else if ($marker == "displayInbox") {

			$query = "SELECT * FROM messages WHERE status = 'received' ORDER BY id DESC";
			$runQuery = mysqli_query($con,$query);

			$msgList = array ();

			if ($runQuery) {
				while ($row = $runQuery->fetch_assoc()) {

					/*$key = hash ('sha256', $row['departmentemail']);
					$ciphertext = $row['msg'];
					$c = base64_decode($ciphertext);
					$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
					$iv = substr($c, 0, $ivlen);
					$hmac = substr($c, $ivlen, $sha2len=32);
					$ciphertext_raw = substr($c, $ivlen+$sha2len);
					$original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);*/

					//echo $original_plaintext;
					//$row['msg'] = $original_plaintext;
					$msgList[]= $row;
				}

				$query = "UPDATE messages SET age = 'old' WHERE age = 'new'";
				$runQuery = mysqli_query($con,$query);
				mysqli_close($con);

				if (!empty($msgList)) {
					Print (json_encode($msgList));
				}else {
					echo "no messages";
				}

			}

		}else if ($marker == "displaySent") {

			$query = "SELECT * FROM messages WHERE status = 'sent' ORDER BY id DESC";
			$runQuery = mysqli_query($con,$query);

			$msgList = array ();

			if ($runQuery) {
				while ($row = $runQuery->fetch_assoc()) {
					$msgList[]= $row;
				}

				mysqli_close($con);

				if (!empty($msgList)) {
					Print (json_encode($msgList));
				}else {
					echo "no messages";
				}
			}

		}else if ($marker == "deleteMsg") {
			
			$messageId = $_POST['messageId'];

			$query = "DELETE FROM messages WHERE id =".$messageId ;
			$runQuery = mysqli_query($con,$query);

			if ($runQuery) {echo "success";}
		}






	}
}

?>