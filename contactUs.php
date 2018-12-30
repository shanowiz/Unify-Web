<!DOCTYPE html>
<html ng-app="uploadData">

<head>
	<?php include 'includes/head.php';?>
</head>

<body ng-controller="contactUs" ng-init="showMsgList=true;showCompose=false">
	<div ng-include="'../unifyWeb/includes/loadingModal.html'"></div>
	<?php 
	include 'includes/header.php';
	include 'includes/navBar.php';
	?>
	
	<div class="row">
		<div class="col-md-5">
			<img class="center-block" src="../unifyWeb/assets/img/contact3.png">
		</div>
		<div class="col-md-7">
			<form class="sendUserMsgFrm" name="sendUserMsgFrm"  ng-submit="sendAdminMsg()">
				<div class="form-group">
					<div class="alert alert-danger" ng-show="sendUserMsgFrm.name.$dirty && sendUserMsgFrm.name.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max characters</div>
					<input type="text" name="name" class="form-control singleLineInputField" placeholder="Name" ng-model="name" ng-maxlength="50" ng-minlength="1" required>
				</div>	
				<div class="form-group">
					<div class="alert alert-danger" ng-show="sendUserMsgFrm.email.$dirty && sendUserMsgFrm.email.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max characters</div>
					<div class="alert alert-danger" ng-show="sendUserMsgFrm.$invalid && sendUserMsgFrm.email.$error.pattern"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> invalid email</div>
					<input type="email" name="email" class="form-control singleLineInputField" placeholder="Email" ng-model="email" ng-maxlength="50" ng-minlength="1"  ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" required>
				</div>
				<div class="form-group">
					<div class="alert alert-danger" ng-show="sendUserMsgFrm.subject.$dirty && sendUserMsgFrm.subject.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max characters</div>
					<input type="text" name="subject" class="form-control singleLineInputField" placeholder="Subject" ng-model="subject" ng-maxlength="50" ng-minlength="1" required>
				</div>		
				<div class="form-group">
					<div class="alert alert-danger" ng-show="sendUserMsgFrm.userMsg.$dirty && sendUserMsgFrm.userMsg.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max characters</div>
					<textarea style="height:120px;box-shadow: none;border:0;" class="form-control inputFields" placeholder="Write something..." ng-model="userMsg" ng-maxlength="500" required></textarea>
				</div>		
				<center>
					<button ng-show="sendUserMsgFrm.$valid" type="submit" class="buttons"><span class="glyphicon glyphicon-send"></span> Send</button>
					<button ng-show="sendUserMsgFrm.$invalid" style="background-color:lightgrey;" type="submit" ng-disabled="true" class="buttons"><span class="glyphicon glyphicon-send"></span> Send</button>
				</center>
				<br>	
				<div ng-show="showSuccessAlert" class="alert alert-success"><strong>Done!</strong></div>
			</form>

		</div>
	</div>
	
	<br><br></br>

	

	<?php include 'includes/footer.php';?>
</body>

</html>