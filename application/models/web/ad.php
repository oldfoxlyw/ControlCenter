<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ad extends CI_Model {
	private $tableName = 'scc_ads';
	private $relativeName = 'scc_ads_news';
	private $viewName = 'scc_ads_channel_view';
	private $webId = null;
	
	public function __construct() {
		parent::__construct();
	}
	
	public function __init($webId) {
		$this->webId = $webId;
	}
	
	public function getTotal() {
		$sql = "select count(*) as count from scc_ads";
		$query = $this->db->query($sql);
		$row = $query->row();
		if(!empty($row->count)) {
			return $row->count;
		} else {
			return 0;
		}
	}

	public function getAllResult($limit = 0, $offset = 0, $channelId = 0, $type = 'data') {
		if($channelId!=0) {
			$this->db->where('channel_id', $channelId);
		}
		$this->db->order_by('ad_id', 'desc');
		if($limit==0 && $offset==0) {
			$query = $this->db->get($this->viewName);
		} else {
			$query = $this->db->get($this->viewName, $limit, $offset);
		}
		if($query->num_rows() > 0) {
			if($type=='data') {
				return $query->result();
			} elseif($type=='json') {
				$result = $query->result();
				$data = array(
					'field'		=>	array()
				);
				foreach($result as $key=>$row) {
					$data['field'][$key]['id'] = $row->ad_id;
					$data['field'][$key]['pic_path'] = $row->ad_pic_path;
					$data['field'][$key]['pic_width'] = $row->ad_pic_width;
					$data['field'][$key]['pic_height'] = $row->ad_pic_height;
					$data['field'][$key]['link'] = $row->ad_link;
					$data['field'][$key]['channel_id'] = $row->ad_channel_id;
				}
				return json_encode($data);
			}
		} else {
			return false;
		}
	}
	
	public function getAllResultNews($newsId = 0, $type = 'data') {
		if($newsId!=0) {
			$this->db->where('news_id', $newsId);
		}
		$this->db->order_by('ad_id', desc);
		$query = $this->db->get($this->viewName);
		if($query->num_rows() > 0) {
			if($type=='data') {
				return $query->result();
			} elseif($type=='json') {
				$result = $query->result();
				$data = array(
					'field'		=>	array()
				);
				foreach($result as $key=>$row) {
					$data['field'][$key]['id'] = $row->ad_id;
					$data['field'][$key]['pic_path'] = $row->ad_pic_path;
					$data['field'][$key]['pic_width'] = $row->ad_pic_width;
					$data['field'][$key]['pic_height'] = $row->ad_pic_height;
					$data['field'][$key]['link'] = $row->ad_link;
					$data['field'][$key]['channel_id'] = $row->ad_channel_id;
				}
				return json_encode($data);
			}
		} else {
			return false;
		}
	}

	public function get($id, $type = 'data') {
		if(is_numeric($id)) {
			$this->db->where('ad_id', $id);
			$query = $this->db->get($this->viewName);
			if($query->num_rows() > 0) {
				if($type=='data') {
					return $query->row();
				} elseif($type=='json') {
					$row = $query->row();
					$data = array();
					$data['id'] = $row->ad_id;
					$data['pic_path'] = $row->ad_pic_path;
					$data['pic_width'] = $row->ad_pic_width;
					$data['pic_height'] = $row->ad_pic_height;
					$data['link'] = $row->ad_link;
					$data['channel_id'] = $row->ad_channel_id;
					return json_encode($data);
				}
			} else {
				return false;
			}
		}
	}

	public function insert($row) {
		if(!empty($row)) {
			return $this->db->insert($this->tableName, $row);
		} else {
			return false;
		}
	}

	public function update($row, $id) {
		if(!empty($row)) {
			$this->db->where('ad_id', $id);
			return $this->db->update($this->tableName, $row);
		} else {
			return false;
		}
	}

	public function delete($id) {
		if(is_numeric($id)) {
			$this->db->where('ad_id', $id);
			return $this->db->delete($this->tableName);
		} else {
			return false;
		}
	}
}
?>