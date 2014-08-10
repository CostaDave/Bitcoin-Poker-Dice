'use strict';

/* Directives */


angular.module('bitcoinDice.directives', []).
directive('appVersion', ['version', function(version) {
	return function(scope, elm, attrs) {
		elm.text(version);
	};
}])

.directive('addressQrCode', function(){
	return {
		restrict: 'E',
		replace: false,
		template: '',
		// scope: {
		// 	address: '@address'
		// },
		link: function link(scope, element, attrs) {
      element.qrcode({
        render:'canvas',
        color: '#FFFFFFF',
        text: 'bitcoin:'+scope.user.address,
        size: 200
      });
    }
  }
}).directive('singleDie', function(){
  return {
    restrict: 'E',
    templateUrl: 'dieTemplate',
    scope: {
      dice: '=',
      size: '='
    },
    
    link: function(scope, element, attributes) {
      scope.$watch('dice', function(){
        if(typeof scope.dice != 'undefined')
        scope.diceValue= scope.dice;
      })
    }
  }
})
.directive('diceDirective',['$rootScope', 'diceService', '$timeout', '$interval', function($rootScope, diceService, $timeout, $interval) {
	return  {
		restrict: 'E',
		replace: 'false',
		templateUrl: 'diceTemplate',
      //replace: true,
      link: function link(scope, element, attributes) {

      	scope.$watch('dice',
          function (newVal) {
            var all_dice = element.find('.dice');
            var rolling_dice = [];
            angular.forEach(all_dice, function(v,k){
              var id = $(v).attr('id');
              if (!$('#'+id).hasClass('selected')) {
                rolling_dice.push(v.id);
              }
            })

            $(rolling_dice.join(',#')).jrumble().trigger('startRumble');

            var dice_array = ['9','10','J','Q','K','A'];
            var shuffle = $interval(function() {
              angular.forEach(rolling_dice, function(v,k){
                var rand = dice_array[Math.floor(Math.random()*dice_array.length)];
                $('#'+v).removeClass($('#'+v).attr('class')).addClass('dice dice-'+rand.toLowerCase());
              })
            }, 100);


            var rolling = $timeout(function() {
              all_dice.jrumble().trigger('stopRumble');
              $interval.cancel(shuffle);
              angular.forEach(scope.dice, function(v,k){
                var oldClass = $('#'+k).attr('class').replace('selected','');
                $('#'+k).removeClass(oldClass).addClass('dice dice-'+v.toLowerCase());
              })
            }, 500);
          }
        );
      }
    }
  }])
.directive("customSort", function() {
return {
    restrict: 'A',
    transclude: true,    
    scope: {
      order: '=',
      sort: '='
    },
    template : 
      ' <a ng-click="sort_by(order)" style="color: #555555;">'+
      '    <span ng-transclude></span>'+
      '    <i ng-class="selectedCls(order)"></i>'+
      '</a>',
    link: function(scope) {
                
    // change sorting order
    scope.sort_by = function(newSortingOrder) {       
        var sort = scope.sort;
        
        if (sort.sortingOrder == newSortingOrder){
            sort.reverse = !sort.reverse;
        }                    

        sort.sortingOrder = newSortingOrder;        
    };
    
   
    // scope.selectedCls = function(column) {
    //     if(column == scope.sort.sortingOrder){
    //         return ('icon-chevron-' + ((scope.sort.reverse) ? 'down' : 'up'));
    //     }
    //     else{            
    //         return'icon-sort' 
    //     } 
    // };      
  }// end link
}
});;