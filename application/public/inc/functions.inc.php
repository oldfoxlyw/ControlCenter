<?php
date_default_timezone_set('PRC');
function post($URL,$post_data,$referrer=""){
	// parsing the given URL
	$URL_Info=parse_url($URL);
	// Building referrer
	if($referrer=="") $referrer=$_SERVER["SCRIPT_URI"];
 
	// making string from $data
	foreach($post_data as $key=>$value)
		$values[]="$key=".urlencode($value);
 
	$data_string=implode("&",$values);
	// Find out which port is needed - if not given use standard (=80)
	if(!isset($URL_Info["port"]))
		$URL_Info["port"]=80;
	// building POST-request:
	$request.="POST ".$URL_Info["path"]."?".$URL_Info["query"]." HTTP/1.1\n";
	$request.="Host: ".$URL_Info["host"]."\n";
	$request.="Referer: $referrer\n";
	$request.="Content-type: application/x-www-form-urlencoded\n";
	$request.="Content-length: ".strlen($data_string)."\n";
	$request.="Connection: close\n";
	$request.="\n";
	$request.=$data_string."\n";
	$fp = fsockopen($URL_Info["host"],$URL_Info["port"]);
	fputs($fp, $request);
	$data = '';
	$inheader = true;
	$filterFirst = false;
	while (!feof($fp)) {
		$line = fgets($fp,1024);
		if ($inheader && ($line == "\n" || $line == "\r\n")) {
			$inheader = false;
		}
		if (!$inheader) {
			if(!$filterFirst) {
				if(!($line == "\n" || $line == "\r\n")) {
					$filterFirst = true;
				}
			} else {
				$data .= $line;
			}
		}
	}
	fclose($fp);
	$data = trim($data);
	$data = rtrim($data, "\r\n0");
	
	return $data;
}

function apiOutput($array, $type = 'json_string') {
	if(!empty($array)) {
		$output = '';
		switch($type) {
			case 'json_string':
				$output .= '{';
				$jsonArray = Array();
				foreach($array as $key=>$value) {
					if(is_numeric($value)) {
						$jsonArray[] = "$key: $value";
					} elseif(empty($value)) {
						$jsonArray[] = "$key: null";
					} else {
						$jsonArray[] = "$key: \"$value\"";
					}
				}
				$json = implode(', ', $jsonArray);
				$output .= $json;
				$output .= '}';
				break;
			case 'json_format':
				$output .= "{\n";
				$jsonArray = Array();
				foreach($array as $key=>$value) {
					if(is_numeric($value)) {
						$jsonArray[] = "\"	$key\": $value";
					} elseif(empty($value)) {
						$jsonArray[] = "\"	$key\": null";
					} else {
						$jsonArray[] = "\"	$key\": \"$value\"";
					}
				}
				$json = implode(",\n", $jsonArray);
				$output .= $json;
				$output .= "}\n";
				break;
		}
		echo $output;
	}
}

function getUserIP() {
	if(getenv('HTTP_CLIENT_IP')) {
		$client_ip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR')) {
		$client_ip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR')) {
		$client_ip = getenv('REMOTE_ADDR');
	} else {
		$client_ip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
	}
	return $client_ip;
}
?>