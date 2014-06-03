<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Exchanges extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'operation_exchange';
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
		$this->load->model('operation/exchange');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$paymentGate = $this->input->get_post('paymentGate', TRUE);
		$orderId = $this->input->get_post('orderId', TRUE);
		$orderEmail = $this->input->get_post('orderEmail', TRUE);
		$website = $this->input->get_post('website', TRUE);
		$parameter = array();
		if(!empty($paymentGate)) {
			$parameter['payment_gate'] = $paymentGate;
		}
		if(!empty($orderId)) {
			$parameter['order_id'] = $orderId;
		}
		if(!empty($orderEmail)) {
			$parameter['order_email'] = $orderEmail;
		}
		if(!empty($website)) {
			$parameter['website'] = $website;
		}
		$parameterString = "paymentGate={$paymentGate}&orderId={$orderId}&orderEmail={$orderEmail}&website={$website}";
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->exchange->getTotal($parameter);
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
		$result = $this->exchange->getAllResult($parameter, $itemPerPage, $offset);
		$this->load->helper('pagination');
		$pagination = getPage($page, $pageTotal, $parameterString);
		$copyright = $this->load->view("std_copyright", '', true);
		
		$data = array(
			'userName'				=>	$this->user->user_name,
			'root_path'				=>	$this->root_path,
			'payment_gate'			=>	$paymentGate,
			'order_id'				=>	$orderId,
			'order_email'			=>	$orderEmail,
			'website'				=>	$website,
			'result'				=>	$result,
			'pagination'			=>	$pagination,
			'copyright'				=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 激活码更新管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'激活码更新管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
}
?>