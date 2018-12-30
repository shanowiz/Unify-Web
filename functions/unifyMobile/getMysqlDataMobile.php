<?php

$eventImageUrl = "";
$discountImageUrl = "";
//includes variables such as image url (ip address)
include 'websiteIpAddress.php';

$id = '';


$con = mysqli_connect('localhost','root','');
			
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
				
				if (isset($_GET['type'])) {
					
					$type = $_GET['type'];
					$eventsList = array ();
					
					if ($type=="eventfdsdl8s77f6sd66sf66sfs7fs6fs87f") {
					
						$query =  "SELECT * FROM events  ORDER BY count DESC" ;
						
						$runQuery = mysqli_query($con,$query);
						//$count = mysqli_num_rows($runQuery);
						
						if ($runQuery) {
						while ($row = $runQuery->fetch_assoc()) {
							if (!empty($row['image'])){
							$row['image']="";
							$row['image']=$eventImageUrl.$row['id'];
						}
							$eventsList[]= $row;		
					}
						mysqli_close($con);
						Print (json_encode($eventsList));
				}
				
				} else if ($type=="discountsdfsdf687sd7s77s67sd78f8sf") {
					
					$query =  "SELECT * FROM discounts  ORDER BY count DESC" ;
				
					$runQuery = mysqli_query($con,$query);
					
					if ($runQuery) {
					while ($row = $runQuery->fetch_assoc()) {
						if (!empty($row['image'])){
						$row['image']="";
						$row['image']=$discountImageUrl.$row['id'];
					}
						$eventsList[]= $row;
					
				}		
					mysqli_close($con);
					Print (json_encode($eventsList));
					}
				}
				
				}
				
				
				
				
				
				
				
				}
			}
			
?>