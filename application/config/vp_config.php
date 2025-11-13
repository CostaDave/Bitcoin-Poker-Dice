<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Load game_config which contains the vp settings
require_once(APPPATH.'config/game_config.php');

// Video Poker configuration
$config['vp_config']['number_of_jokers'] = 0;
$config['vp_config']['number_of_decks'] = 1;
$config['vp_config']['shuffle_every_hand'] = true;

// Copy vp config from game_config
$config['vp_config']['vp'] = isset($config['game_config']['vp']) ? $config['game_config']['vp'] : array();
$config['vp_config']['affiliate_percent'] = isset($config['game_config']['affiliate_percent']) ? $config['game_config']['affiliate_percent'] : 0.075;

// Demo mode
$demo_mode_env = getenv('GAME_DEMO_MODE');
$config['vp_config']['demo_mode'] = ($demo_mode_env !== false) ? filter_var($demo_mode_env, FILTER_VALIDATE_BOOLEAN) : false;

