<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datuma Guest House - Galleries</title>
	<meta name="keywords" content="our galleries, guest house pictures, images, rooms, guest house, south africa, thornton cape town, western cape, accomodation">
	<meta name="description" content="{$campaign.campaign_name} has a lot of memories to share with our previous guest, please see below as to what they had experience as well as our guest house.">          
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="{$campaign.campaign_name}"> 
	<meta property="og:image" content="http://{$campaign.campaign_domain}/images/logo.png"> 
	<meta property="og:url" content="http://{$campaign.campaign_domain}">
	<meta property="og:site_name" content="{$campaign.campaign_name}">
	<meta property="og:type" content="website">
	<meta property="og:description" content="{$campaign.campaign_name} has a lot of memories to share with our previous guest, please see below as to what they had experience as well as our guest house.">
	{include_php file="$smartypath/includes/css.php"}
	{include_php file="$smartypath/includes/javascript.php"}
	{literal}
	<script type="text/javascript">
		$(document).ready(function() {
			
			{/literal}{foreach from=$galleryData item=item name=gallery}{literal}
			
			$(".fancybox_{/literal}{$item.gallery_code}{literal}_click").click(function() {
				$.fancybox.open([
					{/literal}{foreach from=$item.images item=image name=fancyimage}{literal}
					{ href : {/literal}'http://{$image.campaign_domain}{$image.galleryimage_path}/big_{$image.galleryimage_code}{$image.galleryimage_extension}', title : '{$image.galleryimage_description}' {literal}}{/literal}{if $smarty.foreach.fancyimage.last}{else},{/if}{literal}
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
		<p>Below is a list of all our galleries, here you will find the people who have enjoyed a stay at our beautiful guest house. Please enjoy</p>
		<div class="line-hor"></div>
		<div id="gallery">
			{foreach from=$galleryData item=item name=gallery}
			<div class="galleryitem">
				<a href="javascript:;" class="fancybox_{$item.gallery_code}_click"> 
					<img class="extra-img png" src="{$item.galleryimage_path}/tny_{$item.galleryimage_code}{$item.galleryimage_extension}" title="{$item.campaign_name} - {$item.gallery_name}" alt="{$item.campaign_name} - {$item.gallery_name}" />
				</a>
				<br />
				<b class="gallerytitle">{$item.gallery_name}</b><br />
				<p>{$item.gallery_description}</p>
				<br />
				<div class="button">
					<span><span><a href="javascript:;" class="fancybox_{$item.gallery_code}_click">view gallery</a></span></span>
				</div>
			</div>
			{if $smarty.foreach.gallery.iteration is div by 3}<div class="line-hor"></div>{/if}
			{foreachelse}
			<p>There are unfortunately not image galleries at the moment.</p>
			{/foreach}
		</div>
	</div>
	{include_php file="$smartypath/includes/sidebar.php"}	
	{include_php file="$smartypath/includes/footer.php"}	
</div>
</body>
</html>