<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	private $root_path = '';
	public function __construct() {
		parent::__construct();
		$this->root_path = $this->config->item('root_path');
	}
	public function index() {
		$data = array(
			'title'			=>		'SCC后台管理系统 - 管理员登录',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'footer'	=>		$footer,
			'title'		=>		'管理员登录',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('login_view', $data);
	}
	public function validate() {
		$userName = $this->input->post('userName', TRUE);
		$userPass = $this->input->post('userPass', TRUE);
		$entrance = $this->input->post('selectEntrance', TRUE);
		if(empty($entrance) || ($entrance!='1' && $entrance!='2' && $entrance!='3')) {
			$entrance = '1';
		}
		$this->load->model('web/admin_user', 'user');
		
		if(!$this->user->validate($userName, $userPass)) {
			$this->logs->write(array(
				'log_type'	=>	'SCC_USER_INVALID'
			));
			$redirectUrl = urlencode($this->root_path . 'login');
			redirect("/message?info=SCC_USER_INVALID&redirect={$redirectUrl}");
		} elseif(!$this->user->freezed(array('user_name'=>$userName))) {
			$this->logs->write(array(
				'log_type'	=>	'SCC_USER_FREEZED'
			));
			$redirectUrl = urlencode($this->root_path . 'login');
			redirect("/message?info=SCC_USER_FREEZED&redirect={$redirectUrl}");
		} else {
			$checkCode = $userName . '#' . strtoupper(do_hash($userPass, 'md5'));
			$checkCode = strtoupper(do_hash($checkCode, 'md5'));
			$cookie = array(
				'user_name'		=>		$userName,
				'check_code'	=>		$checkCode
			);
			$cookieStr = json_encode($cookie);
			
            $this->load->helper('cookie');
            $cookie = array(
				'name'		=> 'user',
				'value'		=> $cookieStr,
				'expire'	=> $this->config->item('cookie_expire'),
				'domain'	=> $this->config->item('cookie_domain'),
				'path'		=> $this->config->item('cookie_path'),
				'prefix'	=> $this->config->item('cookie_prefix')
            );
            $this->input->set_cookie($cookie);
            $cookie = array(
            	'name'		=>	'default_platform',
            	'value'		=>	$entrance,
				'expire'	=> $this->config->item('cookie_expire'),
				'domain'	=> $this->config->item('cookie_domain'),
				'path'		=> $this->config->item('cookie_path'),
				'prefix'	=> $this->config->item('cookie_prefix')
            );
            $this->input->set_cookie($cookie);
			$this->logs->write(array(
				'log_type'	=>	'SCC_USER_LOGIN'
			));
			if($entrance=='1') {
            	redirect('/web/index', 'location');
			} elseif($entrance=='2') {
            	redirect('/report/index', 'location');
			} elseif($entrance=='3') {
            	redirect('/operation/index', 'location');
			} else {
				$redirectUrl = urlencode($this->config->item('root_path') . 'login');
				redirect("/message?info=SCC_PLATFORM_INVALID&redirect={$redirectUrl}");
			}
		}
	}
	public function out() {
		$this->load->helper('cookie');
		$cookie = array(
			'name'		=> 'user',
			'domain'	=> $this->config->item('cookie_domain'),
			'path'		=> $this->config->item('cookie_path'),
			'prefix'	=> $this->config->item('cookie_prefix')
		);
		delete_cookie($cookie);
		redirect('/login');
	}
}
?>