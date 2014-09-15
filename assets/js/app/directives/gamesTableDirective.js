'use strict';

/* Directives */


angular.module('bitcoinDice.directives')
.directive('gamesTableDirective',['$rootScope','$filter', 'api', 'lang', function($rootScope, $filter, api, lang) {
  return  {
    restrict: 'E',
    replace: 'false',
    templateUrl: 'games_tableTemplate',
    scope: {
      gametype: '@',
      global: '@',
      //lang: lang
    },
      //replace: true,
      link: function link(scope, element, attributes) {
        scope.lang = lang;
        scope.items = null;

        scope.sort = {       
          sortingOrder : 'id',
          reverse : true
        };

        scope.gap = 50;

        scope.groupedItems = [];
        scope.itemsPerPage = 50;
        scope.pagedItems = [];
        scope.currentPage = 0;
        scope.search = function () {
          scope.filteredItems = $filter('filter')(scope.items, function (item) {
            for(var attr in item) {

              if (searchMatch(item[attr], scope.query))
                return true;
            }
            return false;
          });

          if (scope.sort.sortingOrder !== '') {
            scope.filteredItems = $filter('orderBy')(scope.filteredItems, scope.sort.sortingOrder, scope.sort.reverse);
          }
          scope.currentPage = 0;
        // now group by pages
        scope.groupToPages();
      };

      var searchMatch = function (haystack, needle) {
        if (!needle) {
          return true;
        }
        return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
      };

    // init the filtered items
    


    // calculate page in place
    scope.groupToPages = function () {
      scope.pagedItems = [];

      for (var i = 0; i < scope.filteredItems.length; i++) {
        if (i % scope.itemsPerPage === 0) {
          scope.pagedItems[Math.floor(i / scope.itemsPerPage)] = [ scope.filteredItems[i] ];
        } else {
          scope.pagedItems[Math.floor(i / scope.itemsPerPage)].push(scope.filteredItems[i]);
        }
      }
    };
    
    scope.range = function (size,start, end) {
      var ret = [];        
      if (size < end) {
        end = size;
        start = size-scope.gap;
      }
      for (var i = start; i < end; i++) {
        ret.push(i);
      }                
      return ret;
    }

    scope.prevPage = function () {
      if (scope.currentPage > 0) {
        scope.currentPage--;
      }
    };

    scope.nextPage = function () {
      if (scope.currentPage < scope.pagedItems.length - 1) {
        scope.currentPage++;
      }
    };

    scope.setPage = function () {
      scope.currentPage = this.n;
    };


    scope.reload_games = function(){

      api.getGamesTables(scope.gametype, scope.global).then(function(data){

        scope.items = data;
        scope.search();
      });

      //scope.search();  

    };         

    scope.reload_games();
  }
}
}])