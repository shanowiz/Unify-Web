<?php

$id='';

if (isset($_GET['id'])) {
	
	$id=$_GET['id'];
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
					
				$query =  "SELECT * FROM discounts WHERE id='$id' OR name='$id'" ;
				$runQuery = mysqli_query($con,$query);
					
				$row = $runQuery->fetch_assoc();
				
				$image=$row['image'];
					
				header ("Content-type: image/jpeg");
				
				echo $image;
					
					
					
					
					
				}
				
				
				
			}
			
		
					
?>