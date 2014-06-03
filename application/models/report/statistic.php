<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Statistic extends CI_Model {
	private $tableName = 'log_client_statistic';
	private $viewName = 'log_statistic_view';
	private $cacheAllName = 'log_cache_all';
	private $cacheMachineName = 'log_cache_machinecode';
	private $cacheProductName = 'log_cache_product_use';
	private $cacheBuylinkName = 'log_cache_buylink';
	private $logdb = null;
	
	public function __construct() {
		parent::__construct();
		$this->logdb = $this->load->database('logdb', true);
	}
	
	public function query($sql) {
		if(!empty($sql)) {
			$query = $this->logdb->query($sql);
			if($query->num_rows() > 0) {
				return $query->result();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function getCacheResult($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['product_id'])) {
			$this->logdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->logdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['log_time_start']) && !empty($parameter['log_time_end'])) {
			$this->logdb->where('cache_time >=', $parameter['log_time_start']);
			$this->logdb->where('cache_time <=', $parameter['log_time_end']);
		}
		if($limit==0 && $offset==0) {
			$query = $this->logdb->get($this->cacheAllName);
		} else {
			$query = $this->logdb->get($this->cacheAllName, $limit, $offset);
		}
		if($query->num_rows() > 0) {
			if($type=='data') {
				return $query->result();
			} elseif($type=='json') {
				
			}
		} else {
			return false;
		}
	}
	
	public function getLastPostTime($parameter = null) {
		$this->logdb->select('log_time');
		if(!empty($parameter['log_type'])) {
			$this->logdb->where('log_type', $parameter['log_type']);
		}
		if(!empty($parameter['log_time_start']) && !empty($parameter['log_time_end'])) {
			if(intval($parameter['log_time_start']) < intval($parameter['log_time_end'])) {
				$this->logdb->where('log_time >', $parameter['log_time_start']);
				$this->logdb->where('log_time <', $parameter['log_time_end']);
			}
		}
		if(!empty($parameter['client_cpu_info'])) {
			$this->logdb->where('client_cpu_info', $parameter['client_cpu_info']);
		}
		if(!empty($parameter['product_id'])) {
			$this->logdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->logdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['system_cpu'])) {
			$this->logdb->where('system_cpu', $parameter['system_cpu']);
		}
		if(!empty($parameter['system_os'])) {
			$this->logdb->where('system_os', $parameter['system_os']);
		}
		if(!empty($parameter['system_videocard'])) {
			$this->logdb->where('system_videocard', $parameter['system_videocard']);
		}
		$this->logdb->order_by('log_time', 'desc');
		$this->logdb->limit(1);
		$query = $this->logdb->get($this->tableName);
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
	
	public function getCacheAllTotal($parameter = null) {
		if(!empty($parameter['type'])) {
			switch($parameter['type']) {
				case 'install':
					$this->logdb->select_sum('install_total');
					break;
				case 'uninstall':
					$this->logdb->select_sum('uninstall_total');
					break;
				case 'use':
					$this->logdb->select_sum('use_total');
					break;
				default:
					$this->logdb->select_sum('install_total');
					$this->logdb->select_sum('uninstall_total');
					$this->logdb->select_sum('use_total');
			}
		} else {
			$this->logdb->select_sum('install_total');
			$this->logdb->select_sum('uninstall_total');
			$this->logdb->select_sum('use_total');
		}
		if(!empty($parameter['product_id'])) {
			$this->logdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->logdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['cache_time_start']) && !empty($parameter['cache_time_end'])) {
			$this->logdb->where('cache_time >', $parameter['cache_time_start']);
			$this->logdb->where('cache_time <', $parameter['cache_time_end']);
		}
		$query = $this->logdb->get($this->cacheAllName);
		return $query->row();
	}
	
	public function getCacheCpuTotal($parameter = null) {
		if(!empty($parameter['type'])) {
			switch($parameter['type']) {
				case 'install':
					$this->logdb->select_sum('install_total');
					break;
				case 'uninstall':
					$this->logdb->select_sum('uninstall_total');
					break;
				case 'use':
					$this->logdb->select_sum('use_total');
					break;
				default:
					$this->logdb->select_sum('install_total');
					$this->logdb->select_sum('uninstall_total');
					$this->logdb->select_sum('use_total');
			}
		} else {
			$this->logdb->select_sum('install_total');
			$this->logdb->select_sum('uninstall_total');
			$this->logdb->select_sum('use_total');
		}
		if(!empty($parameter['product_id'])) {
			$this->logdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->logdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['cache_time_start']) && !empty($parameter['cache_time_end'])) {
			$this->logdb->where('cache_time >', $parameter['cache_time_start']);
			$this->logdb->where('cache_time <', $parameter['cache_time_end']);
		}
		$query = $this->logdb->get($this->cacheMachineName);
		return $query->row();
	}

	public function getCacheProductTotal($parameter = null) {
		if(!empty($parameter['type'])) {
			switch(!empty($parameter['type'])) {
				case 'actived':
					$this->logdb->select_sum('actived_use_total');
					break;
				case 'diactived':
					$this->logdb->select_sum('diactived_use_total');
					break;
				default:
					$this->logdb->select_sum('actived_use_total');
					$this->logdb->select_sum('diactived_use_total');
			}
		} else {
			$this->logdb->select_sum('actived_use_total');
			$this->logdb->select_sum('diactived_use_total');
		}
		if(!empty($parameter['product_id'])) {
			$this->logdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->logdb->where('product_version', $parameter['product_version']);
		}
		$query = $this->logdb->get($this->cacheProductName);
		return $query->row();
	}
	
	public function getCacheBuylinkTotal($parameter = null) {
		if(!empty($parameter['type'])) {
			switch($parameter['type']) {
				case 'firstbuy':
					$this->logdb->select_sum('firstbuy_total');
					break;
				case 'clickbuy':
					$this->logdb->select_sum('clickbuy_total');
					break;
				default:
					$this->logdb->select_sum('firstbuy_total');
					$this->logdb->select_sum('clickbuy_total');
			}
		} else {
			$this->logdb->select_sum('firstbuy_total');
			$this->logdb->select_sum('clickbuy_total');
		}
		if(!empty($parameter['product_id'])) {
			$this->logdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->logdb->where('product_version', $parameter['product_version']);
		}
		$query = $this->logdb->get($this->cacheBuylinkName);
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
	
	public function getTotal($parameter = null) {
		if(!empty($parameter['log_type'])) {
			$this->logdb->where('log_type', $parameter['log_type']);
		}
		if(!empty($parameter['log_time_start']) && !empty($parameter['log_time_end'])) {
			if(intval($parameter['log_time_start']) < intval($parameter['log_time_end'])) {
				$this->logdb->where('log_time >', $parameter['log_time_start']);
				$this->logdb->where('log_time <', $parameter['log_time_end']);
			}
		}
		if(!empty($parameter['client_cpu_info'])) {
			$this->logdb->where('client_cpu_info', $parameter['client_cpu_info']);
		}
		if(!empty($parameter['product_id'])) {
			$this->logdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->logdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['system_cpu'])) {
			$this->logdb->where('system_cpu', $parameter['system_cpu']);
		}
		if(!empty($parameter['system_os'])) {
			$this->logdb->where('system_os', $parameter['system_os']);
		}
		if(!empty($parameter['system_videocard'])) {
			$this->logdb->where('system_videocard', $parameter['system_videocard']);
		}
		return $this->logdb->count_all_results($this->viewName);
	}
	
	public function getAllResult($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['log_type'])) {
			$this->logdb->where('log_type', $parameter['log_type']);
		}
		if(!empty($parameter['log_time_start']) && !empty($parameter['log_time_end'])) {
			if(intval($parameter['log_time_start']) < intval($parameter['log_time_end'])) {
				$this->logdb->where('log_time >', $parameter['log_time_start']);
				$this->logdb->where('log_time <', $parameter['log_time_end']);
			}
		}
		if(!empty($parameter['client_cpu_info'])) {
			$this->logdb->where('client_cpu_info', $parameter['client_cpu_info']);
		}
		if(!empty($parameter['product_id'])) {
			$this->logdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->logdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['system_cpu'])) {
			$this->logdb->where('system_cpu', $parameter['system_cpu']);
		}
		if(!empty($parameter['system_os'])) {
			$this->logdb->where('system_os', $parameter['system_os']);
		}
		if(!empty($parameter['system_videocard'])) {
			$this->logdb->where('system_videocard', $parameter['system_videocard']);
		}
		if(!empty($parameter['distinct'])) {
			$this->logdb->select($parameter['distinct']);
			$this->logdb->distinct();
		}
		if(!empty($parameter['where'])) {
			$this->logdb->where($parameter['where']);
		}
		if(!empty($parameter['group_by'])) {
			$this->logdb->group_by($parameter['group_by']);
		}
		if(!empty($parameter['count'])) {
			$this->logdb->select($parameter['count']);
		}
		if(!empty($parameter['order_by'])) {
			$this->logdb->order_by($parameter['order_by'][0], $parameter['order_by'][1]);
		} else {
			$this->logdb->order_by('log_time', 'desc');
		}
		if($limit==0 && $offset==0) {
			$query = $this->logdb->get($this->viewName);
		} else {
			$query = $this->logdb->get($this->viewName, $limit, $offset);
		}
		if($query->num_rows() > 0) {
			if($type=='data') {
				return $query->result();
			} elseif($type=='json') {
				
			}
		} else {
			return false;
		}
	}
	
	public function getLongSqlResult($longSqlName, $parameter = null) {
		if(!empty($longSqlName)) {
			$long_sql = $this->config->item('long_sql');
			$sqlContent = $long_sql['log'][$longSqlName];
			if(!empty($sqlContent)) {
				$this->load->helper('template');
				$sqlContent = parseTemplate($sqlContent, $parameter);
				$query = $this->logdb->query($sqlContent);
				return $query->result();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function insert($parameter) {
		if(!empty($parameter)) {
			return $this->logdb->insert($this->tableName, $parameter);
		} else {
			return false;
		}
	}
}
?>