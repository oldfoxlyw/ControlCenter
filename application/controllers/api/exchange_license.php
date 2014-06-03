<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Exchange_license extends CI_Controller {
	private $root_path = null;
	private $authdb = null;
	
	public function __construct() {
		parent::__construct();
		$this->root_path = $this->config->item('root_path');
		$this->authdb = $this->load->database('authdb', TRUE);
		$this->load->model('logs', 'logs');
	}
	
	public function exchange() {
		$email = $this->input->get_post('email', TRUE);
		$product = $this->input->get_post('product', TRUE);		//product id = auto mail id
		$product_key = $this->input->get_post('key', TRUE);
		$website = $this->input->get_post('website', TRUE);
		if(!empty($email)) {
			$this->authdb->where('order_email', $email);
			$this->authdb->where('website', $website);
			$query = $this->authdb->get('export_record');
			$query_count = 0;
			if($query->num_rows() > 0) {
				$result = $query->result();
				$total_gross = 0;
				$total_product = '';
				foreach($result as $row) {
					$query_count = $row->query_count;
					if($row->query_count >= 10) {
						$this->logs->write(array(
							'log_type'	=>	'API_EXCHANGE_LICENSE_ERROR_MAX_QUERY'
						));
						exit('API_EXCHANGE_LICENSE_ERROR_MAX_QUERY');
					}
					$total_gross += floatval($row->gross);
					$total_product .= strtolower($row->product_name);
				}
				if($total_gross >= 10) {
					if($product_key=='ripper') {
						if(strpos( $total_product, $product_key ) ||
						strpos( $total_product, 'rlpper' ) ||
						strpos( $total_product, 'pack' )!==FALSE) {
							
							$this->logs->write(array(
								'log_type'	=>	'API_EXCHANGE_LICENSE_SUCCESS'
							));
							$parameter = $this->_update($product, $email, $query_count);
							exit(json_encode($parameter));
							
						} else {
							$this->logs->write(array(
								'log_type'	=>	'API_EXCHANGE_LICENSE_ERROR_NO_PRODUCT'
							));
							exit('API_EXCHANGE_LICENSE_ERROR_NO_PRODUCT');
						}
					} elseif($product_key=='copy') {
						if(strpos( $total_product, $product_key ) ||
						strpos( $total_product, 'c0py' ) ||
						strpos( $total_product, 'pack' )!==FALSE) {
							
							$this->logs->write(array(
								'log_type'	=>	'API_EXCHANGE_LICENSE_SUCCESS'
							));
							$parameter = $this->_update($product, $email, $query_count);
							exit(json_encode($parameter));
							
						} else {
							$this->logs->write(array(
								'log_type'	=>	'API_EXCHANGE_LICENSE_ERROR_NO_PRODUCT'
							));
							exit('API_EXCHANGE_LICENSE_ERROR_NO_PRODUCT');
						}
					} else {
						if(strpos( $total_product, $product_key ) ||
						strpos( $total_product, 'pack' )!==FALSE) {
							
							$this->logs->write(array(
								'log_type'	=>	'API_EXCHANGE_LICENSE_SUCCESS'
							));
							$parameter = $this->_update($product, $email, $query_count);
							exit(json_encode($parameter));
							
						} else {
							$this->logs->write(array(
								'log_type'	=>	'API_EXCHANGE_LICENSE_ERROR_NO_PRODUCT'
							));
							exit('API_EXCHANGE_LICENSE_ERROR_NO_PRODUCT');
						}
					}
				} else {
					$this->logs->write(array(
						'log_type'	=>	'API_EXCHANGE_LICENSE_ERROR_REFUNDED'
					));
					exit('API_EXCHANGE_LICENSE_ERROR_REFUNDED');
				}
			} else {
				$this->logs->write(array(
					'log_type'	=>	'API_EXCHANGE_LICENSE_ERROR_NOT_EXIST'
				));
				exit('API_EXCHANGE_LICENSE_ERROR_NOT_EXIST');
			}
		} else {
			$this->logs->write(array(
				'log_type'	=>	'API_EXCHANGE_LICENSE_ERROR_NO_PARAM'
			));
			exit('API_EXCHANGE_LICENSE_ERROR_NO_PARAM');
		}
	}
	
	public function _update($product, $email, $query_count) {
		$data = array(
			'aid'	=>	$product,
			'email'	=>	$email,
			'name'	=>	''
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://www.datacenter-digiarty.com/ControlCenter/api/mail/send');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, $HTTP_SERVER_VARS['HTTP_USER_AGENT']);
		$monfd = curl_exec($ch);
		
		$this->authdb->where('order_email', $email);
		$this->authdb->set('query_count', 'query_count+1', FALSE);
		$this->authdb->update('export_record');
		
		$parameter = array(
			'product'		=>	$product,
			'query'			=>	intval($query_count) + 1,
			'email'			=>	$email
		);
		
		return $parameter;
	}
}
?>