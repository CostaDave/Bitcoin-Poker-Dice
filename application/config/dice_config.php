<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['dice_config']['max_bet'] = 100000000;
$config['dice_config']['wager_amounts'] = array(.001,.01,.1);
$config['roll_dice_time'] = 3000; //miliseconds
$config['dice_config']['odds'] = array(
	'five_kind' => array(
		'name' => '5 of a kind', 
		'sort' => 7,
		'payout' => array(
			'roll_1' => 150,
			'roll_2' => 20,
  		'roll_3' => 10
	 	), 
		'odds' => .08
	),
	'four_kind' => array(
		'name' => '4 of a kind', 
		'sort' => 3,
		'payout' => array(
			'roll_1' => 10,
			'roll_2' => 3,
  		'roll_3' => 2
	 	), 
		'odds' => 1.93
	),
	'royal_straight' => array(
		'name' => 'R. Straight', 
		'sort' => 6,
		'payout' => array(
			'roll_1' => 8,
			'roll_2' => 2,
  		'roll_3' => 1
	 	), 
		'odds' => 3.09
	),
	'straight' => array(
		'name' => 'Straight', 
		'sort' => 5,
		'payout' => array(
			'roll_1' => 5,
			'roll_2' => 1.5,
  		'roll_3' => .5
	 	), 
		'odds' => 0
	),
	'full_house' => array(
		'name' => 'Full House', 
		'sort' => 4,
		'payout' => array(
			'roll_1' => 4,
			'roll_2' => 1,
  		'roll_3' => .25
	 	), 
		'odds' => 3.86
	),
	'triple' => array(
		'name' => '3 of a kind', 
		'sort' => 3,
		'payout' => array(
			'roll_1' => 1,
			'roll_2' => .5,
  		'roll_3' => 0
	 	),
		'odds' => 15.43
	),
	'two_pair' => array(
		'name' => '2 Pairs',
		'sort' => 2,
		'payout' => array(
			'roll_1' => .5,
			'roll_2' => .25,
  		'roll_3' => 0
	 	), 
		'odds' => 23.15
	)
);

