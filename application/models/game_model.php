<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class game_model extends CI_model
{

	function get_game($user_id) {
		$this->load->database();
		$query = $this->db->get_where('games', array('user_id'=>$user_id, 'complete'=>0));
		if($query->num_rows() > 0) {
			$game = $query->row();
			$final_array = json_decode($game->final_array, true);

			if(empty($final_array['roll_1'])) {
				$game->current_roll = array('dice_1'=>'A', 'dice_2'=>'A', 'dice_3'=>'A', 'dice_4'=>'A', 'dice_5'=>'A');
			} elseif (empty($final_array['roll_2'])) {
				$game->current_roll = array(
					"dice_1" => $final_array['roll_1']['1'][0], 
					'dice_2' => $final_array['roll_1']['2'][0], 
					'dice_3' => $final_array['roll_1']['3'][0], 
					'dice_4' => $final_array['roll_1']['4'][0], 
					'dice_5' => $final_array['roll_1']['5'][0]
					);

			} elseif (empty($final_array['roll_3'])) {
				$game->current_roll = array(
					'dice_1' => $final_array['roll_2']['1'][0], 
					'dice_2' => $final_array['roll_2']['2'][0], 
					'dice_3' => $final_array['roll_2']['3'][0], 
					'dice_4' => $final_array['roll_2']['4'][0], 
					'dice_5' => $final_array['roll_2']['5'][0]
					);
			}
			return $game;
		}

		return false;
	}

	function get_game_by_id($game_id) {
		$this->load->database();
		$query = $this->db->get_where('games', array('id'=>$game_id));
		if($query->num_rows() > 0) {
			return $query->row();
		}

		return false;
	}

	function get_games($user_id) {
		$this->load->database();
		//$this->db->select('id');
		$this->db->order_by('id', 'desc');
		$this->db->where(array('user_id'=>$user_id, 'complete' => 1));
		$query = $this->db->get('games');

		if($query->num_rows() > 0) {
			$games = $query->result();
			for($i=0;$i<count($games);$i++) {
				$final_array = json_decode($games[$i]->final_array, true);

				if(empty($final_array['roll_2'])) {
					$roll_num = 1;
				} elseif (empty($final_array['roll_3'])) {
					$roll_num = 2;
				} else {
					$roll_num = 3;
				}

				$roll_array = $final_array['roll_'.$roll_num];

				if(isset($roll_array[1])) {
					$roll = array(
						'dice_1' => $roll_array[1][0],
						'dice_2' => $roll_array[2][0],
						'dice_3' => $roll_array[3][0],
						'dice_4' => $roll_array[4][0],
						'dice_5' => $roll_array[5][0],
						);
				}
				
				if($games[$i]->winning_hand != null) {
					$this->load->config('dice_config');
					$config = $this->config->item('dice_config');
					$games[$i]->winning_hand = $config['hands'][$games[$i]->winning_hand]['name'];
				}
				$games[$i]->result = implode(',',$roll);
				$games[$i]->stake = number_format($games[$i]->stake / 100000000,8);
				$games[$i]->profit = number_format($games[$i]->profit / 100000000,8);
				$games[$i]->rolls = 3 - $games[$i]->rolls_remaining;
				$games[$i]->proof = '';


			}
			return $games;
		} else {
			return false;
		}
	}

	function get_all_games() {
		$this->load->database();
		$this->db->select('games.*');
		$this->db->order_by('id', 'desc');
		$this->db->join('users', 'users.user_id = games.user_id');
		$this->db->where(array('complete' => 1, 'stake >' => 0));
		$this->db->limit('100');
		$query = $this->db->get('games');

		if($query->num_rows() > 0) {
			$games = $query->result();
			for($i=0;$i<count($games);$i++) {
				$final_array = json_decode($games[$i]->final_array, true);

				if(empty($final_array['roll_2'])) {
					$roll_num = 1;
				} elseif (empty($final_array['roll_3'])) {
					$roll_num = 2;
				} else {
					$roll_num = 3;
				}

				$roll_array = $final_array['roll_'.$roll_num];

				if(isset($roll_array[1])) {
					$roll = array(
						'dice_1' => $roll_array[1][0],
						'dice_2' => $roll_array[2][0],
						'dice_3' => $roll_array[3][0],
						'dice_4' => $roll_array[4][0],
						'dice_5' => $roll_array[5][0],
						);
				}
				
				if($games[$i]->winning_hand != null) {
					$this->load->config('dice_config');
					$config = $this->config->item('dice_config');
					$games[$i]->winning_hand = $config['hands'][$games[$i]->winning_hand]['name'];
				}
				$games[$i]->result = implode(',',$roll);
				$games[$i]->stake = number_format($games[$i]->stake / 100000000,8);
				$games[$i]->profit = number_format($games[$i]->profit / 100000000,8);
				$games[$i]->rolls = 3 - $games[$i]->rolls_remaining;
				$games[$i]->proof = '';


			}
			return $games;
		} else {
			return false;
		}
	}

function score_game($roll) {

	$this->load->config('dice_config');
	$config = $this->config->item('dice_config');

	$dice['9'] = 0;
	$dice['10'] = 0;
	$dice['J'] = 0;
	$dice['Q'] = 0;
	$dice['K'] = 0;
	$dice['A'] = 0;

	foreach($roll as $die) {
		$dice[$die] += 1;
	}

	foreach($config['hands'] as $k => $v) {
		$winning_rolls[$k] = false;
	}

	$dice_array = array(
		array('value'=>'9', 'sort' => 1),
		array('value'=>'10','sort' => 2),
		array('value'=>'J', 'sort' => 3),
		array('value'=>'Q', 'sort' => 4),
		array('value'=>'K', 'sort' => 5),
		array('value'=>'A', 'sort' => 6)
		);

	arsort($dice);

	for($i=0;$i<6;$i++) {
		if($dice[$dice_array[$i]['value']] > 4) {
			$winning_rolls['five_kind'] = true;
		} elseif($dice[$dice_array[$i]['value']] == 4) {
			$winning_rolls['four_kind'] = true;
		} elseif($dice[$dice_array[$i]['value']] >= 3) {
			$tmp_dice = $dice;
			unset($tmp_dice[$dice_array[$i]['value']]);
			$other_two = false;
			foreach($tmp_dice as $num) {
				if($num > 1) {
					$other_two = true;
				}
			}
			if($other_two) {
				$winning_rolls['full_house'] = true;
			} else {
				$winning_rolls['triple'] = true;
			}
		} elseif($dice[$dice_array[$i]['value']] >= 2) {
			$tmp_dice = $dice;
			unset($tmp_dice[$dice_array[$i]['value']]);
			$other_two = false;
			foreach($tmp_dice as $num) {
				if($num > 1) {
					$other_two = true;
				}
			}
			if($other_two) {
				$winning_rolls['two_pair'] = true;
			}

		} 
	}

	$straights = array(
		'straight' => array('9','10','J','Q','K'),
		'royal_straight' => array('10','J','Q','K','A')
		);

	foreach($straights['straight'] as $die) {
		if(in_array($die, $roll)) {
			$winning_rolls['straight'] = true;
			continue;
		} else {
			$winning_rolls['straight'] = false;
			break;
		}
	}

	foreach($straights['royal_straight'] as $die) {
		if(in_array($die, $roll)) {
			$winning_rolls['royal_straight'] = true;
			continue;
		} else {
			$winning_rolls['royal_straight'] = false;
			break;
		}
	}

	foreach($winning_rolls as $k => $v) {
		if(!$v) {
			unset($winning_rolls[$k]);
		}
	}

	if(count($winning_rolls) > 0) {
		$winner = array_shift(array_keys($winning_rolls));
	} else {
		$winner = false;
	}

	return $winner;
}

function collect_game($game_id = false){
	$this->load->model('game_model');
	$this->load->config('dice_config');
	$config = $this->config->item('dice_config');

	if($game_id) {
		$game = $this->game_model->get_game_by_id($game_id);
	} else {
		$game = $this->game_model->get_game($this->session->userdata('user_id'));
	}

	$final_array = json_decode($game->final_array, true);

	if(empty($final_array['roll_2'])) {
		$roll_num = 1;
	} elseif (empty($final_array['roll_3'])) {
		$roll_num = 2;
	} else {
		$roll_num = 3;
	}

	$roll_array = $final_array['roll_'.$roll_num];

	$roll = array(
		'dice_1' => $roll_array[1][0],
		'dice_2' => $roll_array[2][0],
		'dice_3' => $roll_array[3][0],
		'dice_4' => $roll_array[4][0],
		'dice_5' => $roll_array[5][0],
		);

	$winner = $this->game_model->score_game($roll);

	$payout = 0;
	$amount = 0;

	$this->load->model('user_model');
	$user = $this->user_model->get_user($this->session->userdata('user_id'));

	if($winner) {
		$payout = $config['hands'][$winner]['payout']['roll_'.$roll_num];
		$this->game_model->update_game($game->id, array('winning_hand' => $winner));
		if($payout > 0) {
			$amount = $game->stake * $payout;
			$this->game_model->update_game($game->id, array('profit' => $amount));
			if($amount > 0) {
				$this->user_model->credit_balance($user->user_id, $amount);
				$this->load->model('transaction_model');
				$this->transaction_model->enter_transaction($user->user_id, 'credit', $amount, $user->available_balance + $amount,  'Game #'.$game->id.' - '.$config['hands'][$winner]['name']. ' Roll #'.$roll_num);
			}
		}
	} else {
		// we may have an affiliate to pay
		if($user->affiliate_user_id) {
			$affiliate_payout = $game->stake * $config['affiliate_percent'];
			$aff_parent = $this->user_model->get_user($user->affiliate_user_id);
			$this->user_model->credit_balance($aff_parent->user_id, $affiliate_payout);
			$this->load->model('transaction_model');
			$this->transaction_model->enter_transaction($aff_parent->user_id, 'credit', $affiliate_payout, $aff_parent->available_balance + $affiliate_payout,  'Affiliate Earnings');
		}
	}

	$this->update_game($game->id, array('complete' => 1));

	if($payout == 0) {
		$winnings = false;
	}

	$response = array('payout' => $payout,
		'roll' => $roll,
		'balance' => $user->available_balance + $amount,
		'rolls_needed' => $roll_num,
		'winnings' =>$winner
		);

	return $response;
}


function update_game($game_id, $update_data) {
	$update_data['updated_on'] = date('Y-m-d H:i:s');
	$this->db->where('id', $game_id);
	$this->db->update('games', $update_data);
}

function create_game($user_id) {

	$this->load->library('guid');

	$dice = array(
		'roll_1' => array(
			1 => array('9','10','J','Q','K','A'),
			2 => array('9','10','J','Q','K','A'),
			3 => array('9','10','J','Q','K','A'),
			4 => array('9','10','J','Q','K','A'),
			5 => array('9','10','J','Q','K','A')
			),
		'roll_2' => array(
			1 => array('9','10','J','Q','K','A'),
			2 => array('9','10','J','Q','K','A'),
			3 => array('9','10','J','Q','K','A'),
			4 => array('9','10','J','Q','K','A'),
			5 => array('9','10','J','Q','K','A')
			),
		'roll_3' => array(
			1 => array('9','10','J','Q','K','A'),
			2 => array('9','10','J','Q','K','A'),
			3 => array('9','10','J','Q','K','A'),
			4 => array('9','10','J','Q','K','A'),
			5 => array('9','10','J','Q','K','A')
			)		
		);

	$server_seeds = array(
		'roll_1' => array(
			1 => md5($this->guid->create_guid().$user_id.time()),
			2 => md5($this->guid->create_guid().$user_id.time()),
			3 => md5($this->guid->create_guid().$user_id.time()),
			4 => md5($this->guid->create_guid().$user_id.time()),
			5 => md5($this->guid->create_guid().$user_id.time())
			),
		'roll_2' => array(
			1 => md5($this->guid->create_guid().$user_id.time()),
			2 => md5($this->guid->create_guid().$user_id.time()),
			3 => md5($this->guid->create_guid().$user_id.time()),
			4 => md5($this->guid->create_guid().$user_id.time()),
			5 => md5($this->guid->create_guid().$user_id.time())
			),
		'roll_3' => array(
			1 => md5($this->guid->create_guid().$user_id.time()),
			2 => md5($this->guid->create_guid().$user_id.time()),
			3 => md5($this->guid->create_guid().$user_id.time()),
			4 => md5($this->guid->create_guid().$user_id.time()),
			5 => md5($this->guid->create_guid().$user_id.time())
			)
		);

	foreach($dice as $k => $v) {
		for($i=1;$i<=count($v);$i++) {
			$dice[$k][$i] = $this->seed_shuffle($dice[$k][$i], $server_seeds[$k][$i]);
		}
	}

	$secret_array = array(
		'server_seeds' => json_encode($server_seeds),
		'initial_array' => json_encode($dice)
		);

	$hash = hash("sha256", json_encode($secret_array));

	$this->load->database();
	$insert_data = array(
		'user_id' => $user_id,
		'initial_array' => $secret_array['initial_array'],
		'final_array' => json_encode(array('roll_1'=>array(),'roll_2'=>array(),'roll_3'=>array())),
		'server_seeds' => $secret_array['server_seeds'],
		'hash' => $hash,
		'created_on' => date('Y-m-d H:i:s'),
		'updated_on' => date('Y-m-d H:i:s')
		);
	$this->db->insert('games', $insert_data);

	return $this->get_game($user_id);
}

function roll($game, $held, $seeds, $stake = 0) {

	$final_array = json_decode($game->final_array, true);
	$client_seeds = json_decode($game->client_seeds, true);
	$complete = false;
		//$seeds = json_decode($roll_data->server_seeds, true);

	if(empty($final_array['roll_1'])) {
		$roll_num = 1;
		$rolls_remaining = 2;
	} elseif (empty($final_array['roll_2'])) {
		$roll_num = 2;
		$rolls_remaining = 1;
	} elseif (empty($final_array['roll_3'])) {
		$roll_num = 3;
		$rolls_remaining = 0;
	}

	$dice = json_decode($game->initial_array, true);

	for($i=1;$i<=count($seeds);$i++) {
		if($seeds[$i] == 'held') {
			$seeds[$i] = '"held" is the one seed you cannot use :( '.rand(1,10000000000);
		}
	}

	for($i=1;$i<=5;$i++) {

		if($roll_num > 1 && is_array($held) && in_array($i, $held)) {
			$num = $roll_num - 1;
			$field = 'roll_'.$num;
			$final_array['roll_'.$roll_num][$i] = $final_array[$field][$i];
			$client_seeds['roll_'.$roll_num][$i] = 'held';
		} else {
			$final_array['roll_'.$roll_num][$i] = $this->seed_shuffle($dice['roll_'.$roll_num][$i], $seeds[$i]);
			$client_seeds['roll_'.$roll_num][$i] = $seeds[$i];
		}
		
	}

	if($roll_num == 3) {
		for($i=1;$i<=5;$i++) {
			//$final_array['house_high'][$i] = $this->seed_shuffle($dice['house_high'][$i], $seeds[$i]);
			$complete = true;
		}
	}



	$this->load->database();
	$update_data = array(
		'user_id' => $game->user_id,
		'complete' => $complete,
		'rolls_remaining' => $rolls_remaining,
		'final_array' => json_encode($final_array),
		'client_seeds' => json_encode($client_seeds),
		'updated_on' => date('Y-m-d H:i:s')
		);

	if($stake) {
		$update_data['stake'] = $stake;
	}


	$this->db->where('id', $game->id);
	$this->db->update('games', $update_data);

	$response = array(
		'roll' => array(
			'dice_1'=>$final_array['roll_'.$roll_num][1][0],
			'dice_2'=>$final_array['roll_'.$roll_num][2][0],
			'dice_3'=>$final_array['roll_'.$roll_num][3][0],
			'dice_4'=>$final_array['roll_'.$roll_num][4][0],
			'dice_5'=>$final_array['roll_'.$roll_num][5][0]
			),
		'rolls_remaining' => $rolls_remaining

		);

	return $response;

}

function seed_shuffle( $items, $seed ) {
	if (is_numeric($seed)) {
		$seedval = $seed;
	} else {
		$seedval = crc32($seed);
	}

	srand($seedval);

	for ($i = count($items) - 1; $i > 0; $i--) {
		$j = @rand(0, $i);
		$tmp = $items[$i];
		$items[$i] = $items[$j];
		$items[$j] = $tmp;
	}

	return $items;
}

}