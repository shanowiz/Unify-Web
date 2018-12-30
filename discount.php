<!DOCTYPE html>
<html ng-app="getData">

<head>
    <?php include 'includes/head.php';?>
</head>
<body ng-controller="manageData" ng-init="displaySingleDiscount('<?php echo $_GET['id'];?>')" ng-if="<?php if (isset($_COOKIE['activeSession'])){ echo $_COOKIE['activeSession'];}else{header('Location: ../unifyWeb/login.php');}?>">
	<div ng-include="'../unifyWeb/includes/loadingModal.html'"></div>
	<div ng-include="'../unifyWeb/includes/successModal.html'"></div>
    <?php 
		include 'includes/header.php';
		include 'includes/navBar.php';
	?>
	<div class="singleEventContainer">
	<br>
	<a href="{{image}}"><img src="{{image}}"></a>
	<br><br>
	<div style="padding-left: 10px; width:100%;word-wrap: break-word; ">
		<a class="smallButtons" href="editDiscount.php?id={{id}}"><span class="glyphicon glyphicon-edit"></span> Edit</a>
		<a class="smallButtons" href="" ng-click = "deleteDiscount(id)"><span class="glyphicon glyphicon-trash"></span> Delete</a>
		<br><br>
		<p><strong>Discount:</strong><br>{{discount}}</p>
		<hr>
		<p><strong>Date:</strong><br>{{date}}</p>
		<hr>
		<p><strong>Venue:</strong><br>{{venue}}</p>
		<hr>
		<p><strong>Info:</strong><br>{{details}}</p>
		<hr>
	</div>
	</div>
	</br>
    <?php include 'includes/footer.php';?>
</body>

</html>