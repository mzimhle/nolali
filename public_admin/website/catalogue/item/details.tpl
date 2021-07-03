<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nolali - The Creative</title>
{include_php file='includes/css.php'}
{include_php file='includes/javascript.php'}
</head>
<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content recruiter -->
  <div id="content">
    {include_php file='includes/header.php'}
  	<br />
	<div id="breadcrumb">
        <ul>
            <li><a href="/" title="Home">Home</a></li>
			<li><a href="/website/" title="Website">Website</a></li>
			<li><a href="#" title="Website"><span class="success">{$domainData.campaign_name}</span></a></li>
			<li><a href="/website/catalogue/" title="">Catalogue</a></li>
			<li><a href="/website/catalogue/item/" title="">Items</a></li>
			<li>{if isset($productitemData)}Edit item{else}Add an item{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($productitemData)}Edit item{else}Add a item{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="{if isset($productitemData)}/website/catalogue/item/price.php?code={$productitemData.productitem_code}{else}#{/if}" title="Price">Price</a></li>
			<li><a href="{if isset($productitemData)}/website/catalogue/item/image.php?code={$productitemData.productitem_code}{else}#{/if}" title="Images">Images</a></li>
			<li><a href="{if isset($productitemData)}/website/catalogue/item/extra.php?code={$productitemData.productitem_code}{else}#{/if}" title="Extras">Extras</a></li>			
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/catalogue/item/details.php{if isset($productitemData)}?code={$productitemData.productitem_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
           <tr>
            <td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="productitem_name" id="productitem_name" value="{$productitemData.productitem_name}" size="80"/>
				{if isset($errorArray.productitem_name)}<br /><em class="error">{$errorArray.productitem_name}</em>{/if}
			</td>	
          </tr>	
           <tr>
            <td>
				<h4 class="error">Product:</h4><br />
				<select id="product_code" name="product_code">
					<option value=""> ---------------------- </option>
					{html_options options=$productpairs selected=$productitemData.product_code}
				</select>
				{if isset($errorArray.productitem_name)}<br /><em class="error">{$errorArray.productitem_name}</em>{/if}
			</td>	
          </tr>			  
          <tr>
            <td>
				<h4 class="error">Description:</h4><br />
				<textarea name="productitem_description" id="productitem_description" rows="3" cols="80">{$productitemData.productitem_description}</textarea>
				{if isset($errorArray.productitem_description)}<br /><em class="error">{$errorArray.productitem_description}</em>{/if}
			</td>	
          </tr>	
          <tr>
            <td>
				<h4>Page:</h4><br />
				<textarea name="productitem_page" id="productitem_page" rows="30" cols="120">{$productitemData.productitem_page}</textarea>
				{if isset($errorArray.productitem_page)}<br /><em class="error">{$errorArray.productitem_page}</em>{/if}
			</td>	
          </tr>		  
        </table>
		<input type="hidden" id="action" name="action" value="details" />
      </form>
        <div class="mrg_top_10">
          <a href="/website/catalogue/item/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
          <a href="javascript:submitForm();" class="blue_button mrg_left_20 fl"><span>Save &amp; Complete</span></a>   
        </div>
	</div>			
	<div class="clearer"><!-- --></div>		
    </div><!--inner-->
 </div> 	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 {include_php file='includes/footer.php'}
</div>
{literal}
<script type="text/javascript" language="javascript">
$(document).ready(function() {		
	new nicEditor({
		iconsPath	: '/library/javascript/nicedit/nicEditorIcons.gif',
		buttonList 	: ['bold','italic','underline','left','center', 'ol', 'ul', 'xhtml', 'fontFormat', 'fontFamily', 'fontSize', 'unlink', 'link', 'strikethrough', 'superscript', 'subscript'],
		maxHeight 	: '800'
	}).panelInstance('productitem_page');	
});

function submitForm() {
	nicEditors.findEditor('productitem_page').saveContent();
	document.forms.detailsForm.submit();					 
}
</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
