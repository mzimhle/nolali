<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';
require_once 'adminclient/1T33/includes/auth.php';
require_once 'class/campaignbooking.php';

$campaignbookingsObject	= new class_campaignbooking();

$bookingCalendar		= array();
$classes				= array('customevent1', 'customevent2', 'customevent3', 'customevent4', 'customevent5', 'customevent6', 'customevent7', 'customevent8', 'customevent9', 'customevent10', 'customevent11');
$i								= 0;
$campaignbookingData	= $campaignbookingsObject->getAll('campaignbooking_deleted = 0', 'campaignbooking_added DESC');

if($campaignbookingData) {
	foreach($campaignbookingData as $item) {
		
		$colour	= rand(0, (count($classes) - 1));
			
		$bookingCalendar[$i]['id']				= $i;
		$bookingCalendar[$i]['start'] 			= $item['campaignbooking_startdate'];
		$bookingCalendar[$i]['end'] 			= $item['campaignbooking_enddate'];
		$bookingCalendar[$i]['title']			= $item['participant_name'].' '.$item['participant_name'].' - Booked for '.$item['campaignproduct_name'];
		$bookingCalendar[$i]['url']				= '/admin/bookings/details.php?code='.$item['campaignbooking_code'];
		$bookingCalendar[$i]['allDay']		= 'true';
		$bookingCalendar[$i]['className']	= $classes[$colour].' iframe';
		
		$i++;
	}
}
$json = json_encode($bookingCalendar);

echo "var bookings = $json;";

?>