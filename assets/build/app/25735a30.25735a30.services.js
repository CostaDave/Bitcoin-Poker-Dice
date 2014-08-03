'use strict';

angular.module('bitcoinDice.services', []).
value('version', '0.1')
.service('userData1',function($http, $q){
	var user = false;
	return{
		apiPath:'api',
		getUser: function(){
      var deferred = $q.defer();
      $http.get(this.apiPath+'/get_user').success(function(data){
      	console.log(data)
        deferred.resolve(data);
      }).error(function(){
      	deferred.reject("An error occured while fetching items");
    	});
    	console.log(deferred.promise)
      return deferred.promise;
    }
  }
})
.service('userData',function($http, $q){
	var apiPath = 'api',
  sdo = {
		getUser: function() {
			var promise = $http({ method: 'GET', url: apiPath+'/get_user' }).success(function(data, status, headers, config) {
				
				return data;
			});
			
			return promise;
		},
		getMovies: function() {
			var promise = $http({ method: 'GET', url: 'api/movies.php' }).success(function(data, status, headers, config) {
				return data;
			});
			return promise;
		}
	}
	return sdo;
});
