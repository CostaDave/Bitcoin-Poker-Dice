'use strict';

/* Controllers */

angular.module('bitcoinDice.controllers')
.controller('pokerController',['$scope', '$rootScope', '$interval', '$filter', 'user', 'gameData', 'vpApi', 'appConfig', 'pageConfig', 'lang', 'blockUI', function ($scope, $rootScope, $interval, $filter, user, gameData, vpApi, appConfig, pageConfig, lang, blockUI) {
console.log(appConfig)
$scope.user = $rootScope.user;
$scope.cards = gameData.deal;
$scope.game = gameData;
$rootScope.body_class = pageConfig.body_class;
$scope.pageLang = pageConfig.lang;
$scope.lang = lang;
$scope.paytable = appConfig.vp.default_paytable;
$scope.percent_wagers = appConfig.vp.wager_percents;
$scope.wager_amounts = appConfig.vp.wager_amounts;

var orderBy = $filter('orderBy'),
allCards = blockUI.instances.get('all_cards');
$scope.games = orderBy(appConfig.vp.games, '-name', true);
$scope.pokerHands = orderBy(appConfig.vp.hands, '-name', true);
$scope.identity = angular.identity;

$scope.stake = 0;
$scope.credits = 100;
$scope.all_disabled = false;

$scope.client_seed = get_random_seed();

$scope.held_cards = [];

$scope.draw = function(callback){
	var blocked;

	for(var i=1;i<6;i++) {
		blocked = blockUI.instances.get('card_'+i);
		blocked.stop();
	}

	allCards.stop();

	console.log('deal',$scope.game.deals_remaining);
	if($scope.game.deals_remaining == 2 && $scope.user.available_balance >= $scope.stake) {
		$scope.user.available_balance -= $scope.stake;
	}

  if($scope.user.available_balance < $scope.stake) {
    $scope.stake = 0;
  }
	
	$scope.all_disabled = true;
	$scope.bets_disabled = true;

	var params = {seed:$scope.client_seed,held_cards:$scope.held_cards,stake:$scope.stake,paytable:$scope.paytable};

  vpApi.draw(params).then(function(deal){
  	console.log(params,deal);
    $scope.game.deals_remaining = deal.deals_remaining;
  	if(deal.winning_deals) {
  		$scope.winning_hand = deal.winning_deals;
  	} else {
  		$scope.winning_hand = false;
  	}

  	if(deal.deals_remaining < 1) {
  		$scope.bets_disabled = false;
  		initGame();
  		if(deal.winning_deals) {
  			allCards.start(pageConfig.lang.hands[deal.winning_deals]);
  			console.log('payout',$scope.user.available_balance + appConfig.vp.games[$scope.paytable].hands[deal.winning_deals].payout.bet_1 * $scope.stake)
  			$scope.user.available_balance += parseInt(appConfig.vp.games[$scope.paytable].hands[deal.winning_deals].payout.bet_1 * $scope.stake);
  		} else {
  			allCards.start('Lose');
  		}
  	}


  	//$scope.game = deal;
  	$scope.cards = deal.deal
  	$scope.all_disabled = false;
    $rootScope.reloadGameTableVp = Math.random();
  	//callback();
  })


}

$scope.changePaytable = function(paytable) {

	if(!$scope.bets_disabled) {
		console.log('changing paytable');
		$scope.paytable = paytable;
	}
	
}

$scope.betOne = function(){
	if($scope.stake == appConfig.vp.max_bet) {
		$scope.stake = 1;
	} else {
		$scope.stake++;
	}
}

$scope.betMax = function(){
	$scope.stake = appConfig.vp.max_bet;
}

$scope.addPercentToWager = function(amt) {
	//console.log(amt);

  var wager_amt = 0;
  var max_bet = appConfig.vp.max_bet;

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
	var max_bet = appConfig.vp.max_bet;
  if(amt * 100000000 > $scope.user.available_balance) {
    return false;
  }
  var new_amt = $scope.stake + (amt * 100000000);

  if(new_amt > $scope.user.available_balance) {
    new_amt = $scope.user.available_balance;
  }

  if(new_amt > max_bet) {
    $scope.stake = max_bet;
  } else {
    $scope.stake = new_amt;
  }
}


function initGame(){
	$scope.client_seed = get_random_seed();
  $scope.held_cards = [];
	vpApi.getGame().then(function(game) {
		$scope.game = game;
	})
 }
function get_random_seed(){
  return Math.floor((Math.random() * 1000000000000000) + 1);
}

//initGame();

}])