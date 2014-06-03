<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ads extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $webId = null;
	private $permissionName = 'web_ads';
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
		$this->load->model('web/ad', 'ad');
		$this->ad->__init($this->webId);
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$adUpdate = 'update';
			$adId = $this->input->get('aid', TRUE);
			$row = $this->ad->get($adId);
			$adPath = $row->ad_pic_path;
			$adWidth = $row->ad_pic_width;
			$adHeight = $row->ad_pic_height;
			$channelId = $row->ad_channel_id;
			$adLink = $row->ad_link;
		}
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->ad->getTotal();
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
		$result = $this->ad->getAllResult($itemPerPage, $offset);
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
			'ad_update'			=>	$adUpdate,
			'ad_id'				=>	$adId,
			'ad_width'			=>	$adWidth,
			'ad_height'			=>	$adHeight,
			'ad_channel_id'		=>	$channelId,
			'ad_link'			=>	$adLink,
			'ad_pic_path'		=>	$adPath,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 广告管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'广告管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$adId = $this->input->get('aid', TRUE);
		switch($action) {
			case 'delete':
				$this->ad->delete($adId);
				break;
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_ADS_DELETE'
		));
		redirect('/web/ads');
	}
	
	public function submit() {
		$adUpdate	= $this->input->post('adUpdate', TRUE);
		$adId		= $this->input->post('adId', TRUE);
		$channelId	= $this->input->post('adChannel', TRUE);
		$adWidth	= $this->input->post('adWidth', TRUE);
		$adHeight	= $this->input->post('adHeight', TRUE);
		$adLink		= $this->input->post('adLink', TRUE);
		$adPicPath	= $this->input->post('adPicPath', TRUE);
		if($adUpdate=='update') {
			$parameter = array(
				'ad_pic_path'	=>	$adPicPath,
				'ad_pic_width'	=>	$adWidth,
				'ad_pic_height'	=>	$adHeight,
				'ad_channel_id'	=>	$channelId,
				'ad_link'		=>	$adLink
			);
			if($this->ad->update($parameter, $adId)) {
				
			}
		} else {
			$parameter = array(
				'ad_pic_path'	=>	$adPicPath,
				'ad_pic_width'	=>	$adWidth,
				'ad_pic_height'	=>	$adHeight,
				'ad_channel_id'	=>	$channelId,
				'ad_link'		=>	$adLink
			);
			if($this->ad->insert($parameter)) {
				
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_ADS_SUBMIT'
		));
		redirect('/web/ads');
	}
}
?>