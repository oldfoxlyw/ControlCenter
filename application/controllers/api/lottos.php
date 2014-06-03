<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lottos extends CI_Controller {
	private $root_path = null;
	
	public function __construct() {
		parent::__construct();
		$this->root_path = $this->config->item('root_path');
		$this->load->model('api/lotto');
	}
	
	public function getResult() {
		echo $this->lotto->getResult();
	}
	/*
	public function test() {
		$m1 = $m2 = $m3 = $m4 = 0;
		for($i=0; $i<10000; $i++) {
			$value = $this->lotto->getResult();
			switch($value) {
				case '1':
					$m1++;
					break;
				case '2':
					$m2++;
					break;
				case '3':
					$m3++;
					break;
				default:
					$m4++;
			}
		}
		echo "1: {$m1}<br>";
		echo "2: {$m2}<br>";
		echo "3: {$m3}<br>";
		echo "4: {$m4}<br>";
	}
	*/
}
?>