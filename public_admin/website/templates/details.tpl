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
			<li><a href="/website/templates/" title="">Templates</a></li>
			<li><a href="#" title="">{if isset($templateData)}{$templateData.template_name}{else}Add a template{/if}</a></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($templateData)}{$templateData.template_name}{else}Details{/if}</h2>
    <div id="sidetabs">
        <ul>  
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/templates/details.php{if isset($templateData)}?code={$templateData.template_code}{/if}" method="post" enctype="multipart/form-data">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="template_name" id="template_name" value="{$templateData.template_name}" size="60" />
				{if isset($errorArray.template_name)}<br /><span class="error">{$errorArray.template_name}</span>{/if}
			</td>		
          </tr>
		  <tr>
			<td>
				<h4 class="error">Template Type:</h4><br />
				<select id="template_type" name="template_type" >
					<option value=""> ----- </option>
					<option value="INVOICE" {if $templateData.template_type eq 'INVOICE'}selected{/if}> INVOICE </option>
					<option value="INQUIRY" {if $templateData.template_type eq 'INQUIRY'}selected{/if}> INQUIRY </option>
					<option value="ESTIMATE" {if $templateData.template_type eq 'ESTIMATE'}selected{/if}> COST ESTIMATE </option>
					<option value="QUOTATION" {if $templateData.template_type eq 'QUOTATION'}selected{/if}> QUOTATION </option>
				</select>
				{if isset($errorArray.template_type)}<br /><span class="error">{$errorArray.template_type}</span>{/if}			
			</td>		  
		  </tr>
          <tr>
			<td>
				<h4>Note:</h4><br />
				To add peoples names on the mailer please add the following variables on the mailer: <br /><br />
					<table>					
						<tr><td>[fullname]</td><td>=</td><td>Member Name and Surname</td></tr>
						<tr><td>[name]</td><td>=</td><td>Member Name</td></tr>
						<tr><td>[surname]</td><td>=</td><td>Member Surname</td></tr>
						<tr><td>[cellphone]</td><td>=</td><td>Member Cellphone</td></tr>
						<tr><td>[address]</td><td>=</td><td>Member Address</td></tr>
						<tr><td>[email]</td><td>=</td><td>Client email</td></tr>
						<tr><td>[message]</td><td>=</td><td>Message to be sent</td></tr>
						<tr><td>[tracking]</td><td>=</td><td>Code for tracking email opened by client</td></tr>
						<tr><td>[date]</td><td>=</td><td>Date sent out to client</td></tr>
						{if isset($templateData)}
							<tr><td>Image paths</td><td>=</td><td>http://{$templateData.campaign_domain}/media/templates/{$templateData.template_code}/images/imagename.jpg</td></tr>
						{/if}
						{if isset($templateData) && $templateData.template_file neq ''}<tr><td>View file</td><td>=</td><td>
							<a href="http://{$templateData.campaign_domain}/media/templates/{$templateData.template_code}/{$templateData.template_code}.html" target="_blank" >
								http://{$templateData.campaign_domain}/media/templates/{$templateData.template_code}/{$templateData.template_code}.html
							</a>
						</td></tr>
					{/if}						
					</table><br />					
				<h4>Upload HTML File:</h4><br />
				<input type="file" name="htmlfile" id="htmlfile" />
				{if isset($errorArray.htmlfile)}<br /><span class="error">{$errorArray.htmlfile}</span>{else}<br /><em>Only .html and .htm allowed</em>{/if}					
			</td>
          </tr>
          <tr> 
			<td>			
				<h4>Upload CSS File:</h4><br />
				<input type="file" name="cssfile" id="cssfile" />
				{if isset($errorArray.cssfile)}<br /><span class="error">{$errorArray.cssfile}</span>{else}<br /><em>Only .css allowed</em>{/if}					
			</td>
          </tr>	 		  
          <tr> 
			<td>			
				<h4>Upload image files:</h4><br />
				<input type="file" name="imagefiles[]" id="imagefiles[]" multiple />
				{if isset($errorArray.imagefiles)}<br /><span class="error">{$errorArray.imagefiles}</span>{else}<br /><em>Only .png, .jpeg, .gif and .jpg allowed</em>{/if}					
			</td>
          </tr>	  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
	<div class="mrg_top_10">
	  <a class="button cancel mrg_left_147 fl" href="/website/templates/"><span>Cancel</span></a>
	  <a class="blue_button mrg_left_20 fl" href="javascript:submitForm();"><span>Save &amp; Complete</span></a>   
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
