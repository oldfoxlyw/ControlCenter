<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class General_api extends CI_Controller {
	private $root_path = null;
	public function __construct() {
		parent::__construct();
		$this->root_path = $this->config->item('root_path');
	}
	
	public function changePlatform() {
		$platformId = $this->input->post('platformId', TRUE);
		if(empty($platformId) || ($platformId!='1' && $platformId!='2' && $platformId!='3')) {
			$platformId = '1';
		}
        $this->load->helper('cookie');
        $cookie = array(
			'name'		=> 'default_platform',
			'value'		=> $platformId,
			'expire'	=> $this->config->item('cookie_expire'),
			'domain'	=> $this->config->item('cookie_domain'),
			'path'		=> $this->config->item('cookie_path'),
			'prefix'	=> $this->config->item('cookie_prefix')
        );
        $this->input->set_cookie($cookie);
        
		if($platformId=='1') {
			redirect('web/index');
		} elseif($platformId=='2') {
			redirect('report/index');
		} elseif($platformId=='3') {
			redirect('operation/index');
		} else {
			$redirectUrl = urlencode($this->config->item('root_path') . 'login');
			redirect("/message?info=SCC_PLATFORM_INVALID&redirect={$redirectUrl}&auto_redirect=1&auto_delay=10");
		}
	}
}
?>