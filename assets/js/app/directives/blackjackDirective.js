'use strict';

/* Directives */


angular.module('bitcoinDice.directives')
.directive('blackjackDirective',['$rootScope', '$timeout', '$interval', 'blockUI', function($rootScope, $timeout, $interval, blockUI) {
  return  {
    restrict: 'E',
    replace: 'true',
    templateUrl: 'blackjackTemplate',
      //replace: true,
      link: function link(scope, element, attributes) {

        
    }
  }
}])