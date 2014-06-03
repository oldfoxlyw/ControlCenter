<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Links extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'web_links';
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
		$this->load->model('web/link', 'link');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$linkUpdate = 'update';
			$linkId = $this->input->get('lid', TRUE);
			$row = $this->link->get($linkId);
			$linkContent = $row->link_content;
		}
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->link->getTotal();
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
		$result = $this->link->getAllResult($itemPerPage, $offset);
		$this->load->helper('pagination');
		$pagination = getPage($page, $pageTotal);
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'result'			=>	$result,
			'pagination'		=>	$pagination,
			'link_update'		=>	$linkUpdate,
			'link_id'			=>	$linkId,
			'link_content'		=>	$linkContent,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 产品链接管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'产品链接管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$linkId = $this->input->get('lid', TRUE);
		switch($action) {
			case 'delete':
				$this->link->delete($linkId);
				break;
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_LINK_DELETE'
		));
		redirect('/web/links');
	}
	
	public function submit() {
		$linkUpdate		= $this->input->post('linkUpdate', TRUE);
		$linkId			= $this->input->post('linkId', TRUE);
		$linkContent	= $this->input->post('linkContent', TRUE);
		if($linkUpdate=='update') {
			$parameter = array(
				'link_content'	=>	$linkContent,
			);
			if($this->link->update($parameter, $linkId)) {
				
			}
		} else {
			$parameter = array(
				'link_content'	=>	$linkContent,
			);
			if($this->link->insert($parameter)) {
				
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_LINK_SUBMIT'
		));
		redirect('/web/links');
	}
}
?>