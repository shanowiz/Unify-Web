<!DOCTYPE html>
<html ng-app="uploadData">

<head>
	<?php include 'includes/head.php';?>
</head>

<body ng-controller="changePassword" ng-if="<?php if (isset($_COOKIE['activeSession'])){ echo $_COOKIE['activeSession'];}else{header('Location: ../unifyWeb/login.php');}?>">
	<?php 
	include 'includes/header.php';
	include 'includes/navBar.php';
	?>
</br></br>
<div class="container changePasswordContainer">
	<li class='divHeading'><p>Edit Password</p></li>
</br>
<form name="passwordFrm" ng-submit="passwordMatch(<?php echo $_COOKIE['userId'];?>)">
</br></br></br>
<div class="alert alert-danger" ng-if="passwordValidityStatusInfo"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning! </strong>{{passwordValidityStatusInfo}}</div><br>
<div class="form-group">
	<center><input type="text" ng-model="oldPassword" name="oldPassword" class="form-control changePasswordInputFields {{oldPasswordValidityStatus}}" onfocus="if(this.placeholder == 'Old Password') { this.placeholder = ''; this.type = 'Password'}" placeholder="Old Password" required></center>
</div>
</br>
<div class="form-group">
	<div class="alert alert-danger" ng-show="passwordFrm.newPassword.$dirty && passwordFrm.newPassword.$error.minlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> 7 characters min<br></div>
	<div class="alert alert-danger" ng-show="passwordFrm.newPassword.$dirty && passwordFrm.newPassword.$error.pattern"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> both letters and numbers, no special characters</div>
	<div class="alert alert-danger" ng-show="newPasswordLabel">new password</div>
	<center>
		<input type="text" ng-model="newPassword" ng-minlength="7" ng-pattern="/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/" name="newPassword" class="form-control changePasswordInputFields {{newPasswordValidityStatus}}" onfocus="if(this.placeholder == 'New Password') { this.placeholder = ''; this.type = 'Password'}" placeholder="New Password" required>
	</center>
</div>
</br>
<div class="form-group">
	<div class="alert alert-danger" ng-show="passwordFrm.confirmPassword.$dirty && passwordFrm.confirmPassword.$error.match"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> Passswords dont match</div>
	<div class="alert alert-danger" ng-show="confirmPasswordLabel">confirm password</div>
	<center>
		<input type="text" name="confirmPassword" ng-model="confirmPassword" class="form-control changePasswordInputFields {{confirmPasswordValidityStatus}}" onfocus="if(this.placeholder == 'Confirm Password') { this.placeholder = ''; this.type = 'Password'}" placeholder="Confirm Password" required></center>
	</div>
</br>
<span ng-show="passwordFrm.$valid">
	<center><button type="submit" class="btn btn-lg buttons"><span class="glyphicon glyphicon-upload"></span> Submit</button></center>
</span>
<span ng-show="passwordFrm.$invalid" style="font-size:15px;">
	<center>
		<input style="background-color:lightgrey;" type="submit" name="submit" class="btn btn-lg buttons"  ng-disabled="passwordFrm.$invalid">
	</center>
</span>
<br>
<div class="alert alert-info" ng-show="showSuccessAlert">
	<strong>Done!</strong>
</div>
</br></br>
</form>
</div>
</br></br>
<?php include 'includes/footer.php';?>
</body>

</html>