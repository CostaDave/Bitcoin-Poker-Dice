'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('navController',['$scope','$rootScope', 'lang', 'AuthService', 'AUTH_EVENTS', 'appConfig', function($scope, $rootScope, lang, AuthService, AUTH_EVENTS, appConfig){
  $scope.lang = lang;
  $scope.sound_muted = false;
  $scope.active_nav = '';
  $scope.items = appConfig.games_available;

  $scope.status = {
    isopen: false
  };

  $scope.toggled = function(open) {
    //console.log('Dropdown is now: ', open);
  };

  $scope.toggleDropdown = function($event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.status.isopen = !$scope.status.isopen;
  };
  $scope.toggleMute = function(dice){
    if(!$scope.sound_muted) {
      $scope.sound_muted = true;
      soundManager.mute();
    } else {
      $scope.sound_muted = false;
      soundManager.unmute();
    }
  }
}])