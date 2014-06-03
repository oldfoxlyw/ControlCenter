<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class logs extends CI_Model {
	private $authName = 'log_auth';
	private $verifyName = 'log_verify';
	private $groupName = 'log_group';
	private $webName = 'log_scc';
	private $apiName = 'log_api';
	private $viewName = 'auth_actived_view';
	private $logdb = null;
	
	public function __construct() {
		parent::__construct();
		$this->logdb = $this->load->database('logdb', true);
	}
	
	public function write($parameter) {
		if(!empty($parameter) && !empty($parameter['log_type'])) {
			$relativePage			=	$this->input->server('PHP_SELF');
			$relativeMethod			=	$this->input->server('REQUEST_METHOD');
			$relativeParameterArray	=	Array();
			$relativeParameter		=	'';
			$license = $machine = $product = $version = '';
			$coupon = $firstName = $lastName = $email = $from = '';
			
			foreach($_REQUEST as $key => $value) {
				if($key=='license') {
					$license = $value;
				} elseif($key=='machine') {
					$machine = $value;
				} elseif($key=='product_id') {
					$product = $value;
				} elseif($key=='product_version') {
					$version = $value;
				} elseif($key=='couponContent') {
					$coupon = $value;
				} elseif($key=='firstName') {
					$firstName = $value;
				} elseif($key=='lastName') {
					$lastName = $value;
				} elseif($key=='email') {
					$email = $value;
				} elseif($key=='from') {
					$from = $value;
				} 
				if(is_numeric($value)) {
					$relativeParameterArray[] = "\"$key\": $value";
				} elseif(empty($value)) {
					$relativeParameterArray[] = "\"$key\": null";
				} else {
					$relativeParameterArray[] = "\"$key\": \"$value\"";
				}
			}
			$relativeParameter = '{' . implode(', ', $relativeParameterArray) . '}';
			$currentTime		=	date("Y-m-d H:i:s", time());
			
			$logType = explode('_', $parameter['log_type']);
			switch($logType[0]) {
				case 'SCC':
					$currentUser = $parameter['user_name'];
					$row = array(
						'log_type'				=>	$parameter['log_type'],
						'log_user'				=>	$currentUser,
						'log_relative_page_url'	=>	$relativePage,
						'log_relative_parameter'=>	$relativeParameter,
						'log_relative_method'	=>	$relativeMethod,
						'log_time'				=>	$currentTime
					);
					$this->logdb->insert($this->webName, $row);
					break;
				case 'AUTH':
					$row = array(
						'log_type'				=>	$parameter['log_type'],
						'client_cpu_info'		=>	$machine,
						'license_content'		=>	$license,
						'product_id'			=>	$product,
						'product_version'		=>	$version,
						'log_relative_parameter'=>	$relativeParameter,
						'log_time'				=>	$currentTime
					);
					if($logType[1]=='ACTIVE') {
						$this->logdb->insert($this->authName, $row);
					} elseif($logType[1]=='VERIFY') {
						$this->logdb->insert($this->verifyName, $row);
					} else {
						$this->logdb->insert($this->authName, $row);
					}
					break;
				case 'GROUP':
					$row = array(
						'log_type'				=>	$parameter['log_type'],
						'log_coupon_content'	=>	$coupon,
						'log_first_name'		=>	$firstName,
						'log_last_name'			=>	$lastName,
						'log_email'				=>	$email,
						'log_relative_page_url'	=>	$relativePage,
						'log_relative_parameter'=>	$relativeParameter,
						'log_relative_method'	=>	$relativeMethod,
						'log_time'				=>	$currentTime,
						'log_from'				=>	$from
					);
					$this->logdb->insert($this->groupName, $row);
					break;
				default:
					$row = array(
						'log_type'				=>	$parameter['log_type'],
						'log_email'				=>	$email,
						'log_product_id'		=>	$product,
						'log_product_version'	=>	$version,
						'log_relative_parameter'=>	$relativeParameter,
						'log_relative_method'	=>	$relativeMethod,
						'log_time'				=>	$currentTime
					);
					$this->logdb->insert($this->apiName, $row);
			}
		}
	}
}
?>