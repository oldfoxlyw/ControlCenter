<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends CI_Controller {
	private $root_path = null;

	public function __construct() {
		parent::__construct();
		$this->root_path = $this->config->item('root_path');
		$this->load->model('web/slide', 'slide');
	}
	
	public function getSlides($webId) {
		
	}
}
?>