<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Js extends CI_Controller {

	public function index()
	{
		$guid = $this->session->userdata('guid');
		$this->load->config('dice_config');
		$data['config'] = json_encode($this->config->item('dice_config'));
		$this->load->model('user_model');
		$user = $this->user_model->get_user($guid);
		
		$data['user'] = json_encode($user);
		$this->load->model('game_model');
		$game = $this->game_model->get_game($user->user_id);

		$data['games'] = json_encode($this->game_model->get_games($user->user_id));

		unset($game->server_seeds);
		unset($game->initial_array);
		unset($game->final_array);
		$data['game'] = json_encode($game);
		header("content-type: application/javascript");

		$this->load->view('js', $data);
	}
}