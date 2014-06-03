<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class License extends CI_Model {
	private $tableName = 'log_auth';
	private $licenseName = 'sys_licenses';
	private $authdb = null;
	private $logdb = null;
	
	public function __construct() {
		parent::__construct();
		$this->logdb = $this->load->database('logdb', TRUE);
		$this->authdb = $this->load->database('authdb', TRUE);
	}
	
	public function getLicenseTotal($parameter = null) {
		if(!empty($parameter['license_type'])) {
			$this->authdb->where('license_type', $parameter['license_type']);
		}
		if(!empty($parameter['product_id'])) {
			$this->authdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->authdb->where('product_version', $parameter['product_version']);
		}
		return $this->authdb->count_all_results($this->licenseName);
	}
	
	public function getTotal($parameter = null) {
		if(!empty($parameter['log_type'])) {
			$this->logdb->where('log_type', $parameter['log_type']);
		}
		if(!empty($parameter['client_cpu_info'])) {
			$this->logdb->where('client_cpu_info', $parameter['client_cpu_info']);
		}
		if(!empty($parameter['license_content'])) {
			$this->logdb->where('license_content', $parameter['license_content']);
		}
		if(!empty($parameter['product_id'])) {
			$this->logdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->logdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['start_time']) && !empty($parameter['end_time'])) {
			if(intval($parameter['start_time']) < intval($parameter['end_time'])) {
				$this->logdb->where('log_time >', date('Y-m-d H:i:s', intval($parameter['start_time'])));
				$this->logdb->where('log_time <', date('Y-m-d H:i:s', intval($parameter['end_time'])));
			}
		}
		return $this->logdb->count_all_results($this->tableName);
	}
	
	public function getAllResult($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['log_type'])) {
			$this->logdb->where('log_type', $parameter['log_type']);
		}
		if(!empty($parameter['client_cpu_info'])) {
			$this->logdb->where('client_cpu_info', $parameter['client_cpu_info']);
		}
		if(!empty($parameter['license_content'])) {
			$this->logdb->where('license_content', $parameter['license_content']);
		}
		if(!empty($parameter['product_id'])) {
			$this->logdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->logdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['start_time']) && !empty($parameter['end_time'])) {
			if(intval($parameter['start_time']) < intval($parameter['end_time'])) {
				$this->logdb->where('log_time >', date('Y-m-d H:i:s', intval($parameter['start_time'])));
				$this->logdb->where('log_time <', date('Y-m-d H:i:s', intval($parameter['end_time'])));
			}
		}
		if(!empty($parameter['select'])) {
			$this->logdb->select($parameter['select']);
		}
		if(!empty($parameter['order_by'])) {
			$this->logdb->order_by($parameter['order_by'][0], $parameter['order_by'][1]);
		}
		if(!empty($parameter['group_by'])) {
			$this->logdb->group_by($parameter['group_by']);
		}
		if(!empty($parameter['limit'])) {
			$this->logdb->limit($parameter['limit']);
		}
		if($limit == 0 && $offset == 0) {
			$query = $this->logdb->get($this->tableName);
		} else {
			$query = $this->logdb->get($this->tableName, $limit, $offset);
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
	
	public function getLicenseResult($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['license_content'])) {
			$this->authdb->where('license_content', $parameter['license_content']);
		}
		if(!empty($parameter['license_type'])) {
			$this->authdb->where('license_type', $parameter['license_type']);
		}
		if(!empty($parameter['product_id'])) {
			$this->authdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->authdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['order_by'])) {
			$this->authdb->order_by($parameter['order_by'][0], $parameter['order_by'][1]);
		}
		if(!empty($parameter['group_by'])) {
			$this->authdb->group_by($parameter['group_by']);
		}
		if(!empty($parameter['limit'])) {
			$this->authdb->limit($parameter['limit']);
		}
		if($limit == 0 && $offset == 0) {
			$query = $this->authdb->get($this->licenseName);
		} else {
			$query = $this->authdb->get($this->licenseName, $limit, $offset);
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
	
	public function get($id) {
		if(is_numeric($id)) {
			$this->authdb->where('license_id', $id);
			$query = $this->authdb->get($this->licenseName);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		}
	}
	
	public function insert($parameter) {
		if(!empty($parameter) && !empty($parameter['license_content']) && !empty($parameter['license_type'])) {
			return $this->authdb->insert($this->licenseName, $parameter);
		} else {
			return false;
		}
	}
	
	public function update($parameter, $id) {
		if(!empty($parameter) && !empty($parameter['license_content']) && !empty($parameter['license_type'])) {
			$this->authdb->where('license_id', $id);
			return $this->authdb->update($this->licenseName, $parameter);
		} else {
			return false;
		}
	}
	
	public function delete($id) {
		if(is_numeric($id)) {
			$this->authdb->where('license_id', $id);
			return $this->authdb->delete($this->licenseName);
		} else {
			return false;
		}
	}
}
?>