<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notices extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'web_notices';
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
		$this->load->model('web/notice', 'notice');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$noticeUpdate = 'update';
			$noticeId = $this->input->get('nid', TRUE);
			$row = $this->notice->get($noticeId);
			$noticeContent = $row->notice_content;
			$noticeEndTime = date('Y-m-d', $row->notice_endtime);
			$noticeEndTimeHour = date('H', $row->notice_endtime);
			$noticeEndTimeMinute = date('i', $row->notice_endtime);
			$noticeEndTimeSecond = date('s', $row->notice_endtime);
			$noticePostTime = $row->notice_posttime;
			$noticeVisible = $row->notice_visible;
			$noticeSender = $row->notice_sender_id;
			$noticeReciever = $row->notice_reciever_id;
		} else {
			$noticeSender = $this->user->GUID;
		}
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->notice->getTotal();
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
		$result = $this->notice->getAllResult($itemPerPage, $offset);
		$this->load->helper('pagination');
		$pagination = getPage($page, $pageTotal);
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'				=>	$this->user->user_name,
			'root_path'				=>	$this->root_path,
			'result'				=>	$result,
			'pagination'			=>	$pagination,
			'notice_update'			=>	$noticeUpdate,
			'notice_id'				=>	$noticeId,
			'notice_content'		=>	$noticeContent,
			'notice_endtime'		=>	$noticeEndTime,
			'notice_endtime_hour'	=>	$noticeEndTimeHour,
			'notice_endtime_minute'	=>	$noticeEndTimeMinute,
			'notice_endtime_second'	=>	$noticeEndTimeSecond,
			'notice_sender_id'		=>	$noticeSender,
			'notice_reciever_id'	=>	$noticeReciever,
			'copyright'				=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 短消息管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'短消息管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$noticeId = $this->input->get('nid', TRUE);
		switch($action) {
			case 'delete':
				$this->notice->delete($noticeId);
				break;
			case 'show':
				$this->notice->visible($noticeId, true);
				break;
			case 'hide':
				$this->notice->visible($noticeId, false);
				break;
		}
		redirect('/web/notices');
	}
	
	public function submit() {
		$noticeUpdate		= $this->input->post('noticeUpdate', TRUE);
		$noticeId			= $this->input->post('noticeId', TRUE);
		$noticeContent		= $this->input->post('noticeContent', TRUE);
		$noticeEndTime		= $this->input->post('notice_endtime', TRUE);
		$noticeEndTimeHour	= $this->input->post('notice_endtime_hour', TRUE);
		$noticeEndTimeMinute= $this->input->post('notice_endtime_minute', TRUE);
		$noticeEndTimeSecond= $this->input->post('notice_endtime_second', TRUE);
		$noticeEndTime 		= strtotime("{$noticeEndTime} {$noticeEndTimeHour}:{$noticeEndTimeMinute}:{$noticeEndTimeSecond}");
		$noticePostTime		= time();
		$noticeSender		= $this->input->post('noticeSender', TRUE);
		$noticeReciever		= $this->input->post('noticeReciever', TRUE);
		if($noticeUpdate=='update') {
			$parameter = array(
				'notice_content'	=>	$noticeContent,
				'notice_endtime'	=>	$noticeEndTime,
				'notice_sender_id'	=>	$noticeSender,
				'notice_reciever_id'=>	$noticeReciever
			);
			if($this->notice->update($parameter, $noticeId)) {
				
			}
		} else {
			$parameter = array(
				'notice_content'	=>	$noticeContent,
				'notice_endtime'	=>	$noticeEndTime,
				'notice_posttime'	=>	$noticePostTime,
				'notice_sender_id'	=>	$noticeSender,
				'notice_reciever_id'=>	$noticeReciever
			);
			if($this->notice->insert($parameter)) {
				
			}
		}
		redirect('/web/notices');
	}
}
?>