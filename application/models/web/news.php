<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Model {
	private $tableName = 'scc_news';
	private $relativeName = 'scc_ads_news';
	private $viewName = 'scc_news_view';
	private $webId = null;
	
	public function __construct() {
		parent::__construct();
	}
	
	public function __init($webId) {
		$this->webId = $webId;
	}
	
	public function getTotal() {
		$sql = "select count(*) as count from scc_news";
		$query = $this->db->query($sql);
		$row = $query->row();
		if(!empty($row->count)) {
			return $row->count;
		} else {
			return 0;
		}
	}

	public function getTotalByWeb() {
		$this->db->where('web_id', $this->webId);
		$this->db->from($this->viewName);
		return $this->db->count_all_results();
	}
	
	public function getAllResult($limit, $offset, $type = 'data') {
		$this->db->where('web_id', $this->webId);
		$this->db->order_by('news_id', 'desc');
		$query = $this->db->get($this->viewName, $limit, $offset);
		if($query->num_rows() > 0) {
			if($type=='data') {
				return $query->result();
			} elseif($type=='json') {
				
			}
		} else {
			return false;
		}
	}
	
	public function getNewsAdsResult($newsId = 0, $type = 'data') {
		if($newsId != 0) {
			$this->db->where('out_news_id', $newsId);
		}
		$this->db->order_by('out_ad_id');
		$query = $this->db->get($this->relativeName);
		if($query->num_rows() > 0) {
			if($type=='data') {
				return $query->result();
			} else {
				$result = $query->result();
				$data = array(
					'field'		=>	array()
				);
				foreach($result as $key=>$row) {
					$data['field'][$key]['ad_id'] = $row->out_ad_id;
					$data['field'][$key]['news_id'] = $row->out_news_id;
				}
				return json_encode($data);
			}
		}
	}
	
	public function get($id) {
		if(is_numeric($id)) {
			$this->db->where('news_id', $id);
			$query = $this->db->get($this->viewName);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function getNewsAds($newsId, $adsId) {
		if(is_numeric($newsId) && is_numeric($adsId)) {
			$this->db->where('out_ad_id', $adsId);
			$this->db->where('out_news_id', $newsId);
			$query = $this->db->get($this->relativeName);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function insert($row) {
		if(!empty($row)) {
			return $this->db->insert($this->tableName, $row);
		} else {
			return false;
		}
	}
	
	public function insertNewsAds($newsId, $adsId) {
		if(is_numeric($newsId) && is_numeric($adsId)) {
			$row = array(
				'out_ad_id'		=>	$adsId,
				'out_news_id'	=>	$newsId
			);
			return $this->db->insert($this->relativeName, $row);
		} else {
			return false;
		}
	}

	public function update($row, $id) {
		if(!empty($row)) {
			$this->db->where('news_id', $id);
			return $this->db->update($this->tableName, $row);
		} else {
			return false;
		}
	}

	public function scroll($id, $flag = true) {
		if(is_numeric($id)) {
			if($flag) {
				$parameter = array(
					'news_scroll_show'	=>	1
				);
			} else {
				$parameter = array(
					'news_scroll_show'	=>	0
				);
			}
			$this->db->where('news_id', $id);
			return $this->db->update($this->tableName, $parameter);
		} else {
			return false;
		}
	}
	
	public function delete($id) {
		if(is_numeric($id)) {
			$this->db->where('news_id', $id);
			return $this->db->delete($this->tableName);
		} else {
			return false;
		}
	}
	
	public function deleteNewsAds($newsId, $adsId) {
		if(is_numeric($newsId) && is_numeric($adsId)) {
			$this->db->where('out_ad_id', $adsId);
			$this->db->where('out_news_id', $newsId);
			return $this->db->delete($this->relativeName);
		} else {
			return false;
		}
	}
}
?>