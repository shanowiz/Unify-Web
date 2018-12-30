<!DOCTYPE html>
<html ng-app="getData">

<head>
	<?php include 'includes/head.php';?>
</head>
<body ng-controller="manageData" ng-init="retrieveDiscounts()" ng-if="<?php if (isset($_COOKIE['activeSession'])){ echo $_COOKIE['activeSession'];}else{header('Location: ../unifyWeb/login.php');}?>">
	<div ng-include="'../unifyWeb/includes/loadingModal.html'"></div>
	<?php 
	include 'includes/header.php';
	include 'includes/navBar.php';
	?>
</br>
<div class="manageDiscountsDiv">
	<br>
	<div class="container searchContainer">
	<form name="searchFrm" ng-submit="searchDiscount()">
		<div class="input-group">
      <input type="text" class="form-control" placeholder="Search Discount" name="search" ng-model="searchId">
      <div class="input-group-btn">
        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
      </div>
    </div>
    <span ng-if="searchResultCount>=0">Results: {{searchResultCount}} </span>
	</form>
</br>
</div>
</br></br>
<div class="row" ng-if="existDiscount" style="margin: 0 auto; word-wrap: break-word;">
	<div class="col-md-3" ng-repeat="x in info">
		<center>
			<a href="discount.php?id={{x.id}}" style="text-decoration: none; color:#595959; font-weight: bold;font-size: 17px;">
				<img class= "img-rounded img-thumbnail" src="{{x.image}}" style="width:200px; height:130px;"><br>
				<div class="previewDetailsDiv">
					<p class="text"><span><strong>{{x.name}}</strong></span>
					<br><span>{{x.date}}</span>
					<br><span>{{x.venue}}</span></p>
				</div>
			</a>
		</center>
		<br><br><br>
	</div> 
</div>
<div style="width:100%" ng-if="!existDiscount || searchResultCount==0">
	<center><img class="img img-rounded noDataImg" src="../unifyWeb/assets/img/empty.png"></center>
	<br><br>
</div>
</br>
</div>
<?php include 'includes/footer.php';?>

</body>

</html>