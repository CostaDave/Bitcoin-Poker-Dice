'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('affiliateController',['$scope', '$rootScope', 'user', 'appConfig', function($scope, $rootScope, user, appConfig){
  $scope.user = user;
  $scope.config =appConfig;
}])

