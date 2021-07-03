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
			<li><a href="/campaign/" title="">Campaign</a></li>
			<li>{$campaignData.campaign_name}</li>
			<li>Components</li>
        </ul>
	</div><!--breadcrumb--> 
	<div class="inner">
		<div class="clearer"><!-- --></div>
		<br /><h2>Manage Price</h2><br />
		<div id="sidetabs">
		<ul> 
            <li><a href="/campaign/details.php?code={$campaignData.campaign_code}" title="Details">Details</a></li>
			<li class="active"><a href="#" title="Component">Component</a></li>
		</ul>
		</div><!--tabs-->	
		  <div class="detail_box">  
		  <form name="campaignpackageForm" id="campaignpackageForm" action="/campaign/package.php?code={$campaignData.campaign_code}" method="post">
			  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="innertable"> 
			  <thead>
			  <tr>
				<th valign="top">Package</th>
				<th valign="top">Description</th>
				<th valign="top"></th>	
			  </tr>
			  </thead>
			  <tbody>
			  {foreach from=$campaignpackageData item=item}
			  <tr>	
				<td valign="top">{$item._package_name}</td>
				<td valign="top">{$item._package_description}</td>	
				<td valign="top">{if $item._campaignpackage_active eq 1}<span class="success">Active Package</span>{else}<span class="error">Inactive Package</span>{/if}</td>	
			  </tr>
			  {/foreach}			
			  <tr>
				<td valign="top" colspan="2">
					<select id="_package_code" name="_package_code">
						<option value=""> -------- </option>
						{html_options options=$packagePairs}
					</select>
					{if isset($errorArray._package_code)}<br /><em class="error">{$errorArray._package_code}</em>{/if}
				</td>	
				<td valign="top">
					<button type="submit" onclick="submitForm();">Add</button>	
				</td>			
			  </tr>
			  </tbody>
			</table>
			{if isset($errorArray.error)}<span class="error">{$errorArray.error}</span>{/if}
			</form>
		</div>		
	<div class="clearer"><!-- --></div>
    </div><!--inner-->
 </div> 	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 {include_php file='includes/footer.php'}
</div>
{literal}
<script type="text/javascript">
function submitForm() {
	document.forms.imageForm.submit();					 
}		
</script>
{/literal}	
<!-- End Main Container -->
</body>
</html>
