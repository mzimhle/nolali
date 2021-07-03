<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>Products | {$domainData.campaign_company}</title>
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
				<a href="#">{if isset($productData)}Edit product{else}Add a product{/if}</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
				<form id="detailsForm" name="detailsForm" action="/admin/products/details.php{if isset($productData)}?code={$productData.product_code}{/if}" method="post">
				<div class="col">
					<div class="article">
						<h4><a href="#">Active?</a></h4>
						<p class="short">
							<input type="checkbox" name="product_active" id="product_active" value="1" {if $productData.product_active eq 1} checked="checked"{/if} />
						</p>
					</div>				
					<div class="article">
						<h4><a href="#" {if isset($errorArray.product_name)}class="error"{/if}>Product Name</a></h4>
						<p class="short">
							<input type="text" name="product_name" id="product_name" value="{$productData.product_name}" size="42"/>
						</p>
					</div>	
					<br /><br />						
					<div class="article">
						<h4><a href="#" {if isset($errorArray.product_page)}class="error"{/if}>Full Description</a></h4>					
						<p class="short">
							<textarea id="product_page" name="product_page" rows="15" cols="69">{$productData.product_page}</textarea>		
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
						<h4><a href="#" {if isset($errorArray.product_description)}class="error"{/if}>Short Description / Invoice Description</a></h4>
						<p class="short">
							<textarea id="product_description" name="product_description" cols="34" rows="5">{$productData.product_description}</textarea>
						</p>
					</div>				
				</div>
				</form>
				<div class="col">
					<div class="article">
						<h4><a href="{if isset($productData)}/admin/products/images.php?code={$productData.product_code}{else}#{/if}">Product Gallery</a></h4>
						<p class="short line">
							Add images for this product, for galleries and displayes if there is a website. {if !isset($productData)}<br /><br /><span class="error">You can only add the images after a product has been added.</span>{/if}
						</p>
					</div>					
					<div class="article">
						<h4><a href="{if isset($productData)}/admin/products/items.php?code={$productData.product_code}{else}#{/if}">Product Features</a></h4>
						<p class="short line">
							Add items that fall under this product.
						</p>
					</div>
					<div class="article">
						<h4><a href="{if isset($productData)}/admin/products/prices.php?code={$productData.product_code}{else}#{/if}">Product Price(s)</a></h4>
						<p class="short line">
							Add prices of the product depending on quantity.
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
			nicEditors.findEditor('product_page').saveContent();
			document.forms.detailsForm.submit();					 
		}
		
		$(document).ready(function() {
			
			new nicEditor({
				iconsPath	: '/admin/library/javascript/nicedit/nicEditorIcons.gif',
				buttonList 	: ['bold','italic','underline','left','center', 'ol', 'ul', 'xhtml', 'fontFormat', 'fontFamily', 'fontSize', 'unlink', 'link', 'strikethrough', 'superscript', 'subscript'],
				maxHeight 	: '800'
			}).panelInstance('product_page');
				
		});
		
		</script>
		{/literal}			
	</body>
</html>