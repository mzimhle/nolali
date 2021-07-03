<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

require_once 'gapi.class.php';

$email = "willow.nettica@gmail.com";
$password = "sakile123";
$report_id = 73634502; // $report_id is the Google report ID for the selected account


		$stats = array();
		$visits = array();

		$ga = new gapi($email, $password);

		$time_start = date("Y-m-d", mktime(0, 0, 0, date("m")-2, date("d"),   date("Y")));
		$time_end  = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d"), date("Y")));

		$ga->requestReportData($report_id, array('date'), array('visits'), array("date"), null, $time_start, $time_end);
		
		foreach($ga->getResults() as $result){
			$metrics = $result->getMetrics();
			$dimesions = $result->getDimesions();
			$date = $dimesions["date"];
			list($year, $month, $day) = array(substr($date, 0, 4), substr($date, 4, 2), substr($date, 6, 2));
			$timestamp = mktime(0, 0, 0, $month, $day, $year);
			$stats[] = array($timestamp*1000, $metrics['visits']);
		}
		
		for($i=0;$i<count($stats);$i++) $visits[] = $stats[$i][1];
		$max = max($visits);
		$min = min($visits);
		$medium = $min + ($max - $min)/2;
		$max_new = $medium*2;
		if($max_new>100 && $max_new < 1000) $roundFigure = 100;
		elseif($max_new>=1000 && $max_new < 10000) $roundFigure = 500;
		else $roundFigure = 1000;
		$output = $max_new - fmod($max_new, $roundFigure) + $roundFigure;
		$min = 0;
		$return = array("stats" => $stats, "ticks" => array($min, $output/2, $output), "max" => $output, "min" => $min);
		echo 'var stats = '.json_encode($return['stats']).';';


?>