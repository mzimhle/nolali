<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datuma Guest House - Make a booking</title>
	<meta name="keywords" content="online booking, guest house, make a booking, south africa, thornton cape town, bed and breakfast, western cape, accomodation">
	<meta name="description" content="{$campaign.campaign_name} allows you to make bookings online as well as allows you to see which dates are available.">          
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="{$campaign.campaign_name}"> 
	<meta property="og:image" content="http://{$campaign.campaign_domain}/images/logo.png"> 
	<meta property="og:url" content="http://{$campaign.campaign_domain}">
	<meta property="og:site_name" content="{$campaign.campaign_name}">
	<meta property="og:type" content="website">
	<meta property="og:description" content="{$campaign.campaign_name} allows you to make bookings online as well as allows you to see which dates are available.">
	{include_php file="$smartypath/includes/css.php"}
	{include_php file="$smartypath/includes/javascript.php"}
	<link rel="stylesheet" type="text/css" href="/library/javascript/fullcalendar-1.6.2/fullcalendar.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/library/javascript/fullcalendar-1.6.2/fullcalendar.print.css" media="screen" />
	<script type="text/javascript" language="javascript" src="/library/javascript/fullcalendar-1.6.2/fullcalendar.min.js"></script>
	<script type="text/javascript" language="javascript" src="/feeds/bookings.php"></script>
	<script type="text/javascript" language="javascript" src="/admin/library/javascript/date.js"></script>
</head> 
<body>
<div id="wrap">
	{include_php file="$smartypath/includes/header.php"}	
	<div id="main">
		<p>Please select the days you would like to book by simply dragging on top of them from start to finish.</p>
		<div id='calendar'></div>
	</div>
	{include_php file="$smartypath/includes/sidebar.php"}	
	{include_php file="$smartypath/includes/footer.php"}		
</div>
{literal}
<script type="text/javascript" language="javascript">		
$(document).ready(function() {
	
	var calendar = $('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month'
		},
		selectable: true,
		selectHelper: true,
		select: function(start, end, allDay) {
			
			var check = $.fullCalendar.formatDate(start,'yyyy-MM-dd');
			var today = $.fullCalendar.formatDate(new Date(),'yyyy-MM-dd');			
			
			if(check < today) {
				alert('You cannot book past dates.')
			} else {
				var startdate = new Date(start);
				var enddate = new Date(end);			
				window.location.href = '/campaign/booking/details.php?startdate='+startdate.format('yyyy-mm-dd')+'&enddate='+enddate.format('yyyy-mm-dd');				
			}
		},
		editable: true,
		events: bookings
	});
});
</script>
{/literal}
</body>
</html>