<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Function_statistic extends CI_Model {
	private $converterName = 'log_function_converter';
	private $ripperName = 'log_function_ripper';
	private $playerName = 'log_function_player';
	private $converterViewName = 'log_function_converter_view';
	private $ripperViewName = 'log_function_ripper_view';
	private $playerViewName = 'log_function_player_view';
	private $logdb = null;
	
	public function __construct() {
		parent::__construct();
		$this->logdb = $this->load->database('logdb', true);
	}
	
	public function query($sql) {
		if(!empty($sql)) {
			$query = $this->logdb->query($sql);
			if($query->num_rows() > 0) {
				return $query->result();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function getLastPostTime($parameter = null) {
		$this->logdb->select('log_time');
		if(!empty($parameter['log_type'])) {
			$this->logdb->where('log_type', $parameter['log_type']);
		}
		if(!empty($parameter['log_time_start']) && !empty($parameter['log_time_end'])) {
			if(intval($parameter['log_time_start']) < intval($parameter['log_time_end'])) {
				$this->logdb->where('log_time >', $parameter['log_time_start']);
				$this->logdb->where('log_time <', $parameter['log_time_end']);
			}
		}
		if(!empty($parameter['client_cpu_info'])) {
			$this->logdb->where('client_cpu_info', $parameter['client_cpu_info']);
		}
		if(!empty($parameter['product_id'])) {
			$this->logdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->logdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['system_cpu'])) {
			$this->logdb->where('system_cpu', $parameter['system_cpu']);
		}
		if(!empty($parameter['system_os'])) {
			$this->logdb->where('system_os', $parameter['system_os']);
		}
		if(!empty($parameter['system_videocard'])) {
			$this->logdb->where('system_videocard', $parameter['system_videocard']);
		}
		
		if(!empty($parameter['file_type'])) {
			$this->logdb->where('log_parameter_filetype', $parameter['file_type']);
		}
		if(!empty($parameter['file_input'])) {
			$this->logdb->where('log_parameter_input', $parameter['file_input']);
		}
		if(!empty($parameter['file_output'])) {
			$this->logdb->where('log_parameter_output', $parameter['file_output']);
		}
		if(!empty($parameter['file_width'])) {
			$this->logdb->where('log_parameter_width ' . $parameter['file_width'][0], $parameter['file_width'][1]);
		}
		if(!empty($parameter['file_height'])) {
			$this->logdb->where('log_parameter_height ' . $parameter['file_height'][0], $parameter['file_height'][1]);
		}
		if(!empty($parameter['file_vcode'])) {
			$this->logdb->where('log_parameter_vcode', $parameter['file_vcode']);
		}
		if(!empty($parameter['file_acode'])) {
			$this->logdb->where('log_parameter_acode', $parameter['file_acode']);
		}
		if(!empty($parameter['file_subtitle'])) {
			$this->logdb->where('log_parameter_subtitle', $parameter['file_subtitle']);
		}
		if(!empty($parameter['file_crop'])) {
			$this->logdb->where('log_parameter_crop', $parameter['file_crop']);
		}
		if(!empty($parameter['file_timerange'])) {
			$this->logdb->where('log_parameter_timerange', $parameter['file_timerange']);
		}
		if(!empty($parameter['file_cuda'])) {
			$this->logdb->where('log_parameter_cuda', $parameter['file_cuda']);
		}
		
		$this->logdb->order_by('log_time', 'desc');
		$this->logdb->limit(1);
		switch($parameter['software_type']) {
			case 'converter':
				$query = $this->logdb->get($this->converterName);
				break;
			case 'ripper':
				$query = $this->logdb->get($this->ripperName);
				break;
			case 'player':
				$query = $this->logdb->get($this->playerName);
				break;
			default:
				$query = $this->logdb->get($this->converterName);
		}
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
	
	public function getTotal($parameter = null) {
		if(!empty($parameter['log_type'])) {
			$this->logdb->where('log_type', $parameter['log_type']);
		}
		if(!empty($parameter['log_time_start']) && !empty($parameter['log_time_end'])) {
			if(intval($parameter['log_time_start']) < intval($parameter['log_time_end'])) {
				$this->logdb->where('log_time >', $parameter['log_time_start']);
				$this->logdb->where('log_time <', $parameter['log_time_end']);
			}
		}
		if(!empty($parameter['client_cpu_info'])) {
			$this->logdb->where('client_cpu_info', $parameter['client_cpu_info']);
		}
		if(!empty($parameter['product_id'])) {
			$this->logdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->logdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['system_cpu'])) {
			$this->logdb->where('system_cpu', $parameter['system_cpu']);
		}
		if(!empty($parameter['system_os'])) {
			$this->logdb->where('system_os', $parameter['system_os']);
		}
		if(!empty($parameter['system_videocard'])) {
			$this->logdb->where('system_videocard', $parameter['system_videocard']);
		}
		switch($parameter['software_type']) {
			case 'converter':
				return $this->logdb->count_all_results($this->converterName);
				break;
			case 'ripper':
				return $this->logdb->count_all_results($this->ripperName);
				break;
			case 'player':
				return $this->logdb->count_all_results($this->playerName);
				break;
			default:
				return $this->logdb->count_all_results($this->converterName);
		}
	}
	
	public function getAllResult($parameter = null, $limit = 0, $offset = 0, $type = 'data') {
		if(!empty($parameter['log_type'])) {
			$this->logdb->where('log_type', $parameter['log_type']);
		}
		if(!empty($parameter['log_time_start']) && !empty($parameter['log_time_end'])) {
			if(intval($parameter['log_time_start']) < intval($parameter['log_time_end'])) {
				$this->logdb->where('log_time >', $parameter['log_time_start']);
				$this->logdb->where('log_time <', $parameter['log_time_end']);
			}
		}
		if(!empty($parameter['client_cpu_info'])) {
			$this->logdb->where('client_cpu_info', $parameter['client_cpu_info']);
		}
		if(!empty($parameter['product_id'])) {
			$this->logdb->where('product_id', $parameter['product_id']);
		}
		if(!empty($parameter['product_version'])) {
			$this->logdb->where('product_version', $parameter['product_version']);
		}
		if(!empty($parameter['product_function'])) {
			$this->logdb->where('log_parameter_func', $parameter['product_function']);
		}
		if(!empty($parameter['system_cpu'])) {
			$this->logdb->where('system_cpu', $parameter['system_cpu']);
		}
		if(!empty($parameter['system_os'])) {
			$this->logdb->where('system_os', $parameter['system_os']);
		}
		if(!empty($parameter['system_videocard'])) {
			$this->logdb->where('system_videocard', $parameter['system_videocard']);
		}
		
		if(!empty($parameter['file_type'])) {
			$this->logdb->where('log_parameter_filetype', $parameter['file_type']);
		}
		if(!empty($parameter['file_input'])) {
			$this->logdb->where('log_parameter_input', $parameter['file_input']);
		}
		if(!empty($parameter['file_output'])) {
			$this->logdb->where('log_parameter_output', $parameter['file_output']);
		}
		if(!empty($parameter['file_width'])) {
			$this->logdb->where('log_parameter_width ' . $parameter['file_width'][0], $parameter['file_width'][1]);
		}
		if(!empty($parameter['file_height'])) {
			$this->logdb->where('log_parameter_height ' . $parameter['file_height'][0], $parameter['file_height'][1]);
		}
		if(!empty($parameter['file_vcode'])) {
			$this->logdb->where('log_parameter_vcode', $parameter['file_vcode']);
		}
		if(!empty($parameter['file_acode'])) {
			$this->logdb->where('log_parameter_acode', $parameter['file_acode']);
		}
		if(!empty($parameter['file_subtitle'])) {
			$this->logdb->where('log_parameter_subtitle', $parameter['file_subtitle']);
		}
		if(!empty($parameter['file_crop'])) {
			$this->logdb->where('log_parameter_crop', $parameter['file_crop']);
		}
		if(!empty($parameter['file_timerange'])) {
			$this->logdb->where('log_parameter_timerange', $parameter['file_timerange']);
		}
		if(!empty($parameter['file_cuda'])) {
			$this->logdb->where('log_parameter_cuda', $parameter['file_cuda']);
		}
		
		if(!empty($parameter['distinct'])) {
			$this->logdb->select($parameter['distinct']);
			$this->logdb->distinct();
		}
		if(!empty($parameter['where'])) {
			$this->logdb->where($parameter['where']);
		}
		if(!empty($parameter['group_by'])) {
			$this->logdb->group_by($parameter['group_by']);
		}
		if(!empty($parameter['count'])) {
			$this->logdb->select($parameter['count']);
		}
		if(!empty($parameter['order_by'])) {
			$this->logdb->order_by($parameter['order_by'][0], $parameter['order_by'][1]);
		} else {
			$this->logdb->order_by('log_time', 'desc');
		}
		if($limit==0 && $offset==0) {
			switch($parameter['software_type']) {
				case 'converter':
					$query = $this->logdb->get($this->converterViewName);
					break;
				case 'ripper':
					$query = $this->logdb->get($this->ripperViewName);
					break;
				case 'player':
					$query = $this->logdb->get($this->playerViewName);
					break;
				default:
					$query = $this->logdb->get($this->converterViewName);
			}
		} else {
			switch($parameter['software_type']) {
				case 'converter':
					$query = $this->logdb->get($this->converterViewName, $limit, $offset);
					break;
				case 'ripper':
					$query = $this->logdb->get($this->ripperViewName, $limit, $offset);
					break;
				case 'player':
					$query = $this->logdb->get($this->playerViewName, $limit, $offset);
					break;
				default:
					$query = $this->logdb->get($this->converterViewName, $limit, $offset);
			}
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
	
	public function insert($parameter, $target) {
		if(!empty($parameter)) {
			switch($target) {
				case 'converter':
					return $this->logdb->insert($this->converterName, $parameter);
					break;
				case 'ripper':
					return $this->logdb->insert($this->ripperName, $parameter);
					break;
				case 'player':
					return $this->logdb->insert($this->playerName, $parameter);
					break;
				default:
					return $this->logdb->insert($this->converterName, $parameter);
			}
		} else {
			return false;
		}
	}
}
?>