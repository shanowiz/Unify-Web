<?php
session_start ();
$discountName = $_POST['discountName'];
$venue = $_POST['discountVenue'];
$details = $_POST['discountDetails'];
//$image = $_FILES['discountImg']['tmp_name'];
$uploadDate = date("Y-m-d");
$discountDate = $_POST['discountDate'];
$userId='';
$valid=0;
$discountId='';
$uploader='';
$type="discount";
$discountImageUrl = "";
$userid = 0;

include 'phpTimeoutLimit.php';

//trim ($latitude,$longitude);

if (isset ($_COOKIE['userId'])) {
	
	$userId= $_COOKIE['userId'];
}

if (isset ($_COOKIE['profileName'])) {

	$uploader= $_COOKIE['profileName'];

}

if (isset ($_COOKIE['eventId'])) {

	$discountId= $_COOKIE['eventId'];

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

		$title= $discountId;
		$message = $discountName;
		$path_to_fcm = 'https://fcm.googleapis.com/fcm/send';
												//$server_key = "AIzaSyAjwJxmfs_Pmb3LiYBJrxF1oE-llPtJMjs";

		function send_notification ($title, $message, $key, $discountName, $venue, $details, $discountDate) {

												//includes variables such as image url (ip address)
			include 'unifyMobile/websiteIpAddress.php';

			$imageUrl = $discountImageUrl.$discountName;

			$path_to_fcm = 'https://fcm.googleapis.com/fcm/send';

			$headers = array (
				'Authorization:key = AAAAPaxCSA0:APA91bE1HSEI8IEoEPMh44QgDZK621RsN9BHX_PQsYFgRTxg3a6XhWjPhtn4oahuEyp3nzf9BykWfOFgbkECbYiUSPI98_9yvFzy0RMQaxPOOEGQf6FvYGSxV_2mo6cOwBJpT3X9X44m',
				'Content-Type:application/json'
			);

			$fields = array (
				'to'=>$key,
				'data'=>array ( 'title'=>$title, 
					'line1'=>$message, 
					'line2'=>'discount',
					'line3'=>$venue,
					'line4'=>$details,
					'line7'=>$discountDate,
					'line8'=>$imageUrl
				)
			);	


			$payload = json_encode($fields);

												//echo $payload;

			$curl_session = curl_init();
			curl_setopt($curl_session, CURLOPT_URL, $path_to_fcm);
			curl_setopt($curl_session, CURLOPT_POST, true);
			curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl_session, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
												//curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
			curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);

			$result = curl_exec($curl_session);
			if ($result == false) {
				die('Curl failed:'.curl_error($curl_session));
			}
			curl_close($curl_session);
			return $result;

		}

		$id = bin2hex(mcrypt_create_iv(14, MCRYPT_DEV_URANDOM));
		$query1 =  "SELECT * FROM fcm_info" ;
		$runQuery1 = mysqli_query($con,$query1);

		if (isset($_FILES['discountImg']['tmp_name'])) {

			$image = addslashes (file_get_contents($_FILES['discountImg']['tmp_name']));
			$imageSize = getimagesize ($_FILES['discountImg']['tmp_name']);

			if ($imageSize==false) {

				echo "imageErr";

			} else {

				$query = "INSERT INTO discounts  (id,userid,name,details,date,venue,image,department,uploaddate,uploader,type) VALUES ('$id','$userId','$discountName','$details','$discountDate','$venue','$image','$discountId','$uploadDate','$uploader','$type')";
			}
		} else {

			$query = "INSERT INTO discounts  (id,userid,name,details,date,venue,department,uploaddate,uploader,type) VALUES ('$id','$userId','$discountName','$details','$discountDate','$venue','$discountId','$uploadDate','$uploader','$type')";
		}
		$runQuery = mysqli_query($con,$query);

		$key = "";

		while ($row = $runQuery1->fetch_assoc()) {

			$key = $row['fcm_token'];
			$message_status = send_notification ($title, $message, $key, $discountName, $venue, $details, $startTime, $endTime, $cost, $discountDate);

		}

		mysqli_close($con);

		echo "success";
		exit;



	}
}

?>