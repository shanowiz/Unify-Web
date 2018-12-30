<!DOCTYPE html>
<html ng-app="uploadData">

<head>
    <?php include 'includes/head.php';?>
</head>

<body ng-controller="editHomeImages">
	<div ng-include="'../unifyWeb/includes/loadingModal.html'"></div>
    <?php 
		include 'includes/header.php';
		include 'includes/navBar.php';
	?>
	
	<div class="container carouselContainer" ng-init="initImages()">
		<div id="myCarousel" class="carousel slide desktopCarousel" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
		  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		  <li data-target="#myCarousel" data-slide-to="1"></li>
		  <li data-target="#myCarousel" data-slide-to="2"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" >
		  <div class="item active">
			<img src="{{firstImage}}" id="carouselImg" >
		  </div>
		
		  <div class="item">
			<img src="{{secondImage}}" id="carouselImg">
		  </div>
		  
		   <div class="item">
			<img src="{{thirdImage}}" id="carouselImg">
		  </div>
		</div>

		<!-- Left and right controls -->
		<a class="left carousel-control" href="#myCarousel" data-slide="prev">
		  <span class="glyphicon glyphicon-chevron-left"></span>
		  <span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" data-slide="next">
		  <span class="glyphicon glyphicon-chevron-right"></span>
		  <span class="sr-only">Next</span>
		</a>
	  </div>
	</div>
	<br><br>
	<div id="editImages" class="text-center" ng-init="department='<?php if(isset($_COOKIE['eventId'])){ echo $_COOKIE['eventId'];}?>'; validAdmin='admin'; editImageButton='Edit Images'">
		<form name="editImages" ng-submit="editHomeImages()">
			<div class="row" ng-if="editImageStatus">
				<div class="col-md-4">
					<label class="btn btn-lg frontPageImageInput" >
						<span class="glyphicon glyphicon-picture"></span>
						Image 1 <input type="file" id="firstImage" name="firstImage" style="display: none;" onchange="angular.element(this).scope().displayFirstImageName()"></br>
					</label>
					<br>{{firstImageName}}
					<br>
				</div>
				<div class="col-md-4">
					<label class="btn btn-lg frontPageImageInput" >
						<span class="glyphicon glyphicon-picture"></span>
						Image 2 <input type="file" id="secondImage" name="secondImage" style="display: none;" onchange="angular.element(this).scope().displaySecondImageName()"></br>
					</label>
					<br>{{secondImageName}}
					<br>
				</div>
				<div class="col-md-4">
					<label class="btn btn-lg frontPageImageInput" >
						<span class="glyphicon glyphicon-picture"></span>
						Image 3 <input type="file" id="thirdImage" name="thirdImage" style="display: none;" onchange="angular.element(this).scope().displayThirdImageName()"></br>
					</label>
					<br>{{thirdImageName}}
					<br>
				</div>
				<br><br>
			</div>
			<br>
			<button ng-if="department==validAdmin" type="submit" class="btn btn-lg largeButtons text-center"><span class="glyphicon glyphicon-picture"></span> {{editImageButton}}</button>
		</form>
		<br>
		<div style="width:40%;margin:0 auto;" ng-if="showSuccessAlert" class="alert alert-success"><strong>Done!</strong><br>Page will refresh in a second</div>
		<br>
	</div>
    <div class="container homePageRowContainer">
        <div class="row homePageRow">
            <div class="col-md-4" id="detailsDiv1">
                <h2 class="text-center"><strong>Unify's Motto</strong></h2>
                <p class="text-center">Unify will become Utech's best mobile application through you, providing convenience and efficiency at arms length. </p>
            </div>
            <div class="col-md-4" id="detailsDiv2">
                <h2 class="text-center"><strong>Convenience</strong> </h2>
                <p class="text-center">Unify's responsive web interface provides ease of use to users uploading events whether from a mobile device or a computer as Unify's interace reacts and changes given the platform.</p>
            </div>
            <div class="col-md-4" id="detailsDiv3">
                <h2 class="text-center"><strong>Re-Designed App</strong></h2>
                <p class="text-center">Unify is a complete upgraded re-design of Utech's current mobile application. Providing students and staff a like with only the best experience.</p>
            </div>
        </div>
    </div>
	
	</br></br>
	<div class="unifyWebDiv">
		<div class="container" id="unifyWebContainer">
			</br>
			<div class="row">
				<div class="col-md-4" id="col">
					<center><img src="assets/img/upload1.png" width="300" height="300"></center>
					<br>
				</div>
				
				<div class="col-md-8" id="col">
					<h1 class="text-center" align="center">Unify Web</h1>
					<p>unify's web interface allows for the easy and efficient upload and management of events. Unify was developed using top technologies with its end users being the main priorty. Based on the device Unify's web interaces reacts and changes its display to better suite the device and its user allowing for a much more fine tunned experience.</p>
				</div>
			</div>
			</br>
		</div>
	</div>

	</br></br>
	<div class="unifyMobileDiv">
		<div class="container">
			</br>
			<div class="row">
				<div class="col-md-8" id="unifyMobileDivDetails">
					<h1 class="text-center" align="center">Unify Mobile</h1>
					<p>Stay informed with the happenings of your university with the newly developed mobile app Unify. Unify seeks to provide students and staff a like with university updates. The mobile app interface provides users with an organized simplistic interface to view events and thier locations amongst aother features. </p>
					<br>
					<div id="appLinksDiv">
						<center><a href=""><img class="playStoreImg" src="assets/img/playStore.png" width="250" height="90"></a>
						<a href=""><img class="appStoreImg" src="assets/img/appStore.png" width="250" height="65"></a></center>
					</div>
					<br>
				</div>
				<div class="col-md-4" id="unifyMobileDivImg">
					<center><img class="unifyLogoImg" src="assets/img/unify.png" width="200" height="200"></center>
				</div>
			</div>
			</br>
		</div>
	</div>

	<?php include 'includes/footer.php';?>

	<div id="newUserMsgModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4>Attention</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-success"><strong>Please review new users</strong></div>	
			</div>
	</div>
	
    <script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
	
	<script>
		window.sr = ScrollReveal();

		sr.reveal('.carouselContainer', {duration: 2000, origin:'right', distance:'300px'});
		sr.reveal('#editImages', {duration: 2500, origin:'right', distance:'300px'});
		sr.reveal('#detailsDiv1', {duration: 1700, origin:'bottom', distance:'300px'});
		sr.reveal('#detailsDiv2', {duration: 1900, origin:'bottom', distance:'300px'});
		sr.reveal('#detailsDiv3', {duration: 2000, origin:'bottom', distance:'300px'});
		sr.reveal('.unifyWebDiv', {duration: 1800, origin:'left', distance:'300px', viewFactor: 0.2});
		sr.reveal('#unifyWebContainer', {duration: 2500, origin:'bottom', distance:'300px', viewFactor: 0.2});
		sr.reveal('#unifyMobileDivDetails', {duration: 2200, origin:'left', distance:'300px', viewFactor: 0.2});
		sr.reveal('#unifyMobileDivImg', {duration: 2200, origin:'right', distance:'300px', viewFactor: 0.2});
		sr.reveal('#appLinksDiv', {duration: 3500, origin:'left', distance:'300px', viewFactor: 0.2});
	</script>
</body>
</html>