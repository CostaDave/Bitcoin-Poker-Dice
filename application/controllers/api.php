<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->user_id = $this->session->userdata('user_id');
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');

		$this->load->model('user_model');
		$user = $this->user_model->get_user($this->user_id);

		if(!$user || ($user->has_password && !$this->ion_auth->logged_in())) {
			header('HTTP/1.0 401 Unauthorized');
			die('You must be logged in.');
		} 
	}


	public function get_user()
	{
		$this->load->library('ion_auth');
		$this->load->model('user_model');
		$user = $this->user_model->get_user($this->session->userdata('user_id'));
		if($this->ion_auth->logged_in()) {
			$user->logged_in = true;
		} else {
			$user->logge_in = false;
		}
		die(json_encode($user, true));
	}

	public function get_config() {
		$this->load->config('dice_config');
		die(json_encode($this->config->item('dice_config')));
	}

	public function set_password() {
		
		$post_data = file_get_contents('php://input');

		$items = json_decode($post_data, true);
		
		if(
			strlen($items['password']) >= $this->config->item('min_password_length', 'ion_auth') 
			&& strlen($items['password'] <= $this->config->item('max_password_length', 'ion_auth')
			&& $items['password'] == $items['password_confirm']	
		)) {
			$password = $items['password'];
			$this->load->model('user_model');
			$this->user_model->set_password($this->session->userdata('user_id'), $password);
		} else {
			die(json_encode(array('error'=>validation_errors())));
		}

		echo json_encode(array('success'=>true));
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

	public function get_all_games() {
		$this->load->model('game_model');

		$games = $this->game_model->get_all_games();

		if($games) {
			echo json_encode($games);
		} else {
			echo json_encode(array());
		}



		
	}

	public function get_transactions() {
		$this->load->model('transaction_model');

		$trans = $this->transaction_model->get_transactions($this->session->userdata('user_id'));

		if($trans) {
			echo json_encode($trans);
		} else {
			echo json_encode(array());
		}



		
	}

	public function get_withdrawals() {
		$this->load->model('withdrawal_model');

		$trans = $this->withdrawal_model->get_all($this->session->userdata('user_id'));

		if($trans) {
			echo json_encode($trans);
		} else {
			echo json_encode(array());
		}



		
	}

	public function request_withdrawal(){

		$this->load->config('btc_config');

		$post_data = file_get_contents('php://input');

		$post = json_decode($post_data, true);

		$guid = $this->session->userdata('guid');
		$address = $post['address'];
		$amount = $post['amount'] * 100000000;

		// check to make sure the address is valid
		$this->load->library('bitcoinservice');
		if(!$this->bitcoinservice->isValid($address)) {
			die('bad address');	
		}

		$this->load->model('user_model');
		$user = $this->user_model->get_user($this->session->userdata('user_id'));

		if($amount > $user->available_balance) {
			die('not enough funds');
		}

		$this->user_model->debit_balance($user->user_id, $amount);

		$this->load->model('withdrawal_model');
		$withdrawal_id = $this->withdrawal_model->new_withdrawal($user->user_id,$address, $amount);


		$this->load->model('transaction_model');
		$transaction_id = $this->transaction_model->enter_transaction($user->user_id, 'debit', $amount, $user->available_balance - $amount,  'Withdrawal');

		if($amount <= $this->config->item('max_withdrawal_no_approval')) {
			//$tran = $this->bitcoin->send($address, $amount);
			$tran = '{ "message" : "Sent '.($amount / 100000000).' BTC to '.$address.'" , "tx_hash": "f322d01ad784e5deeb25464a5781c3b20971c1863679ca506e702e3e33c18e9c", "notice" : "Some funds are pending confirmation and cannot be spent yet (Value 0.001 BTC)" }';
			$tran = json_decode($tran);

			if(isset($tran->error)) {
				$this->user_model->debit_balance($user->user_id, $amount);
				$this->withdrawal_model->update_withdrawal($withdrawal_id, array('status' => 'cancelled'));
			} else {
				$this->withdrawal_model->update_withdrawal($withdrawal_id, array('transaction_hash'=>$tran->tx_hash,'status' => 'complete'));
			}

		} else {
			$this->withdrawal_model->update_withdrawal($withdrawal_id, array('status' => 'held'));
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

		$post_data = file_get_contents('php://input');

		$post = json_decode($post_data, true);

		$this->load->model('game_model');
		$game = $this->game_model->get_game($this->session->userdata('user_id'));

		$this->load->config('dice_config');
		$config = $this->config->item('dice_config');

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

		$roll = $this->game_model->roll($game, $held_array, $seeds, $stake);

		$winner = $this->game_model->score_game($roll['roll']);

		if($roll['rolls_remaining'] < 1) {
			$winnings = $this->game_model->collect_game($game->id);
		}

		$response = array(
			'roll'=>$roll['roll'], 
			'rolls_remaining'=> $roll['rolls_remaining'], 
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