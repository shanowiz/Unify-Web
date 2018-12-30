<!DOCTYPE html>
<html ng-app="getData">

<head>
	<?php include 'includes/head.php';?>
</head>
<body ng-controller="manageUsers" ng-init="retrieveUsers()"  ng-if="<?php if (isset($_COOKIE['activeSession'])){ echo $_COOKIE['activeSession'];}else{header('Location: ../unifyWeb/login.php');}?>; <?php if($_COOKIE['eventId']=='admin'){ echo $_COOKIE['eventId'];}else{header('Location: ../unifyWeb/index.php');}?>='admin'">
	<div ng-include="'../unifyWeb/includes/loadingModal.html'"></div>
	<?php 
	include 'includes/header.php';
	include 'includes/navBar.php';
	?>
</br>
<div class="manageUserDiv">
	<div class="container searchContainer">
	</br>
	<form name="searchFrm" ng-submit="searchUser()">
		<div class="input-group">
      <input type="text" class="form-control" placeholder="Search User" name="search" ng-model="searchId">
      <div class="input-group-btn">
        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
      </div>
    </div>
    <span ng-if="searchResultCount>=0">Results: {{searchResultCount}} </span>
	</form>

</div>
</br></br>
<div class="row" ng-if="existUser" style="margin: 0 auto; word-wrap: break-word; ">
	<div class="col-md-3" ng-repeat="x in userData">
		<center>
			<a href="user.php?id={{x.id}}" style="text-decoration: none; color:#595959; font-weight: bold;font-size: 17px;">
				<img class= "img-rounded img-thumbnail" src="../unifyWeb/assets/img/user1.png" style="width:200px; height:150px;"">
				<div class="previewDetailsDiv">
					<p class="text"><span>{{x.username}}</span>
					<br><span>{{x.department}}</span></p>
				</div>
			</a>
		</center>
		<br><br><br>
	</div> 
</div>
<div style="width:100%" ng-if="!existUser || searchResultCount==0">
	<center><img class="img img-rounded noDataImg" src="../unifyWeb/assets/img/empty.png"></center>
	<br><br>
</div>
</br>
</div>
<?php include 'includes/footer.php';?>

</body>

</html>