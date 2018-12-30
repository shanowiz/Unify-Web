<?php
session_start ();
$eventName = $_POST['eventName'];
$venue = $_POST['eventVenue'];
$details = $_POST['eventDetails'];
$cost = $_POST['eventCost'];
$startTime = date("g:i a", strtotime($_POST['startTime']));
$noImageUrl = "../unifyWeb/assets/img/noImage.png";
$endTime = date("g:i a", strtotime($_POST['endTime']));
$uploadDate = date("Y-m-d");
$eventDate = $_POST['eventDate'];
$userId='';
$valid=0;
$eventId='';
$uploader='';
$type="event";
$eventImageUrl = "";
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

	$eventId= $_COOKIE['eventId'];

} 

$con = "";
//contains connection variable to database
include 'databaseConnect.php';
//contains img url
include 'unifyMobile/websiteIpAddress.php';

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


		$displayQuery = "select * from events";
		$runQuery = mysqli_query($con,$displayQuery);

		$count = mysqli_num_rows($runQuery);

		$i = 0;
		$flag = "";

		while ($i<$count) {

			$row = $runQuery->fetch_assoc();

			if (($row['eventdate'] == $eventDate and $row['venue'] == $venue) and (($row['starttime'] == $startTime) || ($startTime > $row['starttime'] and $startTime < $row['endtime']) || ($endTime > $startTime))  ) {

				$flag = "roomBooked";
				break;
			} else if ($row['name'] == $eventName) {

				$flag = "eventNameDuplicate";
				break;

			}

			$i++;	
		}

		if ($flag=="roomBooked") {

			echo "eventCollisionErr";

		} else if ($flag=="eventNameDuplicate") {

			echo "eventNameErr";

		} else {

			$title= $eventId;
			$message = $eventName;
			$path_to_fcm = 'https://fcm.googleapis.com/fcm/send';
												//$server_key = "AIzaSyAjwJxmfs_Pmb3LiYBJrxF1oE-llPtJMjs";

			function send_notification ($title, $message, $key, $eventName, $venue, $details, $startTime, $endTime, $cost, $eventDate) {

												//includes variables such as image url (ip address)
				include 'unifyMobile/websiteIpAddress.php';

				if (isset ($_FILES['eventImg']['tmp_name'])){
					$imageUrl = $eventImageUrl.$eventName;
				}else{
					$imageUrl = "";
				}
				$time = $startTime." - ".$endTime;

				$path_to_fcm = 'https://fcm.googleapis.com/fcm/send';

				$headers = array (
					'Authorization:key = AAAAPaxCSA0:APA91bE1HSEI8IEoEPMh44QgDZK621RsN9BHX_PQsYFgRTxg3a6XhWjPhtn4oahuEyp3nzf9BykWfOFgbkECbYiUSPI98_9yvFzy0RMQaxPOOEGQf6FvYGSxV_2mo6cOwBJpT3X9X44m',
					'Content-Type:application/json'
				);

				$fields = array (
					'to'=>$key,
					'data'=>array ( 'title'=>$title, 
						'line1'=>$message, 
						'line2'=>'event',
						'line3'=>$venue,
						'line4'=>$details,
						'line5'=>$time,
						'line6'=>$cost,
						'line7'=>$eventDate,
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

			if (isset($_FILES['eventImg']['tmp_name'])) {   

				$image = addslashes (file_get_contents($_FILES['eventImg']['tmp_name']));
				$imageSize = getimagesize ($_FILES['eventImg']['tmp_name']);
				if ($imageSize==false) {

					echo "imageErr";

				} else {

					$query = "INSERT INTO events  (id,userid,name,venue,details,cost,starttime,endtime,image,department,eventdate,uploaddate,uploader,type) VALUES ('$id','$userId','$eventName','$venue','$details','$cost','$startTime','$endTime','$image','$eventId','$eventDate','$uploadDate','$uploader','$type')";
					echo "success";
				}
			} else {

				$query = "INSERT INTO events  (id,userid,name,venue,details,cost,starttime,endtime,department,eventdate,uploaddate,uploader,type) VALUES ('$id','$userId','$eventName','$venue','$details','$cost','$startTime','$endTime','$eventId','$eventDate','$uploadDate','$uploader','$type')";
				echo "success";

			}
			$runQuery = mysqli_query($con,$query);

			$key = "";

			while ($row = $runQuery1->fetch_assoc()) {

				$key = $row['fcm_token'];
				$message_status = send_notification ($title, $message, $key, $eventName, $venue, $details, $startTime, $endTime, $cost, $eventDate);

			}

			mysqli_close($con);
			exit;

		}	

	}
}

?>