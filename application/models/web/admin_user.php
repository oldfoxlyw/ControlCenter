<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_user extends CI_Model {
	private $tableName = 'scc_user';
	private $viewName = 'scc_user_permission';
	public function __construct() {
		parent::__construct();
	}
	
	public function validate($userName, $userPass) {
		$this->load->helper('security');
		$userName = $this->db->escape($userName);
		$userPass = $this->db->escape(strtoupper(do_hash($userPass, 'md5')));
		$sql = "select `user_name`, `user_pass` from `scc_user` where `user_name`={$userName} and `user_pass`={$userPass}";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function freezed($param) {
		if(!empty($param['guid'])) {
			$this->db->where('GUID', $param['guid']);
		} elseif(!empty($param['user_name'])) {
			$this->db->where('user_name', $param['user_name']);
		}
		$query = $this->db->get($this->tableName);
		if($query->num_rows() > 0) {
			$row = $query->row();
			if($row->user_freezed=='1') {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	public function getTotal() {
		$sql = "select count(*) as count from scc_user";
		$query = $this->db->query($sql);
		$row = $query->row();
		if(!empty($row->count)) {
			return $row->count;
		} else {
			return 0;
		}
	}
	
	public function getAllResult($limit = 0, $offset = 0, $type = 'data') {
		if($limit==0 && $offset==0) {
			$query = $this->db->get($this->tableName);
		} else {
			$query = $this->db->get($this->tableName, $limit, $offset);
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
	
	public function getPermissionResult($limit = 0, $offset = 0, $type = 'data') {
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
		if(!empty($id)) {
			$this->db->where('GUID', $id);
			$query = $this->db->get($this->tableName);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		}
	}
	
	public function getPermission($id) {
		if(!empty($id)) {
			$this->db->where('GUID', $id);
			$query = $this->db->get($this->viewName);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		}
	}
	
	public function freeze($id, $flag = true) {
		if(!empty($id)) {
			if($flag) {
				$parameter = array(
					'user_freezed'	=>	1
				);
			} else {
				$parameter = array(
					'user_freezed'	=>	0
				);
			}
			$this->db->where('GUID', $id);
			return $this->db->update($this->tableName, $parameter);
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
			$this->db->where('GUID', $id);
			return $this->db->update($this->tableName, $row);
		} else {
			return false;
		}
	}
	
	public function delete($id) {
		if(!empty($id)) {
			$this->db->where('GUID', $id);
			return $this->db->delete($this->tableName);
		} else {
			return false;
		}
	}
}
?>