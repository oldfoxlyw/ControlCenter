<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Model {
	private $tableName = 'web_accounts';
	private $accountdb = null;
	
	public function __construct() {
		parent::__construct();
		$this->accountdb = $this->load->database('accountdb', true);
	}
	
	public function update() {
		$query = $this->accountdb->get($this->tableName);
		foreach($query->result() as $row) {
			$time = date('Y-m-d H:i:s', $row->account_regtime);
			$parameter = array(
				'account_reglocaltime'	=>	$time
			);
			$this->accountdb->where('GUID', $row->GUID);
			$this->accountdb->update($this->tableName, $parameter);
		}
	}
	
	public function getLastPostTime($parameter = null) {
		$this->accountdb->select('account_regtime');
		$this->accountdb->order_by('account_regtime', 'desc');
		$this->accountdb->limit(1);
		$query = $this->accountdb->get($this->tableName);
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
	
	public function getTotal($parameter = null) {
		if(!empty($parameter['account_regtime_start']) && !empty($parameter['account_regtime_end'])) {
			if(intval($parameter['account_regtime_start']) < intval($parameter['account_regtime_end'])) {
				$this->accountdb->where('account_regtime >', $parameter['account_regtime_start']);
				$this->accountdb->where('account_regtime <', $parameter['account_regtime_end']);
			}
		}
		return $this->accountdb->count_all_results($this->tableName);
	}
	
	public function getAllResult($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['account_mail'])) {
			$this->accountdb->where('account_mail', $parameter['account_mail']);
		}
		if(!empty($parameter['account_regtime_start']) && !empty($parameter['account_regtime_end'])) {
			if(intval($parameter['account_regtime_start']) < intval($parameter['account_regtime_end'])) {
				$this->accountdb->where('account_regtime >', $parameter['account_regtime_start']);
				$this->accountdb->where('account_regtime <', $parameter['account_regtime_end']);
			}
		}
		$this->accountdb->order_by('account_regtime', 'desc');
		if($limit == 0 && $offset == 0) {
			$query = $this->accountdb->get($this->tableName);
		} else {
			$query = $this->accountdb->get($this->tableName, $limit, $offset);
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
	
	public function getLongSqlResult($longSqlName, $parameter = null) {
		if(!empty($longSqlName)) {
			$long_sql = $this->config->item('long_sql');
			$sqlContent = $long_sql['account'][$longSqlName];
			if(!empty($sqlContent)) {
				$this->load->helper('template');
				$sqlContent = parseTemplate($sqlContent, $parameter);
				$query = $this->accountdb->query($sqlContent);
				return $query->result();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function insert($parameter) {
		if(!empty($parameter) && !empty($parameter['GUID']) && !empty($parameter['account_mail'])) {
			return $this->accountdb->insert($this->tableName, $parameter);
		} else {
			return false;
		}
	}
}
?>