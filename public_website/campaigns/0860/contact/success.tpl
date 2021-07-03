<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datuma Guest House - Contact Us</title>
	<meta name="keywords" content="contact us, thank you, enquiry form, guest house, complaints, comments, south africa, thornton cape town, bed and breakfast, western cape, accomodation">
	<meta name="description" content="{$campaign.campaign_name} is greatful for your enquiry, we will get back to you as soon as possible.">          
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="{$campaign.campaign_name}"> 
	<meta property="og:image" content="http://{$campaign.campaign_domain}/images/logo.png"> 
	<meta property="og:url" content="http://{$campaign.campaign_domain}">
	<meta property="og:site_name" content="{$campaign.campaign_name}">
	<meta property="og:type" content="website">
	<meta property="og:description" content="{$campaign.campaign_name} is greatful for your enquiry, we will get back to you as soon as possible.">
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
		<h2>Enquiry Sent successfully!</h2>		
		<p>Good day, your enquiry form was sent successfully, we will get back to you as soon as possible.</p>
		<div class="clear"></div>
		<div class="line-hor"></div>		
		<div id="map-canvas"></div>
	</div>
	{include_php file="$smartypath/includes/sidebar.php"}	
	{include_php file="$smartypath/includes/footer.php"}		
</div>
</body>
</html>