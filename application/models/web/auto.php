<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auto extends CI_Model {
	private $tableName = 'scc_mail_autosend';
	private $viewName = 'scc_auto_template';
	public function __construct() {
		parent::__construct();
	}
	
	public function getTotal() {
		$sql = "select count(*) as count from scc_mail_autosend";
		$query = $this->db->query($sql);
		$row = $query->row();
		if(!empty($row->count)) {
			return $row->count;
		} else {
			return 0;
		}
	}
	
	public function getAllResult($limit = 0, $offset = 0, $type = 'data') {
		$this->db->order_by('auto_id', 'desc');
		if($limit==0 && $offset==0) {
			$query = $this->db->get($this->viewName);
		} else {
			$query = $this->db->get($this->viewName, $limit, $offset);
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
	
	public function get($id) {
		if(is_numeric($id)) {
			$this->db->where('auto_id', $id);
			$query = $this->db->get($this->viewName);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
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
			$this->db->where('auto_id', $id);
			return $this->db->update($this->tableName, $row);
		} else {
			return false;
		}
	}
	
	public function delete($id) {
		if(is_numeric($id)) {
			$this->db->where('auto_id', $id);
			return $this->db->delete($this->tableName);
		} else {
			return false;
		}
	}
}
?>