<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Autos extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'web_auto';
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
		$this->load->model('web/auto', 'auto');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$autoUpdate = 'update';
			$autoId = $this->input->get('aid', TRUE);
			$row = $this->auto->get($autoId);
			$autoName = $row->auto_name;
			$templateId = $row->template_id;
		}
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->auto->getTotal();
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
		$result = $this->auto->getAllResult($itemPerPage, $offset);
		$this->load->helper('pagination');
		$pagination = getPage($page, $pageTotal);
		$copyright = $this->load->view("std_copyright", '', true);
		
		$this->load->model('web/mail_template', 'mail_template');
		$templateResult = $this->mail_template->getAllResult();
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'result'			=>	$result,
			'pagination'		=>	$pagination,
			'auto_update'		=>	$autoUpdate,
			'auto_id'			=>	$autoId,
			'auto_name'			=>	$autoName,
			'template_result'	=>	$templateResult,
			'template_id'		=>	$templateId,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 自动发送邮件管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'自动发送邮件管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$autoId = $this->input->get('aid', TRUE);
		switch($action) {
			case 'delete':
				$this->auto->delete($autoId);
				break;
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_AUTO_DELETE'
		));
		redirect('/web/autos');
	}
	
	public function submit() {
		$autoUpdate	= $this->input->post('autoUpdate', TRUE);
		$autoId		= $this->input->post('autoId', TRUE);
		$templateId	= $this->input->post('templateId', TRUE);
		$autoName	= $this->input->post('autoName', TRUE);
		if($autoUpdate=='update') {
			$parameter = array(
				'auto_name'			=>	$autoName,
				'auto_template_id'	=>	$templateId
			);
			if($this->auto->update($parameter, $autoId)) {
				
			}
		} else {
			$parameter = array(
				'auto_name'			=>	$autoName,
				'auto_template_id'	=>	$templateId
			);
			if($this->auto->insert($parameter)) {
				
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_AUTO_SUBMIT'
		));
		redirect('/web/autos');
	}
}
?>