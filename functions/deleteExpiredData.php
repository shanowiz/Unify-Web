<?php
$con = '';

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
		
		$query =  "SELECT * FROM events" ;
		$runQuery = mysqli_query($con,$query);
		
		$count = mysqli_num_rows($runQuery);
		
		$i = 0;

		while ($row = $runQuery->fetch_assoc()) {	
			$date=date_create($row['eventdate']);
			$eventDate = date_format($date,"d-m-Y");
			if (strtotime($eventDate) < strtotime(Date("d-m-Y"))) {
				$deleteQuery = "DELETE FROM events WHERE count =".$row['count'] ;
				$runDeleteQuery = mysqli_query($con,$deleteQuery);
			}
			
			$i++;
		}
		
		
		$query =  "SELECT * FROM discounts" ;
		$runQuery = mysqli_query($con,$query);
		
		while ($row = $runQuery->fetch_assoc()) {
			$date=date_create($row['date']);
			$discountDate = date_format($date,"d-m-Y");
			if (strtotime($discountDate) < strtotime(Date("d-m-Y"))) {
				
				$deleteQuery = "DELETE FROM discounts WHERE count =".$row['count'] ;
				$runDeleteQuery = mysqli_query($con,$deleteQuery);
				
			}
		}	
		mysqli_close($con);
	}	
}	
