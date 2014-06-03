<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partner_promotion extends CI_Controller {
	private $root_path = null;
	private $promotiondb = null;
	
	public function __construct() {
		parent::__construct();
		$this->promotiondb = $this->load->database('promotiondb', TRUE);
		$this->root_path = $this->config->item('root_path');
		//$this->load->library('session');
	}
	
	public function count() {
		$partnerId = $this->input->get_post('partner_id', TRUE);
		$website = $this->input->get_post('website', TRUE);		//macxdvd
		$time = $this->input->get_post('time', TRUE);			//20120523
		$activity = $this->input->get_post('activity', TRUE);	//partner
		$sid = $this->input->get_post('sid', TRUE);
		$ip = $this->input->ip_address();
		
		if(!empty($sid)) {
			session_id($sid);
		}
		session_start();
		$logFlag = false;
		if(isset($_SESSION["cache_{$partnerId}"])) {
			$cacheTime = intval($_SESSION["cache_{$partnerId}"]);
			if(time() > $cacheTime + 300) {
				$logFlag = true;
			} else {
				if(isset($_SESSION["ipv4_{$partnerId}"]) && $_SESSION["ipv4_{$partnerId}"]==$ip) {
					
				} else {
					$logFlag = true;
				}
			}
		} else {
			$logFlag = true;
		}
		
		if(!empty($partnerId) && !empty($website) && !empty($time) && !empty($activity)) {
			$tableName = "{$website}_{$time}_{$activity}_count";
			
			$this->promotiondb->where('partner_id', $partnerId);
			$query = $this->promotiondb->get($tableName);
			if($query->num_rows() > 0) {
				$row = $query->row();
				if($logFlag) {
					$count = $row->product_download_count;
					$this->promotiondb->where('partner_id', $partnerId);
					$this->promotiondb->set('product_download_count', 'product_download_count+1', FALSE);
					$this->promotiondb->update($tableName);
				
					$_SESSION["cache_{$partnerId}"] = time();
					$_SESSION["ipv4_{$partnerId}"] = $ip;
				}
				unset($row->partner_name);
				unset($row->partner_url);
				unset($row->product_download_count);
				echo json_encode($row);
			} else {
				echo 'PARTNER_ID_ERROR';
			}
		}
	}
}
?>