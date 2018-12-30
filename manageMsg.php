<!DOCTYPE html>
<html ng-app="getData">

<head>
	<?php include 'includes/head.php';?>
</head>
<body ng-if="<?php if (isset($_COOKIE['activeSession'])){ echo $_COOKIE['activeSession'];}else{header('Location: ../unifyWeb/login.php');}?>; <?php if($_COOKIE['eventId']=='admin'){ echo $_COOKIE['eventId'];}else{header('Location: ../unifyWeb/index.php');}?>='admin'" ng-controller="manageMsg" ng-init="showMsgList=true;showCompose=false; department='<?php if(isset($_COOKIE['eventId'])){ echo $_COOKIE['eventId'];}?>'">
	<div ng-include="'../unifyWeb/includes/loadingModal.html'"></div>
	<?php 
	include 'includes/header.php';
	include 'includes/navBar.php';
	?>
	<div ng-show="mobileScreenWidth">
		<form name="searchFrm" ng-submit="searchMsg()">
			<div class="input-group">
				<input type="text" class="form-control" ng-model="searchId" placeholder="Search Messages" name="search">
				<div class="input-group-btn">
					<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
				</div>
			</div>
		</form>
		<span ng-if="searchResultCount>=0">Results: {{searchResultCount}} </span>
	</div>
</br>
<div ng-show="showSuccessAlert" class="alert alert-success"><strong>Sent!</strong></div>
<div class="row">
	<div class="col-md-2">
		<button type="button" ng-click="displayCompose()" class="btn btn-sml" style="width:100%"><span class="glyphicon glyphicon-pencil"></span> Compose</button>
		<br><br>
		<button type="button" ng-click="retrieveInboxMsg()" class="btn btn-sml" style="width:100%"><span class="glyphicon glyphicon-envelope"></span> Inbox</button>
		<br><br>
		<button type="button" ng-click="retrieveSentMsg()" class="btn btn-sml" style="width:100%"><span class="glyphicon glyphicon-send"></span> Sent</button>
		<br><br>
	</div>
	<div class="col-md-10" ng-show="showCompose" ng-init="disableField=true">
		<div class="sendUserMsgDiv">
			
			<form name="sendUserMsgFrm">
				<div class="form-group">
					<div class="alert alert-danger" ng-show="sendUserMsgFrm.email.$dirty && sendUserMsgFrm.email.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max characters</div>
					<div class="alert alert-danger" ng-show="sendUserMsgFrm.email.$dirty && sendUserMsgFrm.email.$error.pattern"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> invalid email</div>
					<div class="alert alert-danger" ng-show="sendUserMsgFrm.email.$dirty && emailErr"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> user does not exists</div>
					<input type="text" name="email" class="form-control singleLineInputField {{emailErr}}" placeholder="Email" ng-model="email" ng-maxlength="50" ng-minlength="1" ng-disabled="disableField" ng-pattern="/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/" required>
				</div>
				<div class="form-group">
					<div class="alert alert-danger" ng-show="sendUserMsgFrm.subject.$dirty && sendUserMsgFrm.subject.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max characters</div>
					<input type="text" name="subject" class="form-control singleLineInputField" placeholder="Subject" ng-model="subject" ng-maxlength="100" ng-disabled="disableField" required>
				</div>
				<div class="form-group">
					<div class="alert alert-danger" ng-show="sendUserMsgFrm.userMsg.$dirty && sendUserMsgFrm.userMsg.$error.maxlength"><strong><img src="../unifyWeb/assets/img/error.png" class="invalidIconImg">Warning!</strong> exeeded max characters</div>
					<textarea style="height:200px;box-shadow: none;border:0;" name="userMsg" class="form-control inputFields" placeholder="Write something..." ng-model="userMsg" ng-disabled="disableField" ng-maxlength="500" required></textarea>
				</div><br>
				<button ng-show="showReplyButton" class="btn btn-sml" ng-click="reply()"><span class="glyphicon glyphicon-share-alt"></span> reply</button>
				<button ng-show="showDeleteButton" class="btn btn-sml" ng-click="deleteMsg()"><span class="glyphicon glyphicon-trash"></span></button>

				<div ng-show="showComposeSendButton">
					<center>
						<button ng-show="sendUserMsgFrm.$valid" ng-click="sendUserMsg()" type="submit" class="buttons"><span class="glyphicon glyphicon-send"></span> Send</button>
						<button ng-show="sendUserMsgFrm.$invalid" style="background-color:lightgrey;" type="submit" ng-disabled="true" class="buttons"><span class="glyphicon glyphicon-send"></span> Send</button>
					</center>
				</div>
				<br>
			</form>
		</div>
	</div>
	<div class="col-md-10" ng-show="showMsgList">
		<div ng-show="webScreenWidth">
			<form name="searchFrm" ng-submit="searchMsg()">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search Messages" ng-model="searchId" name="search">
					<div class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					</div>
				</div>
				<span ng-if="searchResultCount>=0">Results: {{searchResultCount}} </span>
			</form>
		</div>
		<div class="messagesDiv" ng-init="retrieveInboxMsg()">
			<table>
				<tr ng-repeat="x in msgList">
					<td><a href="" ng-click="displaySingleMsg(x.departmentemail,x.subject,x.msg,x.id)" style="float: left; text-decoration: none; color:#333333;font-weight: bold;">{{x.departmentemail}}</a> 
						<a href="" ng-click="deleteMsg(x.id)" style="color:#1a1a1a;"><span style="float: right;" class="glyphicon glyphicon-trash"></span></a>
						<br>
						<a href="" ng-click="displaySingleMsg(x.departmentemail,x.subject,x.msg,x.id)" style="float: left; text-decoration: none; color:#333333;">{{x.subject}}</a></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</br>
<?php include 'includes/footer.php';?>
</body>

</html>