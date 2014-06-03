<?php
$timeStamp = time();
$currentYear = date('Y', $timeStamp);
$currentMonth = intval(date('n', $timeStamp));
switch($currentMonth) {
	case 1:case 2:case 3:
		$currentYear .= '1';
		break;
	case 4:case 5:case 6:
		$currentYear .= '2';
		break;
	case 7:case 8:case 9:
		$currentYear .= '3';
		break;
	case 10:case 11:case 12:
		$currentYear .= '4';
		break;
	default:
		$currentYear .= '0';
}

$config['logdb']['hostname'] = 'localhost';
$config['logdb']['username'] = 'tdatctsc';
$config['logdb']['password'] = '2w]3H@7J9MUC';
$config['logdb']['database'] = "tdatctsc_scc_logdb_{$currentYear}";

$config['authdb']['hostname'] = 'localhost';
$config['authdb']['username'] = 'tdatctsc';
$config['authdb']['password'] = '2w]3H@7J9MUC';
$config['authdb']['database'] = 'tdatctsc_scc_authorization';
?>