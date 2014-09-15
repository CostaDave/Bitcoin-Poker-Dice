'use strict';

angular.module('bitcoinDice.services')
.service('AuthService',['$http', 'Session', '$q', 'appConfig', function ($http, Session, $q, appConfig) {
  var authService = {};
 
  authService.login = function (credentials) {
    var deferred = $q.defer();
    var data = $.param(credentials);
    $http({
      url: appConfig.site_url+'/auth/login/'+appConfig.guid,
      data: data,
      method: "POST",
      headers: {
          "Content-Type": "application/x-www-form-urlencoded "
      }
    }).success(function(res){
      if('undefined' == typeof res[0].error) {
        Session.create(res[0].guid, res[0].user_id, res[0].role);
      } else {
        res = false;
      }
      deferred.resolve(res);
    }).error(function(){
      deferred.reject("An error occured while loggin in");
    });
    return deferred.promise;
  };

  authService.logout = function () {
    var deferred = $q.defer();
    $http({
      url: appConfig.site_url+'/auth/logout',
      data: {},
      method: "POST",
      headers: {
          "Content-Type": "application/x-www-form-urlencoded "
      }
    }).success(function(data){
      Session.destroy();
      deferred.resolve(data);
    }).error(function(){
      deferred.reject("An error occured while lgging out");
    });
    return deferred.promise;
  };
 
  authService.isAuthenticated = function () {
    return !!Session.userId;
  };
 
  authService.isAuthorized = function (authorizedRoles) {
    if (!angular.isArray(authorizedRoles)) {
      authorizedRoles = [authorizedRoles];
    }
    return (authService.isAuthenticated() &&
      authorizedRoles.indexOf(Session.userRole) !== -1);
  };

  authService.createSession  = function(sessionId, userId, userRole){
    Session.create(sessionId, userId, userRole);
  }
 
  return authService;
}])
.service('Session', function () {
  this.create = function (sessionId, userId, userRole) {
    this.id = sessionId;
    this.userId = userId;
    this.userRole = userRole;
  };
  this.destroy = function () {
    this.id = null;
    this.userId = null;
    this.userRole = null;
  };
  return this;
})