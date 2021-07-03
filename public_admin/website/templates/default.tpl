<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nolali - The Creative</title>
{include_php file='includes/css.php'}
{include_php file='includes/javascript.php'}
<script type="text/javascript" language="javascript" src="default.js"></script>
</head>

<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content Section -->
  <div id="content">
    {include_php file='includes/header.php'}
	<div id="breadcrumb">
        <ul>
            <li><a href="/" title="Home">Home</a></li>
			<li><a href="/website/" title="Website">Website</a></li>
			<li><a href="#" title="Website"><span class="success">{$domainData.campaign_name}</span></a></li>
			<li><a href="/website/templates/" title="">Templates</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage  <span class="success">{$domainData.campaign_name}</span> Templates</h2>		
	<a href="/website/templates/details.php" title="Click to Add a new templates" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new templates</span></a> <br />
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
					<th>Name</th>
					<th>Type</th>
					<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$templateData item=item}
						<tr>	
							<td align="left">{$item.template_name}</td>
							<td align="left">
								<a href="/website/templates/details.php?code={$item.template_code}">
									{$item.template_type}
								</a>
							</td>
							<td align="left"><button onclick="deleteitem('{$item.gallery_code}'); return false;">delete</button></td>
						</tr>
					{/foreach}     
			  </tbody>
			</table>
		 </div>
		 <!-- End Content Table -->	
	</div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
  </div><!-- End Content Section -->
 {include_php file='includes/footer.php'}
</div>
<!-- End Main Container -->
{literal}
<script type="text/javascript" language="javascript">
function deleteitem(code) {					
	if(confirm('Are you sure you want to delete this item?')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
				data: "delete_code="+code,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert('Item deleted!');
							window.location.href = window.location.href;
						} else {
							alert(data.error);
						}
				}
		});							
	}
	return false;
}
</script>
{/literal}
</body>
</html>
