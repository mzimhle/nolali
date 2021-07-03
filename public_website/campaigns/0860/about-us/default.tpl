<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datuma Guest House - About Us</title>
	<meta name="keywords" content="about us, guest house, south africa, thornton cape town, bed and breakfast, company profile, western cape, accomodation">
	<meta name="description" content="{$campaign.campaign_name} has been in business for the past 4 years. Suites are elegantly decorated and spacious with en-suite bathrooms.">          
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="{$campaign.campaign_name}"> 
	<meta property="og:image" content="http://{$campaign.campaign_domain}/images/logo.png"> 
	<meta property="og:url" content="http://{$campaign.campaign_domain}">
	<meta property="og:site_name" content="{$campaign.campaign_name}">
	<meta property="og:type" content="website">
	<meta property="og:description" content="{$campaign.campaign_name} has been in business for the past 4 years. Suites are elegantly decorated and spacious with en-suite bathrooms.">
	{include_php file="$smartypath/includes/css.php"}
	{include_php file="$smartypath/includes/javascript.php"}
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
		<h2>About {$domainData.campaign_name}!</h2>		
		<img class="img-indent pimg" alt="{$domainData.campaign_name} is happy to welcome you!" src="{$link}images/nqulelwa-mzana.jpg" />  
		<p class="alt-top">
			Datuma Guesthouse has been in business for the past 4 years. Suites are elegantly decorated and spacious with en-suite bathrooms. 
			<br /><br />6 Individually decorated luxury guest units with views of Table Mountain and Grand West Casino. Experience our units with heaters & en-suite bathrooms.
			<br /><br />Fine dining on request with excellence full English breakfast. Personal attention to detail in every aspect.
		</p>
		<p>Luxurious percale linen and high quality towels and personal toiletries complete your retreat experience at Datuma's which endeavours to go the extra mile in providing you with service excellence in every discipline.</p>
		<img class="img-indent png" alt="" src="{$link}images/1page-img1.png" /> 
		<img class="img-indent png" alt="" src="{$link}images/1page-img1b.png" /> 
		<img class="img-indent png" alt="" src="{$link}images/1page-img1c.png" /> 
		<img class="img-indent png" alt="" src="{$link}images/1page-img1cent.png">
		<div class="clear"></div>
		<div class="line-hor"></div>
		<div class="clear"></div>
<div class="wrapper line-ver">
            <div class="col-1">
              <h3>Facilities Offers</h3>
              <ul>
                <li>Own tv with Dstv channels</li>
				 <li>Internet Connectivity(Wifi)</li>
                <li>Ensuite bathrooms</li>
                <li>Breakfast included </li>
				 <li>Splash pool</li>
                <li>Exclusive souvenirs</li>
              </ul>
            </div>
            <div class="col-2">
              <h3>Value Added Services</h3>
              <ul>
                <li>Laundry services by arrangement</li>
				 <li>Secure parking</li>
                <li>Picnic baskets</li>
                <li>Tours and Transfers(by arrangement) </li>
				 <li>24 Hours security and access control to property</li>
              </ul>
            </div>
			 <div class="col-1">
              <h3>Conveniently Close to</h3>
              <ul>
                <li>Cape Town Stadium</li>
				 <li>Grand West Casino</li>
                <li>Cape Town International Airport</li>
                <li>V&amp;A Waterfront </li>
                <li>Century City Mall</li>
				 <li>Vincent Palloti Hospital </li>
                <li>And Many More</li>
              </ul>
            </div>
            <div class="col-2">
              <h3>Location</h3>
              <p>We are located in a Surburb called Thornton right opposite Grand West Casino, and 5 Km away from CAnal Walk Mall in Century City.</p>
            </div>
          </div>
		<div class="clear"></div>
		<div class="line-hor"></div>
		<div class="clear"></div>		
		<div id="map-canvas"></div>
	</div>
	{include_php file="$smartypath/includes/sidebar.php"}	
	{include_php file="$smartypath/includes/footer.php"}	
</div>
</body>
</html>