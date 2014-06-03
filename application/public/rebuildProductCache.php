<?php
include_once 'inc/functions.inc.php';
if($_GET) {
	$cacheTime = $_GET['cacheTime'];
}
if(empty($cacheTime)) $cacheTime = time();
$parameter = 'cacheIndexDataProduct=1&cacheTime='.$cacheTime;
$content = file_get_contents('http://67.228.209.14/ControlCenter/api/caches/rebuidCache/json?' . $parameter);
$json = json_decode($content);
echo 'Result: ' . $content;
?>