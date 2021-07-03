<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datuma Guest House - Make a booking and add your details</title>
	<meta name="keywords" content="online booking, guest house, make a booking, south africa, thornton cape town, bed and breakfast, western cape, accomodation">
	<meta name="description" content="{$campaign.campaign_name} allows you to make bookings online but then you need to give us your contact details, we will get back to you as soon as possible.">          
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="{$campaign.campaign_name}"> 
	<meta property="og:image" content="http://{$campaign.campaign_domain}/images/logo.png"> 
	<meta property="og:url" content="http://{$campaign.campaign_domain}">
	<meta property="og:site_name" content="{$campaign.campaign_name}">
	<meta property="og:type" content="website">
	<meta property="og:description" content="{$campaign.campaign_name} allows you to make bookings online but then you need to give us your contact details, we will get back to you as soon as possible.">
	{include_php file="includes/css.php"}
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	{include_php file="includes/javascript.php"}
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
</head>
<body>
<div id="wrap">
	{include_php file="includes/header.php"}	
	<div id="main">
		<h2>{$campaign.campaign_name} bookings</h2>		
		<p>For any bookings please fill in the below form and we will get back to you as soon as you have confirmed your email address.</p>
		{if isset($success)}
		<p class="success">Thank you for submitting a booking, we will get back to you as soon as possible, you will however get a confirmation email to confirm your email address as being valid, from there on we will process your booking</p>
		{/if}
		<div class="clear"></div>
		<div class="line-hor"></div>
		<div id="contact-area">			
			<form method="post" action="/booking/details.php?startdate={$startdate}&enddate={$enddate}" name="detailsForm" id="detailsForm">
				<table>
					<tr>
						<td class="left">
							<label for="booking_startdate">Start Date:</label>
							{if isset($errorArray.booking_startdate)}<em class="error">{$errorArray.booking_startdate}</em>{/if}
						</td>
						<td>
							<span class="success">{$startdate|date_format}</span>
							<input type="hidden" value="{$startdate}" id="booking_startdate" name="booking_startdate" />
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="booking_enddate">End Date:</label>
							{if isset($errorArray.booking_enddate)}<em class="error">{$errorArray.booking_enddate}</em>{/if}
						</td>
						<td>
							<span class="success">{$enddate|date_format}</span>
							<input type="hidden" value="{$enddate}" id="booking_enddate" name="booking_enddate" />
						</td>
					</tr>
					<tr>
						<td class="left" colspan="2">
							<div class="line-hor"></div>
							<div class="clear"></div>								
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="product_code">Our Suites :</label>
							{if isset($errorArray.product_code)}<br /><em class="error">{$errorArray.product_code}</em>{/if}
						</td>
						<td>
							<select id="product_code" name="product_code">
								<option value=""> --- </option>
								{html_options options=$productPairs}
							</select>
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="productitem_code">Rooms :</label>
							{if isset($errorArray.productitem_code)}<em class="error">{$errorArray.productitem_code}</em>{/if}
						</td>
						<td id="productitemtypetd">
							<select name="productitem_code" id="productitem_code">
								<option value="">Please select a suite first.</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="_price_code">Room Prices :</label>
							{if isset($errorArray._price_code)}<em class="error">{$errorArray._price_code}</em>{/if}
						</td>
						<td id="pricetd">
							<select name="_price_code" id="_price_code">
								<option value="">Please select a room first.</option>
							</select>
						</td>
					</tr>					
					<tr>
						<td class="left" valign="top">
							<label for="booking_message">Message / Request:</label>
							{if isset($errorArray.booking_message)}<em class="error">{$errorArray.booking_message}</em>{else}<em>(Optional)</em>{/if}
						</td>
						<td><textarea name="booking_message" id="booking_message" rows="20" cols="20">{$bookingData.booking_message}</textarea></td>
					</tr>
					<tr>
						<td class="left" colspan="2">
							<div class="line-hor"></div>
							<div class="clear"></div>								
						</td>
					</tr>	
					<tr>
						<td class="left">
							<label for="booking_person_name">Full Name :</label>
							{if isset($errorArray.booking_person_name)}<br /><em class="error">{$errorArray.booking_person_name}</em>{/if}
						</td>
						<td>
							<input type="text" id="booking_person_name" name="booking_person_name" value="{$bookingData.booking_person_name}" />
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="booking_person_email">Email :</label>
							{if isset($errorArray.booking_person_email)}<br /><em class="error">{$errorArray.booking_person_email}</em>{/if}
						</td>
						<td>
							<input type="text" id="booking_person_email" name="booking_person_email" value="{$bookingData.booking_person_email}" />
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="booking_person_number">Telephone / Cellphone :</label>
							{if isset($errorArray.booking_person_number)}<br /><em class="error">{$errorArray.booking_person_number}</em>{else}<em>e.g. 0815987412</em>{/if}
						</td>
						<td>
							<input type="text" id="booking_person_number" name="booking_person_number" value="{$bookingData.booking_person_number}" />
						</td>
					</tr>					
					<tr>
						<td class="left">
							<label for="areapost_name">City / Town:</label>
							{if isset($errorArray.areapost_code)}<em class="error">{$errorArray.areapost_code}</em>{/if}
						</td>
						<td>
							<input type="text" name="areapost_name" id="areapost_name" value="{$bookingData.areapost_name}" />
							<input type="hidden" name="areapost_code" id="areapost_code" value="{$bookingData.areapost_code}" />
						</td>
					</tr>
					<tr>
						<td valign="top">{if isset($errorArray.booking_captcha)}<br /><em class="error">Incorrect characters entered, please try again.</em>{/if}</td>
						<td>
							<div id="captcha-area">{$captchahtml}</div>	
						</td>
					</tr>
				</table>
				<br /><br />						
				<input type="submit" name="submit" value="Submit" class="submit-button" />
			</form>		
		</div>
	</div>
	{include_php file="includes/sidebar.php"}	
	{include_php file="includes/footer.php"}		
</div>
{literal}
<script type="text/javascript">
function submitForm() {
	document.forms.detailsForm.submit();					 
}

$( document ).ready(function() {
		
	$('#product_code').change(function() {	
		getItem();
	});
	
	$('#productitem_code').change(function() {	
		getPrice();
	});
	
	$( "#areapost_name" ).autocomplete({
		source: "/feeds/areapost.php",
		minLength: 2,
		select: function( event, ui ) {
		
			if(ui.item.id == '') {
				$('#areapost_code').val('');					
			} else { 
				$('#areapost_code').val(ui.item.id);									
			}
			
			$('#areapost_name').val('');										
		}
	});	
});	

function getPrice() {
	var productitem	= $('#productitem_code :selected').val();
	
	if(productitem != '') {
		$.ajax({
			type: "GET",
			url: "/booking/details.php",
			data: "{/literal}startdate={$startdate}&enddate={$enddate}{literal}&productitem_code_search="+productitem,
			dataType: "html",
			success: function(items){
				$('#_price_code').html(items);
			}
		});
	}
}

function getItem() {
	var product	= $('#product_code :selected').val();
	
	if(product != '') {
		$.ajax({
			type: "GET",
			url: "/booking/details.php",
			data: "{/literal}startdate={$startdate}&enddate={$enddate}{literal}&product_code_search="+product,
			dataType: "html",
			success: function(items){
				//show table
				$('#productitem_code').html(items);
			}
		});
	}
}	
</script>
{/literal}
</body>
</html>