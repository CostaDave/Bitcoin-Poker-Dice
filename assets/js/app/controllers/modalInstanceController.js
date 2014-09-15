'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('ModalInstanceCtrl', ['$scope','$rootScope','$modalInstance',  function($scope,$rootScope,$modalInstance) {


  $scope.ok = function () {
    $modalInstance.close();
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };




}]);