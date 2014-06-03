<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Statistics extends CI_Controller {
	private $root_path = null;
	private $baseUrl = '';
	
	public function __construct() {
		parent::__construct();
		$this->root_path = $this->config->item('root_path');
		$this->baseUrl = $this->config->item('base_url');
		$this->load->model('active', 'active');
		$this->load->model('report/statistic', 'statistic');
		$this->load->model('report/function_statistic', 'function_statistic');
		$this->load->model('logs', 'logs');
	}
	
	public function feed() {
		$logType		=	trim($this->input->get_post('logType', TRUE));
		$logTime		=	time();
		$logLocalTime	=	date('Y-m-d H:i:s', $logTime);
		$machineCode	=	trim($this->input->get_post('machine', TRUE));
		$productId		=	trim($this->input->get_post('product_id', TRUE));
		$productVersion	=	trim($this->input->get_post('product_version', TRUE));
		$systemOS		=	$this->input->get_post('system_os');
		$systemCpu		=	trim($this->input->get_post('system_cpu', TRUE));
		$systemVideocard=	trim($this->input->get_post('system_videocard', TRUE));
		$ip				=	$this->input->get_post('ip', TRUE);
		if($ip===false) {
			$ip			=	$this->input->ip_address();
		}
		$productVersion	=	$this->_4styleTo3Style($productVersion);
		
		//if($ip!='119.6.80.40') {
			if(!empty($logType) && !empty($machineCode) && !empty($productId) && !empty($productVersion)) {
				if($logType=='function') {
					$softwareType	=	$this->input->get_post('software_type', TRUE);
					$funcName		=	$this->input->get_post('func', TRUE);
					$fileType		=	$this->input->get_post('filetype', TRUE);
					$fileInput		=	$this->input->get_post('input', TRUE);
					$fileOutput		=	$this->input->get_post('output', TRUE);
					$fileWidth		=	$this->input->get_post('width', TRUE);
					$fileHeight		=	$this->input->get_post('height', TRUE);
					$fileVcode		=	$this->input->get_post('vcode', TRUE);
					$fileAcode		=	$this->input->get_post('acode', TRUE);
					$fileSubtitle	=	$this->input->get_post('subtitle', TRUE);
					$fileCrop		=	$this->input->get_post('crop', TRUE);
					$fileTimeRange	=	$this->input->get_post('timerange', TRUE);
					$fileCuda		=	$this->input->get_post('cuda', TRUE);
					
					if(empty($softwareType) || empty($funcName)) {
						$this->logs->write(array(
							'log_type'	=>	'FEED_ERROR_NO_PARAM'
						));
						exit('FEED_ERROR_NO_PARAM');
					} else {
						$userEmail = '';
						if(empty($systemOS)) $systemOS='unknow';
						if(empty($systemCpu)) $systemCpu='unknow';
						if(empty($systemVideocard)) $systemVideocard='unknow';
						if(empty($fileType)) $fileType = 'N/A';
						if(empty($fileInput)) $fileInput = 'N/A';
						if(empty($fileOutput)) $fileOutput = 'N/A';
						if(empty($fileWidth)) $fileWidth = -1;
						if(empty($fileHeight)) $fileHeight = -1;
						if(empty($fileVcode)) $fileVcode = 'N/A';
						if(empty($fileAcode)) $fileAcode = 'N/A';
						if(empty($fileSubtitle)) $fileSubtitle = 0;
						if(empty($fileCrop)) $fileCrop = 0;
						if(empty($fileTimeRange)) $fileTimeRange = 0;
						if(empty($fileCuda)) $fileCuda = 0;
						
						$row = array(
							'log_type'			=>	$logType,
							'log_time'			=>	$logTime,
							'log_localtime'		=>	$logLocalTime,
							'client_cpu_info'	=>	$machineCode,
							'account_mail'		=>	$userEmail,
							'product_id'		=>	$productId,
							'product_version'	=>	$productVersion,
							'system_os'			=>	$systemOS,
							'system_cpu'		=>	$systemCpu,
							'system_videocard'	=>	$systemVideocard,
							'log_ipv4'			=>	$ip,
							'log_parameter_func'=>	$funcName
						);
						$target = '';
						if($softwareType=='converter') {
							$target							=	'converter';
							$row['log_parameter_filetype']	=	$fileType;
							$row['log_parameter_input']		=	$fileInput;
							$row['log_parameter_output']	=	$fileOutput;
							$row['log_parameter_width']		=	$fileWidth;
							$row['log_parameter_height']	=	$fileHeight;
							$row['log_parameter_vcode']		=	$fileVcode;
							$row['log_parameter_acode']		=	$fileAcode;
							$row['log_parameter_subtitle']	=	$fileSubtitle;
							$row['log_parameter_crop']		=	$fileCrop;
							$row['log_parameter_timerange']	=	$fileTimeRange;
							$row['log_parameter_cuda']		=	$fileCuda;
						} elseif($softwareType=='ripper') {
							$target							=	'ripper';
							$row['log_parameter_input']		=	$fileInput;
							$row['log_parameter_output']	=	$fileOutput;
							$row['log_parameter_width']		=	$fileWidth;
							$row['log_parameter_height']	=	$fileHeight;
							$row['log_parameter_vcode']		=	$fileVcode;
							$row['log_parameter_acode']		=	$fileAcode;
							$row['log_parameter_subtitle']	=	$fileSubtitle;
							$row['log_parameter_crop']		=	$fileCrop;
							$row['log_parameter_timerange']	=	$fileTimeRange;
							$row['log_parameter_cuda']		=	$fileCuda;
						} elseif($softwareType=='player') {
							$target							=	'player';
							$row['log_parameter_filetype']	=	$fileType;
							$row['log_parameter_input']		=	$fileInput;
						}
						if($this->function_statistic->insert($row, $target)) {
							exit('FEED_SUCCESS');
						} else {
							$this->logs->write(array(
								'log_type'	=>	'FEED_DATABASE_ERROR'
							));
							exit('FEED_DATABASE_ERROR');
						}
					}
				} else {
					$userEmail		=	'';
					$parameter		=	"{";
					$tmp			=	Array();
					$statisticParameter = $this->config->item('statistic_parameter');
					foreach($_REQUEST as $key => $value) {
						if(in_array($key, $statisticParameter)) {
							if(is_numeric($value)) {
								$tmp[] = "\"$key\": $value";
							} elseif(empty($value)) {
								$tmp[] = "\"$key\": null";
							} else {
								$tmp[] = "\"$key\": \"$value\"";
							}
						}
					}
					if(empty($systemOS)) $systemOS='unknow';
					if(empty($systemCpu)) $systemCpu='unknow';
					if(empty($systemVideocard)) $systemVideocard='unknow';
					$parameter .= implode(',', $tmp);
					$parameter .= '}';
					
					$row = array(
						'log_type'			=>	$logType,
						'log_time'			=>	$logTime,
						'log_localtime'		=>	$logLocalTime,
						'client_cpu_info'	=>	$machineCode,
						'account_mail'		=>	$userEmail,
						'log_parameter'		=>	$parameter,
						'product_id'		=>	$productId,
						'product_version'	=>	$productVersion,
						'system_os'			=>	$systemOS,
						'system_cpu'		=>	$systemCpu,
						'system_videocard'	=>	$systemVideocard,
						'log_ipv4'			=>	$ip
					);
					if($this->statistic->insert($row)) {
						exit('FEED_SUCCESS');
					} else {
						$this->logs->write(array(
							'log_type'	=>	'FEED_DATABASE_ERROR'
						));
						exit('FEED_DATABASE_ERROR');
					}
				}
			} else {
				$this->logs->write(array(
					'log_type'	=>	'FEED_ERROR_NO_PARAM'
				));
				exit('FEED_ERROR_NO_PARAM');
			}
		//}
	}
	
	public function uninstall() {
		$logTime		=	time();
		$logLocalTime	=	date('Y-m-d H:i:s', $logTime);
		$machineCode	=	trim($this->input->get_post('machine', TRUE));
		$productId		=	trim($this->input->get_post('product_id', TRUE));
		$productVersion	=	trim($this->input->get_post('product_version', TRUE));
		$systemOS		=	$this->input->get_post('system_os');
		$systemCpu		=	trim($this->input->get_post('system_cpu', TRUE));
		$systemVideocard=	trim($this->input->get_post('system_videocard', TRUE));
		$ip				=	trim($this->input->get_post('ip', TRUE));
		$isScc			=	$this->input->get('scc', TRUE);
		if($ip===false) {
			$ip			=	$this->input->ip_address();
		}
		
		if(!empty($machineCode) && !empty($productId) && !empty($productVersion)) {
			$this->load->model('product', 'product');
			$result = $this->product->getAllResult(array(
				'product_id'		=>	$productId,
				'product_version'	=>	$productVersion
			));
			if($result!=FALSE) {
				$row = $result[0];
				$redirectUrl = $row->product_uninstall_page;
				$webSite = urlencode($row->product_web);
				$surveyId = $row->product_uninstall_survey;
				
				$parameter = "logType=uninstall&machine={$machineCode}&product_id={$productId}&product_version={$productVersion}&system_os={$systemOS}&system_cpu={$systemCpu}&system_videocard={$systemVideocard}&ip={$ip}";
				$content = file_get_contents("{$this->baseUrl}api/statistics/feed?$parameter");
				if($content == 'FEED_SUCCESS') {
					if(empty($redirectUrl)) {
						if($isScc=='1') {
							echo $row->product_web;
						} else {
							redirect($row->product_web);
						}
					} else {
						if($isScc=='1') {
							echo "{$redirectUrl}?surveyId={$surveyId}&product_id={$productId}&product_version={$productVersion}&machine={$machineCode}&redirect={$webSite}";
						} else {
							redirect("{$redirectUrl}?surveyId={$surveyId}&product_id={$productId}&product_version={$productVersion}&machine={$machineCode}&redirect={$webSite}");
						}
					}
				} else {
					if($isScc=='1') {
						echo "http://www.winxdvd.com/";
					} else {
						redirect("http://www.winxdvd.com/");
					}
				}
			} else {
				$result = $this->product->getAllResult(array(
						'product_id'		=>	$productId
				));
				if($result!=FALSE) {
					$row = $result[0];
					$redirectUrl = $row->product_uninstall_page;
					$webSite = urlencode($row->product_web);
					$surveyId = $row->product_uninstall_survey;

					$parameter = "logType=uninstall&machine={$machineCode}&product_id={$productId}&product_version={$productVersion}&system_os={$systemOS}&system_cpu={$systemCpu}&system_videocard={$systemVideocard}&ip={$ip}";
					$content = file_get_contents("{$this->baseUrl}api/statistics/feed?$parameter");
					if($content == 'FEED_SUCCESS') {
						if(empty($redirectUrl)) {
							if($isScc=='1') {
								echo $row->product_web;
							} else {
								redirect($row->product_web);
							}
						} else {
							if($isScc=='1') {
								echo "{$redirectUrl}?surveyId={$surveyId}&product_id={$productId}&product_version={$productVersion}&machine={$machineCode}&redirect={$webSite}";
							} else {
								redirect("{$redirectUrl}?surveyId={$surveyId}&product_id={$productId}&product_version={$productVersion}&machine={$machineCode}&redirect={$webSite}");
							}
						}
					} else {
						if($isScc=='1') {
							echo "http://www.winxdvd.com/";
						} else {
							redirect("http://www.winxdvd.com/");
						}
					}
				} else {
					if($isScc=='1') {
						echo "http://www.winxdvd.com/";
					} else {
						redirect("http://www.winxdvd.com/");
					}
				}
			}
		} else {
			if($isScc=='1') {
				echo "http://www.winxdvd.com/";
			} else {
				redirect("http://www.winxdvd.com/");
			}
		}
	}
	
	public function download_count() {
		$logDownMethod = $this->input->get_post('log_down_method', TRUE);
		$logRedirectPid = $this->input->get_post('log_redirect_pid', TRUE);
		$logReferenceUrl = urldecode($this->input->get_post('log_reference_url', TRUE));
		$this->load->model('report/web', 'web');
		$parameter = array(
			'log_down_method'	=>	$logDownMethod,
			'log_redirect_pid'	=>	$logRedirectPid,
			'log_reference_url'	=>	$logReferenceUrl
		);
		$this->web->insert($parameter);
	}
	
	public function buy_count() {
		$logVid = $this->input->get_post('log_vid', TRUE);
		$logAid = $this->input->get_post('log_aid', TRUE);
		$logPid = $this->input->get_post('log_pid', TRUE);
		$logQuantity = $this->input->get_post('log_quantity', TRUE);
		$logCoupon = $this->input->get_post('log_coupon', TRUE);
		$logReferenceUrl = urldecode($this->input->get_post('log_reference_url', TRUE));
		$this->load->model('report/web', 'web');
		$parameter = array(
			'log_vid'			=>	$logVid,
			'log_aid'			=>	$logAid,
			'log_pid'			=>	$logPid,
			'log_quantity'		=>	$logQuantity,
			'log_coupon'		=>	$logCoupon,
			'log_reference_url'	=>	$logReferenceUrl
		);
		$this->web->insert_buy($parameter);
	}
	
	private function _4styleTo3Style($versionString) {
		if(!empty($versionString)) {
			$versionArray = explode('.', $versionString);
			if(count($versionArray) > 3) {
				array_pop($versionArray);
				return implode('.', $versionArray);
			} else {
				return $versionString;
			}
		}
	}
}
?>