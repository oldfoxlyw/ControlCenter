<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Redirects extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'web_redirects';
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
		$this->load->model('web/redirect', 'redirect');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$redirectUpdate = 'update';
			$redirectId = $this->input->get('rid', TRUE);
			$row = $this->redirect->get($redirectId);
			$redirectPid		=		$row->redirect_pid;
			$redirectName		=		$row->redirect_pname;
			$redirectInner		=		$row->redirect_down_inner;
			$redirectOuter		=		$row->redirect_down_outer;
			$redirectPaypal		=		$row->redirect_paypal;
			$redirectAvangate	=		$row->redirect_avangate;
			$redirectRegnow		=		$row->redirect_regnow;
		}
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->redirect->getTotal();
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
		$result = $this->redirect->getAllResult($itemPerPage, $offset);
		$this->load->helper('pagination');
		$pagination = getPage($page, $pageTotal);
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'				=>	$this->user->user_name,
			'root_path'				=>	$this->root_path,
			'result'				=>	$result,
			'pagination'			=>	$pagination,
			'redirect_update'		=>	$redirectUpdate,
			'redirect_id'			=>	$redirectId,
			'redirect_pid'			=>	$redirectPid,
			'redirect_pname'		=>	$redirectName,
			'redirect_down_inner'	=>	$redirectInner,
			'redirect_down_outer'	=>	$redirectOuter,
			'redirect_paypal'		=>	$redirectPaypal,
			'redirect_avangate'		=>	$redirectAvangate,
			'redirect_regnow'		=>	$redirectRegnow,
			'copyright'				=>	$copyright
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
		$redirectId = $this->input->get('rid', TRUE);
		switch($action) {
			case 'delete':
				$this->redirect->delete($redirectId);
				break;
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_REDIRECT_DELETE'
		));
		redirect('/web/redirects');
	}
	
	public function submit() {
		$redirectUpdate		= $this->input->post('redirectUpdate', TRUE);
		$redirectId			= $this->input->post('redirectId', TRUE);
		$redirectPid		= $this->input->post('redirectPid', TRUE);
		$redirectName		= $this->input->post('redirectName', TRUE);
		$redirectInner		= $this->input->post('redirectInner', TRUE);
		$redirectOuter		= $this->input->post('redirectOuter', TRUE);
		$redirectPaypal		= $this->input->post('redirectPaypal', TRUE);
		$redirectAvangate	= $this->input->post('redirectAvangate', TRUE);
		$redirectRegnow		= $this->input->post('redirectRegnow', TRUE);
		if($redirectUpdate=='update') {
			$parameter = array(
				'redirect_pid'			=>	$redirectPid,
				'redirect_pname'		=>	$redirectName,
				'redirect_down_inner'	=>	$redirectInner,
				'redirect_down_outer'	=>	$redirectOuter,
				'redirect_paypal'		=>	$redirectPaypal,
				'redirect_avangate'		=>	$redirectAvangate,
				'redirect_regnow'		=>	$redirectRegnow
			);
			if($this->redirect->update($parameter, $redirectId)) {
				
			}
		} else {
			$parameter = array(
				'redirect_pid'			=>	$redirectPid,
				'redirect_pname'		=>	$redirectName,
				'redirect_down_inner'	=>	$redirectInner,
				'redirect_down_outer'	=>	$redirectOuter,
				'redirect_paypal'		=>	$redirectPaypal,
				'redirect_avangate'		=>	$redirectAvangate,
				'redirect_regnow'		=>	$redirectRegnow
			);
			if($this->redirect->insert($parameter)) {
				
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_REDIRECT_SUBMIT'
		));
		redirect('/web/redirects');
	}
}
?>