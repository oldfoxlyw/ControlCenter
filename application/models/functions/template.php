<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('PRC');

class Template extends CI_Model {
	private $root_path = null;
	public function __construct() {
		parent::__construct();
		$this->root_path = $this->config->item('root_path');
	}
	public function getAdditionalMenu($user, $permissionName) {
		$retMenuList = "";
		$leftReference = "admin_web_left";
		$cookieArray = $this->input->cookie('scc_default_platform', TRUE);
		if($cookieArray=='2') {
			$leftReference = 'admin_report_left';
		}elseif($cookieArray=='3') {
			$leftReference = 'admin_operation_left';
		}
		
		if(!empty($user->additional_permission)) {
			$permissionList = explode(',', $user->additional_permission);
		} else {
			$permissionList = explode(',', $user->permission_list);
		}
		$this->load->model('web/notice', 'notice');
		$noticeCount = $this->notice->getRecieveTotal($user->GUID);
		$noticeResult = $this->notice->getRecieveResult($user->GUID);
		$this->load->model('web/admin_user', 'admin_user');
		$userResult = $this->admin_user->getAllResult();
		$platformResult = array(
			array(
				'platform_id'	=>	'1',
				'platform_name'	=>	'切换到网站管理中心'
			),
			array(
				'platform_id'	=>	'2',
				'platform_name'	=>	'切换到报表中心'
			),
			array(
				'platform_id'	=>	'3',
				'platform_name'	=>	'切换到运维中心'
			)
		);
		
		$parser = Array(
			'title'					=>		'后台管理菜单',
			'userName'				=>		$user->user_name,
			'userPermissionName'	=>		$user->permission_name,
			'notice_count'			=>		$noticeCount,
			'user_result'			=>		$userResult,
			'notice_result'			=>		$noticeResult,
			'platform_result'		=>		$platformResult,
			'guid'					=>		$user->GUID,
			'root_path'				=>		$this->root_path
		);
		$permission = $this->config->item('permission');
		$permissionDetail = $this->config->item('permission_detail');
		$root_path = $this->config->item('root_path');
		foreach ($permission as $value) {
			if($permissionName==$value) {
				$currentPage = " class=\"heading selected\"";
			} else {
				$currentPage = '';
			}
			if($user->permission_list=='All' || in_array($value, $permissionList)) {
				if(in_array($value, array('web_notices', 'web_settings', 'web_settings_action'))) {
					if($user->user_founder=='1') {
						if($permissionName==$value) {
							$parser[$value] = "<li><a href=\"{$root_path}{$permissionDetail[$value][1]}\" title=\"{$permissionDetail[$value][0]}\" class=\"current\">{$permissionDetail[$value][0]}</a></li>";
						} else {
							$parser[$value] = "<li><a href=\"{$root_path}{$permissionDetail[$value][1]}\" title=\"{$permissionDetail[$value][0]}\">{$permissionDetail[$value][0]}</a></li>";
						}
					} else {
						$parser[$value] = '';
					}
				} else {
					if($permissionName==$value) {
						$parser[$value] = "<li><a href=\"{$root_path}{$permissionDetail[$value][1]}\" title=\"{$permissionDetail[$value][0]}\" class=\"current\">{$permissionDetail[$value][0]}</a></li>";
					} else {
						$parser[$value] = "<li><a href=\"{$root_path}{$permissionDetail[$value][1]}\" title=\"{$permissionDetail[$value][0]}\">{$permissionDetail[$value][0]}</a></li>";
					}
				}
			} else {
				$parser[$value] = '';
			}
		}
		$retMenuList = $this->load->view($leftReference, $parser, true);
		return $retMenuList;
	}
}
?>