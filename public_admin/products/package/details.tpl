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
			<li><a href="/products/" title="">Products</a></li>
			<li><a href="/products/package/" title="">Package</a></li>
			<li>{if isset($packageData)}Edit a package{else}Add a package{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($packageData)}{$packageData._package_name}{else}Add a new package{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="{if isset($packageData)}/products/package/price.php?code={$packageData._package_code}{else}#{/if}" title="Price">Price</a></li>
			<li><a href="{if isset($packageData)}/products/package/component.php?code={$packageData._package_code}{else}#{/if}" title="Component">Component</a></li>
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/products/package/details.php{if isset($packageData)}?code={$packageData._package_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
			<tr>
				<td class="heading">Details</td>
			</tr>
          <tr>
            <td class="left_col error"><h4>Name:</h4><br />
				<input type="text" name="_package_name" id="_package_name" value="{$packageData._package_name}" size="30"/>
				{if isset($errorArray._package_name)}<br /><span class="error">{$errorArray._package_name}</span>{/if}
			</td>	
          </tr> 		  
          <tr>
            <td class="left_col error">
				<h4>Description:</h4><br />
				<textarea type="text" name="_package_description" id="_package_description" rows="5" cols="100">{$packageData._package_description}</textarea>
				{if isset($errorArray._package_description)}<br /><span class="error">{$errorArray._package_description}</span>{/if}
			</td>	
          </tr>	  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="/products/package/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
          <a href="javascript:submitForm();" class="blue_button mrg_left_20 fl"><span>Save &amp; Complete</span></a>   
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
function submitForm() {
	document.forms.detailsForm.submit();					 
}
</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
