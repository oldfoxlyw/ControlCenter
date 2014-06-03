<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mail_templates extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'web_mail_templates';
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
		$this->load->model('web/mail_template', 'mail_template');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$templateUpdate = 'update';
			$templateId = $this->input->get('tid', TRUE);
			$row = $this->mail_template->get($templateId);
			$templateName = $row->template_name;
			$templateContent = html_entity_decode($row->template_content, ENT_QUOTES);
			$templateSubject = $row->template_subject;
			$templateReader = $row->template_reader;
			$smtpHost = $row->smtp_host;
			$smtpUser = $row->smtp_user;
			$smtpPass = $row->smtp_pass;
			$smtpFrom = $row->smtp_from;
			$smtpFromName = $row->smtp_fromName;
		}
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->mail_template->getTotal();
		$itemPerPage = $this->config->item('pagination_per_page');
		$pageTotal = intval($rowTotal/$itemPerPage);
		if($rowTotal%$itemPerPage) $pageTotal++;
		if($pageTotal > 0) {
			if(empty($page) || !is_numeric($page) || intval($page) < 1) {
				$page = 1;
			} elseif($page > $pageTotal) {
				$page = $pageTotal;
			} else {
				$page = intval($page);
			}
			$offset = $itemPerPage * ($page - 1);
		} else {
			$offset = 0;
		}
		$result = $this->mail_template->getAllResult($itemPerPage, $offset);
		$this->load->helper('pagination');
		$pagination = getPage($page, $pageTotal);
		$copyright = $this->load->view("std_copyright", '', true);
		
		if(empty($smtpHost)) $smtpHost = '67.228.209.12';
		if(empty($smtpUser)) $smtpUser = 'contact@macxdvd.com';
		if(empty($smtpPass)) $smtpPass = 'cont333999';
		if(empty($smtpFrom)) $smtpFrom = 'contact@macxdvd.com';
		if(empty($smtpFromName)) $smtpFromName = 'contact@macxdvd.com';
		$data = array(
			'userName'				=>	$this->user->user_name,
			'root_path'				=>	$this->root_path,
			'result'				=>	$result,
			'pagination'			=>	$pagination,
			'template_update'		=>	$templateUpdate,
			'template_id'			=>	$templateId,
			'template_name'			=>	$templateName,
			'template_content'		=>	$templateContent,
			'template_subject'		=>	$templateSubject,
			'template_reader'		=>	$templateReader,
			'smtp_host'				=>	$smtpHost,
			'smtp_user'				=>	$smtpUser,
			'smtp_pass'				=>	$smtpPass,
			'smtp_from'				=>	$smtpFrom,
			'smtp_from_name'		=>	$smtpFromName,
			'copyright'				=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 邮件模版管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'邮件模版管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$templateId = $this->input->get('tid', TRUE);
		switch($action) {
			case 'delete':
				$this->mail_template->delete($templateId);
				redirect('/web/mail_templates');
				break;
			case 'preview':
				$row = $this->mail_template->get($templateId);
				echo html_entity_decode($row->template_content, ENT_QUOTES);
				break;
		}
	}
	
	public function submit() {
		$templateUpdate		= $this->input->post('templateUpdate', TRUE);
		$templateId			= $this->input->post('templateId', TRUE);
		$templateName		= $this->input->post('templateName', TRUE);
		$templateContent	= $this->input->post('templateContent');
		$templateSubject	= $this->input->post('templateSubject', TRUE);
		$templateReader		= $this->input->post('templateReader', TRUE);
		$smtpHost			= $this->input->post('smtpHost', TRUE);
		$smtpUser			= $this->input->post('smtpUser', TRUE);
		$smtpPass			= $this->input->post('smtpPass', TRUE);
		$smtpFrom			= $this->input->post('smtpFrom', TRUE);
		$smtpFromName		= $this->input->post('smtpFromName', TRUE);
		if($templateUpdate=='update') {
			$parameter = array(
				'template_name'		=>	$templateName,
				'template_content'	=>	$templateContent,
				'template_subject'	=>	$templateSubject,
				'template_reader'	=>	$templateReader,
				'smtp_host'			=>	$smtpHost,
				'smtp_user'			=>	$smtpUser,
				'smtp_pass'			=>	$smtpPass,
				'smtp_from'			=>	$smtpFrom,
				'smtp_fromName'		=>	$smtpFromName
			);
			if($this->mail_template->update($parameter, $templateId)) {
				
			}
		} else {
			$parameter = array(
				'template_name'		=>	$templateName,
				'template_content'	=>	$templateContent,
				'template_subject'	=>	$templateSubject,
				'template_reader'	=>	$templateReader,
				'smtp_host'			=>	$smtpHost,
				'smtp_user'			=>	$smtpUser,
				'smtp_pass'			=>	$smtpPass,
				'smtp_from'			=>	$smtpFrom,
				'smtp_fromName'		=>	$smtpFromName
			);
			if($this->mail_template->insert($parameter)) {
				
			}
		}
		redirect('/web/mail_templates');
	}
}
?>