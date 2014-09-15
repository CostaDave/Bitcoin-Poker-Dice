'use strict';

/* Directives */


angular.module('bitcoinDice.directives')
.directive('updateTitle',['$rootScope', function($rootScope) {
  return {
    link: function(scope, element) {

      var listener = function(event, toState, toParams, fromState, fromParams) {
        console.log(toState);
        var title = 'Default Title';
        if (toState.data && toState.data.pageTitle) title = toState.data.pageTitle;
        element.text(title)
      };

      $rootScope.$on('$stateChangeStart', listener);
    }
  }
}]);