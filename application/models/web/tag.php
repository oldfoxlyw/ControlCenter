<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tag extends CI_Model {
	private $tableName = 'scc_tags';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getTotal() {
		$sql = "select count(*) as count from scc_tags";
		$query = $this->db->query($sql);
		$row = $query->row();
		if(!empty($row->count)) {
			return $row->count;
		} else {
			return 0;
		}
	}

	public function getAllResult($limit, $offset, $type = 'data') {
		$this->db->order_by('tag_id', 'desc');
		$query = $this->db->get($this->tableName, $limit, $offset);
		if($query->num_rows() > 0) {
			if($type=='data') {
				return $query->result();
			} elseif($type=='json') {
				$result = $query->result();
				$data = array(
					'field'		=>	array()
				);
				foreach($result as $key=>$row) {
					$data['field'][$key]['id'] = $row->tag_id;
					$data['field'][$key]['name'] = $row->tag_name;
				}
				return json_encode($data);
			}
		} else {
			return false;
		}
	}
	
	public function get($id) {
		if(is_numeric($id)) {
			$this->db->where('tag_id', $id);
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
	
	public function getTagByName($name) {
		if(!empty($name)) {
			$this->db->where('tag_name', $name);
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
			$this->db->where('tag_id', $id);
			return $this->db->update($this->tableName, $row);
		} else {
			return false;
		}
	}

	public function delete($id) {
		if(is_numeric($id)) {
			$this->db->where('tag_id', $id);
			return $this->db->delete($this->tableName);
		} else {
			return false;
		}
	}
}
?>