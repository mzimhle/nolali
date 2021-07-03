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
			<li><a href="/website/gallery/view/" title="">View</a></li>
			<li>{$galleryData.gallery_name}</li>
			<li>Image</li>
        </ul>
	</div><!--breadcrumb-->
	<div class="inner">
		<div class="clearer"><!-- --></div>
		<br /><h2>Manage <span class="success">{$domainData.campaign_name}</span> Gallery Images</h2><br />
		<div id="sidetabs">
		<ul> 
            <li><a href="/website/gallery/view/details.php?code={$galleryData.gallery_code}" title="Details">Details</a></li>
			<li class="active"><a href="#" title="Images">Images</a></li>
		</ul>
		</div><!--tabs-->	
		  <div class="detail_box">  
		  <form name="imageForm" id="imageForm" action="/website/gallery/view/image.php?code={$galleryData.gallery_code}" method="post"  enctype="multipart/form-data">
			  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="innertable"> 
			  <thead>
			  <tr>				
				<th valign="top" colspan="2" {if isset($errorArray.category_code)}class="error"{/if}>Updaload</th>
				<th valign="top">Delete Image</th>
				<th valign="top">Make Primary</th>
			  </tr>
			  </thead>
			  {foreach from=$galleryimageData item=item}
			  <tr>	
				<td valign="top"{if $item.galleryimage_primary eq '1'}class="success"{/if}>{$item.galleryimage_description}</td>	
				<td valign="top">
					<a href="http://{$domainData.campaign_domain}/{$item.galleryimage_path}/big_{$item.galleryimage_code}{$item.galleryimage_extension}" target="_blank">
						<img src="http://{$item.campaign_domain}/{$item.galleryimage_path}/tny_{$item.galleryimage_code}{$item.galleryimage_extension}" />
					</a>
				</td>			
				<td valign="top">{if $item.galleryimage_primary eq '0'}<button type="button" onclick="deleteitem('{$item.galleryimage_code}'); return false;">Delete</button>{else}<b>Primary</b>{/if}</td>	
				<td valign="top">{if $item.galleryimage_primary eq '0'}<button type="button" onclick="makeprimary('{$item.galleryimage_code}'); return false;">Primary</button>{else}<b>Primary</b>{/if}</td>	
			  </tr>
			  {/foreach}			
			  <tr>
				<td valign="top" colspan="3">
					<input type="file" name="imagefiles[]" id="imagefiles[]" multiple />
					{if isset($errorArray.imagefiles)}<br /><em class="error">{$errorArray.imagefiles}</em>{/if}
				</td>		
				<td valign="top">
					<button type="submit" onclick="submitForm();">Upload Image</button>	
				</td>			
			  </tr>
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

function makeprimary(code) {
	if(confirm('Are you sure you want to make this item primary?')) {
		$.ajax({
				type: "GET",
				url: "image.php?code={/literal}{$galleryData.gallery_code}{literal}",
				data: "primarycode="+code,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert('Changed');
							window.location.href = '/website/gallery/view/image.php?code={/literal}{$galleryData.gallery_code}{literal}';
						} else {
							alert(data.message);
						}
				}
		});		
	}
	return false;			
}

function deleteitem(code) {
	if(confirm('Are you sure you want to delete this item?')) {
		$.ajax({
				type: "GET",
				url: "image.php?code={/literal}{$galleryData.gallery_code}{literal}",
				data: "deletecode="+code,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert('Deleted');
							window.location.href = '/website/gallery/view/image.php?code={/literal}{$galleryData.gallery_code}{literal}';
						} else {
							alert(data.message);
						}
				}
		});		
	}
	return false;			
}
				
</script>
{/literal}	
<!-- End Main Container -->
</body>
</html>
