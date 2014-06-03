<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Actives extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $root_path = null;
	
	public function __construct() {
		parent::__construct();
		$this->load->model('functions/check_user', 'check');
		$this->user = $this->check->validate();
		$this->check->ip();
		$record = $this->check->configuration($this->user);
		$this->_CONFIG = $record['record'];
		if(!$record['state']) {
			$redirectUrl = urlencode($this->config->item('root_path') . 'login');
			redirect("/message?info=SCC_CLOSED&redirect={$redirectUrl}");
		}
		$this->root_path = $this->config->item('root_path');
		$this->load->model('active', 'active');
		$this->load->model('logs', 'logs');
	}
	
	public function deactived() {
		$licenseContent = $this->input->post('license_content', TRUE);
		$machineCode = $this->input->post('machine_code', TRUE);
		if(!empty($licenseContent) || !empty($machineCode)) {
			if($this->active->addBlockInfo(array(
				'license_content'	=>	$licenseContent,
				'client_cpu_info'	=>	$machineCode
			))) {
				echo 'API_DEACTIVED_SUCCESS';
			} else {
				$this->logs->write(array(
					'log_type'	=>	'API_DEACTIVED_ERROR'
				));
				echo 'API_DEACTIVED_ERROR';
			}
		} else {
			$this->logs->write(array(
				'log_type'	=>	'API_DEACTIVED_NO_PARAM'
			));
			echo 'API_DEACTIVED_NO_PARAM';
		}
	}
	
	public function actived() {
		$licenseContent = $this->input->post('license_content', TRUE);
		$machineCode = $this->input->post('machine_code', TRUE);
		if(!empty($licenseContent) || !empty($machineCode)) {
			if($this->active->removeBlockInfo(array(
				'license_content'	=>	$licenseContent,
				'client_cpu_info'	=>	$machineCode
			))) {
				echo 'API_ACTIVED_SUCCESS';
			} else {
				$this->logs->write(array(
					'log_type'	=>	'API_ACTIVED_ERROR'
				));
				echo 'API_ACTIVED_ERROR';
			}
		} else {
			$this->logs->write(array(
				'log_type'	=>	'API_ACTIVED_NO_PARAM'
			));
			echo 'API_ACTIVED_NO_PARAM';
		}
	}
}
?>