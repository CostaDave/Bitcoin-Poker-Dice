<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_api extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->user_id = $this->session->userdata('user_id');
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');

		$this->load->model('user_model');
		$user = $this->user_model->get_user($this->user_id);

		if(!$user || $user->role != 'admin') {
			header('HTTP/1.0 401 Unauthorized');
			die('You must be logged in.');
		} 
	}

	public function get_user($user_id) {
		$this->load->library('ion_auth');
		$this->load->model('user_model');
		die(json_encode($this->user_model->get_user_with_details($user_id, false)));
	}

	public function get_game($game_id) {
		$this->load->model('game_model');
		die(json_encode($this->game_model->get_game_by_id($game_id)));
	}

	public function get_all_users() {
		$this->load->model('user_model');
		die(json_encode($this->user_model->get_all_users()));
	}

	public function get_admin_data() {
		$this->load->library('bitcoinservice');
		$data['balance'] = json_decode($this->bitcoinservice->get_balance(),true)['balance'];

		$this->load->model('stats_model');

		$data['total_wagered'] = $this->stats_model->get_total_wagered(30);
		$data['total_won'] = $this->stats_model->get_total_won(30);

		$this->load->model('withdrawal_model');
		$data['pending_withdrawal_amount'] = $this->withdrawal_model->get_pending_amount();

		echo json_encode($data);
	}

	public function get_withdrawals() {
		$this->load->model('withdrawal_model');

		$data['withdrawals'] = $this->withdrawal_model->get_all();
		if(!$data['withdrawals']) {
			$data['withdrawals'] = array();
		}

		echo json_encode($data);
	}

	public function process_withdrawals() {
		$this->load->model('withdrawal_model');

		$post_data = file_get_contents('php://input');

		$items = json_decode($post_data, true)['withdrawals']['items'];

		$i=0;
		foreach($items as $k => $v) {
			if($v) {
				$wd = $this->withdrawal_model->get($k);
				$withdrawals[$i]['id'] = $wd->id;
				$withdrawals[$i]['address'] = $wd->destination_address;
				$withdrawals[$i]['value'] = $wd->value;
			}
			$i++;
			
		}

		$this->load->library('bitcoinservice');
		$resp = json_decode($this->bitcoinservice->send_many($withdrawals),true);

		if(isset($resp['error'])) {
			die(json_encode(array('success'=>false)));
		} else {
			foreach($withdrawals as $wd) {
				$this->withdrawal_model->update_withdrawal($wd['id'], array('trancastion_hash', $resp['tx_hash']));
			}
			die(json_encode(array('success'=>true)));
		}
	}

public function get_pending_withdrawals() {
	$this->load->model('withdrawal_model');

	$data['withdrawals'] = $this->withdrawal_model->get_all_pending();
	if(!$data['withdrawals']) {
		$data['withdrawals'] = array();
	}

	echo json_encode($data);
}

public function get_games() {
	$this->load->model('game_model');

	$games = $this->game_model->get_all_games();

	if($games) {
		echo json_encode($games);
	} else {
		echo json_encode(array());
	}
}

public function get_games_by_user($user_id) {
	$this->load->model('game_model');

	$games = $this->game_model->get_games($user_id);

	if($games) {
		echo json_encode($games);
	} else {
		echo json_encode(array());
	}




}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */