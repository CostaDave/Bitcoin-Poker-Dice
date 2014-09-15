<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class user_model extends CI_model
{	

	function __construct()
	{
		parent::__construct();
		$this->user_id = $this->session->userdata('user_id');
		$this->load->helper('url');
	}

	function create_user($guid) {

		$this->load->library('bitcoinservice');
		$address = $this->bitcoinservice->get_address($guid);

		$this->load->library('guid');
		$this->load->config('game_config');
		$config = $this->config->item('game_config');

		if($this->input->get('aff')) {			
			$affiliate_user_id = $this->guid->create_alphaId($this->input->get('aff'),true,false,$config['guid_secret']);
		}


		$this->load->database();
		$insert_data = array(
			'guid' => $guid,
		 	'available_balance' => 200000000,
		 	//'username' => $username,
		 	'affiliate_earnings' => 0,
		 	'role' => 'user',
		 	'address' => json_decode($address)->address,
		 	'created_on' => date('Y-m-d H:i:s'),
			'updated_on' => date('Y-m-d H:i:s')
		);

		if(isset($affiliate__user_id)) {
			$insert_data['affiliate_user_id'] = $affiliate_user_id;
		}

		$this->db->insert('users', $insert_data);

		$insert_id = $this->db->insert_id();

		$update_data['username'] = $this->guid->create_alphaId($insert_id,false,false,$config['guid_secret']);
		$this->db->where('user_id', $insert_id);
		$this->db->update('users', $update_data);


	}

	function update_settings($user_id, $update_data) {

		$update_data['updated_on'] = date('Y-m-d H:i:s');

		$this->db->where('user_id', $user_id);
		$this->db->update('users', $update_data);
	}

	function set_password($user_id, $password) {
		$this->load->model('ion_auth_model');
		$salt = $this->ion_auth_model->salt();
		$password = $this->ion_auth_model->hash_password($password, $salt);

		$update_data = array(
			'password' 			=> $password,
			'salt'		 			=> $salt,
			'has_password' 	=> 1,
			'updated_on'	  => date('Y-m-d H:i:s')
		);
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $update_data);

		return true;
	}

	function login($user_id, $password) {
		$this->load->model('ion_auth_model');
		$login = $this->ion_auth_model->login($user_id, $password, false, false);

		if($login) {
			return $this->get_user($user_id, true);
		} else {
			return array('error'=>true);
		}
	}

	function logout($user_id) {
		$this->load->library('ion_auth');
		$this->ion_auth->logout();
	}

	function get_user($user_id, $public = false) {
		//die('getting user '.$guid);
		$this->load->database();
		if($public) {
			$this->db->select('user_id,username,email,timezone,guid,available_balance,address,affiliate_earnings,has_password, role');
		}
		
		$user = $this->db->get_where('users', array('user_id'=> $user_id))->row();

		$this->load->library('guid');
		$this->load->config('dice_config');
		$config = $this->config->item('dice_config');
		
		if($user) {
			$user->affiliate_id = $user->username;
		}
		
		
		return $user;
	}

	function get_all_users() {
		//die('getting user '.$guid);
		$this->load->database();
		$this->db->select('users.*, count(games.id)as total_games, sum(games.stake) as total_wagered, sum(games.profit) as total_won');
		$this->db->join('games', 'users.user_id = games.user_id', 'left');
		$this->db->group_by('users.user_id');
		$users = $this->db->get('users')->result();
		return $users;
	}

	function get_user_with_details($user_id, $public = false) {
		//die('getting user '.$guid);
		$this->load->database();

		$user = $this->db->get_where('users', array('user_id'=> $user_id))->row();

		$this->load->library('guid');
		$this->load->config('dice_config');
		$config = $this->config->item('dice_config');
		
		if($user) {
			$user->affiliate_id = $this->guid->create_alphaId($user->user_id,false,false,$config['guid_secret']);
		}

		$this->db->select_sum('stake');
		$this->db->where('user_id', $user->user_id);
		$user->total_wagered = $this->db->get('games')->row()->stake;

		$this->db->select_sum('profit');
		$this->db->where('user_id', $user->user_id);
		$user->total_profit = $this->db->get('games')->row()->profit;

		$this->db->select_sum('value');
		$this->db->where('user_id', $user->user_id);
		$user->total_deposited = $this->db->get('deposits')->row()->value;

		$this->db->select_sum('value');
		$this->db->where('user_id', $user->user_id);
		$this->db->where('status <>','cancelled');
		$user->total_withdrawn = $this->db->get('withdrawals')->row()->value;

		$this->db->where('user_id', $user->user_id);
		$user->total_games = $this->db->get('games')->num_rows();
		
		
		return $user;
	}

	function get_user_by_guid($guid) {
		$this->load->database();
		$user = $this->db->get_where('users', array('guid'=> $guid))->row();

		$this->load->library('guid');
		$this->load->config('dice_config');
		$config = $this->config->item('dice_config');
		
		$user->affiliate_id = $this->guid->create_alphaId($user->user_id,false,false,$config['guid_secret']);
		
		return $user;
	}

	function get_by_address($addr) {
		$this->load->database();
		$user = $this->db->get_where('users', array('address'=> $addr))->row();
		
		return $user;
	}

	function debit_balance($user_id, $amt) {
		$this->load->database();
		$user = $this->get_user($user_id);
		$update_data['available_balance'] = $user->available_balance - $amt;
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $update_data);
	}

	function credit_balance($user_id, $amt) {
		$this->load->database();
		$user = $this->get_user($user_id);
		$update_data['available_balance'] = $user->available_balance + $amt;
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $update_data);
	}

}