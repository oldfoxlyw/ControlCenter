<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Web extends CI_Model {
	private $tableName = 'scc_web';
	public function __construct() {
		parent::__construct();
	}
	public function getTotal() {
		$sql = "select count(*) as count from scc_web";
		$query = $this->db->query($sql);
		$row = $query->row();
		if(!empty($row->count)) {
			return $row->count;
		} else {
			return 0;
		}
	}
	
	public function getAllResult() {
		$this->db->order_by('web_id');
		$query = $this->db->get($this->tableName);
		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function get($id) {
		if(is_numeric($id)) {
			$this->db->where('web_id', $id);
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
			$this->db->where('web_id', $id);
			return $this->db->update($this->tableName, $row);
		} else {
			return false;
		}
	}
	
	public function set($id) {
		if(is_numeric($id)) {
			$this->load->helper('cookie');
            $cookie = array(
				'name'		=> 'default_web',
				'value'		=> $id,
				'expire'	=> '31536000',
				'domain'	=> '',
				'path'		=> '/',
				'prefix'	=> 'scc_'
            );
            $this->input->set_cookie($cookie);
		} else {
			return false;
		}
	}
	
	public function delete($id) {
		if(is_numeric($id)) {
			$this->db->where('web_id', $id);
			return $this->db->delete($this->tableName);
		} else {
			return false;
		}
	}
}
?>