<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Check_user extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function validate() {
		$this->load->helper('security');
		$this->load->helper('cookie');
		$redirectUrl = urlencode($this->config->item('root_path') . 'login');
		if(!$this->input->cookie('scc_user', TRUE)) {
			redirect("/message?info=SCC_USER_EXPIRED&redirect={$redirectUrl}");
		} else {
			$cookie = $this->input->cookie('scc_user', TRUE);
			$json = json_decode($cookie);
			$userName = $this->db->escape($json->user_name);
			$sql = "select * from scc_user_permission where user_name={$userName}";
			$query = $this->db->query($sql);
			if($query->num_rows() > 0) {
				$row = $query->row();
				$checkCode = $json->user_name . '#' . $row->user_pass;
				$checkCode = strtoupper(do_hash($checkCode, 'md5'));
				if($checkCode != $json->check_code) {
					redirect("/message?info=SCC_USER_CHECKCODE_INVALID&redirect={$redirectUrl}");
				} else {
					$this->load->model('web/admin_user', 'admin_user');
					if(!$this->admin_user->freezed(array('user_name'=>$row->user_name))) {
						 redirect("/message?info=SCC_USER_FREEZED&redirect={$redirectUrl}");
					} else {
						return $row;
					}
				}
			} else {
				redirect("/message?info=SCC_USER_INVALID&redirect={$redirectUrl}");
			}
		}
	}
	public function permission($user, $permissionName) {
		$userPermission = $user->user_permission;
		if(empty($userPermission)) {
			$userPermission = '1';
		}
		if(!empty($user->additional_permission)) {
			$permission = explode(',', $user->additional_permission);
		} else {
			$permission = explode(',', $user->permission_list);
		}
		switch($userPermission) {
			case '999':
				if(in_array($permissionName, array('web_notices', 'web_settings', 'web_settings_action'))) {
					if($user->user_founder=='1') {
						return true;
					} else {
						return false;
					}
				} else {
					return true;
				}
				break;
			default:
				if(in_array($permissionName, $permission)) {
					return true;
				} else {
					$redirectUrl = urlencode($this->config->item('root_path') . 'login');
					redirect("/message?info=SCC_NO_PERMISSION&redirect={$redirectUrl}&auto_redirect=1&auto_delay=10");
				}
		}
	}
	public function ip() {
		$enabled = $this->config->item('ip_check_enable');
		if($enabled) {
			$currentIp = $this->input->ip_address();
			$allowIpList = $this->config->item('ip_list');
			if(!in_array($currentIp, $allowIpList)) {
				$redirectUrl = urlencode($this->config->item('root_path') . 'login');
				redirect("/message?info=SCC_IP_INVALID&redirect={$redirectUrl}&auto_redirect=1&auto_delay=10");
			}
		}
	}
	public function configuration($user) {
		$temp = array();
		$sql = "select * from scc_config where config_selected=1";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$rowConfig = $query->row();
			if($rowConfig->config_close_scc=='1') {
				if($user->user_founder=='1') {
					$temp['state'] = true;
				} else {
					$temp['state'] = false;
				}
			} else {
				$temp['state'] = true;
			}
			$temp['record'] = $rowConfig;
		} else {
			$temp['state'] = false;
			$temp['record'] = array();
		}
		return $temp;
	}
	public function checkDefaultWeb() {
		$this->load->helper('cookie');
		if(!$this->input->cookie('scc_default_web', TRUE)) {
			$redirectUrl = urlencode($this->config->item('root_path') . 'web/webs');
			redirect("/message?info=SCC_DEFAULT_WEB_INVALID&redirect={$redirectUrl}");
		} else {
			return $this->input->cookie('scc_default_web', TRUE);
		}
	}
}
?>