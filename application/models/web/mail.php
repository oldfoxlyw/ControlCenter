<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mail extends CI_Model {
	private $tableName = 'web_accounts';
	private $accountdb = null;
	private $fobiddenEmail = array();
	
	public function __construct() {
		parent::__construct();
		$this->accountdb = $this->load->database('accountdb', true);
		$this->fobiddenEmail = $this->config->item('fobidden_email');
	}
	
	public function getTotal() {
		$this->accountdb->from($this->tableName);
		return $this->accountdb->count_all_results();
	}
	
	public function getAllResult($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['distinct'])) {
			$this->accountdb->distinct();
		}
		if(!empty($parameter['select'])) {
			$this->accountdb->select($parameter['select']);
		}
		if(!empty($parameter['where'])) {
			$this->accountdb->where($parameter['where']);
		}
		if($parameter['accept_mail']===1 || $parameter['accept_mail']===0) {
			$this->accountdb->where('accept_mail', $parameter['accept_mail']);
		}
		$this->accountdb->order_by('account_regtime', 'desc');
		if($limit==0 && $offset==0) {
			$query = $this->accountdb->get($this->tableName);
		} else {
			$query = $this->accountdb->get($this->tableName, $limit, $offset);
		}
		if($query->num_rows() > 0) {
			if($type=='data') {
				return $query->result();
			} elseif($type=='json') {
				
			}
		} else {
			return false;
		}
	}
	
	public function get($id) {
		if(!empty($id)) {
			$this->accountdb->where('GUID', $id);
			$query = $this->accountdb->get($this->tableName);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		}
	}
	
	public function insert($row) {
		if(!empty($row)) {
			return $this->accountdb->insert($this->tableName, $row);
		} else {
			return false;
		}
	}

	public function update($row, $id) {
		if(!empty($row)) {
			$this->accountdb->where('GUID', $id);
			return $this->accountdb->update($this->tableName, $row);
		} else {
			return false;
		}
	}
	
	public function delete($id) {
		if(!empty($id)) {
			$this->accountdb->where('GUID', $id);
			return $this->accountdb->delete($this->tableName);
		} else {
			return false;
		}
	}
	
	public function autoSendMail($parameter) {
		if(!empty($parameter)) {
			$this->load->model('web/auto', 'auto');
			$this->load->helper('template');
			$row = $this->auto->get($parameter['auto_id']);
			if($row!=FALSE) {
				$readerName = $row->template_reader;
				$readerName = parseTemplate($readerName, $parameter['reader_name_parser']);
				$mailSubject = $row->template_subject;
				$templateContent = $row->template_content;
				$templateContent = parseTemplate($templateContent, $parameter['template_parser']);
				
				$config = array(
					'protocol'		=>	'smtp',
					'smtp_host'		=>	$row->smtp_host,
					'smtp_user'		=>	$row->smtp_user,
					'smtp_pass'		=>	$row->smtp_pass,
					'mailtype'		=>	'html',
					'validate'		=>	TRUE
				);
				$this->load->library('email');
				$this->email->initialize($config);
				
				foreach($parameter['mail_list'] as $accountName => $accountMail) {
					if(!in_array($accountMail, $this->fobiddenEmail)) {
						$this->email->clear();
						$this->email->from($row->smtp_from, $row->smtp_fromName);
						$this->email->to($accountMail);
						$this->email->subject($mailSubject);
						$this->email->message($templateContent);
						if(!$this->email->send()) {
							return false;
						} else {
							return true;
						}
					}
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
?>