<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Slides extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $webId = null;
	private $permissionName = 'web_slides';
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
		$this->load->model('web/slide', 'slide');
		$this->slide->__init($this->webId);
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$slideUpdate = 'update';
			$slideId = $this->input->get('sid', TRUE);
			$row = $this->slide->get($slideId);
			$slidePathFront = $row->slide_pic_path_front;
			$slidePathBack = $row->slide_pic_path_back;
			$slideWidth = $row->slide_pic_width;
			$slideHeight = $row->slide_pic_height;
			$channelId = $row->slide_channel_id;
			$slideLink = $row->slide_link;
		}
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->slide->getTotal();
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
		$result = $this->slide->getAllResult($itemPerPage, $offset);
		$this->load->helper('pagination');
		$pagination = getPage($page, $pageTotal);
		
		$this->load->model('web/channel', 'channel');
		$this->channel->__init($this->webId);
		$channelResult = $this->channel->getAllResult();
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'result'			=>	$result,
			'pagination'		=>	$pagination,
			'channel_result'	=>	$channelResult,
			'slide_update'		=>	$slideUpdate,
			'slide_id'			=>	$slideId,
			'slide_width'		=>	$slideWidth,
			'slide_height'		=>	$slideHeight,
			'slide_channel_id'	=>	$channelId,
			'slide_link'		=>	$slideLink,
			'slide_pic_path_front'	=>	$slidePathFront,
			'slide_pic_path_back'	=>	$slidePathBack,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 幻灯管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'幻灯管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$slideId = $this->input->get('sid', TRUE);
		switch($action) {
			case 'delete':
				$this->slide->delete($slideId);
				break;
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_SLIDE_DELETE'
		));
		redirect('/web/slides');
	}
	
	public function submit() {
		$slideUpdate	= $this->input->post('slideUpdate', TRUE);
		$slideId		= $this->input->post('slideId', TRUE);
		$channelId		= $this->input->post('slideChannel', TRUE);
		$slideWidth		= $this->input->post('slideWidth', TRUE);
		$slideHeight	= $this->input->post('slideHeight', TRUE);
		$slideLink		= $this->input->post('slideLink', TRUE);
		$slidePicPathFront	= $this->input->post('slidePicPathFront', TRUE);
		$slidePicPathBack	= $this->input->post('slidePicPathBack', TRUE);
		if($slideUpdate=='update') {
			$parameter = array(
				'slide_pic_path_front'	=>	$slidePicPathFront,
				'slide_pic_path_back'	=>	$slidePicPathBack,
				'slide_pic_width'	=>	$slideWidth,
				'slide_pic_height'	=>	$slideHeight,
				'slide_channel_id'	=>	$channelId,
				'slide_link'		=>	$slideLink
			);
			if($this->slide->update($parameter, $slideId)) {
				
			}
		} else {
			$parameter = array(
				'slide_pic_path_front'	=>	$slidePicPathFront,
				'slide_pic_path_back'	=>	$slidePicPathBack,
				'slide_pic_width'	=>	$slideWidth,
				'slide_pic_height'	=>	$slideHeight,
				'slide_channel_id'	=>	$channelId,
				'slide_link'		=>	$slideLink
			);
			if($this->slide->insert($parameter)) {
				
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_SLIDE_SUBMIT'
		));
		redirect('/web/slides');
	}
}
?>