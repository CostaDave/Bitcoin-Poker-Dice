'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('tranTableController',['$scope', '$rootScope', '$filter', 'api', function ($scope, $rootScope, $filter, api) {

  $scope.items = [];

  $scope.sort = {       
    sortingOrder : 'id',
    reverse : true
  };





  $scope.gap = 50;

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
        // now group by pages
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

    $scope.reload_trans = function(){
      if($scope.items == null) {
        $scope.items = transactions;
      } else {
        api.getGames().then(function(data){
          $scope.items = data;
          $scope.search();
        });
      }
      $scope.search();  
    }; 
    //functions have been describe process the data for display
    $rootScope.$watch('reloadTranTable',function(newVal){
      if(typeof newVal != 'undefined') {
        console.log('reloading table', newVal)
        $scope.reload_trans();
      }
    })

    $scope.reload_trans = function(){
      if($scope.items == null) {
       $scope.items = transactions;

     } else {
      api.getTransactions().then(function(data){

        $scope.items = data;
        $scope.search();
      });
    }
    $scope.search();  

  };         

  $scope.reload_trans();


}])