'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('accountController',['$scope', '$rootScope', 'appConfig', 'pageConfig', function($scope, $rootScope, appConfig, pageConfig){
  $scope.pageLang = pageConfig.lang;
  $scope.hands =appConfig.hands;
  $scope.open_tab = 1;

  $scope.changeTab = function(tab) {
  	$scope.open_tab = tab;
  }

}])