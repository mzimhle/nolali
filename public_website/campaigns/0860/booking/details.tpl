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
	{include_php file="$smartypath/includes/css.php"}
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	{include_php file="$smartypath/includes/javascript.php"}
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
</head>
<body>
<div id="wrap">
	{include_php file="$smartypath/includes/header.php"}	
	<div id="main">
		<h2>Contact {$domainData.campaign_name}!</h2>		
		<p>For any enquiries, please do not hesitate to contact us via the below contact form, we would like to know of any ideas, complaints or even improvements you would like to recommend to us.</p>
		<div class="clear"></div>
		<div class="line-hor"></div>
		<div id="contact-area">			
			<form method="post" action="{$link}booking/details.php?startdate={$startdate}&enddate={$enddate}" name="detailsForm" id="detailsForm">
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
							<label for="product_code">Room :</label>
							{if isset($errorArray.product_code)}<br /><em class="error">{$errorArray.product_code}</em>{/if}
						</td>
						<td>
							<select id="product_code" name="product_code">
								<option value=""> --- </option>
								{html_options options=$productPairs selected=$bookingData.product_code}
							</select>
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="productprice_code">Price :</label>
							{if isset($errorArray.productprice_code)}<em class="error">{$errorArray.productprice_code}</em>{/if}
						</td>
						<td id="producttypetd">
							<span class="error">Please select a product first.</span>
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
							<label for="participant_name">Name :</label>
							{if isset($errorArray.participant_name)}<br /><em class="error">{$errorArray.participant_name}</em>{/if}
						</td>
						<td>
							<input type="text" id="participant_name" name="participant_name" value="{$bookingData.participant_name}" />
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="participant_surname">Surname :</label>
							{if isset($errorArray.participant_surname)}<br /><em class="error">{$errorArray.participant_surname}</em>{/if}
						</td>
						<td>
							<input type="text" id="participant_surname" name="participant_surname" value="{$bookingData.participant_surname}" />
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="participant_email">Email :</label>
							{if isset($errorArray.participant_email)}<br /><em class="error">{$errorArray.participant_email}</em>{/if}
						</td>
						<td>
							<input type="text" id="participant_email" name="participant_email" value="{$bookingData.participant_email}" />
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="participant_cellphone">Cellphone :</label>
							{if isset($errorArray.participant_cellphone)}<br /><em class="error">{$errorArray.participant_cellphone}</em>{else}<em>e.g. 0815987412</em>{/if}
						</td>
						<td>
							<input type="text" id="participant_cellphone" name="participant_cellphone" value="{$bookingData.participant_cellphone}" />
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
	{include_php file="$smartypath/includes/sidebar.php"}	
	{include_php file="$smartypath/includes/footer.php"}		
</div>
{literal}
<script type="text/javascript">
function submitForm() {
	document.forms.detailsForm.submit();					 
}

$( document ).ready(function() {
		
	$('#product_code').change(function() {	
		getPrice();
	});
	
	getPrice();
	
	$( "#areapost_name" ).autocomplete({
		source: "/feeds/area.php",
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
		var product	= $('#product_code :selected').val();
		
		if(product != '') {
			$.ajax({
				type: "GET",
				url: "/campaign/booking/details.php",
				data: "{/literal}startdate={$startdate}&enddate={$enddate}{literal}&product_code_search="+product+"&price_code={/literal}{$bookingData.productprice_code}{literal}",
				dataType: "html",
				success: function(items){
					//show table
					$('#producttypetd').html(items);
				}
			});
		}
}	
</script>
{/literal}
</body>
</html>