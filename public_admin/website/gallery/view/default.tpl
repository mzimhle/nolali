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
			<li><a href="/website/gallery/" title="">Gallery</a></li>
			<li><a href="/website/gallery/view/" title="">View</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage  <span class="success">{$domainData.campaign_name}</span> Gallery</h2>		
	<a href="/website/gallery/view/details.php" title="Click to Add a new gallery" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new gallery</span></a> <br />
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
					<th></th>
					<th>Campaign</th>
					<th>Type</th>
					<th>Gallery Name</th>
					<th></th>
					<th></th>
					</tr>
				</thead>
			   <tbody>
			  {foreach from=$galleryData item=item}
			  <tr>
				<td valign="top">
						{if $item.galleryimage_path neq ''} 
						<img src="http://{$item.campaign_domain}/{$item.galleryimage_path}/tny_{$item.galleryimage_code}{$item.galleryimage_extension}" width="80" />
						{else}
						<img src="/images/no-image.jpg" width="80" />
						{/if}
				</td>	
				<td align="left">{$item.gallerytype_name}</td>
				<td align="left">{$item.campaign_company}</td>
				<td align="left">
						<a href="/website/gallery/view/details.php?code={$item.gallery_code}" class="{if $item.gallery_active eq '1'}success{else}error{/if}">
							{$item.gallery_name}
						</a>
				</td>		
				<td align="left"><button onclick="changeStatus('{$item.gallery_code}', '{if $item.gallery_active eq '1'}0{else}1{/if}'); return false;">{if $item.gallery_active eq '1'}deactivate{else}activate{/if}</button></td>	
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

function changeStatus(code, status) {					
	if(confirm('Are you sure you want to change this item status?')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
				data: "status_code="+code+"&status="+status,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert('Item status changed!');
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
