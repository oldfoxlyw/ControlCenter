<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blacklist extends CI_Model {
	private $tableName = 'sys_blacklist';
	private $authdb = null;
	
	public function __construct() {
		parent::__construct();
		$this->authdb = $this->load->database('authdb', TRUE);
	}
	public function getTotal() {
		$this->authdb->from($this->tableName);
		return $this->authdb->count_all_results();
	}
	
	public function getAllResult($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['license_content'])) {
			$this->authdb->where('license_content', $parameter['license_content']);
		}
		if(!empty($parameter['client_cpu_info'])) {
			$this->authdb->where('client_cpu_info', $parameter['client_cpu_info']);
		}
		if($parameter['list_actived']===0 || $parameter['list_actived']===1) {
			$this->authdb->where('list_actived', $parameter['list_actived']);
		}
		$this->authdb->order_by('list_id');
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
	
	public function get($id) {
		if(is_numeric($id)) {
			$this->authdb->where('list_id', $id);
			$query = $this->authdb->get($this->tableName);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		}
	}
	
	public function insert($row) {
		if(!empty($row)) {
			return $this->authdb->insert($this->tableName, $row);
		} else {
			return false;
		}
	}
	
	public function update($row, $id) {
		if(!empty($row)) {
			$this->authdb->where('list_id', $id);
			return $this->authdb->update($this->tableName, $row);
		} else {
			return false;
		}
	}
	
	public function active($id, $flag = TRUE) {
		if(is_numeric($id)) {
			$this->authdb->where('list_id', $id);
			if($flag) {
				$parameter = array(
					'list_actived'	=>	1
				);
			} else {
				$parameter = array(
					'list_actived'	=>	0
				);
			}
			return $this->authdb->update($this->tableName, $parameter);
		} else {
			return false;
		}
	}
	
	public function delete($id) {
		if(is_numeric($id)) {
			$this->authdb->where('list_id', $id);
			return $this->authdb->delete($this->tableName);
		} else {
			return false;
		}
	}
}
?>