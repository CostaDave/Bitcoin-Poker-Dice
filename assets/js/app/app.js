'use strict';

angular.module('bitcoinDice', [
  'datatables',
  'ui.bootstrap',
  'ngRoute',
  'restangular',
  'bitcoinDice.filters',
  'bitcoinDice.services',
  'bitcoinDice.directives',
  'bitcoinDice.controllers'
]).
config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/',{
  	controller: 'AppCtrl',
  	templateUrl: 'partials/index/home_page'
 });
  
  $routeProvider.when('/payouts', {
    controller: 'payoutController',
    templateUrl: 'partials/index/payouts',
    resolve: {
      config: function(appData) {
        return appData.getConfig();
      }
    }
  });
  $routeProvider.when('/deposit', {
    controller: 'depositController',
    templateUrl: 'partials/index/deposit',
    resolve: {
      user: function(userData) {
        return userData.getUser();
      }
    }
  });
  $routeProvider.when('/proof/:game_id', {
    //controller: 'depositController',
    //function(params){ return 'partials/index/proof/' + params.game_id; 
    templateUrl: function(params){ return 'proof/game/' + params.game_id},
    // resolve: {
    //   user: function(userData) {
    //     return userData.getUser();
    //   }
    
  });
  $routeProvider.otherwise({redirectTo: '/'});
}]);
