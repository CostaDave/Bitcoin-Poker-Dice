'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('blackjackController',['$scope', '$rootScope', '$interval', '$filter', 'user', 'vpApi', 'appConfig', 'pageConfig', 'lang', 'blockUI', function ($scope, $rootScope, $interval, $filter, user, vpApi, appConfig, pageConfig, lang, blockUI) {

  $rootScope.bj = [];
  $rootScope.bj.player_cards = [];
  $rootScope.bj.dealer_cards = [];

  $scope.hit = function(){
    console.log('hitting')
    $rootScope.bj.player_cards.push('10C');
    //$rootScope.$apply();
    console.log($rootScope.bj)
  }


  function initGame() {
    $rootScope.bj.player_cards.push('AS');
    $rootScope.bj.player_cards.push('10D');

    $rootScope.bj.dealer_cards.push('AH');
    $rootScope.bj.dealer_cards.push(null);
  }

  initGame();

}])