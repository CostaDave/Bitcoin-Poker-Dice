<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class transaction_model extends CI_model
{
	function enter_transaction($user_id, $type, $amt, $balance, $reference) {
		$this->load->database();
		$insert_data = array(
			'user_id' => $user_id,
		 	'type' => $type,
		 	'amount' => $amt,
		 	'balance' => $balance,
		 	'reference' => $reference,
		 	'created_on' => date('Y-m-d H:i:s'),
			'updated_on' => date('Y-m-d H:i:s')
		);

		$this->db->insert('transactions', $insert_data);
	}

	function get_user($guid) {
		$this->load->database();
		$user = $this->db->get_where('users', array('guid'=> $guid))->row();
		
		return $user;
	}

	function debit_balance($guid, $amt) {
		$this->load->database();
		$user = $this->get_user($guid);
		$update_data['available_balance'] = $user->available_balance - $amt;
		$this->db->where('guid', $guid);
		$this->db->update('users', $update_data);
	}

}