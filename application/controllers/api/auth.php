<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
	private $root_path = null;
	
	public function __construct() {
		parent::__construct();
		$this->root_path = $this->config->item('root_path');
		$this->load->model('active', 'active');
		$this->load->model('operation/blacklist', 'blacklist');
		$this->load->model('logs', 'logs');
	}
	
	public function authorize() {
		$licenseCode = trim($this->input->get_post('license', TRUE));
		$machineCode = trim($this->input->get_post('machine', TRUE));
		$productId = trim($this->input->get_post('product_id', TRUE));
		$productVersion = trim($this->input->get_post('product_version', TRUE));
		$productFree = trim($this->input->get_post('product_free', TRUE));
		$email = trim($this->input->get_post('email', TRUE));
		
		if($licenseCode!=FALSE && $machineCode!=FALSE && $productId!=FALSE && $productVersion!=FALSE
		&& !empty($licenseCode) && !empty($machineCode) && !empty($productId) && !empty($productVersion)) {
			if($productFree=='1') {
				//是免费产品，直接激活
				$licenseStartTime = $licenseEndTime = time();
				$licenseEndTime += ($licenseTimelimit * 24 * 60 * 60);
				$accountGUID = '';
				if($email!=FALSE) {
					$this->load->model('report/account', 'account');
					$result = $this->account->getAllResult(array(
						'account_mail'	=>	$email
					));
					if($result!=FALSE) {
						$accountGUID = $result[0]->GUID;
					}
				}
				if($this->active->addActiveInfo(array(
					'account_GUID'		=>	$accountGUID,
					'license_content'	=>	$licenseCode,
					'client_cpu_info'	=>	$machineCode,
					'license_start_time'=>	$licenseStartTime,
					'license_end_time'	=>	$licenseEndTime,
					'product_id'		=>	$productId,
					'product_version'	=>	$productVersion
				))) {
					$this->logs->write(array(
						'log_type'	=>	'AUTH_ACTIVE'
					));
					exit('AUTH_ACTIVE');
				} else {
					$this->logs->write(array(
						'log_type'	=>	'AUTH_ACTIVE_DATABASE_ERROR'
					));
					exit('AUTH_ACTIVE_DATABASE_ERROR');
				}
			} else {
				//判定是否已激活
				$result = $this->active->getSmallResult(array(
					'license_content'	=>	$licenseCode,
					'client_cpu_info'	=>	$machineCode
				));
				if($result!=FALSE) {
					$isActived = true;
				} else {
					$isActived = false;
				}
				$isConfirm = true;
				
				//黑名单判定
				$result = $this->blacklist->getAllResult(array(
					'license_content'	=>	$licenseCode,
					'list_actived'		=>	1
				));
				if($result!=false) {
					foreach($result as $row) {
						if(empty($row->client_cpu_info) || $row->client_cpu_info==$machineCode) {
							$isConfirm = false;
							$this->logs->write(array(
								'log_type'	=>	'AUTH_ACTIVE_ERROR_LICENSE_BLOCK'
							));
							exit('AUTH_ACTIVE_ERROR_LICENSE_BLOCK');
						}
					}
				}
				$result = $this->blacklist->getAllResult(array(
					'client_cpu_info'	=>	$machineCode,
					'list_actived'		=>	1
				));
				if($result!=false) {
					foreach($result as $row) {
						if(empty($row->license_content)) {
							$isConfirm = false;
							$this->logs->write(array(
								'log_type'	=>	'AUTH_ACTIVE_ERROR_MACHINE_BLOCK'
							));
							exit('AUTH_ACTIVE_ERROR_MACHINE_BLOCK');
						}
					}
				}
				if($isConfirm) {
					if($isActived) {
						$this->logs->write(array(
							'log_type'	=>	'AUTH_REACTIVE'
						));
						exit('AUTH_REACTIVE');
					} else {
						$licenseStartTime = $licenseEndTime = time();
						$licenseEndTime += ($licenseTimelimit * 24 * 60 * 60);
						$accountGUID = '';
						if($email!=FALSE) {
							$this->load->model('report/account', 'account');
							$result = $this->account->getAllResult(array(
								'account_mail'	=>	$email
							));
							if($result!=FALSE) {
								$accountGUID = $result[0]->GUID;
							}
						}
						if($this->active->addActiveInfo(array(
							'account_GUID'		=>	$accountGUID,
							'license_content'	=>	$licenseCode,
							'client_cpu_info'	=>	$machineCode,
							'license_start_time'=>	$licenseStartTime,
							'license_end_time'	=>	$licenseEndTime,
							'product_id'		=>	$productId,
							'product_version'	=>	$productVersion
						))) {
							$this->logs->write(array(
								'log_type'	=>	'AUTH_ACTIVE'
							));
							exit('AUTH_ACTIVE');
						} else {
							$this->logs->write(array(
								'log_type'	=>	'AUTH_ACTIVE_DATABASE_ERROR'
							));
							exit('AUTH_ACTIVE_DATABASE_ERROR');
						}
					}
				}
			}
		} else {
			$this->logs->write(array(
				'log_type'	=>	'AUTH_ACTIVE_ERROR_NO_PARAM'
			));
			exit('AUTH_ACTIVE_ERROR_NO_PARAM');
		}
	}
	
	public function authorize_strict() {
		
	}
	
	public function verify() {
		$licenseCode = trim($this->input->get_post('license', TRUE));
		$machineCode = trim($this->input->get_post('machine', TRUE));
		
		if($licenseCode!=FALSE && $machineCode!=FALSE && !empty($licenseCode) && !empty($machineCode)) {
			$result = $this->blacklist->getAllResult(array(
				'license_content'	=>	$licenseCode,
				'list_actived'		=>	1
			));
			if($result!=false) {
				foreach($result as $row) {
					if(empty($row->client_cpu_info) || $row->client_cpu_info==$machineCode) {
						$isConfirm = false;
						$this->logs->write(array(
							'log_type'	=>	'AUTH_VERIFY_ERROR_LICENSE_BLOCK'
						));
						exit('AUTH_VERIFY_ERROR_LICENSE_BLOCK');
					}
				}
			}
			$result = $this->blacklist->getAllResult(array(
				'client_cpu_info'	=>	$machineCode,
				'list_actived'		=>	1
			));
			if($result!=false) {
				foreach($result as $row) {
					if(empty($row->license_content)) {
						$isConfirm = false;
						$this->logs->write(array(
							'log_type'	=>	'AUTH_VERIFY_ERROR_MACHINE_BLOCK'
						));
						exit('AUTH_VERIFY_ERROR_MACHINE_BLOCK');
					}
				}
			}
			/*
			$this->load->model('license');
			$result = $this->license->getLicenseResult(array(
				'license_content'	=>	$licenseCode
			));
			if($result!=FALSE) {
				
			} else {
				$this->logs->write(array(
					'log_type'	=>	'AUTH_VERIFY_ERROR_LICENSE_INVALID'
				));
				exit('AUTH_VERIFY_ERROR_LICENSE_INVALID');
			}
			*/
			exit('AUTH_VERIFY_SUCCESS');
		} else {
			$this->logs->write(array(
				'log_type'	=>	'AUTH_VERIFY_ERROR_NO_PARAM'
			));
			exit('AUTH_VERIFY_ERROR_NO_PARAM');
		}
	}
	
	public function verify_strict() {
		
	}
}
?>