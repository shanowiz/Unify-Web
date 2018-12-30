<?php

$con = '';
$id = '';

//makes connection to database/ contains con variable 
//include 'databaseConnect.php';
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
					
					$eventsList = array ();
					
					
						$query =  "SELECT * FROM events" ;
						
						$runQuery = mysqli_query($con,$query);
						
						if ($runQuery) {
						while ($row = $runQuery->fetch_assoc()) {
							
							$row['image']="";
							$row['image']="includes/displayImage.php?id=".$row['id'];
							$eventsList[]= $row;		
					}
						mysqli_close($con);
						Print (json_encode($eventsList));
				}
				
				
				
				
				
				
				
				
				
				}
			}
			
?>