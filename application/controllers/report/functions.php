<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Functions extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'report_function';
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
		$this->load->model('report/function_statistic', 'statistic');
		$this->load->model('cache', 'cache');
	}
	
	public function index() {
		$post = $this->input->post('post_flag', TRUE);
		if(!empty($post)) {
			$page			=	$this->input->get('page', TRUE);
			$reportType		=	$this->input->post('reportType', TRUE);
			$isMulti		=	$this->input->post('isMulti', TRUE);
			$year1			=	$this->input->post('year1', TRUE);
			$month1			=	$this->input->post('month1', TRUE);
			$date1			=	$this->input->post('date1', TRUE);
			$year2			=	$this->input->post('year2', TRUE);
			$month2			=	$this->input->post('month2', TRUE);
			$date2			=	$this->input->post('date2', TRUE);
			$year3			=	$this->input->post('year3', TRUE);
			$month3			=	$this->input->post('month3', TRUE);
			$date3			=	$this->input->post('date3', TRUE);
			$year4			=	$this->input->post('year4', TRUE);
			$month4			=	$this->input->post('month4', TRUE);
			$date4			=	$this->input->post('date4', TRUE);
			$machineCode	=	$this->input->post('machineCode', TRUE);
			$productId		=	$this->input->post('productId_forVer', TRUE);
			$productVersion	=	$this->input->post('productVersion', TRUE);
			$systemCPU		=	$this->input->post('systemCPU', TRUE);
			$systemOS		=	$this->input->post('systemOS', TRUE);
			$systemVideocard=	$this->input->post('systemVideocard', TRUE);
			$selectFunction	=	$this->input->post('selectFunction', TRUE);
			
			$functionList = array();
			$functionTotal = 0;
			if($productId=='0' || $productVersion=='0') {
				exit("<script>alert(\"请选择产品和版本号\");history.back(-1);</script>");
			}
			$this->load->model('product', 'product');
			if($selectFunction=='0') {
				$funcResult = $this->product->getFunctions(array(
					'product_id'		=>	$productId,
					'product_version'	=>	$productVersion
				));
				if($funcResult!=FALSE) {
					foreach($funcResult as $i => $row) {
						array_push($functionList, $row->func_name);
					}
				}
			} else {
				$funcResult = $this->product->getFunctions(array(
					'func_id'	=>	$selectFunction
				));
				if($funcResult!=FALSE) {
					$selectFunction = $funcResult[0]->func_name;
				}
			}
			$softwareType	=	$this->input->post('softwareType', TRUE);
			switch($softwareType) {
				case 'converter':
					array_push($selectCase, '数据表：converter');
					$parameter['software_type'] = 'converter';
					$converterFileType = $this->input->post('converterFileType', TRUE);
					$converterInput = $this->input->post('converterInput', TRUE);
					$converterOutput = $this->input->post('converterOutput', TRUE);
					$converterWidthCase = $this->input->post('converterWidthCase', TRUE);
					$converterWidth = $this->input->post('converterWidth', TRUE);
					$converterHeightCase = $this->input->post('converterHeightCase', TRUE);
					$converterHeight = $this->input->post('converterHeight', TRUE);
					$converterVcode = $this->input->post('converterVcode', TRUE);
					$converterAcode = $this->input->post('converterAcode', TRUE);
					$converterSubtitle = $this->input->post('converterSubtitle', TRUE);
					$converterCrop = $this->input->post('converterCrop', TRUE);
					$converterTimerange = $this->input->post('converterTimerange', TRUE);
					$converterCuda = $this->input->post('converterCuda', TRUE);
					if($converterFileType!='0') {
						$parameter['file_type'] = $converterFileType;
					}
					if($converterInput!='0') {
						$parameter['file_input'] = $converterInput;
					}
					if($converterOutput!='0') {
						$parameter['file_output'] = $converterOutput;
					}
					if(!empty($converterWidth)) {
						if($converterWidthCase == '1') {
							$parameter['file_width'] = array('<=', $converterWidth);
						} elseif($converterWidthCase == '2') {
							$parameter['file_width'] = array('>', $converterWidth);
						}
					}
					if(!empty($converterHeight)) {
						if($converterHeightCase == '1') {
							$parameter['file_height'] = array('<=', $converterHeight);
						} elseif($converterHeightCase == '2') {
							$parameter['file_height'] = array('>', $converterHeight);
						}
					}
					if($converterVcode!='0') {
						$parameter['file_vcode'] = $converterVcode;
					}
					if($converterAcode!='0') {
						$parameter['file_acode'] = $converterAcode;
					}
					if($converterSubtitle!='-1') {
						$parameter['file_subtitle'] = $converterSubtitle;
					}
					if($converterCrop!='-1') {
						$parameter['file_crop'] = $converterCrop;
					}
					if($converterTimerange!='-1') {
						$parameter['file_timerange'] = $converterTimerange;
					}
					if($converterCuda!='-1') {
						$parameter['file_cuda'] = $converterCuda;
					}
					break;
					
					
				case 'ripper':
					array_push($selectCase, '数据表：ripper');
					$parameter['software_type'] = 'ripper';
					$ripperInput = $this->input->post('ripperInput', TRUE);
					$ripperOutput = $this->input->post('ripperOutput', TRUE);
					$ripperWidthCase = $this->input->post('ripperWidthCase', TRUE);
					$ripperWidth = $this->input->post('ripperWidth', TRUE);
					$ripperHeightCase = $this->input->post('ripperHeightCase', TRUE);
					$ripperHeight = $this->input->post('ripperHeight', TRUE);
					$ripperVcode = $this->input->post('ripperVcode', TRUE);
					$ripperAcode = $this->input->post('ripperAcode', TRUE);
					$ripperSubtitle = $this->input->post('ripperSubtitle', TRUE);
					$ripperCrop = $this->input->post('ripperCrop', TRUE);
					$ripperTimerange = $this->input->post('ripperTimerange', TRUE);
					$ripperCuda = $this->input->post('ripperCuda', TRUE);
					if($ripperInput!='0') {
						$parameter['file_input'] = $ripperInput;
					}
					if($ripperOutput!='0') {
						$parameter['file_output'] = $ripperOutput;
					}
					if(!empty($ripperWidth)) {
						if($ripperWidthCase == '1') {
							$parameter['file_width'] = array('<=', $ripperWidth);
						} elseif($ripperWidthCase == '2') {
							$parameter['file_width'] = array('>', $ripperWidth);
						}
					}
					if(!empty($ripperHeight)) {
						if($ripperHeightCase == '1') {
							$parameter['file_height'] = array('<=', $ripperHeight);
						} elseif($ripperHeightCase == '2') {
							$parameter['file_height'] = array('>', $ripperHeight);
						}
					}
					if($ripperVcode!='0') {
						$parameter['file_vcode'] = $ripperVcode;
					}
					if($ripperAcode!='0') {
						$parameter['file_acode'] = $ripperAcode;
					}
					if($ripperSubtitle!='-1') {
						$parameter['file_subtitle'] = $ripperSubtitle;
					}
					if($ripperCrop!='-1') {
						$parameter['file_crop'] = $ripperCrop;
					}
					if($ripperTimerange!='-1') {
						$parameter['file_timerange'] = $ripperTimerange;
					}
					if($ripperCuda!='-1') {
						$parameter['file_cuda'] = $ripperCuda;
					}
					break;
					
					
				case 'player':
					array_push($selectCase, '数据表：player');
					$parameter['software_type'] = 'player';
					$playerFileType = $this->input->post('playerFileType', TRUE);
					$playerInput = $this->input->post('playerInput', TRUE);
					if($playerFileType!='0') {
						$parameter['file_type'] = $playerFileType;
					}
					if($playerInput!='0') {
						$parameter['file_input'] = $playerInput;
					}
					break;
			}
			
			$parameter['log_type'] = 'function';
			$selectCase = array();
			if($reportType=='1') {
				array_push($selectCase, '按周进行统计');
				array_push($selectCase, "时间：{$year1}年{$month1}月{$date1}日前一周");
				if($isMulti=='1') {
					array_push($selectCase, '加入同期数据');
					array_push($selectCase, "同期时间：{$year2}年{$month2}月{$date2}日前一周");
				}
			} elseif($reportType=='2') {
				array_push($selectCase, '按天进行统计');
				array_push($selectCase, "时间：{$year1}年{$month1}月{$date1}日");
				if($isMulti=='1') {
					array_push($selectCase, '加入同期数据');
					array_push($selectCase, "同期时间：{$year2}年{$month2}月{$date2}日");
				}
			} elseif($reportType=='3') {
				array_push($selectCase, '按月份进行统计');
				array_push($selectCase, "时间：{$year1}年{$month1}月");
				if($isMulti=='1') {
					array_push($selectCase, '加入同期数据');
					array_push($selectCase, "同期时间：{$year2}年{$month2}月");
				}
			} elseif($reportType=='4') {
				array_push($selectCase, '按年份进行统计');
				array_push($selectCase, "时间：{$year1}年");
				if($isMulti=='1') {
					array_push($selectCase, '加入同期数据');
					array_push($selectCase, "同期时间：{$year2}年");
				}
			} elseif($reportType=='5') {
				array_push($selectCase, '自定义时间段');
				array_push($selectCase, "时间：{$year3}年{$month3}月{$date3}日 - {$year4}年{$month4}月{$date4}日");
			}
			if($selectFunction=='0') {
				array_push($selectCase, '所有功能');
			} else {
				array_push($selectCase, "功能：{$selectFunction}");
				$parameter['product_function'] = $selectFunction;
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
		}
		//是否开启报表缓存
		$enableReportCache = $this->config->item('enable_report_cache');
		$rowTotal = 0;
		
		if($reportType=='1') {
			//按周统计
			if(is_numeric($year1) && is_numeric($month1) && is_numeric($date1)) {
				$this->load->helper('date');
				if($isMulti=='1' && is_numeric($year2) && is_numeric($month2) && is_numeric($date2) && $selectFunction!='0') {
					$endTimeStamp = strtotime("{$year2}-{$month2}-{$date2} 23:59:59");
					$startTimeStamp = $endTimeStamp - 6*24*60*60 - 23*60*60 - 59*60 - 59;
					$dataMulti[$selectFunction] = getTimeProgress($startTimeStamp, $endTimeStamp);
					$multiResult = array();
					
					$parameter['log_time_start'] = $startTimeStamp;
					$parameter['log_time_end'] = $endTimeStamp;
					
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
								$dataMulti = json_to_array(json_decode($dataMultiResult->cache_content_data));
							}
						}
					}
					if(!$cacheAvilable) {
						$rowTotalMulti = $this->statistic->getTotal($parameter);
						$itemPerPage = $this->config->item('pagination_data');
						$pageTotalMulti = intval($rowTotalMulti/$itemPerPage);
						if($rowTotalMulti%$itemPerPage) $pageTotalMulti++;
						for($page=1; $page<=$pageTotalMulti; $page++) {
							$offset = $itemPerPage * ($page - 1);
							$resultFunction = $this->statistic->getAllResult($parameter, $itemPerPage, $offset);
							if($resultFunction!=false) {
								foreach($resultFunction as $row) {
									$currentDate = date('n-j', $row->log_time);
									$dataMulti[$row->log_parameter_func][$currentDate] += 1;
								}
							}
						}
						if($enableReportCache) {
							if($dataMultiResult!=false) {
								$parameter = array(
									'cache_page'		=>	'functions',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->updateReportCache($parameter, $cache_condition);
							} else {
								$parameter = array(
									'cache_condition'	=>	$cache_condition,
									'cache_page'		=>	'functions',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->generateReportCache($parameter);
							}
						}
					}
					foreach($dataMulti as $key=>$value) {
						foreach($value as $date=>$count) {
							$multiResult[$key][] = array(
								'date'	=>	$date,
								'count'	=>	$count
							);
						}
					}
				}
				$endTimeStamp = strtotime("{$year1}-{$month1}-{$date1} 23:59:59");
				$startTimeStamp = $endTimeStamp - 6*24*60*60 - 23*60*60 - 59*60 - 59;
				if($selectFunction=='0') {
					for($i=0; $i<count($functionList); $i++) {
						$data[$functionList[$i]] = getTimeProgress($startTimeStamp, $endTimeStamp);
					}
				} else {
					$data[$selectFunction] = getTimeProgress($startTimeStamp, $endTimeStamp);
				}
				$result = array();
				
				$parameter['log_time_start'] = $startTimeStamp;
				$parameter['log_time_end'] = $endTimeStamp;
				$lastPostTime = $this->statistic->getLastPostTime($parameter);
				
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
							$data = json_to_array(json_decode($dataResult->cache_content_data));
						}
					}
				}
				if(!$cacheAvilable) {
					$rowTotal = $this->statistic->getTotal($parameter);
					$itemPerPage = $this->config->item('pagination_data');
					$pageTotal = intval($rowTotal/$itemPerPage);
					if($rowTotal%$itemPerPage) $pageTotal++;
					for($page=1; $page<=$pageTotal; $page++) {
						$offset = $itemPerPage * ($page - 1);
						$resultFunction = $this->statistic->getAllResult($parameter, $itemPerPage, $offset);
						if($resultFunction!=false) {
							foreach($resultFunction as $row) {
								$currentDate = date('n-j', $row->log_time);
								$data[$row->log_parameter_func][$currentDate] += 1;
							}
						}
					}
					if($enableReportCache) {
						if($dataResult!=false) {
							$parameter = array(
								'cache_page'		=>	'functions',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'functions',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->generateReportCache($parameter);
						}
					}
				}
				foreach($data as $key=>$value) {
					foreach($value as $date=>$count) {
						if($cacheAvilable) {
							$rowTotal += intval($count);
						}
						$result[$key][] = array(
							'date'	=>	$date,
							'count'	=>	$count
						);
					}
				}
			}
		} elseif($reportType=='2') {
			//按天统计
			if(is_numeric($year1) && is_numeric($month1) && is_numeric($date1)) {
				$this->load->helper('date');
				if($isMulti=='1' && is_numeric($year2) && is_numeric($month2) && is_numeric($date2) && $selectFunction!='0') {
					$dataMulti[$selectFunction] = getHoursArray();
					$multiResult = array();
					$startTimeStamp = strtotime("{$year2}-{$month2}-{$date2} 00:00:00");
					$endTimeStamp = strtotime("{$year2}-{$month2}-{$date2} 23:59:59");
					
					$parameter['log_time_start'] = $startTimeStamp;
					$parameter['log_time_end'] = $endTimeStamp;;
					
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
								$dataMulti = json_to_array(json_decode($dataMultiResult->cache_content_data));
							}
						}
					}
					if(!$cacheAvilable) {
						$rowTotalMulti = $this->statistic->getTotal($parameter);
						$itemPerPage = $this->config->item('pagination_data');
						$pageTotal = intval($rowTotalMulti/$itemPerPage);
						if($rowTotalMulti%$itemPerPage) $pageTotal++;
						for($page=1; $page<=$pageTotal; $page++) {
							$offset = $itemPerPage * ($page - 1);
							$resultAccount = $this->statistic->getAllResult($parameter, $itemPerPage, $offset);
							if($resultAccount!=false) {
								foreach($resultAccount as $row) {
									$currentHour = intval(date('G', $row->log_time));
									$dataMulti[$row->log_parameter_func][$currentHour] += 1;
								}
							}
						}
						if($enableReportCache) {
							if($dataMultiResult!=false) {
								$parameter = array(
									'cache_page'		=>	'functions',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->updateReportCache($parameter, $cache_condition);
							} else {
								$parameter = array(
									'cache_condition'	=>	$cache_condition,
									'cache_page'		=>	'functions',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->generateReportCache($parameter);
							}
						}
					}
					foreach($dataMulti as $key=>$value) {
						foreach($value as $date=>$count) {
							$multiResult[$key][] = array(
								'date'	=>	$date,
								'count'	=>	$count
							);
						}
					}
				}
				if($selectFunction=='0') {
					for($i=0; $i<count($functionList); $i++) {
						$data[$functionList[$i]] = getHoursArray();
					}
				} else {
					$data[$selectFunction] = getHoursArray();
				}
				$result = array();
				$startTimeStamp = strtotime("{$year1}-{$month1}-{$date1} 00:00:00");
				$endTimeStamp = strtotime("{$year1}-{$month1}-{$date1} 23:59:59");
				
				$parameter['log_time_start'] = $startTimeStamp;
				$parameter['log_time_end'] = $endTimeStamp;
				$lastPostTime = $this->statistic->getLastPostTime($parameter);
				
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
							$data = json_to_array(json_decode($dataResult->cache_content_data));
						}
					}
				}
				if(!$cacheAvilable) {
					$rowTotal = $this->statistic->getTotal($parameter);
					$itemPerPage = $this->config->item('pagination_data');
					$pageTotal = intval($rowTotal/$itemPerPage);
					if($rowTotal%$itemPerPage) $pageTotal++;
					for($page=1; $page<=$pageTotal; $page++) {
						$offset = $itemPerPage * ($page - 1);
						$resultAccount = $this->statistic->getAllResult($parameter, $itemPerPage, $offset);
						if($resultAccount!=false) {
							foreach($resultAccount as $row) {
								$currentHour = intval(date('G', $row->log_time));
								$data[$row->log_parameter_func][$currentHour] += 1;
							}
						}
					}
					if($enableReportCache) {
						if($dataResult!=false) {
							$parameter = array(
								'cache_page'		=>	'functions',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'functions',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->generateReportCache($parameter);
						}
					}
				}
				foreach($data as $key=>$value) {
					foreach($value as $date=>$count) {
						if($cacheAvilable) {
							$rowTotal += intval($count);
						}
						$result[$key][] = array(
							'date'	=>	$date,
							'count'	=>	$count
						);
					}
				}
			}
		} elseif($reportType=='3') {
			//按月份统计
			if(is_numeric($year1) && is_numeric($month1)) {
				$this->load->helper('date');
				if($isMulti=='1' && is_numeric($year2) && is_numeric($month2) && $selectFunction!='0') {
					$dataMulti[$selectFunction] = getDatesArray($year2, intval($month2));
					$multiResult = array();
					$count = strval(days_in_month(intval($month2), $year2));
					$startTimeStamp = strtotime("{$year2}-{$month2}-01 00:00:00");
					$endTimeStamp = strtotime("{$year2}-{$month2}-{$count} 23:59:59");
					
					$parameter['log_time_start'] = $startTimeStamp;
					$parameter['log_time_end'] = $endTimeStamp;;
					
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
								$dataMulti = json_to_array(json_decode($dataMultiResult->cache_content_data));
							}
						}
					}
					if(!$cacheAvilable) {
						$rowTotalMulti = $this->statistic->getTotal($parameter);
						$itemPerPage = $this->config->item('pagination_data');
						$pageTotal = intval($rowTotalMulti/$itemPerPage);
						if($rowTotalMulti%$itemPerPage) $pageTotal++;
						for($page=1; $page<=$pageTotal; $page++) {
							$offset = $itemPerPage * ($page - 1);
							$resultAccount = $this->statistic->getAllResult($parameter, $itemPerPage, $offset);
							if($resultAccount!=false) {
								foreach($resultAccount as $row) {
									$currentDate = intval(date('j', $row->log_time));
									$dataMulti[$row->log_parameter_func][$currentDate] += 1;
								}
							}
						}
						if($enableReportCache) {
							if($dataMultiResult!=false) {
								$parameter = array(
									'cache_page'		=>	'functions',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->updateReportCache($parameter, $cache_condition);
							} else {
								$parameter = array(
									'cache_condition'	=>	$cache_condition,
									'cache_page'		=>	'functions',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->generateReportCache($parameter);
							}
						}
					}
					foreach($dataMulti as $key=>$value) {
						foreach($value as $date=>$count) {
							$multiResult[$key][] = array(
								'date'	=>	$date,
								'count'	=>	$count
							);
						}
					}
				}
				if($selectFunction=='0') {
					for($i=0; $i<count($functionList); $i++) {
						$data[$functionList[$i]] = getDatesArray($year1, intval($month1));
					}
				} else {
					$data[$selectFunction] = getDatesArray($year1, intval($month1));
				}
				$result = array();
				$count = strval(days_in_month(intval($month1), $year1));
				$startTimeStamp = strtotime("{$year1}-{$month1}-01 00:00:00");
				$endTimeStamp = strtotime("{$year1}-{$month1}-{$count} 23:59:59");
				
				$parameter['log_time_start'] = $startTimeStamp;
				$parameter['log_time_end'] = $endTimeStamp;
				$lastPostTime = $this->statistic->getLastPostTime($parameter);
				
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
							$data = json_to_array(json_decode($dataResult->cache_content_data));
						}
					}
				}
				if(!$cacheAvilable) {
					$rowTotal = $this->statistic->getTotal($parameter);
					$itemPerPage = $this->config->item('pagination_data');
					$pageTotal = intval($rowTotal/$itemPerPage);
					if($rowTotal%$itemPerPage) $pageTotal++;
					for($page=1; $page<=$pageTotal; $page++) {
						$offset = $itemPerPage * ($page - 1);
						$resultAccount = $this->statistic->getAllResult($parameter, $itemPerPage, $offset);
						if($resultAccount!=false) {
							foreach($resultAccount as $row) {
								$currentDate = intval(date('j', $row->log_time));
								$data[$row->log_parameter_func][$currentDate] += 1;
							}
						}
					}
					if($enableReportCache) {
						if($dataResult!=false) {
							$parameter = array(
								'cache_page'		=>	'functions',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'functions',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->generateReportCache($parameter);
						}
					}
				}
				foreach($data as $key=>$value) {
					foreach($value as $date=>$count) {
						if($cacheAvilable) {
							$rowTotal += intval($count);
						}
						$result[$key][] = array(
							'date'	=>	$date,
							'count'	=>	$count
						);
					}
				}
			}
		} elseif($reportType=='4') {
			//按年统计
			if(is_numeric($year1)) {
				$this->load->helper('date');
				if($isMulti=='1' && is_numeric($year2) && $selectFunction!='0') {
					$dataMulti[$selectFunction] = getMonthsArray();
					$multiResult = array();
					$startTimeStamp = strtotime("{$year2}-01-01 00:00:00");
					$endTimeStamp = strtotime("{$year2}-12-31 23:59:59");
					
					$parameter['log_time_start'] = $startTimeStamp;
					$parameter['log_time_end'] = $endTimeStamp;;
					
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
								$dataMulti = json_to_array(json_decode($dataMultiResult->cache_content_data));
							}
						}
					}
					if(!$cacheAvilable) {
						$rowTotalMulti = $this->statistic->getTotal($parameter);
						$itemPerPage = $this->config->item('pagination_data');
						$pageTotal = intval($rowTotalMulti/$itemPerPage);
						if($rowTotalMulti%$itemPerPage) $pageTotal++;
						for($page=1; $page<=$pageTotal; $page++) {
							$offset = $itemPerPage * ($page - 1);
							$resultAccount = $this->statistic->getAllResult($parameter, $itemPerPage, $offset);
							if($resultAccount!=false) {
								foreach($resultAccount as $row) {
									$currentMonth = intval(date('n', $row->log_time));
									$dataMulti[$row->log_parameter_func][$currentMonth-1] += 1;
								}
							}
						}
						if($enableReportCache) {
							if($dataMultiResult!=false) {
								$parameter = array(
									'cache_page'		=>	'functions',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->updateReportCache($parameter, $cache_condition);
							} else {
								$parameter = array(
									'cache_condition'	=>	$cache_condition,
									'cache_page'		=>	'functions',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->generateReportCache($parameter);
							}
						}
					}
					foreach($dataMulti as $key=>$value) {
						foreach($value as $date=>$count) {
							$multiResult[$key][] = array(
								'date'	=>	$date,
								'count'	=>	$count
							);
						}
					}
				}
				if($selectFunction=='0') {
					for($i=0; $i<count($functionList); $i++) {
						$data[$functionList[$i]] = getMonthsArray();
					}
				} else {
					$data[$selectFunction] = getMonthsArray();
				}
				$result = array();
				$startTimeStamp = strtotime("{$year1}-01-01 00:00:00");
				$endTimeStamp = strtotime("{$year1}-12-31 23:59:59");
				
				$parameter['log_time_start'] = $startTimeStamp;
				$parameter['log_time_end'] = $endTimeStamp;
				$lastPostTime = $this->statistic->getLastPostTime($parameter);
				
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
							$data = json_to_array(json_decode($dataResult->cache_content_data));
						}
					}
				}
				if(!$cacheAvilable) {
					$rowTotal = $this->statistic->getTotal($parameter);
					$itemPerPage = $this->config->item('pagination_data');
					$pageTotal = intval($rowTotal/$itemPerPage);
					if($rowTotal%$itemPerPage) $pageTotal++;
					for($page=1; $page<=$pageTotal; $page++) {
						$offset = $itemPerPage * ($page - 1);
						$resultAccount = $this->statistic->getAllResult($parameter, $itemPerPage, $offset);
						if($resultAccount!=false) {
							foreach($resultAccount as $row) {
								$currentMonth = intval(date('n', $row->log_time));
								$data[$row->log_parameter_func][$currentMonth-1] += 1;
							}
						}
					}
					if($enableReportCache) {
						if($dataResult!=false) {
							$parameter = array(
								'cache_page'		=>	'functions',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'functions',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->generateReportCache($parameter);
						}
					}
				}
				foreach($data as $key=>$value) {
					foreach($value as $date=>$count) {
						if($cacheAvilable) {
							$rowTotal += intval($count);
						}
						$result[$key][] = array(
							'date'	=>	$date,
							'count'	=>	$count
						);
					}
				}
			}
		} elseif($reportType=='5') {
			//自定义时间段
			$this->load->helper('date');
			$startTimeStamp = strtotime("{$year3}-{$month3}-{$date3} 00:00:00");
			$endTimeStamp = strtotime("{$year4}-{$month4}-{$date4} 23:59:59");
			if($selectFunction=='0') {
				for($i=0; $i<count($functionList); $i++) {
					$data[$functionList[$i]] = getTimeProgress($startTimeStamp, $endTimeStamp);
				}
			} else {
				$data[$selectFunction] = getTimeProgress($startTimeStamp, $endTimeStamp);
			}
			$result = array();
			
			$parameter['log_time_start'] = $startTimeStamp;
			$parameter['log_time_end'] = $endTimeStamp;
			$lastPostTime = $this->statistic->getLastPostTime($parameter);
			
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
						$data = json_to_array(json_decode($dataResult->cache_content_data));
					}
				}
			}
			if(!$cacheAvilable) {
				$resultAccount = $this->statistic->getAllResult($parameter);
				if($resultAccount!=false) {
					foreach($resultAccount as $row) {
						$currentDate = date('n-j', $row->log_time);
						$data[$row->log_parameter_func][$currentDate] += 1;
					}
				}
				if($enableReportCache) {
					if($dataResult!=false) {
						$parameter = array(
							'cache_page'		=>	'functions',
							'cache_content_data'=>	json_encode($data),
							'cache_time'		=>	time()
						);
						$this->cache->updateReportCache($parameter, $cache_condition);
					} else {
						$parameter = array(
							'cache_condition'	=>	$cache_condition,
							'cache_page'		=>	'functions',
							'cache_content_data'=>	json_encode($data),
							'cache_time'		=>	time()
						);
						$this->cache->generateReportCache($parameter);
					}
				}
			}
			foreach($data as $key=>$value) {
				foreach($value as $date=>$count) {
					if($cacheAvilable) {
						$rowTotal += intval($count);
					}
					$result[$key][] = array(
						'date'	=>	$date,
						'count'	=>	$count
					);
				}
			}
		}
		
		if(empty($rowTotal)) $rowTotal = '0';
		if(empty($lastPostTime)) $lastPostTime = '没有数据';
		
		$this->config->load('cache', FALSE, TRUE);
		if($this->config->item('enable_cache')) {
			$productResult = $this->cache->getCacheResult('product_list');
			$osResult = $this->cache->getCacheResult('sys_os_list');
			$cpuResult = $this->cache->getCacheResult('sys_cpu_list');
			$videocardResult = $this->cache->getCacheResult('sys_videocard_list');
			
			$convertFileTypeResult = $this->cache->getCacheResult('converter_filetype_list');
			$convertInputResult = $this->cache->getCacheResult('converter_input_list');
			$convertOutputResult = $this->cache->getCacheResult('converter_output_list');
			$convertVcodeResult = $this->cache->getCacheResult('converter_vcode_list');
			$convertAcodeResult = $this->cache->getCacheResult('converter_acode_list');
			
			$ripperInputResult = $this->cache->getCacheResult('ripper_input_list');
			$ripperOutputResult = $this->cache->getCacheResult('ripper_output_list');
			$ripperVcodeResult = $this->cache->getCacheResult('ripper_vcode_list');
			$ripperAcodeResult = $this->cache->getCacheResult('ripper_acode_list');
			
			$playerFileTypeResult = $this->cache->getCacheResult('player_filetype_list');
			$playerInputResult = $this->cache->getCacheResult('player_input_list');
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
			'userName'					=>	$this->user->user_name,
			'root_path'					=>	$this->root_path,
			'record_total'				=>	$rowTotal,
			'last_post_time'			=>	$lastPostTime,
			'product_result'			=>	$productResult,
			'cpu_result'				=>	$cpuResult,
			'os_result'					=>	$osResult,
			'videocard_result'			=>	$videocardResult,
			'convert_filetype_result'	=>	$convertFileTypeResult,
			'convert_input_result'		=>	$convertInputResult,
			'convert_output_result'		=>	$convertOutputResult,
			'convert_vcode_result'		=>	$convertVcodeResult,
			'convert_acode_result'		=>	$convertAcodeResult,
			'ripper_input_result'		=>	$ripperInputResult,
			'ripper_output_result'		=>	$ripperOutputResult,
			'ripper_vcode_result'		=>	$ripperVcodeResult,
			'ripper_acode_result'		=>	$ripperAcodeResult,
			'player_filetype_result'	=>	$playerFileTypeResult,
			'player_input_result'		=>	$playerInputResult,
			'select_case'		=>	$selectCase,
			'report_type'		=>	$reportType,
			'year1'				=>	$year1,
			'month1'			=>	$month1,
			'date1'				=>	$date1,
			'year2'				=>	$year2,
			'month2'			=>	$month2,
			'date2'				=>	$date2,
			'year3'				=>	$year3,
			'month3'			=>	$month3,
			'date3'				=>	$date3,
			'year4'				=>	$year4,
			'month4'			=>	$month4,
			'date4'				=>	$date4,
			'result'			=>	$result,
			'multi_result'		=>	$multiResult,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 软件使用量统计',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'软件使用量统计',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
}
?>