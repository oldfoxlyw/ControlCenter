<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Web extends CI_Model {
	private $tableName = 'log_download';
	private $buyName = 'log_buy';
	private $logdb = null;
	
	public function __construct() {
		parent::__construct();
		$this->logdb = $this->load->database('weblogdb', true);
	}
	
	public function insert($parameter) {
		if(!empty($parameter) && !empty($parameter['log_down_method']) && !empty($parameter['log_redirect_pid'])) {
			$currentTimeStamp = time();
			if(empty($parameter['log_time'])) {
				$parameter['log_time'] = $currentTimeStamp;
			}
			if(empty($parameter['log_localtime'])) {
				$parameter['log_localtime'] = date('Y-m-d H:i:s', $currentTimeStamp);
			}
			return $this->logdb->insert($this->tableName, $parameter);
		} else {
			return false;
		}
	}
	
	public function insert_buy($parameter) {
		if(!empty($parameter)) {
			$currentTimeStamp = time();
			if(empty($parameter['log_time'])) {
				$parameter['log_time'] = $currentTimeStamp;
			}
			if(empty($parameter['log_localtime'])) {
				$parameter['log_localtime'] = date('Y-m-d H:i:s', $currentTimeStamp);
			}
			return $this->logdb->insert($this->buyName, $parameter);
		} else {
			return false;
		}
	}
}
?>