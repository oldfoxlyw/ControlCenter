<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Thanksgiving extends CI_Controller {
	private $root_path = null;
	private $promotiondb = null;
	
	public function __construct() {
		parent::__construct();
		$this->promotiondb = $this->load->database('promotiondb', TRUE);
		$this->root_path = $this->config->item('root_path');
		$this->load->model('product', 'product');
		$this->load->model('logs', 'logs');
		//$this->load->library('session');
	}
	
	public function get_count() {
		$result = $this->promotiondb->get('count_thanksgiving');
		$row = $result->row();
		echo $row->count;
	}
	
	public function count_drp() {
		session_start();
		$ip = $this->input->ip_address();
		$this->promotiondb->where('product', 'drp');
		$result = $this->promotiondb->get('count_thanksgiving');
		$row = $result->row();
		$count = intval($row->count);
		if($count > 23167) {
			$seed = rand(0, 100);
			$amount = rand(10, 100);
			if($seed < 20) {
				$this->promotiondb->where('product', 'drp');
				$this->promotiondb->set('count', 'count-' . strval($amount), FALSE);
				$this->promotiondb->update('count_thanksgiving');
			}
		}
		
		if($ip!='119.6.80.40') {
			$logFlag = false;
			if(isset($_SESSION['cache_drp'])) {
				$cacheTime = intval($_SESSION['cache_drp']);
				if(time() > $cacheTime + 300) {
					$logFlag = true;
				} else {
					if(isset($_SESSION['ipv4_drp']) && $_SESSION['ipv4_drp']==$ip) {
						
					} else {
						$logFlag = true;
					}
				}
			} else {
				$logFlag = true;
			}
			if($logFlag) {
				$currentTimeStamp = time();
				$this->promotiondb->where('product', 'drp');
				$this->promotiondb->set('count', 'count+1', FALSE);
				$this->promotiondb->set('count_real', 'count_real+1', FALSE);
				$this->promotiondb->update('count_thanksgiving');
				
				$_SESSION['cache_drp'] = $currentTimeStamp;
				$_SESSION['ipv4_drp'] = $ip;
			}
		}
		echo strval($count + 1);
	}
	
	public function count_drp_jp() {
		session_start();
		$ip = $this->input->ip_address();
		$this->promotiondb->where('product', 'drp_jp');
		$result = $this->promotiondb->get('count_thanksgiving');
		$row = $result->row();
		$count = intval($row->count);
		if($count > 23172) {
			$seed = rand(0, 100);
			$amount = rand(10, 100);
			if($seed < 20) {
				$this->promotiondb->where('product', 'drp_jp');
				$this->promotiondb->set('count', 'count-' . strval($amount), FALSE);
				$this->promotiondb->update('count_thanksgiving');
			}
		}
		
		if($ip!='119.6.80.40') {
			$logFlag = false;
			if(isset($_SESSION['cache_drp_jp'])) {
				$cacheTime = intval($_SESSION['cache_drp_jp']);
				if(time() > $cacheTime + 300) {
					$logFlag = true;
				} else {
					if(isset($_SESSION['ipv4_drp_jp']) && $_SESSION['ipv4_drp_jp']==$ip) {
						
					} else {
						$logFlag = true;
					}
				}
			} else {
				$logFlag = true;
			}
			if($logFlag) {
				$currentTimeStamp = time();
				$this->promotiondb->where('product', 'drp_jp');
				$this->promotiondb->set('count', 'count+1', FALSE);
				$this->promotiondb->set('count_real', 'count_real+1', FALSE);
				$this->promotiondb->update('count_thanksgiving');
				
				$_SESSION['cache_drp_jp'] = $currentTimeStamp;
				$_SESSION['ipv4_drp_jp'] = $ip;
			}
		}
		echo strval($count + 1);
	}
	
	public function count_ripper() {
		session_start();
		$ip = $this->input->ip_address();
		$this->promotiondb->where('product', 'ripper');
		$result = $this->promotiondb->get('count_thanksgiving');
		$row = $result->row();
		$count = intval($row->count);
		if($count > 25612) {
			$seed = rand(0, 100);
			$amount = rand(10, 100);
			if($seed < 20) {
				$this->promotiondb->where('product', 'ripper');
				$this->promotiondb->set('count', 'count-' . strval($amount), FALSE);
				$this->promotiondb->update('count_thanksgiving');
			}
		}
		
		if($ip!='119.6.80.40') {
			$logFlag = false;
			if(isset($_SESSION['cache_ripper'])) {
				$cacheTime = intval($_SESSION['cache_ripper']);
				if(time() > $cacheTime + 300) {
					$logFlag = true;
				} else {
					if(isset($_SESSION['ipv4_ripper']) && $_SESSION['ipv4_ripper']==$ip) {
						
					} else {
						$logFlag = true;
					}
				}
			} else {
				$logFlag = true;
			}
			if($logFlag) {
				$currentTimeStamp = time();
				$this->promotiondb->where('product', 'ripper');
				$this->promotiondb->set('count', 'count+1', FALSE);
				$this->promotiondb->set('count_real', 'count_real+1', FALSE);
				$this->promotiondb->update('count_thanksgiving');
				
				$_SESSION['cache_ripper'] = $currentTimeStamp;
				$_SESSION['ipv4_ripper'] = $ip;
			}
		}
		echo strval($count + 1);
	}
	
	public function count_decrypter() {
		session_start();
		$ip = $this->input->ip_address();
		
		if($ip!='119.6.80.40') {
			$logFlag = false;
			if(isset($_SESSION['cache_decrypter'])) {
				$cacheTime = intval($_SESSION['cache_decrypter']);
				if(time() > $cacheTime + 300) {
					$logFlag = true;
				} else {
					if(isset($_SESSION['ipv4_decrypter']) && $_SESSION['ipv4_decrypter']==$ip) {
						
					} else {
						$logFlag = true;
					}
				}
			} else {
				$logFlag = true;
			}
			if($logFlag) {
				$currentTimeStamp = time();
				$this->promotiondb->where('product', 'decrypter');
				$this->promotiondb->set('count', 'count+1', FALSE);
				$this->promotiondb->set('count_real', 'count_real+1', FALSE);
				$this->promotiondb->update('count_thanksgiving');
				
				$_SESSION['cache_decrypter'] = $currentTimeStamp;
				$_SESSION['ipv4_decrypter'] = $ip;
			}
		}
		$this->promotiondb->where('product', 'decrypter');
		$result = $this->promotiondb->get('count_thanksgiving');
		$row = $result->row();
		$count = intval($row->count);
		echo strval($count + 1);
	}
	
	public function count_decrypter_jp() {
		session_start();
		$ip = $this->input->ip_address();
		
		if($ip!='119.6.80.40') {
			$logFlag = false;
			if(isset($_SESSION['cache_decrypter_jp'])) {
				$cacheTime = intval($_SESSION['cache_decrypter_jp']);
				if(time() > $cacheTime + 300) {
					$logFlag = true;
				} else {
					if(isset($_SESSION['ipv4_decrypter_jp']) && $_SESSION['ipv4_decrypter_jp']==$ip) {
						
					} else {
						$logFlag = true;
					}
				}
			} else {
				$logFlag = true;
			}
			if($logFlag) {
				$currentTimeStamp = time();
				$this->promotiondb->where('product', 'decrypter_jp');
				$this->promotiondb->set('count', 'count+1', FALSE);
				$this->promotiondb->set('count_real', 'count_real+1', FALSE);
				$this->promotiondb->update('count_thanksgiving');
				
				$_SESSION['cache_decrypter_jp'] = $currentTimeStamp;
				$_SESSION['ipv4_decrypter_jp'] = $ip;
			}
		}
		$this->promotiondb->where('product', 'decrypter_jp');
		$result = $this->promotiondb->get('count_thanksgiving');
		$row = $result->row();
		$count = intval($row->count);
		echo strval($count + 1);
	}
	
	public function count_converter() {
		session_start();
		$ip = $this->input->ip_address();
		
		if($ip!='119.6.80.40') {
			$logFlag = false;
			if(isset($_SESSION['cache_converter'])) {
				$cacheTime = intval($_SESSION['cache_converter']);
				if(time() > $cacheTime + 300) {
					$logFlag = true;
				} else {
					if(isset($_SESSION['ipv4_converter']) && $_SESSION['ipv4_converter']==$ip) {
						
					} else {
						$logFlag = true;
					}
				}
			} else {
				$logFlag = true;
			}
			if($logFlag) {
				$currentTimeStamp = time();
				$this->promotiondb->where('product', 'converter');
				$this->promotiondb->set('count', 'count+1', FALSE);
				$this->promotiondb->set('count_real', 'count_real+1', FALSE);
				$this->promotiondb->update('count_thanksgiving');
				
				$_SESSION['cache_converter'] = $currentTimeStamp;
				$_SESSION['ipv4_converter'] = $ip;
			}
		}
		$this->promotiondb->where('product', 'converter');
		$result = $this->promotiondb->get('count_thanksgiving');
		$row = $result->row();
		$count = intval($row->count);
		echo strval($count + 1);
	}
	
	public function count_bdlot() {
		session_start();
		$ip = $this->input->ip_address();
		
		if($ip!='119.6.80.40') {
			$logFlag = false;
			if(isset($_SESSION['cache_bdlot'])) {
				$cacheTime = intval($_SESSION['cache_bdlot']);
				if(time() > $cacheTime + 300) {
					$logFlag = true;
				} else {
					if(isset($_SESSION['ipv4_bdlot']) && $_SESSION['ipv4_bdlot']==$ip) {
						
					} else {
						$logFlag = true;
					}
				}
			} else {
				$logFlag = true;
			}
			if($logFlag) {
				$currentTimeStamp = time();
				$this->promotiondb->where('product', 'bdlot');
				$this->promotiondb->set('count', 'count+1', FALSE);
				$this->promotiondb->set('count_real', 'count_real+1', FALSE);
				$this->promotiondb->update('count_thanksgiving');
				
				$_SESSION['cache_bdlot'] = $currentTimeStamp;
				$_SESSION['ipv4_bdlot'] = $ip;
			}
		}
		$this->promotiondb->where('product', 'bdlot');
		$result = $this->promotiondb->get('count_thanksgiving');
		$row = $result->row();
		$count = intval($row->count);
		echo strval($count + 1);
	}
}
?>