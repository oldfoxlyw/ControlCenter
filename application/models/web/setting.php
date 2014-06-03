<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Model {
	private $tableName = 'scc_config';
	
	public function __construct() {
		parent::__construct();
	}

	public function getTotal() {
		$this->db->from($this->tableName);
		return $this->db->count_all_results();
	}
	
	public function getAllResult($limit, $offset, $type = 'data') {
		$this->db->order_by('config_id', 'desc');
		$query = $this->db->get($this->tableName, $limit, $offset);
		if($query->num_rows() > 0) {
			if($type=='data') {
				return $query->result();
			} elseif($type=='json') {
				
			}
		} else {
			return false;
		}
	}
	
	public function get($id) {
		if(is_numeric($id)) {
			$this->db->where('config_id', $id);
			$query = $this->db->get($this->tableName);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function insert($row) {
		if(!empty($row)) {
			return $this->db->insert($this->tableName, $row);
		} else {
			return false;
		}
	}

	public function update($row, $id) {
		if(!empty($row)) {
			$this->db->where('config_id', $id);
			return $this->db->update($this->tableName, $row);
		} else {
			return false;
		}
	}

	public function select($id, $flag = true) {
		if(is_numeric($id)) {
			if($flag) {
				$parameter = array(
					'config_selected'	=>	1
				);
			} else {
				$parameter = array(
					'config_selected'	=>	0
				);
			}
			$this->db->where('config_id', $id);
			return $this->db->update($this->tableName, $parameter);
		} else {
			return false;
		}
	}
	
	public function disabled() {
		$parameter = array(
			'config_selected'	=>	0
		);
		return $this->db->update($this->tableName, $parameter);
	}
	
	public function delete($id) {
		if(is_numeric($id)) {
			$this->db->where('config_id', $id);
			return $this->db->delete($this->tableName);
		} else {
			return false;
		}
	}
}
?>