<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Christmas extends CI_Controller {
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
			$other = $other===FALSE ? '' : $other;
			
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
		$timeZone	=	$this->input->get_post('timezone', TRUE);
		$name		=	$this->input->get_post('name', TRUE);
		$email		=	$this->input->get_post('email', TRUE);
		$score		=	$this->input->get_post('score', TRUE);
		$type		=	$this->input->get_post('type', TRUE);
		if(!empty($timeZone)) {
			date_default_timezone_set($timeZone);
		}
		if(empty($name)) $name = '';
		if(empty($type)) $type = 'en';
		if($email!=FALSE && is_numeric($score)) {
			$time = time();
			$local = date('Y-m-d H:i:s', $time);
			$parameter = array(
				'log_email'		=>	$email,
				'log_name'		=>	$name,
				'log_score'		=>	$score,
				'log_time'		=>	$time,
				'log_time_local'=>	$local,
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
		$timeStart = $this->input->get_post('time_start', TRUE);
		$timeEnd = $this->input->get_post('time_end', TRUE);
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
		if(!empty($timeStart) && !empty($timeEnd)) {
			$result = $this->promotiondb->query("SELECT `log_email`, `log_name`, MAX(`log_score`) as `log_score` FROM `log_gathergold_score` where `log_type`='{$type}' and `log_time`>{$timeStart} and `log_time`<={$timeEnd} group by `log_email` order by `log_score` desc limit {$limit}");
		} else {
			$result = $this->promotiondb->query("SELECT `log_email`, `log_name`, MAX(`log_score`) as `log_score` FROM `log_gathergold_score` where `log_type`='{$type}' group by `log_email` order by `log_score` desc limit {$limit}");
		}
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
		$product = $this->input->get_post('product', TRUE);
		$type = $this->input->get_post('type', TRUE);
		$product_md5 = md5($product);
		if(!empty($product)) {
			$product = strtolower(str_replace(' ', '_', $product));
			$ip = $this->input->ip_address();
			$type = empty($type) ? 'normal' : $type;
			
			$this->promotiondb->where('log_product', $product);
			$result = $this->promotiondb->get('count_christmas');
			$row = $result->row();
			$count = intval($row->log_count);
			if($type=='limit') {
				if( ($product=='winxbd' && $count > 79812) ||
				($product=='macxvideoconverterpack' && $count > 59632) ||
				($product=='winxbd_jp' && $count > 29718) ) {
					$seed = rand(0, 100);
					$amount = rand(10, 100);
					if($seed < 20) {
						$this->promotiondb->where('log_product', $product);
						$this->promotiondb->set('log_count', 'log_count-' . strval($amount), FALSE);
						$this->promotiondb->update('count_christmas');
					}
				}
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
				$this->promotiondb->update('count_christmas');
				
				$_SESSION["cache_{$product_md5}"] = $currentTimeStamp;
				$_SESSION["ipv4_{$product_md5}"] = $ip;
			}
			echo strval($count + 1);
		}
	}
}
?>