<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Services extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'operation_service';
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
		$this->load->model('operation/service', 'service');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$serviceUpdate = 'update';
			$serviceId = $this->input->get('id', TRUE);
			$row = $this->service->get($serviceId);
			$couponContent = $row->coupon_content;
			$productId = $row->product_id;
			$productVersion = $row->product_version;
			$redirectUrl = $row->redirect_url;
			$couponProportion = $row->coupon_proportion;
			$couponSendmail = $row->coupon_sendmail;
			$autoId = $row->auto_id;
		}
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->service->getTotal();
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
		$result = $this->service->getAllResult(null, $itemPerPage, $offset);
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
		$this->load->model('web/auto', 'auto');
		$autoResult = $this->auto->getAllResult();
		
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'result'			=>	$result,
			'pagination'		=>	$pagination,
			'service_update'	=>	$serviceUpdate,
			'service_id'		=>	$serviceId,
			'single_result'		=>	$row,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 服务包信息管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'服务包信息管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$serviceId = $this->input->get('id', TRUE);
		switch($action) {
			case 'delete':
				$this->service->delete($serviceId);
				$this->logs->write(array(
					'log_type'	=>	'SCC_SERVICE_DELETE'
				));
				break;
		}
		redirect('operation/services');
	}
	
	public function submit() {
		$serviceUpdate	= $this->input->post('serviceUpdate', TRUE);
		$serviceId		= $this->input->post('serviceId', TRUE);
		$serviceName	= $this->input->post('serviceName', TRUE);
		$licensePrefix	= $this->input->post('licensePrefix', TRUE);
		
		$parameter = array(
			'service_name'		=>	$serviceName,
			'license_prefix'	=>	$licensePrefix
		);
		
		if($serviceUpdate=='update') {
			if($this->service->update($parameter, $serviceId)) {
				
			}
		} else {
			if($this->service->insert($parameter)) {
				
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_SERVICE_SUBMIT'
		));
		redirect('operation/services');
	}
}
?>