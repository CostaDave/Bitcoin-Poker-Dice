<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');
	}

	public function score() {
		$this->load->model('game_model_vp', 'game_model');
		$game = $this->game_model->score_game(500);
		//print_r($game);
		//print_r($this->game_model->deal($game,array(),275366470683367,0));
	}

	
	public function index($guid = false)
	{

		if(!$guid) {
			$this->load->library('guid');
			$guid = $this->guid->create_guid();
			$this->load->model('user_model');
			$this->user_model->create_user($guid);
			redirect(site_url('u/'.$guid.'/#/play'));
		} else {
			$this->load->model('user_model');
			$user = $this->user_model->get_user_by_guid($guid);
		}

		if($user->has_password) {
			$this->session->set_userdata('has_password', true);
		}


		$data['templates'] = array('games_table','card','welcome_modal', 'update_email', 'update_password');

		$this->session->set_userdata('guid', $guid);
		$this->session->set_userdata('user_id', $user->user_id);

		if(ENVIRONMENT == 'production') {
			$this->load->view('build', $data);
		} else {
			$this->load->view('home', $data);
		}

		
	}
}