<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datuma Guest House - Contact Us</title>
	<meta name="keywords" content="contact us, enquiry form, guest house, complaints, comments, south africa, thornton cape town, bed and breakfast, western cape, accomodation">
	<meta name="description" content="{$campaign.campaign_name} is asking if you can please send us compliments, complaints or general enquiries via this page, we will get back to you as soon as possible.">          
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="{$campaign.campaign_name}"> 
	<meta property="og:image" content="http://{$campaign.campaign_domain}/images/logo.png"> 
	<meta property="og:url" content="http://{$campaign.campaign_domain}">
	<meta property="og:site_name" content="{$campaign.campaign_name}">
	<meta property="og:type" content="website">
	<meta property="og:description" content="{$campaign.campaign_name} is asking if you can please send us compliments, complaints or general enquiries via this page, we will get back to you as soon as possible.">
	{include_php file="$smartypath/includes/css.php"}
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	{include_php file="$smartypath/includes/javascript.php"}
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	{literal}
    <style>
      #map-canvas {
			height: 300px;
			widht: 700px;
			margin: 0px;
			padding: 0px
      }
    </style>	
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script type="text/javascript">
		function initialize() {
		  var myLatlng = new google.maps.LatLng(-33.919296, 18.541452);
		  var mapOptions = {
			zoom: 16,
			mapTypeId: google.maps.MapTypeId.SATELLITE,
			center: myLatlng
		  }
		  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		  var marker = new google.maps.Marker({
			  position: myLatlng,
			  map: map,
			  title: '{/literal}{$domainData.campaign_name}{literal}'
		  });
		}
		google.maps.event.addDomListener(window, 'load', initialize);
    </script>
	{/literal}
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
			<form method="post" action="{$link}contact/" name="detailsForm" id="detailsForm">
				<table>
					<tr>
						<td class="left">
							<label for="enquiry_name">Full name:</label>
							{if isset($errorArray.enquiry_name)}<em class="error">{$errorArray.enquiry_name}</em>{/if}
						</td>
						<td><input type="text" name="enquiry_name" id="enquiry_name" value="" /></td>
					</tr>
					<tr>
						<td class="left">
							<label for="areapost_name">City / Town:</label>
							{if isset($errorArray.areapost_code)}<em class="error">{$errorArray.areapost_code}</em>{/if}
						</td>
						<td>
							<input type="text" name="areapost_name" id="areapost_name" />
							<input type="hidden" name="areapost_code" id="areapost_code" />
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="enquiry_email">Email:</label>
							{if isset($errorArray.enquiry_email)}<em class="error">{$errorArray.enquiry_email}</em>{/if}
						</td>
						<td><input type="text" name="enquiry_email" id="enquiry_email" value="" /></td>
					</tr>
					<tr>
						<td class="left">
							<label for="enquiry_number">Cellphone :</label>
							{if isset($errorArray.enquiry_number)}<br /><em class="error">{$errorArray.enquiry_number}</em>{else}<em>(Optional e.g. 0735698741){/if}
						</td>
						<td><input type="text" name="enquiry_number" id="enquiry_number" value="" /></td>
					</tr>
					<tr>
						<td class="left">
							<label for="enquiry_subject">Subject :</label>
							{if isset($errorArray.enquiry_subject)}<em class="error">{$errorArray.enquiry_subject}</em>{/if}
						</td>
						<td>
							<select name="enquiry_subject" id="enquiry_subject">
								<option value="Enquiry"> Enquiry </option>
								<option value="Complaint"> Complaint </option>
								<option value="Improvement / Suggestion"> Improvement / Suggestion </option>
							</select>
						</td>
					</tr>						
					<tr>
						<td class="left" valign="top">
							<label for="enquiry_comments">Message:</label>
							{if isset($errorArray.enquiry_comments)}<em class="error">{$errorArray.enquiry_comments}</em>{/if}
						</td>
						<td><textarea name="enquiry_comments" id="enquiry_comments" rows="20" cols="20"></textarea></td>
					</tr>
				</table>	
				<p>To make sure you are not a spammer and are a person, please confirm the characters you see in the box below before you submit.</p>
				{if isset($errorArray.enquiry_captcha)}<em class="error">Incorrect captcha details, please fill in the correct characters in the box.</em>{/if}
				<br /><br />
				<div id="captcha-area">{$captchahtml}</div>								
				<input type="submit" name="submit" value="Submit" class="submit-button" />
			</form>
		
		</div>
		<div class="clear"></div>
		<div class="line-hor"></div>			
		<div id="map-canvas"></div>
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
</script>
{/literal}
</body>
</html>