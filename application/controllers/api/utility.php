<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Utility extends CI_Controller {
	private $root_path = null;
	
	public function __construct() {
		parent::__construct();
		$this->root_path = $this->config->item('root_path');
	}
	
	public function clear() {
		$target = $this->input->get_post('target', TRUE);
		switch($target) {
			case 'register':
				$db = $this->load->database('accountdb', TRUE);
				$db->truncate('web_accounts');
				break;
			case 'auth':
				$db = $this->load->database('authdb', TRUE);
				$db->truncate('sys_actived');
				break;
			case 'feed':
				$db = $this->load->database('logdb', TRUE);
				$db->truncate('log_client_statistic');
				break;
			case 'all':
				$db = $this->load->database('accountdb', TRUE);
				$db->truncate('web_accounts');
				$db = $this->load->database('authdb', TRUE);
				$db->truncate('sys_actived');
				$db = $this->load->database('logdb', TRUE);
				$db->truncate('log_client_statistic');
				break;
		}
	}
}
?>