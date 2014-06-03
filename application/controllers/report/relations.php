<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Relations extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'report_relation';
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
		$this->load->model('cache', 'cache');
	}
	
	public function index() {
		//是否开启报表缓存
		$enableReportCache = $this->config->item('enable_report_cache');
		
		$post = $this->input->get_post('post_flag', TRUE);
		if(!empty($post)) {
			$productId		=	$this->input->get_post('productId_forVer', TRUE);
			$productName	=	$this->input->get_post('productName', TRUE);
			$productVersion	=	$this->input->get_post('productVersion', TRUE);
			$startTime		=	$this->input->get_post('startTime', TRUE);
			$endTime		=	$this->input->get_post('endTime', TRUE);
			
			$selectCase = array();
			$parameter = array();
			if(!empty($productId)) {
				array_push($selectCase, "产品：{$productName}");
				$parameter['product_id'] = $productId;
			}
			if($productVersion!='0') {
				array_push($selectCase, "版本：{$productVersion}");
				$parameter['product_version'] = $productVersion;
			}
			if(!empty($startTime) && !empty($endTime)) {
				array_push($selectCase, "时间：{$startTime}至{$endTime}");
				$parameter['cache_time_start'] = $startTime;
				$parameter['cache_time_end'] = $endTime;
				$startTime = strtotime("{$startTime} 00:00:00");
				$endTime = strtotime("{$endTime} 23:59:59");
				$parameter['log_time_start'] = $startTime;
				$parameter['log_time_end'] = $endTime;
			}
			$this->load->model('report/statistic', 'statistic');
			$this->load->model('active', 'active');
			
			$row = $this->statistic->getCacheAllTotal($parameter);
			$installTotal = $row->install_total;
			$useTotal = $row->use_total;
			$uninstallTotal = $row->uninstall_total;
		
			if($installTotal==0) {
				$useAvg = 0;
			} else {
				$useAvg = round($useTotal / $installTotal, 2);
			}
			
			$temp = $parameter;
			$temp['log_type'] = 'install';
			$row = $this->statistic->getLastPostTime($temp);
			$lastInstallTime = date('Y-m-d H:i:s', $row->log_time);
			$temp['log_type'] = 'uninstall';
			$row = $this->statistic->getLastPostTime($temp);
			$lastUninstallTime = date('Y-m-d H:i:s', $row->log_time);
			$temp['log_type'] = 'use';
			$row = $this->statistic->getLastPostTime($temp);
			$lastUseTime = date('Y-m-d H:i:s', $row->log_time);
			
			$activedTotal = $this->active->getActivedTotal($parameter);
			$row = $this->active->getLastActivedTime($parameter);
			$lastActivedTime = date('Y-m-d H:i:s', $row->license_start_time);
			
			$sql = "SELECT `product_id`, `product_name`, `product_version`, sum(`install_total`) as `install_total`, sum(`use_total`) as `use_total`, sum(`uninstall_total`) as `uninstall_total` FROM `log_cache_machinecode` WHERE `client_cpu_info` in (select distinct `client_cpu_info` from `log_cache_machinecode` where `product_id`='$productId' and `product_version` = '$productVersion') and not (`product_id`='$productId' and `product_version`='$productVersion') group by `product_id`, `product_version`";
			
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
						$result = json_decode($dataMultiResult->cache_content_data);
					}
				}
			}
			if(!$cacheAvilable) {
				$result = $this->statistic->query($sql);
				if($enableReportCache) {
					if($dataMultiResult!=false) {
						$parameter = array(
							'cache_page'		=>	'relations',
							'cache_content_data'=>	json_encode($result),
							'cache_time'		=>	time()
						);
						$this->cache->updateReportCache($parameter, $cache_condition);
					} else {
						$parameter = array(
							'cache_condition'	=>	$cache_condition,
							'cache_page'		=>	'relations',
							'cache_content_data'=>	json_encode($result),
							'cache_time'		=>	time()
						);
						$this->cache->generateReportCache($parameter);
					}
				}
			}
		}
		$this->load->model('product', 'product');
		$productResult = $this->product->getAllResult(array(
			'group_by'	=>	'product_id'
		));
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'product_result'	=>	$productResult,
			'select_case'		=>	$selectCase,
			'product_name'		=>	$productName,
			'product_version'	=>	$productVersion,
			'install_total'		=>	$installTotal,
			'actived_total'		=>	$activedTotal,
			'last_activedtime'	=>	$lastActivedTime,
			'use_total'			=>	$useTotal,
			'use_avg'			=>	$useAvg,
			'uninstall_total'	=>	$uninstallTotal,
			'last_installTime'	=>	$lastInstallTime,
			'last_useTime'		=>	$lastUseTime,
			'last_uninstallTime'=>	$lastUninstallTime,
			'result'			=>	$result,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 关联软件统计报告',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'关联软件统计报告',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
}
?>