<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sqls extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'report_sql';
	private $root_path = null;
	
	public function __construct() {
		parent::__construct();
		$this->load->model('functions/check_user', 'check');
		$this->user = $this->check->validate();
		$this->check->permission($this->user, $this->permissionName);
		$this->check->ip();
		$record = $this->check->configuration($this->user);
		$this->_CONFIG = $record['record'];
		if(!$record['state']) {
			$redirectUrl = urlencode($this->config->item('root_path') . 'login');
			redirect("/message?info=SCC_CLOSED&redirect={$redirectUrl}");
		}
		$this->root_path = $this->config->item('root_path');
		$this->load->model('report/statistic', 'statistic');
	}
	
	public function index() {
		$type = $this->input->post('post_flag', TRUE);
		if($type=='1') {
			
		} elseif($type=='2') {
			$dbName = $this->input->post('sqlDatabase', TRUE);
			$dbSql = $this->input->post('sqlStatement', TRUE);
			
			$this->load->model('report/statement', 'statement');
			$this->statement->__init($dbName);
			$result = $this->statement->getResult($dbSql);
			$fields = $this->statement->getResultFields($result);
		}
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'fields'			=>	$fields,
			'result'			=>	$result,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - SQL语句查询',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'SQL语句查询',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
}
?>