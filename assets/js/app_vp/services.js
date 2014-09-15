'use strict';

angular.module('bitcoinDice.services', ['restangular']).
value('version', '0.1')

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
.service('api',['$http','$rootScope', '$q', 'Restangular', 'AUTH_EVENTS', '$state', 'appConfig',  function ($http, $rootScope, $q, Restangular, AUTH_EVENTS, $state, appConfig) {
  
  Restangular.setBaseUrl(appConfig.site_url);
  Restangular.setErrorInterceptor(function(response, deferred, responseHandler) {
    if(response.status === 401) {
        $rootScope.$broadcast(AUTH_EVENTS.notAuthenticated);
        $state.go('login');
    }

    return true; // error not handled
});
  return {
    getUser: function () {
      return Restangular.one("api/get_user").get();
    },
    getGame: function(){
      return Restangular.one("api/get_game").get();
    },
    getGames: function(){
        return Restangular.all('api/get_games').getList();
    },
    getAllGames: function(){
        return Restangular.all('api/get_all_games').getList();
    },
    getTransactions: function(){
        return Restangular.all('api/get_transactions').getList();
    },
    getWithdrawals: function(){
        return Restangular.all('api/get_withdrawals').getList();
    },
    rollDice: function(params) {
      var roll = Restangular.one('api/roll_dice');
      return roll.post('roll_dice', params);
    },
    collectWin: function(params) {
      var roll = Restangular.one('api/collect');
      return roll.post('collect', params);
    },
    setPassword: function(params) {
      var call = Restangular.one('api/set_password');
      return call.post('set_password', params);
    },
    requestWithdrawal: function(params) {
      var call = Restangular.one('api/request_withdrawal');
      return call.post('request_withdrawal', params);
    }
  };
}])
.service('adminApi',['$http','$rootScope', '$q', 'Restangular', 'AUTH_EVENTS', '$location', 'appConfig',  function ($http, $rootScope, $q, Restangular, AUTH_EVENTS, $location, appConfig) {
  
  Restangular.setBaseUrl(appConfig.site_url);
  Restangular.setErrorInterceptor(function(response, deferred, responseHandler) {
    if(response.status === 401) {
        $rootScope.$broadcast(AUTH_EVENTS.notAuthenticated);
        $location.path('/login');
    }

    return true; // error not handled
});
  return {
    getAdminData: function () {
      return Restangular.one("admin_api/get_admin_data").get();
    },
    getWithdrawals: function() {
      return Restangular.one("admin_api/get_withdrawals").get();
    },
    getPendingWithdrawals: function() {
      return Restangular.one("admin_api/get_pending_withdrawals").get();
    },
    processWithdrawals: function(params) {
      console.log(params)
      var call = Restangular.one('admin_api/process_withdrawals');
      return call.post('process_withdrawals', params);
    },
    getGames: function(){
        return Restangular.all('admin_api/get_games').getList();
    },
    getGame: function(params){
      return Restangular.one('admin_api/get_game/'+params).get();
    },
    getUser: function(params){
      //console.log(params);
        return Restangular.one('admin_api/get_user/'+params).get();
    },
    getGamesForUser: function(params){
        return Restangular.all('admin_api/get_games_by_user/'+params).getList();
    },
    getUsers: function(){
      //console.log(params);
        return Restangular.one('admin_api/get_all_users/').getList();
    },
  };
}]);
