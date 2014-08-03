'use strict';

angular.module('bitcoinDice', [
  'ngRoute',
  'bitcoinDice.filters',
  'bitcoinDice.services',
  'bitcoinDice.directives',
  'bitcoinDice.controllers'
]).
config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/',{
  	controller: 'AppCtrl',
  	templateUrl: 'partials/index/home_page',
  	resolve: {
  		user: function(userData) {
  			return userData.getUser();
  		}
  	}
 });
  $routeProvider.when('/view2', {templateUrl: 'partials/partial2.html', controller: 'MyCtrl2'});
  $routeProvider.otherwise({redirectTo: '/'});
}]);
