<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Survey_adds extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'operation_survey_add';
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
		$this->load->model('survey', 'survey');
	}
	
	public function index() {
		$action = $this->input->get('action', TRUE);
		if($action == 'modify') {
			$surveyId = $this->input->get('sid', TRUE);
			$surveyResult = $this->survey->getSurvey(array(
				'survey_id'	=>	$surveyId
			));
			$surveyComment = $surveyResult[0]->survey_comment;
			$surveyTemplateId = $surveyResult[0]->survey_template_id;
			$result = $this->survey->getQuestion(array(
				'survey_id'	=>	$surveyId
			));
			$questionTotal = strval(count($result));
			$surveyUpdate = 'update';
		}
		
		$this->load->model('operation/survey_template', 'survey_template');
		$templateResult = $this->survey_template->getAllResult();
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'survey_id'			=>	$surveyId,
			'survey_update'		=>	$surveyUpdate,
			'survey_comment'	=>	$surveyComment,
			'template_id'		=>	$surveyTemplateId,
			'template_result'	=>	$templateResult,
			'question_total'	=>	$questionTotal,
			'result'			=>	$result,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 新建调查问卷',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'新建调查问卷',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function submit() {
		$surveyUpdate		= $this->input->post('surveyUpdate', TRUE);
		$surveyId			= $this->input->post('surveyId', TRUE);
		$surveyComment		= $this->input->post('surveyComment', TRUE);
		$surveyTemplateId	= $this->input->post('surveyTemplateId', TRUE);
		$questionTotal		= intval($this->input->post('questionTotal', TRUE));
		
		$this->load->library('Guid');
		$guid = $this->guid->toString();
		
		if($surveyUpdate=='update') {
			$this->survey->deleteQuestion(array(
				'survey_id'	=>	$surveyId
			));
			$parameter = array(
				'survey_comment'	=>	$surveyComment,
				'survey_template_id'=>	$surveyTemplateId
			);
			if($this->survey->updateSurvey($parameter, $surveyId)) {
				
			}
		} else {
			$parameter = array(
				'survey_id'			=>	$guid,
				'survey_comment'	=>	$surveyComment,
				'survey_template_id'=>	$surveyTemplateId,
				'survey_posttime'	=>	time()
			);
			if($this->survey->insertSurvey($parameter)) {
				
			}
		}
		for($i=1; $i<=$questionTotal; $i++) {
			$questionId = $this->input->post("questionId_{$i}", TRUE);
			$questionContent = $this->input->post("questionContent_{$i}", TRUE);
			$optionTotal = intval($this->input->post("optionId_{$i}", TRUE))-1;
			if(!empty($questionContent)) {
				$jsonData = "{\"field\": [";
				$tempArray = array();
				for($j=1; $j<=$optionTotal; $j++) {
					$optionType = $this->input->post("optionType_{$i}_{$j}", TRUE);
					$optionVariable = $this->input->post("optionVariable_{$i}_{$j}", TRUE);
					$optionTitle = $this->input->post("optionTitle_{$i}_{$j}", TRUE);
					if(!empty($optionType) && !empty($optionVariable) && !empty($optionTitle)) {
						$data = "{";
						$data .= "	\"type\": \"{$optionType}\",";
						$data .= "	\"variable\": \"{$optionVariable}\",";
						$data .= "	\"title\": \"{$optionTitle}\"";
						$data .= "}";
						$tempArray[] = $data;
					}
				}
				$data = implode(',', $tempArray);
				$jsonData .= $data;
				$jsonData .= "]}";
				
				if($surveyUpdate=='update') {
					$parameter = array(
						'question_content'	=>	$questionContent,
						'question_options'	=>	$jsonData,
						'question_survey_id'=>	$surveyId
					);
					if($this->survey->insertQuestion($parameter)) {
						
					}
				} else {
					$parameter = array(
						'question_content'	=>	$questionContent,
						'question_options'	=>	$jsonData,
						'question_survey_id'=>	$guid
					);
					if($this->survey->insertQuestion($parameter)) {
						
					}
				}
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_SURVEY_SUBMIT'
		));
		redirect('/operation/surveys');
	}
}
?>