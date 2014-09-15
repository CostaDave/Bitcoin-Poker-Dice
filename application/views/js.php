angular.module('bitcoinDice').constant('appConfig', <?=$config;?>);
angular.module('bitcoinDice').constant('AUTH_EVENTS', {
  loginSuccess: 'auth-login-success',
  loginFailed: 'auth-login-failed',
  logoutSuccess: 'auth-logout-success',
  sessionTimeout: 'auth-session-timeout',
  notAuthenticated: 'auth-not-authenticated',
  notAuthorized: 'auth-not-authorized'
});
angular.module('bitcoinDice').constant('USER_ROLES', {
  all: '*',
  admin: 'admin',
  user: 'user'
});
angular.module('bitcoinDice').constant('lang', <?=$language;?>);
angular.module('bitcoinDice').constant('userDefault', <?=$user;?>);

angular.module('bitcoinDice').constant('timezones', <?=$timezones;?>);