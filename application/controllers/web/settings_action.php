<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings_action extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'web_settings_action';
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
		$this->load->model('web/setting', 'setting');
	}
	
	public function index() {
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$configUpdate = 'update';
			$configId = $this->input->get('cid', TRUE);
			$row = $this->setting->get($configId);
			$configName			= $row->config_name;
			$configCloseScc		= $row->config_close_scc;
			$configCloseReason	= $row->config_close_reason;
			$configSelected		= $row->config_selected;
			if($configCloseScc=='1') {
				$config_close_scc_checked = "checked=\"checked\"";
			} else {
				$config_close_scc_unchecked = "checked=\"checked\"";
			}
			if($configSelected=='1') {
				$config_selected_checked = "checked=\"checked\"";
			} else {
				$config_selected_unchecked = "checked=\"checked\"";
			}
		}
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'					=>	$this->user->user_name,
			'root_path'					=>	$this->root_path,
			'config_update'				=>	$configUpdate,
			'config_id'					=>	$configId,
			'config_selected_checked'	=>	$config_selected_checked,
			'config_selected_unchecked'	=>	$config_selected_unchecked,
			'config_close_scc_checked'	=>	$config_close_scc_checked,
			'config_close_scc_unchecked'=>	$config_close_scc_unchecked,
			'config_name'				=>	$configName,
			'config_close_reason'		=>	$configCloseReason,
			'copyright'					=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 新建配置',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'新建配置',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function submit() {
		$configUpdate = $this->input->post('configUpdate', TRUE);
		$configId = $this->input->post('configId', TRUE);
		$configSelected = $this->input->post('configSelected', TRUE);
		$configName = $this->input->post('configName', TRUE);
		$configCloseScc = $this->input->post('configCloseScc', TRUE);
		$configCloseReason = $this->input->post('configCloseReason', TRUE);
		if($configSelected=='1') {
			$this->setting->disabled();
		}
		if(!empty($configUpdate) && $configUpdate=='update') {
			$parameter = array(
				'config_name'			=>	$configName,
				'config_close_scc'		=>	$configCloseScc,
				'config_close_reason'	=>	$configCloseReason,
				'config_selected'		=>	$configSelected
			);
			$this->setting->update($parameter, $configId);
		} else {
			$parameter = array(
				'config_name'			=>	$configName,
				'config_close_scc'		=>	$configCloseScc,
				'config_close_reason'	=>	$configCloseReason,
				'config_selected'		=>	$configSelected
			);
			$this->setting->insert($parameter);
		}
		redirect('/web/settings');
	}
}
?>