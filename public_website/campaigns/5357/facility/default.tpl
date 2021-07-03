<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datuma Guest House - Facilities / Guest Houses</title>
	<meta name="keywords" content="our suits, suits, rooms, guest house, south africa, thornton cape town, bed and breakfast, western cape, accomodation">
	<meta name="description" content="{$campaign.campaign_name} has a range of available rooms and suits of your choice, you can choose from here as to which one you would like to book.">          
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="{$campaign.campaign_name}"> 
	<meta property="og:image" content="http://{$campaign.campaign_domain}/images/logo.png"> 
	<meta property="og:url" content="http://{$campaign.campaign_domain}">
	<meta property="og:site_name" content="{$campaign.campaign_name}">
	<meta property="og:type" content="website">
	<meta property="og:description" content="{$campaign.campaign_name} has a range of available rooms and suits of your choice, you can choose from here as to which one you would like to book.">
	{include_php file="includes/css.php"}
	{include_php file="includes/javascript.php"}
	{literal}
	<script type="text/javascript">
		$(document).ready(function() {
			
			{/literal}{foreach from=$productitemData item=item name=gallery}{literal}
			
			$(".fancybox_{/literal}{$item.productitem_code}{literal}_click").click(function() {
				$.fancybox.open([
					{/literal}{foreach from=$item.productitemimage item=image name=fancyimage}{literal}
					{ href : {/literal}'http://{$campaign.campaign_domain}/{$image.productitemimage_path}/big_{$image.productitemimage_code}{$image.productitemimage_extension}', title : '{$image.productitemimage_description}' {literal}}{/literal}{if $smarty.foreach.fancyimage.last}{else},{/if}{literal}
					{/literal}{/foreach}{literal}
				], {
					padding : 0
				});
				return false;
			});
			{/literal}{/foreach}{literal}		
			});
	</script>	
	{/literal}	
</head>
<body>
<div id="wrap">
	{include_php file="includes/header.php"}	
	<div id="main">
		<h2>We offer several kinds of rooms</h2>
		<div id="gallery">
			{foreach from=$productitemData item=item name=facility}
			<div class="galleryitem">
				<a href="javascript:;" class="fancybox_{$item.productitem_code}_click"> 
					<img class="extra-img png" width="200" src="/{$item.productitemimage_path}/tmb_{$item.productitemimage_code}{$item.productitemimage_extension}" title="{$item.campaign_name} - {$item.productitem_name}" alt="{$campaign.campaign_name} - {$item.productitem_name}" />
				</a>
				<br />
				<b class="gallerytitle">{$item.productitem_name}</b><br />
				<p>{$item.productitem_description}</p>
				{foreach from=$item.productitems item=productitem}
				<p class="sectionitem">{$productitem.productitem_name}</p>
				{/foreach}
				<p><b>Prices</b></p>
				{if !empty($item.price)}
				{foreach from=$item.price item=price}
					<p class="sectionitem">{$price._price_number} people - R {$price._price_cost|number_format:2:",":"."} per night</p>				
				{/foreach}	
				{else}
					<p class="sectionitem">No prices set yet</p>
				{/if}				
				<p><b>Features</b></p>
				{if !empty($item.feature)}
				{foreach from=$item.feature item=feature}
					<p class="sectionitem">{$feature.productitemdata_name} - {$feature.productitemdata_description}</p>				
				{/foreach}	
				{else}
					<p class="sectionitem">No prices set yet</p>
				{/if}
<br />				
				<div class="button">
					<span><span><a href="javascript:;" class="fancybox_{$item.product_code}_click">view facility</a></span></span>
				</div>
			</div>
			{if $smarty.foreach.facility.iteration is div by 3}<div class="line-hor"></div>{/if}
			{/foreach}
		</div>
	</div>
	{include_php file="includes/sidebar.php"}	
	{include_php file="includes/footer.php"}	
</div>
</body>
</html>