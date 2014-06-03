<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Exchange extends CI_Model {
	private $tableName = 'export_record';
	private $authdb = null;
	
	public function __construct() {
		parent::__construct();
		$this->authdb = $this->load->database('authdb', TRUE);
	}
	public function getTotal($parameter = null) {
		if(!empty($parameter['payment_gate'])) {
			$this->authdb->where('payment_gate', $parameter['payment_gate']);
		}
		if(!empty($parameter['order_id'])) {
			$this->authdb->where('order_id', $parameter['order_id']);
		}
		if(!empty($parameter['order_email'])) {
			$this->authdb->where('order_email', $parameter['order_email']);
		}
		if(!empty($parameter['website'])) {
			$this->authdb->where('website', $parameter['website']);
		}
		return $this->authdb->count_all_results($this->tableName);
	}
	
	public function getAllResult($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['payment_gate'])) {
			$this->authdb->where('payment_gate', $parameter['payment_gate']);
		}
		if(!empty($parameter['order_id'])) {
			$this->authdb->where('order_id', $parameter['order_id']);
		}
		if(!empty($parameter['order_email'])) {
			$this->authdb->where('order_email', $parameter['order_email']);
		}
		if(!empty($parameter['website'])) {
			$this->authdb->where('website', $parameter['website']);
		}
		$this->authdb->order_by('id');
		if($limit == 0 && $offset == 0) {
			$query = $this->authdb->get($this->tableName);
		} else {
			$query = $this->authdb->get($this->tableName, $limit, $offset);
		}
		if($query->num_rows() > 0) {
			if($type == 'data') {
				return $query->result();
			} elseif($type == 'json') {
				
			}
		} else {
			return false;
		}
	}
	
	public function get($id) {
		if(is_numeric($id)) {
			$this->authdb->where('list_id', $id);
			$query = $this->authdb->get($this->tableName);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		}
	}
}
?>