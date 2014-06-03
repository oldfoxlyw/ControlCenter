<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$info			= $this->input->get('info', TRUE);
		$redirect		= urldecode($this->input->get('redirect', TRUE));
		$autoRedirect	= $this->input->get('auto_redirect', TRUE);
		$autoDelay		= $this->input->get('auto_delay', TRUE);
		if($autoRedirect=='1') {
			$metaData = "<meta http-equiv=\"refresh\" content=\"3; url=$redirect\" />";
			$returnContent = "系统将在{$autoDelay}秒内自动跳转，或者您也可以点<a href=\"$redirect\">这里</a>\n";
		} else {
			$metaData = '';
			$returnContent = "<a href=\"$redirect\">点击这里返回</a>\n";
		}
		switch($info) {
			case 'SCC_SEND_MAIL_SUCCESS':
				$messageContent = "邮件发送成功！";
				break;
			case 'SCC_CLOSED':
				$sql = "select `config_close_reason` from `scc_config` where `config_selected`=1";
				$query = $this->db->query($sql);
				$row = $query->row();
				$messageContent = $row->config_close_reason;
				break;
			case 'SCC_USER_FREEZED':
				$messageContent = "该管理员已被冻结";
				break;
			case 'SCC_NO_PERMISSION':
				$messageContent = "您没有被授权此项功能";
				break;
			case 'SCC_USER_INVALID':
				$messageContent = "用户登录信息错误，请重新登录";
				break;
			case 'SCC_USER_CHECKCODE_INVALID':
				$messageContent = "用户登录信息异常，请检查网络环境的安全状况";
				break;
			case 'SCC_USER_EXPIRED':
				$messageContent = "用户登录已过期，请重新登录";
				break;
			case 'SCC_PLATFORM_INVALID':
				$messageContent = "获取默认工作区错误，请确保您的浏览器打开了Cookie功能";
				break;
			case 'SCC_IP_INVALID':
				$messageContent = "您的IP地址不在\"允许的IP地址列表\"之列，禁止登录";
				break;
			case 'SCC_DEFAULT_WEB_INVALID':
				$messageContent = "您还没有选择要操作的网站，请点击返回链接前往设置";
				break;
				
			case 'SCC_SEND_MAIL_NO_PARAM':
				$messageContent = "您还没有填写完必要的信息";
				break;
		}
		$data = array(
			'title'			=>		'SCC后台管理系统 - 错误信息',
			'root_path'		=>		'/ControlCenter/'
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'footer'	=>		$footer,
			'title'		=>		'错误信息',
			'root_path'	=>		'/ControlCenter/',
			'meta_data'	=>		$metaData,
			'message'	=>		$messageContent,
			'returned'	=>		$returnContent
		);
		$this->load->view('message_view', $data);
	}
}
?>