<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bitcoinservice {


	
	CONST MAINNET = "00";
	CONST TESTNET = "6F";
	
	var $bc_api = 'https://blockchain.info/merchant/';

	public function __construct(){
		require_once('bitcoin.inc');
		return true;
	}

	function get_balance() {
		// $CI =& get_instance();
		// $CI->config->load('btc_config');

		// $opts = array(
		// 	'password' => $CI->config->item('blockchain_password')
		// 	);

		// $url = $this->bc_api.$CI->config->item('blockchain_identifier').'/balance?';

		// return $this->sendGet($url,$opts);

		return json_encode(array('balance'=>1454347323));
	}

	function send($address, $amount) {
		$CI =& get_instance();
		$CI->config->load('btc_config');

		$opts = array(
			'password' => $CI->config->item('blockchain_password'),
			'to'						=> $address,
			'amount'				=> $amount,

			);

		$url = $this->bc_api.$CI->config->item('blockchain_identifier').'/payment?';

		return $this->sendGet($url,$opts);
	}


	// function get_address1($guid) {
	// 	$CI =& get_instance();
	// 	$CI->config->load('btc_config');
	// 	$client = new BitcoinClient(
	// 		$CI->config->item('rpc_scheme'),
	// 		$CI->config->item('rpc_user'),
	// 		$CI->config->item('rpc_pass'),
	// 		$CI->config->item('rpc_host'),
	// 		$CI->config->item('rpc_port'),
	// 		'',
	// 		1
	// 	);

	// 	$address = $client->help();

	// 	die($address);
	// }


	function get_address($guid) {
		
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

		$url = $url.http_build_query($options);

		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url
			));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		// Close request to clear up some resources
		curl_close($curl);

		return $resp;
	}

	static public function isValid($addr, $version = null) {

		if (is_null($version)) {
			$version = self::MAINNET;
		}

		if (preg_match('/[^1-9A-HJ-NP-Za-km-z]/', $addr)) {
			return false;
		}

		$decoded = self::decodeAddress($addr);

		if (strlen($decoded) != 50) {
			return false;
		}

		if (substr($decoded, 0, 2) != $version && substr($decoded, 0, 2) != "05") {
			return false;
		}

		$check = substr($decoded, 0, strlen($decoded) - 8);
		$check = pack("H*", $check);
		$check = hash("sha256", $check, true);
		$check = hash("sha256", $check);
		$check = strtoupper($check);
		$check = substr($check, 0, 8);

		return ($check == substr($decoded, strlen($decoded) - 8));
	}

	static protected function decodeAddress($data) {

		$charsetHex = '0123456789ABCDEF';
		$charsetB58 = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';

		$raw = "0";
		for ($i = 0; $i < strlen($data); $i++) {
			$current = (string) strpos($charsetB58, $data[$i]);
			$raw = (string) bcmul($raw, "58", 0);
			$raw = (string) bcadd($raw, $current, 0);
		}

		$hex = "";
		while (bccomp($raw, 0) == 1) {
			$dv = (string) bcdiv($raw, "16", 0);
			$rem = (integer) bcmod($raw, "16");
			$raw = $dv;
			$hex = $hex . $charsetHex[$rem];
		}

		$withPadding = strrev($hex);
		for ($i = 0; $i < strlen($data) && $data[$i] == "1"; $i++) {
			$withPadding = "00" . $withPadding;
		}

		if (strlen($withPadding) % 2 != 0) {
			$withPadding = "0" . $withPadding;
		}

		return $withPadding;
	}

}