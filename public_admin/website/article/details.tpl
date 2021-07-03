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
			<li><a href="/website/article/" title="">Article</a></li>
			<li><a href="#" title="">{if isset($articleData)}{$articleData.article_name}{else}Add a Article{/if}</a></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($articleData)}Edit Article{else}Add a Article{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/article/details.php{if isset($articleData)}?code={$articleData.article_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="article_name" id="article_name" value="{$articleData.article_name}" size="60" />
				{if isset($errorArray.article_name)}<br /><span class="error">{$errorArray.article_name}</span>{else}<br /><em>As will be seen on the website</em>{/if}
			</td>					
          </tr>
          <tr>
			<td>
				<h4 class="error">Description:</h4><br />
				<textarea name="article_description" id="article_description" rows="3" cols="100">{$articleData.article_description}</textarea><br />
				{if isset($errorArray.article_description)}<span class="error">{$errorArray.article_description}</span>{else}<em>Short article description / introduction</em>{/if}
			</td>					
          </tr>	
          <tr>
			<td>
				<h4 class="error">Page:</h4><br />
				<textarea id="article_page" name="article_page" cols="100" rows="50">{$articleData.article_page}</textarea>
				{if isset($errorArray.article_page)}<br /><span class="error">{$errorArray.article_page}</span>{/if}
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
$(document).ready(function() {			
	new nicEditor({
		iconsPath	: '/library/javascript/nicedit/nicEditorIcons.gif',
		buttonList 	: ['bold','italic','underline','left','center', 'ol', 'ul', 'xhtml', 'fontFormat', 'fontFamily', 'fontSize', 'unlink', 'link', 'strikethrough', 'superscript', 'subscript', 'upload'],
		uploadURI : '/library/javascript/nicedit/nicUpload.php',
	}).panelInstance('article_page');				
});

function submitForm() {
	nicEditors.findEditor('article_page').saveContent();
	document.forms.detailsForm.submit();					 
}

</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
