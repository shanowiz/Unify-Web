var getData = angular.module('getData', ['duScroll']);

//authenticates a user
getData.controller("login", function ($scope, $filter,$http,$window,$document,$timeout){

 $scope.validateData = function () {
  var username = $scope.username;
  var password = $scope.password;

  if (username == undefined && password == undefined) {
    $scope.validityStatus = "invalid";
  }else {
    $scope.login(username,password);
  }
}

$scope.setValidity = function (elm) {

  $scope.$apply(function(scope) {
    $scope.loginFrm.username.$setValidity('username', true);
    $scope.loginFrm.password.$setValidity('password', true);  
  });
}

$scope.login = function (username, password) {

  $('#loadingModal').modal('show');

  var fd = new FormData ();
  fd.append('username', username);
  fd.append('password', password);

  $http({
   method: 'post',
   url: '../unifyWeb/functions/loginFunction.php',
   data: fd,
   headers: {'Content-Type': undefined},
 }).then(function successCallback(response) { 
  $('#loadingModal').modal('hide');
  if (response.data == "invalid") {
    $scope.password = "";
    $scope.validityStatus = "invalid";
    $scope.validityStatusInfo = "Check Credentials";
  } else if (response.data == "partiallyRegisteredErr") {
    $scope.password = "";
    $scope.validityStatus = "invalid";
    $scope.validityStatusInfo = "Please confirm registration from email";
  }else if (response.data == "accountLocked") {
    $scope.password = "";
    $scope.validityStatus = "invalid";
    $scope.validityStatusInfo = "Account temporarily suspended";
  }else if (response.data == "newUserSuccess") {
    alert("Please review new users!!!");
    $window.location.href = '../unifyWeb/index.php';
 }else if (response.data == "success") {
    $window.location.href = '../unifyWeb/index.php';
 }else {
  console.log(response.data);
}
}, function (error){
  console.log(error.data);
});
}

$scope.resetInputField = function () {
  $scope.validityStatus = false;
  $scope.validityStatusInfo = false;
}

$scope.sendResetLink = function () {
  $scope.showLoader = true;
  $scope.emailValidityStatusInfo = "";
  $scope.emailValidityStatus = "";
  //$('#loadingModal').modal('show');
  //$('#passwordRecoveryModal').modal('hide');
  var fd = new FormData ();
  fd.append('email', $scope.email);

  $http({
   method: 'post',
   url: '../unifyWeb/functions/passwordRecoveryFunction.php?action=sendLink',
   data: fd,
   headers: {'Content-Type': undefined},
 }).then(function successCallback(response) { 

  $scope.showLoader = false;

  if (response.data == "linkSent") {
    $scope.successMsg = "Check email";
    $timeout(function() {
      $('#passwordRecoveryModal').modal('hide');
      $scope.successMsg = false;
    }, 3000);
  }else if (response.data == "userEmailErr") {
    $scope.emailValidityStatusInfo = "email does not match our records";
    $scope.emailValidityStatus = "invalid";
  }else{
    console.log(response.data);
  }

}, function (error){
  console.log(error.data);
});
}

});

//gets data from mysql database
getData.controller("manageData", function ($scope, $http,$window,$timeout) {

  /*var screenWidth = $window.innerWidth;
  if (screenWidth < 1108){
    $scope.webScreenWidth = false;
    $scope.mobileScreenWidth = true;
  }else{
    $scope.webScreenWidth = true;
    $scope.mobileScreenWidth = false;
  }

  angular.element($window).on('resize', function () {
    var screenWidth = $window.innerWidth;

    $scope.$apply(function(scope) {
     if (screenWidth < 1108){
      $scope.webScreenWidth = false;
      $scope.mobileScreenWidth = true;
    }else{
      $scope.webScreenWidth = true;
      $scope.mobileScreenWidth = false;
    } 
  });
});*/

$scope.retrieveEvents = function () {
  $('#loadingModal').modal('show');
  $http({
    method: 'get',
    url: '../unifyWeb/functions/manageEventsFunction.php?marker=display'
  }).then(function successCallback(response) {
          // Stores response data to scope model
          if (response.data == "no events") {
            $scope.existEvent = false;
          }else {
            $scope.existEvent = true;
            $scope.info = response.data;
            $scope.eventData = response.data;
          }
        }, function (error){
          console.log(error.data);
        });
}

$scope.retrieveDiscounts = function () {
  $('#loadingModal').modal('show');
  $http({
    method: 'get',
    url: '../unifyWeb/functions/manageDiscountsFunction.php?marker=display'
  }).then(function successCallback(response) {
          // Store response data
          if (response.data == "no discounts") {
            $scope.existDiscount = false;
          }else {
            $scope.existDiscount = true;
            $scope.info = response.data;
            $scope.discountData = response.data;
          }
          $('#loadingModal').modal('hide');
        }, function (error){
          console.log(error.data);
        });
}


$scope.deleteEvent = function (id) {

  var confirmClick = confirm ("Are you sure you want to delete this event?");

  if (confirmClick) {
  eventId = id;
  $('#loadingModal').modal('show');
  $http({
    method: 'get',
    url: '../unifyWeb/functions/manageEventsFunction.php?marker=deleteEvent&id='+eventId,
  }).then(function successCallback(response) {
    console.log(response.data);
    if (response.data=="deleted successfully") {
     $('#loadingModal').modal('hide');
     $('#successModal').modal('show');
     $timeout(function() {
      $('#successModal').modal('hide');
      $window.location.href = '../unifyWeb/manageEvents.php';
      $scope.dismiss();
    }, 2000);
   }else {
    console.log(response.data);
  }
});
}
}

$scope.deleteDiscount = function (id) {

  var confirmClick = confirm ("Are you sure you want to delete this discount?");

  if (confirmClick) {
  discountId = id;
  $('#loadingModal').modal('show');
  $http({
    method: 'get',
    url: '../unifyWeb/functions/manageDiscountsFunction.php?marker=deleteDiscount&id='+discountId,
  }).then(function successCallback(response) {
    if (response.data=="deleted successfully") {
     $('#loadingModal').modal('hide');
     $('#successModal').modal('show');
     $timeout(function() {
      $('#successModal').modal('hide');
      $window.location.href = '../unifyWeb/manageDiscounts.php';
      $scope.dismiss();
    }, 2000);
   }else {
    console.log(reponse.data);
  }
});
}
}

$scope.displaySingleEvent = function (id) { 
  $('#loadingModal').modal('show');
  $http({
    method: 'get',
    url: '../unifyWeb/functions/manageEventsFunction.php?marker=display'
  }).then(function successCallback(response) {
          // Searches array of event to find the one with matching id's
          angular.forEach(response.data,function(x,index){
            if (id==x.id) {
              $scope.id = x.id;
              $scope.image = x.image;
              $scope.event = x.name;
              $scope.date = x.eventdate;
              $scope.venue = x.venue;
              $scope.details = x.details;
              $scope.cost = x.cost;
              $scope.time = x.starttime + " - " + x.endtime;
            }
          });
          $('#loadingModal').modal('hide');
        }, function (error){
          console.log(error.data);
        });
} 

$scope.displaySingleDiscount = function (id) { 
  $('#loadingModal').modal('show');
  $http({
    method: 'get',
    url: '../unifyWeb/functions/manageDiscountsFunction.php?marker=display'
  }).then(function successCallback(response) {
          // Searches array of event to find the one with matching id's
          angular.forEach(response.data,function(x,index){
            if (id==x.id) {
              $scope.id = x.id;
              $scope.image = x.image;
              $scope.discount = x.name;
              $scope.date = x.date;
              $scope.venue = x.venue;
              $scope.details = x.details;
            }
          });
          $('#loadingModal').modal('hide');
        }, function (error){
          console.log(error.data);
        });
} 

$scope.searchEvent = function () {
      //console.log($scope.searchId);
      if ($scope.searchId != undefined) { 
        $('#loadingModal').modal('show');
        var searchId = $scope.searchId;
        var resultarray = [];
        $http({
          method: 'get',
          url: '../unifyWeb/functions/manageEventsFunction.php?marker=display'
        }).then(function successCallback(response) {
          // Store response data
          if (response.data) {
            $scope.existEvent = true;
          }else {
            $scope.existEvent = false;
          }
          angular.forEach(response.data,function(x,index){
            if (searchId.toLowerCase() == x.name.toLowerCase() || searchId.toLowerCase() == x.venue.toLowerCase() || searchId.toLowerCase() == x.details.toLowerCase()) {
              resultarray.push(x);
            } else if (x.name.toLowerCase().match(searchId.toLowerCase()) || x.venue.toLowerCase().match(searchId.toLowerCase()) || x.details.toLowerCase().match(searchId.toLowerCase())){
              resultarray.push(x);
            }
          });
          if (resultarray.length>0) {
           $scope.searchResultCount = resultarray.length;
         }else{
           $scope.searchResultCount = 0;
         }
         $scope.info = resultarray;
         $('#loadingModal').modal('hide');
       }, function (error){
        console.log(error.data);
      });
      }
    }

    $scope.searchDiscount = function () {
      //console.log($scope.searchId);
      if ($scope.searchId != undefined) {
        $('#loadingModal').modal('show');
        var searchId = $scope.searchId;
        var resultarray = [];
        $http({
          method: 'get',
          url: '../unifyWeb/functions/manageDiscountsFunction.php?marker=display'
        }).then(function successCallback(response) {
          // Store response data
          if (response.data) {
            $scope.existDiscount = true;
          }else {
            $scope.existDiscount = false;
          }
          angular.forEach(response.data,function(x,index){
            if (searchId.toLowerCase() == x.name.toLowerCase() || searchId.toLowerCase() == x.venue.toLowerCase() || searchId.toLowerCase() == x.details.toLowerCase()) {
              resultarray.push(x);
            } else if (x.name.toLowerCase().match(searchId.toLowerCase()) || x.venue.toLowerCase().match(searchId.toLowerCase()) || x.details.toLowerCase().match(searchId.toLowerCase())){
              resultarray.push(x);
            }
          });
          if (resultarray.length>0) {
           $scope.searchResultCount = resultarray.length;
         }else{
           $scope.searchResultCount = 0;
         }
         $scope.info = resultarray;
         $('#loadingModal').modal('hide');
       }, function (error){
        console.log(error.data);
      });
      }
    }

  });

//valdates and upload the data the user edited
getData.controller("editEvent", function ($scope,$window,$http,$filter,$document,$timeout) {

  var eventId = "";

  $scope.retrieveEvent = function (id) {
    eventId = id;
    $http({
      method: 'get',
      url: '../unifyWeb/functions/manageEventsFunction.php?marker=display'
    }).then(function successCallback(response) {
          // selects the event to be edited from a list
          angular.forEach(response.data,function(value,index){
            if (value.id == id) {
              $scope.eventName = value.name;
              var dateArry = value.eventdate.split('-');
              var eventDate = dateArry[1]+"-"+dateArry[0]+"-"+dateArry[2];
              $scope.eventDate = new Date (eventDate); 
              $scope.eventVenue = value.venue;
              $scope.eventDetails = value.details;
              $scope.eventCost =  parseInt(value.cost); 
              $scope.startTime = value.starttime;
              $scope.endTime = value.endtime;
              $scope.eventImage = value.image;
            }
          })
          //$scope.info = response.data;
        });
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
                $scope.dateValidityStatus = "valid";
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

  $scope.validateStartTime = function (elm) {
   $scope.$apply(function(scope) {
     if ($scope.startTime != undefined) {
                //$scope.uploadFrm.startTime.$setValidity('startTime', true);
                $scope.startTimeValidityStatus = "valid";
              }
            });
 }

 $scope.validateEndTime = function (elm) {
   $scope.$apply(function(scope) {
     if ($scope.endTime != undefined) {
                //$scope.uploadFrm.endTime.$setValidity('endTime', true);
                $scope.endTimeValidityStatus = "valid";
              }
            });
 }

 $scope.editEvent = function () {

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
  fd.append('eventId', eventId);
  if (eventImg != undefined) { 
            //console.log("image");
            fd.append('eventImg', eventImg);
          }

          $http({
           method: 'post',
           url: '../unifyWeb/functions/editEventFunction.php',
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
              $scope.eventCollisionErr = "Another Event Is Already Scheduled For Specified Date & Time";
                //$scope.uploadFrm.eventDate.$setValidity('eventDate', false);
                //$scope.uploadFrm.startTime.$setValidity('startTime', false);
                //$scope.uploadFrm.endTime.$setValidity('endTime', false);
                //$scope.startTimeValidityStatus = "invalid";
                //$scope.endTimeValidityStatus = "invalid";
                //$scope.dateValidityStatus = "invalid";
                $document.scrollTopAnimated(top, duration).then(function() {});
              } else if (response.data == "eventNameErr") {
                $scope.eventNameErr = "event name already exists";
                $scope.eventName = "";
                $scope.eventNameValidityStatus = "invalid";
                $document.scrollTopAnimated(top, duration).then(function() {});
              }else if (response.data == "success") {
                $('#successModal').modal('show');
                $timeout(function() {
                  $('#successModal').modal('hide');
                  $window.location.href = '../unifyWeb/manageEvents.php';
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


getData.controller("editDiscount", function ($scope,$window,$http,$filter,$document,$timeout) {

  var eventId = "";

  $scope.retrieveDiscount = function (id) {
    eventId = id;
    $http({
      method: 'get',
      url: '../unifyWeb/functions/manageDiscountsFunction.php?marker=display'
    }).then(function successCallback(response) {
          // selects the event to be edited from a list
          angular.forEach(response.data,function(value,index){
            if (value.id == id) {
              $scope.discountName = value.name;
              var dateArry = value.date.split('-');
              var discountDate = dateArry[1]+"-"+dateArry[0]+"-"+dateArry[2];
              $scope.discountDate = new Date (discountDate); 
              $scope.discountVenue = value.venue;
              $scope.discountDetails = value.details;
              $scope.discountImage = value.image;
            }
          })
          //$scope.info = response.data;
        });
  }

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
                $scope.dateValidityStatus = "valid";
              }
            });
  }

  $scope.displayEventFileName = function (elm) {

    $scope.$apply(function(scope) {
     $scope.fileName = document.getElementById('discountImage').files[0].name;
   });
  }

  $scope.validateCost = function (elm) {

    $scope.$apply(function(scope) {
     if ($scope.costFree == true) {
      $scope.disabledStatus = true;
      if ($scope.discountCost == undefined) {
        $scope.discountCost = 0;
      }
    }else {
      if ($scope.discountCost == undefined || $scope.discountCost== 0) {
        $scope.discountCost = undefined;
      }
      $scope.disabledStatus = false;
    }
  });
  }

  $scope.editDiscount = function () {

    $('#loadingModal').modal('show');
    var discountImg = document.getElementById('discountImage').files[0];
    var fd = new FormData ();

    fd.append('discountName', $scope.discountName);
    fd.append('discountDate', $filter('date')($scope.discountDate, "dd-MM-yyyy"));
    fd.append('discountVenue', $scope.discountVenue);
    fd.append('discountDetails', $scope.discountDetails);
    if (discountImg != undefined) { 
      fd.append('discountImg', discountImg);
    }

    $http({
     method: 'post',
     url: '../unifyWeb/functions/editDiscountFunction.php?id=' + eventId,
     data: fd,
     headers: {'Content-Type': undefined},
   }).then(function successCallback(response) { 

    $('#loadingModal').modal('hide');

    if (response.data == "imageErr") {
      $scope.imageErr = "invalid file";
    }else if (response.data == "success") {
     $('#successModal').modal('show');
     $timeout(function() {
      $('#successModal').modal('hide');
      $window.location.href = '../unifyWeb/manageDiscounts.php';
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

getData.controller("manageUsers", function ($scope, $http,$window,$timeout) {
  var userId=0;

  $scope.retrieveUsers = function () {
    $('#loadingModal').modal('show');
    $http({
      method: 'get',
      url: '../unifyWeb/functions/manageUsersFunction.php?marker=display'
    }).then(function successCallback(response) {
          // Stores response data to scope model
          if (response.data == "no users") {
            $scope.existUser = false;
          }else {
            $scope.existUser = true;
            $scope.userData = response.data;
            console.log("working");
          }
        }, function (error){
          console.log(error.data);
        });
  }

  $scope.displaySingleUser = function (id) { 
    userId = id;
    $('#loadingModal').modal('show');
    $http({
      method: 'get',
      url: '../unifyWeb/functions/manageUsersFunction.php?marker=display'
    }).then(function successCallback(response) {
          // Searches array of event to find the one with matching id's
          angular.forEach(response.data,function(x,index){
            if (id==x.id) {
              $scope.id = x.id;
              $scope.username = x.username;
              $scope.firstName = x.firstname;
              $scope.lastName = x.lastname;
              $scope.department = x.department;
              $scope.departmentEmail = x.departmentemail;

              if (x.status.match("verify")){
                $scope.status = "Confirm Registration";
              }else{
                 $scope.status = x.status;
              }
              if (x.status == "locked") {
                $scope.action = "unlock";
              }else {
                $scope.action = "lock";
              }
            }
          });
          $('#loadingModal').modal('hide');
        }, function (error){
          console.log(error.data);
        });
  } 

  $scope.deleteUser = function (id) {

    var confirmClick = confirm ("Are you sure you want to delete this user?");

  if (confirmClick) {
    $('#loadingModal').modal('show');
    $http({
      method: 'get',
      url: '../unifyWeb/functions/manageUsersFunction.php?marker=deleteUser&id='+id,
    }).then(function successCallback(response) {
      if (response.data=="deleted successfully") {
        $('#loadingModal').modal('hide');
        $('#successModal').modal('show');
        $timeout(function() {
          $('#successModal').modal('hide');
          $window.location.href = '../unifyWeb/manageUsers.php';
          $scope.dismiss();
        }, 2000);
      }else {
        console.log(reponse.data);
      }
    });
  }
  }

  $scope.searchUser = function () {
      //console.log($scope.searchId);
      if ($scope.searchId != undefined) { 
        $('#loadingModal').modal('show');
        var searchId = $scope.searchId;
        var resultarray = [];
        $http({
          method: 'get',
          url: '../unifyWeb/functions/manageUsersFunction.php?marker=display'
        }).then(function successCallback(response) {
          // Store response data
          if (response.data) {
            $scope.existUser = true;
          }else {
            $scope.existUser = false;
          }
          angular.forEach(response.data,function(x,index){
            if (searchId.toLowerCase() == x.firstname.toLowerCase() || searchId.toLowerCase() == x.lastname.toLowerCase() || searchId.toLowerCase() == x.username.toLowerCase() || searchId.toLowerCase() == x.idnumber.toLowerCase() || searchId.toLowerCase() == x.departmentemail.toLowerCase() || searchId.toLowerCase() == x.department.toLowerCase()) {
              resultarray.push(x);
            } else if (x.username.toLowerCase().match(searchId.toLowerCase()) || x.idnumber.toLowerCase().match(searchId.toLowerCase()) || x.departmentemail.toLowerCase().match(searchId.toLowerCase()) || x.department.toLowerCase().match(searchId.toLowerCase())){
              resultarray.push(x);
            }
          });
          if (resultarray.length>0) {
           $scope.searchResultCount = resultarray.length;
         }else{
           $scope.searchResultCount = 0;
         }
         $scope.userData = resultarray;
         $('#loadingModal').modal('hide');
       }, function (error){
        console.log(error.data);
      });
      }
    }

    $scope.sendUserMsg = function (departmentEmail) {

      $scope.loadingWheel = true;
      var fd = new FormData ();
      fd.append('departmentEmail', departmentEmail);
      fd.append('subject', $scope.subject);
      fd.append('userMsg', $scope.userMsg);

      $http({
       method: 'post',
       url: '../unifyWeb/functions/manageMsgFunction.php?marker=sendUserMsg',
       data: fd,
       headers: {'Content-Type': undefined},
     }).then(function successCallback(response) { 
       $scope.loadingWheel = false;
       if (response.data == "emailErr") {
        console.log("email error");
      }else if (response.data == "success") {
        $scope.showSuccessAlert = true;
        $timeout(function() {
          $('#sendUserMsgModal').modal('hide');
        //$scope.dismiss();
      }, 3000);
      }else{
        console.log(response.data);
      }

    }, function (error){
      console.log(error.data);
    });
   }

   $scope.manageAccount = function () {

    var confirmClick = "";

    if ($scope.action == "lock") {
      var confirmClick = confirm ("Are you sure you want to lock this account?\nA message will be sent informing the user");
    }else if ($scope.action == "unlock") {
      var confirmClick = confirm ("Account will be unlocked!\nA message will be sent informing the user");
    }
    
    if (confirmClick) {
      $('#loadingModal').modal('show');

      var manageAccountUrl = "";
      if ($scope.action == "unlock") {
        manageAccountUrl = '../unifyWeb/functions/manageUsersFunction.php?marker=unlockAccount';
      }else if ($scope.action == "lock") {
        manageAccountUrl = '../unifyWeb/functions/manageUsersFunction.php?marker=lockAccount';
      }
      var fd = new FormData ();
      fd.append('id', $scope.id);
      fd.append('departmentEmail', $scope.departmentEmail);
      fd.append('department', $scope.department);

      console.log()

      $http({
       method: 'post',
       url: manageAccountUrl,
       data: fd,
       headers: {'Content-Type': undefined},
     }).then(function successCallback(response) { 
      $scope.displaySingleUser($scope.id);
      $('#loadingModal').modal('hide');
      if (response.data == "success") {
        $('#successModal').modal('show');
        $timeout(function() {
          $('#successModal').modal('hide');
        }, 3000);
      }else{
        console.log(response.data);
      }

    }, function (error){
      console.log(error.data);
    });
   }
 }

 /*$scope.unlockAccount = function () {
  $('#loadingModal').modal('show');
  var fd = new FormData ();
  fd.append('id', $scope.id);
  fd.append('departmentEmail', $scope.departmentEmail);
  fd.append('department', $scope.department);

  $http({
   method: 'post',
   url: '../unifyWeb/functions/manageUsersFunction.php?marker=unlockAccount',
   data: fd,
   headers: {'Content-Type': undefined},
 }).then(function successCallback(response) { 
  $('#loadingModal').modal('hide');
  if (response.data == "success") {
    $('#successModal').modal('show');
    $timeout(function() {
      $('#successModal').modal('hide');
    }, 3000);
  }else{
    console.log(response.data);
  }

}, function (error){
  console.log(error.data);
});
}*/

});

getData.controller("manageMsg", function ($scope, $http,$window,$timeout) {

  var screenWidth = $window.innerWidth;
  if (screenWidth < 1108){
    $scope.webScreenWidth = false;
    $scope.mobileScreenWidth = true;
  }else{
    $scope.webScreenWidth = true;
    $scope.mobileScreenWidth = false;
  }

  angular.element($window).on('resize', function () {
    var screenWidth = $window.innerWidth;

    $scope.$apply(function(scope) {
     if (screenWidth < 1108){
      $scope.webScreenWidth = false;
      $scope.mobileScreenWidth = true;
    }else{
      $scope.webScreenWidth = true;
      $scope.mobileScreenWidth = false;
    } 
  });
  });

  $scope.retrieveInboxMsg = function () {

    $scope.emailErr = false;
    $scope.showReplyButton = true;
    $scope.showDeleteButton = true;
    $scope.showCompose = false;
    $scope.showMsgList = true;
    $scope.inbox = true;
    $scope.sent = false;
    $scope.msgList = false;
    $scope.searchResultCount = -1;

    $('#loadingModal').modal('show');
    $http({
      method: 'get',
      url: '../unifyWeb/functions/manageMsgFunction.php?marker=displayInbox'
    }).then(function successCallback(response) {
          // Store response data
          $('#loadingModal').modal('hide');
          if (response.data == "no messages") {


          }else {
            $scope.msgList = response.data;
          }
        }, function (error){
          console.log(error.data);
        });
  }

  $scope.retrieveSentMsg = function () {

    $scope.emailErr = false;
    $scope.showReplyButton = false;
    $scope.showDeleteButton = true;
    $scope.showCompose = false;
    $scope.showMsgList = true;
    $scope.inbox = false;
    $scope.sent = true;
    $scope.msgList = false;
    $scope.searchResultCount = -1;

    
    $('#loadingModal').modal('show');
    $http({
      method: 'get',
      url: '../unifyWeb/functions/manageMsgFunction.php?marker=displaySent'
    }).then(function successCallback(response) {
          // Store response data
          $('#loadingModal').modal('hide');
          if (response.data == "no messages") {
            console.log(response.data);
          }else {
            $scope.msgList = response.data;
          }
        }, function (error){
          console.log(error.data);
        });
  }

  $scope.displayCompose = function () {

    $scope.disableField = false;
    $scope.emailErr = false;
    $scope.subject = "";
    $scope.email = "";
    $scope.userMsg = "";
    $scope.showCompose = true;
    $scope.showComposeSendButton = true;
    $scope.showReplyButton = false;
    $scope.showDeleteButton = false;
    $scope.showMsgList = false

  }

  $scope.displaySingleMsg = function (email,subject,msg,id) {

    $scope.disableField = true;
    $scope.showCompose = true;
    $scope.showMsgList = false;
    $scope.showComposeSendButton = false;
    $scope.subject = subject;
    $scope.email = email;
    $scope.userMsg = msg;
    $scope.messageId = id;

  }

  $scope.sendUserMsg = function () {
    $('#loadingModal').modal('show');
    var fd = new FormData ();
    fd.append('departmentEmail', $scope.email);
    fd.append('subject', $scope.subject);
    fd.append('userMsg', $scope.userMsg);

    $http({
     method: 'post',
     url: '../unifyWeb/functions/manageMsgFunction.php?marker=sendUserMsg',
     data: fd,
     headers: {'Content-Type': undefined},
   }).then(function successCallback(response) { 

    $('#loadingModal').modal('hide');
    if (response.data == "success") {
      $scope.showCompose = false;
      $scope.showMsgList = true;
      $scope.showSuccessAlert = true;
      $timeout(function() {
       $scope.showSuccessAlert = false;
     }, 3000);
    }if (response.data == "emailErr") {
      $scope.emailErr = "invalid"
    }else{
      console.log(response.data);
    }

  }, function (error){
    console.log(error.data);
  });
 }

 $scope.resetErrorStatus = function () {

  $scope.emailErr = false;

}

$scope.reply = function () {
  $scope.disableField = false;
  $scope.showReplyButton = false;
  $scope.showDeleteButton = false;
  $scope.showComposeSendButton = true;
  $scope.subject = "";
  $scope.userMsg = "";
}

$scope.deleteMsg = function (id) {

    //$('#loadingModal').modal('show');
    var messageId = "";

    if ($scope.messageId) {
      messageId = $scope.messageId;
    }else {
      messageId = id;
    }

    var confirmClick = confirm ("Are you sure you want to delete this message?");

    if (confirmClick) {

    var fd = new FormData ();
    fd.append('messageId', messageId);

    $http({
     method: 'post',
     url: '../unifyWeb/functions/manageMsgFunction.php?marker=deleteMsg',
     data: fd,
     headers: {'Content-Type': undefined},
   }).then(function successCallback(response) { 

    $scope.messageId=false;
    if (response.data == "success") {
      if ($scope.inbox == true) {
        $scope.retrieveInboxMsg();
      }else if ($scope.sent == true) {
        $scope.retrieveSentMsg();
      }
    }else{
      console.log(response.data);
    }

  }, function (error){
    console.log(error.data);
  });
 }

 }

 $scope.searchMsg = function () {

  var dataUrl = "";

  if ($scope.inbox) {
    dataUrl = "../unifyWeb/functions/manageMsgFunction.php?marker=displayInbox";
  }else if ($scope.sent){
    dataUrl = "../unifyWeb/functions/manageMsgFunction.php?marker=displaySent";
  }

  if ($scope.searchId != undefined) { 
    $('#loadingModal').modal('show');
    var searchId = $scope.searchId;
    var resultarray = [];
    $http({
      method: 'get',
      url: dataUrl
    }).then(function successCallback(response) {
          // Store response data
          if (response.data) {
            $scope.existMsg = true;
          }else {
            $scope.existMsg = false;
          }
          angular.forEach(response.data,function(x,index){
           if (x.departmentemail.toLowerCase().match(searchId.toLowerCase()) || x.subject.toLowerCase().match(searchId.toLowerCase()) || x.msg.toLowerCase().match(searchId.toLowerCase())){
            resultarray.push(x);
          }
        });
          if (resultarray.length>0) {
           $scope.searchResultCount = resultarray.length;
         }else{
           $scope.searchResultCount = 0;
         }
         $scope.msgList = resultarray;
         $('#loadingModal').modal('hide');
       }, function (error){
        console.log(error.data);
      });
  }
}



});

