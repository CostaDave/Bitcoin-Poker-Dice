'use strict';

angular.module('bitcoinDice.services')
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
    updateUserSettings: function(params){
      console.log(params);
      var call = Restangular.one('api');
      return call.post('update_user', params);
    },
    
    getGame: function(){
      return Restangular.one("api/get_game").get();
    },
    getGames: function(gametype, global){
        return Restangular.all('api/get_games').getList();
    },
    getGamesTables: function(gametype, global){
      var url = ''
      if(gametype) {
        url += '/'+gametype;
      } else {
        url +=  '/false';
      }

      if(global) {
        url += '/'+global;
      } 

      return Restangular.all('api/get_games'+url).getList();
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