<?php
include_once 'inc/functions.inc.php';

$currentTime = time();
$year = date('Y', $currentTime);
$month = date('m', $currentTime);
$date = date('d', $currentTime);

$parameter = array(
	'reportType'=>	'4',
	'year1'		=>	$year
);
$parameter = "reportType=4&year1={$year}";
$content = file_get_contents('http://67.228.209.14/ControlCenter/report/installs?' . $parameter);
echo 'Result: ' . $content;
?>