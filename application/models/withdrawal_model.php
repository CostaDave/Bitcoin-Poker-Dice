<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class withdrawal_model extends CI_model
{	

	function get_all($user_id = false, $limit = false) {
		$this->load->database();
		if($user_id) {
			$this->db->where('user_id', $user_id);
		}

		if($limit) {
			$this->db->limit($limit);
		}
		
		$query = $this->db->get('withdrawals');
		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function get_all_pending($user_id = false, $limit = false) {
		$this->load->database();
		if($user_id) {
			$this->db->where('user_id', $user_id);
		}

		if($limit) {
			$this->db->limit($limit);
		}
		
		$this->db->where('status', 'held');
		$query = $this->db->get('withdrawals');
		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function get($id) {
		$this->load->database();

		$this->db->where('id', $id);
		return $this->db->get('withdrawals')->row();
	}
	
	function get_pending_amount() {
		$this->load->database();
		$this->db->select_sum('value');
		$this->db->where('status', 'held');
		return $this->db->get('withdrawals')->row()->value;
	}

	function new_withdrawal($user_id, $address, $amount) {
		$this->load->database();

		$insert_data = array(
			'user_id' => $user_id,
			'value'		=> $amount,
			'destination_address' => $address,
			'status'  => 'pending',
			'created_on' => date('Y-m-d H:i:s'),
			'updated_on' => date('Y-m-d H:i:s')
		);

		$this->db->insert('withdrawals', $insert_data);

		return $this->db->insert_id();
	}

	function update_withdrawal($id, $data) {
		$this->load->database();
		$this->db->where('id', $id);
		$data['updated_on'] = date('Y-m-d H:i:s');
		$this->db->update('withdrawals', $data);
	}

}