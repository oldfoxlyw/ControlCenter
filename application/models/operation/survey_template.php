<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Survey_template extends CI_Model {
	private $tableName = 'sys_survey_template';
	private $viewName = 'survey_template_view';
	private $productdb = null;
	
	public function __construct() {
		parent::__construct();
		$this->productdb = $this->load->database('productdb', TRUE);
	}
	
	public function getTotal() {
		$this->productdb->from($this->tableName);
		return $this->productdb->count_all_results();
	}
	
	public function getAllResult($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['survey_id'])) {
			$this->productdb->where('survey_id', $parameter['survey_id']);
		}
		$this->productdb->order_by('template_id', 'desc');
		if($limit==0 && $offset==0) {
			$query = $this->productdb->get($this->viewName);
		} else {
			$query = $this->productdb->get($this->viewName, $limit, $offset);
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
			$this->productdb->where('template_id', $id);
			$query = $this->productdb->get($this->tableName);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		}
	}
	
	public function insert($row) {
		if(!empty($row)) {
			return $this->productdb->insert($this->tableName, $row);
		} else {
			return false;
		}
	}

	public function update($row, $id) {
		if(!empty($row)) {
			$this->productdb->where('template_id', $id);
			return $this->productdb->update($this->tableName, $row);
		} else {
			return false;
		}
	}
	
	public function delete($id) {
		if(is_numeric($id)) {
			$this->productdb->where('template_id', $id);
			return $this->productdb->delete($this->tableName);
		} else {
			return false;
		}
	}
}
?>