<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Model {
	private $tableName = 'sys_products';
	private $functionName = 'sys_product_functions';
	private $viewName = 'product_function_view';
	private $productdb = null;
	
	public function __construct() {
		parent::__construct();
		$this->productdb = $this->load->database('productdb', true);
	}
	
	public function getTotal($parameter = null) {
		if(!empty($parameter['product_id'])) {
			$this->productdb->where('product_id', $parameter['product_id']);
		}
		$this->productdb->count_all_results($this->tableName);
	}
	
	public function getAllResult($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['product_id'])) {
			$this->productdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->productdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['product_access_token'])) {
			$this->productdb->where('product_access_token', $parameter['product_access_token']);
		}
		if($parameter['product_index_show']===0 || $parameter['product_index_show']===1) {
			$this->productdb->where('product_index_show', $parameter['product_index_show']);
		}
		if(!empty($parameter['distinct'])) {
			$this->productdb->select($parameter['distinct']);
			$this->productdb->distinct();
		}
		if(!empty($parameter['group_by'])) {
			$this->productdb->group_by($parameter['group_by']);
		}
		if(!empty($parameter['limit'])) {
			$this->productdb->limit($parameter['limit']);
		}
		if(!empty($parameter['order_by'])) {
			$this->productdb->order_by($parameter['order_by'][0], $parameter['order_by'][1]);
		}
		if($limit == 0 && $offset == 0) {
			$query = $this->productdb->get($this->tableName);
		} else {
			$query = $this->productdb->get($this->tableName, $limit, $offset);
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
			$this->productdb->where('PID', $id);
			$query = $this->productdb->get($this->tableName);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		}
	}
	
	public function getFunctionTotal($parameter = null) {
		if(!empty($parameter['product_id'])) {
			$this->productdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->productdb->where('product_version', $parameter['product_version']);
		}
		$this->productdb->count_all_results($this->functionName);
	}
	
	public function getFunctions($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['func_id'])) {
			$this->productdb->where('func_id', $parameter['func_id']);
		}
		if(!empty($parameter['product_id'])) {
			$this->productdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->productdb->where('product_version', $parameter['product_version']);
		}
		if($limit == 0 && $offset == 0) {
			$query = $this->productdb->get($this->viewName);
		} else {
			$query = $this->productdb->get($this->viewName, $limit, $offset);
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
	
	public function getProductName($product_id) {
		if(!empty($product_id)) {
			$this->productdb->where('product_id', $product_id);
		}
		$this->productdb->limit(1);
		$query = $this->productdb->get($this->tableName);
		if($query->num_rows() > 0) {
			$result = $query->result();
			return $result[0];
		} else {
			return false;
		}
	}
	
	public function insert($parameter) {
		if(!empty($parameter) && !empty($parameter['product_id']) && !empty($parameter['product_version']) &&
		!empty($parameter['product_type']) && !empty($parameter['product_web'])) {
			return $this->productdb->insert($this->tableName, $parameter);
		} else {
			return false;
		}
	}
	
	public function update($parameter, $id) {
		if(!empty($parameter)) {
			if(is_numeric($id)) {
				$this->productdb->where('PID', $id);
			} else {
				$this->productdb->where('product_id', $id);
			}
			return $this->productdb->update($this->tableName, $parameter);
		} else {
			return false;
		}
	}
	
	public function delete($id) {
		if(is_numeric($id)) {
			$this->productdb->where('PID', $id);
			return $this->productdb->delete($this->tableName);
		} else {
			return false;
		}
	}
	
	public function insertFunction($parameter) {
		if(!empty($parameter) && !empty($parameter['func_name'])) {
			return $this->productdb->insert($this->functionName, $parameter);
		} else {
			return false;
		}
	}
	
	public function updateFunction($parameter, $id) {
		if(!empty($parameter) && !empty($parameter['func_name'])) {
			$this->productdb->where('func_id', $id);
			return $this->productdb->update($this->functionName, $parameter);
		} else {
			return false;
		}
	}
	
	public function deleteFunction($id) {
		if(is_numeric($id)) {
			$this->productdb->where('func_id', $id);
			return $this->productdb->delete($this->functionName);
		} else {
			return false;
		}
	}
}
?>