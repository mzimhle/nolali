<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>{$domainData.campaign_company} | Admin | {if isset($campaignproductitemData)}Edit an item{else}Add an item{/if}</title>
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/products/">Products</a> &raquo;
				<a href="/admin/products/details.php?code={$campaignproductData.campaignproduct_code}">{$campaignproductData.campaignproduct_name}</a> &raquo;
				<a href="/admin/products/items/?code={$campaignproductData.campaignproduct_code}">Items</a> &raquo;
				<a href="#">{if isset($campaignproductitemData)}Edit an item{else}Add an item{/if}</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
				<form id="detailsForm" name="detailsForm" action="/admin/products/items/details.php?code={$campaignproductData.campaignproduct_code}{if isset($campaignproductitemData)}&item={$campaignproductitemData.campaignproductitem_code}{/if}" method="post">
				<div class="col">
					<div class="article">
						<h4><a href="#">Active?</a></h4>
						<p class="short">
							<input type="checkbox" name="campaignproductitem_active" id="campaignproductitem_active" value="1" {if $campaignproductitemData.campaignproductitem_active eq 1} checked="checked"{/if} />
						</p>
					</div>				
					<div class="article">
						<h4><a href="#" {if isset($errorArray.campaignproductitem_name)}class="error"{/if}>Item Name</a></h4>
						<p class="short">
							<input type="text" name="campaignproductitem_name" id="campaignproductitem_name" value="{$campaignproductitemData.campaignproductitem_name}" size="42"/>
						</p>
					</div>	
					<div class="article">
						<h4><a href="#" {if isset($errorArray.campaignproductitem_price)}class="error"{/if}>Item Price (R)</a></h4>
						<p class="short">
							<input type="text" name="campaignproductitem_price" id="campaignproductitem_price" value="{$campaignproductitemData.campaignproductitem_price}" size="10"/>
						</p>
					</div>													
					<div class="article">
						<p class="short">
							<a class="link" href="javascript:submitForm();">Save Details</a>
						</p>
					</div>						
				</div>				
				<div class="col">
					<div class="article">
						<h4><a href="#" {if isset($errorArray.campaignproductitem_description)}class="error"{/if}>Description</a></h4>
						<p class="short">
							<textarea id="campaignproductitem_description" name="campaignproductitem_description" cols="34" rows="5">{$campaignproductitemData.campaignproductitem_description}</textarea>
						</p>
					</div>				
				</div>
				</form>
				<div class="col">
					<div class="article">
						<h4><a href="{if isset($campaignproductitemData)}/admin/products/items/images.php?code={$campaignproductData.campaignproduct_code}&item={$campaignproductitemData.campaignproductitem_code}{else}#{/if}">Item Gallery</a></h4>
						<p class="short line">
							Add images for this item, for galleries and displayes if there is a website. {if !isset($campaignproductitemData)}<br /><br /><span class="error">You can only add the images after an item has been added.</span>{/if}
						</p>
					</div>										
				</div>					
				<div class="clr"></div>
			</div>
			{include_php file='includes/footer.php'}
		</div>
		{literal}
		<script type="text/javascript">
		function submitForm() {
			document.forms.detailsForm.submit();					 
		}
		
		</script>
		{/literal}			
	</body>
</html>