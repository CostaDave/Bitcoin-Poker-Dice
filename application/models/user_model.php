<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class user_model extends CI_model
{
	function create_user($guid) {

		$this->load->library('bitcoin');
		$address = $this->bitcoin->get_address($guid);
		$this->load->database();
		$insert_data = array(
			'guid' => $guid,
		 	'available_balance' => 0,
		 	'held_balance' => 0,
		 	'address' => json_decode($address)->address,
		 	'created_on' => date('Y-m-d H:i:s'),
			'updated_on' => date('Y-m-d H:i:s')
		);

		$this->db->insert('users', $insert_data);
	}

	function get_user($guid) {
		$this->load->database();
		$user = $this->db->get_where('users', array('guid'=> $guid))->row();
		
		return $user;
	}

	function get_by_address($addr) {
		$this->load->database();
		$user = $this->db->get_where('users', array('address'=> $addr))->row();
		
		return $user;
	}

	function debit_balance($guid, $amt) {
		$this->load->database();
		$user = $this->get_user($guid);
		$update_data['available_balance'] = $user->available_balance - $amt;
		$this->db->where('guid', $guid);
		$this->db->update('users', $update_data);
	}

	function credit_balance($guid, $amt) {
		$this->load->database();
		$user = $this->get_user($guid);
		$update_data['available_balance'] = $user->available_balance + $amt;
		$this->db->where('guid', $guid);
		$this->db->update('users', $update_data);
	}

}