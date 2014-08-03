'use strict';

angular.module('bitcoinDice.services', ['restangular']).
value('version', '0.1')
.service('userData',function($http, $q){
	var apiPath = 'api',
  sdo = {
		getUser: function() {
			var promise = $http({ method: 'GET', url: apiPath+'/get_user' }).success(function(data, status, headers, config) {
				return data;
			});
			return promise;
		}
	}
	return sdo;
})
.service('api', function (Restangular) {
 //prepend /api before making any request with restangular
  //RestangularProvider.setBaseUrl('/api');
  return {
    user: function () {
      return Restangular.one("index.php/api/get_user");
    },
    getGames: function(){
      // search: function (query) {
        return Restangular.all('index.php/api/get_games').getList();
      // }
    },
  };
})
.service('diceService', function($http, $q){
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
				console.log(dice)
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
      	console.log('stake',stake)
      	is_rolling = true;
        var deferred = $q.defer();
        // if(held_dice.length > 0) {
        // 	client_seeds.held_dice = held_dice.join(',');
        // }
        var data = $.param(params);
        $http({
	        url: this.apiPath+'/roll_dice',
	        //dataType: "json",
	        data: data,
	        method: "POST",
	        headers: {
	            "Content-Type": "application/x-www-form-urlencoded "
	        }
	      }).success(function(data){
	      	//console.log('rolling in service', is_rolling)
          deferred.resolve(data);
          is_rolling = false;
        }).error(function(){
        	deferred.reject("An error occured while fetching dice");
        });
        return deferred.promise;
      }
  }

	//return diceService;
})
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
