'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers', [])
.controller('adminController',['$scope', '$rootScope', 'adminData', function($scope, $rootScope, adminData){
  $scope.adminData = adminData;
}])
.controller('adminDashboardController',['$scope', '$rootScope', 'games', 'users', 'adminData', 'ngTableParams', function($scope, $rootScope, games, users, adminData, ngTableParams){
  
  $scope.adminData = adminData;
  var gameData = games;
  var userData = users;

  $scope.gameTableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10           // count per page
    }, {
        total: gameData.length, // length of data
        getData: function($defer, params) {
            $defer.resolve(gameData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    });

  $scope.userTableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10           // count per page
    }, {
        total: userData.length, // length of data
        getData: function($defer, params) {
            $defer.resolve(userData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    });
}])
.controller('adminWithdrawController',['$scope', '$rootScope', 'withdrawals', 'ngTableParams', function($scope, $rootScope, withdrawals, ngTableParams){
  var data = withdrawals.withdrawals;
  $scope.tableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10           // count per page
    }, {
        total: data.length, // length of data
        getData: function($defer, params) {
            $defer.resolve(data.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    });

    $scope.checkboxes = { 'checked': false, items: {} };

    // watch for check all checkbox
    $scope.$watch('checkboxes.checked', function(value) {
      console.log('echking all')
        angular.forEach(data, function(item) {
            if (angular.isDefined(item.id)) {
                $scope.checkboxes.items[item.id] = value;
            }
        });
    });

    // watch for data checkboxes
    $scope.$watch('checkboxes.items', function(values) {
        if (!data) {
            return;
        }
        var checked = 0, unchecked = 0,
            total = data.length;
        angular.forEach($scope.users, function(item) {
            checked   +=  ($scope.checkboxes.items[item.id]) || 0;
            unchecked += (!$scope.checkboxes.items[item.id]) || 0;
        });
        if ((unchecked == 0) || (checked == 0)) {
            $scope.checkboxes.checked = (checked == total);
        }
        // grayed checkbox
        angular.element(document.getElementById("select_all")).prop("indeterminate", (checked != 0 && unchecked != 0));
    }, true);
}])
.controller('adminGamesController',['$scope', '$rootScope','$filter', 'games', 'ngTableParams', function($scope, $rootScope, $filter, games, ngTableParams){
  console.log('loading controlelr')
  var data = games;
  $scope.tableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10,
        
        sorting: {
            id: 'desc'     // initial sorting
        }      // count per page
    }, {
        total: data.length, // length of data
        getData: function($defer, params) {
            // use build-in angular filter
            var orderedData = params.sorting() ?
                                $filter('orderBy')(data, params.orderBy()) :
                                data;

            var filteredData = params.filter() ?
                    $filter('filter')(data, params.filter()) :
                    data;

            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    });
}])
.controller('adminGameController',['$scope', '$rootScope', 'game', 'ngTableParams', function($scope, $rootScope, game, ngTableParams){
  console.log('loading controlelr')
  $scope.game = game;
  // var data = withdrawals.withdrawals;
  // $scope.tableParams = new ngTableParams({
  //       page: 1,            // show first page
  //       count: 10           // count per page
  //   }, {
  //       total: data.length, // length of data
  //       getData: function($defer, params) {
  //           $defer.resolve(data.slice((params.page() - 1) * params.count(), params.page() * params.count()));
  //       }
  //   });
}])
.controller('adminUsersController',['$scope', '$rootScope','$filter', 'users', 'ngTableParams', function($scope, $rootScope, $filter, users, ngTableParams){
  console.log('loading controlelr')
  var data = users;
  $scope.tableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10,
        
        filter: {
            guid: ''       // initial filter
        }, 
        sorting: {
            user_id: 'desc'     // initial sorting
        }      // count per page
    }, {
        total: data.length, // length of data
        getData: function($defer, params) {
            // use build-in angular filter
            var orderedData = params.sorting() ?
                                $filter('orderBy')(data, params.orderBy()) :
                                data;

            var filteredData = params.filter() ?
                    $filter('filter')(data, params.filter()) :
                    data;

            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    });
}])
.controller('adminUserController',['$scope', '$rootScope', 'user', 'games', 'ngTableParams', function($scope, $rootScope, user, games, ngTableParams){
  console.log('loading controlelr')
  $scope.user = user;
  var data = games;
  $scope.tableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10           // count per page
    }, {
        total: data.length, // length of data
        getData: function($defer, params) {
            $defer.resolve(data.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    });
}])
.controller('ApplicationController', ['$scope','$rootScope','AuthService', 'appConfig', 'lang', '$interval', '$modal', '$timeout', 'user', 'game', 'diceService', 'AUTH_EVENTS', 'api', function($scope, $rootScope, AuthService, appConfig, lang, $interval, $modal, $timeout, user, game, diceService, AUTH_EVENTS, api) {
 $rootScope.lang = lang;
 $rootScope.config = appConfig;
 $scope.user = user;
 $rootScope.user = $scope.user;
 $rootScope.user_balance = user.available_balance;
 $scope.user_balance = $rootScope.user_balance;
 //$rootScope.next_hash = user.next_hash;

 $scope.hands = appConfig.hands;
 $scope.predicate = '-sort';

 $scope.stake = 0;
 $scope.stake_held = false;
 $scope.wager_amounts = $rootScope.config.wager_amounts;
 $scope.percent_wagers = [
 {'text':'10%','amt':.10},
 {'text':'25%','amt':.25},
 {'text':'50%','amt':.50}
 ];

 $scope.$watch(AuthService.isAuthenticated(), function(newVal){
    //console.log('authenticated', newVal)
 })

 var pollTimer = $interval(function(){
  //if($scope.user.logged_in) {
    getUser();
  //}
 },15000)

 $scope.$on('$destroy', function () { $interval.cancel(); });

 $rootScope.$on(AUTH_EVENTS.notAuthenticated, function(){
  console.log('no longer authenticated')
 });

 function getUser(){
  api.getUser().then(function(data){
    if(data.available_balance > $scope.user.available_balance) {
      depositSound.play();
    }
    $scope.user = data;
    $rootScope.user = data;
    $scope.user.available_balance = data.available_balance;
  })
}

$scope.game = game;

$scope.dice = game.dice;
$scope.screenState;
$scope.held_dice = [];
$scope.winning_hand = 'Royal Straight';
$scope.new_game = game.rolls_remaining > 2 ? true:false;
$scope.rolls_remaining = game.rolls_remaining;
$scope.dice_rolling = false;
$scope.seeds = {};
$scope.seeds.seed_1 = get_random_seed();
$scope.seeds.seed_2 = get_random_seed();
$scope.seeds.seed_3 = get_random_seed();
$scope.seeds.seed_4 = get_random_seed();
$scope.seeds.seed_5 = get_random_seed();


$rootScope.dice = $scope.dice;
$rootScope.seeds = $scope.seeds;
$rootScope.held_dice = $scope.held_dice;


initScreen();

var roll_button = $('.btn-roll'),
collect_button = $('.btn-collect');

function initScreen(){
  if(game.rolls_remaining == 3) {
        changeScreenState('new');
      } else {
        changeScreenState('inplay');
      }
    }

    function changeScreenState(state) {
      $scope.screenState = state;
    }

    function get_random_seed(){
      return Math.floor((Math.random() * 1000000000000000) + 1);
    }

    $scope.toggleHold = function(dice){
      clickDiceSound.play();
      if($.inArray(dice, $scope.held_dice) > -1) { 
        remove($scope.held_dice, dice);
        $('#dice_'+dice).removeClass('selected');
      } else {
        $scope.held_dice.push(dice);
        $('#dice_'+dice).addClass('selected');
      }
    }

    function unhold_dice(){
      $('strong').children('.card').unwrap();
    }


    function remove(arr, item) {
      var i;
      while((i = arr.indexOf(item)) !== -1) {
        arr.splice(i, 1);
      }
    }

    var setupNewGame = function(){
      $scope.new_game = true;
      $scope.held_dice = [];
      $scope.stake = 0;
      $scope.rolls_remaining = 3;
      $rootScope.reloadGameTable = Math.random();
      $rootScope.reloadTranTable = Math.random();;
      unhold_dice();

      if($scope.user.available_balance > 0) {
        $('.wager-buttons').removeClass('disabled');
      }

      $('.selected').removeClass('selected');

      $scope.stake_held = false;

      //roll_button.html('New Game');

      createSeeds();

      
    }

    var createSeeds = function(){
      $scope.seeds.seed_1 = get_random_seed();
      $scope.seeds.seed_2 = get_random_seed();
      $scope.seeds.seed_3 = get_random_seed();
      $scope.seeds.seed_4 = get_random_seed();
      $scope.seeds.seed_5 = get_random_seed();
    }


    // END
    $scope.collect_win = function(){
      $('.wager-buttons').addClass('disabled');
      collect_button.addClass('disabled');
      winnerSound.play();
      diceService.collect_win().then(function(response){
        console.log(response);
        $scope.user.available_balance = response.balance;
        $scope.finished_hand = response.roll;
        $scope.winning_hand = $rootScope.config.hands[response.winnings].name;
        $scope.winning_rolls_needed = response.rolls_needed;
        $scope.last_roll = response.roll;
        $scope.winning_payout = $rootScope.config.hands[response.winnings].payout['roll_'+response.rolls_needed];
        api.getGame().then(function(data){
          $scope.game = data;
          changeScreenState('result-winner');
          setupNewGame();
        });
      });


    }


    $scope.roll_dice = function(){
      $scope.dice_rolling = true;
      rollDiceSound.play();
      
      if($scope.game.rolls_remaining == 3) {
        changeScreenState('inplay');
        $('.wager-buttons').addClass('disabled');
        roll_button.html('Roll Dice!');
      }

      if(!$scope.stake_held) {
        $scope.user.available_balance = $scope.user.available_balance - $scope.stake;
        $scope.stake_held = true;
      } 
      

      var params = {seeds:$scope.seeds,held_dice:$scope.held_dice,stake:$scope.stake};

      // console.log(api.rollDice().post($.params(params)).then(function(roll){
      //   return roll;
      // }))
      api.rollDice(params).then(function(roll){
        $scope.dice = roll.roll;
        $scope.rolls_remaining = $scope.rolls_remaining - 1;
        
        if(roll.rolls_remaining === 0) {
          var timeout = $timeout(function() {
            api.getGame().then(function(data){
              $scope.game = data;
              $scope.user.available_balance = roll.balance;
              
              if(roll.winning_rolls && $rootScope.config.hands[roll.winning_rolls].payout.roll_3 > 0) {
                winnerSound.play();
                changeScreenState('result-winner');
                $scope.winning_hand = $rootScope.config.hands[roll.winning_rolls].name;
                $scope.winning_rolls_needed = 3;
                $scope.winning_payout = $rootScope.config.hands[roll.winning_rolls].payout.roll_3;
                console.log(roll.balance)
                $scope.user.available_balance = roll.balance;
              } else {
                loserSound.play();
                

                changeScreenState('result-loser');
              }

              $scope.last_roll = roll.roll;

              setupNewGame();
            });
          }, 1500);
          


        }

        if(roll.winning_rolls && roll.rolls_remaining > 0) {
          collect_button.removeClass('disabled');
        } else {
          collect_button.addClass('disabled');
        }

        createSeeds();
      });
}

var rollDiceSound = soundManager.createSound({
  url: '/assets/mp3/roll.mp3'
});

var clickDiceSound = soundManager.createSound({
  url: '/assets/mp3/dice_click.mp3',
  volume: 25
});

var depositSound = soundManager.createSound({
  url: '/assets/mp3/deposit.mp3',
  volume: 25
});

var winnerSound = soundManager.createSound({
  url: '/assets/mp3/winner_short.mp3',
  volume: 100
});

var loserSound = soundManager.createSound({
  url: '/assets/mp3/loser_short.mp3',
  volume: 100
});

$scope.addPercentToWager = function(amt) {

  var wager_amt = 0;
  var max_bet = $rootScope.config.max_bet;

  if(max_bet > $scope.user.available_balance) {
    max_bet = $scope.user.available_balance;
  }


  if(amt == 'max') {
    wager_amt = max_bet;
  } else {
    wager_amt = amt * $scope.user.available_balance;

    if(wager_amt > $scope.user.available_balance)
      wager_amt = $scope.user.available_balance;
    if(wager_amt > max_bet) {
      wager_amt = max_bet;
    }
  }
  $scope.stake = wager_amt;
}

$scope.addAmtToWager = function(amt) {
  if(amt * 100000000 > $rootScope.user_balance) {
    return false;
  }
  var new_amt = $scope.stake + (amt * 100000000);

  if(new_amt > $scope.user.available_balance) {
    new_amt = $scope.user.available_balance;
  }

  if(new_amt > $rootScope.config.max_bet) {
    $scope.stake = $rootScope.config.max_bet;
  } else {
    $scope.stake = new_amt;
  }
}

$scope.openSeedModal = function () {

  var modalInstance = $modal.open({
    templateUrl: 'seedModalTemplate',
    controller: 'ModalInstanceCtrl',
    resolve: {
      user: function () {
        return $scope.user;
      }
    }
  });
}

$scope.openModal = function (template) {

  var modalInstance = $modal.open({
    templateUrl: template,
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
.controller('navController',['$scope', 'lang', function($scope, lang){
  $scope.lang = lang;
  $scope.sound_muted = false;
  $scope.active_nav = '';

  $scope.$on('$routeChangeSuccess', function (ev, current, prev) {
   var curr_route = current.$$route.originalPath;
   if(curr_route == '/') {
    $scope.active_nav = 'play';
   }
   if(curr_route == '/payouts') {
    $scope.active_nav = 'payouts';
   }  
   if(curr_route == '/deposit') {
    $scope.active_nav = 'deposit';
   }
   if(curr_route == '/withdraw') {
    $scope.active_nav = 'withdraw';
   }
   if(curr_route == '/affiliates') {
    $scope.active_nav = 'affiliates';
   }
   if(curr_route == '/account') {
    $scope.active_nav = 'account';
   }
  });

  $scope.changeNav = function(nav) {
    $scope.active_nav = nav;
  }

  $scope.toggleMute = function(dice){
    if(!$scope.sound_muted) {
      $scope.sound_muted = true;
      soundManager.mute();
    } else {
      $scope.sound_muted = false;
      soundManager.unmute();
    }
  }
}])
.controller('payoutController',['$scope', '$rootScope', 'appConfig', function($scope, $rootScope, appConfig){
  $scope.hands =appConfig.hands;
}])

.controller('affiliateController',['$scope', '$rootScope', 'user', 'appConfig', function($scope, $rootScope, user, appConfig){
  $scope.user = user;
  $scope.config =appConfig;
}])
.controller('accountController',['$scope', '$rootScope', 'appConfig', function($scope, $rootScope, appConfig){
  $scope.hands =appConfig.hands;
}])
.controller('depositController',['$scope', '$rootScope','lang', 'user', 'appConfig', function($scope, $rootScope, lang, user, appConfig){
  $scope.lang = lang;
  $scope.user = user;
  $scope.demo_mode = appConfig.demo_mode;

  $scope.withdraw_address = '';
  $scope.withdraw_amount = 0;

  $scope.items = false;

  $scope.sort = {       
    sortingOrder : 'id',
    reverse : true
  };

  $scope.gap = 5;

  $scope.groupedItems = [];
  $scope.itemsPerPage = 50;
  $scope.pagedItems = [];
  $scope.currentPage = 0;

  $scope.search = function () {
    $scope.filteredItems = $filter('filter')($scope.items, function (item) {
      for(var attr in item) {

              if (searchMatch(item[attr], $scope.query))
                return true;
            }
            return false;
          });


        if ($scope.sort.sortingOrder !== '') {
          $scope.filteredItems = $filter('orderBy')($scope.filteredItems, $scope.sort.sortingOrder, $scope.sort.reverse);
        }
        $scope.currentPage = 0;

        $scope.groupToPages();
      };

      var searchMatch = function (haystack, needle) {
        if (!needle) {
          return true;
        }
        return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
      };

    // init the filtered items
    


    // calculate page in place
    $scope.groupToPages = function () {
      $scope.pagedItems = [];

      for (var i = 0; i < $scope.filteredItems.length; i++) {
        if (i % $scope.itemsPerPage === 0) {
          $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)] = [ $scope.filteredItems[i] ];
        } else {
          $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)].push($scope.filteredItems[i]);
        }
      }
    };
    
    $scope.range = function (size,start, end) {
      var ret = [];        
      if (size < end) {
        end = size;
        start = size-$scope.gap;
      }
      for (var i = start; i < end; i++) {
        ret.push(i);
      }                
      return ret;
    }

    $scope.prevPage = function () {
      if ($scope.currentPage > 0) {
        $scope.currentPage--;
      }
    };

    $scope.nextPage = function () {
      if ($scope.currentPage < $scope.pagedItems.length - 1) {
        $scope.currentPage++;
      }
    };

    $scope.setPage = function () {
      $scope.currentPage = this.n;
    };

    //functions have been describe process the data for display
    $rootScope.$watch('reloadWithdrawals',function(newVal){
      if(typeof newVal != 'undefined') {
        $scope.reload_withdrawals();
      }
    })

 
  $scope.requestWithdrawal = function(){
    api.requestWithdrawal({'address':$scope.withdraw_address, 'amount':$scope.withdraw_amount});
  }
}])
.controller('withdrawController',['$scope', '$rootScope','$filter', 'api', 'withdrawals', 'appConfig', 'ngTableParams', function($scope, $rootScope, $filter, api, withdrawals, appConfig, ngTableParams){
  
  $scope.demo_mode = appConfig.demo_mode;

  var data = withdrawals;
  $scope.tableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10           // count per page
    }, {
        total: data.length, // length of data
        getData: function($defer, params) {
            $defer.resolve(data.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    });

    $scope.checkboxes = { 'checked': false, items: {} };

  $scope.requestWithdrawal = function(){
    console.log('requesting withdrawal');
    api.requestWithdrawal({'address':$scope.withdraw_address, 'amount':$scope.withdraw_amount});
  }
  
}])
.controller('tabController', ['$scope', 'DTOptionsBuilder', 'DTColumnBuilder', function($scope, DTOptionsBuilder, DTColumnBuilder){
  $scope.tabs = [
  { title:'Dynamic Title 1', content:'Dynamic content 1' },
  { title:'Dynamic Title 2', content:'Dynamic content 2', disabled: true }
  ];

  
  
}])
.controller('proofController', ['$scope', function($scope){
  $scope.tabs = [
  ];

  

  
}])
.controller('ctrlRead',['$scope', '$rootScope', '$filter', 'diceService', 'api', 'games', function ($scope, $rootScope, $filter, diceService, api, games) {

    // init
    $scope.items = null;

    $scope.sort = {       
      sortingOrder : 'id',
      reverse : true
    };
    


    

    $scope.gap = 50;
    
    $scope.groupedItems = [];
    $scope.itemsPerPage = 50;
    $scope.pagedItems = [];
    $scope.currentPage = 0;

    $scope.search = function () {
      $scope.filteredItems = $filter('filter')($scope.items, function (item) {
        for(var attr in item) {

              if (searchMatch(item[attr], $scope.query))
                return true;
            }
            return false;
          });

        if ($scope.sort.sortingOrder !== '') {
          $scope.filteredItems = $filter('orderBy')($scope.filteredItems, $scope.sort.sortingOrder, $scope.sort.reverse);
        }
        $scope.currentPage = 0;
        // now group by pages
        $scope.groupToPages();
      };

      var searchMatch = function (haystack, needle) {
        if (!needle) {
          return true;
        }
        return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
      };

    // init the filtered items
    


    // calculate page in place
    $scope.groupToPages = function () {
      $scope.pagedItems = [];

      for (var i = 0; i < $scope.filteredItems.length; i++) {
        if (i % $scope.itemsPerPage === 0) {
          $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)] = [ $scope.filteredItems[i] ];
        } else {
          $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)].push($scope.filteredItems[i]);
        }
      }
    };
    
    $scope.range = function (size,start, end) {
      var ret = [];        
      if (size < end) {
        end = size;
        start = size-$scope.gap;
      }
      for (var i = start; i < end; i++) {
        ret.push(i);
      }                
      return ret;
    }

    $scope.prevPage = function () {
      if ($scope.currentPage > 0) {
        $scope.currentPage--;
      }
    };

    $scope.nextPage = function () {
      if ($scope.currentPage < $scope.pagedItems.length - 1) {
        $scope.currentPage++;
      }
    };

    $scope.setPage = function () {
      $scope.currentPage = this.n;
    };

    $scope.reload_games = function(){
      if($scope.items == null) {
        $scope.items = games;
      } else {
        api.getGames().then(function(data){
          $scope.items = games;
          $scope.search();
        });
      }
      $scope.search();  
    }; 
    //functions have been describe process the data for display
    $rootScope.$watch('reloadGameTable',function(newVal){
      if(typeof newVal != 'undefined') {
        $scope.reload_games();
        //$rootScope.reloadGameTable = false;
      }

      //$scope.search();
    })

    $scope.reload_games = function(){
      if($scope.items == null) {
       $scope.items = games;

     } else {
      api.getGames().then(function(data){

        $scope.items = data;
        $scope.search();
      });
    }
    $scope.search();  

  };         

  $scope.reload_games();


}])
.controller('allGamesController',['$scope', '$rootScope', '$interval', '$filter', 'api', function ($scope, $rootScope, $interval, $filter, api) {

  $scope.items = null;

  $scope.reload_games = function(){
    api.getAllGames().then(function(data){
      $scope.items = data;
    });
  };         

  $scope.reload_games();

  var pollTimer = $interval($scope.reload_games(),60000)


}])


.controller('tranTableController',['$scope', '$rootScope', '$filter', 'api', 'transactions', function ($scope, $rootScope, $filter, api, transactions) {

    $scope.items = transactions;

    $scope.sort = {       
      sortingOrder : 'id',
      reverse : true
    };
    


    

    $scope.gap = 50;
    
    $scope.groupedItems = [];
    $scope.itemsPerPage = 50;
    $scope.pagedItems = [];
    $scope.currentPage = 0;

    $scope.search = function () {
      $scope.filteredItems = $filter('filter')($scope.items, function (item) {
        for(var attr in item) {

              if (searchMatch(item[attr], $scope.query))
                return true;
            }
            return false;
          });

        if ($scope.sort.sortingOrder !== '') {
          $scope.filteredItems = $filter('orderBy')($scope.filteredItems, $scope.sort.sortingOrder, $scope.sort.reverse);
        }
        $scope.currentPage = 0;
        // now group by pages
        $scope.groupToPages();
      };

      var searchMatch = function (haystack, needle) {
        if (!needle) {
          return true;
        }
        return haystack.toLowerCase().indexOf(needle.toLowerCase()) !== -1;
      };

    // init the filtered items
    


    // calculate page in place
    $scope.groupToPages = function () {
      $scope.pagedItems = [];

      for (var i = 0; i < $scope.filteredItems.length; i++) {
        if (i % $scope.itemsPerPage === 0) {
          $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)] = [ $scope.filteredItems[i] ];
        } else {
          $scope.pagedItems[Math.floor(i / $scope.itemsPerPage)].push($scope.filteredItems[i]);
        }
      }
    };
    
    $scope.range = function (size,start, end) {
      var ret = [];        
      if (size < end) {
        end = size;
        start = size-$scope.gap;
      }
      for (var i = start; i < end; i++) {
        ret.push(i);
      }                
      return ret;
    }

    $scope.prevPage = function () {
      if ($scope.currentPage > 0) {
        $scope.currentPage--;
      }
    };

    $scope.nextPage = function () {
      if ($scope.currentPage < $scope.pagedItems.length - 1) {
        $scope.currentPage++;
      }
    };

    $scope.setPage = function () {
      $scope.currentPage = this.n;
    };

    $scope.reload_trans = function(){
      if($scope.items == null) {
        $scope.items = transactions;
      } else {
        api.getGames().then(function(data){
          $scope.items = data;
          $scope.search();
        });
      }
      $scope.search();  
    }; 
    //functions have been describe process the data for display
    $rootScope.$watch('reloadTranTable',function(newVal){
      if(typeof newVal != 'undefined') {
        console.log('reloading table', newVal)
        $scope.reload_trans();
      }
    })

    $scope.reload_trans = function(){
      if($scope.items == null) {
       $scope.items = transactions;

     } else {
      api.getTransactions().then(function(data){

        $scope.items = data;
        $scope.search();
      });
    }
    $scope.search();  

  };         

  $scope.reload_trans();


}])
.controller('loginController', ['$scope','$rootScope','$state', 'api', 'AuthService', 'AUTH_EVENTS', function($scope,$rootScope, $state, api, AuthService, AUTH_EVENTS) {


  $scope.login_errors = null;
  $scope.password = null;
  $scope.one_time_pass = null;

  $scope.login = function (credentials) {
    AuthService.login(credentials).then(function (user) {
      $rootScope.$broadcast(AUTH_EVENTS.loginSuccess);
      $scope.setCurrentUser(user);
      $state.go('home');
    }, function () {
      $rootScope.$broadcast(AUTH_EVENTS.loginFailed);
    });
  };

  $scope.setCurrentUser = function (user) {
    $rootScope.user = user;
  };

  $scope.logout = function(){
    AuthService.logout().then(function(data){
      console.log(data);
      //$location.path('/login');
    });
  }

  var changeLocation = function(url, forceReload) {
    $scope = $scope || angular.element(document).scope();
    if(forceReload || $scope.$$phase) {
      $window.location = url;
    }
    else {
      $location.path(url);
      $scope.$apply();
    }
  };
}])
.controller('accountSettingsController', ['$scope','$rootScope', 'api',  function($scope,$rootScope,api) {

  $scope.user = $rootScope.user;
  $scope.password_errors = null;

  $scope.setPassword = function(params){
    api.setPassword(params).then(function(data){
      if(undefined != typeof data.error) {
        $scope.password_errors = data.error;
      } else {
        $scope.has_password = true;
        //$location.path('/login');
        
      }
    });
  }
}])

.controller('ModalInstanceCtrl', ['$scope','$rootScope','$modalInstance', 'user',  function($scope,$rootScope,$modalInstance,user) {

  $scope.user = user;;
      // $scope.selected = {
      //   item: $scope.items[0]
      // };

      $scope.ok = function () {
        $modalInstance.close();
      };

      $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
      };




    }]);

angular.module('bitcoinDice').$inject = ['$scope', '$filter'];
