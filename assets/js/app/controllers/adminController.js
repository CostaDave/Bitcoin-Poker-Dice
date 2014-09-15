'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('adminController',['$scope', '$rootScope', 'adminData', function($scope, $rootScope, adminData){
  $scope.adminData = adminData;
}])