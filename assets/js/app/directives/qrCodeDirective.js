'use strict';

/* Directives */


angular.module('bitcoinDice.directives')
.directive('addressQrCode', function(){
	return {
		restrict: 'E',
		replace: false,
		template: '',
		link: function link(scope, element, attrs) {
      element.qrcode({
        render:'canvas',
        color: '#FFFFFFF',
        text: 'bitcoin:'+scope.user.address,
        size: 200
      });
    }
  }
})