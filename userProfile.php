<!DOCTYPE html>
<html ng-app="uploadData">

<head>
	<?php include 'includes/head.php';?>
</head>

<body ng-if="<?php if (isset($_COOKIE['activeSession'])){ echo $_COOKIE['activeSession'];}else{header('Location: ../unifyWeb/login.php');}?>">
	<?php 
	include 'includes/header.php';
	include 'includes/navBar.php';
	?>
</br></br>
<div class="container userProfileContainer">
	<li class='divHeading'><p>Profile</p></li>
	<div class="row">
		<br><br>
		<div class="col-md-6">
			<img src="../unifyWeb/assets/img/profile.png" width="250" height="250">
			<br>
			<button style="margin-left:40px;" class="smallButtons" data-toggle="modal" data-target="#changePasswordModal">Change Password</button>
			<br><br>
		</div>
		<div class="col-md-6">
			<p><strong>Username:</strong> <?php echo $_COOKIE['profileName']?></p>
			<p><strong>Password:</strong> **************</p>
		</div>

	</div>
</div>
<div id="changePasswordModal" class="modal fade" my-modal role="dialog" ng-controller="changePassword">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Change Password</h4>
			</div>
			<div class="modal-body" style="">
				<form name="passwordFrm" ng-submit="passwordMatch(<?php echo $_COOKIE['userId'];?>)">
					<label for="oldpassword" class="formHeading">Old Password:</label>
				<div class="alert alert-danger" ng-if="passwordValidityStatusInfo"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning! </strong>{{passwordValidityStatusInfo}}</div><br>
				<div class="form-group">
					<center><input type="text" ng-model="oldPassword" name="oldPassword" class="form-control changePasswordInputFields {{oldPasswordValidityStatus}}" onfocus="if(this.placeholder == 'Old Password') { this.placeholder = ''; this.type = 'Password'}" placeholder="Old Password" required></center>
				</div>
			</br>
			<div class="form-group">
				<label for="newpassword" class="formHeading">New Password:</label>
				<div class="alert alert-danger" ng-show="passwordFrm.newPassword.$dirty && passwordFrm.newPassword.$error.minlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> 7 characters min<br></div>
				<div class="alert alert-danger" ng-show="passwordFrm.newPassword.$dirty && passwordFrm.newPassword.$error.pattern"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> both letters and numbers, no special characters</div>
				<center>
					<input type="text" ng-model="newPassword" ng-minlength="7" ng-pattern="/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/" name="newPassword" class="form-control changePasswordInputFields {{newPasswordValidityStatus}}" onfocus="if(this.placeholder == 'New Password') { this.placeholder = ''; this.type = 'Password'}" placeholder="New Password" required>
				</center>
			</div>
		</br>
		<div class="form-group">
			<label for="confirmpassword" class="formHeading">Confirm Password:</label>
			<div class="alert alert-danger" ng-show="passwordFrm.confirmPassword.$dirty && passwordFrm.confirmPassword.$error.match"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> Passswords dont match</div>
			<center>
				<input type="text" name="confirmPassword" ng-model="confirmPassword" class="form-control changePasswordInputFields {{confirmPasswordValidityStatus}}" onfocus="if(this.placeholder == 'Confirm Password') { this.placeholder = ''; this.type = 'Password'}" placeholder="Confirm Password" required></center>
			</div>
		</br>
		<span ng-show="passwordFrm.$valid">
			<center><button type="submit" class="btn btn-lg buttons"><span class="glyphicon glyphicon-floppy-saved"></span> Save</button></center>
		</span>
		<span ng-show="passwordFrm.$invalid" style="font-size:15px;">
			<center>
				<button style="background-color:lightgrey;" type="button" class="btn btn-lg buttons" ng-disabled="true"><span class="glyphicon glyphicon-floppy-saved"></span> Save</button>
			</center>
		</span>
		<br>
		<div class="alert alert-info" ng-show="showSuccessAlert">
			<strong>Done!</strong>
		</div>
</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>

</div>
</div>
</br></br>
<?php include 'includes/footer.php';?>

</html>