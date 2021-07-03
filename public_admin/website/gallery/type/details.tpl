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
			<li><a href="/website/gallery/" title="">Gallery</a></li>
			<li><a href="/website/gallery/type/" title="">Type</a></li>
			<li><a href="#" title="">{if isset($gallerytypeData)}{$gallerytypeData.gallerytype_name}{else}Add a Type{/if}</a></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($gallerytypeData)}Edit Type{else}Add a Type{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/gallery/type/details.php{if isset($gallerytypeData)}?code={$gallerytypeData.gallerytype_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="gallerytype_name" id="gallerytype_name" value="{$gallerytypeData.gallerytype_name}" size="60" />
				{if isset($errorArray.gallerytype_name)}<br /><span class="error">{$errorArray.gallerytype_name}</span>{else}<br /><em>Name of the website gallery type</em>{/if}
			</td>					
          </tr>	  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
	<div class="mrg_top_10">
	  <a class="blue_button mrg_left_147 fl" href="javascript:submitForm();"><span>Save &amp; Complete</span></a>   
	</div>
    <div class="clearer"><!-- --></div>
	<br /><br />	
    </div><!--inner-->
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
