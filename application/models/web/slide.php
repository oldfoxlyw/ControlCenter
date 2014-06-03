<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Slide extends CI_Model {
	private $tableName = 'scc_slide';
	private $viewName = 'scc_slides_view';
	private $webId = null;
	
	public function __construct() {
		parent::__construct();
	}
	
	public function __init($webId) {
		$this->webId = $webId;
	}
	
	public function getTotal() {
		$sql = "select count(*) as count from scc_slide";
		$query = $this->db->query($sql);
		$row = $query->row();
		if(!empty($row->count)) {
			return $row->count;
		} else {
			return 0;
		}
	}
	
	public function getAllResult($limit = 0, $offset = 0, $type = 'data') {
		$this->db->where('web_id', $this->webId);
		$this->db->order_by('slide_id', 'desc');
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
			$this->db->where('slide_id', $id);
			$query = $this->db->get($this->tableName);
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
			$this->db->where('slide_id', $id);
			return $this->db->update($this->tableName, $row);
		} else {
			return false;
		}
	}
	
	public function delete($id) {
		if(is_numeric($id)) {
			$this->db->where('slide_id', $id);
			return $this->db->delete($this->tableName);
		} else {
			return false;
		}
	}
}
?>