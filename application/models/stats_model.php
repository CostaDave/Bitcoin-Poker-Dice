<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class stats_model extends CI_model
{	

	function __construct()
	{
		parent::__construct();
	}

	function get_total_wagered($days) {
		$this->load->database();
		$this->db->select_sum('stake');
		$query = $this->db->get('games');

		return $query->row()->stake;

	}

	function get_total_won($days) {
		$this->load->database();
		$this->db->select_sum('profit');
		$query = $this->db->get('games');

		return $query->row()->profit;

	}
	

}