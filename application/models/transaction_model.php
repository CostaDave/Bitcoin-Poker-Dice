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

		return $this->db->insert_id();
	}

	function update_transaction($transaction_id, $data) {
		$this->load->database();
		$this->db->where('id', $transaction_id);
		$data['updated_on'] = date('Y-m-d H:i:s');
		$this->db->update('transactions', $data);
	}

	function get_transactions($user_id) {
		$this->load->database();
		$this->db->where('user_id', $user_id);
		return $this->db->get('transactions')->result();
	}
}