'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('adminGameController',['$scope', '$rootScope', 'game', 'ngTableParams', function($scope, $rootScope, game, ngTableParams){
  console.log('loading controlelr')
  $scope.game = game;
}])