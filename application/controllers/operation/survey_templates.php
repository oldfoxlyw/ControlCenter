<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Survey_templates extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'operation_survey_template';
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
		$this->load->model('operation/survey_template', 'survey_template');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$templateUpdate = 'update';
			$templateId = $this->input->get('tid', TRUE);
			$row = $this->survey_template->get($templateId);
			$templateName = $row->template_name;
			$templateContent = $row->template_content;
		}
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->survey_template->getTotal();
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
		$result = $this->survey_template->getAllResult(null, $itemPerPage, $offset);
		$this->load->helper('pagination');
		$pagination = getPage($page, $pageTotal);
		$copyright = $this->load->view("std_copyright", '', true);
		
		$data = array(
			'userName'				=>	$this->user->user_name,
			'root_path'				=>	$this->root_path,
			'result'				=>	$result,
			'pagination'			=>	$pagination,
			'template_update'		=>	$templateUpdate,
			'template_id'			=>	$templateId,
			'template_name'			=>	$templateName,
			'template_content'		=>	$templateContent,
			'copyright'				=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 调查问卷模版管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'调查问卷模版管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$templateId = $this->input->get('tid', TRUE);
		switch($action) {
			case 'delete':
				$this->survey_template->delete($templateId);
				$this->logs->write(array(
					'log_type'	=>	'SCC_SURVEY_TEMPLATE_DELETE'
				));
				redirect('/operation/survey_templates');
				break;
			case 'preview':
				$row = $this->survey_template->get($templateId);
				echo $row->template_content;
				break;
		}
	}
	
	public function submit() {
		$templateUpdate		= $this->input->post('templateUpdate', TRUE);
		$templateId			= $this->input->post('templateId', TRUE);
		$templateName		= $this->input->post('templateName', TRUE);
		$templateContent	= $this->input->post('templateContent');
		if($templateUpdate=='update') {
			$parameter = array(
				'template_name'		=>	$templateName,
				'template_content'	=>	$templateContent
			);
			if($this->survey_template->update($parameter, $templateId)) {
				
			}
		} else {
			$parameter = array(
				'template_name'		=>	$templateName,
				'template_content'	=>	$templateContent
			);
			if($this->survey_template->insert($parameter)) {
				
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_SURVEY_TEMPLATE_SUBMIT'
		));
		redirect('/operation/survey_templates');
	}
}
?>