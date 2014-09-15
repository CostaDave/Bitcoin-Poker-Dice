'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('tabController', ['$scope', 'DTOptionsBuilder', 'DTColumnBuilder', function($scope, DTOptionsBuilder, DTColumnBuilder){
  $scope.tabs = [
  { title:'Dynamic Title 1', content:'Dynamic content 1' },
  { title:'Dynamic Title 2', content:'Dynamic content 2', disabled: true }
  ]; 
}])