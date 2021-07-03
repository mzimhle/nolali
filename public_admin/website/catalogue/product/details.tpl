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
			<li><a href="/website/catalogue/product/" title="">Products</a></li>
			<li>{if isset($productData)}Edit product{else}Add a product{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($productData)}Edit product{else}Add a product{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="{if isset($productData)}/website/catalogue/product/image.php?code={$productData.product_code}{else}#{/if}" title="Images">Images</a></li>
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/catalogue/product/details.php{if isset($productData)}?code={$productData.product_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
           <tr>
            <td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="product_name" id="product_name" value="{$productData.product_name}" size="80"/>
				{if isset($errorArray.product_name)}<br /><em class="error">{$errorArray.product_name}</em>{/if}
			</td>	
          </tr>							  
          <tr>
            <td>
				<h4 class="error">Description:</h4><br />
				<textarea name="product_description" id="product_description" rows="3" cols="80">{$productData.product_description}</textarea>
				{if isset($errorArray.product_description)}<br /><em class="error">{$errorArray.product_description}</em>{/if}
			</td>	
          </tr>	
          <tr>
            <td>
				<h4 class="error">Page:</h4><br />
				<textarea name="product_page" id="product_page" rows="30" cols="120">{$productData.product_page}</textarea>
				{if isset($errorArray.product_page)}<br /><em class="error">{$errorArray.product_page}</em>{/if}
			</td>	
          </tr>		  
        </table>
		<input type="hidden" id="action" name="action" value="details" />
      </form>
        <div class="mrg_top_10">
          <a href="/website/catalogue/product/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
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
	}).panelInstance('product_page');	
});

function submitForm() {
	nicEditors.findEditor('product_page').saveContent();
	document.forms.detailsForm.submit();					 
}
</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
