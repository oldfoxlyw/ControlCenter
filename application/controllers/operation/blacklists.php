<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blacklists extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'operation_blacklist';
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
		$this->load->model('operation/blacklist', 'blacklist');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$listUpdate = 'update';
			$listId = $this->input->get('lid', TRUE);
			$row = $this->blacklist->get($listId);
			$licenseContent = $row->license_content;
			$machineCode = $row->client_cpu_info;
			$redirectUrl = $row->redirect_url;
			$listActived = $row->list_actived;
		}
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->blacklist->getTotal();
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
		$result = $this->blacklist->getAllResult();
		$this->load->helper('pagination');
		$pagination = getPage($page, $pageTotal);
		$copyright = $this->load->view("std_copyright", '', true);
		
		$data = array(
			'userName'				=>	$this->user->user_name,
			'root_path'				=>	$this->root_path,
			'result'				=>	$result,
			'pagination'			=>	$pagination,
			'list_update'			=>	$listUpdate,
			'list_id'				=>	$listId,
			'license_content'		=>	$licenseContent,
			'client_cpu_info'		=>	$machineCode,
			'redirect_url'			=>	$redirectUrl,
			'copyright'				=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 黑名单管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'黑名单管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$listId = $this->input->get('lid', TRUE);
		switch($action) {
			case 'delete':
				$this->blacklist->delete($listId);
				$this->logs->write(array(
					'log_type'	=>	'SCC_BLACKLIST_DELETE'
				));
				break;
			case 'active':
				$this->blacklist->active($listId, TRUE);
				$this->logs->write(array(
					'log_type'	=>	'SCC_BLACKLIST_ACTIVE'
				));
				break;
			case 'deactive':
				$this->blacklist->active($listId, FALSE);
				$this->logs->write(array(
					'log_type'	=>	'SCC_BLACKLIST_DEACTIVE'
				));
				break;
		}
		redirect('/operation/blacklists');
	}
	
	public function submit() {
		$listUpdate		= $this->input->post('listUpdate', TRUE);
		$listId			= $this->input->post('listId', TRUE);
		$licenseContent	= $this->input->post('licenseContent', TRUE);
		$machineCode	= $this->input->post('machineCode', TRUE);
		$redirectUrl	= $this->input->post('redirectUrl', TRUE);
		if($listUpdate=='update') {
			$parameter = array(
				'license_content'	=>	$licenseContent,
				'client_cpu_info'	=>	$machineCode,
				'redirect_url'		=>	$redirectUrl
			);
			if($this->blacklist->update($parameter, $listId)) {
				
			}
		} else {
			$parameter = array(
				'license_content'	=>	$licenseContent,
				'client_cpu_info'	=>	$machineCode,
				'redirect_url'		=>	$redirectUrl
			);
			if($this->blacklist->insert($parameter)) {
				
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_BLACKLIST_SUBMIT'
		));
		redirect('/operation/blacklists');
	}
}
?>