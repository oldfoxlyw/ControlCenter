<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Survey extends CI_Model {
	private $tableName = 'sys_survey';
	private $questionName = 'sys_survey_question';
	private $templateName = 'sys_survey_template';
	private $questionView = 'survey_question_view';
	private $templateView = 'survey_template_view';
	private $productdb = null;
	
	public function __construct() {
		parent::__construct();
		$this->productdb = $this->load->database('productdb', true);
	}
	
	public function getSurveyTotal() {
		$this->productdb->from($this->tableName);
		return $this->productdb->count_all_results();
	}
	
	public function getSurvey($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['survey_id'])) {
			$this->productdb->where('survey_id', $parameter['survey_id']);
		}
		if($limit==0 && $offset==0) {
			$query = $this->productdb->get($this->templateView);
		} else {
			$query = $this->productdb->get($this->templateView, $limit, $offset);
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
	
	public function getQuestion($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['survey_id'])) {
			$this->productdb->where('question_survey_id', $parameter['survey_id']);
		}
		if(!empty($parameter['question_id'])) {
			$this->productdb->where('question_id', $parameter['question_id']);
		}
		if($limit==0 && $offset==0) {
			$query = $this->productdb->get($this->questionView);
		} else {
			$query = $this->productdb->get($this->questionView, $limit, $offset);
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
	
	public function insertSurvey($row) {
		if(!empty($row)) {
			return $this->productdb->insert($this->tableName, $row);
		} else {
			return false;
		}
	}
	
	public function insertQuestion($row) {
		if(!empty($row)) {
			return $this->productdb->insert($this->questionName, $row);
		} else {
			return false;
		}
	}
	
	public function updateSurvey($row, $id) {
		if(!empty($row)) {
			$this->productdb->where('survey_id', $id);
			return $this->productdb->update($this->tableName, $row);
		} else {
			return false;
		}
	}
	
	public function deleteSurvey($id) {
		if(!empty($id)) {
			$this->productdb->where('survey_id', $id);
			return $this->productdb->delete($this->tableName);
		} else {
			return false;
		}
	}
	
	public function deleteQuestion($parameter = null) {
		if(!empty($parameter['question_id'])) {
			$this->productdb->where('question_id', $parameter['question_id']);
		}
		if(!empty($parameter['survey_id'])) {
			$this->productdb->where('question_survey_id', $parameter['survey_id']);
		}
		return $this->productdb->delete($this->questionName);
	}
}
?>