<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class bitcoin_model extends CI_model
{
	function deposit($user_id, $hash, $value, $confirmations, $input_address) {
		$this->load->database();
		$insert_data = array(
			'user_id' => $user_id,
		 	'transaction_hash' => $hash,
		 	'value' => $value,
		 	'confirmations' => $confirmations,
		 	'input_address' => $input_address,
		 	'created_on' => date('Y-m-d H:i:s'),
			'updated_on' => date('Y-m-d H:i:s')
		);

		$this->db->insert('deposits', $insert_data);

		return $this->db->insert_id();
	}

	function update_confirmations($deposit_id, $confirmations){
		$this->load->database();
		$update_data['confirmations'] = $confirmations;
		$this->db->where('id',$deposit_id);
		$this->db->update('deposits', $update_data);

		return true;
	}

	function get_deposit_by_tran($hash) {
		$this->load->database();
		$this->db->where('transaction_hash', $hash);
		$query = $this->db->get('deposits');

		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
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