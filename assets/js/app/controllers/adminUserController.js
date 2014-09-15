'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('adminUserController',['$scope', '$rootScope', 'user', 'games', 'ngTableParams', function($scope, $rootScope, user, games, ngTableParams){
  console.log('loading controlelr')
  $scope.user = user;
  var data = games;
  $scope.tableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10           // count per page
      }, {
        total: data.length, // length of data
        getData: function($defer, params) {
          $defer.resolve(data.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
      });
}])
