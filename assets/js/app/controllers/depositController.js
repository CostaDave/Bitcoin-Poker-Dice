'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('depositController',['$scope', '$rootScope','lang', 'user', 'appConfig', function($scope, $rootScope, lang, user, appConfig){
  $scope.lang = lang;
  $scope.user = user;
  $scope.demo_mode = appConfig.demo_mode;

  $scope.withdraw_address = '';
  $scope.withdraw_amount = 0;

  $scope.items = false;

  $scope.sort = {       
    sortingOrder : 'id',
    reverse : true
  };

  $scope.gap = 5;

  $scope.groupedItems = [];
  $scope.itemsPerPage = 50;
  $scope.pagedItems = [];
  $scope.currentPage = 0;

  $scope.search = function () {
    $scope.filteredItems = $filter('filter')($scope.items, function (item) {
      for(var attr in item) {

        if (searchMatch(item[attr], $scope.query))
          return true;
      }
      return false;
    });


    if ($scope.sort.sortingOrder !== '') {
      $scope.filteredItems = $filter('orderBy')($scope.filteredItems, $scope.sort.sortingOrder, $scope.sort.reverse);
    }
    $scope.currentPage = 0;

    $scope.groupToPages();
  };

  var searchMatch = function (haystack, needle) {
    if (!needle) {
      return true;
    }
    return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
  };

    // init the filtered items
    


    // calculate page in place
    $scope.groupToPages = function () {
      $scope.pagedItems = [];

      for (var i = 0; i < $scope.filteredItems.length; i++) {
        if (i % $scope.itemsPerPage === 0) {
          $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)] = [ $scope.filteredItems[i] ];
        } else {
          $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)].push($scope.filteredItems[i]);
        }
      }
    };
    
    $scope.range = function (size,start, end) {
      var ret = [];        
      if (size < end) {
        end = size;
        start = size-$scope.gap;
      }
      for (var i = start; i < end; i++) {
        ret.push(i);
      }                
      return ret;
    }

    $scope.prevPage = function () {
      if ($scope.currentPage > 0) {
        $scope.currentPage--;
      }
    };

    $scope.nextPage = function () {
      if ($scope.currentPage < $scope.pagedItems.length - 1) {
        $scope.currentPage++;
      }
    };

    $scope.setPage = function () {
      $scope.currentPage = this.n;
    };

    //functions have been describe process the data for display
    $rootScope.$watch('reloadWithdrawals',function(newVal){
      if(typeof newVal != 'undefined') {
        $scope.reload_withdrawals();
      }
    })


    $scope.requestWithdrawal = function(){
      api.requestWithdrawal({'address':$scope.withdraw_address, 'amount':$scope.withdraw_amount});
    }
  }])