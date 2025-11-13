<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['dice_config']['site_name'] = 'Bitcoin Poker Dice';
$config['dice_config']['guid_secret'] = 'F*KfC!8PuPi*KGiXIa';
$config['dice_config']['affiliate_percent'] = .075;
$demo_mode_env = getenv('GAME_DEMO_MODE');
$config['dice_config']['demo_mode'] = ($demo_mode_env !== false) ? filter_var($demo_mode_env, FILTER_VALIDATE_BOOLEAN) : false;
$config['dice_config']['max_bet'] = 100000000;
$config['dice_config']['wager_amounts'] = array(.001,.01,.1);
$config['roll_dice_time'] = 3000; //miliseconds
$config['dice_config']['hands'] = array(
	'five_kind' => array(
		'name' => '5 of a kind', 
		'sort' => 7,
		'payout' => array(
			'roll_1' => 150,
			'roll_2' => 20,
  		'roll_3' => 10
	 	)
	),
	'four_kind' => array(
		'name' => '4 of a kind', 
		'sort' => 3,
		'payout' => array(
			'roll_1' => 10,
			'roll_2' => 3,
  		'roll_3' => 2
	 	)
	),
	'royal_straight' => array(
		'name' => 'R. Straight', 
		'sort' => 6,
		'payout' => array(
			'roll_1' => 8,
			'roll_2' => 2,
  		'roll_3' => 1
	 	)
	),
	'straight' => array(
		'name' => 'Straight', 
		'sort' => 5,
		'payout' => array(
			'roll_1' => 5,
			'roll_2' => 1.5,
  		'roll_3' => .5
	 	)
	),
	'full_house' => array(
		'name' => 'Full House', 
		'sort' => 4,
		'payout' => array(
			'roll_1' => 4,
			'roll_2' => 1,
  		'roll_3' => .25
	 	)
	),
	'triple' => array(
		'name' => '3 of a kind', 
		'sort' => 3,
		'payout' => array(
			'roll_1' => 1,
			'roll_2' => .5,
  		'roll_3' => 0
	 	)
	),
	'two_pair' => array(
		'name' => '2 Pairs',
		'sort' => 2,
		'payout' => array(
			'roll_1' => .5,
			'roll_2' => .25,
  		'roll_3' => 0
	 	)
	)
);

