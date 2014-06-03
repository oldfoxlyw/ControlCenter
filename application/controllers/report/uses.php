<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Uses extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'report_use';
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
		$fastQuery = true;
		$post = $this->input->get_post('post_flag', TRUE);
		if(!empty($post)) {
			$page			=	$this->input->get('page', TRUE);
			$reportType		=	$this->input->get_post('reportType', TRUE);
			$isMulti		=	$this->input->get_post('isMulti', TRUE);
			$year1			=	$this->input->get_post('year1', TRUE);
			$month1			=	$this->input->get_post('month1', TRUE);
			$date1			=	$this->input->get_post('date1', TRUE);
			$year2			=	$this->input->get_post('year2', TRUE);
			$month2			=	$this->input->get_post('month2', TRUE);
			$date2			=	$this->input->get_post('date2', TRUE);
			$year3			=	$this->input->get_post('year3', TRUE);
			$month3			=	$this->input->get_post('month3', TRUE);
			$date3			=	$this->input->get_post('date3', TRUE);
			$year4			=	$this->input->get_post('year4', TRUE);
			$month4			=	$this->input->get_post('month4', TRUE);
			$date4			=	$this->input->get_post('date4', TRUE);
			$machineCode	=	$this->input->get_post('machineCode', TRUE);
			$productId		=	$this->input->get_post('productId_forVer', TRUE);
			$productVersion	=	$this->input->get_post('productVersion', TRUE);
			$systemCPU		=	$this->input->get_post('systemCPU', TRUE);
			$systemOS		=	$this->input->get_post('systemOS', TRUE);
			$systemVideocard=	$this->input->get_post('systemVideocard', TRUE);
			
			$parameter['log_type'] = 'use';
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
			if(!empty($machineCode)) {
				$parameter['client_cpu_info'] = $machineCode;
				$fastQuery = false;
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
				$fastQuery = false;
				array_push($selectCase, "CPU：{$systemCPU}");
			}
			if($systemOS!='0') {
				$parameter['system_os'] = $systemOS;
				$fastQuery = false;
				array_push($selectCase, "操作系统：{$systemOS}");
			}
			if($systemVideocard!='0') {
				$parameter['system_videocard'] = $systemVideocard;
				$fastQuery = false;
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
				if($isMulti=='1' && is_numeric($year2) && is_numeric($month2) && is_numeric($date2)) {
					$endTimeStamp = strtotime("{$year2}-{$month2}-{$date2} 23:59:59");
					$startTimeStamp = $endTimeStamp - 6*24*60*60 - 23*60*60 - 59*60 - 59;
					$dataMulti = getTimeProgress($startTimeStamp, $endTimeStamp);
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
						if($fastQuery) {
							$parameter['log_time_start'] = date('Y-m-d H:i:s', $startTimeStamp);
							$parameter['log_time_end'] = date('Y-m-d H:i:s', $endTimeStamp);
							$resultAccount = $this->statistic->getCacheResult($parameter);
							if($resultAccount!=false) {
								foreach($resultAccount as $row) {
									$currentDate = date('n-j', strtotime($row->cache_time));
									$dataMulti[$currentDate] += intval($row->use_total);
								}
							}
						} else {
							$rowTotalMulti = $this->statistic->getTotal($parameter);
							$itemPerPage = $this->config->item('pagination_data');
							$pageTotalMulti = intval($rowTotalMulti/$itemPerPage);
							if($rowTotalMulti%$itemPerPage) $pageTotalMulti++;
							for($page=1; $page<=$pageTotalMulti; $page++) {
								$offset = $itemPerPage * ($page - 1);
								$resultAccount = $this->statistic->getAllResult($parameter, $itemPerPage, $offset);
								if($resultAccount!=false) {
									foreach($resultAccount as $row) {
										$currentDate = date('n-j', $row->log_time);
										$dataMulti[$currentDate] += 1;
									}
								}
							}
						}
						if($enableReportCache) {
							if($dataMultiResult!=false) {
								$parameter = array(
									'cache_page'		=>	'uses',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->updateReportCache($parameter, $cache_condition);
							} else {
								$parameter = array(
									'cache_condition'	=>	$cache_condition,
									'cache_page'		=>	'uses',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->generateReportCache($parameter);
							}
						}
					}
					foreach($dataMulti as $key=>$value) {
						array_push($multiResult, array(
							'date'	=>	$key,
							'count'	=>	$value
						));
					}
				}
				$endTimeStamp = strtotime("{$year1}-{$month1}-{$date1} 23:59:59");
				$startTimeStamp = $endTimeStamp - 6*24*60*60 - 23*60*60 - 59*60 - 59;
				$data = getTimeProgress($startTimeStamp, $endTimeStamp);
				$result = array();
				
				$parameter['log_time_start'] = $startTimeStamp;
				$parameter['log_time_end'] = $endTimeStamp;
				
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
					if($fastQuery) {
						$parameter['log_time_start'] = date('Y-m-d H:i:s', $startTimeStamp);
						$parameter['log_time_end'] = date('Y-m-d H:i:s', $endTimeStamp);
						$resultAccount = $this->statistic->getCacheResult($parameter);
						if($resultAccount!=false) {
							foreach($resultAccount as $row) {
								$currentDate = date('n-j', strtotime($row->cache_time));
								$data[$currentDate] += intval($row->use_total);
							}
						}
					} else {
						$rowTotal = $this->statistic->getTotal($parameter);
						$itemPerPage = $this->config->item('pagination_data');
						$pageTotal = intval($rowTotal/$itemPerPage);
						if($rowTotal%$itemPerPage) $pageTotal++;
						for($page=1; $page<=$pageTotal; $page++) {
							$offset = $itemPerPage * ($page - 1);
							$resultAccount = $this->statistic->getAllResult($parameter, $itemPerPage, $offset);
							if($resultAccount!=false) {
								foreach($resultAccount as $row) {
									$currentDate = date('n-j', $row->log_time);
									$data[$currentDate] += 1;
								}
							}
						}
					}
					if($enableReportCache) {
						if($dataResult!=false) {
							$parameter = array(
								'cache_page'		=>	'uses',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'uses',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->generateReportCache($parameter);
						}
					}
				}
				foreach($data as $key=>$value) {
					if($cacheAvilable || $fastQuery) {
						$rowTotal += intval($value);
					}
					array_push($result, array(
						'date'	=>	$key,
						'count'	=>	$value
					));
				}
			}
		} elseif($reportType=='2') {
			//按天统计
			if(is_numeric($year1) && is_numeric($month1) && is_numeric($date1)) {
				$this->load->helper('date');
				if($isMulti=='1' && is_numeric($year2) && is_numeric($month2) && is_numeric($date2)) {
					$dataMulti = getHoursArray();
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
									$dataMulti[$currentHour] += 1;
								}
							}
						}
						if($enableReportCache) {
							if($dataMultiResult!=false) {
								$parameter = array(
									'cache_page'		=>	'uses',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->updateReportCache($parameter, $cache_condition);
							} else {
								$parameter = array(
									'cache_condition'	=>	$cache_condition,
									'cache_page'		=>	'uses',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->generateReportCache($parameter);
							}
						}
					}
					foreach($dataMulti as $key=>$value) {
						array_push($multiResult, array(
							'date'	=>	$key,
							'count'	=>	$value
						));
					}
				}
				$data = getHoursArray();
				$result = array();
				$startTimeStamp = strtotime("{$year1}-{$month1}-{$date1} 00:00:00");
				$endTimeStamp = strtotime("{$year1}-{$month1}-{$date1} 23:59:59");
				
				$parameter['log_time_start'] = $startTimeStamp;
				$parameter['log_time_end'] = $endTimeStamp;
				
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
								$data[$currentHour] += 1;
							}
						}
					}
					if($enableReportCache) {
						if($dataResult!=false) {
							$parameter = array(
								'cache_page'		=>	'uses',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'uses',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->generateReportCache($parameter);
						}
					}
				}
				foreach($data as $key=>$value) {
					if($cacheAvilable) {
						$rowTotal += intval($value);
					}
					array_push($result, array(
						'date'	=>	$key,
						'count'	=>	$value
					));
				}
			}
		} elseif($reportType=='3') {
			//按月份统计
			if(is_numeric($year1) && is_numeric($month1)) {
				if(!empty($machineCode)) {
					$additionalSql .= "and `client_cpu_info`='$machineCode'";
				}
				if($productId!='0') {
					$additionalSql .= "and `product_id`='$productId' ";
				}
				if($productVersion!='0') {
					$additionalSql .= "and `product_version`='$productVersion' ";
				}
				if($systemCPU!='0') {
					$additionalSql .= "and `system_cpu`='$systemCPU'";
				}
				if($systemOS!='0') {
					$additionalSql .= "and `system_os`='$systemOS'";
				}
				if($systemVideocard!='0') {
					$additionalSql .= "and `system_videocard`='$systemVideocard'";
				}
				if($isMulti=='1' && is_numeric($year2) && is_numeric($month2)) {
					$sqlArray = Array(
						'year'				=>	$year2,
						'month'				=>	$month2,
						'log_type'			=>	'use',
						'additional_sql'	=>	$additionalSql
					);
					//初始缓存无效状态
					$cacheAvilable = false;
					//缓存开启
					if($enableReportCache) {
						//读取缓存
						$cache_condition = md5(json_encode($sqlArray));
						$dataMultiResult = $this->cache->getReportCache($cache_condition);
						if($dataMultiResult!=false) {
							$cacheTimeExpire = intval($dataMultiResult->cache_time) + $this->config->item('report_cache_expire');
							if($cacheTimeExpire > time()) {
								//缓存有效
								$cacheAvilable = true;
								$multiResult = json_decode($dataMultiResult->cache_content_data);
							}
						}
					}
					if(!$cacheAvilable) {
						$multiResult = $this->statistic->getLongSqlResult('getCountByDate', $sqlArray);
						if($enableReportCache) {
							if($dataMultiResult!=false) {
								$parameter = array(
									'cache_page'		=>	'uses',
									'cache_content_data'=>	json_encode($multiResult),
									'cache_time'		=>	time()
								);
								$this->cache->updateReportCache($parameter, $cache_condition);
							} else {
								$parameter = array(
									'cache_condition'	=>	$cache_condition,
									'cache_page'		=>	'uses',
									'cache_content_data'=>	json_encode($multiResult),
									'cache_time'		=>	time()
								);
								$this->cache->generateReportCache($parameter);
							}
						}
					}
				}
				$sqlArray = Array(
					'year'				=>	$year1,
					'month'				=>	$month1,
					'log_type'			=>	'use',
					'additional_sql'	=>	$additionalSql
				);
				//初始缓存无效状态
				$cacheAvilable = false;
				//缓存开启
				if($enableReportCache) {
					//读取缓存
					$cache_condition = md5(json_encode($sqlArray));
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
					$result = $this->statistic->getLongSqlResult('getCountByDate', $sqlArray);
					if($enableReportCache) {
						if($dataResult!=false) {
							$parameter = array(
								'cache_page'		=>	'uses',
								'cache_content_data'=>	json_encode($result),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'uses',
								'cache_content_data'=>	json_encode($result),
								'cache_time'		=>	time()
							);
							$this->cache->generateReportCache($parameter);
						}
					}
				}
				foreach($result as $row) {
					$rowTotal += $row->count;
				}
				$lastPostTime = $this->statistic->getLastPostTime();
				$lastPostTime = date('Y-m-d H:i:s', $lastPostTime->log_time);
			}
		} elseif($reportType=='4') {
			//按年统计
			if(is_numeric($year1)) {
				if(!empty($machineCode)) {
					$additionalSql .= "and `client_cpu_info`='$machineCode'";
				}
				if($productId!='0') {
					$additionalSql .= "and `product_id`='$productId' ";
				}
				if($productVersion!='0') {
					$additionalSql .= "and `product_version`='$productVersion' ";
				}
				if($systemCPU!='0') {
					$additionalSql .= "and `system_cpu`='$systemCPU'";
				}
				if($systemOS!='0') {
					$additionalSql .= "and `system_os`='$systemOS'";
				}
				if($systemVideocard!='0') {
					$additionalSql .= "and `system_videocard`='$systemVideocard'";
				}
				if($isMulti=='1' && is_numeric($year2)) {
					$sqlArray = Array(
						'year'				=>	$year2,
						'log_type'			=>	'use',
						'additional_sql'	=>	$additionalSql
					);
					//初始缓存无效状态
					$cacheAvilable = false;
					//缓存开启
					if($enableReportCache) {
						//读取缓存
						$cache_condition = md5(json_encode($sqlArray));
						$dataMultiResult = $this->cache->getReportCache($cache_condition);
						if($dataMultiResult!=false) {
							$cacheTimeExpire = intval($dataMultiResult->cache_time) + $this->config->item('report_cache_expire');
							if($cacheTimeExpire > time()) {
								//缓存有效
								$cacheAvilable = true;
								$multiResult = json_decode($dataMultiResult->cache_content_data);
							}
						}
					}
					if(!$cacheAvilable) {
						$multiResult = $this->statistic->getLongSqlResult('getCountByMonth', $sqlArray);
						if($enableReportCache) {
							if($dataMultiResult!=false) {
								$parameter = array(
									'cache_page'		=>	'uses',
									'cache_content_data'=>	json_encode($multiResult),
									'cache_time'		=>	time()
								);
								$this->cache->updateReportCache($parameter, $cache_condition);
							} else {
								$parameter = array(
									'cache_condition'	=>	$cache_condition,
									'cache_page'		=>	'uses',
									'cache_content_data'=>	json_encode($multiResult),
									'cache_time'		=>	time()
								);
								$this->cache->generateReportCache($parameter);
							}
						}
					}
				}
				$sqlArray = Array(
					'year'				=>	$year1,
					'log_type'			=>	'use',
					'additional_sql'	=>	$additionalSql
				);
				//初始缓存无效状态
				$cacheAvilable = false;
				//缓存开启
				if($enableReportCache) {
					//读取缓存
					$cache_condition = md5(json_encode($sqlArray));
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
					$result = $this->statistic->getLongSqlResult('getCountByMonth', $sqlArray);
					if($enableReportCache) {
						if($dataResult!=false) {
							$parameter = array(
								'cache_page'		=>	'uses',
								'cache_content_data'=>	json_encode($result),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'uses',
								'cache_content_data'=>	json_encode($result),
								'cache_time'		=>	time()
							);
							$this->cache->generateReportCache($parameter);
						}
					}
				}
				foreach($result as $row) {
					$rowTotal += $row->count;
				}
				$lastPostTime = $this->statistic->getLastPostTime();
				$lastPostTime = date('Y-m-d H:i:s', $lastPostTime->log_time);
			}
		} elseif($reportType=='5') {
			//自定义时间段
			$this->load->helper('date');
			$startTimeStamp = strtotime("{$year3}-{$month3}-{$date3} 00:00:00");
			$endTimeStamp = strtotime("{$year4}-{$month4}-{$date4} 23:59:59");
			$data = getTimeProgress($startTimeStamp, $endTimeStamp);
			$result = array();
			
			$parameter['log_time_start'] = $startTimeStamp;
			$parameter['log_time_end'] = $endTimeStamp;
			
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
							$currentDate = date('n-j', $row->log_time);
							$data[$currentDate] += 1;
						}
					}
				}
				if($enableReportCache) {
					if($dataResult!=false) {
						$parameter = array(
							'cache_page'		=>	'uses',
							'cache_content_data'=>	json_encode($data),
							'cache_time'		=>	time()
						);
						$this->cache->updateReportCache($parameter, $cache_condition);
					} else {
						$parameter = array(
							'cache_condition'	=>	$cache_condition,
							'cache_page'		=>	'uses',
							'cache_content_data'=>	json_encode($data),
							'cache_time'		=>	time()
						);
						$this->cache->generateReportCache($parameter);
					}
				}
			}
			foreach($data as $key=>$value) {
				if($cacheAvilable) {
					$rowTotal += intval($value);
				}
				array_push($result, array(
					'date'	=>	$key,
					'count'	=>	$value
				));
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