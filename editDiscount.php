<!DOCTYPE html>
<html ng-app="getData">

<head>
    <?php include 'includes/head.php';?>
</head>

<body ng-if="<?php if (isset($_COOKIE['activeSession'])){ echo $_COOKIE['activeSession'];}else{header('Location: ../unifyWeb/login.php');}?>">
	<div ng-include="'../unifyWeb/includes/loadingModal.html'"></div>
	<div ng-include="'../unifyWeb/includes/successModal.html'"></div>
    <?php 
		include 'includes/header.php';
		include 'includes/navBar.php';
	?>
	</br>
	<div class="container editDiscountContainer" ng-controller="editDiscount" ng-init="retrieveDiscount('<?php echo $_GET['id']?>')" ng-submit="editDiscount()">
		<li class='divHeading'><p>Edit</p></li>
		</br>
		<form enctype="multipart/form-data" method="post" name="uploadFrm">
			</br>
			<div class="form-group">
				<label for="name" class="formHeading">Discount:</label>
				<div class="alert alert-danger" ng-show="uploadFrm.discountName.$dirty && uploadFrm.discountName.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max characters</div>
				<input type="text" name="discountName" class="form-control inputFields" placeholder="Discount Name" ng-model="discountName" ng-maxlength="50" ng-minlength="1" required>
			</div>
			<div class="form-group">
				<label for="date" class="formHeading">Date:</label>
				<div class="alert alert-danger" ng-if="dateValidityStatusInfo"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> {{dateValidityStatusInfo}}</div>
				<input type="date" id= "date1" name="discountDate" class="form-control inputFields {{dateValidityStatus}}" ng-model="discountDate" onchange="angular.element(this).scope().validateEventDate()" required>
			</div>
			<div class="form-group">
				<label for="venue" class="formHeading">Venue:</label>
				<div class="alert alert-danger" ng-show="uploadFrm.discountVenue.$dirty && uploadFrm.discountVenue.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max characters</div>
				<input type="text" name="discountVenue" class="form-control inputFields" placeholder="Event Location" ng-model="discountVenue" ng-maxlength="30" required>
			</div>
			<div class="form-group">
				<label for="details" class="formHeading">Details:</label>
				<div class="alert alert-danger" ng-show="uploadFrm.discountDetails.$dirty && uploadFrm.discountDetails.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max characters</div>
				<textarea name="discountDetails" class="form-control detailsInput" placeholder="Event Details" ng-model="discountDetails" ng-maxlength="200" required></textarea>
			</div>
			<div class="form-group">
				<label for="image" class="formHeading">Image: </label>16mb Max</br>
				<div class="alert alert-danger" ng-if="imageErr"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> {{imageErr}}</div>
				<label class="btn btn-lg imageInput" >
					<span class="glyphicon glyphicon-picture"></span>
				    Browse <input type="file"  id="discountImage" name="discountImage" style="display: none;" onchange="angular.element(this).scope().displayEventFileName()"></br>
				</label><br>
				<img class= "img-rounded img-thumbnail" src="{{discountImage}}" style="width:200px; height:150px;"" class="">
				<span>{{fileName}}</span></br> 
            </div>
			<br><br>
			<span ng-show="uploadFrm.$valid">
			<center><button type="submit" class="btn btn-lg buttons"><span class="glyphicon glyphicon-floppy-saved"></span> Save</button></center>
			</span>
			<span ng-show="uploadFrm.$invalid" style="font-size:15px;">
			<center>
			<button type="button" style="background-color:lightgrey;" class="btn btn-lg buttons" ng-disabled="true"><span class="glyphicon glyphicon-floppy-saved"></span> Save</button>
			</br></br>
			</center>
			</span>
			</br>
		</form>
	</div>
	<br>
    <?php include 'includes/footer.php';?>
</body>

</html>