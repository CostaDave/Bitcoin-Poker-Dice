<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partials extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');
	}

	public function index($page)
	{
		

		// if($this->session->userdata('has_password') && !$this->ion_auth->logged_in()) {
		// 	$this->load->view('login');
		// } else {
			// $this->load->config('game_config');
			// if($page == 'home_page') {
			// 	$page = $page.'_'.$this->config->item('game_config')['game_type'];
			// }
			$this->load->view('partials/'.$page);
		// }
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */