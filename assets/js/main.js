var uploadData = angular.module('uploadData', ['duScroll']);

//validates and upload event information
uploadData.controller("validateEvent", function ($scope, $filter,$http,$window,$document){

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
            console.log("working");
             if ($scope.costFree == true) {
                $scope.disabledStatus = true;
                //$scope.uploadFrm.eventCost.$setValidity('eventCost', true);
             }else {
                $scope.disabledStatus = false;
             }
        });
    }

    $scope.uploadEvent = function () {

        //console.log('working');

        var eventImg = document.getElementById('eventImage').files[0];
        var fd = new FormData ();

        var dateNumbers = $filter('date')($scope.eventDate, "dd-MM-yyyy"); 

        if ($scope.costFree == true ) {
            var eventCost = 0;
        }else {
            var eventCost = $scope.eventCost;
        }
        fd.append('eventName', $scope.eventName);
        fd.append('eventDate', dateNumbers);
        fd.append('eventVenue', $scope.eventVenue);
        fd.append('eventDetails', $scope.eventDetails);
        fd.append('eventCost', eventCost);
        fd.append('startTime', $scope.startTime);
        fd.append('endTime', $scope.endTime);
        if (eventImg != undefined) { 
            //console.log("image");
            fd.append('eventImg', eventImg);
        }

        $http({
           method: 'post',
           url: '../unifyWeb/functions/uploadEventFunction.php',
           data: fd,
           headers: {'Content-Type': undefined},
        }).then(function successCallback(response) { 
            // Store response data
            var top = 0;
            var duration = 600;

            if (response.data == "imageErr") {
                $scope.imageErr = "invalid file";
            }else if (response.data == "eventCollisionErr") {
                $scope.eventCollisionErr = "Another Event Is Already Scheduled For Specified Date & Time";
                $scope.uploadFrm.eventDate.$setValidity('eventDate', false);
                $scope.uploadFrm.startTime.$setValidity('startTime', false);
                $scope.uploadFrm.endTime.$setValidity('endTime', false);
                 $document.scrollTopAnimated(top, duration).then(function() {
                    //console.log('You just scrolled to the top!');
                });
            } else if (response.data == "eventNameErr") {
                $scope.eventNameErr = "event name already exists";
                $scope.eventName = "";
                $scope.eventNameValidityStatus = "invalid";
                //$scope.uploadFrm.eventName.$setValidity('eventName', false);
                //$scope.uploadFrm.eventName.$setUntouched();
                 $document.scrollTopAnimated(top, duration).then(function() {
                     //console.log('You just scrolled to the top!');
                 });
            }else {
                console.log(response.data);
            }
            //$scope.info = response.data;
             //$window.scrollTo(0, $scope.eventImage);
            
        }, function (error){
            //$scope.response = error.data;
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

        //console.log('working');

        var discountImg = document.getElementById('discountImage').files[0];
        var fd = new FormData ();

        var dateNumbers = $filter('date')($scope.discountDate, "dd-MM-yyyy"); 

        if ($scope.costFree == true ) {
            var discountCost = 0;
        }else {
            var discountCost = $scope.discountCost;
        }
        fd.append('discountName', $scope.discountName);
        fd.append('discountDate', dateNumbers);
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

            if (response.data == "imageErr") {
                $scope.imageErr = "invalid file";
            }else {
                console.log(response.data);
            }
            //$scope.info = response.data;
             //$window.scrollTo(0, $scope.eventImage);
            
        }, function (error){
            //$scope.response = error.data;
            console.log(error.data);
        });


    }

});

//gets data from mysql database and manages it
var manageData = angular.module('manageData', ['duScroll']);
manageData.controller("manageDataController", function ($scope, $http) {


    $http.get("getMysqlDataWeb.php").then(function (data) {
        $scope.info = data;
        //alert (JSON.stringify(data));

    });


});