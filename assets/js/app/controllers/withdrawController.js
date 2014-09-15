'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('withdrawController',['$scope', '$rootScope','$filter', 'api', 'withdrawals', 'appConfig', 'ngTableParams', function($scope, $rootScope, $filter, api, withdrawals, appConfig, ngTableParams){

  $scope.demo_mode = appConfig.demo_mode;

  var data = withdrawals;
  $scope.tableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10           // count per page
      }, {
        total: data.length, // length of data
        getData: function($defer, params) {
          $defer.resolve(data.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
      });

  $scope.checkboxes = { 'checked': false, items: {} };

  $scope.requestWithdrawal = function(){
    console.log('requesting withdrawal');
    api.requestWithdrawal({'address':$scope.withdraw_address, 'amount':$scope.withdraw_amount});
  }
  
}])