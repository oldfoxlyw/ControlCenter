<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Surveys extends CI_Controller {
	private $root_path = null;
	
	public function __construct() {
		parent::__construct();
		$this->root_path = $this->config->item('root_path');
		$this->load->model('survey', 'survey');
		$this->load->model('logs', 'logs');
	}
	
	public function logSurvey() {
		$productId = '';
		$productVersion = '';
		$machineCode = '';
		$surveyId = '';
		$redirectPage = '';
		$relativePage			=	$this->input->server('REQUEST_URI');
		$relativeParameterArray	=	Array();
		foreach($_POST as $key=>$value) {
			switch($key) {
				case 'surveyId':
					$surveyId = $value;
					break;
				case 'product_id':
					$productId = $value;
					break;
				case 'product_version':
					$productVersion = $value;
					break;
				case 'machine':
					$machineCode = $value;
					break;
				case 'redirect':
					$redirectPage = $value;
					break;
			}
			if(is_numeric($value)) {
				$relativeParameterArray[] = "\"$key\": $value";
			} elseif(empty($value)) {
				$relativeParameterArray[] = "\"$key\": null";
			} else {
				$relativeParameterArray[] = "\"$key\": \"$value\"";
			}
		}
		$relativeParameter	=	'{' . implode(', ', $relativeParameterArray) . '}';
		$currentTime		=	time();
		$currentTimeLocal	=	date("Y-m-d H:i:s", $currentTime);
		
		$this->load->model('report/log_survey', 'log_survey');
		$parameter = array(
			'log_survey_id'		=>	$surveyId,
			'product_id'		=>	$productId,
			'product_version'	=>	$productVersion,
			'client_cpu_info'	=>	$machineCode,
			'log_parameter'		=>	$relativeParameter,
			'log_relative_page'	=>	$relativePage,
			'log_time'			=>	$currentTime,
			'log_localtime'		=>	$currentTimeLocal
		);
		$this->log_survey->insert($parameter);
		echo "<script>alert(\"Thank you, we will redirect you to the home page\");window.location='$redirectPage'</script>";
	}
	
	public function getSurveyTemplate() {
		$surveyId = trim($this->input->post('surveyId', TRUE));
		$productId = trim($this->input->post('product_id', TRUE));
		$productVersion = trim($this->input->post('product_version', TRUE));
		$machineCode = trim($this->input->post('machine', TRUE));
		$redirectPage = trim($this->input->post('redirect', TRUE));
		
		if($surveyId!=FALSE) {
			$this->load->model('operation/survey_template', 'template');
			$result = $this->template->getAllResult(array(
				'survey_id'	=>	$surveyId
			));
			if($result!=FALSE) {
				$row = $result[0];
				$templateContent = $row->template_content;
				$parser = array(
					'survey_id'			=>	$surveyId,
					'product_id'		=>	$productId,
					'product_version'	=>	$productVersion,
					'machine_code'		=>	$machineCode,
					'redirect_page'		=>	$redirectPage
				);
				$this->load->model('survey', 'survey');
				$result = $this->survey->getQuestion(array(
					'survey_id'	=>	$surveyId
				));
				foreach($result as $i => $row) {
					$currentQuestion = $i+1;
					$parser["question_$currentQuestion"] = $row->question_content;
					$opstionJson = json_decode($row->question_options);
					foreach($opstionJson->field as $key=>$value) {
						$currentOption = $key+1;
						if($value->type=='textarea') {
							$parser["option_{$currentQuestion}_{$currentOption}"] = "<textarea name=\"{$value->variable}\" id=\"{$value->variable}\" cols=\"50\" rows=\"5\"></textarea>";
						} elseif($value->type=='text') {
							$parser["option_{$currentQuestion}_{$currentOption}"] = "<input type=\"{$value->type}\" name=\"{$value->variable}\" id=\"{$value->variable}\" value=\"\" />";
						} else {
							$parser["option_{$currentQuestion}_{$currentOption}"] = "<input type=\"{$value->type}\" name=\"{$value->variable}\" id=\"{$value->variable}\" value=\"{$value->title}\" />";
						}
						$parser["option_{$currentQuestion}_{$currentOption}_title"] = $value->title;
					}
				}
				$this->load->helper('template');
				$templateContent = parseTemplate($templateContent, $parser);
				echo $templateContent;
			} else {
				$this->logs->write(array(
					'log_type'	=>	'SURVEY_TEMPLATE_ERROR_NOT_EXIST'
				));
				echo 'SURVEY_TEMPLATE_ERROR_NOT_EXIST';
			}
		} else {
			$this->logs->write(array(
				'log_type'	=>	'SURVEY_TEMPLATE_ERROR_NO_PARAM'
			));
			echo 'SURVEY_TEMPLATE_ERROR_NO_PARAM';
		}
	}
}
?>