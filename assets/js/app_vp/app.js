'use strict';

angular.module(
  'bitcoinDice', [
  'ngProgress',
  'datatables',
  'ui.bootstrap',
  'ui.router',
  'ngTable',
  'restangular',
  'bitcoinDice.filters',
  'bitcoinDice.services',
  'bitcoinDice.directives',
  'bitcoinDice.controllers'
  ]).
config(['$stateProvider', '$urlRouterProvider', 'appConfig', 'USER_ROLES', function($stateProvider, $urlRouterProvider, appConfig, USER_ROLES){
  
  $urlRouterProvider.otherwise("/play");

  $stateProvider
  .state('home', {
    url: "/play",
    controller: 'ApplicationController',
    templateUrl: appConfig.site_url+'/partials/index/home_page',
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
  })
  .state('payouts', {
    url: "/payouts",
    controller: 'payoutController',
    templateUrl: appConfig.site_url+'/partials/index/payouts',
    data: {
      authorizedRoles: [USER_ROLES.user, USER_ROLES.admin]
    }
  })
  .state('deposit', {
    url: "/deposits",
    controller: 'depositController',
    templateUrl: appConfig.site_url+'/partials/index/deposit',
    resolve: {
      user: ['api', function(api) {
        return api.getUser();
      }]
    },
    data: {
      authorizedRoles: [USER_ROLES.user, USER_ROLES.admin]
    }
  })
  .state('withdraw', {
    url: "/withdraw",
    controller: 'withdrawController',
    templateUrl: appConfig.site_url+'/partials/index/withdraw',
    resolve: {
      user: ['api', function(api) {
        return api.getUser();
      }],
      withdrawals: ['api', function(api) {
        return api.getWithdrawals();
      }]
    },
    data: {
      authorizedRoles: [USER_ROLES.user, USER_ROLES.admin]
    }
  })
  .state('affiliates', {
    url: "/affiliates",
    controller: 'affiliateController',
    templateUrl: appConfig.site_url+'/partials/index/affiliates',
    resolve: {
      user: ['api', function(api) {
        return api.getUser();
      }]
    },
    data: {
      authorizedRoles: [USER_ROLES.user, USER_ROLES.admin]
    }
  })
  .state('account', {
    url: "/account",
    controller: 'accountController',
    templateUrl: appConfig.site_url+'/partials/index/account',
    resolve: {
      user: ['api', function(api) {
        return api.getUser();
      }]
    },
    data: {
      authorizedRoles: [USER_ROLES.user, USER_ROLES.admin]
    }
  })
  .state('login', {
    url: "/login",
    controller: 'loginController',
    templateUrl: appConfig.site_url+'/partials/index/login',
    data: {
      authorizedRoles: [USER_ROLES.all]
    }
  })
  .state('proof', {
    url: "/proof/:game_id",
    templateUrl: function(params){ return appConfig.site_url+'/proof/game/' + params.game_id},
    data: {
      authorizedRoles: [USER_ROLES.user, USER_ROLES.admin]
    }
  })
  .state('admin', {
    url: "/admin",
    controller: 'adminController',
    resolve: {
      adminData:['adminApi', function(adminApi) {
        return adminApi.getAdminData();
      }]
    },
    templateUrl: appConfig.site_url+'/admin/partials/home',
    data: {
      authorizedRoles: [USER_ROLES.admin]
    }
  })
  .state('admin.dashboard', {
    url: "/dashboard",
    controller: 'adminDashboardController',
    resolve: {
      adminData:['adminApi', function(adminApi) {
        return adminApi.getAdminData();
      }],
      games:['adminApi', function(adminApi) {
        return adminApi.getGames();
      }],
      users:['$stateParams', 'adminApi', function($stateParams, adminApi) {
        return adminApi.getUsers();
      }]
    },
    templateUrl: appConfig.site_url+'/admin/partials/dashboard',
    data: {
      authorizedRoles: [USER_ROLES.admin]
    }
  })
  .state('admin.games', {
    url: "/games",
    controller: 'adminGamesController',
    resolve: {
      games:['adminApi', function(adminApi) {
        return adminApi.getGames();
      }]
    },
    templateUrl: appConfig.site_url+'/admin/partials/games_list',
    data: {
      authorizedRoles: [USER_ROLES.admin]
    }
  })
  .state('admin.game', {
    url: "/game/:id",
    controller: 'adminGameController',
    resolve: {
      game:['$stateParams', 'adminApi', function($stateParams, adminApi) {
        return adminApi.getGame($stateParams.id);
      }]
    },
    templateUrl: appConfig.site_url+'/admin/partials/game_detail',
    data: {
      authorizedRoles: [USER_ROLES.admin]
    }
  })
  .state('admin.users', {
    url: "/users",
    controller: 'adminUsersController',
    resolve: {
      users:['$stateParams', 'adminApi', function($stateParams, adminApi) {
        return adminApi.getUsers();
      }]
    },
    templateUrl: appConfig.site_url+'/admin/partials/users_list',
    data: {
      authorizedRoles: [USER_ROLES.admin]
    }
  })
  .state('admin.user', {
    url: "/user/:user_id",
    controller: 'adminUserController',
    resolve: {
      user:['$stateParams', 'adminApi', function($stateParams, adminApi) {
        return adminApi.getUser($stateParams.user_id);
      }],
      games:['$stateParams', 'adminApi', function($stateParams, adminApi) {
        return adminApi.getGamesForUser($stateParams.user_id);
      }]
    },
    templateUrl: appConfig.site_url+'/admin/partials/user_detail',
    data: {
      authorizedRoles: [USER_ROLES.admin]
    }
  })
  .state('admin.withdrawals', {
    url: "/withdrawals",
    controller: 'adminWithdrawController',
    resolve: {
      withdrawals:['adminApi', function(adminApi) {
        return adminApi.getWithdrawals();
      }],
      pendingWithdrawals: ['adminApi', function(adminApi) {
        return adminApi.getPendingWithdrawals();
      }]
    },
    templateUrl: appConfig.site_url+'/admin/partials/withdrawals',
    data: {
      authorizedRoles: [USER_ROLES.admin]
    }
  })
}])
.run(['$rootScope', '$state', '$location', 'AuthService', 'userDefault', 'AUTH_EVENTS', 'ngProgress', function($rootScope, $state, $location, AuthService, userDefault, AUTH_EVENTS, ngProgress){
$rootScope.$on('$stateChangeStart', function (event, next) {
    
    ngProgress.color('#fb1508');
    ngProgress.complete();
    ngProgress.start();  

    var user;

    if('undefined' == typeof $rootScope.user) {
      user = userDefault;
      if(user.logged_in) {
        AuthService.createSession(user.guid, user.user_id, user.role);
        $rootScope.user = user;
      }
    } else {
      user = $rootScope.user;
    }

    if(next.name != 'login') {
      var authorizedRoles = next.data.authorizedRoles;
      if (!AuthService.isAuthorized(authorizedRoles)) {
        event.preventDefault();
        if (AuthService.isAuthenticated()) {
          $rootScope.$broadcast(AUTH_EVENTS.notAuthorized);
          $state.go('login');
        } else {
          $rootScope.$broadcast(AUTH_EVENTS.notAuthenticated);
          $state.go('login');
        }
      }
    }    
  });
$rootScope.$on('$stateChangeSuccess', function (event, next) {
    
    ngProgress.complete();     
  });
}]);
