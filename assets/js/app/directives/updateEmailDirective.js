'use strict';

/* Directives */


angular.module('bitcoinDice.directives')
.directive('updateEmailDirective', function(){
	return {
		restrict: 'E',
		replace: false,
		template: '',
		link: function link(scope, element, attrs) {
      console.log('update emial');
    }
  }
})