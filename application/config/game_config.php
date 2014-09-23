<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['game_config']['site_name'] = 'Bitcoin Video Poker';
$config['game_config']['game_type'] = 'vp';
$config['game_config']['guid_secret'] = 'F*KfC!8PuPi*KGiXIa';
$config['game_config']['affiliate_percent'] = .075;
$config['game_config']['demo_mode'] = false;
$config['game_config']['max_bet'] = 100000000;
$config['game_config']['wager_amounts'] = array(.001,.01,.1);
$config['roll_dice_time'] = 3000; //miliseconds
$config['game_config']['games_available'] = array(
	array('name'=>'vp', 'state'=>'videopoker', 'text'=>'Video Poker'),
	//array('name'=>'bj', 'state'=>'blackjack', 'text'=>'Blackjack'),
	array('name'=>'pd', 'state'=>'pokerdice', 'text'=>'Poker Dice'),
	//array('name'=>'rl', 'state'=>'roulette', 'text'=>'Roulette')
);
$config['game_config']['vp']['max_bet'] = 100000000;
$config['game_config']['vp']['wager_amounts'] = array(.001,.01,.1);
$config['game_config']['vp']['wager_percents'] = array(.10,.25,.50);
$config['game_config']['vp']['default_paytable'] = 'jacks_better';
$config['game_config']['vp']['games']['jacks_better'] = array(
	'name' => 'jacks_better',
	'hands' => array(
		 	'jacks_better' => array(
			'name' => 'jacks_better', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 1,
				'bet_2' => 2,
	  		'bet_3' => 3,
	  		'bet_4' => 4,
	  		'bet_5' => 5
		 	)
		),
		 	'two_pair' => array(
			'name' => 'two_pair', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 2,
				'bet_2' => 4,
	  		'bet_3' => 6,
	  		'bet_4' => 8,
	  		'bet_5' => 10
		 	)
		),
		 	'three_kind' => array(
			'name' => 'three_kind', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 3,
				'bet_2' => 6,
	  		'bet_3' => 9,
	  		'bet_4' => 12,
	  		'bet_5' => 15
		 	)
		),
		'straight' => array(
			'name' => 'straight', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 4,
				'bet_2' => 12,
	  		'bet_3' => 18,
	  		'bet_4' => 24,
	  		'bet_5' => 30
		 	)
		),
		'flush' => array(
			'name' => 'flush', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 6,
				'bet_2' => 12,
	  		'bet_3' => 18,
	  		'bet_4' => 24,
	  		'bet_5' => 30
		 	)
		),
		'full_house' => array(
			'name' => 'full_house', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 9,
				'bet_2' => 18,
	  		'bet_3' => 27,
	  		'bet_4' => 36,
	  		'bet_5' => 45
		 	)
		),
		'four_kind' => array(
			'name' => 'four_kind', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 25,
				'bet_2' => 50,
	  		'bet_3' => 75,
	  		'bet_4' => 100,
	  		'bet_5' => 125
		 	)
		),
		'straight_flush' => array(
			'name' => 'straight_flush', 
			'sort' => 7,
			'payout' => array(
				'bet_1' => 50,
				'bet_2' => 100,
	  		'bet_3' => 150,
	  		'bet_4' => 200,
	  		'bet_5' => 250
		 	)
		),
		'royal_flush' => array(
			'name' => 'royal_flush',
			'sort' => 7,
			'payout' => array(
				'bet_1' => 800,
				'bet_2' => 500,
	  		'bet_3' => 750,
	  		'bet_4' => 1000,
	  		'bet_5' => 4000
		 	)
		)
	)
);
$config['game_config']['vp']['games']['tens_better'] = array(
	'name' => 'tens_better',
	'hands' => array(
		 	'tens_better' => array(
			'name' => 'tens_better', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 1,
				'bet_2' => 2,
	  		'bet_3' => 3,
	  		'bet_4' => 4,
	  		'bet_5' => 5
		 	)
		),
		 	'two_pair' => array(
			'name' => 'two_pair', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 2,
				'bet_2' => 4,
	  		'bet_3' => 6,
	  		'bet_4' => 8,
	  		'bet_5' => 10
		 	)
		),
		 	'three_kind' => array(
			'name' => 'three_kind', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 3,
				'bet_2' => 6,
	  		'bet_3' => 9,
	  		'bet_4' => 12,
	  		'bet_5' => 15
		 	)
		),
		'straight' => array(
			'name' => 'straight', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 4,
				'bet_2' => 12,
	  		'bet_3' => 18,
	  		'bet_4' => 24,
	  		'bet_5' => 30
		 	)
		),
		'flush' => array(
			'name' => 'flush', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 5,
				'bet_2' => 12,
	  		'bet_3' => 18,
	  		'bet_4' => 24,
	  		'bet_5' => 30
		 	)
		),
		'full_house' => array(
			'name' => 'full_house', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 6,
				'bet_2' => 18,
	  		'bet_3' => 27,
	  		'bet_4' => 36,
	  		'bet_5' => 45
		 	)
		),
		'four_kind' => array(
			'name' => 'four_kind', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 25,
				'bet_2' => 50,
	  		'bet_3' => 75,
	  		'bet_4' => 100,
	  		'bet_5' => 125
		 	)
		),
		'straight_flush' => array(
			'name' => 'straight_flush', 
			'sort' => 7,
			'payout' => array(
				'bet_1' => 50,
				'bet_2' => 100,
	  		'bet_3' => 150,
	  		'bet_4' => 200,
	  		'bet_5' => 250
		 	)
		),
		'royal_flush' => array(
			'name' => 'royal_flush', 
			'sort' => 7,
			'payout' => array(
				'bet_1' => 800,
				'bet_2' => 500,
	  		'bet_3' => 750,
	  		'bet_4' => 1000,
	  		'bet_5' => 4000
		 	)
		)
	)
);
$config['game_config']['vp']['games']['deuces_wild'] = array(
	'name' => 'deuces_wild',
	'wild_cards' => '2',
	'hands' => array(
		 	'three_kind' => array(
			'name' => 'three_kind', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 2,
				'bet_2' => 6,
	  		'bet_3' => 9,
	  		'bet_4' => 12,
	  		'bet_5' => 15
		 	)
		),
		'straight' => array(
			'name' => 'straight', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 2,
				'bet_2' => 12,
	  		'bet_3' => 18,
	  		'bet_4' => 24,
	  		'bet_5' => 30
		 	)
		),
		'flush' => array(
			'name' => 'flush', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 3,
				'bet_2' => 12,
	  		'bet_3' => 18,
	  		'bet_4' => 24,
	  		'bet_5' => 30
		 	)
		),
		'full_house' => array(
			'name' => 'full_house', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 4,
				'bet_2' => 18,
	  		'bet_3' => 27,
	  		'bet_4' => 36,
	  		'bet_5' => 45
		 	)
		),
		'four_kind' => array(
			'name' => 'four_kind', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 4,
				'bet_2' => 50,
	  		'bet_3' => 75,
	  		'bet_4' => 100,
	  		'bet_5' => 125
		 	)
		),
		'straight_flush' => array(
			'name' => 'straight_flush', 
			'sort' => 7,
			'payout' => array(
				'bet_1' => 10,
				'bet_2' => 100,
	  		'bet_3' => 150,
	  		'bet_4' => 200,
	  		'bet_5' => 250
		 	)
		),
		'five_kind' => array(
			'name' => 'five_kind', 
			'sort' => 7,
			'payout' => array(
				'bet_1' => 15,
				'bet_2' => 100,
	  		'bet_3' => 150,
	  		'bet_4' => 200,
	  		'bet_5' => 250
		 	)
		),
		'wild_royal_flush' => array(
			'name' => 'wild_royal_flush', 
			'sort' => 7,
			'payout' => array(
				'bet_1' => 25,
				'bet_2' => 100,
	  		'bet_3' => 150,
	  		'bet_4' => 200,
	  		'bet_5' => 250
		 	)
		),
		'four_deuces' => array(
			'name' => 'four_deuces', 
			'sort' => 7,
			'payout' => array(
				'bet_1' => 200,
				'bet_2' => 100,
	  		'bet_3' => 150,
	  		'bet_4' => 200,
	  		'bet_5' => 250
		 	)
		),
		'royal_flush' => array(
			'name' => 'nat_royal_flush', 
			'sort' => 7,
			'payout' => array(
				'bet_1' => 800,
				'bet_2' => 500,
	  		'bet_3' => 750,
	  		'bet_4' => 1000,
	  		'bet_5' => 4000
		 	)
		)
	)
);
$config['game_config']['vp']['games']['bonus'] = array(
	'name' => 'bonus',
	'hands' => array(
		 	'jacks_better' => array(
			'name' => 'jacks_better', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 1,
				'bet_2' => 2,
	  		'bet_3' => 3,
	  		'bet_4' => 4,
	  		'bet_5' => 5
		 	)
		),
		 	'two_pair' => array(
			'name' => 'two_pair', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 2,
				'bet_2' => 4,
	  		'bet_3' => 6,
	  		'bet_4' => 8,
	  		'bet_5' => 10
		 	)
		),
		 	'three_kind' => array(
			'name' => 'three_kind', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 3,
				'bet_2' => 6,
	  		'bet_3' => 9,
	  		'bet_4' => 12,
	  		'bet_5' => 15
		 	)
		),
		'straight' => array(
			'name' => 'straight', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 4,
				'bet_2' => 12,
	  		'bet_3' => 18,
	  		'bet_4' => 24,
	  		'bet_5' => 30
		 	)
		),
		'flush' => array(
			'name' => 'flush', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 5,
				'bet_2' => 12,
	  		'bet_3' => 18,
	  		'bet_4' => 24,
	  		'bet_5' => 30
		 	)
		),
		'full_house' => array(
			'name' => 'full_house', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 8,
				'bet_2' => 18,
	  		'bet_3' => 27,
	  		'bet_4' => 36,
	  		'bet_5' => 45
		 	)
		),
		'four_5-k' => array(
			'name' => 'four_5_K', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 25,
				'bet_2' => 50,
	  		'bet_3' => 75,
	  		'bet_4' => 100,
	  		'bet_5' => 125
		 	)
		),
		'four_2-4' => array(
			'name' => 'four_2_4', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 40,
				'bet_2' => 50,
	  		'bet_3' => 75,
	  		'bet_4' => 100,
	  		'bet_5' => 125
		 	)
		),
		'four_aces' => array(
			'name' => 'four_aces', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 80,
				'bet_2' => 50,
	  		'bet_3' => 75,
	  		'bet_4' => 100,
	  		'bet_5' => 125
		 	)
		),
		'straight_flush' => array(
			'name' => 'straight_flush', 
			'sort' => 7,
			'payout' => array(
				'bet_1' => 50,
				'bet_2' => 100,
	  		'bet_3' => 150,
	  		'bet_4' => 200,
	  		'bet_5' => 250
		 	)
		),
		'royal_flush' => array(
			'name' => 'royal_flush', 
			'sort' => 7,
			'payout' => array(
				'bet_1' => 800,
				'bet_2' => 500,
	  		'bet_3' => 750,
	  		'bet_4' => 1000,
	  		'bet_5' => 4000
		 	)
		)
	)
);
$config['game_config']['vp']['games']['double_bonus'] = array(
	'name' => 'double_bonus',
	'hands' => array(
		 	'jacks_better' => array(
			'name' => 'jacks_better', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 1,
				'bet_2' => 2,
	  		'bet_3' => 3,
	  		'bet_4' => 4,
	  		'bet_5' => 5
		 	)
		),
		 	'two_pair' => array(
			'name' => 'two_pair', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 1,
				'bet_2' => 4,
	  		'bet_3' => 6,
	  		'bet_4' => 8,
	  		'bet_5' => 10
		 	)
		),
		 	'three_kind' => array(
			'name' => 'three_kind', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 3,
				'bet_2' => 6,
	  		'bet_3' => 9,
	  		'bet_4' => 12,
	  		'bet_5' => 15
		 	)
		),
		'straight' => array(
			'name' => 'straight', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 5,
				'bet_2' => 12,
	  		'bet_3' => 18,
	  		'bet_4' => 24,
	  		'bet_5' => 30
		 	)
		),
		'flush' => array(
			'name' => 'flush', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 7,
				'bet_2' => 12,
	  		'bet_3' => 18,
	  		'bet_4' => 24,
	  		'bet_5' => 30
		 	)
		),
		'full_house' => array(
			'name' => 'full_house', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 10,
				'bet_2' => 18,
	  		'bet_3' => 27,
	  		'bet_4' => 36,
	  		'bet_5' => 45
		 	)
		),
		'four_5-k' => array(
			'name' => 'four_5_K', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 45,
				'bet_2' => 50,
	  		'bet_3' => 75,
	  		'bet_4' => 100,
	  		'bet_5' => 125
		 	)
		),
		'four_2-4' => array(
			'name' => 'four_2_4', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 80,
				'bet_2' => 50,
	  		'bet_3' => 75,
	  		'bet_4' => 100,
	  		'bet_5' => 125
		 	)
		),
		'four_aces' => array(
			'name' => 'four_aces', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 160,
				'bet_2' => 50,
	  		'bet_3' => 75,
	  		'bet_4' => 100,
	  		'bet_5' => 125
		 	)
		),
		'straight_flush' => array(
			'name' => 'straight_flush', 
			'sort' => 7,
			'payout' => array(
				'bet_1' => 60,
				'bet_2' => 100,
	  		'bet_3' => 150,
	  		'bet_4' => 200,
	  		'bet_5' => 250
		 	)
		),
		'royal_flush' => array(
			'name' => 'royal_flush', 
			'sort' => 7,
			'payout' => array(
				'bet_1' => 800,
				'bet_2' => 500,
	  		'bet_3' => 750,
	  		'bet_4' => 1000,
	  		'bet_5' => 4000
		 	)
		)
	)
);
$config['game_config']['vp']['games']['dbl_dbl_bonus'] = array(
	'name' => 'dbl_dbl_bonus',
	'hands' => array(
		 	'jacks_better' => array(
			'name' => 'jacks_better', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 1,
				'bet_2' => 2,
	  		'bet_3' => 3,
	  		'bet_4' => 4,
	  		'bet_5' => 5
		 	)
		),
		 	'two_pair' => array(
			'name' => 'two_pair', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 1,
				'bet_2' => 4,
	  		'bet_3' => 6,
	  		'bet_4' => 8,
	  		'bet_5' => 10
		 	)
		),
		 	'three_kind' => array(
			'name' => 'three_kind', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 3,
				'bet_2' => 6,
	  		'bet_3' => 9,
	  		'bet_4' => 12,
	  		'bet_5' => 15
		 	)
		),
		'straight' => array(
			'name' => 'straight', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 4,
				'bet_2' => 12,
	  		'bet_3' => 18,
	  		'bet_4' => 24,
	  		'bet_5' => 30
		 	)
		),
		'flush' => array(
			'name' => 'flush', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 6,
				'bet_2' => 12,
	  		'bet_3' => 18,
	  		'bet_4' => 24,
	  		'bet_5' => 30
		 	)
		),
		'full_house' => array(
			'name' => 'full_house', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 9,
				'bet_2' => 18,
	  		'bet_3' => 27,
	  		'bet_4' => 36,
	  		'bet_5' => 45
		 	)
		),
		'four_5_K' => array(
			'name' => 'four_5_K', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 50,
				'bet_2' => 50,
	  		'bet_3' => 75,
	  		'bet_4' => 100,
	  		'bet_5' => 125
		 	)
		),
		'four_2_4' => array(
			'name' => 'four_2_4', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 80,
				'bet_2' => 50,
	  		'bet_3' => 75,
	  		'bet_4' => 100,
	  		'bet_5' => 125
		 	)
		),
		'four_aces' => array(
			'name' => 'four_aces', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 160,
				'bet_2' => 50,
	  		'bet_3' => 75,
	  		'bet_4' => 100,
	  		'bet_5' => 125
		 	)
		),
		'four_aces_2_4' => array(
			'name' => 'four_aces_2_4', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 460,
				'bet_2' => 50,
	  		'bet_3' => 75,
	  		'bet_4' => 100,
	  		'bet_5' => 125
		 	)
		),
		'four_2_4_a_4' => array(
			'name' => 'four_2_4_a_4', 
			'sort' => 1,
			'payout' => array(
				'bet_1' => 160,
				'bet_2' => 50,
	  		'bet_3' => 75,
	  		'bet_4' => 100,
	  		'bet_5' => 125
		 	)
		),
		
		'straight_flush' => array(
			'name' => 'straight_flush', 
			'sort' => 7,
			'payout' => array(
				'bet_1' => 60,
				'bet_2' => 100,
	  		'bet_3' => 150,
	  		'bet_4' => 200,
	  		'bet_5' => 250
		 	)
		),
		'royal_flush' => array(
			'name' => 'royal_flush', 
			'sort' => 7,
			'payout' => array(
				'bet_1' => 800,
				'bet_2' => 500,
	  		'bet_3' => 750,
	  		'bet_4' => 1000,
	  		'bet_5' => 4000
		 	)
		)
	)
);
$config['game_config']['pd']['hands'] = array(
	'five_kind' => array(
		'name' => 'five_kind', 
		'sort' => 7,
		'payout' => array(
			'roll_1' => 150,
			'roll_2' => 20,
  		'roll_3' => 10
	 	)
	),
	'four_kind' => array(
		'name' => 'four_kind', 
		'sort' => 3,
		'payout' => array(
			'roll_1' => 10,
			'roll_2' => 3,
  		'roll_3' => 2
	 	)
	),
	'royal_straight' => array(
		'name' => 'royal_straight', 
		'sort' => 6,
		'payout' => array(
			'roll_1' => 8,
			'roll_2' => 2,
  		'roll_3' => 1
	 	)
	),
	'straight' => array(
		'name' => 'straight', 
		'sort' => 5,
		'payout' => array(
			'roll_1' => 5,
			'roll_2' => 1.5,
  		'roll_3' => .5
	 	)
	),
	'full_house' => array(
		'name' => 'full_house', 
		'sort' => 4,
		'payout' => array(
			'roll_1' => 4,
			'roll_2' => 1,
  		'roll_3' => .25
	 	)
	),
	'triple' => array(
		'name' => 'triple', 
		'sort' => 3,
		'payout' => array(
			'roll_1' => 1,
			'roll_2' => .5,
  		'roll_3' => 0
	 	)
	),
	'two_pair' => array(
		'name' => 'two_pair',
		'sort' => 2,
		'payout' => array(
			'roll_1' => .5,
			'roll_2' => .25,
  		'roll_3' => 0
	 	)
	)
);

