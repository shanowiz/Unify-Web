<!DOCTYPE html>
<html ng-app="getData">

<head>
	<?php include 'includes/head.php';?>
</head>

<body ng-controller="login" ng-show="<?php if (isset($_COOKIE['activeSession'])){ header('Location: ../unifyWeb/index.php');}else{echo true;}?>">
	<div ng-include="'../unifyWeb/includes/loadingModal.html'"></div>
	<?php 
	include 'includes/header.php';
	include 'includes/navBar.php';
	?>
</br>
<div class="container loginContainer">
	<li class='divHeading'><p>Login</p></li>
	<form  ng-submit="validateData()" name="loginFrm">
	</br></br></br>
	<div class="alert alert-danger" ng-show="loginFrm.$invalid && validityStatusInfo"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> {{validityStatusInfo}}</div>
	<div class="alert alert-success" ng-if="<?php if(isset($_GET['user'])){echo $_GET['user'];}?>"><strong>Email confirmed!</strong><br>please log in </div>
<div class="form-group">
	<input style="margin: 0 auto;" type="text" name="username" class="form-control loginInputFields {{validityStatus}}" placeholder="Username" ng-change="resetInputField()" ng-model="username" required>
</div>
</br>
<div class="form-group">
	<input style="margin: 0 auto;" type="password" name="password" class="form-control loginInputFields {{validityStatus}}" ng-model="password" ng-change="resetInputField()" placeholder="Password" required>	
</div>
<center><span><a href="" data-toggle="modal" data-target="#passwordRecoveryModal"><span class="glyphicon glyphicon-modal-window"></span> Password Recovery</a></span></center>
</br>
<button type="submit" class="btn btn-lg buttons" ><span class="glyphicon glyphicon-send"></span> Go</button>
</center>
</br>
</span>
</br>
<span>new member <a class="smallButtons" style="background-color: lightgrey;font-weight:normal;color:#1a75ff;" href="../unifyWeb/userRegistration.php">Register</a></span>
</form>
<br>
</div>

<div id="passwordRecoveryModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Password Recovery</h4>
			</div>
			<div class="modal-body">
				<form name="passwordRecoveryFrm"  ng-submit="sendResetLink()">
					<div class="form-group">
						<label for="email" class="formHeading">Email:</label>
					</br>
					<div class="alert alert-danger" ng-show="passwordRecoveryFrm.$invalid && passwordRecoveryFrm.email.$error.pattern"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> invalid email</div>
					<div class="alert alert-danger" ng-show="emailValidityStatusInfo"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> {{emailValidityStatusInfo}}</div>
					<input type="email" name="email" class="form-control inputFields {{emailValidityStatus}}" placeholder="Enter the email tied to your account to recover password" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" ng-model="email" required>
				</div><br>
				<span ng-show="passwordRecoveryFrm.$valid"><center><button type="submit" class="buttons"><span class="glyphicon glyphicon-send"></span> Go</button></center></span>
				<span ng-show="passwordRecoveryFrm.$invalid"><center><button  style="background-color:lightgrey;" ng-disabled="true" type="submit" class="buttons"><span class="glyphicon glyphicon-send"></span> Go</button></center></span>
				<div class="loader" ng-show="showLoader">loading...</div>
				<br>
				<div class="alert alert-success" ng-if="successMsg"><strong>Done!</strong><br>{{successMsg}} </div>
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

<script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>

<script>
	window.sr = ScrollReveal();
	sr.reveal('.loginContainer', {duration: 1500, origin:'right', distance:'400px'});
</script>
</body>

</html>