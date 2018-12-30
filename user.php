<!DOCTYPE html>
<html ng-app="getData">

<head>
    <?php include 'includes/head.php';?>
</head>
<body ng-controller="manageUsers" ng-init="displaySingleUser(<?php echo $_GET['id'];?>)"  ng-if="<?php if (isset($_COOKIE['activeSession'])){ echo $_COOKIE['activeSession'];}else{header('Location: ../unifyWeb/login.php');}?>; <?php if($_COOKIE['eventId']=='admin'){ echo $_COOKIE['eventId'];}else{header('Location: ../unifyWeb/index.php');}?>='admin'">
	<div ng-include="'../unifyWeb/includes/loadingModal.html'"></div>
	<div ng-include="'../unifyWeb/includes/successModal.html'"></div>
    <?php 
		include 'includes/header.php';
		include 'includes/navBar.php';
	?>
	<div class="userDetailsContainer">
	<br>
	<img style="margin: 0 auto;" class="img-responsive" src="../unifyWeb/assets/img/user1.png">
	<br><br>
	<div style="padding-left: 10px; width:100%; word-wrap: break-word; ">
		<a class="btn smallButtons" href="" ng-click = "deleteUser(id)"><span class="glyphicon glyphicon-trash"></span> Delete</a>
		<a class="btn smallButtons" href="" data-toggle="modal" data-target="#sendUserMsgModal"><span class="glyphicon glyphicon-envelope"></span> Message</a>
		<a class="btn smallButtons" href="" ng-click="manageAccount()"><span class="glyphicon glyphicon-lock"></span> {{action}}</a>
		<br><br>
		<p><strong>Username:</strong><br>{{username}}</p>
		<hr>
		<p><strong>First Name:</strong><br>{{firstName}}</p>
		<hr>
		<p><strong>Last Name:</strong><br>{{lastName}}</p>
		<hr>
		<p><strong>Department:</strong><br>{{department}}</p>
		<hr>
		<p><strong>Email:</strong><br>{{departmentEmail}}</p>
		<hr>
		<p align="center"><strong>STATUS:</strong> {{status}}</p>
		<br>
	</div>
	</div>

	<div id="sendUserMsgModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Send Message</h4>
			</div>
			<div class="modal-body">
				<form name="sendUserMsgFrm"  ng-submit="sendUserMsg(departmentEmail)">
					<div class="form-group">
						<div class="alert alert-danger" ng-show="sendUserMsgFrm.subject.$dirty && sendUserMsgFrm.subject.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max characters</div>
						<input type="text" class="form-control singleLineInputField" placeholder="Subject" ng-model="subject" ng-maxlength="100" required>
					</div>
					<div class="form-group">
					<div class="alert alert-danger" ng-show="sendUserMsgFrm.userMsg.$dirty && sendUserMsgFrm.userMsg.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max characters</div>
					<textarea style="height:200px;box-shadow: none;border:0;" class="form-control inputFields" placeholder="Write something..." ng-model="userMsg" ng-maxlength="500" required></textarea>
				</div><br>
				<center>
					<button ng-if="sendUserMsgFrm.$valid" type="submit" class="buttons"><span class="glyphicon glyphicon-send"></span> Send</button>
					<button ng-if="sendUserMsgFrm.$invalid" style="background-color:lightgrey;" type="submit" ng-disabled="true" class="buttons"><span class="glyphicon glyphicon-send"></span> Send</button>
				</center>
				<br>
				<div ng-if="loadingWheel" class="loader">loading...</div>
				<div ng-if="showSuccessAlert" class="alert alert-success"><strong>Done!</strong></div>
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	</div>

</div>
</div>
	</br>
    <?php include 'includes/footer.php';?>
</body>

</html>