'use strict';

/* Directives */


angular.module('bitcoinDice.directives')
.directive('diceDirective',['$rootScope', '$timeout', '$interval', function($rootScope, $timeout, $interval) {
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