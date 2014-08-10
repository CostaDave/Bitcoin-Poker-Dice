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
      Session.create(res[0].guid, res[0].user_id, res[0].role);
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
}])
.service('diceService',['$http', '$q', function($http, $q){
	var apiPath = 'api';
	var diceService = {};
	var dice = [];
	var is_rolling = false;

	return{
      apiPath:'api',
      get: function(){
      	return dice;
      },
      getGames: function(){
      	var deferred = $q.defer();
        $http({
	        url: this.apiPath+'/getGames',
	        method: "GET"
	      }).success(function(data){
          deferred.resolve(data);
        }).error(function(){
        deferred.reject("An error occured while fetching dice");
        });
        return deferred.promise;
      },
      isRolling: function(){
      	return is_rolling;
      },
      set: function(obj){
				angular.forEach(obj, function(value, key){
					console.log('value '+value, key)
					dice.push(value)
				});
				return;
			},
			get_game: function(){
				var deferred = $q.defer();
        $http({
	        url: this.apiPath+'/get_game',
	        method: "GET"
	      }).success(function(data){
          deferred.resolve(data);
        }).error(function(){
        deferred.reject("An error occured while fetching dice");
        });
        return deferred.promise;
			},
      getAllGames: function(){
        var deferred = $q.defer();
        $http({
          url: this.apiPath+'/get_all_games',
          method: "GET"
        }).success(function(data){
          deferred.resolve(data);
        }).error(function(){
        deferred.reject("An error occured while fetching dice");
        });
        return deferred.promise;
      },
			collect_win: function(){
				var deferred = $q.defer();
        $http({
	        url: this.apiPath+'/collect',
	        method: "POST"
	      }).success(function(data){
          deferred.resolve(data);
        }).error(function(){
        deferred.reject("An error occured while fetching dice");
        });
        return deferred.promise;
			},
      roll_dice: function(params,client_seeds, held_dice, stake){
      	is_rolling = true;
        var deferred = $q.defer();
        var data = $.param(params);
        $http({
	        url: this.apiPath+'/roll_dice',
	        data: data,
	        method: "POST",
	        headers: {
	            "Content-Type": "application/x-www-form-urlencoded "
	        }
	      }).success(function(data){
          deferred.resolve(data);
          is_rolling = false;
        }).error(function(){
        	deferred.reject("An error occured while fetching dice");
        });
        return deferred.promise;
      }
  }
}])
.service('diceData', function($http, $q){
	var apiPath = 'api',
  sdo = {
		getConfig: function() {
			var promise = $http({ method: 'POST', url: apiPath+'/roll_dice' }).success(function(data, status, headers, config) {
				return data;
			});
			return promise;
		}
	}
	return sdo;
})
.service('appData',function($http, $q){
	var apiPath = 'api',
  sdo = {
		getConfig: function() {
			var promise = $http({ method: 'GET', url: apiPath+'/get_config' }).success(function(data, status, headers, config) {
				return data;
			});
			return promise;
		}
	}
	return sdo;
});
