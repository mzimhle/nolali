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
	{include_php file="$smartypath/includes/css.php"}
	{include_php file="$smartypath/includes/javascript.php"}
	{literal}
	<script type="text/javascript">
		$(document).ready(function() {
			
			{/literal}{foreach from=$productData item=item name=gallery}{literal}
			
			$(".fancybox_{/literal}{$item.product_code}{literal}_click").click(function() {
				$.fancybox.open([
					{/literal}{foreach from=$item.productimages item=image name=fancyimage}{literal}
					{ href : {/literal}'http://{$image.campaign_domain}{$image.productimage_path}/big_{$image.productimage_code}{$image.productimage_extension}', title : '{$image.productimage_description}' {literal}}{/literal}{if $smarty.foreach.fancyimage.last}{else},{/if}{literal}
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
	{include_php file="$smartypath/includes/header.php"}	
	<div id="main">
		<h2>We offer several kinds of rooms</h2>
		<div id="gallery">
			{foreach from=$productData item=item name=gallery}
			<div class="galleryitem">
				<a href="javascript:;" class="fancybox_{$item.product_code}_click"> 
					<img class="extra-img png" width="200" src="{$item.productimage_path}/tmb_{$item.productimage_code}{$item.productimage_extension}" title="{$item.campaign_name} - {$item.product_name}" alt="{$item.campaign_name} - {$item.product_name}" />
				</a>
				<br />
				<b class="gallerytitle">{$item.product_name}</b><br />
				<p>{$item.product_description}</p>
				{foreach from=$item.productitems item=productitem}
				<p class="sectionitem">{$productitem.productitem_name}</p>
				{/foreach}
				<br />
				{if !empty($item.productprices)}
				{foreach from=$item.productprices item=productprice}
				<p class="sectionitem">{$productprice.productprice_name} - R {$productprice.productprice_price|number_format:2:",":"."}</p>				
				{/foreach}	
				{else}
					<p class="sectionitem">No prices set yet</p>
				{/if}				
				<br />
				<div class="button">
					<span><span><a href="javascript:;" class="fancybox_{$item.product_code}_click">view gallery</a></span></span>
				</div>
			</div>
			{if $smarty.foreach.gallery.iteration is div by 3}<div class="line-hor"></div>{/if}
			{/foreach}
		</div>
	</div>
	{include_php file="$smartypath/includes/sidebar.php"}	
	{include_php file="$smartypath/includes/footer.php"}	
</div>
</body>
</html>