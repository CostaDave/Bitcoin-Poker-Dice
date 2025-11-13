<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class game_model_vp extends CI_model
{	

	function __construct(){
		$this->whole_deck = $deck = array(
		'2C','3C','4C','5C','6C','7C','8C','9C','10C','JC','QC','KC','AC',
		'2H','3H','4H','5H','6H','7H','8H','9H','10H','JH','QH','KH','AH',
		'2D','3D','4D','5D','6D','7D','8D','9D','10D','JD','QD','KD','AD',
		'2S','3S','4S','5S','6S','7S','8S','9S','10S','JS','QS','KS','AS'
	);
	}

	function get_game($user_id) {
		$this->load->database();
		$query = $this->db->get_where('games', array('user_id'=>$user_id,'game_type' =>'videopoker', 'complete'=>0));
		if($query->num_rows() > 0) {
			$game = $query->row();
			$final_array = json_decode($game->final_array, true);

			if(empty($final_array['deal_1'])) {
				$game->current_deal = array('card_1'=>null, 'card_2'=>null, 'card_3'=>null, 'card_4'=>null, 'card_5'=>null);
			} elseif (empty($final_array['deal_2'])) {
				$game->current_deal = array(
					"card_1" => $final_array['deal_1'][1], 
					'card_2' => $final_array['deal_1'][2], 
					'card_3' => $final_array['deal_1'][3], 
					'card_4' => $final_array['deal_1'][4], 
					'card_5' => $final_array['deal_1'][5]
					);

			} else {
				$game->current_deal = array(
					'card_1' => $final_array['deal_2'][1], 
					'card_2' => $final_array['deal_2'][2], 
					'card_3' => $final_array['deal_2'][3], 
					'card_4' => $final_array['deal_2'][4], 
					'card_5' => $final_array['deal_2'][5]
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

	function get_games($user_id, $global = false) {
		$this->load->database();
		//$this->db->select('id');
		$this->db->order_by('id', 'desc');
		if(!$global) {
			$this->db->where(array('user_id'=>$user_id));
		}
		$this->db->where(array('complete' => 1,'game_type'=>'videopoker'));
		$query = $this->db->get('games');

		if($query->num_rows() > 0) {
			$games = $query->result();
			for($i=0;$i<count($games);$i++) {
				$final_array = json_decode($games[$i]->final_array, true);

				if(empty($final_array['deal_2'])) {
					$deal_num = 1;
				} elseif (empty($final_array['deal_3'])) {
					$deal_num = 2;
				} else {
					$deal_num = 3;
				}

				$deal_array = $final_array['deal_'.$deal_num];

				if(isset($deal_array[1])) {
					$deal = array(
						'dice_1' => $deal_array[1],
						'dice_2' => $deal_array[2],
						'dice_3' => $deal_array[3],
						'dice_4' => $deal_array[4],
						'dice_5' => $deal_array[5],
						);
				}
				
				if($games[$i]->winning_hand != null) {
					$this->load->config('game_config');
					$config = $this->config->item('game_config');
					$games[$i]->winning_hand = $config['vp']['games'][$games[$i]->paytable]['hands'][$games[$i]->winning_hand]['name'];
				}
				$games[$i]->result = implode(',',$deal);
				$games[$i]->stake = number_format($games[$i]->stake / 100000000,8);
				$games[$i]->profit = number_format($games[$i]->profit / 100000000,8);
				$games[$i]->deals = 2 - $games[$i]->rolls_remaining;
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

function check_royal_flush($cards, $wild_card) {
	//echo 'checking royal flush';
	// first check to see if it's a flush
	if(!$this->check_flush($cards, $wild_card)) {
		//echo 'no flush!';
		return false;
	} 

	if(!$this->check_straight($cards,$wild_card, true)) {
		return false;
	}

	return true; 
}

function check_wild_royal_flush($cards, $wild_card) {

	$num_wild = $this->get_number_of_rank($wild_card, $cards);
	// first check to see if it's a flush
	if(!$this->check_flush($cards,$wild_card)) {
		//echo 'no flush';
		return false;
	}

	if(!$this->check_straight($cards,$wild_card, true)) {
		return false;
	}
	//echo "this is a wild royal flush<br/>";
	return true; 
}

function check_nat_royal_flush($cards, $wild_card) {
	$num_wild = $this->get_number_of_rank($wild_card, $cards);
	if($num_wild > 0) {
		//echo 'has wild so no natural royal<br>';
		return false;
	}
	return $this->check_royal_flush($cards, $wild_card);
}

function check_four_deuces($cards, $wild_card) {
	// first check to see if it's a flush
	if($this->get_number_of_rank('2', $cards) > 3) {
		return true;
	} 
	//echo 'does not have four twos<br>';
	return false;; 
}

function check_four_aces($cards, $wild_card) {
	// first check to see if it's a flush
	return $this->check_num_of_a_kind($cards,4) && in_array($this->check_num_of_a_kind($cards,4),array('A'));
}

function check_four_aces_2_4($cards, $wild_card) {

	if(!$this->check_num_of_a_kind($cards,4) || !in_array($this->check_num_of_a_kind($cards,4),array('A'))) {
		return false;
	} 

	return in_array($this->check_num_of_a_kind($cards,1,0,'A'),array('2','3','4'));

}

function check_four_2_4($cards, $wild_card) {
	return $this->check_num_of_a_kind($cards,4) && in_array($this->check_num_of_a_kind($cards,4),array('2','3','4'));
}

function check_four_2_4_a_4($cards, $wild_card) {
	if(!$this->check_num_of_a_kind($cards,4) || !in_array($this->check_num_of_a_kind($cards,4),array('2','3','4'))) {
		return false;
	}

	return in_array($this->check_num_of_a_kind($cards,1,0,$this->check_num_of_a_kind($cards,4)),array('A','2','3','4'));
}
function check_four_5_K($cards, $wild_card) {
	return $this->check_num_of_a_kind($cards,4) && in_array($this->check_num_of_a_kind($cards,4),array('5','6','7','8','9','10','J','Q','K'));
}

function check_straight_flush($cards, $wild_card) {

	if(!$this->check_flush($cards, $wild_card)) {
		return false;
	}

	if(!$this->check_straight($cards, $wild_card)) {
		return false;
	}
	
	return true;
}

function check_full_house($cards, $wild_card) {
	// echo 'checking full house';
	// check to see if there is at least a natural pair
	if(!$this->check_num_of_a_kind($cards,2,0,$wild_card)) {
		return false;
	} else {
		// $two_part = $this->check_num_of_a_kind($cards,2,0,$wild_card);
		// echo $this->check_num_of_a_kind($cards,2,0,$wild_card);
		// echo $this->check_num_of_a_kind($cards,3,$wild_card, $two_part);
	}

	// now check for a two of a kind that excludes the first one.
	$two_part = $this->check_num_of_a_kind($cards,2,0,$wild_card);

	if(!$this->check_num_of_a_kind($cards,3,$wild_card, $two_part)) {
		return false;
	} else {
		//echo $this->check_num_of_a_kind($cards,3,$wild_card, $two_part);
	}
	
	//echo '<br>';
	return true;
}

function check_jacks_better($cards) {
	return $this->check_num_of_a_kind($cards,2) && in_array($this->check_num_of_a_kind($cards,2),array('J','Q','K','A'));
}

function check_tens_better($cards) {
	return $this->check_num_of_a_kind($cards,2) && in_array($this->check_num_of_a_kind($cards,2),array('10','J','Q','K','A'));
}

function check_two_pair($cards) {
	if(!$this->check_num_of_a_kind($cards,2,0)) {
		return false;
	}

	// now check for a two of a kind that excludes the first one.
	$first_pair = $this->check_num_of_a_kind($cards,2);

	if(!$this->check_num_of_a_kind($cards,2,0, $first_pair)) {
		return false;
	}

	

	return true;
}

function check_three_kind($cards, $wild_card) {
	return $this->check_num_of_a_kind($cards,3,$wild_card, $wild_card);
}

function check_four_kind($cards, $wild_card) {
	//echo "checking four kind";
	if($this->check_num_of_a_kind($cards,4,$wild_card, $wild_card)){
		//echo $this->check_num_of_a_kind($cards,4,$wild_card, null);
		return true;
	} else {

		return false;
	}
}

function check_five_kind($cards, $wild_card) {
	return $this->check_num_of_a_kind($cards,5,$wild_card, $wild_card);
}

function check_num_of_a_kind($cards, $num, $wild_card = 0, $exclude = null) {

	$num_wild = $this->get_number_of_rank($wild_card, $cards);
	$ranks = array(
		'A' => 0,
		'K' => 0,
		'Q' => 0,
		'J' => 0,
		'10' => 0,
		'9' => 0,
		'8' => 0,
		'7' => 0,
		'6' => 0,
		'5' => 0,
		'4' => 0,
		'3' => 0,
		'2' => 0
	);
	foreach($cards as $card) {
		$ranks[$card['rank']] += 1;
	}
	// echo '<pre>';
	// print_r($ranks);
	// echo '</pre>';

	foreach($ranks as $key => $value) {
		//echo $num - $num_wild.'<br>';
		if($value == $num - $num_wild && $key != $exclude ) {
			//echo $key.' - '.$value.' '.$exclude;
			return $key;
		}
	}
	return 0;
}

	
function check_straight($cards, $wild_card, $royal = false) {
	//echo 'checking straigts<br>';
	//print_r($cards);

	$str = false;

	$num_wild = $this->get_number_of_rank($wild_card, $cards);

	foreach($cards as $card) {
		$ranks[] = $card['rank'];
	}

	if($royal) {
		$straights = array(array('10','J','Q','K','A'));
	} else {
		$straights = array(
			array('2','3','4','5','6'),
			array('3','4','5','6','7'),
			array('4','5','6','7','8'),
			array('5','6','7','8','9'),
			array('6','7','8','9','10'),
			array('7','8','9','10','J'),
			array('8','9','10','J','Q'),
			array('9','10','J','Q','K'),
			array('10','J','Q','K','A')
		);
	}
	
	
	foreach($straights as $straight) {
		$i=0;
		foreach($ranks as $rank) {

			if(in_array($rank, $straight) && $rank != $wild_card) {
				//echo $rank;
				unset($straight[array_search($rank, $straight)]);
				//echo $i.' '.(4-$num_wild).'-';
				if($i == 4 - $num_wild) {
					$str = true;
					break;
				} else {
					$i++;
					continue;
				}
				
			} else {
				continue;
			}
		}
	}
	return $str;
}


function check_flush($cards, $wild_card) {

	foreach($cards as $card) {
		if($card['rank'] != $wild_card) {
			$new_cards[] = $card['suit']; 
		}
	}

	return count(array_unique($new_cards)) === 1;
}


function get_number_of_rank($rank, $cards) {
	
	if($rank < 1) {
		return 0;
	}

	$ranks = array(
		'A' => 0,
		'K' => 0,
		'Q' => 0,
		'J' => 0,
		'10' => 0,
		'9' => 0,
		'8' => 0,
		'7' => 0,
		'6' => 0,
		'5' => 0,
		'4' => 0,
		'3' => 0,
		'2' => 0
	);

	//print_r($cards);

	foreach($cards as $card) {
		$ranks[$card['rank']]++;
	}

	return $ranks[$rank];
}

function get_most_of_suit($cards, $wild_card) {
	$suits = array(
		'C' => 0,
		'H' => 0,
		'D' => 0,
		'S' => 0
	);

	foreach($cards as $card) {
		//if($card['rank'] != $wild_card) {
			$suits[$card['suit']]++;
		
	}

	arsort($suits);

	//print_r($suits);

	//echo array_shift($suits);

	return array_shift($suits);
}


function score_game($deal, $paytable = 'dbl_dbl_bonus', $debug = false) {


	//print_r($this->whole_deck);

	// $deal = array(
	// 	'card_1' => '3S',
	// 	'card_2' => '3C',
	// 	'card_3' => '3D',
	// 	'card_4' => '3S',
	// 	'card_5' => '8H'
	// );

	// $debug = true;

	// format the cards and hands
	foreach($deal as $k => $value) {
		$cards[$k] = array(
			'rank' => strlen($value) == 3 ? substr($value, 0, 2) : substr($value, 0, 1),
			'suit' => substr($value, -1)
		);
	}
	//echo '<pre>';
	//print_r($cards);
	

	// find out which paytable we need to check
	$this->load->config('game_config');

	$hands = $this->config->item('game_config')['vp']['games'][$paytable]['hands'];
	
	if(isset($this->config->item('game_config')['vp']['games'][$paytable]['wild_cards'])) {
		$wild_card = $this->config->item('game_config')['vp']['games'][$paytable]['wild_cards'];
	} else {
		$wild_card = false;
	}
	
	$winning_hands = array();


	// if($wild_card) {
	// 	$possible_hands = array();
	// 	// foreach($deal as $k => $value) {
	// 	// 	$rank = strlen($value) == 3 ? substr($value, 0, 2) : substr($value, 0, 1);
	// 	// 	if($rank == $wild_card) {
	// 	// 		foreach($this->whole_deck as $card) {
	// 	// 			$new_deal = $deal;
	// 	// 			$new_deal[$k] = $card;
	// 	// 			$possible_hands[] = $new_deal;
					
	// 	// 		}
				
	// 	// 	}
	// 	// }

	// 	//for($i=0;$i<$this->get_number_of_rank($wild_card, $cards);$i++) {
	// 		foreach($cards as $k => $v) {
	// 			if($v['rank'] == $wild_card) {
	// 				$wild_cards[] = $k;
	// 				// foreach($this->whole_deck as $card) {

	// 				// }
	// 			}
	// 		}

	// 		for($i=0;$i<count($wild_cards);$i++) {
	// 			$n=0;
	// 			foreach($this->whole_deck as $card) {
	// 				$new_deal = $deal;
	// 				$new_deal[$wild_cards[$i]] = $card;
	// 				$possible_hands[] = $new_deal;
	// 				$n++;
	// 			}
				
	// 			//$possible_hands[] = $new_deal;
	// 			// foreach($wild_cards as $wc) {
	// 			// 	foreach($this->whole_deck as $card) {
	// 			// 		for($n=0;$n<count($wild_cards);$n++) {
	// 			// 			$new_deal = $deal;
	// 			// 			$new_deal[$wild_cards[$n]] = $card;
	// 			// 			$possible_hands[] = $new_deal;
	// 			// 		}
						
	// 			// 	}
	// 			// }
				
	// 		}

	// 		for($i=0;$i<count($possible_hands);$i++) {
	// 			//fore
	// 		}

	// 	//}
	// 	// loop through the cards to replace the wild ones
	// 	// for($i=0;$i<$this->get_number_of_rank($wild_card, $cards);$i++) {
	// 	// 	echo array_search($wild_card, $cards);
	// 	// 	// foreach($this->whole_deck as $card) {
	// 	// 	// 	$rank = strlen($value) == 3 ? substr($value, 0, 2) : substr($value, 0, 1);
	// 	// 	// 	$suit = substr($value, -1);
	// 	// 	// 	$possibilities[$i][] = 
	// 	// 	// }
	// 	// 	// foreach($hands as $hand) {
	// 	// 	// 	if($this->{'check_'.$hand['name']}($cards)) {
	// 	// 	// 		$winning_hands[$hand['payout']['bet_1']] = $hand['name'];
	// 	// 	// 	}
	// 	// 	// }
	// 	// }
		
	// }
	$hands = array_reverse($hands);
	foreach($hands as $hand) {
		// echo $hand['name'].'<br />';
		if($this->{'check_'.$hand['name']}($cards, $wild_card)) {
			$winning_hands[$hand['payout']['bet_1']] = $hand['name'];
			break;
		}
		
	}

	//echo '</pre>';
	krsort($winning_hands);

	//print_r($winning_hands);

	if(count($winning_hands) > 0) {
		$winning_hand = array_shift(array_values($winning_hands));
	} else {
		$winning_hand = false;
	}
	
	if($debug) {
		echo $winning_hand;

	}
	
	return $winning_hand;
}

function collect_game($game_id = false, $paytable = false){
	$this->load->config('game_config');
	$config = $this->config->item('game_config');

	if($game_id) {
		$game = $this->get_game_by_id($game_id);
	} else {
		$game = $this->get_game($this->session->userdata('user_id'));
	}

	$final_array = json_decode($game->final_array, true);

	if(empty($final_array['deal_2'])) {
		$deal_num = 1;
	} else {
		$deal_num = 2;
	}

	$deal_array = $final_array['deal_'.$deal_num];

	$deal = array(
		'card_1' => $deal_array[1],
		'card_2' => $deal_array[2],
		'card_3' => $deal_array[3],
		'card_4' => $deal_array[4],
		'card_5' => $deal_array[5],
		);

	$winner = $this->score_game($deal, $paytable);

	$payout = 0;
	$amount = 0;

	$this->load->model('user_model');
	$user = $this->user_model->get_user($this->session->userdata('user_id'));

	if($winner) {
		$payout = $config['vp']['games']['jacks_better']['hands'][$winner]['payout']['bet_1'];
		$this->update_game($game->id, array('winning_hand' => $winner));
		if($payout > 0) {
			$amount = $game->stake * $payout;
			$this->update_game($game->id, array('profit' => $amount));
			if($amount > 0) {
				$this->user_model->credit_balance($user->user_id, $amount);
				$this->load->model('transaction_model');
				$this->transaction_model->enter_transaction($user->user_id, 'credit', $amount, $user->available_balance + $amount,  'Game #'.$game->id.' - '.$config['vp']['games'][$paytable]['hands'][$winner]['name']. ' Roll #'.$deal_num);
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
		'deal' => $deal,
		'balance' => $user->available_balance + $amount,
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
	$this->load->config('vp_config');
	$config = $this->config->item('vp_config');


	$deck = array(
		'2C','3C','4C','5C','6C','7C','8C','9C','10C','JC','QC','KC','AC',
		'2H','3H','4H','5H','6H','7H','8H','9H','10H','JH','QH','KH','AH',
		'2D','3D','4D','5D','6D','7D','8D','9D','10D','JD','QD','KD','AD',
		'2S','3S','4S','5S','6S','7S','8S','9S','10S','JS','QS','KS','AS'
	);

	if($config['number_of_jokers'] > 0) {
		for($i=0;$i<$config['number_of_jokers'];$i++) {
			$deck[] = 'JK';
		}
	}

	$server_seed = md5($this->guid->create_guid().time());
	

	$initial_deck = $this->seed_shuffle($deck, $server_seed);

	$secret_array = array(
		'server_seeds' => $server_seed,
		'initial_array' => json_encode($initial_deck)
		);

	$hash = hash("sha256", json_encode($secret_array));

	$this->load->database();
	$insert_data = array(
		'user_id' => $user_id,
		'game_type' => 'videopoker',
		'rolls_remaining' => 2,
		'initial_array' => $secret_array['initial_array'],
		'final_array' => json_encode(array('deal_1'=>array(),'deal_2'=>array())),
		'server_seeds' => $secret_array['server_seeds'],
		'hash' => $hash,
		'created_on' => date('Y-m-d H:i:s'),
		'updated_on' => date('Y-m-d H:i:s')
		);
	$this->db->insert('games', $insert_data);

	return $this->get_game($user_id);
}

function draw($game, $held, $seed, $stake = 0, $paytable) {

	$final_array = json_decode($game->final_array, true);
	$client_seed = $game->client_seeds;
	$complete = false;
		//$seeds = json_decode($deal_data->server_seeds, true);

	if(empty($final_array['deal_1'])) {
		$deal_num = 1;
		$deals_remaining = 1;
		$offset = 0;
	} elseif (empty($final_array['deal_2'])) {
		$deal_num = 2;
		$deals_remaining = 0;
		$offset = 5;
		$paytable = $game->paytable;
	} 

	

	if($seed == 'held') {
		$seed = '"held" is the one seed you cannot use :( '.rand(1,10000000000);
	}

	$shuffled_deck = json_decode($game->shuffled_array);

	//shuffle the deck, but only if it's the first roll
	if($deal_num == 1) {
		$deck = json_decode($game->initial_array, true);
		$seed_val = is_array($seed) ? $seed[1] : $seed;
		$shuffled_deck = $this->seed_shuffle($deck, $seed_val);
	}

	for($i=1;$i<=5;$i++) {
		// echo 'deal_num='.$deal_num.' $i='.$i.' is_array='.is_array($held).' in_array='.in_array($i, $held).'//////';
		if($deal_num > 1 && is_array($held) && in_array($i, $held)) {
			$final_array['deal_2'][$i] = $final_array['deal_1'][$i];
		} else {
			//unset($shuffled_deck[$i]);
			$final_array['deal_'.$deal_num][$i] = array_slice($shuffled_deck, $offset + $i, 1, true)[$i+$offset];
		}
		
	}

	if($deal_num == 2) {
		for($i=1;$i<=5;$i++) {
			//$final_array['house_high'][$i] = $this->seed_shuffle($dice['house_high'][$i], $seeds[$i]);
			$complete = true;
		}
	}

	$this->load->database();
	$update_data = array(
		'user_id' => $game->user_id,
		'complete' => $complete,
		'shuffled_array' => json_encode($shuffled_deck),
		'paytable'	=> $paytable,
		'rolls_remaining' => $deals_remaining,
		'final_array' => json_encode($final_array),
		'client_seeds' => $seed,
		'updated_on' => date('Y-m-d H:i:s')
		);

	if($stake) {
		$update_data['stake'] = $stake;

	}


	$this->db->where('id', $game->id);
	$this->db->update('games', $update_data);

	$response = array(
		'deal' => array(
			'card_1'=>$final_array['deal_'.$deal_num][1],
			'card_2'=>$final_array['deal_'.$deal_num][2],
			'card_3'=>$final_array['deal_'.$deal_num][3],
			'card_4'=>$final_array['deal_'.$deal_num][4],
			'card_5'=>$final_array['deal_'.$deal_num][5]
			),
		'deals_remaining' => $deals_remaining

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