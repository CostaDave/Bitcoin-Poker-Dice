<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{
		//$this->load->view
	}

	public function partials($page) {
		$this->load->view('admin/'.$page);
	}

}