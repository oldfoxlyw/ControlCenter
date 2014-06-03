<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Caches extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $root_path = null;
	
	public function __construct() {
		parent::__construct();
		/*
		$this->load->model('functions/check_user', 'check');
		$this->user = $this->check->validate();
		$this->check->ip();
		$record = $this->check->configuration($this->user);
		$this->_CONFIG = $record['record'];
		if(!$record['state']) {
			$redirectUrl = urlencode($this->config->item('root_path') . 'login');
			redirect("/message?info=SCC_CLOSED&redirect={$redirectUrl}");
		}
		*/
		$this->root_path = $this->config->item('root_path');
		$this->load->model('cache', 'cache');
	}
	
	public function rebuidCache($type = 'json') {
		$cacheData = $this->input->get_post('cacheData', TRUE);
		$cacheIndexDataAll = $this->input->get_post('cacheIndexDataAll', TRUE);
		$cacheIndexDataCpu = $this->input->get_post('cacheIndexDataCpu', TRUE);
		$cacheIndexDataProduct = $this->input->get_post('cacheIndexDataProduct', TRUE);
		$cacheTime = $this->input->get_post('cacheTime', TRUE);
		if($cacheTime===FALSE) {
			$cacheTime = time();
		}
		
		$resultIndexData = array();
		
		if($cacheData=='1') {
			$resultData = $this->cache->buildCache();
		}
		if($cacheIndexDataAll=='1') {
			$resultIndexData[] = $this->cache->buildLogCacheAll($cacheTime);
		}
		if($cacheIndexDataCpu=='1') {
			$resultIndexData[] = $this->cache->buildLogCacheCpu($cacheTime);
		}
		if($cacheIndexDataProduct=='1') {
			$resultIndexData[] = $this->cache->buildLogCacheProduct($cacheTime);
		}
		if($type=='json') {
			$data = array(
				'field'	=>	array()
			);
			if($cacheData=='1') {
				if($resultData===false) {
					$data['field'][] = array(
						'result'	=>	'API_CACHE_WRITE_ERROR',
						'message'	=>	'数据缓存写入错误，请确保config/cache.php可写'
					);
				} else {
					$data['field'][] = array(
						'result'	=>	'API_CACHE_SUCCESS',
						'message'	=>	'数据缓存更新完成'
					);
				}
			}
			if(!empty($resultIndexData)) {
				foreach($resultIndexData as $item) {
					$data['field'][] = $item;
				}
			}
			echo json_encode($data);
		}
	}
}
?>