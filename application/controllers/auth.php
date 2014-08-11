<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		// $this->guid = $this->uri->segment('3');
		// $this->load->model('user_model');
		// $this->user_id = $this->user_model->get_user_by_guid($this->guid)->user_id;
	}

	public function login($guid) {
		$this->load->model('user_model');
		$user_id = $this->user_model->get_user_by_guid($guid)->user_id;
		$password = $this->input->post('password');
		$response = $this->user_model->login($user_id, $password);

		die(json_encode(array($response)));
	}

	public function logout() {
		$this->load->model('user_model');
		$response = $this->user_model->logout($this->session->userdata('user_id'));

		die(json_encode(array('success'=>true)));
	}

}