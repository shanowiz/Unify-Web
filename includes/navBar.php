<nav class="navbar navbar-default navBar" ng-app ng-init="profileName='<?php if(isset($_COOKIE['profileName'])){ echo $_COOKIE['profileName'];}?>'; department1='<?php if(isset($_COOKIE['eventId'])){ echo $_COOKIE['eventId'];}?>'; validAdmin='admin'; newMessage = '<?php if (isset($_COOKIE['newMessage'])){echo $_COOKIE['newMessage'];}?>'; newUser = '<?php if (isset($_COOKIE['newUser'])){echo $_COOKIE['newUser'];}?>'">
	<div class="container-fluid" style="background-color:#333;"  >
		<div class="navbar-header" >
			<button type="button" style="background-color:#333;" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button></div>
		<div class="collapse navbar-collapse listItemsDiv" id="navcol-1">
			<ul class="nav navbar-nav navbar-left">
				<li role="presentation" id="navbar-left" class="dropdown"><a href="../unifyWeb/index.php" class="listItems" style="color:white;"><span class="glyphicon glyphicon-home"></span> Home</a></li>
				<li ng-if="profileName" id="navbar-left" class="dropdown"><a class="dropdown" data-toggle="dropdown" style="color:white;" href="#"><span class="glyphicon glyphicon-cloud-upload"></span> Upload<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu" id="dropdown">
						<li><a href="../unifyWeb/uploadEvent.php">Events</a></li>
						<li><a href="../unifyWeb/uploadDiscount.php">Discounts</a></li>
					</ul>
				</li>
				<li ng-if="profileName" id="navbar-left" class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"  style="color:white;" href="#"> <span class="glyphicon glyphicon-edit"></span> Manage <span class="caret"></span>  <span ng-show="newUser && department1==validAdmin" class="glyphicon glyphicon-exclamation-sign" style="color: red;"></span></a>
					<ul class="dropdown-menu" role="menu" id="dropdown">
						<li><a href="../unifyWeb/manageEvents.php">Events</a></li>
						<li><a href="../unifyWeb/manageDiscounts.php">Discounts</a></li>
						<li ng-if="department1==validAdmin"><a href="../unifyWeb/functions/killCookieReroute.php?id=manageUsers">Users  <span ng-show="newUser" class="glyphicon glyphicon-exclamation-sign" style="color: red;"></span></a></li>
					</ul>
				</li>
				<li ng-if="profileName && department1==validAdmin" role="presentation" id="navbar-left" class="dropdown"><a href="../unifyWeb/functions/killCookieReroute.php?id=manageMsg" ng-click="" class="listItems" style="color:white;"><span class="glyphicon glyphicon-envelope"></span> Messages <span ng-show="newMessage" class="glyphicon glyphicon-exclamation-sign" style="color: red;"></span></a></li>
			</ul> 
			<ul class="nav navbar-nav navbar-right">
				<li role="presentation" ng-if="!profileName" style="background-color:#1a75ff;">
					<a href="../unifyWeb/login.php" class="listItems" style="color:white;"><span class="glyphicon glyphicon-user"></span> Login</a>
				</li>
				<li ng-if="profileName" class="dropdown" style="background-color:#1a75ff;"  id="navbar-right"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="color:white;"><span class="glyphicon glyphicon-user"></span> {{profileName}}</a>
					<ul class="dropdown-menu" role="menu" id="dropdown">
						<li><a href="../unifyWeb/userProfile.php">Profile</a></li>
						<li><a href="../unifyWeb/functions/loginFunction.php?action=destroy" >Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>