<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $webId = null;
	private $permissionName = 'web_categories';
	private $root_path = null;
	public function __construct() {
		parent::__construct();
		$this->load->model('functions/check_user', 'check');
		$this->user = $this->check->validate();
		$this->check->permission($this->user, $this->permissionName);
		$this->check->ip();
		$this->webId = $this->check->checkDefaultWeb();
		$record = $this->check->configuration($this->user);
		$this->_CONFIG = $record['record'];
		if(!$record['state']) {
			$redirectUrl = urlencode($this->config->item('root_path') . 'login');
			redirect("/message?info=SCC_CLOSED&redirect={$redirectUrl}");
		}
		$this->root_path = $this->config->item('root_path');
		$this->load->model('web/category', 'category');
		$this->category->__init($this->webId);
	}
	
	public function index() {
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$categoryUpdate = 'update';
			$categoryId = $this->input->get('cid', TRUE);
			$row = $this->category->get($categoryId);
			$categoryName = $row->category_name;
			$channelId = $row->channel_id;
		}
		$result = $this->category->getAllResult();
		$tableContent = '';
		foreach($result as $row) {
			$tableContent .= "<tr>\n";
			$tableContent .= "	<td align=\"center\">{$row->category_id}</td>\n";
			$tableContent .= "	<td>{$row->category_name}</td>\n";
			$tableContent .= "	<td>{$row->channel_name}</td>\n";
			$tableContent .= "	<td align=\"center\"><a href=\"?action=modify&cid={$row->category_id}\">编辑</a> | <a href=\"categories/action?action=delete&cid={$row->category_id}\">删除</a></td>\n";
			$tableContent .= "</tr>\n";
		}
		$this->load->model('web/channel', 'channel');
		$this->channel->__init($this->webId);
		$result = $this->channel->getAllResult();
		$channelListOption = '';
		foreach($result as $row) {
			if($channelId==$row->channel_id) {
				$channelListOption .= "<option value=\"{$row->channel_id}\" selected=\"selected\">{$row->channel_name}</option>\n";
			} else {
				$channelListOption .= "<option value=\"{$row->channel_id}\">{$row->channel_name}</option>\n";
			}
		}
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'				=>	$this->user->user_name,
			'root_path'				=>	$this->root_path,
			'table_content'			=>	$tableContent,
			'category_update'		=>	$categoryUpdate,
			'category_id'			=>	$categoryId,
			'channel_list_option'	=>	$channelListOption,
			'category_name'			=>	$categoryName,
			'copyright'				=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 分类管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'分类管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$channelId = $this->input->get('cid', TRUE);
		switch($action) {
			case 'delete':
				$this->category->delete($channelId);
				break;
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_CATEGORY_DELETE'
		));
		redirect('/web/categories');
	}
	
	public function submit() {
		$categoryUpdate	= $this->input->post('categoryUpdate', TRUE);
		$categoryId		= $this->input->post('categoryId', TRUE);
		$channelId		= $this->input->post('channelId', TRUE);
		$categoryName	= $this->input->post('categoryName', TRUE);
		if($categoryUpdate=='update') {
			$parameter = array(
				'category_name'			=>	$categoryName,
				'category_channel_id'	=>	$channelId
			);
			if($this->category->update($parameter, $categoryId)) {
				
			}
		} else {
			$parameter = array(
				'category_name'			=>	$categoryName,
				'category_channel_id'	=>	$channelId
			);
			if($this->category->insert($parameter)) {
				
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_CATEGORY_SUBMIT'
		));
		redirect('/web/categories');
	}
}
?>