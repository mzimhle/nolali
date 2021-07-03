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
				<a href="/admin/daily-bookings/">Bookings</a> &raquo; <a href="#">{if isset($bookingData)}Edit booking{else}Add a booking{/if}</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
				<form id="detailsForm" name="detailsForm" action="/admin/daily-bookings/details.php{if isset($bookingData)}?code={$bookingData.booking_code}{else}?startdate={$startdate}&enddate={$enddate}{/if}" method="post">
				<div class="col">						
					<div class="article">
						<h4><a href="#" class="error">Start Date</a></h4>
						<p class="short">
							{if !isset($enddate)}
							<input type="text" name="booking_startdate" id="booking_startdate" value="{$bookingData.booking_startdate|date_format:'%Y-%m-%d'}" size="10"/>
							{else}
								<span class="success">{$startdate|date_format}</span>
								<input type="hidden" name="booking_startdate" id="booking_startdate" value="{$startdate}" size="10"/>
							{/if}
							{if isset($errorArray.booking_startdate)}<br /><em class="error">{$errorArray.booking_startdate}</em>{/if}
						</p>
					</div>										
					<div class="article">
						<h4><a href="#"  class="error">Client</a></h4>					
							<div class="ui-widget">						
								<input type="text" name="participant_name" id="participant_name" value="{if isset($bookingData)}{$bookingData.participant_name} {$bookingData.participant_surname}{/if}" size="40" /> &nbsp;
								<input type="hidden" name="participant_code" id="participant_code" value="{$bookingData.participant_code}" />
								<br /><span id="participantcodename" name="participantcodename" class="selecteditem">{if isset($bookingData)}{$bookingData.participant_name} {$bookingData.participant_surname}{else}No selection made{/if}</span>
								{if isset($errorArray.participant_code)}<br /><em class="error">{$errorArray.participant_code}</em>{/if}
								<br /><br />
							</div>	
					</div>	
					<div class="article">
						<h4><a href="#">Message</a></h4>					
							<p class="short">					
								<textarea cols="35" rows="4" name="booking_message" id="booking_message">{$bookingData.booking_message}</textarea>
							</p>
					</div>	
					{if isset($bookingData)}
					<div class="article">
						<h4><a href="#">Message</a></h4>					
							<p class="short">					
							{if $bookingData.invoice_html neq ''}
							<a href="http://{$domainData.campaign_domain}{$bookingData.invoice_pdf}" target="_blank">Download PDF</a>
							{else}
							<span class="error">No pdf has been generated for this invoice.</span>
							{/if}	
							</p>
					</div>					
					{/if}
					<div class="article">
						<p class="short">
							<a class="link" href="javascript:submitForm();">Save Details</a>
							<br /><br />
							{if isset($success)}<span class="success">Your details have been updated.</span>{/if}
						</p>
					</div>						
				</div>				
				<div class="col">	
					<div class="article">
						<h4><a href="#" class="error">End Date</a></h4>
						<p class="short">
							{if !isset($enddate)}
							<input type="text" name="booking_enddate" id="booking_enddate" value="{$bookingData.booking_enddate|date_format:'%Y-%m-%d'}" size="10"/>
							{else}
								<span class="success">{$enddate|date_format}</span>
								<input type="hidden" name="booking_enddate" id="booking_enddate" value="{$enddate}" size="10"/>
							{/if}
							{if isset($errorArray.booking_enddate)}<br /><em class="error">{$errorArray.booking_enddate}</em>{/if}
						</p>
					</div>				
					<div class="article">
						<h4><a href="#" class="error">Product</a></h4>
						<p class="short">
							<select id="product_code" name="product_code">
								<option value=""> --- </option>
								{html_options options=$productPairs selected=$bookingData.product_code}</td>
							</select>	
							{if isset($errorArray.product_code)}<br /><em class="error">{$errorArray.product_code}</em>{/if}		
							{if isset($errorArray.productprice_code)}<br /><em class="error">{$errorArray.productprice_code}</em>{/if}									
						</p>
					</div>					
					<div class="article">
						<h4><a href="#" class="error">Product Price</a></h4>
						<p class="short" id="producttypetd">
							{if isset($bookingData.productprice_name)} 
								{$bookingData.productprice_name} - R {$bookingData.productprice_price}								
							{else}
								<span class="error">Please select a product first.</span>
							{/if}
							<input type="hidden" name="productprice_code" id="productprice_code" value="{$bookingData.productprice_code}" />
						</p>										
					</div>
					{if isset($bookingData)}
					<div class="article">
						<h4><a href="#">Invoice Fully Paid Date</a></h4>
						<p class="short">
							<input type="text" name="invoice_paid_date" id="invoice_paid_date" value="{$bookingData.invoice_paid_date}" size="10"/>
						</p>
					</div>
					<div class="article">
						<h4><a href="#">Invoice Paid</a></h4>
						<p class="short">
							<input type="checkbox" id="invoice_paid" name="invoice_paid" value="1" {if $bookingData.invoice_paid eq '1'}checked{/if} disabled />
						</p>
					</div>
					{/if}					
				</div>	
				</form>
				<div class="col">
					<div class="article">
						<h4><a href="calendar.php">View Booking Calendar</a></h4>
						<p class="short line">
							View all and edit booked dates for rooms / houses, etc.
						</p>
					</div>					
				</div>					
				<div class="clr"></div>
			</div>
			{include_php file='includes/footer.php'}
		</div>
		{literal}
		<script type="text/javascript" language="javascript" src="/feeds/bookings_calendar.php"></script>	
		<script type="text/javascript">
		function submitForm() {
			document.forms.detailsForm.submit();					 
		}
		
		$( document ).ready(function() {
				
			$('#product_code').change(function() {
			
			var product	= $('#product_code :selected').val();
			
				$.ajax({
					type: "GET",
					url: "/admin/daily-bookings/details.php",
					data: "{/literal}{if isset($bookingData)}code={$bookingData.booking_code}{else}startdate={$startdate}&enddate={$enddate}{/if}{literal}&product_code_search="+product,
					dataType: "html",
					success: function(items){
						//show table
						$('#producttypetd').html(items);
					}
				});	
			});
	
			$( "#participant_name" ).autocomplete({
				source: "/feeds/participants.php",
				minLength: 2,
				select: function( event, ui ) {
				
					if(ui.item.id == '') {
						$('#participantcodename').html('');
						$('#participant_code').val('');					
					} else { 
						$('#participantcodename').html('<b>' + ui.item.value + '</b>');
						$('#participant_code').val(ui.item.id);									
					}
					
					$('#participant_name').val('');										
				}
			});
			
			{/literal}{if isset($bookingData)}{literal}
			$( "#invoice_paid_date" ).datepicker({
			  defaultDate: "+1w",
			  dateFormat: 'yy-mm-dd',
			  changeMonth: true,
			  changeYear: true
			});
			{/literal}{/if}{literal}
			
			{/literal}{if !isset($startdate)}{literal}
			$( "#booking_startdate" ).datepicker({
			  defaultDate: "+1w",
			  dateFormat: 'yy-mm-dd',
			  changeMonth: false,
			  changeYear: false,
			  numberOfMonths: 3,
			  onClose: function( selectedDate ) {
				$( "#booking_enddate" ).datepicker( "option", "minDate", selectedDate );
			  }
			});
			
			$( "#booking_enddate" ).datepicker({
			  defaultDate: "+1w",
			  dateFormat: 'yy-mm-dd',
			  changeMonth: false,
			  changeYear: false,
			  numberOfMonths: 3,
			  onClose: function( selectedDate ) {
				$( "#booking_startdate" ).datepicker( "option", "maxDate", selectedDate );
			  }
			});
			{/literal}{/if}{literal}
		});		
		</script>
		{/literal}			
	</body>
</html>