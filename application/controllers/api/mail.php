<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mail extends CI_Controller {
	private $root_path = null;
	private $fobiddenEmail = array();
	
	public function __construct() {
		parent::__construct();
		$this->root_path = $this->config->item('root_path');
		$this->fobiddenEmail = $this->config->item('fobidden_email');
		$this->load->model('web/auto', 'auto');
		$this->load->model('web/mail_template', 'mail_template');
	}
	
	public function send() {
		$autoId = $this->input->get_post('aid', TRUE);
		$userEmail = urldecode($this->input->get_post('email', TRUE));
		
		if(in_array($userEmail, $this->fobiddenEmail)) {
			$this->logs->write(array(
				'log_type'	=>	'API_MAIL_SEND_FOBIDDEN'
			));
			echo 'API_MAIL_SEND_FOBIDDEN';
		}
		
		$userName = $this->input->get_post('name', TRUE);
		if($autoId===FALSE) {
			echo 'API_MAIL_SEND_ERROR';
		} else {
			$row = $this->auto->get($autoId);
			if($row!=FALSE) {
				$templateId = $row->template_id;
				$row = $this->mail_template->get($templateId);
				if($row!=FALSE) {
					$templateContent = html_entity_decode($row->template_content, ENT_QUOTES);
					$templateSubject = $row->template_subject;
					$smtpHost = $row->smtp_host;
					$smtpUser = $row->smtp_user;
					$smtpPass = $row->smtp_pass;
					$smtpFrom = $row->smtp_from;
					$smtpFromName = $row->smtp_fromName;
					
					$config = array(
						'protocol'		=>	'smtp',
						'smtp_host'		=>	$smtpHost,
						'smtp_user'		=>	$smtpUser,
						'smtp_pass'		=>	$smtpPass,
						'mailtype'		=>	'html',
						'validate'		=>	TRUE
					);
					$this->load->library('email');
					$this->email->initialize($config);
					$this->load->helper('template');
					
					$templateContent = parseTemplate($templateContent, array(
						'name'		=>	$userName
					));
					$templateSubject = parseTemplate($templateSubject, array(
						'name'		=>	$userName
					));
					$this->email->clear();
					$this->email->from($smtpFrom, $smtpFromName);
					$this->email->to($userEmail);
					$this->email->subject($templateSubject);
					$this->email->message($templateContent);
					if(!$this->email->send()) {
						$this->logs->write(array(
							'log_type'	=>	'API_MAIL_SEND_ERROR'
						));
						echo 'API_MAIL_SEND_ERROR';
					}
					$this->logs->write(array(
						'log_type'	=>	'API_MAIL_SEND'
					));
					echo 'API_MAIL_SEND';
				} else {
					echo 'API_MAIL_SEND_ERROR';
				}
			} else {
				echo 'API_MAIL_SEND_ERROR';
			}
		}
	}
}
?>