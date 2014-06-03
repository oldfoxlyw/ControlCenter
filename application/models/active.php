<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Active extends CI_Model {
	private $tableName = 'sys_actived';
	private $blackName = 'sys_blacklist';
	private $viewName = 'auth_actived_view';
	private $authdb = null;
	
	public function __construct() {
		parent::__construct();
		$this->authdb = $this->load->database('authdb', true);
	}
	
	public function getLastActivedTime($parameter = null) {
		$this->authdb->select('license_start_time');
		if(!empty($parameter['product_id'])) {
			$this->authdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->authdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['license_content'])) {
			$this->authdb->where('license_content', $parameter['license_content']);
		}
		if(!empty($parameter['client_cpu_info'])) {
			$this->authdb->where('client_cpu_info', $parameter['client_cpu_info']);
		}
		if(!empty($parameter['time_start']) && !empty($parameter['time_end'])) {
			if(intval($parameter['time_start']) < intval($parameter['time_end'])) {
				$this->authdb->where('license_start_time >', $parameter['time_start']);
				$this->authdb->where('license_start_time <', $parameter['time_end']);
			}
		}
		$this->authdb->order_by('license_start_time', 'desc');
		$this->authdb->limit(1);
		$query = $this->authdb->get($this->tableName);
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
	
	public function getActivedTotal($parameter = null) {
		if(!empty($parameter['product_id'])) {
			$this->authdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->authdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['license_content'])) {
			$this->authdb->where('license_content', $parameter['license_content']);
		}
		if(!empty($parameter['client_cpu_info'])) {
			$this->authdb->where('client_cpu_info', $parameter['client_cpu_info']);
		}
		if(!empty($parameter['log_time_start']) && !empty($parameter['log_time_end'])) {
			if(intval($parameter['log_time_start']) < intval($parameter['log_time_end'])) {
				$this->authdb->where('license_start_time >', $parameter['log_time_start']);
				$this->authdb->where('license_start_time <', $parameter['log_time_end']);
			}
		}
		return $this->authdb->count_all_results($this->tableName);
	}
	
	public function getAllResult($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['product_id'])) {
			$this->authdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->authdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['license_content'])) {
			$this->authdb->where('license_content', $parameter['license_content']);
		}
		if(!empty($parameter['client_cpu_info'])) {
			$this->authdb->where('client_cpu_info', $parameter['client_cpu_info']);
		}
		if(!empty($parameter['log_time_start']) && !empty($parameter['log_time_end'])) {
			if(intval($parameter['log_time_start']) < intval($parameter['log_time_end'])) {
				$this->authdb->where('license_start_time >', $parameter['log_time_start']);
				$this->authdb->where('license_end_time <', $parameter['log_time_end']);
			}
		}
		if(!empty($parameter['group_by'])) {
			$this->authdb->group_by($parameter['group_by']);
		}
		
		if($limit == 0 && $offset == 0) {
			$query = $this->authdb->get($this->viewName);
		} else {
			$query = $this->authdb->get($this->viewName, $limit, $offset);
		}
		if($query->num_rows() > 0) {
			if($type == 'data') {
				return $query->result();
			} elseif($type == 'json') {
				
			}
		} else {
			return false;
		}
	}
	
	public function getSmallResult($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['product_id'])) {
			$this->authdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->authdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['license_content'])) {
			$this->authdb->where('license_content', $parameter['license_content']);
		}
		if(!empty($parameter['client_cpu_info'])) {
			$this->authdb->where('client_cpu_info', $parameter['client_cpu_info']);
		}
		if(!empty($parameter['time_start']) && !empty($parameter['time_end'])) {
			if(intval($parameter['time_start']) < intval($parameter['time_end'])) {
				$this->authdb->where('license_start_time >', $parameter['time_start']);
				$this->authdb->where('license_end_time <', $parameter['time_end']);
			}
		}
		if(!empty($parameter['group_by'])) {
			$this->authdb->group_by($parameter['group_by']);
		}
		
		if($limit == 0 && $offset == 0) {
			$query = $this->authdb->get($this->tableName);
		} else {
			$query = $this->authdb->get($this->tableName, $limit, $offset);
		}
		if($query->num_rows() > 0) {
			if($type == 'data') {
				return $query->result();
			} elseif($type == 'json') {
				
			}
		} else {
			return false;
		}
	}
	
	public function addBlockInfo($parameter = null) {
		if(!empty($parameter) && (!empty($parameter['license_content']) || !empty($parameter['client_cpu_info']))) {
			if(!empty($parameter['license_content'])) {
				$this->authdb->where('license_content', $parameter['license_content']);
			}
			if(!empty($parameter['client_cpu_info'])) {
				$this->authdb->where('client_cpu_info', $parameter['client_cpu_info']);
			}
			$query = $this->authdb->get($this->blackName);
			if($query->num_rows() < 1) {
				return $this->authdb->insert($this->blackName, $parameter);
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function removeBlockInfo($parameter = null) {
		if(!empty($parameter) && (!empty($parameter['license_content']) || !empty($parameter['client_cpu_info']))) {
			if(!empty($parameter['license_content'])) {
				$this->authdb->where('license_content', $parameter['license_content']);
			}
			if(!empty($parameter['client_cpu_info'])) {
				$this->authdb->where('client_cpu_info', $parameter['client_cpu_info']);
			}
			return $this->authdb->delete($this->blackName);
		} else {
			return false;
		}
	}
	
	public function addActiveInfo($parameter) {
		if(!empty($parameter)) {
			if(!empty($parameter['license_content']) && !empty($parameter['client_cpu_info']) && !empty($parameter['license_start_time'])
			&& !empty($parameter['license_end_time']) && !empty($parameter['product_id']) && !empty($parameter['product_version'])) {
				return $this->authdb->insert($this->tableName, $parameter);
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
?>