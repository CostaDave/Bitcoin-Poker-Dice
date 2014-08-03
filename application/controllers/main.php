<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		if(!$this->input->get('user')) {
			$this->load->library('guid');
			$guid = $this->guid->create_guid();
			$this->load->model('user_model');
			$this->user_model->create_user($guid);
			redirect(site_url('/?user='.$guid));
		} else {
			$this->load->model('user_model');
			$user = $this->user_model->get_user($this->input->get('user', true));
		}
		$this->session->set_userdata('guid', $this->input->get('user'));
		$this->session->set_userdata('user_id', $user->user_id);

		$this->load->config('dice_config');
		$data['config'] = json_encode($this->config->item('dice_config'));

		$this->load->view('home', $data);
	}
}