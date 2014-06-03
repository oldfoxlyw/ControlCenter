<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'operation_product';
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
		$this->load->model('product', 'product');
	}
	
	public function index() {
		$page = $this->input->get('page', TRUE);
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$productUpdate = 'update';
			$PID = $this->input->get('pid', TRUE);
			$row = $this->product->get($PID);
			$productId = $row->product_id;
			$productVersion = $row->product_version;
			$productName = $row->product_name;
			$productComment = $row->product_comment;
			$productType = $row->product_type;
			$productWeb = $row->product_web;
			$productUninstallPage = $row->product_uninstall_page;
			$surveyId = $row->product_uninstall_survey;
			$productControlCommand = $row->product_control_command;
			$productDefaultMessage = $row->product_default_message;
			$productMessageUrl = $row->product_message_url;
			$productMessageText = $row->product_message_text;
		}
		/**
		 * 
		 * 分页程序
		 * @novar
		 */
		$rowTotal = $this->product->getTotal();
		$itemPerPage = $this->config->item('pagination_per_page');
		$pageTotal = intval($rowTotal/$itemPerPage);
		if($rowTotal%$itemPerPage) $pageTotal++;
		if($pageTotal > 0) {
			if(empty($page) || !is_numeric($page) || intval($page) < 1) {
				$page = 1;
			} elseif($page > $pageTotal) {
				$page = $pageTotal;
			} else {
				$page = intval($page);
			}
			$offset = $itemPerPage * ($page - 1);
		} else {
			$offset = 0;
		}
		$result = $this->product->getAllResult(null, $itemPerPage, $offset);
		$this->load->helper('pagination');
		$pagination = getPage($page, $pageTotal);
		$copyright = $this->load->view("std_copyright", '', true);
		
		$this->load->model('survey');
		$surveyResult = $this->survey->getSurvey();
		
		if($productUpdate) {
			$functionResult = $this->product->getFunctions(array(
				'product_id'		=>	$productId,
				'product_version'	=>	$productVersion
			));
		}
		
		$data = array(
			'userName'				=>	$this->user->user_name,
			'root_path'				=>	$this->root_path,
			'result'				=>	$result,
			'survey_result'			=>	$surveyResult,
			'func_result'			=>	$functionResult,
			'product_update'		=>	$productUpdate,
			'pid'					=>	$PID,
			'product_id'			=>	$productId,
			'product_version'		=>	$productVersion,
			'product_name'			=>	$productName,
			'product_comment'		=>	$productComment,
			'product_type'			=>	$productType,
			'product_web'			=>	$productWeb,
			'product_uninstall_page'=>	$productUninstallPage,
			'survey_id'				=>	$surveyId,
			'control_command'		=>	$productControlCommand,
			'product_default_message'=>	$productDefaultMessage,
			'product_message_url'	=>	$productMessageUrl,
			'product_message_text'	=>	$productMessageText,
			'pagination'			=>	$pagination,
			'copyright'				=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 产品管理',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'产品管理',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function action() {
		$action = $this->input->get('action', TRUE);
		$PID = $this->input->get('pid', TRUE);
		switch($action) {
			case 'delete':
				$this->product->delete($PID);
				$this->logs->write(array(
					'log_type'	=>	'SCC_PRODUCT_DELETE'
				));
				break;
			case 'index_hidden':
				$this->product->update(array(
					'product_index_show'	=>	0
				), $PID);
				break;
			case 'index_show':
				$this->product->update(array(
					'product_index_show'	=>	1
				), $PID);
				break;
		}
		redirect('/operation/products');
	}
	
	public function submit() {
		$productUpdate			=	$this->input->post('productUpdate', TRUE);
		$PID					=	$this->input->post('PID', TRUE);
		$productId				=	$this->input->post('productId', TRUE);
		$productVersion			=	$this->input->post('productVersion', TRUE);
		$productName			=	$this->input->post('productName', TRUE);
		$productComment			=	$this->input->post('productComment', TRUE);
		$productType			=	$this->input->post('productType', TRUE);
		$productWeb				=	$this->input->post('productWeb', TRUE);
		$productUninstallPage	=	$this->input->post('productUninstallPage', TRUE);
		$surveyId				=	$this->input->post('surveyId', TRUE);
		
		$controlForbiddenPurchase	=	$this->input->post('controlForbiddenPurchase', TRUE);
		$controlPopupPurchase		=	$this->input->post('controlPopupPurchase', TRUE);
		$controlUpdatePurchase		=	$this->input->post('controlUpdatePurchase', TRUE);
		$controlFunctionPurchase	=	$this->input->post('controlFunctionPurchase', TRUE);
		$functionDisabledPurchase	=	$this->input->post('functionDisabledPurchase', TRUE);
		
		$controlForbiddenGiveaway	=	$this->input->post('controlForbiddenGiveaway', TRUE);
		$controlPopupGiveaway		=	$this->input->post('controlPopupGiveaway', TRUE);
		$controlUpdateGiveaway		=	$this->input->post('controlUpdateGiveaway', TRUE);
		$controlFunctionGiveaway	=	$this->input->post('controlFunctionGiveaway', TRUE);
		$functionDisabledGiveaway	=	$this->input->post('functionDisabledGiveaway', TRUE);
		
		$controlForbiddenFree	=	$this->input->post('controlForbiddenFree', TRUE);
		$controlPopupFree		=	$this->input->post('controlPopupFree', TRUE);
		$controlUpdateFree		=	$this->input->post('controlUpdateFree', TRUE);
		$controlFunctionFree	=	$this->input->post('controlFunctionFree', TRUE);
		$functionDisabledFree	=	$this->input->post('functionDisabledFree', TRUE);
		
		$productDefaultMessage	=	$this->input->post('productDefaultMessage', TRUE);
		$productMessageAll		=	$this->input->post('productMessageAll', TRUE);
		$productMessageUrl		=	$this->input->post('productMessageUrl', TRUE);
		$productMessageTextTitle=	$this->input->post('productMessageTextTitle', TRUE);
		$productMessageTextTime	=	date('Y-m-d H:i:s', time());
		$productMessageText		=	$this->input->post('productMessageText', TRUE);
		
		if(!empty($productMessageTextTitle) && !empty($productMessageText)) {
			$productMessageText = "{$productMessageTextTitle}@@{$productMessageTextTime}@@{$productMessageText}";
		}
		
		$command = '';
		$commandArray = array();
		if($controlForbiddenPurchase=='1') {
			array_push($commandArray, 'CONTROL_PURCHASE_FORBIDDEN');
		}
		if($controlPopupPurchase=='1') {
			array_push($commandArray, 'CONTROL_PURCHASE_POPUP_BUY');
		}
		if($controlUpdatePurchase=='1') {
			array_push($commandArray, 'CONTROL_PURCHASE_UPDATE');
		}
		
		if($controlForbiddenGiveaway=='1') {
			array_push($commandArray, 'CONTROL_GIVEAWAY_FORBIDDEN');
		}
		if($controlPopupGiveaway=='1') {
			array_push($commandArray, 'CONTROL_GIVEAWAY_POPUP_BUY');
		}
		if($controlUpdateGiveaway=='1') {
			array_push($commandArray, 'CONTROL_GIVEAWAY_UPDATE');
		}
		
		if($controlForbiddenFree=='1') {
			array_push($commandArray, 'CONTROL_FREE_FORBIDDEN');
		}
		if($controlPopupFree=='1') {
			array_push($commandArray, 'CONTROL_FREE_POPUP_BUY');
		}
		if($controlUpdateFree=='1') {
			array_push($commandArray, 'CONTROL_FREE_UPDATE');
		}
		
		$command .= implode('@@', $commandArray);
		
		$commandArray = array();
		if($controlFunctionPurchase=='1') {
			$funcArray = explode(',', $functionDisabledPurchase);
			foreach($funcArray as $item) {
				$item = strtoupper($item);
				array_push($commandArray, "CONTROL_PURCHASE_DISABLED_{$item}");
			}
			$command .= '@@' . implode('@@', $commandArray);
		}
	
		$commandArray = array();
		if($controlFunctionGiveaway=='1') {
			$funcArray = explode(',', $functionDisabledGiveaway);
			foreach($funcArray as $item) {
				$item = strtoupper($item);
				array_push($commandArray, "CONTROL_GIVEAWAY_DISABLED_{$item}");
			}
			$command .= '@@' . implode('@@', $commandArray);
		}
	
		$commandArray = array();
		if($controlFunctionFree=='1') {
			$funcArray = explode(',', $functionDisabledFree);
			foreach($funcArray as $item) {
				$item = strtoupper($item);
				array_push($commandArray, "CONTROL_FREE_DISABLED_{$item}");
			}
			$command .= '@@' . implode('@@', $commandArray);
		}
		
		if(!empty($command)) {
			$checkCode = strtoupper(do_hash($command, 'md5'));
			$command .= "@@@{$checkCode}";
		}
		
		if($productUpdate=='update') {
			$this->load->library('Guid');
			$this->load->library('encrypt');
			$messageGuid = $this->guid->toString();
			$parameter = array(
				'product_id'			=>	$productId,
				'product_name'			=>	$productName,
				'product_version'		=>	$productVersion,
				'product_comment'		=>	$productComment,
				'product_type'			=>	$productType,
				'product_uninstall_page'=>	$productUninstallPage,
				'product_web'			=>	$productWeb,
				'product_uninstall_survey'=>$surveyId,
				'product_control_command'=>	$command,
				'product_message_id'	=>	$messageGuid,
				'product_message_url'	=>	$productMessageUrl,
				'product_message_text'	=>	$productMessageText,
				'product_default_message'=>	$productDefaultMessage
			);
			if($this->product->update($parameter, $PID)) {
				
			}
			if($productMessageAll=='1') {
				$parameter = array(
					'product_message_id'	=>	$messageGuid,
					'product_message_url'	=>	$productMessageUrl,
					'product_message_text'	=>	$productMessageText,
					'product_default_message'=>	$productDefaultMessage
				);
				if($this->product->update($parameter, $productId)) {
					
				}
			}
		} else {
			$this->load->library('Guid');
			$this->load->library('encrypt');
			$guid = $this->guid->toString();
			$messageGuid = $this->guid->toString();
			$key = $productId . '_' . $productVersion;
			$accessToken = $this->encrypt->encode(md5($guid), $key);
			$accessToken = replace_invalid_characters($accessToken);
			$parameter = array(
				'product_id'			=>	$productId,
				'product_name'			=>	$productName,
				'product_version'		=>	$productVersion,
				'product_comment'		=>	$productComment,
				'product_type'			=>	$productType,
				'product_uninstall_page'=>	$productUninstallPage,
				'product_web'			=>	$productWeb,
				'product_uninstall_survey'=>$surveyId,
				'product_control_command'=>	$command,
				'product_access_token'	=>	$accessToken,
				'product_guid'			=>	$guid,
				'product_message_id'	=>	$messageGuid,
				'product_message_url'	=>	$productMessageUrl,
				'product_message_text'	=>	$productMessageText,
				'product_default_message'=>	$productDefaultMessage
			);
			if($this->product->insert($parameter)) {
				
			}
			if($productMessageAll=='1') {
				$parameter = array(
					'product_message_id'	=>	$messageGuid,
					'product_message_url'	=>	$productMessageUrl,
					'product_message_text'	=>	$productMessageText,
					'product_default_message'=>	$productDefaultMessage
				);
				if($this->product->update($parameter, $productId)) {
					
				}
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_PRODUCT_SUBMIT'
		));
		redirect('/operation/products');
	}
}
?>