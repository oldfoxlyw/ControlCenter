<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {
	private $root_path = '';
	private $upload_dir = '';
	private $param_name = '';
	
	public function __construct() {
		parent::__construct();
		$this->root_path = $this->config->item('root_path');
		$this->upload_dir = $this->config->item('upload_log_dir');
		$this->load->model('logs', 'logs');
	}
	
	public function submit() {
		$accessToken = $this->input->get_post('access_token');
		$productId = $this->input->get_post('product_id');
		if(!empty($accessToken) && !empty($productId)) {
			$this->load->model('product', 'product');
			$result = $this->product->getAllResult(array(
				'product_access_token'	=>	$accessToken
			));
			if($result!=FALSE) {
				$this->load->helper('path');
				$realPath = set_realpath($this->upload_dir);
				$realPath .= $productId;
				if(!file_exists($realPath)) {
					mkdir($realPath);
					chmod($realPath, 777);
				}
				$timeForder = date('Ymd', time());
				$realPath .= '/';
				$realPath .= $timeForder;
				if(!file_exists($realPath)) {
					mkdir($realPath);
					chmod($realPath, 777);
				}
				$this->param_name = 'file';
				$config['upload_path'] = $this->upload_dir . '/' . $productId . '/' . $timeForder;
				//$config['allowed_types'] = 'txt|jpg|png|gif|log';
				$this->load->library('upload', $config);
				
				if (!$this->upload->do_upload($this->param_name)) {
					$this->logs->write(array(
						'log_type'	=>	"UPLOAD_ERROR@" . $this->upload->display_errors('', '')
					));
					exit("UPLOAD_ERROR@" . $this->upload->display_errors('', ''));
				} else {
					$data = $this->upload->data();
					$fileName = $this->root_path . $this->upload_dir . '/' . $data['file_name'];
					exit('UPLOAD_SUCCESS');
				}
			} else {
				$this->logs->write(array(
					'log_type'	=>	'UPLOAD_ERROR_ACCESS_DENIED'
				));
				exit('UPLOAD_ERROR_ACCESS_DENIED');
			}
		} else {
			$this->logs->write(array(
				'log_type'	=>	'UPLOAD_ERROR_NO_PARAM'
			));
			exit('UPLOAD_ERROR_NO_PARAM');
		}
	}
}
?>