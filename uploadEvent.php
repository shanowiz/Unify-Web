<!DOCTYPE html>
<html ng-app="uploadData">

<head>
    <?php include 'includes/head.php';?>
</head>

<body ng-controller="validateEvent"  ng-if="<?php if (isset($_COOKIE['activeSession'])){ echo $_COOKIE['activeSession'];}else{header('Location: ../unifyWeb/login.php');}?>">
	<div ng-include="'../unifyWeb/includes/loadingModal.html'"></div>
    <?php 
		include 'includes/header.php';
		include 'includes/navBar.php';
	?>
	</br>
	<div class="container uploadEventContainer">
		<li class='divHeading'><p>Upload</p></li>
		</br>
		<form enctype="multipart/form-data" method="post" name="uploadFrm" ng-submit="uploadEvent()">
			</br>
			{{requireStatus}}
			<div class="alert alert-success" ng-if="<?php if (isset($_GET['successMsg'])){echo $_GET['successMsg'];}?>"><strong>Successful!</strong></div>
			<div class="alert alert-danger" ng-if="eventCollisionErr"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning! </strong>{{eventCollisionErr}}</div>
			<div class="form-group">
				<label for="eventname" class="formHeading">Event:</label>
				</br>
				<div class="alert alert-danger" ng-if="eventNameErr && uploadFrm.$invalid"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning! </strong>{{eventNameErr}}</div>
				<div class="alert alert-danger" ng-show="uploadFrm.eventName.$dirty && uploadFrm.eventName.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max characters</div>
				<input type="text" name="eventName" class="form-control inputFields {{eventNameValidityStatus}}" placeholder="Event Name" ng-model="eventName" ng-maxlength="50" ng-minlength="1" required>
			</div>
			<div class="form-group">
				<label for="date" class="formHeading">Date:</label>
				</br>
				<div class="alert alert-danger" ng-if="dateValidityStatusInfo"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> {{dateValidityStatusInfo}}</div>
				<input type="date" id= "date1" name="eventDate" class="form-control inputFields" ng-model="eventDate" onchange="angular.element(this).scope().validateEventDate()" required>
			</div>
			<div class="form-group">
				<div class="alert alert-danger" ng-show="uploadFrm.eventVenue.$dirty && uploadFrm.eventVenue.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max characters</div>
				<label for="venue" class="formHeading">Venue:</label>
				<input type="text" name="eventVenue" class="form-control inputFields" placeholder="Event Location" ng-model="eventVenue" ng-maxlength="30" required>
			</div>
			<div class="form-group">
				<div class="alert alert-danger" ng-show="uploadFrm.eventDetails.$dirty && uploadFrm.eventDetails.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max characters</div>
				<label for="details" class="formHeading">Details:</label>
				<textarea name="eventDetails" class="form-control detailsInput" placeholder="Event Details" ng-model="eventDetails" ng-maxlength="200" required></textarea>
			</div>
			<div class="form-group">
				<label for="cost" class="formHeading">Cost:</label>
				</br>
				<input type="checkbox" name="costFree" ng-model="costFree" onchange="angular.element(this).scope().validateCost()"> Free
				</br></br>
				<input type="number" name="eventCost" ng-disabled="disabledStatus" class="form-control inputFields" placeholder="Event Cost" ng-model="eventCost" required>
			</div>
			<div class="form-group">
				<label for="time" class="formHeading">Time:</label></br>
			Start: <input type="time" name="startTime" class=" form-control inputFields" ng-model="startTime" required> 
			End: <input type="time" name="endTime" class=" form-control inputFields" ng-model="endTime" required></label>
			</div>
			<div class="form-group">
				<div class="alert alert-danger" ng-if="imageErr"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> {{imageErr}}</div>
				<label for="image" class="formHeading">Image: </label>16mb Max</br>
				<label class="btn btn-lg imageInput" >
					<span class="glyphicon glyphicon-picture"></span>
				    Browse.. <input type="file" id="eventImage" name="eventImage" style="display: none;" onchange="angular.element(this).scope().displayEventFileName()"></br>
				</label>
				 <span ng-show="fileName">{{fileName}}</span></br>
            </div>
			</br><br>
			<span ng-show="uploadFrm.$valid">
			<center><button type="submit" class="btn buttons"><span class="glyphicon glyphicon-cloud-upload"></span> Upload</button></center>
			</span>
			<span ng-show="uploadFrm.$invalid" style="font-size:15px;">
			<center>
			<button type="button" style="background-color:lightgrey;" class="btn buttons" ng-disabled="true"><span class="glyphicon glyphicon-cloud-upload"></span> Upload</button>
			</center>
			</span>
		</br>
		<br>
		</form>
	</div>
	</br>
    <?php include 'includes/footer.php';?>
   
</body>

</html>