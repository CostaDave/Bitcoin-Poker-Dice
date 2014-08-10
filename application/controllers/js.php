<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Js extends CI_Controller {

	public function index()
	{	
		header("content-type: application/javascript");
		$this->load->library('ion_auth');
		$user_id = $this->session->userdata('user_id');
		$this->load->model('user_model');
		$user = $this->user_model->get_user($user_id, true);

		


		if(!$this->session->userdata('language')) {
			$lang = $this->config->item('default_language');
		} else {
			$lang = $this->session->userdata('language');
		}

		$this->lang->load('main', $lang);
		$data['language'] = json_encode($this->lang->language);

		
		$this->load->config('dice_config');
		$config = $this->config->item('dice_config');
		$config['site_url'] = site_url();
		$config['guid'] = $user->guid;
		unset($config['guid_secret']);
		$data['config'] = json_encode($config);
		
		$this->load->model('game_model');
		$game = $this->game_model->get_game($user->user_id);
		if(!$game) {
			$game = $this->game_model->create_game($user->user_id);
		}

		unset($game->server_seeds);
		unset($game->initial_array);
		unset($game->final_array);
		
		$this->load->model('withdrawal_model');
		$withdrawals = json_encode($this->withdrawal_model->get_all($user->user_id));

		$data['games'] = json_encode($this->game_model->get_games($user->user_id));

		$this->load->model('transaction_model');
		$transactions = json_encode($this->transaction_model->get_transactions($user->user_id));
		
		if($user->has_password && !$this->ion_auth->logged_in()) {
			$user = array('logged_in' => false,'has_password'=>true, 'role' => 'user');
			$game = false;
			$withdrawals = false;
			$transactions = false;
		} else {
			$user->logged_in = true;
		}

		$data['user'] = json_encode($user);
		$data['game'] = json_encode($game);
		$data['transactions'] = json_encode($transactions);
		$data['withdrawals'] = json_encode($withdrawals);

		
		$this->load->view('js', $data);
	}
}