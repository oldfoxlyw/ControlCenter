<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Percentages extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'report_percentage';
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
			$reportType		=	$this->input->get_post('reportType', TRUE);
			$startTime		=	$this->input->get_post('startTime', TRUE);
			$startHours		=	$this->input->get_post('startHours', TRUE);
			$startMinutes	=	$this->input->get_post('startMinutes', TRUE);
			$startSeconds	=	$this->input->get_post('startSeconds', TRUE);
			$endTime		=	$this->input->get_post('endTime', TRUE);
			$endHours		=	$this->input->get_post('endHours', TRUE);
			$endMinutes		=	$this->input->get_post('endMinutes', TRUE);
			$endSeconds		=	$this->input->get_post('endSeconds', TRUE);
			
			$selectCase = array();
			$parameter = array();
			if($reportType=='1') {
				$parameter['count'] = '*,count(*) as count';
				$parameter['group_by'] = 'system_os';
				$parameter['order_by'] = array('count', 'desc');
				array_push($selectCase, '操作系统使用比重');
			} elseif($reportType=='2') {
				$parameter['count'] = '*,count(*) as count';
				$parameter['group_by'] = 'system_cpu';
				$parameter['order_by'] = array('count', 'desc');
				array_push($selectCase, 'CPU比重');
			} elseif($reportType=='3') {
				$parameter['count'] = '*,count(*) as count';
				$parameter['group_by'] = 'system_videocard';
				$parameter['order_by'] = array('count', 'desc');
				array_push($selectCase, '显卡比重');
			} elseif($reportType=='4') {
				$parameter['count'] = '*,count(*) as count';
				$parameter['group_by'] = array('product_name', 'product_version');
				$parameter['order_by'] = array('count', 'desc');
				array_push($selectCase, '产品占有比重');
			} elseif($reportType=='5') {
				$parameter['count'] = '*,count(*) as count';
				$parameter['where'] = "(`log_type`='install' or `log_type`='uninstall')";
				$parameter['group_by'] = 'log_type';
				$parameter['order_by'] = array('count', 'desc');
				array_push($selectCase, '记录类型比重');
			}
			if(!empty($startTime) && !empty($endTime)) {
				array_push($selectCase, "时间：{$startTime} {$startHours}:{$startMinutes}:{$startSeconds} 至 {$endTime} {$endHours}:{$endMinutes}:{$endSeconds}");
				$startTime = strtotime("$startTime $startHours:$startMinutes:$startSeconds");
				$endTime = strtotime("$endTime $endHours:$endMinutes:$endSeconds");
				if($startTime < $endTime) {
					$parameter['log_time_start'] = $startTime;
					$parameter['log_time_end'] = $endTime;
				}
			} else {
				array_push($selectCase, '全时间段');
			}
			
			//初始缓存无效状态
			$cacheAvilable = false;
			//缓存开启
			if($enableReportCache) {
				//读取缓存
				$cache_condition = md5(json_encode($parameter));
				$dataResult = $this->cache->getReportCache($cache_condition);
				if($dataResult!=false) {
					$cacheTimeExpire = intval($dataResult->cache_time) + $this->config->item('report_cache_expire');
					if($cacheTimeExpire > time()) {
						//缓存有效
						$cacheAvilable = true;
						$result = json_decode($dataResult->cache_content_data);
					}
				}
			}
			if(!$cacheAvilable) {
				$result = $this->statistic->getAllResult($parameter);
				if($enableReportCache) {
					if($dataResult!=false) {
						$parameter = array(
							'cache_page'		=>	'percentages',
							'cache_content_data'=>	json_encode($result),
							'cache_time'		=>	time()
						);
						$this->cache->updateReportCache($parameter, $cache_condition);
					} else {
						$parameter = array(
							'cache_condition'	=>	$cache_condition,
							'cache_page'		=>	'percentages',
							'cache_content_data'=>	json_encode($result),
							'cache_time'		=>	time()
						);
						$this->cache->generateReportCache($parameter);
					}
				}
			}
			$lastPostTime = $this->statistic->getLastPostTime($parameter);
			$lastPostTime = date('Y-m-d H:i:s', $lastPostTime->log_time);
			
			$rowTotal = 0;
			foreach($result as $row) {
				$rowTotal += $row->count;
			}
		}
		
		if(empty($rowTotal)) $rowTotal = '0';
		if(empty($lastPostTime)) $lastPostTime = '没有数据';
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'record_total'		=>	$rowTotal,
			'last_post_time'	=>	$lastPostTime,
			'select_case'		=>	$selectCase,
			'report_type'		=>	$reportType,
			'result'			=>	$result,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 比重统计报告',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'比重统计报告',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
}
?>