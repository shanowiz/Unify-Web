<?php
include 'phpTimeoutLimit.php';

$con = '';
$id = '';

//makes connection to database/ contains con variable 
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
				
				if (isset($_GET['type'])) {
					
					$type = $_GET['type'];
					$eventsList = array ();
					
					if ($type=="event") {
					
						$query =  "SELECT * FROM events" ;
						
						$runQuery = mysqli_query($con,$query);
						
						if ($runQuery) {
						while ($row = $runQuery->fetch_assoc()) {
							
							$row['image']="";
							$row['image']="functions/displayImage.php?id=".$row['id'];
							$eventsList[]= $row;		
					}
						mysqli_close($con);
						Print (json_encode($eventsList));
				}
				
				} else if ($type=="discount") {
					
					$query =  "SELECT * FROM discounts" ;
				
					$runQuery = mysqli_query($con,$query);
					
					if ($runQuery) {
					while ($row = $runQuery->fetch_assoc()) {
						
						$row['image']="";
						$row['image']="includes/displayDiscountsImage.php?id=".$row['id'];
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