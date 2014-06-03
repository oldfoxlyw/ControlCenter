<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Licenses extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'operation_license';
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
		$this->load->model('license', 'license');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$licenseUpdate = 'update';
			$licenseId = $this->input->get('lid', TRUE);
			$row = $this->license->get($licenseId);
			$licenseContent = $row->license_content;
			$licenseType = $row->license_type;
			$licenseLimit = $row->license_limit;
			$licenseTimeLimit = $row->license_timelimit;
			$licenseGeneratedTime = $row->license_generated_time;
			$licenseLastTime = $row->license_last_time;
			$productId = $row->product_id;
			$productVersion = $row->product_version;
			$controlCommand = $row->license_control_command;
		}
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->license->getLicenseTotal();
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
		$result = $this->license->getLicenseResult(null, $itemPerPage, $offset);
		$this->load->helper('pagination');
		$pagination = getPage($page, $pageTotal);
		$copyright = $this->load->view("std_copyright", '', true);
		
		$this->config->load('cache', FALSE, TRUE);
		if($this->config->item('is_cache')) {
			$this->load->model('cache', 'cache');
			$productResult = $this->cache->getCacheResult('product_list');
		} else {
			$this->load->model('product', 'product');
			$productResult = $this->product->getAllResult(array(
				'group_by'	=>	'product_id'
			));
		}
		
		$data = array(
			'userName'				=>	$this->user->user_name,
			'root_path'				=>	$this->root_path,
			'result'				=>	$result,
			'product_result'		=>	$productResult,
			'license_id'			=>	$licenseId,
			'license_update'		=>	$licenseUpdate,
			'license_content'		=>	$licenseContent,
			'license_type'			=>	$licenseType,
			'license_limit'			=>	$licenseLimit,
			'license_time_limit'	=>	$licenseTimeLimit,
			'license_generated_time'=>	$licenseGeneratedTime,
			'license_last_time'		=>	$licenseLastTime,
			'product_id'			=>	$productId,
			'product_version'		=>	$productVersion,
			'control_command'		=>	$controlCommand,
			'pagination'			=>	$pagination,
			'copyright'				=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 激活码管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'激活码管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$licenseId = $this->input->get('lid', TRUE);
		switch($action) {
			case 'delete':
				$this->license->delete($licenseId);
				$this->logs->write(array(
					'log_type'	=>	'SCC_LICENSE_DELETE'
				));
				break;
		}
		redirect('/operation/licenses');
	}
	
	public function submit() {
		$licenseId				=	$this->input->post('licenseId', TRUE);
		$licenseUpdate			=	$this->input->post('licenseUpdate', TRUE);
		$licenseContent			=	$this->input->post('licenseContent', TRUE);
		$licenseType			=	$this->input->post('licenseType', TRUE);
		$licenseLimit			=	$this->input->post('licenseLimit', TRUE);
		$licenseTimeLimit		=	$this->input->post('licenseTimeLimit', TRUE);
		$licenseLastTime		=	$this->input->post('licenseLastTime', TRUE);
		$productId				=	$this->input->post('productId_forVer', TRUE);
		$productVersion			=	$this->input->post('productVersion', TRUE);
		
		$controlForbidden		=	$this->input->post('controlForbidden', TRUE);
		$controlPopup			=	$this->input->post('controlPopup', TRUE);
		$controlUpdate			=	$this->input->post('controlUpdate', TRUE);
		$controlFunction		=	$this->input->post('controlFunction', TRUE);
		$functionDisabled		=	$this->input->post('functionDisabled', TRUE);
		
		$licenseLastTime = strtotime("{$licenseLastTime} 00:00:00");
		
		$command = '';
		$commandArray = array();
		if($controlForbidden=='1') {
			array_push($commandArray, 'CONTROL_FORBIDDEN');
		}
		if($controlPopup=='1') {
			array_push($commandArray, 'CONTROL_POPUP_BUY');
		}
		if($controlUpdate=='1') {
			array_push($commandArray, 'CONTROL_UPDATE');
		}
		$command .= implode('@@', $commandArray);
		
		$commandArray = array();
		if($controlFunction=='1') {
			$funcArray = explode(',', $functionDisabled);
			foreach($funcArray as $item) {
				$item = strtoupper($item);
				array_push($commandArray, "CONTROL_DISABLED_{$item}");
			}
			$command .= '@@' . implode('@@', $commandArray);
		}
		
		if(!empty($command)) {
			$checkCode = strtoupper(do_hash($command, 'md5'));
			$command .= "@@@{$checkCode}";
		}
		
		if($licenseUpdate=='update') {
			$parameter = array(
				'license_content'		=>	$licenseContent,
				'license_type'			=>	$licenseType,
				'license_limit'			=>	$licenseLimit,
				'license_timelimit'		=>	$licenseTimeLimit,
				'license_last_time'		=>	$licenseLastTime,
				'product_id'			=>	$productId,
				'product_version'		=>	$productVersion,
				'license_control_command'=>	$command
			);
			if($this->license->update($parameter, $licenseId)) {
				
			}
		} else {
			$licenseGeneratedTime	=	time();
			$parameter = array(
				'license_content'		=>	$licenseContent,
				'license_type'			=>	$licenseType,
				'license_limit'			=>	$licenseLimit,
				'license_timelimit'		=>	$licenseTimeLimit,
				'license_generated_time'=>	$licenseGeneratedTime,
				'license_last_time'		=>	$licenseLastTime,
				'product_id'			=>	$productId,
				'product_version'		=>	$productVersion,
				'license_control_command'=>	$command
			);
			if($this->license->insert($parameter)) {
				
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_LICENSE_SUBMIT'
		));
		redirect('/operation/licenses');
	}
}
?>