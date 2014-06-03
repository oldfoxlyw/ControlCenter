<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class General_api extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $webId = null;
	private $root_path = null;
	public function __construct() {
		parent::__construct();
		$this->load->model('functions/check_user', 'check');
		$this->user = $this->check->validate();
		$this->check->ip();
		$this->webId = $this->check->checkDefaultWeb();
		$record = $this->check->configuration($this->user);
		$this->_CONFIG = $record['record'];
		/*
		if(!$record['state']) {
			$redirectUrl = urlencode($this->config->item('root_path') . 'login');
			redirect("/message?info=SCC_CLOSED&redirect={$redirectUrl}");
		}
		*/
		$this->root_path = $this->config->item('root_path');
	}
	
	public function getCategoryByChannel() {
		$this->check->permission($this->user, 'func_get_category');
		
		$cid = $this->input->post('cid', TRUE);
		$this->load->model('web/category', 'category');
		$this->category->__init($this->webId);
		$result = $this->category->getAllResult($cid);
		$retData = array(
			'field'		=>	array()
		);
		foreach($result as $i=>$row) {
			$retData['field'][$i] = array(
				'id'	=>	$row->category_id,
				'name'	=>	$row->category_name
			);
		}
		$retData = json_encode($retData);
		echo $retData;
	}
	
	public function doPicUpload() {
		$this->check->permission($this->user, 'func_upload');
		$uploadDir = $this->config->item('upload_dir');
		$domain = $this->config->item('base_domain');
		$fileElementName = 'fileUpload';
		$el = $this->input->get('el', TRUE);
		if($el) {
			$fileElementName = $el;
		}
		if($el=='adUpload') {
			$uploadDir = $this->config->item('upload_ads_dir');
		}
		$uploadStorePath = $uploadDir;
		$error = "";
		$msg = "";
		//$error = $uploadStorePath;
		
		$config['upload_path'] = $uploadStorePath;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name'] = TRUE;
		
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload($fileElementName)) {
			$error = $this->upload->display_errors('', '');
		} else {
			$data = $this->upload->data();
			$msg = '上传成功！';
			$error = 'null';
			$fileName = $domain . $this->root_path . $uploadDir . '/' . $data['file_name'];
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_PIC_UPLOAD'
		));
		
		$ret = '{';
		$ret .= "	error:\"{$error}\",";
		$ret .= "	msg:\"{$msg}\",";
		$ret .= "	data:\"{$fileName}\"";
		$ret .= '}';
		echo $ret;
	}
	
	public function sendNotice() {
		$this->check->permission($this->user, 'func_send_notice');
		$guid = $this->input->post('GUID', TRUE);
		$noticeContent = $this->input->post('noticeContent', TRUE);
		$noticeReciever = $this->input->post('noticeReciever', TRUE);
		$noticePostTime = time();
		if($noticeReciever=='all') {
			$noticeEndTime = $noticePostTime + 24 * 60 * 60;
		} else {
			$noticeEndTime = strtotime('2030-12-31 23:59:59');
		}
		$this->load->model('web/notice', 'notice');
		$parameter = array(
			'notice_content'		=>	$noticeContent,
			'notice_endtime'		=>	$noticeEndTime,
			'notice_posttime'		=>	$noticePostTime,
			'notice_sender_id'		=>	$guid,
			'notice_reciever_id'	=>	$noticeReciever
		);
		if($this->notice->insert($parameter)) {
			$data = array(
				'result'	=>	'API_NOTICE_SEND',
				'message'	=>	'发送成功'
			);
		} else {
			$data = array(
				'result'	=>	'API_NOTICE_ERROR',
				'message'	=>	'发送失败'
			);
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_SEND_MESSAGE'
		));
		echo json_encode($data);
	}
	
	public function deleteNotice() {
		$this->check->permission($this->user, 'func_delete_notice');
		$noticeId = $this->input->post('noticeId', TRUE);
		$this->load->model('web/notice', 'notice');
		if($this->notice->delete($noticeId)) {
			$data = array(
				'result'	=>	'API_NOTICE_DELETED',
				'message'	=>	'已删除',
				'id'		=>	$noticeId
			);
		} else {
			$data = array(
				'result'	=>	'API_NOTICE_ERROR',
				'message'	=>	'删除失败'
			);
		}
		echo json_encode($data);
	}
	
	public function getMailTemplate() {
		$this->check->permission($this->user, 'func_get_mailtemplate');
		$templateId = $this->input->post('tid', TRUE);
		$this->load->model('web/mail_template', 'mail_template');
		$row = $this->mail_template->get($templateId);
		echo html_entity_decode($row->template_content, ENT_QUOTES);
	}
	
	public function getAccountMail() {
		$this->load->model('web/mail');
		$parameter = array(
			'distinct'		=>	'account_mail',
			'select'		=>	'account_mail,account_firstname,account_lastname',
			'where'			=>	"account_firstname <> '' AND account_lastname <> '' AND account_firstname <> 'NULL' AND account_lastname <> 'NULL'"
		);
		$result = $this->mail->getAllResult($parameter);
		$retContent = '';
		foreach($result as $row) {
			if(empty($retContent)) {
				$retContent .= "<{$row->account_firstname} {$row->account_lastname}>{$row->account_mail}";
			} else {
				$retContent .= ",<{$row->account_firstname} {$row->account_lastname}>{$row->account_mail}";
			}
		}
		echo $retContent;
	}
}
?>