<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Licenses extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'report_license';
	private $root_path = null;
	private $logTypeList = array(
		'AUTH_ACTIVE_ERROR_EXPIRED'			=>		'激活码过期',
		'AUTH_ACTIVE_ERROR_VERSION'			=>		'激活码版本错误',
		'AUTH_ACTIVE_ERROR_USED'			=>		'激活码已被使用',
		'AUTH_ACTIVE_ERROR_FREE_EXPIRED'	=>		'激活码已失效',
		'AUTH_ACTIVE_ERROR_INVALID'			=>		'激活码不存在',
		'AUTH_ACTIVE_ERROR_LICENSE_BLOCK'	=>		'激活码被列入黑名单',
		'AUTH_ACTIVE_ERROR_MACHINE_BLOCK'	=>		'机器码被列入黑名单',
		'AUTH_REACTIVE'						=>		'再激活',
		'AUTH_ACTIVE'						=>		'首次激活'
	);
	
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
		$this->load->model('cache', 'cache');
	}
	
	public function index() {
		$reportType		=	$this->input->post('reportType', TRUE);
		$licenseCode	=	$this->input->post('licenseCode', TRUE);
		$machineCode	=	$this->input->post('machineCode', TRUE);
		$productId		=	$this->input->post('productId_forVer', TRUE);
		$productVersion	=	$this->input->post('productVersion', TRUE);
		
		$selectCase = array();
		$data = array();
		
		//是否开启报表缓存
		$enableReportCache = $this->config->item('enable_report_cache');
		
		if($reportType == '1') {
			array_push($selectCase, '按激活码查询');
			if(!empty($licenseCode)) {
				array_push($selectCase, "激活码：{$licenseCode}");
				
				//初始缓存无效状态
				$cacheAvilable = false;
				//缓存开启
				if($enableReportCache) {
					//读取缓存
					$cache_condition = md5(json_encode(array(
						'report_type'		=>	'1',
						'license_content'	=>	$licenseCode
					)));
					$dataMultiResult = $this->cache->getReportCache($cache_condition);
					if($dataMultiResult!=false) {
						$cacheTimeExpire = intval($dataMultiResult->cache_time) + $this->config->item('report_cache_expire');
						if($cacheTimeExpire > time()) {
							//缓存有效
							$cacheAvilable = true;
							$data = json_to_array(json_decode($dataMultiResult->cache_content_data));
						}
					}
				}
				if(!$cacheAvilable) {
					$result = $this->license->getAllResult(array(
						'select'			=>	'log_type, count(*) as count',
						'license_content'	=>	$licenseCode,
						'group_by'			=>	'log_type'
					));
					$resultDetail = $this->license->getAllResult(array(
						'license_content'	=>	$licenseCode,
						'order_by'			=>	array('log_time', 'desc'),
						'limit'				=>	100
					));
					foreach($result as $row) {
						$rowData = array();
						$rowData['log_type'] = $this->logTypeList[$row->log_type];
						$rowData['count'] = $row->count;
						$rowData['detail'] = array();
						foreach($resultDetail as $rowDetail) {
							$dataDetail = array();
							$dataDetail['log_type'] = $this->logTypeList[$rowDetail->log_type];
							$dataDetail['client_cpu_info'] = $rowDetail->client_cpu_info;
							$dataDetail['product_id'] = $rowDetail->product_id;
							$dataDetail['product_version'] = $rowDetail->product_version;
							$dataDetail['log_time'] = $rowDetail->log_time;
							array_push($rowData['detail'], $dataDetail);
						}
						array_push($data, $rowData);
					}
					if($enableReportCache) {
						if($dataMultiResult!=false) {
							$parameter = array(
								'cache_page'		=>	'licenses',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'licenses',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->generateReportCache($parameter);
						}
					}
				}
			}
		} elseif($reportType == '2') {
			array_push($selectCase, '按机器码查询');
			if(!empty($machineCode)) {
				array_push($selectCase, "机器码：{$machineCode}");
				
				//初始缓存无效状态
				$cacheAvilable = false;
				//缓存开启
				if($enableReportCache) {
					//读取缓存
					$cache_condition = md5(json_encode(array(
						'report_type'		=>	'2',
						'client_cpu_info'	=>	$machineCode
					)));
					$dataMultiResult = $this->cache->getReportCache($cache_condition);
					if($dataMultiResult!=false) {
						$cacheTimeExpire = intval($dataMultiResult->cache_time) + $this->config->item('report_cache_expire');
						if($cacheTimeExpire > time()) {
							//缓存有效
							$cacheAvilable = true;
							$data = json_to_array(json_decode($dataMultiResult->cache_content_data));
						}
					}
				}
				if(!$cacheAvilable) {
					$result = $this->license->getAllResult(array(
						'select'			=>	'log_type, count(*) as count',
						'client_cpu_info'	=>	$machineCode,
						'group_by'			=>	'log_type'
					));
					$resultDetail = $this->license->getAllResult(array(
						'client_cpu_info'	=>	$machineCode,
						'order_by'			=>	array('log_time', 'desc'),
						'limit'				=>	100
					));
					foreach($result as $row) {
						$rowData = array();
						$rowData['log_type'] = $this->logTypeList[$row->log_type];
						$rowData['count'] = $row->count;
						$rowData['detail'] = array();
						foreach($resultDetail as $rowDetail) {
							$dataDetail = array();
							$dataDetail['log_type'] = $this->logTypeList[$rowDetail->log_type];
							$dataDetail['license_content'] = $rowDetail->license_content;
							$dataDetail['product_id'] = $rowDetail->product_id;
							$dataDetail['product_version'] = $rowDetail->product_version;
							$dataDetail['log_time'] = $rowDetail->log_time;
							array_push($rowData['detail'], $dataDetail);
						}
						array_push($data, $rowData);
					}
					if($enableReportCache) {
						if($dataMultiResult!=false) {
							$parameter = array(
								'cache_page'		=>	'licenses',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'licenses',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->generateReportCache($parameter);
						}
					}
				}
			}
		} elseif($reportType == '3') {
			array_push($selectCase, '按产品查询');
			if(!empty($productId)) {
				array_push($selectCase, "产品ID：{$productId}");
				if($productVersion != '0') {
					array_push($selectCase, "产品版本：{$productVersion}");
					$parameter = array(
						'select'			=>	'log_type, count(*) as count',
						'product_id'		=>	$productId,
						'product_version'	=>	$productVersion,
						'group_by'			=>	'log_type'
					);
					$paramDetail = array(
						'product_id'		=>	$productId,
						'product_version'	=>	$productVersion,
						'order_by'			=>	array('log_time', 'desc'),
						'limit'				=>	100
					);
				} else {
					$parameter = array(
						'select'			=>	'log_type, count(*) as count',
						'product_id'		=>	$productId,
						'group_by'			=>	'log_type'
					);
					$paramDetail = array(
						'product_id'		=>	$productId,
						'order_by'			=>	array('log_time', 'desc'),
						'limit'				=>	100
					);
				}
				
				//初始缓存无效状态
				$cacheAvilable = false;
				//缓存开启
				if($enableReportCache) {
					//读取缓存
					$cache_condition = md5(json_encode($parameter));
					$dataMultiResult = $this->cache->getReportCache($cache_condition);
					if($dataMultiResult!=false) {
						$cacheTimeExpire = intval($dataMultiResult->cache_time) + $this->config->item('report_cache_expire');
						if($cacheTimeExpire > time()) {
							//缓存有效
							$cacheAvilable = true;
							$data = json_to_array(json_decode($dataMultiResult->cache_content_data));
						}
					}
				}
				if(!$cacheAvilable) {
					$result = $this->license->getAllResult($parameter);
					$resultDetail = $this->license->getAllResult($paramDetail);
					foreach($result as $row) {
						$rowData = array();
						$rowData['log_type'] = $this->logTypeList[$row->log_type];
						$rowData['count'] = $row->count;
						$rowData['detail'] = array();
						foreach($resultDetail as $rowDetail) {
							$dataDetail = array();
							$dataDetail['log_type'] = $this->logTypeList[$rowDetail->log_type];
							$dataDetail['license_content'] = $rowDetail->license_content;
							$dataDetail['client_cpu_info'] = $rowDetail->client_cpu_info;
							$dataDetail['product_id'] = $rowDetail->product_id;
							$dataDetail['product_version'] = $rowDetail->product_version;
							$dataDetail['log_time'] = $rowDetail->log_time;
							array_push($rowData['detail'], $dataDetail);
						}
						array_push($data, $rowData);
					}
					if($enableReportCache) {
						if($dataMultiResult!=false) {
							$parameter = array(
								'cache_page'		=>	'licenses',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'licenses',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->generateReportCache($parameter);
						}
					}
				}
			}
		}
		
		$licenseTotal = $this->license->getLicenseTotal();
		
		$this->config->load('cache', FALSE, TRUE);
		if($this->config->item('enable_cache')) {
			$this->load->model('cache', 'cache');
			$productResult = $this->cache->getCacheResult('product_list');
		} else {
			$this->load->model('product', 'product');
			$productResult = $this->product->getAllResult(array(
				'group_by'	=>	'product_id'
			));
		}
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'license_total'		=>	$licenseTotal,
			'product_result'	=>	$productResult,
			'report_type'		=>	$reportType,
			'result'			=>	$data,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 激活码使用情况统计',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'激活码使用情况统计',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
}
?>