'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('loginController', ['$scope','$rootScope','$state', '$stateParams', 'api', 'AuthService', 'AUTH_EVENTS', 'lang', function($scope,$rootScope, $state, $stateParams, api, AuthService, AUTH_EVENTS, lang) {
  $scope.login_errors = null;
  $scope.password = null;
  $scope.one_time_pass = null;

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