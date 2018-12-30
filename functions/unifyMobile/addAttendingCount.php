<?php

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
					
					$deleteQuery1 = "DELETE FROM events WHERE id = 27" ;
					$runDeleteQuery1 = mysqli_query($con,$deleteQuery1);
					
						if (isset($_GET['type'])) {
							
							if ($_GET['type']=="events") {
								
							
								$id=0;
								$type="";
								$attending = 0;
								
								if (isset($_GET['userId'])){
									$id = $_GET['userId'];
								}
								if (isset($_GET['type'])){
									$type = $_GET['type'];				
								}
								
								$query =  "SELECT * FROM events WHERE id =".$id; 
								$runQuery = mysqli_query($con,$query);
								$row = $runQuery->fetch_assoc()
								
								if ($_GET['command']=="add") {
									$attending = $row['attending']+1;
								} else if ($_GET['command']=="remove") {
									$attending = $row['attending']-1;
								}
								
								$updatQeuery = "update events set attending='$attending' where id=".$id;
								$runUpdateQuery = mysqli_query($con,$updateQuery);
								mysqli_close($con);
								
							} 
							
							
							
							
							
							
							
							
						}
							
							
					
					
			}
			
			}
			
?>