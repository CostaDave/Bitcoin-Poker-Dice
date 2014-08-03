<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bitcoin {
	
	
	var $bc_api = 'https://blockchain.info/merchant/';

	public function __construct(){
		return true;
	}

	public function get_address($guid) {
		
		$CI =& get_instance();
		$CI->config->load('btc_config');

		$opts = array(
			'password' 	=> $CI->config->item('blockchain_password'),
			'label'	=> $guid
		);

		$url = $this->bc_api.$CI->config->item('blockchain_identifier').'/new_address?';


		return $this->sendGet($url,$opts);
	}

	private function sendGet($url, $options) {

		//die($url.http_build_query($options));

		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $url.http_build_query($options)
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);

		// Close request to clear up some resources
		curl_close($curl);

		return $resp;
	}

}