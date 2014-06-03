<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Surveys extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $permissionName = 'report_survey';
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
		$this->load->model('report/log_survey', 'log_survey');
		$this->load->model('survey', 'survey');
	}
	
	public function index() {
		$post = $this->input->post('post_flag', TRUE);
		if(!empty($post)) {
			$surveyId		=	$this->input->post('surveyId', TRUE);
			$startTime		=	$this->input->post('startTime', TRUE);
			$startHours		=	$this->input->post('startHours', TRUE);
			$startMinutes	=	$this->input->post('startMinutes', TRUE);
			$startSeconds	=	$this->input->post('startSeconds', TRUE);
			$endTime		=	$this->input->post('endTime', TRUE);
			$endHours		=	$this->input->post('endHours', TRUE);
			$endMinutes		=	$this->input->post('endMinutes', TRUE);
			$endSeconds		=	$this->input->post('endSeconds', TRUE);
			
			if(!empty($surveyId)) {
				$data = array();
				$dataText = array();
				$questionText = array();
				$radioVariable = '';
				$textVariable = '';
				
				$selectCase = array();
				$parameter = array();
				
				$parameter['log_survey_id'] = $surveyId;
				array_push($selectCase, "选择问卷：{$surveyId}");
				
				if(!empty($startTime) && !empty($endTime)) {
					array_push($selectCase, "时间：{$startTime} {$startHours}:{$startMinutes}:{$startSeconds} 至 {$endTime} {$endHours}:{$endMinutes}:{$endSeconds}");
					$startTime = strtotime("$startTime $startHours:$startMinutes:$startSeconds");
					$endTime = strtotime("$endTime $endHours:$endMinutes:$endSeconds");
					if($startTime < $endTime) {
						$parameter['log_time_start'] = $startTime;
						$parameter['log_time_end'] = $endTime;
					}
				} else {
					array_push($selectCase, '全时间段');
				}
				$resultLog = $this->log_survey->getAllResult($parameter);
				$result = $this->survey->getQuestion(array(
					'survey_id'	=>	$surveyId
				));
				if($result!=FALSE) {
					foreach($result as $i => $row) {
						$jsonData = json_decode($row->question_options);
						$data[$row->question_content] = array();
						$questionText[$row->question_content] = array();
						$isRadioConfirm = false;
						for($j=0; $j<count($jsonData->field); $j++) {
							if($jsonData->field[$j]->type=='radio') {
								if($isRadioConfirm) continue;
								$radioVariable = $jsonData->field[$j]->variable;
								$data[$row->question_content][$jsonData->field[$j]->title] = 0;
								foreach($resultLog as $m => $rowLog) {
									$json = json_decode($rowLog->log_parameter);
									if(!empty($json->$radioVariable) && $json->$radioVariable != 'NULL' && $json->$radioVariable != 'null') {
										//echo "{$i}-{$j}-{$m}-{$json->$radioVariable}<br>";
										$data[$row->question_content][$json->$radioVariable] += 1;
									}
								}
								$isRadioConfirm = true;
							} elseif($jsonData->field[$j]->type=='checkbox') {
								$radioVariable = $jsonData->field[$j]->variable;
								$data[$row->question_content][$jsonData->field[$j]->title] = 0;
								foreach($resultLog as $m => $rowLog) {
									$json = json_decode($rowLog->log_parameter);
									if(!empty($json->$radioVariable) && $json->$radioVariable != 'NULL' && $json->$radioVariable != 'null') {
										//echo "{$i}-{$j}-{$m}-{$json->$radioVariable}<br>";
										$data[$row->question_content][$json->$radioVariable] += 1;
									}
								}
							} elseif($jsonData->field[$j]->type=='text' || $jsonData->field[$j]->type=='textarea') {
								$textVariable = $jsonData->field[$j]->variable;
								$questionText[$row->question_content][$jsonData->field[$j]->title] = array();
								foreach($resultLog as $rowLog) {
									$json = json_decode($rowLog->log_parameter);
									if(!empty($json->$textVariable) && $json->$textVariable != 'NULL' && $json->$textVariable != 'null') {
										array_push($questionText[$row->question_content][$jsonData->field[$j]->title], array($json->$textVariable, $rowLog->log_localtime));
									}
								}
							}
						}
					}
				}
			}
		}
		$surveyResult = $this->survey->getSurvey();
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'			=>	$this->user->user_name,
			'root_path'			=>	$this->root_path,
			'survey_result'		=>	$surveyResult,
			'select_case'		=>	$selectCase,
			'survey_id'			=>	$surveyId,
			'result'			=>	$data,
			'question'			=>	$questionText,
			'copyright'			=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 调查问卷统计报告',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'调查问卷统计报告',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
}
?>