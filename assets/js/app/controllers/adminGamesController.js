'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('adminGamesController',['$scope', '$rootScope','$filter', 'games', 'ngTableParams', function($scope, $rootScope, $filter, games, ngTableParams){
  console.log('loading controlelr')
  var data = games;
  $scope.tableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10,
        
        sorting: {
            id: 'desc'     // initial sorting
        }      // count per page
      }, {
        total: data.length, // length of data
        getData: function($defer, params) {
            // use build-in angular filter
            var orderedData = params.sorting() ?
            $filter('orderBy')(data, params.orderBy()) :
            data;

            var filteredData = params.filter() ?
            $filter('filter')(data, params.filter()) :
            data;

            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
          }
        });
}])