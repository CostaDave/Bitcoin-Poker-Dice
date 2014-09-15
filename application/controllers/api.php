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

		$this->load->config('game_config');
		$this->game_type = $this->config->item('game_config')['game_type'];
		$this->game_model = 'game_model_'.$this->game_type;
		//$this->game_model = 'game_model';

		if($this->game_type == 'vp') {
			$this->turns = 'deals';
		} else {
			$this->turns = 'rolls';
		}

		if(!$user || ($user->has_password && !$this->ion_auth->logged_in())) {
			header('HTTP/1.0 401 Unauthorized');
			die('You must be logged in.');
		} 
	}


	public function get_user()
	{
		$this->load->library('ion_auth');
		$this->load->model('user_model');
		$user = $this->user_model->get_user($this->session->userdata('user_id'), true);
		if($this->ion_auth->logged_in()) {
			$user->logged_in = true;
		} else {
			$user->logged_in = false;
		}
		die(json_encode($user, true));
	}

	public function get_config() {
		$this->load->config('game_config');
		die(json_encode($this->config->item('game_config')));
	}

	public function update_user() {
		$post_data = file_get_contents('php://input');

		$items = json_decode($post_data, true);

		

		$_POST['username'] = $items['username'];
		$_POST['email'] = $items['email'];
		$_POST['timezone'] = $items['timezone'];

		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('timezone', 'Timezone', '');

		if ($this->form_validation->run() == FALSE)
		{
			die(json_encode(array('error'=>validation_errors())));
		}
		else
		{	
			$update_items = array(
				'username' => $items['username'],
				'email' => $items['email'],
				'timezone' => $items['timezone']['zone']
			);
			$this->user_model->update_settings($this->user_id, $update_items);

			die(json_encode(array('success'=>true)));
		}

		print_r($update_items);
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
			die(json_encode(array('error'=>'There was an error changing your password.')));
		}

		echo json_encode(array('success'=>true));
	}

	public function get_game() {
		$this->load->model($this->game_model, 'gm');
		$game = $this->gm->get_game($this->session->userdata('user_id'));

		if($game === false) {
			$game = $this->gm->create_game($this->session->userdata('user_id'));
			//$response['dice'] = json_encode(array('dice_1'=>'A', 'dice_2'=>'A', 'dice_3'=>'A', 'dice_4'=>'A', 'dice_5'=>'A'));
		}

		
		if($this->game_type == 'pd') {
			$response['dice'] = $game->current_roll;
			$response['id'] = $game->id;
			$response['hash'] = $game->hash;
			$response['rolls_remaining'] = $game->rolls_remaining;
		} elseif($this->game_type == 'vp') {
			$response['deal'] = $game->current_deal;
			$response['id'] = $game->id;
			$response['hash'] = $game->hash;
			$response['deals_remaining'] = $game->rolls_remaining;
		}
		
		//$response['dice'] = 

		echo json_encode($response);
	}


	public function get_games($gametype, $global) {
		if($gametype == 'videopoker') {
			$model = 'game_model_vp';
		}
		if($gametype == 'pokerdice') {
			$model = 'game_model_pd';
		}

		$this->load->model($model, 'gm');

		$games = $this->gm->get_games($this->user_id, $global);

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

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */