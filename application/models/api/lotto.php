<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lotto extends CI_Model {
	private $min = 0;
	private $max = 10000;
	private $resultList = array(
		array(
			'id'			=>	1,
			'range_start'	=>	0,
			'range_end'		=>	2
		),
		array(
			'id'			=>	2,
			'range_start'	=>	3,
			'range_end'		=>	50
		),
		array(
			'id'			=>	3,
			'range_start'	=>	51,
			'range_end'		=>	10000
		)
	);
	
	public function __construct() {
		parent::__construct();
	}
	
	private function getRandom() {
		return mt_rand($this->min, $this->max);
	}
	
	public function getResult() {
		$value = $this->getRandom();
		foreach($this->resultList as $item) {
			if($value >= $item['range_start'] && $value < $item['range_end']) {
				return $item['id'];
			}
		}
		return -1;
	}
	
}
?>