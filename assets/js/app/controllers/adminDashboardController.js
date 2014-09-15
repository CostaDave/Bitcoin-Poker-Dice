'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('adminDashboardController',['$scope', '$rootScope', 'games', 'users', 'adminData', 'ngTableParams', function($scope, $rootScope, games, users, adminData, ngTableParams){

  $scope.adminData = adminData;
  var gameData = games;
  var userData = users;

  $scope.gameTableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10           // count per page
      }, {
        total: gameData.length, // length of data
        getData: function($defer, params) {
          $defer.resolve(gameData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
      });

  $scope.userTableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10           // count per page
      }, {
        total: userData.length, // length of data
        getData: function($defer, params) {
          $defer.resolve(userData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
      });
}])