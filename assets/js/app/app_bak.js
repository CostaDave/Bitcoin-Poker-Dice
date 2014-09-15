'use strict';

angular.module('bitcoinDice', [
  'angular-onbeforeunload',
  'datatables',
  'ui.bootstrap',
  'ngRoute',
  'restangular',
  'bitcoinDice.filters',
  'bitcoinDice.services',
  'bitcoinDice.directives',
  'bitcoinDice.controllers'
  ]).
config(['$routeProvider', 'appConfig', 'USER_ROLES',  function($routeProvider,config, USER_ROLES) {
  $routeProvider.when('/play',{
  	controller: 'ApplicationController',
  	templateUrl: config.site_url+'/partials/index/home_page',
    resolve: {
      game: ['api',function(api) {
        return api.getGame();
      }],
      user: ['api', function(api) {
        return api.getUser();
      }]
    },
    data: {
      authorizedRoles: [USER_ROLES.user, USER_ROLES.admin]
    }
  });
  
  $routeProvider.when('/payouts', {
    controller: 'payoutController',
    templateUrl: config.site_url+'/partials/index/payouts',
    data: {
      authorizedRoles: [USER_ROLES.user, USER_ROLES.admin]
    }
    
  });
  $routeProvider.when('/deposit', {
    controller: 'depositController',
    templateUrl: config.site_url+'/partials/index/deposit',
    resolve: {
      user: ['api', function(api) {
        return api.getUser();
      }]
    },
    data: {
      authorizedRoles: [USER_ROLES.user, USER_ROLES.admin]
    }
    
  });
  $routeProvider.when('/withdraw', {
    controller: 'withdrawController',
    templateUrl: config.site_url+'/partials/index/withdraw',
    resolve: {
      user: ['api', function(api) {
        return api.getUser();
      }]
    },
    data: {
      authorizedRoles: [USER_ROLES.user, USER_ROLES.admin]
    }
    
  });
  $routeProvider.when('/account', {
    controller: 'accountController',
    templateUrl: config.site_url+'/partials/index/account',
    resolve: {
      user: ['api', function(api) {
        return api.getUser();
      }]
    },
    data: {
      authorizedRoles: [USER_ROLES.user, USER_ROLES.admin]
    }
  });
  $routeProvider.when('/affiliates', {
    controller: 'affiliateController',
    templateUrl: config.site_url+'/partials/index/affiliates',
    resolve: {
      user: ['api', function(api) {
        return api.getUser();
      }]
    },
    data: {
      authorizedRoles: [USER_ROLES.user, USER_ROLES.admin]
    }
  });
  $routeProvider.when('/admin', {
    controller: 'adminController',
    templateUrl: config.site_url+'/admin/partials/dashboard',
    data: {
      authorizedRoles: [USER_ROLES.user, USER_ROLES.admin]
    }
  });
  $routeProvider.when('/login', {
    controller: 'loginController',
    templateUrl: config.site_url+'/partials/index/login',
    data: {
      authorizedRoles: [USER_ROLES.user, USER_ROLES.admin]
    }
  });
  $routeProvider.when('/not_authorized', {
    controller: 'loginController',
    templateUrl: config.site_url+'/partials/index/login',
    data: {
      authorizedRoles: [USER_ROLES.user, USER_ROLES.admin]
    }
  });
  $routeProvider.when('/proof/:game_id', {
    templateUrl: function(params){ return config.site_url+'/proof/game/' + params.game_id},
  });
  $routeProvider.otherwise({redirectTo: '/play'});
}],
['$httpProvider', function($httpProvider){
  console.log('injested')
  $httpProvider.interceptors.push([
    '$injector',
    function ($injector) {
      return $injector.get('AuthInterceptor');
    }
    ]);
}])
.factory('AuthInterceptor',['$rootScope', '$q', 'AUTH_EVENTS', function ($rootScope, $q,
  AUTH_EVENTS) {
  return {
    responseError: function (response) { 
      console.log('error')
      $rootScope.$broadcast({
        401: AUTH_EVENTS.notAuthenticated,
        403: AUTH_EVENTS.notAuthorized,
        419: AUTH_EVENTS.sessionTimeout,
        440: AUTH_EVENTS.sessionTimeout
      }[response.status], response);
      return $q.reject(response);
    }
  };
}])
.run(['$rootScope', '$location', 'AuthService', 'userDefault', 'AUTH_EVENTS', function($rootScope, $location, AuthService, userDefault, AUTH_EVENTS){

  $rootScope.$on('$routeChangeStart', function (event, next) {
    var user;

    if('undefined' == typeof $rootScope.user) {
      user = userDefault;
      if(user.logged_in) {
        AuthService.createSession(user.guid, user.user_id, user.role);
      }
    } else {
      user = $rootScope.user;
    }

    var authorizedRoles = next.data.authorizedRoles;
    console.log(authorizedRoles);
    if (!AuthService.isAuthorized(authorizedRoles)) {
      event.preventDefault();
      if (AuthService.isAuthenticated()) {
      $rootScope.$broadcast(AUTH_EVENTS.notAuthorized);
      $location.path('/not_authorized');
      } else {
        $rootScope.$broadcast(AUTH_EVENTS.notAuthenticated);
        $location.path('/login');
      }
    }
  });
}]);
