'use strict';

/* Directives */


angular.module('bitcoinDice.directives')
.directive('updateBodyClass',['$rootScope', function($rootScope) {
  return {
    link: function(scope, element) {

      var listener = function(event, toState, toParams, fromState, fromParams) {
        var bodyClass = '';
        if (toState.data && toState.data.bodyClass) bodyClass = toState.data.bodyClass;
        element.removeClass(element.attr('class')).addClass(bodyClass)
      };

      $rootScope.$on('$stateChangeStart', listener);
    }
  }
}]);