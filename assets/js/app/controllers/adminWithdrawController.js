'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('adminWithdrawController',['$scope', '$rootScope', '$modal', 'withdrawals', 'pendingWithdrawals', 'ngTableParams', 'adminApi', function($scope, $rootScope,$modal, withdrawals, pendingWithdrawals, ngTableParams, adminApi){
  var all_wd = withdrawals.withdrawals;
  var pending_wd = pendingWithdrawals.withdrawals;
  $scope.pending_sum = 0;
  $scope.pening_total = 0;
  $scope.allTableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10           // count per page
      }, {
        total: data.length, // length of data
        getData: function($defer, params) {
          $defer.resolve(all_wd.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
      });

  $scope.pendingTableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10           // count per page
      }, {
        total: pending_wd.length, // length of data
        getData: function($defer, params) {
          $defer.resolve(pending_wd.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
      });

  $scope.checkboxes = {items: {} };

    // watch for check all checkbox
    $scope.$watch('checkboxes.checked', function(value) {
      console.log('echking all')
      angular.forEach(pending_wd, function(item) {
        if (angular.isDefined(item.id)) {
          $scope.checkboxes.items[item.id] = value;
        }
      });
    });

    // watch for data checkboxes
    $scope.$watch('checkboxes.items', function(values) {
      if (!pending_wd) {
        return;
      }
      var checked = 0, unchecked = 0, sum = 0,
      total = pending_wd.length;
      angular.forEach(pending_wd, function(item) {
        checked   +=  ($scope.checkboxes.items[item.id]) || 0;
        sum       +=  ($scope.checkboxes.items[item.id]) ? parseInt(item.value): 0;
        unchecked +=  (!$scope.checkboxes.items[item.id]) || 0;
      });
      if ((unchecked == 0) || (checked == 0)) {
        $scope.checkboxes.checked = (checked == total);
      }

      $scope.pending_sum = sum;
      $scope.pending_total = checked;
        // grayed checkbox
        angular.element(document.getElementById("select_all")).prop("indeterminate", (checked != 0 && unchecked != 0));
      }, true);

    $scope.processPending = function () {
      console.log('processing withdrawals')
      adminApi.processWithdrawals($scope.checked.items).then(function(){
        pending_wd = adminApi.getPendingWithdrawals();
      });

    }

    $scope.processWithdrawals = function(selected){
      console.log('processing', selected, $scope.pending_sum, $scope.pending_total)
      var checked = [];
      var sum = 0;
      for(var i in $scope.checkboxes.items) {
        if(i == true) {
          checked.push(i);
          sum += 1;
        }
      }
      //console.log(checked.length)
      var modalInstance = $modal.open({
        templateUrl: 'processWithdrawalsTemplate',
        controller: ['$scope', 'withdrawal_count', 'withdrawal_sum', 'selected', 'adminApi', function($scope, withdrawal_count, withdrawal_sum, selected, adminApi){
          $scope.withdrawal_count = withdrawal_count;
          $scope.withdrawal_sum = withdrawal_sum;
          $scope.processPending = function () {
            console.log('processing withdrawals')
            adminApi.processWithdrawals({withdrawals:selected}).then(function(){
              pending_wd = adminApi.getPendingWithdrawals();
            });
          }
        }],
        resolve: {
          withdrawal_count: function(){
            return $scope.pending_total;
          },
          withdrawal_sum: function(){
            return $scope.pending_sum;
          },
          selected: function(){
            return selected;
          }
        }
        
      });
    }


  }])