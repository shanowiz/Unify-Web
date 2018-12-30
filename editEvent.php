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
	<div class="container editEventContainer" ng-controller="editEvent" ng-init="retrieveEvent('<?php echo $_GET['id']?>')">
		<li class='divHeading'><p>Edit</p></li>
		</br>
		<form enctype="multipart/form-data" method="post" name="uploadFrm" ng-submit="editEvent()">
			</br>
			<div class="alert alert-danger" ng-if="eventCollisionErr"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> {{eventCollisionErr}}</div>
			</br>
			<div class="form-group">
				<label for="name" class="formHeading">Event:</label>
				</br>
				<div class="alert alert-danger" ng-if="eventNameErr"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> {{eventNameErr}}</div>
				<div class="alert alert-danger" ng-show="uploadFrm.eventName.$dirty && uploadFrm.eventName.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max ccharacters</div>
				<input type="text" name="eventName" class="form-control inputFields {{eventNameValidityStatus}}" placeholder="Event Name" ng-model="eventName" ng-maxlength="50" ng-minlength="1" required>
			</div>
			<div class="form-group">
				<label for="date" class="formHeading">Date:</label>
				</br>
				<div class="alert alert-danger" ng-if="dateValidityStatusInfo"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> {{dateValidityStatusInfo}}</div>
				<input type="date" id= "date1" name="eventDate" class="form-control inputFields {{dateValidityStatus}}" ng-model="eventDate" onchange="angular.element(this).scope().validateEventDate()" required>
			</div>
			<div class="form-group">
				<label for="venue" class="formHeading">Venue:</label>
				<div class="alert alert-danger" ng-show="uploadFrm.eventVenue.$dirty && uploadFrm.eventVenue.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max ccharacters</div>
				<input type="text" name="eventVenue" class="form-control inputFields" placeholder="Event Location" ng-model="eventVenue" ng-maxlength="30" required>
			</div>
			<div class="form-group">
				<label for="details" class="formHeading">Details:</label>
				<div class="alert alert-danger" ng-show="uploadFrm.eventDetails.$dirty && uploadFrm.eventDetails.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max ccharacters</div>
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
			Start: <input type="text" onfocus="this.type='time'" name="startTime" class=" form-control inputFields {{startTimeValidityStatus}}" ng-model="startTime" onchange="angular.element(this).scope().validateStartTime()" required> 
			End: <input type="text" onfocus="this.type='time'" name="endTime" class=" form-control inputFields {{endTimeValidityStatus}}" ng-model="endTime" required onchange="angular.element(this).scope().validateEndTime()"></label>
			</div>
			<div class="form-group">
				<label for="image" class="formHeading">Image: </label>16mb Max</br>
				<div class="alert alert-danger" ng-if="imageErr"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> {{imageErr}}</div>
				<label class="btn btn-lg imageInput" >
					<span class="glyphicon glyphicon-picture"></span>
				    Browse <input type="file"  id="eventImage" name="eventImage" style="display: none;" onchange="angular.element(this).scope().displayEventFileName()"></br>
				</label><br>
				<img class= "img-rounded img-thumbnail" src="{{eventImage}}" style="width:200px; height:150px;"" class="">
				<span>{{fileName}}</span></br>
            </div>
			<br><br>
			<span ng-show="uploadFrm.$valid">
			<center><button type="submit" class="btn btn-lg buttons"><span class="glyphicon glyphicon-floppy-saved"></span> Save</button></center>
			</span>
			<span ng-show="uploadFrm.$invalid" style="font-size:15px;">
			<center>
			<center><button style="background-color:lightgrey;" type="button" class="btn btn-lg buttons" ng-disabled="true"><span class="glyphicon glyphicon-floppy-saved"></span> Save</button></center></br></br>
			</center>
			</span>
		</form>
		<br>
	</div>
	<br>
    <?php include 'includes/footer.php';?>
</body>

</html>