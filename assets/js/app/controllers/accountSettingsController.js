'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('accountSettingsController', ['$scope','$rootScope','$state', '$stateParams', 'api', 'AuthService', 'AUTH_EVENTS', 'lang', 'timezones', function($scope,$rootScope, $state, $stateParams, api, AuthService, AUTH_EVENTS, lang, timezones) {
  $scope.login_errors = null;
  $scope.password = null;
  $scope.one_time_pass = null;
  $scope.lang = lang;
  $scope.timezones = timezones;
  $scope.user = $rootScope.user;
  $scope.settings = $scope.user;

  $scope.updateUserSettings = function(settings){
    console.log('Updating settings', settings, $scope.user);
    api.updateUserSettings(settings).then(function(data){
      console.log(data);
    })
  };


  $scope.login = function (credentials) {
    AuthService.login(credentials).then(function (user) {
      if(!user) {
        $scope.login_errors = lang.login_failed;
        $rootScope.$broadcast(AUTH_EVENTS.loginFailed);
      } else {
        $rootScope.$broadcast(AUTH_EVENTS.loginSuccess);
        $scope.setCurrentUser(user);
        $state.go('home');
      }
      
    });
  };

  $scope.setCurrentUser = function (user) {
    $rootScope.user = user;
  };

  $scope.logout = function(){
    AuthService.logout().then(function(data){
      $rootScope.$broadcast(AUTH_EVENTS.notAuthenticated);
      $state.go('login');
    });
  }

  var changeLocation = function(url, forceReload) {
    $scope = $scope || angular.element(document).scope();
    if(forceReload || $scope.$$phase) {
      $window.location = url;
    }
    else {
      $location.path(url);
      $scope.$apply();
    }
  };
}])