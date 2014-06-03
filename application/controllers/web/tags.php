<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	//private $webId = null;
	private $permissionName = 'web_tags';
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
		$this->load->model('web/tag', 'tag');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$tagUpdate = 'update';
			$tagId = $this->input->get('tid', TRUE);
			$row = $this->tag->get($tagId);
			$tagName = $row->tag_name;
		}
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->tag->getTotal();
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
		$result = $this->tag->getAllResult($itemPerPage, $offset);
		
		$this->load->helper('pagination');
		$pagination = getPage($page, $pageTotal);
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'result'			=>	$result,
			'pagination'		=>	$pagination,
			'tag_update'		=>	$tagUpdate,
			'tag_id'			=>	$tagId,
			'tag_name'			=>	$tagName,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 标签管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'标签管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$tagsId = $this->input->get('tid', TRUE);
		switch($action) {
			case 'delete':
				$this->tag->delete($tagsId);
				break;
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_TAG_DELETE'
		));
		redirect('/web/tags');
	}

	public function submit() {
		$tagUpdate	= $this->input->post('tagUpdate', TRUE);
		$tagId		= $this->input->post('tagId', TRUE);
		$tagName	= $this->input->post('tagName', TRUE);
		if($tagUpdate=='update') {
			$parameter = array(
				'tag_name'	=>	$tagName
			);
			if($this->tag->update($parameter, $tagId)) {
				
			}
		} else {
			$parameter = array(
				'tag_name'	=>	$tagName,
			);
			if($this->tag->insert($parameter)) {
				
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_TAG_SUBMIT'
		));
		redirect('/web/tags');
	}
}
?>