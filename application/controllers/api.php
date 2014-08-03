<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function get_user()
	{
		$this->load->model('user_model');
		die(json_encode($this->user_model->get_user($this->session->userdata('guid'))));
	}

	public function get_config() {
		$this->load->config('dice_config');
		die(json_encode($this->config->item('dice_config')));
	}

	public function get_game() {
		$this->load->model('game_model');
		$game = $this->game_model->get_game($this->session->userdata('user_id'));

		if($game === false) {
			$game = $this->game_model->create_game($this->session->userdata('user_id'));
			//$response['dice'] = json_encode(array('dice_1'=>'A', 'dice_2'=>'A', 'dice_3'=>'A', 'dice_4'=>'A', 'dice_5'=>'A'));
		}

		
		$response['dice'] = $game->current_roll;
		$response['id'] = $game->id;
		$response['hash'] = $game->hash;
		$response['rolls_remaining'] = $game->rolls_remaining;
		//$response['dice'] = 

		echo json_encode($response);
	}


	public function get_games() {
		$this->load->model('game_model');

		$games = $this->game_model->get_games($this->session->userdata('user_id'));

		if($games) {
			echo json_encode($games);
		} else {
			echo json_encode(array());
		}


		
	}

	function sortBySort($a, $b) {
		return $a['sort'] - $b['sort'];
	}

	function seedShuffle( $items, $seed ) {

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

	public function collect($game_id = false) {
		$this->load->model('game_model');
		$response = $this->game_model->collect_game();
		echo json_encode($response);
	}

	public function roll_dice(){

		$this->load->model('game_model');
		$game = $this->game_model->get_game($this->session->userdata('user_id'));

		$this->load->config('dice_config');
		$config = $this->config->item('dice_config');

		$seed_array = $this->input->post('seeds');

		$seeds = array(
			1 => $seed_array['seed_1'],
			2 => $seed_array['seed_2'],
			3 => $seed_array['seed_3'],
			4 => $seed_array['seed_4'],
			5 => $seed_array['seed_5']
			);

		$held_array = $this->input->post('held_dice');

		if($game->rolls_remaining == 3) {
			$stake = $this->input->post('stake');
		} else {
			$stake = 0;
		}

		$this->load->model('user_model');
		$user = $this->user_model->get_user($this->session->userdata('guid'));
		
		if($stake > 0  && $stake <= $config['max_bet'] && $stake <= $user->available_balance) {
			$this->user_model->debit_balance($this->session->userdata('guid'), $stake);
			$this->load->model('transaction_model');
			$this->transaction_model->enter_transaction($user->user_id, 'debit', $stake, $user->available_balance - $stake,  'Game #'.$game->id);
		} else {
			$stake = 0;
		}

		$roll = $this->game_model->roll($game, $held_array, $seeds, $stake);

		$winner = $this->game_model->score_game($roll['roll']);

		if($roll['rolls_remaining'] < 1) {
			$winnings = $this->game_model->collect_game($game->id);
		}

		$response = array(
			'roll'=>$roll['roll'], 
			'rolls_remaining'=> $roll['rolls_remaining'], 
			'winning_rolls' => $winner,
			);

		if(isset($winnings)) {
			$response['winnings'] = $winnings;
		}

		echo json_encode($response);

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */