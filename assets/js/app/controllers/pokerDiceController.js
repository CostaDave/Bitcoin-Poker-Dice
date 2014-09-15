'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('pokerDiceController', ['$scope','$rootScope','AuthService', 'appConfig', 'lang', '$interval', '$modal', '$timeout', 'user', 'AUTH_EVENTS', 'pdApi','pageConfig', function($scope, $rootScope, AuthService, appConfig, lang, $interval, $modal, $timeout, user, AUTH_EVENTS, pdApi, pageConfig) {
 
 $scope.pageLang = pageConfig.lang;
 $rootScope.lang = lang;
 $rootScope.config = appConfig;
 $scope.user = user;
 $rootScope.user = user;
 $rootScope.user_balance = user.available_balance;
 $scope.user_balance = $rootScope.user_balance;
 $scope.sound_muted = false;
 //$rootScope.next_hash = user.next_hash;

 $scope.hands = appConfig.pd.hands;
 // $scope.predicate = '-sort';

 $scope.stake = 0;
 $scope.stake_held = false;
 $scope.wager_amounts = $rootScope.config.wager_amounts;
 $scope.percent_wagers = [
 {'text':'10%','amt':.10},
 {'text':'25%','amt':.25},
 {'text':'50%','amt':.50}
 ];

 function initGame(){
  $scope.client_seed = get_random_seed();
  pdApi.getGame().then(function(game) {
    $scope.game = game;
    $scope.dice = game.dice;
    $scope.new_game = game.rolls_remaining > 2 ? true:false;
    $scope.rolls_remaining = game.rolls_remaining;
    initScreen(game);
  })
 }

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


  
  $scope.seeds = {};
  $scope.seeds.seed_1 = get_random_seed();
  $scope.seeds.seed_2 = get_random_seed();
  $scope.seeds.seed_3 = get_random_seed();
  $scope.seeds.seed_4 = get_random_seed();
  $scope.seeds.seed_5 = get_random_seed();
  $rootScope.dice = $scope.dice;

initGame();
//$scope.game = game;
//console.log(appConfig)

$scope.screenState;
$scope.held_dice = [];
$scope.winning_hand = 'Royal Straight';


$scope.dice_rolling = false;




$rootScope.seeds = $scope.seeds;
$rootScope.held_dice = $scope.held_dice;




var roll_button = $('.btn-roll'),
collect_button = $('.btn-collect');

function initScreen(game){
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
      pdApi.collectWin().then(function(response){
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


    $scope.roll = function(){
      $scope.dice_rolling = true;
      
      
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

      pdApi.rollDice(params).then(function(roll){
        rollDiceSound.play();
        $scope.dice = roll.roll;
        $scope.rolls_remaining = $scope.rolls_remaining - 1;
        
        if(roll.rolls_remaining === 0) {
          var timeout = $timeout(function() {
            pdApi.getGame().then(function(data){
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