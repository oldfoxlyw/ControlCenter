<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'web_users';
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
		$this->load->model('web/admin_user', 'admin_user');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$userUpdate = 'update';
			$guid = $this->input->get('guid', TRUE);
			$row = $this->admin_user->get($guid);
			$userName = $row->user_name;
			$userPermission = $row->user_permission;
			$userFreezed = $row->user_freezed;
		}
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->admin_user->getTotal();
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
		$result = $this->admin_user->getAllResult($itemPerPage, $offset);
		$this->load->helper('pagination');
		$pagination = getPage($page, $pageTotal);
		
		$userPermissionOption = '';
		$this->load->model('web/permission', 'permission');
		$query = $this->permission->getAllResult();
		foreach($query as $row) {
			if($userPermission==$row->permission_id) {
				$userPermissionOption .= "<option value=\"{$row->permission_id}\" selected=\"selected\">{$row->permission_name}({$row->permission_id})</option>";
			} else {
				$userPermissionOption .= "<option value=\"{$row->permission_id}\">{$row->permission_name}({$row->permission_id})</option>";
			}
		}
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'result'			=>	$result,
			'pagination'		=>	$pagination,
			'user_update'		=>	$userUpdate,
			'guid'				=>	$guid,
			'user_name'			=>	$userName,
			'user_permission'	=>	$userPermissionOption,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 管理员管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'管理员管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$guid = $this->input->get('guid', TRUE);
		switch($action) {
			case 'freezed':
				$this->admin_user->freeze($guid, true);
				$this->logs->write(array(
					'log_type'	=>	'SCC_USER_FREEZED'
				));
				break;
			case 'unfreezed':
				$this->admin_user->freeze($guid, false);
				$this->logs->write(array(
					'log_type'	=>	'SCC_USER_UNFREEZED'
				));
				break;
			case 'delete':
				$this->admin_user->delete($guid);
				$this->logs->write(array(
					'log_type'	=>	'SCC_USER_DELETE'
				));
				break;
		}
		redirect('/web/users');
	}
	
	public function submit() {
		$userUpdate		= $this->input->post('userUpdate', TRUE);
		$guid			= $this->input->post('GUID', TRUE);
		$userName		= $this->input->post('userName', TRUE);
		$userPass		= $this->input->post('userPass', TRUE);
		$userPermission	= $this->input->post('userPermission', TRUE);
		$this->load->helper('security');
		if(!empty($userPass)) $userPass = strtoupper(do_hash($userPass, 'md5'));
		if($userUpdate=='update') {
			if(!empty($userPass)) {
				$parameter = array(
					'user_name'			=>	$userName,
					'user_pass'			=>	$userPass,
					'user_permission'	=>	$userPermission
				);
			} else {
				$parameter = array(
					'user_name'			=>	$userName,
					'user_permission'	=>	$userPermission
				);
			}
			if($this->admin_user->update($parameter, $guid)) {
				
			}
		} else {
			$this->load->library('Guid');
			$guid = $this->guid->toString();
			$parameter = array(
				'GUID'				=>	$guid,
				'user_name'			=>	$userName,
				'user_pass'			=>	$userPass,
				'user_permission'	=>	$userPermission
			);
			if($this->admin_user->insert($parameter)) {
				
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_USER_SUBMIT'
		));
		redirect('/web/users');
	}
}
?>