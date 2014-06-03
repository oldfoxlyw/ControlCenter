<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Single_users extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'report_single_user';
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
		$this->load->model('report/statistic', 'statistic');
		$this->load->model('active', 'active');
		$this->load->model('product', 'product');
		$this->load->model('cache', 'cache');
	}
	
	public function index() {
		//是否开启报表缓存
		$enableReportCache = $this->config->item('enable_report_cache');
		
		$post = $this->input->post('post_flag', TRUE);
		if(!empty($post)) {
			$machineCode = $this->input->post('machineCode', TRUE);
			
			$selectCase = array();
			
			if(!empty($machineCode)) {
				array_push($selectCase, "机器码：{$machineCode}");
				
				//已激活软件
				$activedResult = array();
				
				//初始缓存无效状态
				$cacheAvilable = false;
				//缓存开启
				if($enableReportCache) {
					//读取缓存
					$cache_condition = md5(json_encode(array(
						'client_cpu_info'	=>	$machineCode,
						'group_by'			=>	array('product_id', 'product_version')
					)));
					$dataMultiResult = $this->cache->getReportCache($cache_condition);
					if($dataMultiResult!=false) {
						$cacheTimeExpire = intval($dataMultiResult->cache_time) + $this->config->item('report_cache_expire');
						if($cacheTimeExpire > time()) {
							//缓存有效
							$cacheAvilable = true;
							$activedResult = json_to_array(json_decode($dataMultiResult->cache_content_data));
						}
					}
				}
				if(!$cacheAvilable) {
					$result = $this->active->getAllResult(array(
						'client_cpu_info'	=>	$machineCode,
						'group_by'			=>	array('product_id', 'product_version')
					));
					if($result!=FALSE) {
						foreach($result as $row) {
							$resultRow = array();
							$resultNum = $this->statistic->getCacheCpuTotal(array(
								'type'				=>	'use',
								'client_cpu_info'	=>	$machineCode,
								'product_id'		=>	$row->product_id,
								'product_version'	=>	$row->product_version
							));
							$resultRow['product_id'] = $row->product_id;
							$resultRow['product_name'] = $row->product_name;
							$resultRow['product_version'] = $row->product_version;
							$resultRow['use_total'] = $resultNum->use_total;
							$resultRow['client_cpu_info'] = $machineCode;
							$resultRow['license_content'] = $row->license_content;
							
							$functionResult = $this->product->getFunctions(array(
								'product_id'		=>	$row->product_id,
								'product_version'	=>	$row->product_version
							));
							$functionData = array();
							foreach($functionResult as $functionRow) {
								$functionData[$functionRow->func_name] = 0;
							}
							$logResult = $this->statistic->getAllResult(array(
								'log_type'			=>	'function',
								'client_cpu_info'	=>	$machineCode,
								'product_id'		=>	$row->product_id,
								'product_version'	=>	$row->product_version
							));
							if($logResult!=FALSE) {
								foreach($logResult as $logRow) {
									$json = json_decode($logRow->log_parameter);
									if(!empty($json->func)) {
										$functionData[$json->func] += 1;
									}
								}
							}
							$resultRow['function_data'] = $functionData;
							array_push($activedResult, $resultRow);
						}
					}
					if($enableReportCache) {
						if($dataMultiResult!=false) {
							$parameter = array(
								'cache_page'		=>	'single_users',
								'cache_content_data'=>	json_encode($activedResult),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'single_users',
								'cache_content_data'=>	json_encode($activedResult),
								'cache_time'		=>	time()
							);
							$this->cache->generateReportCache($parameter);
						}
					}
				}
				
				//所有软件
				$allResult = array();
				
				//初始缓存无效状态
				$cacheAvilable = false;
				//缓存开启
				if($enableReportCache) {
					//读取缓存
					$cache_condition = md5(json_encode(array(
						'log_type'			=>	'install',
						'client_cpu_info'	=>	$machineCode,
						'group_by'			=>	array('product_id', 'product_version')
					)));
					$dataMultiResult = $this->cache->getReportCache($cache_condition);
					if($dataMultiResult!=false) {
						$cacheTimeExpire = intval($dataMultiResult->cache_time) + $this->config->item('report_cache_expire');
						if($cacheTimeExpire > time()) {
							//缓存有效
							$cacheAvilable = true;
							$allResult = json_to_array(json_decode($dataMultiResult->cache_content_data));
						}
					}
				}
				if(!$cacheAvilable) {
					$result = $this->statistic->getAllResult(array(
						'log_type'			=>	'install',
						'client_cpu_info'	=>	$machineCode,
						'group_by'			=>	array('product_id', 'product_version')
					));
					if($result!=FALSE) {
						foreach($result as $row) {
							$resultRow = array();
							$resultNum = $this->statistic->getCacheCpuTotal(array(
								'type'				=>	'use',
								'client_cpu_info'	=>	$machineCode,
								'product_id'		=>	$row->product_id,
								'product_version'	=>	$row->product_version
							));
							$resultRow['product_id'] = $row->product_id;
							$resultRow['product_name'] = $row->product_name;
							$resultRow['product_version'] = $row->product_version;
							$resultRow['use_total'] = $resultNum->use_total;
							$resultRow['client_cpu_info'] = $machineCode;
							$resultRow['license_content'] = $row->license_content;
							
							$functionResult = $this->product->getFunctions(array(
								'product_id'		=>	$row->product_id,
								'product_version'	=>	$row->product_version
							));
							$functionData = array();
							foreach($functionResult as $functionRow) {
								$functionData[$functionRow->func_name] = 0;
							}
							$logResult = $this->statistic->getAllResult(array(
								'log_type'			=>	'function',
								'client_cpu_info'	=>	$machineCode,
								'product_id'		=>	$row->product_id,
								'product_version'	=>	$row->product_version
							));
							if($logResult!=FALSE) {
								foreach($logResult as $logRow) {
									$json = json_decode($logRow->log_parameter);
									if(!empty($json->func)) {
										$functionData[$json->func] += 1;
									}
								}
							}
							$resultRow['function_data'] = $functionData;
							array_push($allResult, $resultRow);
						}
					}
					if($enableReportCache) {
						if($dataMultiResult!=false) {
							$parameter = array(
								'cache_page'		=>	'single_users',
								'cache_content_data'=>	json_encode($allResult),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'single_users',
								'cache_content_data'=>	json_encode($allResult),
								'cache_time'		=>	time()
							);
							$this->cache->generateReportCache($parameter);
						}
					}
				}
			}
		}
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'select_case'		=>	$selectCase,
			'actived_result'	=>	$activedResult,
			'all_result'		=>	$allResult,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 用户使用统计报告',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'用户使用统计报告',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
}
?>