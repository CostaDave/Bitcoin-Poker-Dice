<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');
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

		$this->session->set_userdata('guid', $this->input->get('user'));
		$this->session->set_userdata('user_id', $user->user_id);

		// echo $guid;
		// die('here');
		$this->load->view('home');
	}
}