var uploadData = angular.module('uploadData', ['duScroll']);

//validates and registers a new user
uploadData.controller("userRegistration", function ($scope,$http,$document) {

  $scope.$watch('department', function() {
    if ($scope.department == "facultyChecked" && $scope.facultySelect == undefined) {
      $scope.facultyValidityStatus = "invalid";
      $scope.clubValidityStatus = "valid";
    }else if ($scope.department == "clubChecked" && $scope.clubName == undefined) {
      $scope.clubValidityStatus = "invalid";
      $scope.facultyValidityStatus = "valid";
    }else{
      $scope.facultyValidityStatus = "valid";
      $scope.clubValidityStatus = "valid";
    }
  });

  $scope.validateFields = function () {

   $scope.passwordValidityStatusInfo = "";
   $scope.departmentValidityStatusInfo = "";
   $scope.usernameValidityStatusInfo = "";

   if ($scope.password != $scope.confirmPassword) {
    $scope.passwordValidityStatusInfo ="Passwords dont match.";
    $scope.password = "";
    $scope.confirmPassword = "";
  } else if ($scope.idNumber < 1000000 && ($scope.department=="studentsUnionChecked" || $scope.department == "facultyChecked" || $scope.department == "clubChecked")) {
    $scope.departmentValidityStatusInfo = "The department selected does not match Id Number entered.Change Id Number or Department.";      
  }else{
    $scope.registerUser();
  }
}

$scope.registerUser = function () {

  $('#loadingModal').modal('show');
  var fd = new FormData ();

  fd.append('firstName', $scope.firstName);
  fd.append('lastName', $scope.lastName);
  fd.append('idNumber', $scope.idNumber);
  fd.append('username', $scope.username);
  fd.append('departmentEmail', $scope.departmentEmail);
  fd.append('password', $scope.password);
  if ($scope.department == "studentsUnionChecked"){
    fd.append('department', "union");
  }else if ($scope.department == "facultyChecked"){
    fd.append('department', "faculty: " + $scope.facultySelect);
  }else if ($scope.department == "clubChecked"){
    fd.append('department', "club: " + $scope.clubName);
  }else if ($scope.department == "universityChecked"){
    fd.append('department', "university");
  }
  $http({
   method: 'post',
   url: '../unifyWeb/functions/userRegistrationFunction.php',
   data: fd,
   headers: {'Content-Type': undefined},
 }).then(function successCallback(response) { 
            // Store response data
            $('#loadingModal').modal('hide');
            var top = 0;
            var duration = 600;
            if (response.data == "usernameErr") {
              $document.scrollTopAnimated(top, duration).then(function() {});
              $scope.usernameValidityStatusInfo = "username taken";
              $scope.username = "";
            } else if (response.data == "emailErr") {
              $scope.emailValidityStatusInfo = "An account already exists for entered email";
              $scope.departmentEmail = "";
            } else if (response.data == "departmentErr") {
              $scope.departmentValidityStatusInfo = "An account already exists for selected department";
            }else if (response.data == "success") {
              $('#successModal').modal('show');
              console.log("success");
            }else {
              console.log(response.data);
            }
          }, function (error){
            console.log(error.data);
          });
}




});
//validates and upload event information
uploadData.controller("validateEvent", function ($scope, $filter,$http,$window,$document){


 $scope.deleteCookies = function () {
  $window.onbeforeunload = function () {

    var cookies = $cookies.getAll();
    angular.forEach(cookies, function (index, value) {
      $cookies.remove(value);
    });
  }
}

$scope.validateEventDate = function (elm) {

  $scope.$apply(function(scope) {
   var curretDate = new Date ();
   curretDate.setHours(00,00,00,00);
   var eventDate = new Date ($scope.eventDate);

   if (eventDate<curretDate) {
    $scope.uploadFrm.eventDate.$setValidity('eventDate', false);
                //$scope.dateValidityStatus = "invalid";
                $scope.dateValidityStatusInfo = "Invalid Date";
              }else {
                $scope.uploadFrm.eventDate.$setValidity('eventDate', true);
                //$scope.dateValidityStatus = "valid";
                $scope.dateValidityStatusInfo = "";
              }
            });
}


$scope.displayEventFileName = function (elm) {

  $scope.$apply(function(scope) {
   $scope.fileName = document.getElementById('eventImage').files[0].name;
 });
}

$scope.validateCost = function (elm) {

  $scope.$apply(function(scope) {
    if ($scope.costFree == true) {
      $scope.disabledStatus = true;
      scope.eventCost = 0;
    }else {
      scope.eventCost = "";
      $scope.disabledStatus = false;
    }
  });
}

$scope.uploadEvent = function () {

  $('#loadingModal').modal('show');
  var eventImg = document.getElementById('eventImage').files[0];
  var fd = new FormData ();

  if ($scope.costFree == true ) {
    var eventCost = 0;
  }else {
    var eventCost = $scope.eventCost;
  }
  fd.append('eventName', $scope.eventName);
  fd.append('eventDate', $filter('date')($scope.eventDate, "dd-MM-yyyy"));
  fd.append('eventVenue', $scope.eventVenue);
  fd.append('eventDetails', $scope.eventDetails);
  fd.append('eventCost', eventCost);
  fd.append('startTime', $filter('date')($scope.startTime, "h:mm a"));
  fd.append('endTime', $filter('date')($scope.endTime, "h:mm a"));
  if (eventImg != undefined) { 
    fd.append('eventImg', eventImg);
  }

  $http({
   method: 'post',
   url: '../unifyWeb/functions/uploadEventFunction.php',
   data: fd,
   headers: {'Content-Type': undefined},
 }).then(function successCallback(response) { 
            // Store response data
            $('#loadingModal').modal('hide');
            var top = 0;
            var duration = 600;

            if (response.data == "imageErr") {
              $scope.imageErr = "invalid file";
            }else if (response.data == "eventCollisionErr") {
              $scope.eventCollisionErr = "Another Event Is Scheduled For The Time and Venue Selected";
              //$scope.uploadFrm.eventDate.$setValidity('eventDate', false);
              //$scope.uploadFrm.eventVenue.$setValidity('eventVenue', false);
              //$scope.uploadFrm.startTime.$setValidity('startTime', false);
              //$scope.uploadFrm.endTime.$setValidity('endTime', false);
              //$scope.validityStatus = "invalid";
              $document.scrollTopAnimated(top, duration).then(function() {});
            } else if (response.data == "eventNameErr") {
              $scope.eventNameErr = "event name already exists";
              $scope.eventName = "";
              $scope.eventNameValidityStatus = "invalid";
              $document.scrollTopAnimated(top, duration).then(function() {});
            }else if (response.data == "success") {
              $scope.uploadFrm.$setPristine();
              $scope.currentRecord={};
              $document.scrollTopAnimated(top, duration).then(function() {});
              $window.location.href = '../unifyWeb/uploadEvent.php?successMsg=true';
            } else{
              console.log(response.data);
            }

          }, function (error){
            console.log(error.data);
          });

}

});

// validates and upload discout information
uploadData.controller("validateDiscount", function ($scope, $filter,$http,$window,$document){

 $scope.validateDiscountDate = function (elm) {

  $scope.$apply(function(scope) {
   var curretDate = new Date ();
   curretDate.setHours(00,00,00,00);
   var discountDate = new Date ($scope.discountDate);

   if (discountDate<curretDate) {
    $scope.uploadFrm.discountDate.$setValidity('discountDate', false);
                //$scope.dateValidityStatus = "invalid";
                $scope.dateValidityStatusInfo = "Invalid Date";
              }else {
                $scope.uploadFrm.discountDate.$setValidity('discountDate', true);
                //$scope.dateValidityStatus = "valid";
                $scope.dateValidityStatusInfo = "";
              }
            });
}

$scope.displayDiscountFileName = function (elm) {

  $scope.$apply(function(scope) {
   $scope.fileName = document.getElementById('discountImage').files[0].name;
 });
}

$scope.uploadDiscount = function () {

  $('#loadingModal').modal('show');
  var top = 0;
  var duration = 600;
  var discountImg = document.getElementById('discountImage').files[0];
  var fd = new FormData ();

  if ($scope.costFree == true ) {
    var discountCost = 0;
  }else {
    var discountCost = $scope.discountCost;
  }
  fd.append('discountName', $scope.discountName);
  fd.append('discountDate', $filter('date')($scope.discountDate, "dd-MM-yyyy"));
  fd.append('discountVenue', $scope.discountVenue);
  fd.append('discountDetails', $scope.discountDetails);
  if (discountImg != undefined) { 
            //console.log("image");
            fd.append('discountImg', discountImg);
          }

          $http({
           method: 'post',
           url: '../unifyWeb/functions/uploadDiscountFunction.php',
           data: fd,
           headers: {'Content-Type': undefined},
         }).then(function successCallback(response) { 

          $('#loadingModal').modal('hide');

          if (response.data == "imageErr") {
            $scope.imageErr = "invalid file";
          }else if (response.data == "success") { 
            $scope.uploadFrm.$setPristine(true);
            $scope.currentRecord={};
            $document.scrollTopAnimated(top, duration).then(function() {});
            $window.location.href = '../unifyWeb/uploadDiscount.php?successMsg=true';
          }else {
            console.log(response.data);
          }

        }, function (error){
          console.log(error.data);
        });


       }

     });

//creates a directive for the change password modal
uploadData.directive('myModal', function() {
 return {
   restrict: 'A',
   link: function(scope, element, attr) {
     scope.dismiss = function() {
           //element.modal('hide');
           $(element).modal('hide');
         };
       }
     } 
   });

//changes user password
uploadData.controller("changePassword", function ($scope,$timeout,$http,$window){

 $scope.passwordMatch = function (userId) {
  if ($scope.newPassword != $scope.confirmPassword) {
    $scope.newPasswordValidityStatus = "invalidTemp ng-invalid";
    $scope.confirmPasswordValidityStatus = "invalidTemp ng-invalid";
    $scope.passwordValidityStatusInfo = "Passwords Dont Match";
    $scope.newPassword= "";
    $scope.confirmPassword = "";
  }else if ($scope.newPassword == $scope.oldPassword) { 
    $scope.newPasswordValidityStatus = "invalidTemp ng-invalid";
    $scope.confirmPasswordValidityStatus = "invalidTemp ng-invalid";
    $scope.passwordValidityStatusInfo = "Create another new password";
    $scope.newPassword= "";
    $scope.confirmPassword = "";

  }else{
    $scope.changePassword(userId);
  }   
}


$scope.changePassword = function (userId) {
  var fd = new FormData ();

  fd.append('oldPassword', $scope.oldPassword);
  fd.append('newPassword', $scope.newPassword);
  $http({
   method: 'post',
   url: '../unifyWeb/functions/changePasswordFunction.php?userId=' + userId,
   data: fd,
   headers: {'Content-Type': undefined},
 }).then(function successCallback(response) { 

  if (response.data == "oldPasswordErr") {
    $scope.passwordValidityStatusInfo = "Invalid Old Password";
    $scope.oldPasswordValidityStatus = "invalidTemp ng-invalid";
    $scope.oldPassword = "";
  }else if (response.data == "success") {
    $scope.showSuccessAlert = true;
    $timeout(function() {
      $scope.showSuccessAlert = false;
      $('#changePasswordModal').modal('hide');
      $scope.dismiss();
    }, 2000);

  }else{
    console.log(response.data);
  }

}, function (error){
  console.log(error.data);
});

}

});

uploadData.controller("resetPassword", function ($scope,$timeout,$http,$window){

  $scope.validateData = function (userId,confirmation) {
    $scope.newPasswordValidityStatus = "";
    $scope.confirmPasswordValidityStatus = "";
    $scope.passwordValidityStatusInfo = "";

    if ($scope.newPassword != $scope.confirmPassword) {
      $scope.newPasswordValidityStatus = "invalidTemp ng-invalid";
      $scope.confirmPasswordValidityStatus = "invalidTemp ng-invalid";
      $scope.passwordValidityStatusInfo = "Passwords Dont Match";
      $scope.newPassword= "";
      $scope.confirmPassword = "";
    }else{
      $scope.resetPassword(userId,confirmation);
    }   
  }

  $scope.resetPassword = function (userId,confirmation) {

    $scope.passwordValidityStatusInfo = "";
    $scope.passwordValidityStatus = "";
    $('#loadingModal').modal('show');
    var fd = new FormData ();
    fd.append('newPassword', $scope.newPassword);
    fd.append('userId', userId);
    fd.append('confirmation', confirmation);

    $http({
     method: 'post',
     url: '../unifyWeb/functions/passwordRecoveryFunction.php?action=upload',
     data: fd,
     headers: {'Content-Type': undefined},
   }).then(function successCallback(response) { 
    $('#loadingModal').modal('hide');
    if (response.data == "oldPasswordErr") {
      $scope.passwordValidityStatusInfo = "Invalid Old Password";
      $scope.passwordValidityStatus = "invalidTemp ng-invalid";
    }else if (response.data == "uploadSuccess") {
      $scope.showSuccessAlert = true;
      $timeout(function() {
        $scope.showSuccessAlert = false;
        $window.location.href = '../unifyWeb/login.php';
        $scope.dismiss();
      }, 3000);

    }else{
      console.log(response.data);
    }

  }, function (error){
    console.log(error.data);
  });
 }

});

uploadData.controller("editHomeImages", function ($scope,$timeout,$http,$window){

  $scope.newUserModal = function (newUser) {
    //if (newUser) {
      $('#newUserMsgModal').modal('show');
      console.log("dfdfsdf");
    //}
  }

  $scope.initImages = function () {
    $scope.firstImage = "includes/displayHomeImage.php?imageType=firstImage";
    $scope.secondImage = "includes/displayHomeImage.php?imageType=secondImage";
    $scope.thirdImage = "includes/displayHomeImage.php?imageType=thirdImage";
  }

  $scope.retrieveImages = function () {
     $http({
          method: 'get',
          url: '../unifyWeb/functions/editHomeImagesFunction.php?marker=getImages'
        }).then(function successCallback(response) {
          // Store response data
          if (response.data) {
            
          }
        }, function (error){
          console.log(error.data);
        });

  }

  $scope.editHomeImages = function () {

    if ($scope.editImageButton == "Edit Images") {
    $scope.editImageStatus = true;
    $scope.editImageButton = "Save Selections";
  }else if ($scope.editImageButton == "Save Selections")  {
    $scope.editImageStatus = false;
    $scope.editImageButton = "Edit Images";
    $scope.uploadImages();
  }
}

$scope.displayFirstImageName = function (elm) {
  $scope.$apply(function(scope) {
   $scope.firstImageName = document.getElementById('firstImage').files[0].name;
 });
}

$scope.displaySecondImageName = function (elm) {
  $scope.$apply(function(scope) {
   $scope.secondImageName = document.getElementById('secondImage').files[0].name;
 });
}

$scope.displayThirdImageName = function (elm) {
  $scope.$apply(function(scope) {
   $scope.thirdImageName = document.getElementById('thirdImage').files[0].name;
 });
}

  $scope.uploadImages = function () {
   
  $('#loadingModal').modal('show');
  var firstImage = document.getElementById('firstImage').files[0];
  var secondImage = document.getElementById('secondImage').files[0];
  var thirdImage = document.getElementById('thirdImage').files[0];
  var fd = new FormData ();

  if (firstImage != undefined) { 
    fd.append('firstImage', firstImage);
  }
  if (secondImage != undefined) { 
    fd.append('secondImage', secondImage);
  }
  if (thirdImage != undefined) { 
    fd.append('thirdImage', thirdImage);
  }

  $http({
   method: 'post',
   url: '../unifyWeb/functions/editHomeImagesFunction.php',
   data: fd,
   headers: {'Content-Type': undefined},
 }).then(function successCallback(response) { 
            
            $('#loadingModal').modal('hide');

            if (response.data == "success") {
              $scope.showSuccessAlert = true;
              $scope.firstImageName = "";
              $scope.secondImageName = "";
              $scope.thirdImageName = "";
              $timeout(function() {
              $scope.showSuccessAlert = false;
              $window.location.href = '../unifyWeb/index.php';
            }, 3000);
            } else{
              console.log(response.data);
            }

          }, function (error){
            console.log(error.data);
          });

  }

});

var uploadData = angular.module('uploadData', ['duScroll']);

//validates and registers a new user
uploadData.controller("userRegistration", function ($scope,$http,$document) {

  $scope.$watch('department', function() {
    if ($scope.department == "facultyChecked" && $scope.facultySelect == undefined) {
      $scope.facultyValidityStatus = "invalid";
      $scope.clubValidityStatus = "valid";
    }else if ($scope.department == "clubChecked" && $scope.clubName == undefined) {
      $scope.clubValidityStatus = "invalid";
      $scope.facultyValidityStatus = "valid";
    }else{
      $scope.facultyValidityStatus = "valid";
      $scope.clubValidityStatus = "valid";
    }
  });

  $scope.validateFields = function () {

   $scope.passwordValidityStatusInfo = "";
   $scope.departmentValidityStatusInfo = "";
   $scope.usernameValidityStatusInfo = "";

   if ($scope.password != $scope.confirmPassword) {
    $scope.passwordValidityStatusInfo ="Passwords dont match.";
    $scope.password = "";
    $scope.confirmPassword = "";
  } else if ($scope.idNumber < 1000000 && ($scope.department=="studentsUnionChecked" || $scope.department == "facultyChecked" || $scope.department == "clubChecked")) {
    $scope.departmentValidityStatusInfo = "The department selected does not match Id Number entered.Change Id Number or Department.";      
  }else{
    $scope.registerUser();
  }
}

$scope.registerUser = function () {

  $('#loadingModal').modal('show');
  var fd = new FormData ();

  fd.append('firstName', $scope.firstName);
  fd.append('lastName', $scope.lastName);
  fd.append('idNumber', $scope.idNumber);
  fd.append('username', $scope.username);
  fd.append('departmentEmail', $scope.departmentEmail);
  fd.append('password', $scope.password);
  if ($scope.department == "studentsUnionChecked"){
    fd.append('department', "union");
  }else if ($scope.department == "facultyChecked"){
    fd.append('department', "faculty: " + $scope.facultySelect);
  }else if ($scope.department == "clubChecked"){
    fd.append('department', "club: " + $scope.clubName);
  }else if ($scope.department == "universityChecked"){
    fd.append('department', "university");
  }
  $http({
   method: 'post',
   url: '../unifyWeb/functions/userRegistrationFunction.php',
   data: fd,
   headers: {'Content-Type': undefined},
 }).then(function successCallback(response) { 
            // Store response data
            $('#loadingModal').modal('hide');
            var top = 0;
            var duration = 600;
            if (response.data == "usernameErr") {
              $document.scrollTopAnimated(top, duration).then(function() {});
              $scope.usernameValidityStatusInfo = "username taken";
              $scope.username = "";
            } else if (response.data == "emailErr") {
              $scope.emailValidityStatusInfo = "An account already exists for entered email";
              $scope.departmentEmail = "";
            } else if (response.data == "departmentErr") {
              $scope.departmentValidityStatusInfo = "An account already exists for selected department";
            }else if (response.data == "success") {
              $('#successModal').modal('show');
              console.log("success");
            }else {
              console.log(response.data);
            }
          }, function (error){
            console.log(error.data);
          });
}




});
//validates and upload event information
uploadData.controller("validateEvent", function ($scope, $filter,$http,$window,$document){


 $scope.deleteCookies = function () {
  $window.onbeforeunload = function () {

    var cookies = $cookies.getAll();
    angular.forEach(cookies, function (index, value) {
      $cookies.remove(value);
    });
  }
}

$scope.validateEventDate = function (elm) {

  $scope.$apply(function(scope) {
   var curretDate = new Date ();
   curretDate.setHours(00,00,00,00);
   var eventDate = new Date ($scope.eventDate);

   if (eventDate<curretDate) {
    $scope.uploadFrm.eventDate.$setValidity('eventDate', false);
                //$scope.dateValidityStatus = "invalid";
                $scope.dateValidityStatusInfo = "Invalid Date";
              }else {
                $scope.uploadFrm.eventDate.$setValidity('eventDate', true);
                //$scope.dateValidityStatus = "valid";
                $scope.dateValidityStatusInfo = "";
              }
            });
}


$scope.displayEventFileName = function (elm) {

  $scope.$apply(function(scope) {
   $scope.fileName = document.getElementById('eventImage').files[0].name;
 });
}

$scope.validateCost = function (elm) {

  $scope.$apply(function(scope) {
    if ($scope.costFree == true) {
      $scope.disabledStatus = true;
      scope.eventCost = 0;
    }else {
      scope.eventCost = "";
      $scope.disabledStatus = false;
    }
  });
}

$scope.uploadEvent = function () {

  $('#loadingModal').modal('show');
  var eventImg = document.getElementById('eventImage').files[0];
  var fd = new FormData ();

  if ($scope.costFree == true ) {
    var eventCost = 0;
  }else {
    var eventCost = $scope.eventCost;
  }
  fd.append('eventName', $scope.eventName);
  fd.append('eventDate', $filter('date')($scope.eventDate, "dd-MM-yyyy"));
  fd.append('eventVenue', $scope.eventVenue);
  fd.append('eventDetails', $scope.eventDetails);
  fd.append('eventCost', eventCost);
  fd.append('startTime', $filter('date')($scope.startTime, "h:mm a"));
  fd.append('endTime', $filter('date')($scope.endTime, "h:mm a"));
  if (eventImg != undefined) { 
    fd.append('eventImg', eventImg);
  }

  $http({
   method: 'post',
   url: '../unifyWeb/functions/uploadEventFunction.php',
   data: fd,
   headers: {'Content-Type': undefined},
 }).then(function successCallback(response) { 
            // Store response data
            $('#loadingModal').modal('hide');
            var top = 0;
            var duration = 600;

            if (response.data == "imageErr") {
              $scope.imageErr = "invalid file";
            }else if (response.data == "eventCollisionErr") {
              $scope.eventCollisionErr = "Another Event Is Scheduled For The Time and Venue Selected";
              //$scope.uploadFrm.eventDate.$setValidity('eventDate', false);
              //$scope.uploadFrm.eventVenue.$setValidity('eventVenue', false);
              //$scope.uploadFrm.startTime.$setValidity('startTime', false);
              //$scope.uploadFrm.endTime.$setValidity('endTime', false);
              //$scope.validityStatus = "invalid";
              $document.scrollTopAnimated(top, duration).then(function() {});
            } else if (response.data == "eventNameErr") {
              $scope.eventNameErr = "event name already exists";
              $scope.eventName = "";
              $scope.eventNameValidityStatus = "invalid";
              $document.scrollTopAnimated(top, duration).then(function() {});
            }else if (response.data == "success") {
              $scope.uploadFrm.$setPristine();
              $scope.currentRecord={};
              $document.scrollTopAnimated(top, duration).then(function() {});
              $window.location.href = '../unifyWeb/uploadEvent.php?successMsg=true';
            } else{
              console.log(response.data);
            }

          }, function (error){
            console.log(error.data);
          });

}

});

// validates and upload discout information
uploadData.controller("validateDiscount", function ($scope, $filter,$http,$window,$document){

 $scope.validateDiscountDate = function (elm) {

  $scope.$apply(function(scope) {
   var curretDate = new Date ();
   curretDate.setHours(00,00,00,00);
   var discountDate = new Date ($scope.discountDate);

   if (discountDate<curretDate) {
    $scope.uploadFrm.discountDate.$setValidity('discountDate', false);
                //$scope.dateValidityStatus = "invalid";
                $scope.dateValidityStatusInfo = "Invalid Date";
              }else {
                $scope.uploadFrm.discountDate.$setValidity('discountDate', true);
                //$scope.dateValidityStatus = "valid";
                $scope.dateValidityStatusInfo = "";
              }
            });
}

$scope.displayDiscountFileName = function (elm) {

  $scope.$apply(function(scope) {
   $scope.fileName = document.getElementById('discountImage').files[0].name;
 });
}

$scope.uploadDiscount = function () {

  $('#loadingModal').modal('show');
  var top = 0;
  var duration = 600;
  var discountImg = document.getElementById('discountImage').files[0];
  var fd = new FormData ();

  if ($scope.costFree == true ) {
    var discountCost = 0;
  }else {
    var discountCost = $scope.discountCost;
  }
  fd.append('discountName', $scope.discountName);
  fd.append('discountDate', $filter('date')($scope.discountDate, "dd-MM-yyyy"));
  fd.append('discountVenue', $scope.discountVenue);
  fd.append('discountDetails', $scope.discountDetails);
  if (discountImg != undefined) { 
            //console.log("image");
            fd.append('discountImg', discountImg);
          }

          $http({
           method: 'post',
           url: '../unifyWeb/functions/uploadDiscountFunction.php',
           data: fd,
           headers: {'Content-Type': undefined},
         }).then(function successCallback(response) { 

          $('#loadingModal').modal('hide');

          if (response.data == "imageErr") {
            $scope.imageErr = "invalid file";
          }else if (response.data == "success") { 
            $scope.uploadFrm.$setPristine(true);
            $scope.currentRecord={};
            $document.scrollTopAnimated(top, duration).then(function() {});
            $window.location.href = '../unifyWeb/uploadDiscount.php?successMsg=true';
          }else {
            console.log(response.data);
          }

        }, function (error){
          console.log(error.data);
        });


       }

     });

//creates a directive for the change password modal
uploadData.directive('myModal', function() {
 return {
   restrict: 'A',
   link: function(scope, element, attr) {
     scope.dismiss = function() {
           //element.modal('hide');
           $(element).modal('hide');
         };
       }
     } 
   });

//changes user password
uploadData.controller("changePassword", function ($scope,$timeout,$http,$window){

 $scope.passwordMatch = function (userId) {
  if ($scope.newPassword != $scope.confirmPassword) {
    $scope.newPasswordValidityStatus = "invalidTemp ng-invalid";
    $scope.confirmPasswordValidityStatus = "invalidTemp ng-invalid";
    $scope.passwordValidityStatusInfo = "Passwords Dont Match";
    $scope.newPassword= "";
    $scope.confirmPassword = "";
  }else if ($scope.newPassword == $scope.oldPassword) { 
    $scope.newPasswordValidityStatus = "invalidTemp ng-invalid";
    $scope.confirmPasswordValidityStatus = "invalidTemp ng-invalid";
    $scope.passwordValidityStatusInfo = "Create another new password";
    $scope.newPassword= "";
    $scope.confirmPassword = "";

  }else{
    $scope.changePassword(userId);
  }   
}


$scope.changePassword = function (userId) {
  var fd = new FormData ();

  fd.append('oldPassword', $scope.oldPassword);
  fd.append('newPassword', $scope.newPassword);
  $http({
   method: 'post',
   url: '../unifyWeb/functions/changePasswordFunction.php?userId=' + userId,
   data: fd,
   headers: {'Content-Type': undefined},
 }).then(function successCallback(response) { 

  if (response.data == "oldPasswordErr") {
    $scope.passwordValidityStatusInfo = "Invalid Old Password";
    $scope.oldPasswordValidityStatus = "invalidTemp ng-invalid";
    $scope.oldPassword = "";
  }else if (response.data == "success") {
    $scope.showSuccessAlert = true;
    $timeout(function() {
      $scope.showSuccessAlert = false;
      $('#changePasswordModal').modal('hide');
      $scope.dismiss();
    }, 2000);

  }else{
    console.log(response.data);
  }

}, function (error){
  console.log(error.data);
});

}

});

uploadData.controller("resetPassword", function ($scope,$timeout,$http,$window){

  $scope.validateData = function (userId,confirmation) {
    $scope.newPasswordValidityStatus = "";
    $scope.confirmPasswordValidityStatus = "";
    $scope.passwordValidityStatusInfo = "";

    if ($scope.newPassword != $scope.confirmPassword) {
      $scope.newPasswordValidityStatus = "invalidTemp ng-invalid";
      $scope.confirmPasswordValidityStatus = "invalidTemp ng-invalid";
      $scope.passwordValidityStatusInfo = "Passwords Dont Match";
      $scope.newPassword= "";
      $scope.confirmPassword = "";
    }else{
      $scope.resetPassword(userId,confirmation);
    }   
  }

  $scope.resetPassword = function (userId,confirmation) {

    $scope.passwordValidityStatusInfo = "";
    $scope.passwordValidityStatus = "";
    $('#loadingModal').modal('show');
    var fd = new FormData ();
    fd.append('newPassword', $scope.newPassword);
    fd.append('userId', userId);
    fd.append('confirmation', confirmation);

    $http({
     method: 'post',
     url: '../unifyWeb/functions/passwordRecoveryFunction.php?action=upload',
     data: fd,
     headers: {'Content-Type': undefined},
   }).then(function successCallback(response) { 
    $('#loadingModal').modal('hide');
    if (response.data == "oldPasswordErr") {
      $scope.passwordValidityStatusInfo = "Invalid Old Password";
      $scope.passwordValidityStatus = "invalidTemp ng-invalid";
    }else if (response.data == "uploadSuccess") {
      $scope.showSuccessAlert = true;
      $timeout(function() {
        $scope.showSuccessAlert = false;
        $window.location.href = '../unifyWeb/login.php';
        $scope.dismiss();
      }, 3000);

    }else{
      console.log(response.data);
    }

  }, function (error){
    console.log(error.data);
  });
 }

});

uploadData.controller("editHomeImages", function ($scope,$timeout,$http,$window){

  $scope.initImages = function () {
    $scope.firstImage = "includes/displayHomeImage.php?imageType=firstImage";
    $scope.secondImage = "includes/displayHomeImage.php?imageType=secondImage";
    $scope.thirdImage = "includes/displayHomeImage.php?imageType=thirdImage";
  }

  $scope.retrieveImages = function () {
     $http({
          method: 'get',
          url: '../unifyWeb/functions/editHomeImagesFunction.php?marker=getImages'
        }).then(function successCallback(response) {
          // Store response data
          if (response.data) {
            
          }
        }, function (error){
          console.log(error.data);
        });

  }

  $scope.editHomeImages = function () {

    if ($scope.editImageButton == "Edit Images") {
    $scope.editImageStatus = true;
    $scope.editImageButton = "Save Selections";
  }else if ($scope.editImageButton == "Save Selections")  {
    $scope.editImageStatus = false;
    $scope.editImageButton = "Edit Images";
    $scope.uploadImages();
  }
}

$scope.displayFirstImageName = function (elm) {
  $scope.$apply(function(scope) {
   $scope.firstImageName = document.getElementById('firstImage').files[0].name;
 });
}

$scope.displaySecondImageName = function (elm) {
  $scope.$apply(function(scope) {
   $scope.secondImageName = document.getElementById('secondImage').files[0].name;
 });
}

$scope.displayThirdImageName = function (elm) {
  $scope.$apply(function(scope) {
   $scope.thirdImageName = document.getElementById('thirdImage').files[0].name;
 });
}

  $scope.uploadImages = function () {
   
  $('#loadingModal').modal('show');
  var firstImage = document.getElementById('firstImage').files[0];
  var secondImage = document.getElementById('secondImage').files[0];
  var thirdImage = document.getElementById('thirdImage').files[0];
  var fd = new FormData ();

  if (firstImage != undefined) { 
    fd.append('firstImage', firstImage);
  }
  if (secondImage != undefined) { 
    fd.append('secondImage', secondImage);
  }
  if (thirdImage != undefined) { 
    fd.append('thirdImage', thirdImage);
  }

  $http({
   method: 'post',
   url: '../unifyWeb/functions/editHomeImagesFunction.php',
   data: fd,
   headers: {'Content-Type': undefined},
 }).then(function successCallback(response) { 
            
            $('#loadingModal').modal('hide');

            if (response.data == "success") {
              $scope.showSuccessAlert = true;
              $scope.firstImageName = "";
              $scope.secondImageName = "";
              $scope.thirdImageName = "";
              $timeout(function() {
              $scope.showSuccessAlert = false;
              $window.location.href = '../unifyWeb/index.php';
            }, 3000);
            } else{
              console.log(response.data);
            }

          }, function (error){
            console.log(error.data);
          });

  }

});

uploadData.controller("contactUs", function ($scope,$timeout,$http,$window){

  $scope.sendAdminMsg = function () {
    $('#loadingModal').modal('show');
    var fd = new FormData ();
    fd.append('email', $scope.email);
    fd.append('subject', $scope.subject);
    fd.append('userMsg', $scope.userMsg);
    fd.append('name', $scope.name);

    $http({
     method: 'post',
     url: '../unifyWeb/functions/manageMsgFunction.php?marker=sendAdminMsg',
     data: fd,
     headers: {'Content-Type': undefined},
   }).then(function successCallback(response) { 

    $('#loadingModal').modal('hide');
    if (response.data == "success") {
      $scope.showSuccessAlert = true;
       $timeout(function() {
       $scope.showSuccessAlert = false;
      }, 3000);
    }else{
      console.log(response.data);
    }


  }, function (error){
    console.log(error.data);
  });
  }


});