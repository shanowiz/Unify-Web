<!DOCTYPE html>
<html ng-app="uploadData">

<head>
	<div ng-include="'../unifyWeb/includes/loadingModal.html'"></div>
	<?php 
	session_start();
	include 'includes/head.php';?>
</head>
<body ng-controller="resetPassword" ng-init="access=<?php if (isset($_SESSION['passwordResetAccess'])){echo $_SESSION['passwordResetAccess'];}else{echo "false";}?>">

	<div ng-show="access">
	<div ng-include="'../unifyWeb/includes/loadingModal.html'"></div>
	<?php 
	include 'includes/header.php';
	include 'includes/navBar.php';
	?>
</br>
<div class="container resetPasswordContainer">
	<li class='divHeading'><p>Reset</p></li>
	<form  ng-submit="validateData('<?php if (isset($_GET['id'])){echo $_GET['id'];}?>','<?php if (isset($_GET['confirmation'])){echo $_GET['confirmation'];}?>')" name="resetPasswordFrm">
	</br></br></br></br>
	<div class="form-group">
		<label for="newPassword" class="formHeading">New password:</label>
		<div class="alert alert-danger" ng-show="passwordValidityStatusInfo && resetPasswordFrm.$invalid"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> {{passwordValidityStatusInfo}}<br></div>
		<div class="alert alert-danger" ng-show="resetPasswordFrm.newPassword.$dirty && resetPasswordFrm.newPassword.$error.minlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> 7 characters min<br></div>
		<div class="alert alert-danger" ng-show="resetPasswordFrm.newPassword.$dirty && resetPasswordFrm.newPassword.$error.pattern"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> both letters and numbers, no special characters</div>
		<input type="password" placeholder="Password" ng-model="newPassword" name="newPassword" class="form-control inputFields {{passwordValidityStatus}}" ng-minlength="7" ng-pattern="/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/" required>
		</div>
</br>
<div class="form-group">
	<label for="newPassword" class="formHeading">Confirm password:</label>
	<input style="margin: 0 auto;" type="password" name="confirmPassword" class="form-control inputFields {{passwordValidityStatus}}" ng-model="confirmPassword" placeholder="Confirm Password" required>
</div>
</br>
<span ng-show="resetPasswordFrm.$valid"><center><button type="submit" class="btn btn-lg buttons" ><span class="glyphicon glyphicon-send"></span> Go</button></center></span>
<span ng-show="resetPasswordFrm.$invalid"><center><button style="background-color:lightgrey;" ng-disabled="true" type="submit" class="btn btn-lg buttons" ><span class="glyphicon glyphicon-send"></span> Go</button></center></span>
</br>
</form>
<br>
<div class="alert alert-success" ng-show="showSuccessAlert"><strong>Done!</strong></div>
</div>

</br>
<?php include 'includes/footer.php';?>

<script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>

<script>
	window.sr = ScrollReveal();
	sr.reveal('.loginContainer', {duration: 1500, origin:'right', distance:'400px'});
</script>
</div>
<div ng-show="!access">
	<?php include '../unifyWeb/login.php'; ?>
</div>
</body>

</html>