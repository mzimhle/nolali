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
			<li><a href="/website/people/" title="">People</a></li>
			<li><a href="/website/people/type/" title="">Type</a></li>
			<li><a href="#" title="">{if isset($participantcategoryData)}{$participantcategoryData.participantcategory_name}{else}Add a Type{/if}</a></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($participantcategoryData)}Edit Type{else}Add a Type{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/people/type/details.php{if isset($participantcategoryData)}?code={$participantcategoryData.participantcategory_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
		{if !isset($participantcategoryData)}
          <tr>
			<td>
				<h4 class="error">Code:</h4><br />
				<input type="text" name="participantcategory_code" id="participantcategory_code" value="{$participantcategoryData.participantcategory_code}" size="60" />
				{if isset($errorArray.participantcategory_code)}<br /><span class="error">{$errorArray.participantcategory_code}</span>{else}<br /><em>Less than or equal to 4 characters</em>{/if}
			</td>					
          </tr>	 		
		  {else}
          <tr>
			<td>
				<h4 class="error">Code:</h4><br />
				<span class="success">{$participantcategoryData.participantcategory_code}</span>
			</td>					
          </tr>	 		  
		  {/if}
          <tr>
			<td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="participantcategory_name" id="participantcategory_name" value="{$participantcategoryData.participantcategory_name}" size="60" />
				{if isset($errorArray.participantcategory_name)}<br /><span class="error">{$errorArray.participantcategory_name}</span>{else}<br /><em>Name of the website gallery type</em>{/if}
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
