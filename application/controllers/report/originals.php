<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Originals extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'report_original';
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
	}
	
	public function index() {
		$post = $this->input->get_post('post_flag', TRUE);
		if(!empty($post)) {
			$page			=	$this->input->get('page', TRUE);
			$reportType		=	$this->input->get_post('reportType', TRUE);
			$startTime		=	$this->input->get_post('startTime', TRUE);
			$startHours		=	$this->input->get_post('startHours', TRUE);
			$startMinutes	=	$this->input->get_post('startMinutes', TRUE);
			$startSeconds	=	$this->input->get_post('startSeconds', TRUE);
			$endTime		=	$this->input->get_post('endTime', TRUE);
			$endHours		=	$this->input->get_post('endHours', TRUE);
			$endMinutes		=	$this->input->get_post('endMinutes', TRUE);
			$endSeconds		=	$this->input->get_post('endSeconds', TRUE);
			$machineCode	=	$this->input->get_post('machineCode', TRUE);
			$productId		=	$this->input->get_post('productId_forVer', TRUE);
			$productVersion	=	$this->input->get_post('productVersion', TRUE);
			$systemCPU		=	$this->input->get_post('systemCPU', TRUE);
			$systemOS		=	$this->input->get_post('systemOS', TRUE);
			$systemVideocard=	$this->input->get_post('systemVideocard', TRUE);
			
			$parameterString=	"post_flag=1&reportType=$reportType&startTime=$startTime&startHours=$startHours&startMinutes=$startMinutes&startSeconds=$startSeconds";
			$parameterString.=	"&endTime=$endTime&endHours=$endHours&endMinutes=$endMinutes&endSeconds=$endSeconds&machineCode=$machineCode&productId_forVer=$productId";
			$parameterString.=	"&productVersion=$productVersion&systemCPU=$systemCPU&systemOS=$systemOS&systemVideocard=$systemVideocard";
			
			$selectCase = array();
			$parameter = array();
			if($reportType=='0') {
				array_push($selectCase, '统计所有类型');
			} elseif($reportType=='install') {
				$parameter['log_type'] = 'install';
				array_push($selectCase, '安装');
			} elseif($reportType=='uninstall') {
				$parameter['log_type'] = 'uninstall';
				array_push($selectCase, '卸载');
			} elseif($reportType=='use') {
				$parameter['log_type'] = 'use';
				array_push($selectCase, '使用');
			} elseif($reportType=='function') {
				$parameter['log_type'] = 'function';
				array_push($selectCase, '功能使用');
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
			if(!empty($machineCode)) {
				$parameter['client_cpu_info'] = $machineCode;
				array_push($selectCase, "机器码：{$machineCode}");
			}
			if($productId!='0') {
				$parameter['product_id'] = $productId;
				array_push($selectCase, "产品ID：{$productId}");
			}
			if($productVersion!='0') {
				$parameter['product_version'] = $productVersion;
				array_push($selectCase, "产品版本：{$productVersion}");
			}
			if($systemCPU!='0') {
				$parameter['system_cpu'] = $systemCPU;
				array_push($selectCase, "CPU：{$systemCPU}");
			}
			if($systemOS!='0') {
				$parameter['system_os'] = $systemOS;
				array_push($selectCase, "操作系统：{$systemOS}");
			}
			if($systemVideocard!='0') {
				$parameter['system_videocard'] = $systemVideocard;
				array_push($selectCase, "显卡：{$systemVideocard}");
			}
			
			/**
			 * 
			 * 分页程序
			 * @novar
			 */
			$rowTotal = $this->statistic->getTotal($parameter);
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
			$result = $this->statistic->getAllResult($parameter, $itemPerPage, $offset);
			$lastPostTime = $this->statistic->getLastPostTime($parameter);
			$lastPostTime = date('Y-m-d H:i:s', $lastPostTime->log_time);
			$this->load->helper('pagination');
			$pagination = getPage($page, $pageTotal, $parameterString);
		}
		if(empty($rowTotal)) $rowTotal = '0';
		if(empty($lastPostTime)) $lastPostTime = '没有数据';
		
		$this->config->load('cache', FALSE, TRUE);
		if($this->config->item('enable_cache')) {
			$this->load->model('cache', 'cache');
			$productResult = $this->cache->getCacheResult('product_list');
			$osResult = $this->cache->getCacheResult('sys_os_list');
			$cpuResult = $this->cache->getCacheResult('sys_cpu_list');
			$videocardResult = $this->cache->getCacheResult('sys_videocard_list');
		} else {
			$this->load->model('product', 'product');
			$productResult = $this->product->getAllResult(array(
				'group_by'	=>	'product_id'
			));
			
			$cpuResult = $this->statistic->getAllResult(array(
				'distinct'	=>	'system_cpu'
			));
			
			$osResult = $this->statistic->getAllResult(array(
				'distinct'	=>	'system_os'
			));
			
			$videocardResult = $this->statistic->getAllResult(array(
				'distinct'	=>	'system_videocard'
			));
		}
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'record_total'		=>	$rowTotal,
			'last_post_time'	=>	$lastPostTime,
			'product_result'	=>	$productResult,
			'cpu_result'		=>	$cpuResult,
			'os_result'			=>	$osResult,
			'videocard_result'	=>	$videocardResult,
			'select_case'		=>	$selectCase,
			'result'			=>	$result,
			'pagination'		=>	$pagination,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 原始统计报告',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'原始统计报告',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
}
?>