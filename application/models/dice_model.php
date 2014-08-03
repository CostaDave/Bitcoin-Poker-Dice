<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class dice_model extends CI_model
{

	function get_open_roll($user_id) {
		$this->load->database();
		$query = $this->db->get_where('rolls', array('user_id'=>$user_id, 'complete'=>0));
		if($query->num_rows() > 0) {
			return $query->row();
		}

		return false;
	}

	function roll($user_id, $seeds) {

		$roll_data = $this->get_open_roll($user_id);

		$final_array = json_decode($roll_data->final_array, true);
		$client_seeds = json_decode($roll_data->client_seeds, true);
		//$seeds = json_decode($roll_data->server_seeds, true);

		if(empty($final_array['roll_1'])) {
			$roll_num = 1;
		} elseif (empty($final_array['roll_2'])) {
			$roll_num = 2;
		} elseif (empty($final_array['roll_3'])) {
			$roll_num = 3;
		}
			
		$dice = json_decode($roll_data->initial_array, true);

   	for($i=1;$i<=5;$i++) {
			$final_array['roll_'.$roll_num][$i] = $this->seed_shuffle($dice['roll_'.$roll_num][$i], $seeds[$i]);
			$client_seeds['roll_'.$roll_num][$i] = $seeds[$i];
		}

		if($roll_num == 3) {
			for($i=1;$i<=5;$i++) {
				$final_array['house_high'][$i] = $this->seed_shuffle($dice['house_high'][$i], $seeds[$i]);
			}
		}



		$this->load->database();
		$update_data = array(
		 	'user_id' => $user_id,
		 	'final_array' => json_encode($final_array),
		 	'client_seeds' => json_encode($client_seeds),
			'updated_on' => date('Y-m-d H:i:s')
		);

		if(!empty($final_array['roll_3'])) {
			$update_data['complete'] = 1;	
		}


		$this->db->where('id', $roll_data->id);
		$this->db->update('rolls', $update_data);

		return array(
			'dice_1'=>$final_array['roll_'.$roll_num][1][0],
			'dice_2'=>$final_array['roll_'.$roll_num][2][0],
			'dice_3'=>$final_array['roll_'.$roll_num][3][0],
			'dice_4'=>$final_array['roll_'.$roll_num][4][0],
			'dice_5'=>$final_array['roll_'.$roll_num][5][0]
		);



	}

	function seed_shuffle( $items, $seed ) {
   		



    if (is_numeric($seed)) {
        $seedval = $seed;
    } else {
      $seedval = crc32($seed);
    }

   srand($seedval);

   for ($i = count($items) - 1; $i > 0; $i--) {
      $j = @rand(0, $i);
      $tmp = $items[$i];
      $items[$i] = $items[$j];
      $items[$j] = $tmp;
   }

   return $items;
	}


	function create_roll($user_id) {

		$this->load->library('guid');

		// $dice = array(
		// 	1 => array(1,2,3,4,5,6),
		// 	2 => array(1,2,3,4,5,6),
		// 	3 => array(1,2,3,4,5,6),
		// 	4 => array(1,2,3,4,5,6),
		// 	5 => array(1,2,3,4,5,6)
		// );

		$dice = array(
			'roll_1' => array(
				1 => array('9','10','J','Q','K','A'),
				2 => array('9','10','J','Q','K','A'),
				3 => array('9','10','J','Q','K','A'),
				4 => array('9','10','J','Q','K','A'),
				5 => array('9','10','J','Q','K','A')
			),
			'roll_2' => array(
				1 => array('9','10','J','Q','K','A'),
				2 => array('9','10','J','Q','K','A'),
				3 => array('9','10','J','Q','K','A'),
				4 => array('9','10','J','Q','K','A'),
				5 => array('9','10','J','Q','K','A')
			),
			'roll_3' => array(
				1 => array('9','10','J','Q','K','A'),
				2 => array('9','10','J','Q','K','A'),
				3 => array('9','10','J','Q','K','A'),
				4 => array('9','10','J','Q','K','A'),
				5 => array('9','10','J','Q','K','A')
			),
			'house_high' => array(
				1 => array('9','10','J','Q','K','A'),
				2 => array('9','10','J','Q','K','A'),
				3 => array('9','10','J','Q','K','A'),
				4 => array('9','10','J','Q','K','A'),
				5 => array('9','10','J','Q','K','A')
			)		
		);

		$server_seeds = array(
			'roll_1' => array(
				1 => md5($this->guid->create_guid().$user_id.time()),
				2 => md5($this->guid->create_guid().$user_id.time()),
				3 => md5($this->guid->create_guid().$user_id.time()),
				4 => md5($this->guid->create_guid().$user_id.time()),
				5 => md5($this->guid->create_guid().$user_id.time())
			),
			'roll_2' => array(
				1 => md5($this->guid->create_guid().$user_id.time()),
				2 => md5($this->guid->create_guid().$user_id.time()),
				3 => md5($this->guid->create_guid().$user_id.time()),
				4 => md5($this->guid->create_guid().$user_id.time()),
				5 => md5($this->guid->create_guid().$user_id.time())
			),
			'roll_3' => array(
				1 => md5($this->guid->create_guid().$user_id.time()),
				2 => md5($this->guid->create_guid().$user_id.time()),
				3 => md5($this->guid->create_guid().$user_id.time()),
				4 => md5($this->guid->create_guid().$user_id.time()),
				5 => md5($this->guid->create_guid().$user_id.time())
			),
			'house_high' => array(
				1 => md5($this->guid->create_guid().$user_id.time()),
				2 => md5($this->guid->create_guid().$user_id.time()),
				3 => md5($this->guid->create_guid().$user_id.time()),
				4 => md5($this->guid->create_guid().$user_id.time()),
				5 => md5($this->guid->create_guid().$user_id.time())
			)
				
		);
		
		// $server_seed[1] = md5($this->guid->create_guid().$user_id.time());
		// $server_seed[2] = md5($this->guid->create_guid().$user_id.time());
		// $server_seed[3] = md5($this->guid->create_guid().$user_id.time());
		// $server_seed[4] = md5($this->guid->create_guid().$user_id.time());
		// $server_seed[5] = md5($this->guid->create_guid().$user_id.time());
		
		foreach($dice as $k => $v) {
			//print_r($v);
			for($i=1;$i<=count($v);$i++) {
				$dice[$k][$i] = $this->seed_shuffle($dice[$k][$i], $server_seeds[$k][$i]);
			}
			//for($i=)
		}

		$secret_array = array(
			'server_seeds' => json_encode($server_seeds),
			'initial_array' => json_encode($dice)
		);
		
		$hash = hash("sha256", json_encode($secret_array));

		$this->load->database();
		$insert_data = array(
		 	'user_id' => $user_id,
		 	'initial_array' => $secret_array['initial_array'],
		 	'final_array' => json_encode(array('roll_1'=>array(),'roll_2'=>array(),'roll_3'=>array(),'house_high'=>array())),
		 	'server_seeds' => $secret_array['server_seeds'],
		 	'hash' => $hash,
		 	'created_on' => date('Y-m-d H:i:s'),
			'updated_on' => date('Y-m-d H:i:s')
		);
		$this->db->insert('rolls', $insert_data);

		return array('hash' => $hash, 'id' => $this->db->insert_id());
	}

	function get_user($guid) {
		$this->load->database();
		return $this->db->get_where('users', array('guid'=> $guid))->row();
	}
}