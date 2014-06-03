<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lists extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $webId = null;
	private $permissionName = 'web_list';
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
		$this->load->model('web/news', 'news');
		$this->news->__init($this->webId);
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->news->getTotalByWeb();
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
		$result = $this->news->getAllResult($itemPerPage, $offset);
		
		$this->load->helper('pagination');
		$pagination = getPage($page, $pageTotal);
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'result'			=>	$result,
			'pagination'		=>	$pagination,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 新闻管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'新闻管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$newsId = $this->input->get('nid', TRUE);
		switch($action) {
			case 'scroll':
				$this->news->scroll($newsId, true);
				$this->logs->write(array(
					'log_type'	=>	'SCC_NEWS_SCROLL'
				));
				break;
			case 'unscroll':
				$this->news->scroll($newsId, false);
				$this->logs->write(array(
					'log_type'	=>	'SCC_NEWS_UNSCROLL'
				));
				break;
			case 'delete':
				$this->news->delete($newsId);
				$this->logs->write(array(
					'log_type'	=>	'SCC_NEWS_DELETE'
				));
				break;
		}
		redirect('/web/lists');
	}
}
?>