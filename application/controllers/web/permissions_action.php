<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Permissions_action extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'web_permission_action';
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
		$this->load->model('web/permission', 'permission');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		$type = $this->input->get('type', TRUE);
		$permissionId = $this->input->get('pid', TRUE);
		$guid = $this->input->get('guid', TRUE);
		if($action=='modify') {
			$permissionUpdate = 'update';
			if($type=='user') {
				$readOnly = "readonly=\"readonly\"";
				$this->load->model('web/admin_user', 'admin_user');
				$row = $this->admin_user->getPermission($guid);
				$permissionName = $row->permission_name;
				$permissionId = $row->permission_id;
				if(empty($row->additional_permission)) {
					$permissionList = $row->permission_list;
				} else {
					$permissionList = $row->additional_permission;
				}
			} else {
				$row = $this->permission->get($permissionId);
				$permissionName = $row->permission_name;
				$permissionList = $row->permission_list;
			}
			$permission = $this->config->item('permission');
			$permissionArray = array();
			if($permissionId=='999') {
				foreach($permission as $value) {
					$permissionArray[$value] = true;
				}
			} else {
				foreach($permission as $value) {
					$permissionArray[$value] = false;
				}
				$permissionListArray = explode(',', $permissionList);
				foreach($permissionListArray as $value) {
					$permissionArray[$value] = true;
				}
			}
		}
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'permission_update'	=>	$permissionUpdate,
			'permission_type'	=>	$type,
			'guid'				=>	$guid,
			'permission_id'		=>	$permissionId,
			'permission_name'	=>	$permissionName,
			'read_only'			=>	$readOnly,
			'copyright'			=>	$copyright
		);
		foreach($permissionArray as $key=>$value) {
			if($value) {
				$data[$key] = "checked=\"checked\"";
			}
		}
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 编辑权限',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'编辑权限',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function submit() {
		$postData = $this->input->post();
		$permission = $this->config->item('permission');
		$permissionArray = array();
		foreach($permission as $value) {
			$permissionArray[$value] = false;
		}
		foreach ($postData as $key=>$value) {
			if(in_array($value, $permission)) {
				$permissionArray[$value] = true;
				$permissionList[] = $value;
			}
		}
		$permissionList = implode(',', $permissionList);
		$permissionId = $this->input->post('permissionId', TRUE);
		$permissionIdHidden = $this->input->post('permissionIdHidden', TRUE);
		$permissionName = $this->input->post('permissionName', TRUE);
		$permissionUpdate = $this->input->post('permissionUpdate', TRUE);
		$permissionType = $this->input->post('permissionType', TRUE);
		if($permissionType=='user') {
			$guid = $this->input->post('GUID', TRUE);
			$param = array(
				'additional_permission'	=>	$permissionList
			);
			$this->load->model('web/admin_user', 'admin_user');
			$this->admin_user->update($param, $guid);
		} else {
			if($permissionUpdate=='update') {
				$param = array(
					'permission_id'		=>	$permissionId,
					'permission_name'	=>	$permissionName,
					'permission_list'	=>	$permissionList
				);
				$this->permission->update($param, $permissionIdHidden);
			} else {
				$param = array(
					'permission_id'		=>	$permissionId,
					'permission_name'	=>	$permissionName,
					'permission_list'	=>	$permissionList
				);
				$this->permission->insert($param);
			}
		}
		if($permissionType=='user') {
			redirect('web/users');
		} else {
			redirect('web/permissions');
		}
	}
}
?>