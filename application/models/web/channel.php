<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Channel extends CI_Model {
	private $tableName = 'scc_channels';
	private $webId = null;
	
	public function __construct() {
		parent::__construct();
	}
	
	public function __init($webId) {
		$this->webId = $webId;
	}
	
	public function getTotal() {
		$sql = "select count(*) as count from scc_channels";
		$query = $this->db->query($sql);
		$row = $query->row();
		if(!empty($row->count)) {
			return $row->count;
		} else {
			return 0;
		}
	}

	public function getAllResult($webId = 0, $type = 'data') {
		if($webId === 0) {
			$this->db->where('channel_web_id', $this->webId);
		} elseif(is_numeric($webId) && $webId > 0) {
			$this->db->where('channel_web_id', $webId);
		}
		$this->db->order_by('channel_id');
		$query = $this->db->get($this->tableName);
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
			$this->db->where('channel_id', $id);
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
			$this->db->where('channel_id', $id);
			return $this->db->update($this->tableName, $row);
		} else {
			return false;
		}
	}

	public function delete($id) {
		if(is_numeric($id)) {
			$this->db->where('channel_id', $id);
			return $this->db->delete($this->tableName);
		} else {
			return false;
		}
	}
}
?>