'use strict';

/* Directives */


angular.module('bitcoinDice.directives')
.directive('updatePasswordDirective',['api', function(api){
	return {
		restrict: 'E',
		replace: false,
		templateUrl: 'update_passwordTemplate',
		link: function link(scope, element, attrs) {
      console.log('update password');
      scope.setPassword = function(pass){
      	console.log(pass)
      	api.setPassword(pass).then(function(response){
      		console.log('resonse', response);
      	})
      }
      
    }
  }
}])