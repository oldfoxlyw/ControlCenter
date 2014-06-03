<?php
function getTimeProgress($startTimeStamp, $endTimeStamp) {
	$data = array();
	if(is_numeric($startTimeStamp) && is_numeric($endTimeStamp) && $endTimeStamp>=$startTimeStamp) {
		$startYear = intval(date('Y', $startTimeStamp));
		$endYear = intval(date('Y', $endTimeStamp));
		$startMonth = intval(date('n', $startTimeStamp));
		$endMonth = intval(date('n', $endTimeStamp));
		$startDate = intval(date('j', $startTimeStamp));
		$endDate = intval(date('j', $endTimeStamp));
		if($startYear==$endYear) {
			if($startMonth==$endMonth) {
				for($i=$startDate; $i<=$endDate; $i++) {
					$data["$startMonth-$i"] = 0;
				}
			} else {
				for($i=$startMonth; $i<=$endMonth; $i++) {
					$count = days_in_month($i, $startYear);
					if($i==$startMonth) {
						for($j=$startDate; $j<=$count; $j++) {
							$data["$i-$j"] = 0;
						}
					} elseif($i==$endMonth) {
						for($j=1; $j<=$endDate; $j++) {
							$data["$i-$j"] = 0;
						}
					} else {
						for($j=1; $j<=$count; $j++) {
							$data["$i-$j"] = 0;
						}
					}
				}
			}
		} else {
			for($y=$startYear; $y<=$endYear; $y++) {
				if($y==$startYear) {
					for($m=$startMonth; $m<=12; $m++) {
						$count = days_in_month($m, $startYear);
						if($m==$startMonth) {
							for($j=$startDate; $j<=$count; $j++) {
								$data["$m-$j"] = 0;
							}
						} elseif($m==$endMonth) {
							for($j=1; $j<=$endDate; $j++) {
								$data["$m-$j"] = 0;
							}
						} else {
							for($j=1; $j<=$count; $j++) {
								$data["$m-$j"] = 0;
							}
						}
					}
				} elseif($y==$endYear) {
					for($m=1; $m<=$endMonth; $m++) {
						$count = days_in_month($m, $startYear);
						if($m==$endMonth) {
							for($j=1; $j<=$endDate; $j++) {
								$data["$m-$j"] = 0;
							}
						} elseif($m==1) {
							for($j=$startDate; $j<=$count; $j++) {
								$data["$m-$j"] = 0;
							}
						} else {
							for($j=1; $j<=$count; $j++) {
								$data["$m-$j"] = 0;
							}
						}
					}
				} else {
					for($m=1; $m<=12; $m++) {
						$count = days_in_month($m, $startYear);
						for($j=1; $j<=$count; $j++) {
							$data["$m-$j"] = 0;
						}
					}
				}
			}
		}
	}
	return $data;
}

function getHoursArray() {
	$data = array();
	for($i=0; $i<24; $i++) {
		$data[$i] = 0;
	}
	return $data;
}

function getDatesArray($year = '', $month = 0) {
	if(empty($year) || $month==0) {
		$year = date('Y', time());
		$month = intval(date('n', time()));
	}
	$count = days_in_month($month, $year);
	$data = array();
	for($i=0; $i<$count; $i++) {
		$data[$i] = 0;
	}
	return $data;
}

function getMonthsArray() {
	$data = array();
	for($i=0; $i<12; $i++) {
		$data[$i] = 0;
	}
	return $data;
}
?>