'use strict';

/* Directives */


angular.module('bitcoinDice.directives')
.directive('cardDirective',['$rootScope', '$timeout', '$interval', function($rootScope, $timeout, $interval) {
	return  {
		restrict: 'E',
		replace: 'true',
		templateUrl: 'cardTemplate',
		scope: {},
    //replace: true,
    link: function link(scope, element, attr) {
    	scope.cards = [];
    	$rootScope.$watch('bj.'+attr.player+'_cards', function(val){
    		console.log('cards changing', attr.player, val)
    		for(var i=0;i<val.length;i++){
    			if(val[i] == null) {
    				var suit = 'back',
    				rank = '',
    				suit_html = 'back';
    			} else {
    				var suit = val[i].slice(-1);
    				var rank = val[i].replace(suit, '');
    				switch(suit) {
    					case 'D' :
    					var suit_html = 'diams';
    					break;
    					case 'S' :
    					var suit_html = 'spades';
    					break;
    					case 'C' :
    					var suit_html = 'clubs';
    					break;
    					case 'H' :
    					var suit_html = 'hearts';
    					break;
    				}
    			}
    			scope.cards.push({rank:rank,suit:suit_html});
    		}
    		//console.log(scope)
    	})

    }
  }
}])