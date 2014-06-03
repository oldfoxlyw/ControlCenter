<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'report_index';
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
		$this->load->model('cache', 'cache');
	}
	
	public function index() {
		$this->load->model('report/statistic', 'statistic');
		$this->load->model('active', 'active');
		$this->load->model('product', 'product');
		
		$row = $this->statistic->getCacheAllTotal();
		$installTotal = $row->install_total;
		$useTotal = $row->use_total;
		$uninstallTotal = $row->uninstall_total;
		
		if($installTotal==0) {
			$useAvg = 0;
		} else {
			$useAvg = round($useTotal / $installTotal, 2);
		}
		
		$row = $this->statistic->getLastPostTime(array(
			'log_type'	=>	'install'
		));
		$lastInstallTime = date('Y-m-d H:i:s', $row->log_time);
		$row = $this->statistic->getLastPostTime(array(
			'log_type'	=>	'uninstall'
		));
		$lastUninstallTime = date('Y-m-d H:i:s', $row->log_time);
		$row = $this->statistic->getLastPostTime(array(
			'log_type'	=>	'use'
		));
		$lastUseTime = date('Y-m-d H:i:s', $row->log_time);
		
		$row = $this->statistic->getCacheBuylinkTotal();
		if(!empty($row->firstbuy_total)) {
			$firstbuyTotal = $row->firstbuy_total;
		} else {
			$firstbuyTotal = 0;
		}
		if(!empty($row->clickbuy_total)) {
			$clickbuyTotal = $row->clickbuy_total;
		} else {
			$clickbuyTotal = 0;
		}
		
		$activedTotal = $this->active->getActivedTotal();
		$row = $this->active->getLastActivedTime();
		$lastActivedTime = date('Y-m-d H:i:s', $row->license_start_time);
		
		//是否开启报表缓存
		$enableReportCache = $this->config->item('enable_report_cache');
		
		//初始缓存无效状态
		$cacheAvilable = false;
		//缓存开启
		if($enableReportCache) {
			//读取缓存
			$cache_condition = md5(json_encode(array(
				'cache_page'	=>	'index'
			)));
			$dataResult = $this->cache->getReportCache($cache_condition);
			if($dataResult!=false) {
				$cacheTimeExpire = intval($dataResult->cache_time) + $this->config->item('report_cache_expire');
				if($cacheTimeExpire > time()) {
					//缓存有效
					$cacheAvilable = true;
					$productResult = json_to_array(json_decode($dataResult->cache_content_data));
				}
			}
		}
		if(!$cacheAvilable) {
			$productResult = array();
			$result = $this->product->getAllResult(array(
				'product_index_show'	=>	1
			));
			foreach($result as $row) {
				$rowDetail = $this->statistic->getCacheAllTotal(array(
					'product_id'		=>	$row->product_id,
					'product_version'	=>	$row->product_version
				));
				if(empty($rowDetail->install_total)) {
					$installTotalDetail = 0;
				} else {
					$installTotalDetail = $rowDetail->install_total;
				}
				if(empty($rowDetail->use_total)) {
					$useTotalDetail = 0;
				} else {
					$useTotalDetail = $rowDetail->use_total;
				}
				if(empty($rowDetail->uninstall_total)) {
					$uninstallTotalDetail = 0;
				} else {
					$uninstallTotalDetail = $rowDetail->uninstall_total;
				}
			
				if($installTotalDetail==0) {
					$useAvgTotalDetail = 0;
				} else {
					$useAvgTotalDetail = round($useTotalDetail / $installTotalDetail, 2);
				}
				
				$activedTotalDetail = $this->active->getActivedTotal(array(
					'product_id'		=>	$row->product_id,
					'product_version'	=>	$row->product_version
				));
				
				$rowDetail = $this->statistic->getCacheProductTotal(array(
					'product_id'		=>	$row->product_id,
					'product_version'	=>	$row->product_version
				));
				if(empty($rowDetail->actived_use_total)) {
					$activedUseTotalDetail = 0;
				} else {
					$activedUseTotalDetail = $rowDetail->actived_use_total;
				}
				if(empty($rowDetail->diactived_use_total)) {
					$diactivedUseTotalDetail = 0;
				} else {
					$diactivedUseTotalDetail = $rowDetail->diactived_use_total;
				}
				
				$rowDetail = $this->statistic->getCacheBuylinkTotal(array(
					'product_id'		=>	$row->product_id,
					'product_version'	=>	$row->product_version
				));
				if(empty($rowDetail->firstbuy_total)) {
					$firstbuyTotalDetail = 0;
				} else {
					$firstbuyTotalDetail = $rowDetail->firstbuy_total;
				}
				if(empty($rowDetail->clickbuy_total)) {
					$clickbuyTotalDetail = 0;
				} else {
					$clickbuyTotalDetail = $rowDetail->clickbuy_total;
				}
				
				array_push($productResult, array(
					'product_id'			=>	$row->product_id,
					'product_name'			=>	$row->product_name,
					'product_version'		=>	$row->product_version,
					'install_total_detail'	=>	$installTotalDetail,
					'active_total_detail'	=>	$activedTotalDetail,
					'use_total_detail'		=>	$useTotalDetail,
					'use_avg_detail'		=>	$useAvgTotalDetail,
					'diactived_use_total'	=>	$diactivedUseTotalDetail,
					'actived_use_total'		=>	$activedUseTotalDetail,
					'uninstall_total_detail'=>	$uninstallTotalDetail,
					'firstbuy_total_detail'	=>	$firstbuyTotalDetail,
					'clickbuy_total_detail'	=>	$clickbuyTotalDetail
				));
			}
			if($enableReportCache) {
				if($dataResult!=false) {
					$parameter = array(
						'cache_page'		=>	'index',
						'cache_content_data'=>	json_encode($productResult),
						'cache_time'		=>	time()
					);
					$this->cache->updateReportCache($parameter, $cache_condition);
				} else {
					$parameter = array(
						'cache_condition'	=>	$cache_condition,
						'cache_page'		=>	'index',
						'cache_content_data'=>	json_encode($productResult),
						'cache_time'		=>	time()
					);
					$this->cache->generateReportCache($parameter);
				}
			}
		}
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'				=>	$this->user->user_name,
			'install_total'			=>	$installTotal,
			'last_installTime'		=>	$lastInstallTime,
			'actived_total'			=>	$activedTotal,
			'last_activedtime'		=>	$lastActivedTime,
			'use_total'				=>	$useTotal,
			'use_avg'				=>	$useAvg,
			'last_useTime'			=>	$lastUseTime,
			'uninstall_total'		=>	$uninstallTotal,
			'last_uninstallTime'	=>	$lastUninstallTime,
			'firstbuy_total'		=>	$firstbuyTotal,
			'clickbuy_total'		=>	$clickbuyTotal,
			'product_result'		=>	$productResult,
			'root_path'				=>	$this->root_path,
			'copyright'				=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 报表中心首页',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'报表中心首页',
			'root_path'	=>		$this->root_path
		);
		//$this->output->cache(60);
		$this->load->view('std_template', $data);
	}
}
?>