<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';
require_once 'class/booking.php';

$bookingObject	= new class_booking();

$bookingCalendar			= array();
$classes						= array('customevent1', 'customevent2', 'customevent3', 'customevent4', 'customevent5', 'customevent6', 'customevent7', 'customevent8', 'customevent9', 'customevent10', 'customevent11');
$i									= 0;
$bookingData	= $bookingObject->getAll();

if($bookingData) {
	foreach($bookingData as $item) {
		
		$colour	= rand(0, (count($classes) - 1));
			
		$bookingCalendar[$i]['id']				= $i;
		$bookingCalendar[$i]['start'] 			= $item['booking_startdate'];
		$bookingCalendar[$i]['end'] 			= $item['booking_enddate'];
		$bookingCalendar[$i]['title']			= $item['product_name'].' booked';
		$bookingCalendar[$i]['url']				= '#';
		$bookingCalendar[$i]['allDay']		= 'true';
		$bookingCalendar[$i]['className']	= $classes[$colour];
		
		$i++;
	}
}
$json = json_encode($bookingCalendar);

echo "var bookings = $json;";

?>