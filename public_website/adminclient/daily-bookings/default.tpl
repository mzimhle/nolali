<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<script type="text/javascript" language="javascript" src="default.js"></script>
		<title>Daily Bookings | {$domainData.campaign_company}</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum"><a class="first" href="/admin/">Home</a> &raquo; <a href="/admin/daily-bookings/">Daily Bookings</a></p>
			<p class="linebreak"></p>
			<div id="main">
				<a class="link" href="/admin/daily-bookings/calendar.php">Add a New Booking / View Calendar</a>
				<div id="tableContent" align="center">
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="htmlForm" id="htmlForm" action="/admin/daily-bookings/" method="post">
							<table border="0" cellspacing="0" cellpadding="0" id="dataTable">							
							<thead>
						  <tr>
							<th>Added</th>
							<th>Person</th>
							<th>Start Date - End Date</th>
							<th>Days</th>				
							<th>Product</th>
							<th></th>				
						   </tr>
						   </thead>
						   <tbody>
						  {foreach from=$bookingData item=item}
						  <tr>
							<td>{$item.booking_added|date_format}</td>
							<td align="left">{$item.participant_name} {$item.participant_surname}</td>				
							<td align="left"><a href="/admin/daily-bookings/details.php?code={$item.booking_code}">{$item.booking_startdate|date_format:"%A, %B %e, %Y"} till {$item.booking_enddate|date_format:"%A, %B %e, %Y"}</a></td>
							<td align="left">{date_diff date1=$item.booking_startdate date2=$item.booking_enddate}</td>
							<td align="left">{$item.product_name}</td>
							<td align="left"><a class="link" href="javascript:deleteBooking('{$item.booking_code}');">Delete booking</a></td>
						  </tr>
						  {/foreach}     
						  </tbody>
							</table>
						 </form>
					 </div>
					 <!-- End Content Table -->
					<div class="clear"></div>				
				</div>
			</div>							
			<div class="clr"></div>
			{include_php file='includes/footer.php'}
			{literal}
			<script type="text/javascript">
				function deleteBooking(id) {	
					if(confirm('Are you sure you want to delete this item?')) {

						$.ajax({ 
								type: "GET",
								url: "default.php",
								data: "booking_code_delete="+id,
								dataType: "json",
								success: function(data){
										if(data.result == 1) {
											alert('Deleted');
											window.location.href = window.location.href;
										} else {
											alert(data.error);
										}
								}
						});	
					}
				}				
			</script>
			{/literal}			
			</div>
	</body>
</html>