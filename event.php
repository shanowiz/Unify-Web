<!DOCTYPE html>
<html ng-app="getData">

<head>
    <?php include 'includes/head.php';?>
</head>
<body ng-controller="manageData" ng-init="displaySingleEvent('<?php echo $_GET['id'];?>')"  ng-if="<?php if (isset($_COOKIE['activeSession'])){ echo $_COOKIE['activeSession'];}else{header('Location: ../unifyWeb/login.php');}?>">
	<div ng-include="'../unifyWeb/includes/loadingModal.html'"></div>
	<div ng-include="'../unifyWeb/includes/successModal.html'"></div>
    <?php 
		include 'includes/header.php';
		include 'includes/navBar.php';
	?>
	<div class="singleEventContainer">
	<br>
	<a href="{{image}}"><img src="{{image}}" class="img"></a>
	<br><br>
	<div style="padding-left: 10px; width:100%;word-wrap: break-word; ">
		<a class="btn smallButtons" href="editEvent.php?id={{id}}"><span class="glyphicon glyphicon-edit"></span> Edit</a>
		<a class="btn smallButtons" href="" ng-click = "deleteEvent(id)"><span class="glyphicon glyphicon-trash"></span> Delete</a>
		<br><br>
		<p><strong>Event:</strong><br>{{event}}</p>
		<hr>
		<p><strong>Date:</strong><br>{{date}}</p>
		<hr>
		<p><strong>Venue:</strong><br>{{venue}}</p>
		<hr>
		<p><strong>Info:</strong><br>{{details}}</p>
		<hr>
		<p><strong>Cost:</strong><br>{{cost}}</p>
		<hr>
		<p><strong>Time:</strong><br>{{time}}</p>
		<hr>
	</div>
	</div>
	</br>
    <?php include 'includes/footer.php';?>
   
</body>

</html>