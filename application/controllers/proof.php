<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proof extends CI_Controller {

	public function index()
	{
		$this->load->view('partials/proof');
	}

	function game($id) {
		$this->load->model('game_model');
		$game = $this->game_model->get_game_by_id($id);

		$initial_array  = $game->initial_array;;

		$final_array    = $game->final_array;

		$server_seeds 	= $game->server_seeds;

		$client_seeds 	= $game->client_seeds;

		$hash = $game->hash;

		$secret_array = array(
			'server_seeds' => $server_seeds,
			'initial_array' => $initial_array
			);

		$computed_hash = hash("sha256", json_encode($secret_array));

		$initial_array = json_decode($initial_array, true);
		$client_seeds = json_decode($client_seeds, true);
		$final_array = json_decode($final_array, true);

		// Detect game type - video poker uses 'deal_1', poker dice uses 'roll_1'
		$is_video_poker = !empty($final_array['deal_1']) || !empty($final_array['deal_2']);
		
		if ($is_video_poker) {
			// Video poker - deals instead of rolls
			$result_array = array();
			for($i=1;$i<=2;$i++) {
				if(!empty($final_array['deal_'.$i])) {
					$result_array['deal_'.$i] = $final_array['deal_'.$i];
				}
			}
			
			// Find the final deal
			if(!empty($final_array['deal_2'])) {
				$final_deal = 2;
			} else {
				$final_deal = 1;
			}
			
			$result = isset($result_array['deal_'.$final_deal]) ? 
				array_values($result_array['deal_'.$final_deal]) : 
				array('', '', '', '', '');
		} else {
			// Poker dice - original logic
			$result_array = array();
			for($i=1;$i<=3;$i++) {
				if(!empty($final_array['roll_'.$i])) {
					for($n=1;$n<=5;$n++) {
						if(isset($client_seeds['roll_'.$i][$n]) && $client_seeds['roll_'.$i][$n] == 'held') {
							$field = $i-1;
							$result_array['roll_'.$i][$n] = $final_array['roll_'.$field][$n];
						} else {
							$result_array['roll_'.$i][$n] = $this->seed_shuffle($initial_array['roll_'.$i][$n], $client_seeds['roll_'.$i][$n]);
						}
					}
				}
			}

			// Find the final roll
			if(!empty($final_array['roll_3'])) {
				$final_roll = 3;
			} elseif(!empty($final_array['roll_2'])) {
				$final_roll = 2;
			} else {
				$final_roll = 1;
			} 

			$result = isset($result_array['roll_'.$final_roll]) ? array(
				$result_array['roll_'.$final_roll][1][0] ?? '',
				$result_array['roll_'.$final_roll][2][0] ?? '',
				$result_array['roll_'.$final_roll][3][0] ?? '',
				$result_array['roll_'.$final_roll][4][0] ?? '',
				$result_array['roll_'.$final_roll][5][0] ?? ''
			) : array('', '', '', '', '');
		}
		
		$proof = '<pre>';
		$proof .= 'Result: '.implode(',',$result).'<br />';
		$proof .= 'Hashes match: ';
		$proof .= $computed_hash == $hash ? 'true':'false';
		$proof .= '</pre>';

		
		$data['proof'] = $proof;
		$data['game'] = $game;
		$this->load->view('partials/proof', $data);
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