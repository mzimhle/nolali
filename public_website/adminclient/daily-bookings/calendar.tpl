<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>{$domainData.campaign_company} | Admin | Bookings</title>
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/daily-bookings/">Bookings</a> &raquo; 
				<a href="#">{if isset($bookingData)}Edit booking{else}Add a booking{/if}</a>
			</p>			
			<p class="linebreak"></p>			
			<div class="clr"></div>		
			<div id="main">
			<a class="link" href="/admin/daily-bookings/">List View</a>
			<br /><br />
			<div class="clr"></div>				
			<div id='calendar'></div>		
			<div class="clr"></div>			
			</div>
			{include_php file='includes/footer.php'}
		</div>
		{include_php file='includes/calendar.php'}
	</body>
</html>