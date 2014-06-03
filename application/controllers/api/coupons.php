<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Coupons extends CI_Controller {
	private $root_path = null;
	
	public function __construct() {
		parent::__construct();
		$this->root_path = $this->config->item('root_path');
		$this->load->model('product', 'product');
		$this->load->model('logs', 'logs');
	}
	
	public function get_redirect() {
		$coupon = $this->input->get_post('coupon', TRUE);
		if(!empty($coupon)) {
			$this->load->model('operation/coupon', 'coupon');
			$result = $this->coupon->getAllResult(array(
				'coupon_content'	=>	$coupon
			));
			if($result!=FALSE) {
				$row = $result[0];
				if(!empty($row->redirect_url)) {
					echo urlencode($row->redirect_url);
				}
			} else {
				$this->logs->write(array(
					'log_type'	=>	'GROUP_ERROR_COUPON_INVALID'
				));
				exit('GROUP_ERROR_COUPON_INVALID');
			}
		} else {
			$this->logs->write(array(
				'log_type'	=>	'GROUP_REDIRECT_ERROR_NO_PARAM'
			));
			exit('GROUP_REDIRECT_ERROR_NO_PARAM');
		}
	}
	
	public function get_auto_template() {
		$auto_id = $this->input->get_post('auto', TRUE);
		if(!empty($auto_id)) {
			$this->load->model('web/auto', 'auto');
			$result = $this->auto->get($auto_id);
			if($result!=FALSE) {
				if(!empty($result->template_content)) {
					echo $result->template_content;
				}
			} else {
				$this->logs->write(array(
					'log_type'	=>	'GROUP_ERROR_COUPON_INVALID'
				));
				exit('GROUP_ERROR_COUPON_INVALID');
			}
		} else {
			$this->logs->write(array(
				'log_type'	=>	'GROUP_REDIRECT_ERROR_NO_PARAM'
			));
			exit('GROUP_REDIRECT_ERROR_NO_PARAM');
		}
	}
	
	public function get_random_coupon() {
		$couponType = $this->input->get_post('type', TRUE);
		$table = $this->input->get_post('table', TRUE);
		if(!empty($couponType)) {
			$this->load->model('operation/coupon', 'coupon');
			$parameter = array(
				'coupon_disabled'	=>	0,
				'coupon_type'		=>	$couponType
			);
			$result = $this->coupon->getAllResult($parameter);
			
			$promotiondb = $this->load->database('promotiondb', TRUE);
			$promotiondb->where('partner_id', $couponType);
			$query = $promotiondb->get($table);
			if($query->num_rows() > 0) {
				$row = $query->row();
				$currentShow = intval($row->partner_current_show);
				$totalShow = intval($row->partner_total_show);
				if($currentShow >= $totalShow) {
					$promotiondb->set('partner_license_limit', 1);
					$promotiondb->set('partner_license_limittime', time());
				} else {
					$promotiondb->set('partner_current_show', 'partner_current_show+1', FALSE);
				}
			} else {
				exit('-1');
			}
			
			$promotiondb->where('partner_id', $couponType);
			$promotiondb->set('partner_license_remain', 'partner_license_remain-1', FALSE);
			$promotiondb->update($table);
			if($result!=FALSE) {
				$ret = $result[0];
				if($ret->coupon_duplicated != '1') {
					$parameter = array(
						'coupon_disabled'	=>	1
					);
					$this->coupon->update($parameter, $ret->coupon_id);
				}
				exit($ret->coupon_content);
			} else {
				$promotiondb = $this->load->database('promotiondb', TRUE);
				$promotiondb->where('partner_id', $couponType);
				$promotiondb->set('partner_license_remain', 0);
				$promotiondb->update($table);
				exit('RANDOM_COUPON_ERROR_NO_TYPE');
			}
		} else {
			exit('RANDOM_COUPON_ERROR_NO_PARAM');
		}
	}
	
	public function group() {
		$auto_id		=	$this->input->get_post('auto_id', TRUE);
		$couponContent	=	trim($this->input->get_post('couponContent', TRUE));
		$firstName		=	trim($this->input->get_post('firstName', TRUE));
		$lastName		=	trim($this->input->get_post('lastName', TRUE));
		$email			=	trim($this->input->get_post('email', TRUE));
		$fromWhere		=	trim($this->input->get_post('from', TRUE));
		$isDuplicated	=	trim($this->input->get_post('duplicated', TRUE));
		if(!empty($couponContent) && !empty($email)) {
			$this->load->model('operation/coupon', 'coupon');
			$result = $this->coupon->getAllResult(array(
				'coupon_content'	=>	$couponContent
			));
			if($result!=FALSE) {
				$row = $result[0];
				if($row->coupon_disabled!='1') {
					if(!empty($auto_id)) {
						$autoId = $auto_id;
					} else {
						$autoId = $row->auto_id;
					}
					$productId = $row->product_id;
					$productVersion = $row->product_version;
					$couponId = $row->coupon_id;
					$duplicated = $row->coupon_duplicated;
					$isSendEmail = $row->coupon_sendmail;
					
					$this->load->model('report/account', 'account');
					if($isDuplicated=='1') {
						$result = FALSE;
					} else {
						$result = $this->account->getAllResult(array(
							'account_mail'	=>	$email
						));
					}
					if($result!=FALSE) {
						$this->logs->write(array(
							'log_type'	=>	'GROUP_ERROR_EMAIL_EXIST'
						));
						exit('GROUP_ERROR_EMAIL_EXIST');
					} else {
						$this->load->library('Guid');
						$guid = $this->guid->toString();
						$regtime = time();
						$parameter = array(
							'GUID'					=>	$guid,
							'account_mail'			=>	$email,
							'account_regtime'		=>	$regtime,
							'account_reglocaltime'	=>	date('Y-m-d H:i:s', $regtime),
							'account_firstname'		=>	$firstName,
							'account_lastname'		=>	$lastName,
							'from_where'			=>	$fromWhere
						);
						$this->account->insert($parameter);
					}
					if($isSendEmail=='1') {
						$mailList = Array();
						array_push($mailList, $email);
						$parser = Array(
							'first_name'	=>	$firstName,
							'last_name'		=>	$lastName
						);
						$parserTemplate = array(
							'name'	=>	$firstName . ' ' . $lastName
						);
						$parameter = array(
							'auto_id'			=>	$autoId,
							'mail_list'			=>	$mailList,
							'reader_name_parser'=>	$parser,
							'template_parser'	=>	$parserTemplate
						);
						$this->load->model('web/mail', 'mail');
						if($this->mail->autoSendMail($parameter)) {
							if($duplicated!='1') {
								$parameter = array(
									'coupon_disabled'	=>	1
								);
								$this->coupon->update($parameter, $couponId);
							}
							$this->logs->write(array(
								'log_type'	=>	'GROUP_SUCCESS'
							));
							exit('GROUP_SUCCESS');
						} else {
							$this->logs->write(array(
								'log_type'	=>	'GROUP_ERROR_MAIL'
							));
							exit('GROUP_ERROR_MAIL');
						}
					} else {
						if($duplicated!='1') {
							$parameter = array(
								'coupon_disabled'	=>	1
							);
							$this->coupon->update($parameter, $couponId);
						}
						$this->logs->write(array(
							'log_type'	=>	'GROUP_SUCCESS'
						));
						exit('GROUP_SUCCESS');
					}
				} else {
					$this->logs->write(array(
						'log_type'	=>	'GROUP_ERROR_COUPON_DISABLED'
					));
					exit('GROUP_ERROR_COUPON_DISABLED');
				}
			} else {
				$this->logs->write(array(
					'log_type'	=>	'GROUP_ERROR_COUPON_INVALID'
				));
				exit('GROUP_ERROR_COUPON_INVALID');
			}
		} else {
			$this->logs->write(array(
				'log_type'	=>	'GROUP_ERROR_NO_PARAM'
			));
			exit('GROUP_ERROR_NO_PARAM');
		}
	}
}
?>