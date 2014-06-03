<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Channels extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $webId = null;
	private $permissionName = 'web_channels';
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
		$this->load->model('web/channel', 'channel');
		$this->channel->__init($this->webId);
	}
	
	public function index() {
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$updateUpdate = 'update';
			$channelId = $this->input->get('cid', TRUE);
			$row = $this->channel->get($channelId);
			$channelName = $row->channel_name;
		}
		$result = $this->channel->getAllResult();
		$tableContent = '';
		foreach($result as $row) {
			$tableContent .= "<tr>\n";
			$tableContent .= "	<td align=\"center\">{$row->channel_id}</td>\n";
			$tableContent .= "	<td>{$row->channel_name}</td>\n";
			$tableContent .= "	<td align=\"center\"><a href=\"?action=modify&cid={$row->channel_id}\">编辑</a> | <a href=\"channels/action?action=delete&cid={$row->channel_id}\">删除</a></td>\n";
			$tableContent .= "</tr>\n";
		}
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'table_content'		=>	$tableContent,
			'channel_update'	=>	$updateUpdate,
			'channel_id'		=>	$channelId,
			'channel_name'		=>	$channelName,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 频道管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'频道管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$channelId = $this->input->get('cid', TRUE);
		switch($action) {
			case 'delete':
				$this->channel->delete($channelId);
				break;
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_CHANNEL_DELETE'
		));
		redirect('/web/channels');
	}
	
	public function submit() {
		$channelUpdate	= $this->input->post('channelUpdate', TRUE);
		$channelId		= $this->input->post('channelId', TRUE);
		$channelName	= $this->input->post('channelName', TRUE);
		if($channelUpdate=='update') {
			$parameter = array(
				'channel_name'		=>	$channelName
			);
			if($this->channel->update($parameter, $channelId)) {
				
			}
		} else {
			$parameter = array(
				'channel_name'		=>	$channelName,
				'channel_web_id'	=>	$this->webId
			);
			if($this->channel->insert($parameter)) {
				
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_CHANNEL_SUBMIT'
		));
		redirect('/web/channels');
	}
}
?>