<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deposit_callback extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		
		$this->load->database();
		$transaction_hash = $this->input->get('transaction_hash');
		$value = $this->input->get('value');
		$input_address = $this->input->get('input_address');
		$confirmations = $this->input->get('confirmations');
		$secret = $this->input->get('secret');

		//Commented out to test, uncomment when live
		if ($this->input->get('test')) {
		  echo 'Ignoring Test Callback';
		  return;
		}

		if ($secret != $this->config->item('secret')) {
		  echo 'Invalid Secret';
		  return;
		}

		//check to see if the transaction already exists
		$this->load->model('bitcoin_model');

		$tran = $this->bitcoin_model->get_deposit_by_tran($transaction_hash);

		if(!$tran) {
			// this is a new deposit
			// find the user that owns that address
			$this->load->model('user_model');
			$user = $this->user_model->get_by_address($input_address);

			if(!$user) {
				die('not ok');
			}
			
			// create the deposit
			$deposit = $this->bitcoin_model->deposit($user->user_id, $transaction_hash, $value, $confirmations, $input_address);

			// update the user balance
			$this->user_model->credit_balance($user->user_id, $value);

			// add a transaction
			$this->load->model('transaction_model');
			$this->transaction_model->enter_transaction($user->user_id, 'credit', $value, $user->available_balance + $value,  'Deposit #'.$deposit);

			//$this->bitcoin_model->deposit()
		} else {
			// this transaction exists and we need to update the confirmations
			$this->bitcoin_model->update_confirmations($tran->id, $confirmations);

			if($confirmations > 5) {
				die('*ok*');
			}

		}

		die('not ok');
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */