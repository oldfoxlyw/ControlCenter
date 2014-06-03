<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Coupons extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'operation_coupon';
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
		$this->load->model('operation/coupon', 'coupon');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$couponUpdate = 'update';
			$couponId = $this->input->get('cid', TRUE);
			$row = $this->coupon->get($couponId);
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
		$rowTotal = $this->coupon->getTotal();
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
		$result = $this->coupon->getAllResult(null, $itemPerPage, $offset);
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
			'coupon_update'		=>	$couponUpdate,
			'coupon_id'			=>	$couponId,
			'coupon_content'	=>	$couponContent,
			'product_id'		=>	$productId,
			'product_version'	=>	$productVersion,
			'redirect_url'		=>	$redirectUrl,
			'coupon_proportion'	=>	$couponProportion,
			'coupon_sendmail'	=>	$couponSendmail,
			'auto_id'			=>	$autoId,
			'product_result'	=>	$productResult,
			'auto_result'		=>	$autoResult,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 打折信息管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'打折信息管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$couponId = $this->input->get('cid', TRUE);
		switch($action) {
			case 'delete':
				$this->coupon->delete($couponId);
				$this->logs->write(array(
					'log_type'	=>	'SCC_COUPON_DELETE'
				));
				break;
		}
		redirect('/operation/coupons');
	}
	
	public function submit() {
		$couponUpdate	= $this->input->post('couponUpdate', TRUE);
		$couponId		= $this->input->post('couponId', TRUE);
		$couponContent	= $this->input->post('couponContent', TRUE);
		$couponContentAdd= $this->input->post('couponContentAdd', TRUE);
		$productId		= $this->input->post('productId_forVer', TRUE);
		$productVersion	= $this->input->post('productVersion', TRUE);
		$redirectUrl	= $this->input->post('redirectUrl', TRUE);
		$couponProportion=$this->input->post('couponProportion', TRUE);
		$sendMail		= $this->input->post('sendMail', TRUE);
		$autoId			= $this->input->post('auto_id', TRUE);
		$submit_type	= $this->input->post('submit_type', TRUE);
		$couponCount	= $this->input->post('couponCount', TRUE);
		$couponPrefix	= $this->input->post('couponPrefix', TRUE);
		$couponType		= $this->input->post('couponType', TRUE);
		
		if($sendMail == '1') {
			$sendMail = 1;
		} else {
			$sendMail = 0;
		}
		if($couponUpdate=='update') {
			$parameter = array(
				'coupon_content'	=>	$couponContent,
				'product_id'		=>	$productId,
				'product_version'	=>	$productVersion,
				'redirect_url'		=>	$redirectUrl,
				'coupon_proportion'	=>	$couponProportion,
				'coupon_sendmail'	=>	$sendMail,
				'auto_id'			=>	$autoId,
				'coupon_type'		=>	$couponType
			);
			if($this->coupon->update($parameter, $couponId)) {
				
			}
		} else {
			if($submit_type=='single') {
				$parameter = array(
					'coupon_content'	=>	$couponContent,
					'product_id'		=>	$productId,
					'product_version'	=>	$productVersion,
					'redirect_url'		=>	$redirectUrl,
					'coupon_proportion'	=>	$couponProportion,
					'coupon_sendmail'	=>	$sendMail,
					'auto_id'			=>	$autoId,
					'coupon_type'		=>	$couponType
				);
				if($this->coupon->insert($parameter)) {
					
				}
			} elseif($submit_type=='multiple') {
				if(is_numeric($couponCount)) {
					$this->load->library('Guid');
					$this->load->helper('security');
					$couponCount = intval($couponCount);
					for($i=0; $i<$couponCount; $i++) {
						$couponContent = $couponPrefix;
						$guid = $this->guid->newGuid();
						$random_string = strtoupper(do_hash($guid->toString(), 'md5'));
						$couponContent .= substr($random_string, 0, 6) . '-' . substr($random_string, 6, 6);
						$parameter = array(
							'coupon_content'	=>	$couponContent,
							'product_id'		=>	$productId,
							'product_version'	=>	$productVersion,
							'redirect_url'		=>	$redirectUrl,
							'coupon_proportion'	=>	$couponProportion,
							'coupon_sendmail'	=>	$sendMail,
							'auto_id'			=>	$autoId,
							'coupon_type'		=>	$couponType
						);
						$this->coupon->insert($parameter);
					}
				}
			} elseif($submit_type=='upload') {
				$config['upload_path'] = $this->config->item('upload_dir');
				$config['allowed_types'] = 'txt';
				$config['encrypt_name'] = TRUE;
				
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('fileUpload')) {
					$error = $this->upload->display_errors('', '');
				} else {
					$data = $this->upload->data();
					$filePath = $data['full_path'];
				}
			} elseif($submit_type=='add') {
				$couponArray = explode("\n", $couponContentAdd);
				for($i=0; $i<count($couponArray); $i++) {
					if(!empty($couponArray[$i])) {
						$couponContent = $couponArray[$i];
						$parameter = array(
							'coupon_content'	=>	$couponContent,
							'product_id'		=>	$productId,
							'product_version'	=>	$productVersion,
							'redirect_url'		=>	$redirectUrl,
							'coupon_proportion'	=>	$couponProportion,
							'coupon_sendmail'	=>	$sendMail,
							'auto_id'			=>	$autoId,
							'coupon_type'		=>	$couponType
						);
						$this->coupon->insert($parameter);
					}
				}
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_COUPON_SUBMIT'
		));
		redirect('/operation/coupons');
	}
}
?>