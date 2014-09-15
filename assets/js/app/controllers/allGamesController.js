'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('allGamesController',['$scope', '$rootScope', '$interval', '$filter', 'api', function ($scope, $rootScope, $interval, $filter, api) {

  $scope.items = null;

  $scope.reload_games = function(){
    api.getAllGames().then(function(data){
      $scope.items = data;
    });
  };         

  $scope.reload_games();

  var pollTimer = $interval($scope.reload_games(),60000)


}])