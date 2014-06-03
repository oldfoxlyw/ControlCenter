<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Game_promotion extends CI_Controller {
	private $root_path = null;
	private $promotiondb = null;
	
	public function __construct() {
		parent::__construct();
		$this->promotiondb = $this->load->database('promotiondb', TRUE);
		$this->root_path = $this->config->item('root_path');
		//$this->load->library('session');
	}
	
	public function log() {
		$email		=	$this->input->get_post('email', TRUE);
		$name		=	$this->input->get_post('name', TRUE);
		$coupon		=	$this->input->get_post('coupon', TRUE);
		$license	=	$this->input->get_post('license', TRUE);
		$product	=	$this->input->get_post('product', TRUE);
		$other		=	$this->input->get_post('other', TRUE);
		$game_id	=	$this->input->get_post('game', TRUE);
		
		if($email!=FALSE && $game_id!=FALSE) {
			$name = $name===FALSE ? '' : $name;
			$coupon = $coupon===FALSE ? '' : $coupon;
			$license = $license===FALSE ? '' : $license;
			$product = strtolower(str_replace(' ', '_', $product));
			
			$parameter = array(
				'log_email'		=>	$email,
				'log_name'		=>	$name,
				'log_coupon'	=>	$coupon,
				'log_license'	=>	$license,
				'log_product'	=>	$product,
				'log_other'		=>	$other,
				'log_time'		=>	time(),
				'log_game_id'	=>	$game_id
			);
			$this->promotiondb->insert('log_christmas', $parameter);
			echo 'PROMOTION_CHRISTMAS_LOG_SUCCESS';
		} else {
			echo 'PROMOTION_CHRISTMAS_LOG_NO_PARAM';
		}
	}
	
	public function get_log() {
		$game = $this->input->get_post('game', TRUE);
		$limit = $this->input->get_post('limit', TRUE);
		if($limit!==FALSE && is_numeric($limit)) {
			$limit = intval($limit);
		} else {
			$limit = 10;
		}
		$result = $this->promotiondb->query("SELECT `log_email`, `log_coupon`, `log_license`, `log_product`, MAX(`log_time`) as `log_time`, `log_game_id` FROM `log_christmas` where `log_game_id`='{$game}' group by `log_email` order by `log_time` desc limit {$limit}");
		if($result->num_rows() > 0) {
			$result = $result->result();
			if($game=='collect_gift') {
				$item = null;
				$item->log_email = 'dean.lurcker@gmail.com';
				$item->log_coupon = '';
				$item->log_license = 'ipad';
				$item->log_product = 'ipad';
				$item->highlight = '1';
				array_unshift($result, $item);
				array_pop($result);
				
				$item = null;
				$item->log_email = 'tripleleaves@gmail.com';
				$item->log_coupon = '';
				$item->log_license = 'ipad';
				$item->log_product = 'ipad';
				$item->highlight = '1';
				array_unshift($result, $item);
				array_pop($result);
			} elseif($game=='collect_gift_jp') {
				$item = null;
				$item->log_email = 'micfly.johnny@gmail.com';
				$item->log_coupon = '';
				$item->log_license = 'ipad';
				$item->log_product = 'ipad';
				$item->highlight = '1';
				array_unshift($result, $item);
				array_pop($result);
			} elseif($game=='slots_macx') {
				$item = null;
				$item->log_email = 'andrew.oldfox@gmail.com';
				$item->log_coupon = '';
				$item->log_license = 'iphone';
				$item->log_product = 'iphone';
				$item->highlight = '1';
				array_unshift($result, $item);
				array_pop($result);
				
				$item = null;
				$item->log_email = 'gabbril.hawk@hotmail.com';
				$item->log_coupon = '';
				$item->log_license = 'iphone';
				$item->log_product = 'iphone';
				$item->highlight = '1';
				array_unshift($result, $item);
				array_pop($result);
			} elseif($game=='christmas_tree') {
				$item = null;
				$item->log_email = 'tomy.bigfish@gmail.com';
				$item->log_coupon = '';
				$item->log_license = 'ipod';
				$item->log_product = 'ipod';
				$item->highlight = '1';
				array_unshift($result, $item);
				array_pop($result);
			}
			foreach($result as $key => $row) {
				$email = explode('@', $row->log_email);
				$length = strlen($email[0]);
				if($length > 8) {
					$email[0] = substr_replace($email[0], '**', 3, $length-6);
				} else {
					$email[0] = substr_replace($email[0], '***', 4);
				}
				$email[1] = '*****';
				$result[$key]->log_email = implode('@', $email);
			}
			echo json_encode($result);
		} else {
			echo 'PROMOTION_CHRISTMAS_LOG_NO_RESULT';
		}
	}
	
	public function get_log_scroll() {
		$game = $this->input->get_post('game', TRUE);
		//$startTime = $this->input->get_post('starttime', TRUE);
		$limit = $this->input->get_post('limit', TRUE);
		if($limit!==FALSE && is_numeric($limit)) {
			$limit = intval($limit);
		} else {
			$limit = 10;
		}
		/*
		if($startTime!==FALSE && is_numeric($startTime)) {
			$startTime = intval($startTime);
		} else {
			$startTime = 1;
		}
		*/
		$this->promotiondb->where('log_game_id', $game);
		//$this->promotiondb->where('log_time >', $startTime);
		$this->promotiondb->order_by('log_id', 'desc');
		$this->promotiondb->limit($limit);
		$query = $this->promotiondb->get('log_christmas');
		
		if($query->num_rows() > 0) {
			exit(json_encode($query->result()));
		} else {
			exit('PROMOTION_LOG_NO_RESULT');
		}
	}
	
	public function get_log_count() {
		$game = $this->input->get_post('game', TRUE);
		if($game!=FALSE) {
			$this->promotiondb->where('log_game_id', $game);
			echo strval($this->promotiondb->count_all_results('log_christmas'));
		} else {
			echo 'PROMOTION_CHRISTMAS_LOG_COUNT_NO_PARAM';
		}
	}
	
	public function score() {
		$email		=	$this->input->get_post('email', TRUE);
		$score		=	$this->input->get_post('score', TRUE);
		$type		=	$this->input->get_post('type', TRUE);
		if(empty($type)) $type = 'en';
		if($email!=FALSE && is_numeric($score)) {
			$parameter = array(
				'log_email'		=>	$email,
				'log_score'		=>	$score,
				'log_time'		=>	time(),
				'log_type'		=>	$type
			);
			$this->promotiondb->insert('log_gathergold_score', $parameter);
			echo 'PROMOTION_CHRISTMAS_SCORE_SUCCESS';
		} else {
			echo 'PROMOTION_CHRISTMAS_SCORE_NO_PARAM';
		}
	}
	
	public function get_score() {
		$limit = $this->input->get_post('limit', TRUE);
		$type = $this->input->get_post('type', TRUE);
		if(empty($type)) $type = 'en';
		/*
		if($limit!=FALSE && is_numeric($limit)) {
			$limit = intval($limit);
		} else {
			$limit = 10;
		}
		$this->promotiondb->order_by('log_score', 'desc');
		$result = $this->promotiondb->get('log_gathergold_score', $limit, 0);
		*/
		$result = $this->promotiondb->query("SELECT `log_email`, MAX(`log_score`) as `log_score` FROM `log_gathergold_score` where `log_type`='{$type}' group by `log_email` order by `log_score` desc limit {$limit}");
		if($result->num_rows() > 0) {
			$result = $result->result();
			foreach($result as $key => $row) {
				$email = explode('@', $row->log_email);
				$length = strlen($email[0]);
				if($length > 8) {
					$email[0] = substr_replace($email[0], '**', 3, $length-6);
				} else {
					$email[0] = substr_replace($email[0], '***', 4);
				}
				$email[1] = '*****';
				$result[$key]->log_email = implode('@', $email);
			}
			echo json_encode($result);
		} else {
			echo 'PROMOTION_CHRISTMAS_SCORE_NO_RESULT';
		}
	}
	
	public function get_count() {
		$product = $this->input->get_post('product', TRUE);
		$this->promotiondb->where('log_product', $product);
		$result = $this->promotiondb->get('count_christmas');
		if($result->num_rows() > 0) {
			$row = $result->row();
			echo $row->log_count;
		} else {
			echo 'PROMOTION_CHRISTMAS_COUNT_NO_RESULT';
		}
	}
	
	public function count() {
		$website = $this->input->get_post('website', TRUE);		//macxdvd
		$activity = $this->input->get_post('activity', TRUE);	//thanksgiving
		$product = $this->input->get_post('product', TRUE);		//ripper
		$type = $this->input->get_post('type', TRUE);
		$limitCount = $this->input->get_post('limit', TRUE);
		$sid = $this->input->get_post('sid', TRUE);
		$product_md5 = md5($product);
		if(!empty($product) && !empty($website) && !empty($activity)) {
			$product = strtolower(str_replace(' ', '_', $product));
			$ip = $this->input->ip_address();
			$type = empty($type) ? 'normal' : $type;
			
			$this->promotiondb->where('log_product', $product);
			$currentYear = date('Y');
			$databaseName = "{$website}_{$activity}_count_{$currentYear}";
			
			$result = $this->promotiondb->get($databaseName);
			$row = $result->row();
			$count = intval($row->log_count);
			if($type=='limit') {
				if($count > $limitCount) {
					$seed = rand(0, 100);
					$amount = rand(10, 100);
					if($seed < 20) {
						$this->promotiondb->where('log_product', $product);
						$this->promotiondb->set('log_count', 'log_count-' . strval($amount), FALSE);
						$this->promotiondb->update($databaseName);
					}
				}
			}
			if(!empty($sid)) {
				session_id($sid);
			}
			session_start();
			$logFlag = false;
			if(isset($_SESSION["cache_{$product_md5}"])) {
				$cacheTime = intval($_SESSION["cache_{$product_md5}"]);
				if(time() > $cacheTime + 300) {
					$logFlag = true;
				} else {
					if(isset($_SESSION["ipv4_{$product_md5}"]) && $_SESSION["ipv4_{$product_md5}"]==$ip) {
						
					} else {
						$logFlag = true;
					}
				}
			} else {
				$logFlag = true;
			}
			if($logFlag) {
				$currentTimeStamp = time();
				$this->promotiondb->where('log_product', $product);
				$this->promotiondb->set('log_count', 'log_count+1', FALSE);
				$this->promotiondb->set('log_real_count', 'log_real_count+1', FALSE);
				$this->promotiondb->update($databaseName);
				
				$_SESSION["cache_{$product_md5}"] = $currentTimeStamp;
				$_SESSION["ipv4_{$product_md5}"] = $ip;
			}
			echo strval($count + 1);
		}
	}
	
	public function vote() {
		$website = $this->input->get_post('website', TRUE);		//macxdvd
		$activity = $this->input->get_post('activity', TRUE);	//thanksgiving
		$product = $this->input->get_post('product', TRUE);		//ripper
		$type = $this->input->get_post('type', TRUE);
		$limitCount = $this->input->get_post('limit', TRUE);
		$sid = $this->input->get_post('sid', TRUE);
		$product_md5 = md5($product);
		if(!empty($product) && !empty($website) && !empty($activity)) {
			$product = strtolower(str_replace(' ', '_', $product));
			$ip = $this->input->ip_address();
			$type = empty($type) ? 'normal' : $type;
			
			$this->promotiondb->where('log_product', $product);
			$currentYear = date('Y');
			$databaseName = "{$website}_{$activity}_vote_{$currentYear}";
			
			$result = $this->promotiondb->get($databaseName);
			$row = $result->row();
			$count = intval($row->log_count);
			if($type=='limit') {
				if($count > $limitCount) {
					$seed = rand(0, 100);
					$amount = rand(10, 100);
					if($seed < 20) {
						$this->promotiondb->where('log_product', $product);
						$this->promotiondb->set('log_count', 'log_count-' . strval($amount), FALSE);
						$this->promotiondb->update($databaseName);
					}
				}
			}
		
			if(!empty($sid)) {
				session_id($sid);
			}
			session_start();
			$logFlag = false;
			if(isset($_SESSION["cache_{$product_md5}"])) {
				$cacheTime = intval($_SESSION["cache_{$product_md5}"]);
				if(time() > $cacheTime + 300) {
					$logFlag = true;
				} else {
					if(isset($_SESSION["ipv4_{$product_md5}"]) && $_SESSION["ipv4_{$product_md5}"]==$ip) {
						
					} else {
						$logFlag = true;
					}
				}
			} else {
				$logFlag = true;
			}
			if($logFlag) {
				$currentTimeStamp = time();
				$this->promotiondb->where('log_product', $product);
				$this->promotiondb->set('log_count', 'log_count+1', FALSE);
				$this->promotiondb->set('log_real_count', 'log_real_count+1', FALSE);
				$this->promotiondb->update($databaseName);
				
				$_SESSION["cache_{$product_md5}"] = $currentTimeStamp;
				$_SESSION["ipv4_{$product_md5}"] = $ip;
			}
			
			$this->promotiondb->select('log_product, log_count');
			$query = $this->promotiondb->get($databaseName);
			$result = $query->result();
			echo json_encode($result);
		}
	}
	
	public function get_license_remain() {
		$table = $this->input->get_post('table', TRUE);
		$remain = $this->input->get_post('remain', TRUE);
		if(!empty($table)) {
			if($remain!==FALSE) {
				$this->promotiondb->where('partner_license_remain <=', intval($remain));
			}
			$query = $this->promotiondb->get($table);
			echo json_encode($query->result());
		}
	}
	
	public function reset_license_remain() {
		date_default_timezone_set('Etc/GMT+4');
		$table = $this->input->get_post('table', TRUE);
		$query = $this->promotiondb->get($table);
		$row = $query->row();
		$limitTime = intval($row->partner_license_limittime);
		
		$currentTime = time();
		$currentDay = date('Y-m-d', $currentTime);
		$currentDayStart = strtotime("{$currentDay} 00:00:00");
		if($limitTime <= $currentDayStart) {
			$this->promotiondb->set('partner_license_limit', 0);
			$this->promotiondb->set('partner_current_show', 0);
			$this->promotiondb->set('partner_license_limittime', time());
			$this->promotiondb->update($table);
		}
	}
}
?>