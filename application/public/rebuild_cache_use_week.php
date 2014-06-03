<?php
include_once 'inc/functions.inc.php';

$currentTime = time();
$year = date('Y', $currentTime);
$month = date('m', $currentTime);
$date = date('d', $currentTime);

$parameter = "reportType=1&year1={$year}&month1={$month}&date1={$date}";
$content = file_get_contents('http://67.228.209.14/ControlCenter/report/uses?' . $parameter);
echo 'Result: ' . $content;
?>