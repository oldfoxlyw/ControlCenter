<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Activeds extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'report_actived';
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
		$this->load->model('active', 'active');
		$this->load->model('cache', 'cache');
	}
	
	public function index() {
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
			
			$parameter = array();
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
						$rowTotalMulti = $this->active->getActivedTotal($parameter);
						$itemPerPage = $this->config->item('pagination_data');
						$pageTotalMulti = intval($rowTotalMulti/$itemPerPage);
						if($rowTotalMulti%$itemPerPage) $pageTotalMulti++;
						for($page=1; $page<=$pageTotalMulti; $page++) {
							$offset = $itemPerPage * ($page - 1);
							$resultActive = $this->active->getAllResult($parameter, $itemPerPage, $offset);
							if($resultActive!=false) {
								foreach($resultActive as $row) {
									$currentDate = date('n-j', $row->license_start_time);
									$dataMulti[$currentDate] += 1;
								}
							}
						}
						if($enableReportCache) {
							if($dataMultiResult!=false) {
								$parameter = array(
									'cache_page'		=>	'activeds',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->updateReportCache($parameter, $cache_condition);
							} else {
								$parameter = array(
									'cache_condition'	=>	$cache_condition,
									'cache_page'		=>	'activeds',
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
					$rowTotal = $this->active->getActivedTotal($parameter);
					$itemPerPage = $this->config->item('pagination_data');
					$pageTotal = intval($rowTotal/$itemPerPage);
					if($rowTotal%$itemPerPage) $pageTotal++;
					for($page=1; $page<=$pageTotal; $page++) {
						$offset = $itemPerPage * ($page - 1);
						$resultActive = $this->active->getAllResult($parameter, $itemPerPage, $offset);
						if($resultActive!=false) {
							foreach($resultActive as $row) {
								$currentDate = date('n-j', $row->license_start_time);
								$data[$currentDate] += 1;
								$rowTotal += 1;
							}
						}
					}
					if($enableReportCache) {
						if($dataResult!=false) {
							$parameter = array(
								'cache_page'		=>	'activeds',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'activeds',
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
				$lastPostTime = $this->active->getLastActivedTime($parameter);
				$lastPostTime = date('Y-m-d H:i:s', $lastPostTime->license_start_time);
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
						$rowTotalMulti = $this->active->getActivedTotal($parameter);
						$itemPerPage = $this->config->item('pagination_data');
						$pageTotalMulti = intval($rowTotalMulti/$itemPerPage);
						if($rowTotalMulti%$itemPerPage) $pageTotalMulti++;
						for($page=1; $page<=$pageTotalMulti; $page++) {
							$offset = $itemPerPage * ($page - 1);
							$resultActive = $this->active->getAllResult($parameter, $itemPerPage, $offset);
							if($resultActive!=false) {
								foreach($resultActive as $row) {
									$currentHour = intval(date('G', $row->license_start_time));
									$dataMulti[$currentHour] += 1;
								}
							}
						}
						if($enableReportCache) {
							if($dataMultiResult!=false) {
								$parameter = array(
									'cache_page'		=>	'activeds',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->updateReportCache($parameter, $cache_condition);
							} else {
								$parameter = array(
									'cache_condition'	=>	$cache_condition,
									'cache_page'		=>	'activeds',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->generateReportCache($parameter);
							}
						}
					}
					foreach($dataMulti as $key=>$value) {
						array_push($multiResult, array(
							'date'	=>	strval($key),
							'count'	=>	strval($value)
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
					$rowTotal = $this->active->getActivedTotal($parameter);
					$itemPerPage = $this->config->item('pagination_data');
					$pageTotal = intval($rowTotal/$itemPerPage);
					if($rowTotal%$itemPerPage) $pageTotal++;
					for($page=1; $page<=$pageTotal; $page++) {
						$offset = $itemPerPage * ($page - 1);
						$resultActive = $this->active->getAllResult($parameter, $itemPerPage, $offset);
						if($resultActive!=false) {
							foreach($resultActive as $row) {
								$currentHour = intval(date('G', $row->license_start_time));
								$data[$currentHour] += 1;
								$rowTotal += 1;
							}
						}
					}
					if($enableReportCache) {
						if($dataResult!=false) {
							$parameter = array(
								'cache_page'		=>	'activeds',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'activeds',
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
						'date'	=>	strval($key),
						'count'	=>	strval($value)
					));
				}
				$lastPostTime = $this->active->getLastActivedTime($parameter);
				$lastPostTime = date('Y-m-d H:i:s', $lastPostTime->license_start_time);
			}
		} elseif($reportType=='3') {
			//按月份统计
			if(is_numeric($year1) && is_numeric($month1)) {
				$this->load->helper('date');
				if($isMulti=='1' && is_numeric($year2) && is_numeric($month2)) {
					$dataMulti = getDatesArray($year2, intval($month2));
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
						$rowTotalMulti = $this->active->getActivedTotal($parameter);
						$itemPerPage = $this->config->item('pagination_data');
						$pageTotalMulti = intval($rowTotalMulti/$itemPerPage);
						if($rowTotalMulti%$itemPerPage) $pageTotalMulti++;
						for($page=1; $page<=$pageTotalMulti; $page++) {
							$offset = $itemPerPage * ($page - 1);
							$resultActive = $this->active->getAllResult($parameter, $itemPerPage, $offset);
							if($resultActive!=false) {
								foreach($resultActive as $row) {
									$currentDate = intval(date('j', $row->license_start_time));
									$dataMulti[$currentDate] += 1;
								}
							}
						}
						if($enableReportCache) {
							if($dataMultiResult!=false) {
								$parameter = array(
									'cache_page'		=>	'activeds',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->updateReportCache($parameter, $cache_condition);
							} else {
								$parameter = array(
									'cache_condition'	=>	$cache_condition,
									'cache_page'		=>	'activeds',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->generateReportCache($parameter);
							}
						}
					}
					foreach($dataMulti as $key=>$value) {
						$multiResult[] = array(
							'date'	=>	strval($key),
							'count'	=>	strval($value)
						);
					}
				}
				$data = getDatesArray($year1, intval($month1));
				$result = array();
				$count = strval(days_in_month(intval($month1), $year1));
				$startTimeStamp = strtotime("{$year1}-{$month1}-01 00:00:00");
				$endTimeStamp = strtotime("{$year1}-{$month1}-{$count} 23:59:59");
				
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
					$rowTotal = $this->active->getActivedTotal($parameter);
					$itemPerPage = $this->config->item('pagination_data');
					$pageTotal = intval($rowTotal/$itemPerPage);
					if($rowTotal%$itemPerPage) $pageTotal++;
					for($page=1; $page<=$pageTotal; $page++) {
						$offset = $itemPerPage * ($page - 1);
						$resultActive = $this->active->getAllResult($parameter, $itemPerPage, $offset);
						if($resultActive!=false) {
							foreach($resultActive as $row) {
								$currentDate = intval(date('j', $row->license_start_time));
								$data[$currentDate] += 1;
							}
						}
					}
					if($enableReportCache) {
						if($dataResult!=false) {
							$parameter = array(
								'cache_page'		=>	'activeds',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'activeds',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->generateReportCache($parameter);
						}
					}
				}
				foreach($data as $key=>$value) {
					$result[] = array(
						'date'	=>	strval($key),
						'count'	=>	strval($value)
					);
					$rowTotal += $value;
				}
				$lastPostTime = $this->active->getLastActivedTime($parameter);
				$lastPostTime = date('Y-m-d H:i:s', $lastPostTime->license_start_time);
			}
		} elseif($reportType=='4') {
			//按年统计
			if(is_numeric($year1)) {
				$this->load->helper('date');
				if($isMulti=='1' && is_numeric($year2)) {
					$dataMulti = getMonthsArray();
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
						$rowTotalMulti = $this->active->getActivedTotal($parameter);
						$itemPerPage = $this->config->item('pagination_data');
						$pageTotalMulti = intval($rowTotalMulti/$itemPerPage);
						if($rowTotalMulti%$itemPerPage) $pageTotalMulti++;
						for($page=1; $page<=$pageTotalMulti; $page++) {
							$offset = $itemPerPage * ($page - 1);
							$resultActive = $this->active->getAllResult($parameter, $itemPerPage, $offset);
							if($resultActive!=false) {
								foreach($resultActive as $row) {
									$currentMonth = intval(date('n', $row->license_start_time));
									$dataMulti[$currentMonth] += 1;
								}
							}
						}
						if($enableReportCache) {
							if($dataMultiResult!=false) {
								$parameter = array(
									'cache_page'		=>	'activeds',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->updateReportCache($parameter, $cache_condition);
							} else {
								$parameter = array(
									'cache_condition'	=>	$cache_condition,
									'cache_page'		=>	'activeds',
									'cache_content_data'=>	json_encode($dataMulti),
									'cache_time'		=>	time()
								);
								$this->cache->generateReportCache($parameter);
							}
						}
					}
					foreach($dataMulti as $key=>$value) {
						$multiResult[] = array(
							'date'	=>	strval($key),
							'count'	=>	strval($value)
						);
					}
				}
				$data = getMonthsArray();
				$result = array();
				$startTimeStamp = strtotime("{$year1}-01-01 00:00:00");
				$endTimeStamp = strtotime("{$year1}-12-31 23:59:59");
				
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
					$rowTotal = $this->active->getActivedTotal($parameter);
					$itemPerPage = $this->config->item('pagination_data');
					$pageTotal = intval($rowTotal/$itemPerPage);
					if($rowTotal%$itemPerPage) $pageTotal++;
					for($page=1; $page<=$pageTotal; $page++) {
						$offset = $itemPerPage * ($page - 1);
						$resultActive = $this->active->getAllResult($parameter, $itemPerPage, $offset);
						if($resultActive!=false) {
							foreach($resultActive as $row) {
								$currentMonth = intval(date('n', $row->license_start_time));
								$data[$currentMonth] += 1;
							}
						}
					}
					if($enableReportCache) {
						if($dataResult!=false) {
							$parameter = array(
								'cache_page'		=>	'activeds',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->updateReportCache($parameter, $cache_condition);
						} else {
							$parameter = array(
								'cache_condition'	=>	$cache_condition,
								'cache_page'		=>	'activeds',
								'cache_content_data'=>	json_encode($data),
								'cache_time'		=>	time()
							);
							$this->cache->generateReportCache($parameter);
						}
					}
				}
				foreach($data as $key=>$value) {
					$result[] = array(
						'date'	=>	strval($key),
						'count'	=>	strval($value)
					);
					$rowTotal += $value;
				}
				$lastPostTime = $this->active->getLastActivedTime($parameter);
				$lastPostTime = date('Y-m-d H:i:s', $lastPostTime->license_start_time);
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
				$rowTotal = $this->active->getActivedTotal($parameter);
				$itemPerPage = $this->config->item('pagination_data');
				$pageTotal = intval($rowTotal/$itemPerPage);
				if($rowTotal%$itemPerPage) $pageTotal++;
				for($page=1; $page<=$pageTotal; $page++) {
					$offset = $itemPerPage * ($page - 1);
					$resultActive = $this->active->getAllResult($parameter, $itemPerPage, $offset);
					if($resultActive!=false) {
						foreach($resultActive as $row) {
							$currentDate = date('n-j', $row->license_start_time);
							$data[$currentDate] += 1;
							$rowTotal += 1;
						}
					}
				}
				if($enableReportCache) {
					if($dataResult!=false) {
						$parameter = array(
							'cache_page'		=>	'activeds',
							'cache_content_data'=>	json_encode($data),
							'cache_time'		=>	time()
						);
						$this->cache->updateReportCache($parameter, $cache_condition);
					} else {
						$parameter = array(
							'cache_condition'	=>	$cache_condition,
							'cache_page'		=>	'activeds',
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
			$lastPostTime = $this->active->getLastActivedTime($parameter);
			$lastPostTime = date('Y-m-d H:i:s', $lastPostTime->license_start_time);
		}
		
		if(empty($rowTotal)) $rowTotal = '0';
		if(empty($lastPostTime)) $lastPostTime = '没有数据';
		
		$this->config->load('cache', FALSE, TRUE);
		if($this->config->item('enable_cache')) {
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
			'record_total'		=>	$rowTotal,
			'last_post_time'	=>	$lastPostTime,
			'product_result'	=>	$productResult,
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
			'title'			=>		'SCC后台管理系统 - 激活量统计',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'激活量统计',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
}
?>