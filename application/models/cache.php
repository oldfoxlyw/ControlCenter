<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cache extends CI_Model {
	private $tableName = 'log_client_statistic';
	private $viewName = 'log_statistic_view';
	private $cacheAllName = 'log_cache_all';
	private $cacheMachineName = 'log_cache_machinecode';
	private $cacheProductName = 'log_cache_product_use';
	private $cacheBuylinkName = 'log_cache_buylink';
	private $cacheReportName = 'log_cache_report';
	private $cachePath = './application/config/cache.php';
	private $cacheData = '';
	private $logdb = null;
	public function __construct() {
		parent::__construct();
		$this->logdb = $this->load->database('logdb', TRUE);
		$this->config->load('inner_db_setting');
		$dbSetting = $this->config->item('logdb');
		$param = array(
			'dbhost'	=>	$dbSetting['hostname'],
			'dbuser'	=>	$dbSetting['username'],
			'dbpw'		=>	$dbSetting['password'],
			'dbname'	=>	$dbSetting['database']
		);
		$this->load->library('Mysql', $param);
	}
	
	public function buildCache() {
		$this->cacheData = "<?php\n";
		$this->cacheData .= "if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n\n";
		$this->generateProductList();
		$this->generateProductVersion();
		$this->generateProductFunction();
		$this->generateOsList();
		$this->generateCpuList();
		$this->generateVideoList();
		$this->generateFileTypeList('converter');
		$this->generateFileTypeList('player');
		$this->generateInputList('converter');
		$this->generateInputList('ripper');
		$this->generateInputList('player');
		$this->generateOutputList('converter');
		$this->generateOutputList('ripper');
		$this->generateVcodeList('converter');
		$this->generateVcodeList('ripper');
		$this->generateAcodeList('converter');
		$this->generateAcodeList('ripper');
		$this->buildLogDbName();
		$this->cacheData .= "?>";
		
		$this->load->helper('file');
		delete_files($this->cachePath);
		if(!write_file($this->cachePath, $this->cacheData)) {
			return false;
		} else {
			return true;
		}
	}
	
	public function generateProductList() {
		$this->load->model('product', 'product');
		$productResult = $this->product->getAllResult(array(
			'group_by'	=>	'product_id'
		));
		if($productResult!=FALSE) {
			$this->cacheData .= "\$config['product_list'] = array(\n";
			$cache = array();
			foreach($productResult as $row) {
				$cacheRow = "	array(\n";
				$cacheRow .= "		'product_id'	=>	'{$row->product_id}',\n";
				$cacheRow .= "		'product_name'	=>	'{$row->product_name}'\n";
				$cacheRow .= "	)";
				$cache[] = $cacheRow;
				unset($cacheRow);
			}
			$data = implode(",\n", $cache);
			unset($cache);
			$this->cacheData .= "{$data}\n";
			unset($data);
			$this->cacheData .= ");\n\n";
		}
	}
	
	public function generateProductVersion() {
		$this->load->model('product', 'product');
		$productResult = $this->product->getAllResult();
		if($productResult!=FALSE) {
			$this->cacheData .= "\$config['product_version'] = array(\n";
			$cache = array();
			foreach($productResult as $row) {
				$cacheRow = "	array(\n";
				$cacheRow .= "		'product_id'		=>	'{$row->product_id}',\n";
				$cacheRow .= "		'product_name'		=>	'{$row->product_name}',\n";
				$cacheRow .= "		'product_version'	=>	'{$row->product_version}'\n";
				$cacheRow .= "	)";
				$cache[] = $cacheRow;
				unset($cacheRow);
			}
			$data = implode(",\n", $cache);
			unset($cache);
			$this->cacheData .= "{$data}\n";
			unset($data);
			$this->cacheData .= ");\n\n";
		}
	}
	
	public function generateProductFunction() {
		$this->load->model('product', 'product');
		$productResult = $this->product->getAllResult();
		if($productResult!=FALSE) {
			$this->cacheData .= "\$config['product_function'] = array(\n";
			$cache = array();
			foreach($productResult as $row) {
				$cacheRow = "	array(\n";
				$cacheRow .= "		'product_id'		=>	'{$row->product_id}',\n";
				$cacheRow .= "		'product_version'	=>	'{$row->product_version}',\n";
				$cacheRow .= "		'function_list'		=>	array(\n";
				$funcResult = $this->product->getFunctions(array(
					'product_id'		=>	$row->product_id,
					'product_version'	=>	$row->product_version
				));
				
				$func = array();
				foreach($funcResult as $item) {
					$funcRow = "			array(\n";
					$funcRow .= "				'func_id'	=>	{$item->func_id},\n";
					$funcRow .= "				'func_name'	=>	'{$item->func_name}'\n";
					$funcRow .= "			)";
					$func[] = $funcRow;
					unset($funcRow);
				}
				$funcRow = implode(",\n", $func);
				unset($func);
				$cacheRow .= "{$funcRow}\n";
				unset($funcRow);
				
				$cacheRow .= "		)\n";
				$cacheRow .= "	)";
				$cache[] = $cacheRow;
				unset($cacheRow);
			}
			$data = implode(",\n", $cache);
			unset($cache);
			$this->cacheData .= "{$data}\n";
			unset($data);
			$this->cacheData .= ");\n\n";
		}
	}
	
	public function generateOsList() {
		$this->load->model('report/statistic', 'statistic');
		$cpuResult = $this->statistic->getAllResult(array(
			'distinct'	=>	'system_os'
		));
		if($cpuResult!=FALSE) {
			$this->cacheData .= "\$config['sys_os_list'] = array(\n";
			$cache = array();
			foreach($cpuResult as $row) {
				$cacheRow = "	array(\n";
				$cacheRow .= "		'system_os'	=>	'{$row->system_os}'\n";
				$cacheRow .= "	)";
				$cache[] = $cacheRow;
				unset($cacheRow);
			}
			$data = implode(",\n", $cache);
			unset($cache);
			$this->cacheData .= "{$data}\n";
			unset($data);
			$this->cacheData .= ");\n\n";
		}
	}
	
	public function generateCpuList() {
		$this->load->model('report/statistic', 'statistic');
		$cpuResult = $this->statistic->getAllResult(array(
			'distinct'	=>	'system_cpu'
		));
		if($cpuResult!=FALSE) {
			$this->cacheData .= "\$config['sys_cpu_list'] = array(\n";
			$cache = array();
			foreach($cpuResult as $row) {
				$cacheRow = "	array(\n";
				$cacheRow .= "		'system_cpu'	=>	'{$row->system_cpu}'\n";
				$cacheRow .= "	)";
				$cache[] = $cacheRow;
				unset($cacheRow);
			}
			$data = implode(",\n", $cache);
			unset($cache);
			$this->cacheData .= "{$data}\n";
			unset($data);
			$this->cacheData .= ");\n\n";
		}
	}
	
	public function generateVideoList() {
		$this->load->model('report/statistic', 'statistic');
		$cpuResult = $this->statistic->getAllResult(array(
			'distinct'	=>	'system_videocard'
		));
		if($cpuResult!=FALSE) {
			$this->cacheData .= "\$config['sys_videocard_list'] = array(\n";
			$cache = array();
			foreach($cpuResult as $row) {
				$cacheRow = "	array(\n";
				$cacheRow .= "		'system_videocard'	=>	'{$row->system_videocard}'\n";
				$cacheRow .= "	)";
				$cache[] = $cacheRow;
				unset($cacheRow);
			}
			$data = implode(",\n", $cache);
			unset($cache);
			$this->cacheData .= "{$data}\n";
			unset($data);
			$this->cacheData .= ");\n\n";
		}
	}
	
	public function generateFileTypeList($from = 'converter') {
		$this->load->model('report/function_statistic', 'function_statistic');
		$filetypeResult = $this->function_statistic->getAllResult(array(
			'distinct'		=>	'log_parameter_filetype',
			'software_type'	=>	$from
		));
		if($filetypeResult!=FALSE) {
			$this->cacheData .= "\$config['{$from}_filetype_list'] = array(\n";
			$cache = array();
			foreach($filetypeResult as $row) {
				$cacheRow = "	array(\n";
				$cacheRow .= "		'file_type'	=>	'{$row->log_parameter_filetype}'\n";
				$cacheRow .= "	)";
				$cache[] = $cacheRow;
				unset($cacheRow);
			}
			$data = implode(",\n", $cache);
			unset($cache);
			$this->cacheData .= "{$data}\n";
			unset($data);
			$this->cacheData .= ");\n\n";
		}
	}
	
	public function generateInputList($from = 'converter') {
		$this->load->model('report/function_statistic', 'function_statistic');
		$filetypeResult = $this->function_statistic->getAllResult(array(
			'distinct'		=>	'log_parameter_input',
			'software_type'	=>	$from
		));
		if($filetypeResult!=FALSE) {
			$this->cacheData .= "\$config['{$from}_input_list'] = array(\n";
			$cache = array();
			foreach($filetypeResult as $row) {
				$cacheRow = "	array(\n";
				$cacheRow .= "		'input'	=>	'{$row->log_parameter_input}'\n";
				$cacheRow .= "	)";
				$cache[] = $cacheRow;
				unset($cacheRow);
			}
			$data = implode(",\n", $cache);
			unset($cache);
			$this->cacheData .= "{$data}\n";
			unset($data);
			$this->cacheData .= ");\n\n";
		}
	}
	
	public function generateOutputList($from = 'converter') {
		$this->load->model('report/function_statistic', 'function_statistic');
		$filetypeResult = $this->function_statistic->getAllResult(array(
			'distinct'		=>	'log_parameter_output',
			'software_type'	=>	$from
		));
		if($filetypeResult!=FALSE) {
			$this->cacheData .= "\$config['{$from}_output_list'] = array(\n";
			$cache = array();
			foreach($filetypeResult as $row) {
				$cacheRow = "	array(\n";
				$cacheRow .= "		'output'	=>	'{$row->log_parameter_output}'\n";
				$cacheRow .= "	)";
				$cache[] = $cacheRow;
				unset($cacheRow);
			}
			$data = implode(",\n", $cache);
			unset($cache);
			$this->cacheData .= "{$data}\n";
			unset($data);
			$this->cacheData .= ");\n\n";
		}
	}
	
	public function generateVcodeList($from = 'converter') {
		$this->load->model('report/function_statistic', 'function_statistic');
		$filetypeResult = $this->function_statistic->getAllResult(array(
			'distinct'		=>	'log_parameter_vcode',
			'software_type'	=>	$from
		));
		if($filetypeResult!=FALSE) {
			$this->cacheData .= "\$config['{$from}_vcode_list'] = array(\n";
			$cache = array();
			foreach($filetypeResult as $row) {
				$cacheRow = "	array(\n";
				$cacheRow .= "		'vcode'	=>	'{$row->log_parameter_vcode}'\n";
				$cacheRow .= "	)";
				$cache[] = $cacheRow;
				unset($cacheRow);
			}
			$data = implode(",\n", $cache);
			unset($cache);
			$this->cacheData .= "{$data}\n";
			unset($data);
			$this->cacheData .= ");\n\n";
		}
	}
	
	public function generateAcodeList($from = 'converter') {
		$this->load->model('report/function_statistic', 'function_statistic');
		$filetypeResult = $this->function_statistic->getAllResult(array(
			'distinct'		=>	'log_parameter_acode',
			'software_type'	=>	$from
		));
		if($filetypeResult!=FALSE) {
			$this->cacheData .= "\$config['{$from}_acode_list'] = array(\n";
			$cache = array();
			foreach($filetypeResult as $row) {
				$cacheRow = "	array(\n";
				$cacheRow .= "		'acode'	=>	'{$row->log_parameter_acode}'\n";
				$cacheRow .= "	)";
				$cache[] = $cacheRow;
				unset($cacheRow);
			}
			$data = implode(",\n", $cache);
			unset($cache);
			$this->cacheData .= "{$data}\n";
			unset($data);
			$this->cacheData .= ");\n\n";
		}
	}
	
	public function buildLogDbName() {
		$db_prefix = 'datadigi_scc_logdb';
		$this->load->dbutil();
		$dbList = $this->dbutil->list_databases();
		$this->cacheData .= "\$config['logdb_names_list'] = array(\n";
		foreach($dbList as $db) {
			if(strpos($db, $db_prefix)===0) {
				$cacheRow = "	array(\n";
				$cacheRow .= "		'dbname'	=>	'{$db}'\n";
				$cacheRow .= "	)";
				$cache[] = $cacheRow;
			}
		}
		$data = implode(",\n", $cache);
		$this->cacheData .= "{$data}\n";
		$this->cacheData .= ");\n\n";
	}
	
	public function getCacheResult($cacheName) {
		$cache = $this->config->item($cacheName);
		$cache = json_encode($cache);
		return json_decode($cache);
	}
	
	public function getCacheProductName($product_list, $pid) {
		if(!empty($pid)) {
			foreach($product_list as $item) {
				if($item->product_id==$pid) {
					return $item->product_name;
				}
			}
			return false;
		}
		return false;
	}
	
	public function buildLogCache() {
		$result = array();
		$result[0] = $this->buildLogCacheAll();
		$result[1] = $this->buildLogCacheCpu();
		$result[2] = $this->buildLogCacheProduct();
		
		return $result;
	}
	
	public function buildLogCacheAll($currentTimeStamp) {
		$totalRows = 0;
		$totalAffectedRows = 0;
		
		$time = date('Y-m-d', $currentTimeStamp);
		$this->logdb->where('cache_time', "{$time} 00:00:00");
		$this->logdb->delete($this->cacheAllName);
		
		$timeStart = strtotime("{$time} 00:00:00");
		$timeEnd = strtotime("{$time} 23:59:59");
		//$this->logdb->truncate($this->cacheAllName);
		
		/*
		 * Step 1: Update `log_cache_all`, `log_type`='install'
		 */
		$sql = "select `product_id`, `product_version`, DATE_FORMAT(`log_localtime`, '%Y-%m-%d') as `date`, count(*) as `count` from `log_client_statistic` where `log_type`='install' and `log_time`>{$timeStart} and `log_time`<{$timeEnd} group by `product_id`, `product_version`, `date`";
		$result = $this->mysql->query($sql);
		$total = $this->mysql->num_rows($result);
		for($i=0; $i<$total; $i++) {
			$row = $this->mysql->fetch_array($result);
			$sqlInsert = "insert into `log_cache_all`(`product_id`, `product_version`, `cache_time`, `install_total`)values('{$row['product_id']}', '{$row['product_version']}', '{$row['date']}', {$row['count']}) ON DUPLICATE KEY UPDATE `install_total`={$row['count']}";
			$this->mysql->query($sqlInsert);
			$totalRows += 1;
			$totalAffectedRows += $this->mysql->affected_rows();
		}
		
		/*
		 * Step 2: Update `log_cache_all`, `log_type`='uninstall'
		 */
		$sql = "select `product_id`, `product_version`, DATE_FORMAT(`log_localtime`, '%Y-%m-%d') as `date`, count(*) as `count` from `log_client_statistic` where `log_type`='uninstall' and `log_time`>{$timeStart} and `log_time`<{$timeEnd} group by `product_id`, `product_version`, `date`";
		$result = $this->mysql->query($sql);
		$total = $this->mysql->num_rows($result);
		for($i=0; $i<$total; $i++) {
			$row = $this->mysql->fetch_array($result);
			$sqlInsert = "insert into `log_cache_all`(`product_id`, `product_version`, `cache_time`, `uninstall_total`)values('{$row['product_id']}', '{$row['product_version']}', '{$row['date']}', {$row['count']}) ON DUPLICATE KEY UPDATE `uninstall_total`={$row['count']}";
			$this->mysql->query($sqlInsert);
			$totalRows += 1;
			$totalAffectedRows += $this->mysql->affected_rows();
		}
		
		/*
		 * Step 3: Update `log_cache_all`, `log_type`='use'
		 */
		$sql = "select `product_id`, `product_version`, DATE_FORMAT(`log_localtime`, '%Y-%m-%d') as `date`, count(*) as `count` from `log_client_statistic` where `log_type`='use' and `log_time`>{$timeStart} and `log_time`<{$timeEnd} group by `product_id`, `product_version`, `date`";
		$result = $this->mysql->query($sql);
		$total = $this->mysql->num_rows($result);
		for($i=0; $i<$total; $i++) {
			$row = $this->mysql->fetch_array($result);
			$sqlInsert = "insert into `log_cache_all`(`product_id`, `product_version`, `cache_time`, `use_total`)values('{$row['product_id']}', '{$row['product_version']}', '{$row['date']}', {$row['count']}) ON DUPLICATE KEY UPDATE `use_total`={$row['count']}";
			$this->mysql->query($sqlInsert);
			$totalRows += 1;
			$totalAffectedRows += $this->mysql->affected_rows();
		}
		
		$result = array(
			'result'	=>	'API_CACHE_ALL_SUCCESS',
			'message'	=>	"首页报表基本数据缓存更新成功（总共读取 {$totalRows} 行数据，总共影响 {$totalAffectedRows} 行数据）"
		);
		return $result;
	}
	
	public function buildLogCacheCpu($currentTimeStamp) {
		$totalRows = 0;
		$totalAffectedRows = 0;
		
		$time = date('Y-m-d', $currentTimeStamp);
		$this->logdb->where('cache_time', "{$time} 00:00:00");
		$this->logdb->delete($this->cacheMachineName);
		
		$timeStart = strtotime("{$time} 00:00:00");
		$timeEnd = strtotime("{$time} 23:59:59");
		
		//$this->logdb->truncate($this->cacheMachineName);
		
		$this->load->model('product', 'product');
		$result = $this->product->getAllResult(array(
			'group_by'	=>	'product_id'
		));
		$product = array();
		foreach($result as $row) {
			$product[$row->product_id] = $row->product_name;
		}
		
		$productList = $this->getCacheResult('product_list');
		
		/*
		 * Step 1: Update `log_cache_machinecode`, `log_type`='install'
		 */
		$sql = "select `client_cpu_info`, `product_id`, `product_version`, DATE_FORMAT(`log_localtime`, '%Y-%m-%d') as `date`, count(*) as `count` from `log_client_statistic` where `log_type`='install' and `log_time`>{$timeStart} and `log_time`<{$timeEnd} group by `client_cpu_info`, `product_id`, `product_version`, `date`";
		$result = $this->mysql->query($sql);
		$total = $this->mysql->num_rows($result);
		for($i=0; $i<$total; $i++) {
			$row = $this->mysql->fetch_array($result);
			$productName = $this->getCacheProductName($productList, $row['product_id']);
			$sqlInsert = "insert into `log_cache_machinecode`(`client_cpu_info`, `product_id`, `product_name`, `product_version`, `cache_time`, `install_total`)values('{$row['client_cpu_info']}', '{$row['product_id']}', '{$productName}', '{$row['product_version']}', '{$row['date']}', {$row['count']}) ON DUPLICATE KEY UPDATE `install_total`={$row['count']}";
			$this->mysql->query($sqlInsert);
			$totalRows += 1;
			$totalAffectedRows += $this->mysql->affected_rows();
		}
		
		/*
		 * Step 2: Update `log_cache_machinecode`, `log_type`='uninstall'
		 */
		$sql = "select `client_cpu_info`, `product_id`, `product_version`, DATE_FORMAT(`log_localtime`, '%Y-%m-%d') as `date`, count(*) as `count` from `log_client_statistic` where `log_type`='uninstall' and `log_time`>{$timeStart} and `log_time`<{$timeEnd} group by `client_cpu_info`, `product_id`, `product_version`, `date`";
		$result = $this->mysql->query($sql);
		$total = $this->mysql->num_rows($result);
		for($i=0; $i<$total; $i++) {
			$row = $this->mysql->fetch_array($result);
			$productName = $this->getCacheProductName($productList, $row['product_id']);
			$sqlInsert = "insert into `log_cache_machinecode`(`client_cpu_info`, `product_id`, `product_name`, `product_version`, `cache_time`, `uninstall_total`)values('{$row['client_cpu_info']}', '{$row['product_id']}', '{$productName}', '{$row['product_version']}', '{$row['date']}', {$row['count']}) ON DUPLICATE KEY UPDATE `uninstall_total`={$row['count']}";
			$this->mysql->query($sqlInsert);
			$totalRows += 1;
			$totalAffectedRows += $this->mysql->affected_rows();
		}
		
		/*
		 * Step 3: Update `log_cache_machinecode`, `log_type`='use'
		 */
		$sql = "select `client_cpu_info`, `product_id`, `product_version`, DATE_FORMAT(`log_localtime`, '%Y-%m-%d') as `date`, count(*) as `count` from `log_client_statistic` where `log_type`='use' and `log_time`>{$timeStart} and `log_time`<{$timeEnd} group by `client_cpu_info`, `product_id`, `product_version`, `date`";
		$result = $this->mysql->query($sql);
		$total = $this->mysql->num_rows($result);
		for($i=0; $i<$total; $i++) {
			$row = $this->mysql->fetch_array($result);
			$productName = $this->getCacheProductName($productList, $row['product_id']);
			$sqlInsert = "insert into `log_cache_machinecode`(`client_cpu_info`, `product_id`, `product_name`, `product_version`, `cache_time`, `use_total`)values('{$row['client_cpu_info']}', '{$row['product_id']}', '{$productName}', '{$row['product_version']}', '{$row['date']}', {$row['count']}) ON DUPLICATE KEY UPDATE `use_total`={$row['count']}";
			$this->mysql->query($sqlInsert);
			$totalRows += 1;
			$totalAffectedRows += $this->mysql->affected_rows();
		}
		
		$result = array(
			'result'	=>	'API_CACHE_CPU_SUCCESS',
			'message'	=>	"首页报表各用户使用数据缓存更新成功（总共读取 {$totalRows} 行数据，总共影响 {$totalAffectedRows} 行数据）"
		);
		return $result;
	}
	
	public function buildLogCacheProduct($currentTimeStamp) {
		$totalRows = 0;
		$totalAffectedRows = 0;
		
		$time = date('Y-m-d', $currentTimeStamp);
		$this->logdb->where('cache_time', "{$time} 00:00:00");
		$this->logdb->delete($this->cacheProductName);
		
		$timeStart = strtotime("{$time} 00:00:00");
		$timeEnd = strtotime("{$time} 23:59:59");
		
		//$this->logdb->truncate($this->cacheProductName);
		
		/*
		 * Step 1: Update `log_cache_product_use`, `log_type`='use'
		 */
		$sql = "select `client_cpu_info`, `product_id`, `product_version`, DATE_FORMAT(`log_localtime`, '%Y-%m-%d') as `date`, count(*) as `count` from `log_client_statistic` where `log_type`='use' and `log_time`>{$timeStart} and `log_time`<{$timeEnd} group by `client_cpu_info`, `product_id`, `product_version`, `date`";
		$result = $this->mysql->query($sql);
		$total = $this->mysql->num_rows($result);
		
		$data = array();
		for($i=0; $i<$total; $i++) {
			$row = $this->mysql->fetch_array($result);
			
			$logSetting = $this->config->item('logdb');
			$authSetting = $this->config->item('authdb');
			$this->mysql->select_db($authSetting['database']);
			$sqlAuth = "select `client_cpu_info`, `product_id`, `product_version` from `auth_actived_view` where `client_cpu_info`='{$row['client_cpu_info']}' and `product_id`='{$row['product_id']}' and `product_version`='{$row['product_version']}'";
			$resultAuth = $this->mysql->query($sqlAuth);
			$this->mysql->select_db($logSetting['database']);
			
			$key = md5("{$row['product_id']}{$row['product_version']}{$row['date']}");
			if($this->mysql->num_rows($resultAuth) > 0) {
				$activedData = intval($data[$key]['actived_use_total']);
				$diactivedData = $data[$key]['diactived_use_total'];
				$data[$key] = array(
					'product_id'			=>	$row['product_id'],
					'product_version'		=>	$row['product_version'],
					'cache_time'			=>	$row['date'],
					'actived_use_total'		=>	strval(intval($row['count']) + $activedData),
					'diactived_use_total'	=>	$diactivedData
				);
			} else {
				$activedData = $data[$key]['actived_use_total'];
				$diactivedData = intval($data[$key]['diactived_use_total']);
				$data[$key] = array(
					'product_id'			=>	$row['product_id'],
					'product_version'		=>	$row['product_version'],
					'cache_time'			=>	$row['date'],
					'actived_use_total'		=>	$activedData,
					'diactived_use_total'	=>	strval(intval($row['count']) + $diactivedData)
				);
			}
			$totalRows += 1;
		}
		
		foreach($data as $key=>$item) {
			if(empty($item['actived_use_total'])) $item['actived_use_total'] = 0;
			if(empty($item['diactived_use_total'])) $item['diactived_use_total'] = 0;
			$sqlInsert = "insert into `log_cache_product_use`(`product_id`, `product_version`, `cache_time`, `actived_use_total`, `diactived_use_total`)values('{$item['product_id']}', '{$item['product_version']}', '{$item['cache_time']}', {$item['actived_use_total']}, {$item['diactived_use_total']})";
			$this->mysql->query($sqlInsert);
			$totalAffectedRows += $this->mysql->affected_rows();
		}
		
		$result = array(
			'result'	=>	'API_CACHE_PRODUCT_SUCCESS',
			'message'	=>	"首页报表产品激活数据缓存更新成功（总共读取 {$totalRows} 行数据，总共影响 {$totalAffectedRows} 行数据）"
		);
		return $result;
	}
	
	public function getReportCache($cache_condition) {
		if(!empty($cache_condition)) {
			$this->logdb->where('cache_condition', $cache_condition);
			$query = $this->logdb->get($this->cacheReportName);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function generateReportCache($parameter) {
		if(!empty($parameter)) {
			return $this->logdb->insert($this->cacheReportName, $parameter);
		} else {
			return false;
		}
	}
	
	public function updateReportCache($parameter, $condition) {
		if(!empty($parameter) && !empty($condition)) {
			$this->logdb->where('cache_condition', $condition);
			return $this->logdb->update($this->cacheReportName, $parameter);
		} else {
			return false;
		}
	}
}
?>