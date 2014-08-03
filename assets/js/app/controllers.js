'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers', [])
.controller('AppCtrl', ['$scope','$rootScope', 'appConfig', '$interval', '$modal', '$timeout', 'userData', 'user', 'game', 'diceService', function($scope, $rootScope, appConfig, $interval, $modal, $timeout, userData, user, game, diceService) {
 console.log(appConfig);
 console.log(game);
 $rootScope.config = appConfig;
 $scope.user = user;
 $rootScope.user = $scope.user;
 $rootScope.user_balance = user.available_balance;
 $scope.user_balance = $rootScope.user_balance;
 //$rootScope.next_hash = user.next_hash;

 $scope.odds = appConfig.odds;
 $scope.predicate = '-sort';

 $scope.stake = 0;
 $scope.stake_held = false;
 $scope.wager_amounts = $rootScope.config.wager_amounts;
 $scope.percent_wagers = [
 {'text':'10%','amt':.10},
 {'text':'25%','amt':.25},
 {'text':'50%','amt':.50}
 ];

 $scope.dice = {};
 $scope.dice.dice_1 = 'A';
 $scope.dice.dice_2 = 'A';
 $scope.dice.dice_3 = 'A';
 $scope.dice.dice_4 = 'A';
 $scope.dice.dice_5 = 'A';

 var pollTimer = $interval(getUser,15000)

 function getUser(){
  userData.getUser().then(function(data){
    if(data.data.available_balance > $scope.user.available_balance) {
      depositSound.play();
    }
    $scope.user = data.data;
    $rootScope.user = data.data;
    $scope.user.available_balance = data.data.available_balance;
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
        //console.log('new game')
        changeScreenState('new');
      } else {
        changeScreenState('inplay');
      }
    }

    function changeScreenState(state) {
      //console.log('new screen state', state)
      $scope.screenState = state;
    }

    function get_random_seed(){
      return Math.floor((Math.random() * 1000000000000000) + 1);
    }

    $scope.toggleHold = function(dice){
      clickDiceSound.play();
      
      if($.inArray(dice, $scope.held_dice) > -1) { 
        remove($scope.held_dice, dice);
        $('#dice_'+dice).unwrap();
      } else {
        $scope.held_dice.push(dice);
        $('#dice_'+dice).wrap('<strong></strong>');
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
      $rootScope.reloadGameTable = Math.random();;
      unhold_dice();

      if($scope.user.available_balance > 0) {
        $('.wager-buttons').removeClass('disabled');
      }

      $scope.stake_held = false;

      roll_button.html('New Game');

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
        $scope.winning_hand = $rootScope.config.odds[response.winnings].name;
        $scope.winning_rolls_needed = response.rolls_needed;
        $scope.last_roll = response.roll;
        console.log($rootScope.config.odds[response.winnings].payout[response.rolls_needed]);
        $scope.winning_payout = $rootScope.config.odds[response.winnings].payout['roll_'+response.rolls_needed];
        diceService.get_game().then(function(data){
          $scope.game = data;
          changeScreenState('result-winner');
          setupNewGame();
        });
        
        
        //$scope.seeds.house_high = get_random_seed();
      });


    }


    $scope.roll_dice = function(){
      console.log($scope.game);  
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

      diceService.roll_dice(params).then(function(roll){
        $scope.dice = roll.roll;
        $scope.rolls_remaining = roll.rolls_remaining;
        
        if(roll.rolls_remaining === 0) {
          var timeout = $timeout(function() {
            diceService.get_game().then(function(data){
              $scope.game = data;
              
              if(roll.winning_rolls && $rootScope.config.odds[roll.winning_rolls].payout.roll_3 > 0) {
                winnerSound.play();
                changeScreenState('result-winner');
                $scope.winning_hand = $rootScope.config.odds[roll.winning_rolls].name;
                $scope.winning_rolls_needed = 3;
                console.log($rootScope.config.odds[roll.winning_rolls]);
                $scope.winning_payout = $rootScope.config.odds[roll.winning_rolls].payout.roll_3;
                $scope.user.available_balance = roll.balance;
              } else {
                loserSound.play();
                console.log('roll', roll.roll)

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
  url: '/assets/mp3/winner.mp3',
  volume: 100
});

var loserSound = soundManager.createSound({
  url: '/assets/mp3/loser.mp3',
  volume: 100
});
    // $scope.$watch(function (){return $rootScope.held_dice;},
    // function (newVal) {
    //    $scope.game = $rootScope.game;
    //    $scope.rolls_remaining = $rootScope.rolls_remaining;

    // });


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
  console.log('opening seed modal')

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
      //size: size,
      resolve: {
        user: function () {
          return $scope.user;
        }
      }
    });







  modalInstance.result.then(function (selectedItem) {
    $scope.selected = selectedItem;
  }, function () {
      //$log.info('Modal dismissed at: ' + new Date());
    });

  $scope.ok = function () {
    $modalInstance.close();
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
};


}])
.controller('navController',['$scope', function($scope){
  $scope.sound_muted = false;
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
.controller('payoutController',['$scope', '$rootScope', 'config', function($scope, $rootScope, config){
  $scope.odds =config.odds;
}])
.controller('depositController',['$scope', '$rootScope', 'user', function($scope, $rootScope, user){
  $scope.user = user;
}])
.controller('tabController', ['$scope', 'DTOptionsBuilder', 'DTColumnBuilder', function($scope, DTOptionsBuilder, DTColumnBuilder){
  $scope.tabs = [
  { title:'Dynamic Title 1', content:'Dynamic content 1' },
  { title:'Dynamic Title 2', content:'Dynamic content 2', disabled: true }
  ];

  $scope.mygames_dtOptions = DTOptionsBuilder
        //.newOptions()
        .fromSource('api/getGames')
        .withOption('order', [1, 'desc'])
        .withBootstrap()
        .withPaginationType('full_numbers');
        $scope.allgames_dtOptions = DTOptionsBuilder
        //.newOptions()
        .fromSource('api/getGames/all')
        .withOption('order', [1, 'desc'])
        .withBootstrap()
        .withPaginationType('full_numbers');      
        var dtColumns = [
        DTColumnBuilder.newColumn('id').withTitle('ID'),
        DTColumnBuilder.newColumn('updated_on').withTitle('Date'),
        DTColumnBuilder.newColumn('result').withTitle('Result'),
        DTColumnBuilder.newColumn('stake').withTitle('Stake'),
        DTColumnBuilder.newColumn('winning_hand').withTitle('Winning Hand'),
        DTColumnBuilder.newColumn('rolls').withTitle('Rolls'),
        DTColumnBuilder.newColumn('profit').withTitle('Profit'),
        DTColumnBuilder.newColumn('proof').withTitle('Proof')
        ];


  //$scope.mygames_dtOptions = dtOptions;

  $scope.mygames_dtColumns = dtColumns;
  $scope.allgames_dtColumns = dtColumns;

  
}])
.controller('proofController', ['$scope', function($scope){
  $scope.tabs = [
  ];

  

  
}])
.controller('ctrlRead',['$scope', '$rootScope', '$filter', 'diceService', 'api', 'games', function ($scope, $rootScope, $filter, diceService, api, games) {

    // init
    console.log(games);
    $scope.items = null;

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
              //console.log(attr)
              if (searchMatch(item[attr], $scope.query))
                return true;
            }
            return false;
          });

        //console.log('here',$scope.filteredItems)
        // take care of the sorting order
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
          console.log(data);
          $scope.search();
        });
      }
      $scope.search();  
    }; 
    //functions have been describe process the data for display
    $rootScope.$watch('reloadGameTable',function(newVal){
      if(typeof newVal != 'undefined') {
        console.log('reloading table', newVal)
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


.controller('ModalInstanceCtrl', ['$scope','$rootScope','$modalInstance', 'user', function($scope,$rootScope,$modalInstance,user) {

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
