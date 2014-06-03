<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sends extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'web_send';
	private $root_path = null;
	public function __construct() {
		parent::__construct();
		$this->load->model('functions/check_user', 'check');
		$this->user = $this->check->validate();
		$this->check->permission($this->user, $this->permissionName);
		$this->check->ip();
		$record = $this->check->configuration($this->user);
		$this->_CONFIG = $record['record'];
		if(!$record['state']) {
			$redirectUrl = urlencode($this->config->item('root_path') . 'login');
			redirect("/message?info=SCC_CLOSED&redirect={$redirectUrl}");
		}
		$this->root_path = $this->config->item('root_path');
		$this->load->model('web/mail', 'mail');
	}
	
	public function index() {
		$action = $this->input->get('action', TRUE);
		if($action=='send') {
			$this->load->helper('email');
			$guid = $this->input->get('guid', TRUE);
			$row = $this->mail->get($guid);
			$accountMail = parseEmailAddress($row->account_mail);
		}
		$copyright = $this->load->view("std_copyright", '', true);
		$this->load->model('web/mail_template', 'mail_template');
		$templateResult = $this->mail_template->getAllResult();
		$smtpHost = '67.228.209.12';
		$smtpUser = 'contact@macxdvd.com';
		$smtpPass = 'cont333999';
		$smtpFrom = 'contact@macxdvd.com';
		$smtpFromName = 'contact@macxdvd.com';
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'mail_account'		=>	$accountMail,
			'template_result'	=>	$templateResult,
			'smtp_host'			=>	$smtpHost,
			'smtp_user'			=>	$smtpUser,
			'smtp_pass'			=>	$smtpPass,
			'smtp_from'			=>	$smtpFrom,
			'smtp_from_name'	=>	$smtpFromName,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 发送邮件',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'发送邮件',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function submit() {
		$mailtoAccount	=	$this->input->post('mailAccount', TRUE);
		$mailName		=	$this->input->post('mailName', TRUE);
		$mailSubject	=	$this->input->post('mailSubject', TRUE);
		$mailTemplate	=	$this->input->post('mailTemplate', TRUE);
		$mailContent	=	$this->input->post('mailContent');
		if(!empty($mailtoAccount) && !empty($mailSubject) && !empty($mailContent)) {
			$mailListOriginal = explode(',', $mailtoAccount);
			$mailList = array();
			foreach($mailListOriginal as $mailAccount) {
				$tempArray = explode('>', trim($mailAccount));
				if(count($tempArray) < 2) {
					$mailList[] = $tempArray[0];
				} else {
					$tempArray[0] = ltrim($tempArray[0], '<');
					$mailList[$tempArray[0]] = $tempArray[1];
				}
			}
			if($mailTemplate!='0') {
				$this->load->model('web/mail_template', 'mail_template');
				$row = $this->mail_template->get($mailTemplate);
				$smtpHost = $row->smtp_host;
				$smtpUser = $row->smtp_user;
				$smtpPass = $row->smtp_pass;
				$smtpFrom = $row->smtp_from;
				$smtpFromName = $row->smtp_fromName;
			} else {
				$smtpHost = $this->input->post('smtpHost');
				$smtpUser = $this->input->post('smtpUser');
				$smtpPass = $this->input->post('smtpPass');
				$smtpFrom = $this->input->post('smtpFrom');
				$smtpFromName = $this->input->post('smtpFromName');
			}
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
			
			foreach($mailList as $accountName => $accountMail) {
				$mailContent = parseTemplate($mailContent, array(
					'first_name'	=>	$accountName,
					'last_name'		=>	''
				));
				$this->email->clear();
				$this->email->from($smtpFrom, $smtpFromName);
				$this->email->to($accountMail);
				$this->email->subject($mailSubject);
				$this->email->message($mailContent);
				if(!$this->email->send()) {
					$this->logs->write(array(
						'log_type'	=>	'SCC_MAIL_SEND_ERROR'
					));
					continue;
					//exit("<script>alert(\"邮件发送出错\");history.back(-1);</script>");
				}
			}
			$this->logs->write(array(
				'log_type'	=>	'SCC_MAIL_SEND'
			));
			$redirectUrl = urlencode($this->config->item('root_path') . 'web/sends');
			redirect("/message?info=SCC_SEND_MAIL_SUCCESS&redirect={$redirectUrl}&redirect_auto=1&redirect_delay=7");
		} else {
			$redirectUrl = urlencode($this->config->item('root_path') . 'web/sends');
			redirect("/message?info=SCC_SEND_MAIL_NO_PARAM&redirect={$redirectUrl}&redirect_auto=1&redirect_delay=7");
		}
	}
}
?>