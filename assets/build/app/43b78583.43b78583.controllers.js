'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers', [])
  .controller('AppCtrl', ['$scope', 'user', function($scope, user) {
  	$scope.user = user.data;
  }])
  .controller('MyCtrl2', ['$scope', function($scope) {

  }]);
