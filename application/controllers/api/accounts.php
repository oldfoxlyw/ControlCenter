<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends CI_Controller {
	private $root_path = null;
	
	public function __construct() {
		parent::__construct();
		$this->root_path = $this->config->item('root_path');
		$this->load->model('active', 'active');
		$this->load->model('report/account', 'account');
		$this->load->model('logs', 'logs');
	}
	
	public function register() {
		$email			=	trim($this->input->get_post('email', TRUE));
		$firstName		=	trim($this->input->get_post('firstName', TRUE));
		$lastName		=	trim($this->input->get_post('lastName', TRUE));
		$sex			=	trim($this->input->get_post('sex', TRUE));
		$country		=	trim($this->input->get_post('country', TRUE));
		$acceptMail		=	trim($this->input->get_post('acceptMail', TRUE));
		$productId		=	trim($this->input->get_post('product_id', TRUE));
		$productVersion	=	trim($this->input->get_post('product_version', TRUE));
		$fromWhere		=	trim($this->input->get_post('fromWhere', TRUE));
	
		if($email!=FALSE) {
			/*
			$sql = "select `account_mail` from `web_accounts` where `account_mail`='$email'";
			$result = $db->query($sql);
			if($db->num_rows($result) > 0) {
				echo 'REG_ERROR_EMAIL_EXIST';
				exit();
			} else {
			*/
			$this->load->library('Guid');
			$guid = $this->guid->toString();
			$regtime = time();
			if($this->account->insert(array(
				'GUID'				=>	$guid,
				'account_mail'		=>	$email,
				'account_regtime'	=>	$regtime,
				'account_reglocaltime'=>date('Y-m-d H:i:s', $regtime),
				'account_firstname'	=>	$firstName,
				'account_lastname'	=>	$lastName,
				'account_sex'		=>	$sex,
				'account_country'	=>	$country,
				'accept_mail'		=>	$acceptMail,
				'from_where'		=>	$fromWhere,
				'product_id'		=>	$productId,
				'product_version'	=>	$productVersion
			))) {
				$this->logs->write(array(
					'log_type'	=>	'REG_SUCCESS'
				));
				exit('REG_SUCCESS');
			} else {
				$this->logs->write(array(
					'log_type'	=>	'REG_DATABASE_ERROR'
				));
				exit('REG_DATABASE_ERROR');
			}
			//}
		} else {
			$this->logs->write(array(
				'log_type'	=>	'REG_ERROR_NO_PARAM'
			));
			exit('REG_ERROR_NO_PARAM');
		}
	}
}
?>