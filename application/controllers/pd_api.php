<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pd_api extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->user_id = $this->session->userdata('user_id');
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');

		$this->load->model('user_model');
		$this->user = $this->user_model->get_user($this->user_id);

		$this->load->config('game_config');
		$this->game_type = 'pd';
		$this->game_model = 'game_model_pd';
		//$this->game_model = 'game_model';

		if($this->game_type == 'vp') {
			$this->turns = 'deals';
		} else {
			$this->turns = 'rolls';
		}

		if(!$this->user || ($this->user->has_password && !$this->ion_auth->logged_in())) {
			header('HTTP/1.0 401 Unauthorized');
			die('You must be logged in.');
		} 
	}

	public function get_game() {
		//die('dddd');
		//echo $this->game_model;
		$this->load->model($this->game_model, 'gm');
		$game = $this->gm->get_game($this->user->user_id);

		if($game === false) {
			//die('no game');
			$game = $this->gm->create_game($this->user->user_id);
			//$response['dice'] = json_encode(array('dice_1'=>'A', 'dice_2'=>'A', 'dice_3'=>'A', 'dice_4'=>'A', 'dice_5'=>'A'));
		}

		
		
			$response['dice'] = $game->current_roll;
			$response['id'] = $game->id;
			$response['hash'] = $game->hash;
			$response['rolls_remaining'] = $game->rolls_remaining;
		
		

		echo json_encode($response);
	}


	public function get_games() {
		$this->load->model($this->game_model, 'gm');

		$games = $this->gm->get_games($this->session->userdata('user_id'));

		if($games) {
			echo json_encode($games);
		} else {
			echo json_encode(array());
		}



		
	}

	public function get_all_games() {
		$this->load->model($this->game_model, 'gm');

		$games = $this->gm->get_all_games();

		if($games) {
			echo json_encode($games);
		} else {
			echo json_encode(array());
		}



		
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
		$this->load->model($this->game_model, 'gm');
		$response = $this->gm->collect_game();
		echo json_encode($response);
	}

	public function roll_dice(){

		$post_data = file_get_contents('php://input');

		$post = json_decode($post_data, true);

		$this->load->model($this->game_model, 'gm');
		$game = $this->gm->get_game($this->session->userdata('user_id'));

		$this->load->config('game_config');
		$config = $this->config->item('game_config');

		$seed_array = $post['seeds'];

		
			$seeds = array(
			1 => $seed_array['seed_1'],
			2 => $seed_array['seed_2'],
			3 => $seed_array['seed_3'],
			4 => $seed_array['seed_4'],
			5 => $seed_array['seed_5']
			);
		

		

		$held_array = $post['held_dice'];

		if($game->rolls_remaining == 3) {
			$stake = $post['stake'];
		} else {
			$stake = 0;
		}

		$this->load->model('user_model');
		$user = $this->user_model->get_user($this->session->userdata('user_id'));
		
		if($stake > 0  && $stake <= $config['max_bet'] && $stake <= $user->available_balance) {
			$this->user_model->debit_balance($user->user_id, $stake);
			$this->load->model('transaction_model');
			$this->transaction_model->enter_transaction($user->user_id, 'debit', $stake, $user->available_balance - $stake,  'Game #'.$game->id);
		} else {
			$stake = 0;
		}

		$roll = $this->gm->roll($game, $held_array, $seeds, $stake);

		$winner = $this->gm->score_game($roll['roll']);

		if($roll[$this->turns.'_remaining'] < 1) {
			$winnings = $this->gm->collect_game($game->id);
		}

		
			$response = array(
			'roll'=>$roll['roll'], 
			'rolls_remaining'=> $roll[$this->turns.'_remaining'], 
			'winning_rolls' => $winner,
			'balance' => $user->available_balance
			);
		

		

		if(isset($winnings)) {
			$response['winnings'] = $winnings;
		}

		echo json_encode($response);

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */