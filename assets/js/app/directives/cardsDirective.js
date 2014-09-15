'use strict';

/* Directives */


angular.module('bitcoinDice.directives')
.directive('cardsDirective',['$rootScope', '$timeout', '$interval', 'blockUI', function($rootScope, $timeout, $interval, blockUI) {
  return  {
    restrict: 'E',
    replace: 'false',
    templateUrl: 'cardsTemplate',
      //replace: true,
      link: function link(scope, element, attributes) {

        scope.toggleHold = function(card) {
          var myBlock = blockUI.instances.get('card_'+card);

          if(myBlock.state().blocking) {
            remove(scope.held_cards, card);
            myBlock.stop();
          } else {
            
            myBlock.start('Held');
            scope.held_cards.push(card);
          }
        } 

        scope.drawCards = function(){
          blank_cards();
          scope.draw(function(){
            scope.held_cards = [];
            var blocks = blockUI.instances.get();
            blocks.stop();
          });
        }

        function remove(arr, item) {
          var i;
          while((i = arr.indexOf(item)) !== -1) {
            arr.splice(i, 1);
          }
        }

        function blank_cards(){
          var items = element.children().children().children('a.card');
          angular.forEach(items, function(value, key){
            if($.inArray(key+1, scope.held_cards) === -1) { 
              $(value).removeClass($(value).attr('class')).addClass('card back');
            }
          })
        }

        scope.$watch('cards',
          function (newVal) {
            if(typeof newVal != 'undefined') {
            var card_array = element.children().children().children('a'),
            cards = [];
            (function myLoop (i) {          
               setTimeout(function () {   
                  
                  var card = $('#card_'+i);
                  var value = newVal['card_'+parseFloat(i)];

                  if(value == null) {
                    var suit = 'back',
                    rank = '-',
                    suit_html = 'back';
                  } else if(value == 'JK') {
                    var suit = 'joker',
                    rank = '-',
                    suit_html = 'joker';
                  } else {
                    var suit = value.slice(-1);
                    var rank = value.replace(suit, '');
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

                  

                  card.removeClass(card.attr('class')).addClass('card rank-'+rank.toLowerCase()+' '+ suit_html);
                  card.children('.rank').html(rank);
                  card.children('.suit').html('&'+suit_html+';');  
                  i++        //  your code here                
                  if (i<=5) myLoop(i);      //  decrement i and call myLoop again if i > 0
               }, 250)
            })(1);
            }
                
            
            
          }
        );
      }
    }
  }])