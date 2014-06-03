<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log_survey extends CI_Model {
	private $tableName = 'log_survey';
	private $logdb = null;
	
	public function __construct() {
		parent::__construct();
		$this->logdb = $this->load->database('logdb', true);
	}
	
	public function getLastPostTime($parameter = null) {
		$this->logdb->select('log_time');
		if(!empty($parameter['log_survey_id'])) {
			$this->logdb->where('log_survey_id', $parameter['log_survey_id']);
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
		$this->logdb->order_by('log_time', 'desc');
		$this->logdb->limit(1);
		$query = $this->logdb->get($this->tableName);
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
	
	public function getTotal($parameter = null) {
		if(!empty($parameter['log_survey_id'])) {
			$this->logdb->where('log_survey_id', $parameter['log_survey_id']);
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
		return $this->logdb->count_all_results($this->viewName);
	}
	
	public function getAllResult($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['log_survey_id'])) {
			$this->logdb->where('log_survey_id', $parameter['log_survey_id']);
		}
		if(!empty($parameter['log_time_start']) && !empty($parameter['log_time_end'])) {
			if(intval($parameter['log_time_start']) < intval($parameter['log_time_end'])) {
				$this->logdb->where('log_time >', $parameter['log_time_start']);
				$this->logdb->where('log_time <', $parameter['log_time_end']);
			}
		}
		if(!empty($parameter['product_id'])) {
			$this->logdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->logdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['client_cpu_info'])) {
			$this->logdb->where('client_cpu_info', $parameter['client_cpu_info']);
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
			$query = $this->logdb->get($this->tableName);
		} else {
			$query = $this->logdb->get($this->tableName, $limit, $offset);
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
	
	public function insert($parameter) {
		if(!empty($parameter) && !empty($parameter['log_survey_id']) && !empty($parameter['log_parameter'])) {
			return $this->logdb->insert($this->tableName, $parameter);
		} else {
			return false;
		}
	}
}
?>