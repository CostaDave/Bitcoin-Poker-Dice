'use strict';

angular.module('bitcoinDice.services')
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
