<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['client_type'] = getenv('BTC_CLIENT_TYPE') ? getenv('BTC_CLIENT_TYPE') : 'blockchain'; //jsonrpc or blockchain

$config['rpc_scheme'] = getenv('BTC_RPC_SCHEME') ? getenv('BTC_RPC_SCHEME') : 'http';
$config['rpc_port'] = getenv('BTC_RPC_PORT') ? (int) getenv('BTC_RPC_PORT') : 8332;
$config['rpc_host'] = getenv('BTC_RPC_HOST') ? getenv('BTC_RPC_HOST') : 'localhost';
$config['rpc_user'] = getenv('BTC_RPC_USER') ? getenv('BTC_RPC_USER') : 'demo';
$config['rpc_pass'] = getenv('BTC_RPC_PASS') ? getenv('BTC_RPC_PASS') : 'demo';

$config['blockchain_identifier'] = getenv('BTC_BLOCKCHAIN_IDENTIFIER') ? getenv('BTC_BLOCKCHAIN_IDENTIFIER') : '';
$config['blockchain_password'] = getenv('BTC_BLOCKCHAIN_PASSWORD') ? getenv('BTC_BLOCKCHAIN_PASSWORD') : '';
$config['btc_callback_url'] = getenv('BTC_CALLBACK_URL') ? getenv('BTC_CALLBACK_URL') : 'btc/bc_callback';
$config['max_withdrawal_no_approval'] = getenv('BTC_MAX_WITHDRAWAL_NO_APPROVAL') ? (int) getenv('BTC_MAX_WITHDRAWAL_NO_APPROVAL') : 10000000; // 0.1 BTC