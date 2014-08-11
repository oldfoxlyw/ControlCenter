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
		$device_id = $this->input->get_post('id', TRUE);
		$device = $this->input->get_post('type', TRUE);
		$os_version = $this->input->get_post('version', TRUE);
		$value = $this->input->get_post('value', TRUE);

		if(empty($device_id))
		{
			$raw_post_data = file_get_contents('php://input', 'r');
			$inputParam = json_decode($raw_post_data);

			$device_id = $inputParam->id;
			$device = $inputParam->type;
			$os_version = $inputParam->version;
			$value = $inputParam->value;
		}

		if(!empty($device_id) && !empty($value))
		{
			$this->load->model('mpinglog');

			$parameter = array(
				'device'		=>	empty($device) ? '' : $device,
				'os_version'	=>	empty($os_version) ? '' : $os_version,
				'device_id'		=>	$device_id,
				'value'			=>	$value
			);
			$this->mpinglog->create($parameter);
		}
	}
}
?>