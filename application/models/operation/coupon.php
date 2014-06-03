<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Coupon extends CI_Model {
	private $tableName = 'sys_coupons';
	private $comdb = null;
	public function __construct() {
		parent::__construct();
		$this->comdb = $this->load->database('comdb', TRUE);
	}
	
	public function getTotal() {
		$this->comdb->from($this->tableName);
		return $this->comdb->count_all_results();
	}
	
	public function getAllResult($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['coupon_content'])) {
			$this->comdb->where('coupon_content', $parameter['coupon_content']);
		}
		if(!empty($parameter['coupon_type'])) {
			$this->comdb->where('coupon_type', $parameter['coupon_type']);
		}
		if($parameter['coupon_disabled']===0 || $parameter['coupon_disabled']==='0' || $parameter['coupon_disabled']===1 || $parameter['coupon_disabled']==='1') {
			$this->comdb->where('coupon_disabled', $parameter['coupon_disabled']);
		}
		$this->comdb->order_by('coupon_id', 'desc');
		if($limit==0 && $offset==0) {
			$query = $this->comdb->get($this->tableName);
		} else {
			$query = $this->comdb->get($this->tableName, $limit, $offset);
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
			$this->comdb->where('coupon_id', $id);
			$query = $this->comdb->get($this->tableName);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		}
	}
	
	public function insert($row) {
		if(!empty($row)) {
			return $this->comdb->insert($this->tableName, $row);
		} else {
			return false;
		}
	}

	public function update($row, $id) {
		if(!empty($row)) {
			$this->comdb->where('coupon_id', $id);
			return $this->comdb->update($this->tableName, $row);
		} else {
			return false;
		}
	}
	
	public function delete($id) {
		if(is_numeric($id)) {
			$this->comdb->where('coupon_id', $id);
			return $this->comdb->delete($this->tableName);
		} else {
			return false;
		}
	}
}
?>