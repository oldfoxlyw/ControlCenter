<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ping extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function log()
	{
		$raw_post_data = file_get_contents('php://input', 'r');
		$inputParam = json_decode($raw_post_data);

		$device_id = $inputParam->id;
		$device = $inputParam->type;
		$os_version = $inputParam->version;
		unset($inputParam->id);
		unset($inputParam->type);
		unset($inputParam->version);
		$posts = $inputParam;

		if(!empty($device_id) && !empty($device))
		{
			$this->load->model('mpinglog');

			$parameter = array(
				'device'		=>	empty($device) ? '' : $device,
				'os_version'	=>	empty($os_version) ? '' : $os_version,
				'device_id'		=>	$device_id,
				'value'			=>	json_encode($posts),
				'time'			=>	time()
			);
			$this->mpinglog->create($parameter);
		}
	}
}
?>