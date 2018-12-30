<!DOCTYPE html>
<html ng-app="uploadData">

<head>
	<?php include 'includes/head.php';?>
</head>

<body>
	<div ng-include="'../unifyWeb/includes/loadingModal.html'"></div>
	<?php 
	include 'includes/header.php';
	include 'includes/navBar.php';
	?>
</br>
<div class="container createUserContainer" ng-controller="userRegistration">
	<li class='divHeading'><p>Registration</p></li>
</br>
<form name="registrationFrm" ng-submit="validateFields()">
</br>
<div class="alert alert-info"><strong>Note! </strong>Only personel apart of the departments lsited below must register an account for their individual departments. <strong>NO INDIVIDUAL STUDENT/STAFF IS ALLOWED TO REGISTER AN ACCOUNT FOR THEIR OWN PERSONAL USE.</strong></div>
<div class="form-group">
	<label for="firstname" class="formHeading">First Name:</label>
	<div class="alert alert-danger" ng-show="registrationFrm.firstName.$dirty && registrationFrm.firstName.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exceeded max characters</div>
	<input type="text" placeholder="Fist Name" name="firstName" ng-model="firstName" class="form-control inputFields" ng-maxlength="30" required>
</div>
<div class="form-group">
	<label for="lastname" class="formHeading">Last Name:</label>
	<div class="alert alert-danger" ng-show="registrationFrm.lastName.$dirty && registrationFrm.lastName.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exceeded max characters</div>
	<input type="text" placeholder="Last Name" name="lastName" ng-model="lastName" class="form-control inputFields" ng-maxlength="30" required>
</div>
<div class="form-group">
	<label for="id" class="formHeading">Id Number:</label>
	<input type="number" placeholder="ID Number" name="idNumber" ng-model="idNumber" class="form-control inputFields" required>
</div>
<div class="form-group">
	<label for="username" class="formHeading">Username:</label>
	<div class="alert alert-danger" ng-if="usernameValidityStatusInfo && registrationFrm.$invalid"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> {{usernameValidityStatusInfo}}</div>
	<div class="alert alert-danger" ng-show="registrationFrm.username.$dirty && registrationFrm.username.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exceeded max characters</div>
	<input type="text" placeholder="Username" ng-model="username" name="username" class="form-control inputFields" ng-maxlength="35" required>
</div>
<div class="form-group">
	<label for="email" class="formHeading">Department Email:</label>
	<div class="alert alert-danger" ng-if="emailValidityStatusInfo && registrationFrm.$invalid"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> {{emailValidityStatusInfo}}</div>
	<div class="alert alert-danger" ng-show="registrationFrm.$invalid && registrationFrm.departmentEmail.$error.pattern"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> invalid email</div>
	<input type="email" placeholder="Email" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" name="departmentEmail" ng-model="departmentEmail" class="form-control inputFields" required>
</div>
<div class="form-group">
	<label for="password" class="formHeading">Password:</label>
	<div class="alert alert-danger" ng-if="passwordValidityStatusInfo && registrationFrm.$invalid"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> {{passwordValidityStatusInfo}}<br></div>
	<div class="alert alert-danger" ng-show="registrationFrm.password.$dirty && registrationFrm.password.$error.minlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> 7 characters min<br></div>
	<div class="alert alert-danger" ng-show="registrationFrm.password.$dirty && registrationFrm.password.$error.pattern"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> both letters and numbers, no special characters</div>
	<input type="password" placeholder="Password" ng-model="password" name="password" class="form-control inputFields" ng-minlength="7" ng-pattern="/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/" required>
</div>
<div class="form-group">
	<label for="confirm password" class="formHeading">Confirm Password:</label>
	<input type="password" placeholder="Confirm Password" ng-model="confirmPassword" name="confirmPassword" class="form-control inputFields" required>
</div>
<div class="form-group">
	<label for="department" class="formHeading">Department:</label>
	<div class="alert alert-danger" ng-show="departmentValidityStatusInfo"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> {{departmentValidityStatusInfo}}</div>
	<div class="checkbox">
		<input type="radio" value="studentsUnionChecked" ng-model="department" name="department" class="formHeading">
		<label>Students Union</label>
	</div>
	<div class="checkbox">
		<input type="radio" value="universityChecked" ng-model="department" name="department" class="formHeading">
		<label>University</label>
	</div>
	<div class="checkbox">
		<input type="radio" value="facultyChecked"	 ng-model="department" name="department" class="formHeading">
		<label for="faculty">Faculty/School rep:</label>
		<select class="dropDown {{facultyValidityStatus}}" id="club" ng-model="facultySelect" style="width:160px;">
			<option>School of Engineering</option>
			<option>School of Computing and Information Technology</option>
			<option>Caribbean School of Nursing</option>
			<option>School of Allied Health & Wellness</option>
			<option>School of Pharmacy</option>
			<option>School of Business Administration</option>
			<option>School of Hospitality and Tourism Management</option>
			<option>Joan Duncan School of Entrepreneurship, Ethics & Leadership</option>
			<option>UTech/JIM School of Advanced Management</option>
			<option>School of Technical & Vocational Education</option>
			<option>School of Humanities & Social Sciences</option>
			<option>School of Building & Land Management</option>
			<option>Caribbean School of Architecture</option>
			<option>Faculty of Law</option>
			<option>School of Natural & Applied Sciences</option>
			<option>School of Mathematics & Statistics</option>
			<option>Caribbean School of Sport Sciences</option>
			<option>Centre for Science-based Research, Entrepreneurship & Continuing Studies</option>
			<option>Joint College of Medicine</option>
			<option>Joint College of Oral Health</option>
			<option>Joint College of Veterinary Sciences</option>
		</select>
	</div>
	<div class="checkbox">
		<input type="radio" value="clubChecked" ng-model="department" name="department">
		<label for="club">Club:</label>
		<input type="text" placeholder="enter club" ng-model="clubName" name="club" class="clubInputField {{clubValidityStatus}}">
	</div>
</div>
</br></br>
<span ng-if="registrationFrm.$valid && department"><button type="submit" class="buttons"><span class="glyphicon glyphicon-cloud-upload"></span> Submit</button></span>
<span ng-if="registrationFrm.$invalid || !department"><button ng-disabled="true" style="background-color:lightgrey;" type="submit" class="buttons"><span class="glyphicon glyphicon-cloud-upload"></span> Submit</button></span>
<br><br>
</form>
</div>
<div id="successModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" onclick="location.href='../unifyWeb/index.php'" class="close" data-dismiss="modal">&times;</button>
				<h4>Done</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-success"><strong>Successful !</strong><br>check email for confimation link</div>	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" onclick="location.href='../unifyWeb/index.php'" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
</br>
<?php include 'includes/footer.php';?>
</body>

</html>