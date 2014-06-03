<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Webs extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	//private $webId = null;
	private $permissionName = 'web_webs';
	private $root_path = null;
	public function __construct() {
		parent::__construct();
		$this->load->model('functions/check_user', 'check');
		$this->user = $this->check->validate();
		$this->check->permission($this->user, $this->permissionName);
		$this->check->ip();
		//$this->webId = $this->check->checkDefaultWeb();
		$record = $this->check->configuration($this->user);
		$this->_CONFIG = $record['record'];
		if(!$record['state']) {
			$redirectUrl = urlencode($this->config->item('root_path') . 'login');
			redirect("/message?info=SCC_CLOSED&redirect={$redirectUrl}");
		}
		$this->root_path = $this->config->item('root_path');
		$this->load->model('web/web', 'web');
	}
	
	public function index() {
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$webUpdate = 'update';
			$webId = $this->input->get('wid', TRUE);
			$row = $this->web->get($webId);
			$webName = $row->web_name;
		}
		$result = $this->web->getAllResult();
		$tableContent = '';
		foreach($result as $row) {
			$tableContent .= "<tr>\n";
			$tableContent .= "	<td align=\"center\">{$row->web_id}</td>\n";
			$tableContent .= "	<td>{$row->web_name}</td>\n";
			$tableContent .= "	<td align=\"center\"><a href=\"webs/action?action=set&wid={$row->web_id}\">设为当前操作网站</a> | <a href=\"?action=modify&wid={$row->web_id}\">编辑</a> | <a href=\"webs/action?action=delete&wid={$row->web_id}\">删除</a></td>\n";
			$tableContent .= "</tr>\n";
		}
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'table_content'		=>	$tableContent,
			'web_update'		=>	$webUpdate,
			'web_id'			=>	$webId,
			'web_name'			=>	$webName,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 网站管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'网站管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$webId = $this->input->get('wid', TRUE);
		switch($action) {
			case 'set':
				$this->web->set($webId);
				$this->logs->write(array(
					'log_type'	=>	'SCC_WEB_SET'
				));
				break;
			case 'delete':
				$this->web->delete($webId);
				$this->logs->write(array(
					'log_type'	=>	'SCC_WEB_DELETE'
				));
				break;
		}
		redirect('/web/webs');
	}
	
	public function submit() {
		$webUpdate	= $this->input->post('webUpdate', TRUE);
		$webId		= $this->input->post('webId', TRUE);
		$webName	= $this->input->post('webName', TRUE);
		$webUrl		= $this->input->post('webUrl', TRUE);
		if($webUpdate=='update') {
			$parameter = array(
				'web_name'		=>	$webName
			);
			if($this->web->update($parameter, $webId)) {
				
			}
		} else {
			$this->load->library('guid');
			$guid = $this->guid->toString();
			$parameter = array(
				'web_name'		=>	$webName,
				'web_secretkey'	=>	$guid
			);
			if($this->web->insert($parameter)) {
				
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_WEB_SUBMIT'
		));
		redirect('/web/webs');
	}
}
?>