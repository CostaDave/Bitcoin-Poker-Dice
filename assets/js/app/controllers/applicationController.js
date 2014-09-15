'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('ApplicationController', ['$scope','$rootScope','AuthService', 'appConfig', 'lang', '$interval', '$modal', '$timeout', 'user', 'game', 'AUTH_EVENTS', 'api', 'pageConfig', function($scope, $rootScope, AuthService, appConfig, lang, $interval, $modal, $timeout, user, game, AUTH_EVENTS, api, pageConfig) {
 
 $rootScope.lang = lang;
 $rootScope.config = appConfig;
 $rootScope.user = user;
 $scope.sound_muted = false;

 if(user.has_password == '0') {
  openWelcomeModal();
 }

 function openWelcomeModal(template) {

  var modalInstance = $modal.open({
    templateUrl: 'welcome_modalTemplate',
    controller: 'ModalInstanceCtrl',
    resolve: {
      user: function () {
        return $scope.user;
      }
    }
  });

  modalInstance.result.then(function (selectedItem) {
    $scope.selected = selectedItem;
  }, function () {
  });

  $scope.ok = function () {
    $modalInstance.close();
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
};
}])