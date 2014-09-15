'use strict';

/* Directives */


angular.module('bitcoinDice.directives')
.directive('comingSoon', function(){
	return {
		restrict: 'C',
		replace: false,
		template: '',
		link: function link(scope, element, attrs) {
      element.backstretch([
      "/assets/img/bg/16.jpg",
      "/assets/img/bg/15.jpg",
      "/assets/img/bg/14.jpg",
      "/assets/img/bg/13.jpg",
      "/assets/img/bg/11.jpg",
      "/assets/img/bg/12.jpg"
      ], {
        fade: 1000,
        duration: 7000
    });
    }
  }
})