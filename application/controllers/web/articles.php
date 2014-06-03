<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends CI_Controller {
	private $user = null;
	private $_CONFIG = null;
	private $webId = null;
	private $permissionName = 'web_articles';
	private $root_path = null;
	public function __construct() {
		parent::__construct();
		$this->load->model('functions/check_user', 'check');
		$this->user = $this->check->validate();
		$this->check->permission($this->user, $this->permissionName);
		$this->check->ip();
		$this->webId = $this->check->checkDefaultWeb();
		$record = $this->check->configuration($this->user);
		$this->_CONFIG = $record['record'];
		if(!$record['state']) {
			$redirectUrl = urlencode($this->config->item('root_path') . 'login');
			redirect("/message?info=SCC_CLOSED&redirect={$redirectUrl}");
		}
		$this->root_path = $this->config->item('root_path');
		$this->load->model('web/news', 'news');
		$this->news->__init($this->webId);
	}
	
	public function index() {
		$action = $this->input->get('action', TRUE);
		if($action=='modify') {
			$newsUpdate = 'update';
			$newsId = $this->input->get('nid', TRUE);
			$row = $this->news->get($newsId);
			$channelId = $row->channel_id;
			$categoryId = $row->category_id;
			$newsTitle = $row->news_title;
			$newsDisplayTitle = $row->news_display_title;
			$newsSeoTitle = $row->news_seo_title;
			$newsTags = $row->news_tags;
			$newsKeywords = $row->news_keywords;
			$newsDesc = $row->news_description;
			$newsIntro = $row->news_intro;
			$newsPicPath = $row->news_pic_path;
			$newsContent = $row->news_content;
			$newsProduct = $row->news_product;
			$newsBuyLink = $row->news_buy_link;
			$newsDownLink = $row->news_down_link;
			
			$newsAdsList = '';
			$newsAdsResult = $this->news->getNewsAdsResult($newsId);
			if($newsAdsResult!=FALSE) {
				foreach($newsAdsResult as $row) {
					if(empty($newsAdsList)) {
						$newsAdsList .= $row->out_ad_id;
					} else {
						$newsAdsList .= ",{$row->out_ad_id}";
					}
				}
			}
		}
		$this->load->model('web/channel', 'channel');
		$this->channel->__init($this->webId);
		$result = $this->channel->getAllResult();
		$channelListOption = '';
		$categoryChannelId = -1;
		foreach($result as $row) {
			if($categoryChannelId == -1) $categoryChannelId = $row->channel_id;
			if($channelId==$row->channel_id) {
				$channelListOption .= "<option value=\"{$row->channel_id}\" selected=\"selected\">{$row->channel_name}</option>\n";
			} else {
				$channelListOption .= "<option value=\"{$row->channel_id}\">{$row->channel_name}</option>\n";
			}
		}
		
		$this->load->model('web/category', 'category');
		$this->category->__init($this->webId);
		if(!empty($channelId)) {
			$result = $this->category->getAllResult($channelId);
		} else {
			$result = $this->category->getAllResult($categoryChannelId);
		}
		$categoryListOption = '';
		foreach($result as $row) {
			if($categoryId==$row->category_id) {
				$categoryListOption .= "<option value=\"{$row->category_id}\" selected=\"selected\">{$row->category_name}</option>\n";
			} else {
				$categoryListOption .= "<option value=\"{$row->category_id}\">{$row->category_name}</option>\n";
			}
		}
		
		$this->load->model('web/tag', 'tag');
		$result = $this->tag->getAllResult();
		$tagList = '';
		$tagArray = array();
		foreach($result as $row) {
			$tagArray[] = "<a class=\"tags_a\" href=\"javascript:void(0)\">{$row->tag_name}</a>";
		}
		$tagList = implode(' | ', $tagArray);
		
		$this->load->model('web/ad', 'ad');
		$resultAdsList = $this->ad->getAllResult(0, 0, $categoryChannelId);
		
		$copyright = $this->load->view("std_copyright", '', true);
		$data = array(
			'userName'				=>	$this->user->user_name,
			'root_path'				=>	$this->root_path,
			'news_update'			=>	$newsUpdate,
			'news_id'				=>	$newsId,
			'news_title'			=>	$newsTitle,
			'news_display_title'	=>	$newsDisplayTitle,
			'news_seo_title'		=>	$newsSeoTitle,
			'news_tags'				=>	$newsTags,
			'news_keywords'			=>	$newsKeywords,
			'news_desc'				=>	$newsDesc,
			'news_intro'			=>	$newsIntro,
			'news_pic_path'			=>	$newsPicPath,
			'news_content'			=>	$newsContent,
			'news_product'			=>	$newsProduct,
			'news_buy_link'			=>	$newsBuyLink,
			'news_down_link'		=>	$newsDownLink,
			'tag_list'				=>	$tagList,
			'result_ads_list'		=>	$resultAdsList,
			'news_ad_id'			=>	$newsAdsList,
			'channel_list_option'	=>	$channelListOption,
			'category_list_option'	=>	$categoryListOption,
			'copyright'				=>	$copyright
		);
		$content = $this->load->view("{$this->permissionName}_view", $data, true);
		
		$this->load->model('functions/template', 'template');
		$menuContent = $this->template->getAdditionalMenu($this->user, $this->permissionName);
		$data = array(
			'title'			=>		'SCC后台管理系统 - 添加新闻',
			'root_path'		=>		$this->root_path
		);
		$header = $this->load->view('std_header', $data, true);
		$footer = $this->load->view('std_footer', '', true);
		$data = array(
			'header'	=>		$header,
			'sidebar'	=>		$menuContent,
			'content'	=>		$content,
			'footer'	=>		$footer,
			'title'		=>		'添加新闻',
			'root_path'	=>		$this->root_path
		);
		$this->load->view('std_template', $data);
	}
	
	public function submit() {
		$newsUpdate = $this->input->post('newsUpdate', TRUE);
		$newsId = $this->input->post('newsId', TRUE);
		$newsTitle = $this->input->post('newsTitle', TRUE);
		$newsDisplayTitle = $this->input->post('newsDisplayTitle', TRUE);
		$newsSeoTitle = $this->input->post('newsSEOTitle', TRUE);
		$categoryId = $this->input->post('newsCategory', TRUE);
		$newsTags = $this->input->post('newsTags', TRUE);
		$newsKeywords = $this->input->post('newsKeywords', TRUE);
		$newsDesc = $this->input->post('newsDesc', TRUE);
		$newsIntro = $this->input->post('newsIntro', TRUE);
		$newsPicPath = $this->input->post('newsPicPath', TRUE);
		$newsContent = $this->input->post('newsContent', TRUE);
		$newsProduct = $this->input->post('newsProduct', TRUE);
		$newsBuyLink = $this->input->post('newsBuyLink', TRUE);
		$newsDownLink = $this->input->post('newsDownLink', TRUE);
		$newsAdId = $this->input->post('newsAdId', TRUE);
		$newsPosttime = date('Y-m-d H:i:s', time());
		if(empty($newsDisplayTitle)) $newsDisplayTitle = $newsTitle;
		$this->load->model('web/tag', 'tag');
		
		if(!empty($newsUpdate) && $newsUpdate=='update') {
			$parameter = array(
				'news_title'		=>	$newsTitle,
				'news_category_id'	=>	$categoryId,
				'news_intro'		=>	$newsIntro,
				'news_content'		=>	$newsContent,
				'news_tags'			=>	$newsTags,
				'news_keywords'		=>	$newsKeywords,
				'news_description'	=>	$newsDesc,
				'news_seo_title'	=>	$newsSeoTitle,
				'news_buy_link'		=>	$newsBuyLink,
				'news_down_link'	=>	$newsDownLink,
				'news_pic_path'		=>	$newsPicPath,
				'news_product'		=>	$newsProduct,
				'news_display_title'=>	$newsDisplayTitle
			);
			$this->news->update($parameter, $newsId);
		} else {
			$parameter = array(
				'news_title'		=>	$newsTitle,
				'news_category_id'	=>	$categoryId,
				'news_intro'		=>	$newsIntro,
				'news_content'		=>	$newsContent,
				'news_posttime'		=>	$newsPosttime,
				'news_tags'			=>	$newsTags,
				'news_keywords'		=>	$newsKeywords,
				'news_description'	=>	$newsDesc,
				'news_seo_title'	=>	$newsSeoTitle,
				'news_buy_link'		=>	$newsBuyLink,
				'news_down_link'	=>	$newsDownLink,
				'news_pic_path'		=>	$newsPicPath,
				'news_product'		=>	$newsProduct,
				'news_display_title'=>	$newsDisplayTitle
			);
			$this->news->insert($parameter);
			$lastId = $this->db->insert_id();
		}
		$tagArray = explode(',', $newsTags);
		for($i=0; $i<count($tagArray); $i++) {
			if(!$this->tag->getTagByName(trim($tagArray[$i]))) {
				$parameter = array(
					'tag_name'	=>	trim($tagArray[$i])
				);
				$this->tag->insert($parameter);
			} else {
				continue;
			}
		}
		
		$adArray = explode(',', $newsAdId);
		if($newsUpdate=='update') {
			if(!empty($adArray[0])) {
				for($i=0; $i<count($adArray); $i++) {
					$sql = "select * from scc_ads_news where `out_ad_id`=".trim($adArray[$i])." and `out_news_id`=$newsId";
					$result = $this->news->getNewsAds($newsId, trim($adArray[$i]));
					if(!$result) {
						$this->news->insertNewsAds($newsId, trim($adArray[$i]));
					} else {
						continue;
					}
				}
			}
			$result = $this->news->getNewsAdsResult($newsId);
			foreach($result as $row) {
				if(!in_array($row->out_ad_id, $adArray)) {
					$this->news->deleteNewsAds($newsId, $row->out_ad_id);
				}
			}
		} else {
			if(!empty($adArray[0])) {
				for($i=0; $i<count($adArray); $i++) {
					$this->news->insertNewsAds($lastId, trim($adArray[$i]));
				}
			}
		}
		$this->logs->write(array(
			'log_type'	=>	'SCC_NEWS_SUBMIT'
		));
		redirect('/web/lists');
	}
}
?>