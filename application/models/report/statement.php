<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Statement extends CI_Model {
	private $sccdb = null;
	
	public function __construct() {
		parent::__construct();
	}
	
	public function __init($sccdbName) {
		switch($sccdbName) {
			case 'scc_logdb_201107':
				$this->sccdb = $this->load->database('logdb', true);
				break;
			case 'scc_accountdb':
				$this->sccdb = $this->load->database('accountdb', true);
				break;
			case 'scc_authorization':
				$this->sccdb = $this->load->database('authdb', true);
				break;
			case 'scc_commercial':
				$this->sccdb = $this->load->database('comdb', true);
				break;
			case 'scc_productdb':
				$this->sccdb = $this->load->database('productdb', true);
				break;
			case 'scc_webdb':
				$this->sccdb = $this->load->database('webdb', true);
				break;
		}
	}
	
	public function getResult($sql) {
		$query = $this->sccdb->query($sql);
		if($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	public function getResultFields($result) {
		$fields = array();
		if(count($result) > 0) {
			foreach($result[0] as $key => $value) {
				array_push($fields, $key);
			}
		}
		return $fields;
	}
}
?>