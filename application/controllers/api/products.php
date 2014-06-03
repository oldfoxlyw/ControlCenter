<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {
	private $root_path = null;
	public function __construct() {
		parent::__construct();
		$this->root_path = $this->config->item('root_path');
		$this->load->model('product', 'product');
		$this->load->model('logs', 'logs');
	}
	
	public function getVersionById($type = 'json') {
		$productId = $this->input->post('product_id', TRUE);
		$this->config->load('cache', FALSE, TRUE);
		if($this->config->item('is_cache')) {
			$cache = $this->config->item('product_version');
			$result = array();
			foreach($cache as $item) {
				if($item['product_id']==$productId) {
					$result[] = $item;
				}
			}
			if(count($result) > 0) {
				if($type=='json') {
					$data['field'] = array();
					foreach($result as $row) {
						$data['field'][] = array(
							'product_id'		=>	$row['product_id'],
							'product_name'		=>	$row['product_name'],
							'product_version'	=>	$row['product_version']
						);
					}
				}
			} else {
				$data = array(
					'result'	=>	'API_PRODUCT_ID_INVALID',
					'message'	=>	'产品ID编号错误'
				);
			}
		} else {
			$result = $this->product->getAllResult(array(
				'product_id'	=>	$productId
			));
			if($result === FALSE) {
				$data = array(
					'result'	=>	'API_PRODUCT_ID_INVALID',
					'message'	=>	'产品ID编号错误'
				);
			} else {
				if($type=='json') {
					$data['field'] = array();
					foreach($result as $row) {
						$data['field'][] = array(
							'product_id'		=>	$row->product_id,
							'product_name'		=>	$row->product_name,
							'product_version'	=>	$row->product_version
						);
					}
				}
			}
		}
		echo json_encode($data);
	}
	
	public function getFunctionByProduct($type = 'json') {
		$productId		= $this->input->post('product_id', TRUE);
		$productVersion	= $this->input->post('product_version', TRUE);
		$this->config->load('cache', FALSE, TRUE);
		if($this->config->item('is_cache')) {
			$cache = $this->config->item('product_function');
			$result = array();
			foreach($cache as $item) {
				if($item['product_id']==$productId && $item['product_version']==$productVersion) {
					$result = $item;
					break;
				}
			}
			if(count($result['function_list']) > 0) {
				if($type=='json') {
					$data['field'] = array();
					foreach($result['function_list'] as $row) {
						$data['field'][] = array(
							'func_id'		=>	$row['func_id'],
							'func_name'		=>	$row['func_name']
						);
					}
				}
			} else {
				$data = array(
					'result'	=>	'API_PRODUCT_ID_VERSION_INVALID',
					'message'	=>	'产品ID或版本号错误'
				);
			}
		} else {
			$result = $this->product->getFunctions(array(
				'product_id'		=>	$productId,
				'product_version'	=>	$productVersion
			));
			if($result === FALSE) {
				$data = array(
					'result'	=>	'API_PRODUCT_ID_VERSION_INVALID',
					'message'	=>	'产品ID或版本号错误'
				);
			} else {
				if($type=='json') {
					$data['field'] = array();
					foreach($result as $row) {
						$data['field'][] = array(
							'func_id'		=>	$row->func_id,
							'func_name'		=>	$row->func_name
						);
					}
				}
			}
		}
		echo json_encode($data);
	}
	
	public function update() {
		$product_id = trim($this->input->get_post('product_id', TRUE));
		if(!empty($product_id)) {
			$result = $this->product->getAllResult(array(
				'product_id'		=>	$product_id,
				'order_by'			=>	array('product_version', 'desc'),
				'limit'				=>	1
			));
			if($result!=FALSE) {
				exit($result[0]->product_version);
			} else {
				$this->logs->write(array(
					'log_type'	=>	'CHECK_ERROR_NOT_EXIST'
				));
				exit('CHECK_ERROR_NOT_EXIST');
			}
		} else {
			$this->logs->write(array(
				'log_type'	=>	'CHECK_ERROR_NO_PARAM'
			));
			exit('CHECK_ERROR_NO_PARAM');
		}
	}
	
	public function control() {
		$productId = trim($this->input->get_post('product_id', TRUE));
		$productVersion = trim($this->input->get_post('product_version', TRUE));
		$licenseContent = trim($this->input->get_post('license', TRUE));
		
		$this->load->helper('security');
		if(!empty($licenseContent)) {
			$this->load->model('license');
			$result = $this->license->getLicenseResult(array(
				'license_content'	=>	$licenseContent
			));
			if($result!=FALSE) {
				$command = $result[0]->license_control_command;
				if(empty($command)) {
					exit('CONTROL_PASS');
				} else {
					$count = explode('@@', $command);
					if(count($count) >= 1) {
						echo $command;
					} else {
						$this->logs->write(array(
							'log_type'	=>	'CONTROL_DATABASE_ERROR'
						));
						exit('CONTROL_DATABASE_ERROR');
					}
				}
			} else {
				$this->logs->write(array(
					'log_type'	=>	'CONTROL_ERROR_NOT_EXIST'
				));
				exit('CONTROL_ERROR_NOT_EXIST');
			}
		} else {
			if(!empty($productId) && !empty($productVersion)) {
				$result = $this->product->getAllResult(array(
					'product_id'		=>	$productId,
					'product_version'	=>	$productVersion
				));
				if($result!=FALSE) {
					$command = $result[0]->product_control_command;
					if(empty($command)) {
						exit('CONTROL_PASS');
					} else {
						$count = explode('@@', $command);
						if(count($count) >= 1) {
							echo $command;
						} else {
							$this->logs->write(array(
								'log_type'	=>	'CONTROL_DATABASE_ERROR'
							));
							exit('CONTROL_DATABASE_ERROR');
						}
					}
				} else {
					$this->logs->write(array(
						'log_type'	=>	'CONTROL_ERROR_NOT_EXIST'
					));
					exit('CONTROL_ERROR_NOT_EXIST');
				}
			} else {
				$this->logs->write(array(
					'log_type'	=>	'CONTROL_ERROR_NO_PARAM'
				));
				exit('CONTROL_ERROR_NO_PARAM');
			}
		}
	}
	
	public function ip() {
		$ip = $this->input->ip_address();
		if($ip!='0.0.0.0') {
			echo $ip;
		} else {
			$this->logs->write(array(
				'log_type'	=>	'IP_ERROR_INVALID'
			));
			exit('IP_ERROR_INVALID');
		}
	}
	
	public function message() {
		$productId = $this->input->get_post('product_id', TRUE);
		$productVersion = $this->input->get_post('product_version', TRUE);
		$type = $this->input->get_post('type', TRUE);
		
		if(!empty($productId) && !empty($productVersion)) {
			$result = $this->product->getAllResult(array(
				'product_id'		=>	$productId,
				'product_version'	=>	$productVersion
			));
			if($result!=FALSE) {
				if(!empty($type)) {
					if($type=='url') {
						if(!empty($result[0]->product_message_url)) {
							echo 'URL@@' . $result[0]->product_message_url;
						} else {
							exit('MESSAGE_NONE');
						}
					} else {
						if(!empty($result[0]->product_message_text)) {
							echo 'TEXT@@' . $result[0]->product_message_text;
						} else {
							exit('MESSAGE_NONE');
						}
					}
				} else {
					$type = $result[0]->product_default_message;
					if($type=='url') {
						if(!empty($result[0]->product_message_url)) {
							echo 'URL@@' . $result[0]->product_message_url;
						} else {
							exit('MESSAGE_NONE');
						}
					} elseif($type=='text') {
						if(!empty($result[0]->product_message_text)) {
							echo 'TEXT@@' . $result[0]->product_message_text;
						} else {
							exit('MESSAGE_NONE');
						}
					}
				}
			} else {
				exit('MESSAGE_ERROR_NOT_EXIST');
			}
		} else {
			exit('MESSAGE_ERROR_NO_PARAM');
		}
	}
	
	public function getAccessToken() {
		$productId = $this->input->get_post('product_id', TRUE);
		$productVersion = $this->input->get_post('product_version', TRUE);
		
		if(!empty($productId) && !empty($productVersion)) {
			$result = $this->product->getAllResult(array(
				'product_id'		=>	$productId,
				'product_version'	=>	$productVersion
			));
			if($result!=FALSE) {
				echo $result[0]->product_access_token;
			} else {
				exit('API_PRODUCT_NOT_EXIST');
			}
		} else {
			exit('API_ERROR_NO_PARAM');
		}
	}
	/*
	public function updateProductToken() {
		$this->load->library('Guid');
		$this->load->library('encrypt');
		$result = $this->product->getAllResult();
		foreach($result as $row) {
			$guid = $row->product_guid;
			$key = $row->product_id . '_' . $row->product_version;
			$accessToken = $this->encrypt->encode(md5($guid), md5($key));
			$accessToken = replace_invalid_characters($accessToken);
			echo "{$row->product_id} {$row->product_version} {$key} {$accessToken}<br>";
			$parameter = array(
				'product_access_token'	=>	$accessToken
			);
			$this->product->update($parameter, $row->PID);
		}
	}
	*/
}
?>