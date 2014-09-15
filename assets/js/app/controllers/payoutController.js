'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('payoutController',['$scope', '$rootScope', 'appConfig', function($scope, $rootScope, appConfig){
  $scope.hands =appConfig.hands;
}])

