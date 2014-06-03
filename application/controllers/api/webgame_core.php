<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Webgame_core extends CI_Controller {
	private $root_path = null;
	
	public function __construct() {
		parent::__construct();
		$this->load->model('logs', 'logs');
	}
	
	public function seed() {
		$game_id = $this->input->post('game', TRUE);
		$type = $this->input->post('type', TRUE);
		$repeat = $this->input->post('repeat', TRUE);
		
		if(empty($type)) $type = 'single';
		if(empty($repeat) || !is_numeric($repeat)) {
			$repeat = 10;
		} else {
			$repeat = intval($repeat);
		}
		
		if($type=='single') {
			$seed = 0;
			switch($game_id) {
				case 'macxdvd_slots':
					$seed = rand(0, 100);
					break;
				default:
					$seed = rand(0, 100);
					break;
			}
			if($seed==100) $seed--;
			echo strval($seed);
		} elseif($type=='array') {
			$seed = array();
			for($i=0; $i<$repeat; $i++) {
				$temp = rand(0, 100);
				if($temp==100) $temp--;
				array_push($seed, $temp);
			}
			echo implode(',', $seed);
		}
	}
}
?>