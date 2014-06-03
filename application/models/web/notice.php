<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notice extends CI_Model {
	private $tableName = 'scc_private_notice';
	private $viewName = 'scc_notice_sender';
	public function __construct() {
		parent::__construct();
	}
	
	public function getTotal() {
		$sql = "select count(*) as count from scc_private_notice";
		$query = $this->db->query($sql);
		$row = $query->row();
		if(!empty($row->count)) {
			return $row->count;
		} else {
			return 0;
		}
	}
	
	public function getRecieveTotal($reciever) {
		if(!empty($reciever)) {
			$this->db->from($this->tableName);
			$currentTime = time();
			$whereStatement = "(notice_reciever_id='{$reciever}' OR notice_reciever_id='all') AND notice_endtime>{$currentTime} AND notice_visible=1";
			$this->db->where($whereStatement);
			$count = $this->db->count_all_results();
			return $count;
		} else {
			return 0;
		}
	}
	
	public function getAllResult($limit = 0, $offset = 0, $type = 'data') {
		$this->db->order_by('notice_id', 'desc');
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
	
	public function getRecieveResult($reciever, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($reciever)) {
			$currentTime = time();
			$whereStatement = "(notice_reciever_id='{$reciever}' OR notice_reciever_id='all') AND notice_endtime>{$currentTime} AND notice_visible=1";
			$this->db->where($whereStatement);
			$this->db->order_by('notice_id', 'desc');
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
		} else {
			return false;
		}
	}
	
	public function getSendResult($sender, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($sender)) {
			$this->db->where('notice_sender_id', $sender);
			$this->db->order_by('notice_id', 'desc');
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
		} else {
			return false;
		}
	}
	
	public function get($id) {
		if(is_numeric($id)) {
			$this->db->where('notice_id', $id);
			$query = $this->db->get($this->tableName);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		}
	}
	
	public function visible($id, $flag = true) {
		if(is_numeric($id)) {
			if($flag) {
				$parameter = array(
					'notice_visible'	=>	1
				);
			} else {
				$parameter = array(
					'notice_visible'	=>	0
				);
			}
			$this->db->where('notice_id', $id);
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
			$this->db->where('notice_id', $id);
			return $this->db->update($this->tableName, $row);
		} else {
			return false;
		}
	}
	
	public function delete($id) {
		if(is_numeric($id)) {
			$this->db->where('notice_id', $id);
			return $this->db->delete($this->tableName);
		} else {
			return false;
		}
	}
}
?>