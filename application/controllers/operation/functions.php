<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Functions extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'operation_product_function';
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
		$this->load->model('product', 'product');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$funcUpdate = 'update';
			$funcId = $this->input->get('fid', TRUE);
			$func = $this->product->getFunctions(array(
				'func_id'	=>	$funcId
			));
			$funcName = $func[0]->func_name;
			$productId = $func[0]->product_id;
			$productVersion = $func[0]->product_version;
		}
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->product->getFunctionTotal();
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
		$result = $this->product->getFunctions(null, $itemPerPage, $offset);
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
			'func_update'			=>	$funcUpdate,
			'func_id'				=>	$funcId,
			'func_name'				=>	$funcName,
			'product_id'			=>	$productId,
			'product_version'		=>	$productVersion,
			'product_result'		=>	$productResult,
			'pagination'			=>	$pagination,
			'copyright'				=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 产品功能管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'产品功能管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$funcId = $this->input->get('fid', TRUE);
		switch($action) {
			case 'delete':
				$this->product->deleteFunction($funcId);
				$this->logs->write(array(
					'log_type'	=>	'SCC_FUNCTION_DELETE'
				));
				break;
		}
		redirect('/operation/functions');
	}
	
	public function submit() {
		$funcUpdate	=	$this->input->post('funcUpdate', TRUE);
		$funcId		=	$this->input->post('funcId', TRUE);
		$funcName	=	$this->input->post('funcName', TRUE);
		$productId	=	$this->input->post('productId_forVer', TRUE);
		$productVer	=	$this->input->post('productVersion', TRUE);
		
		if($funcUpdate=='update') {
			$parameter = array(
				'func_name'			=>	$funcName,
				'product_id'		=>	$productId,
				'product_version'	=>	$productVer
			);
			if($this->product->updateFunction($parameter, $funcId)) {
				
			}
		} else {
			$parameter = array(
				'func_name'			=>	$funcName,
				'product_id'		=>	$productId,
				'product_version'	=>	$productVer
			);
			if($this->product->insertFunction($parameter)) {
				
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_FUNCTION_SUBMIT'
		));
		redirect('/operation/functions');
	}
}
?>