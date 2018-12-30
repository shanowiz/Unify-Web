<?php

$id = 1;
$imageType = "";
$image = "";

if (isset($_GET['imageType'])) {
	
	$imageType=$_GET['imageType'];
}

$con = mysqli_connect('localhost','root','');
			
			if (!$con) {
	
			echo 'not connected to server';
			mysqli_close($con);
			
	
			} else {

				if (!mysqli_select_db($con,'unify')) {
			
				echo 'Database  not selected';
				mysqli_close($con);
			
			    } else {
					
				$query =  "SELECT * FROM home_images WHERE id = '$id'" ;
				$runQuery = mysqli_query($con,$query);
					
				$row = $runQuery->fetch_assoc();
				
				if ($imageType == "firstImage") {
					$image=$row['firstimage'];

				}else if ($imageType == "secondImage") {
					$image=$row['secondimage'];

				}else if ($imageType == "thirdImage") {
					$image=$row['thirdimage'];
				}
				
				//$image=$row['image'];
					
				header ("Content-type: image/jpeg");
				
				echo $image;	
				}
			}	
?>