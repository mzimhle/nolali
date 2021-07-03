<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>{$domainData.campaign_company} | Admin | Gallery</title>
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/galleries/">Gallery</a> &raquo; 
				<a href="#">{if isset($galleryData)}Edit gallery{else}Add a gallery{/if}</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
				<form id="detailsForm" name="detailsForm" action="/admin/galleries/details.php{if isset($galleryData)}?code={$galleryData.gallery_code}{/if}" method="post">
				<div class="col">
					<div class="article">
						<h4><a href="#">Status Active ?</a></h4>
						<p class="short">
							<input type="checkbox" name="gallery_active" id="gallery_active" value="1" {if $galleryData.gallery_active eq 1} checked="checked"{/if} />
						</p>
					</div>				
					<div class="article">
						<h4><a href="#" {if isset($errorArray.gallery_name)}class="error"{/if}>Name</a></h4>
						<p class="short">
							<input type="text" name="gallery_name" id="gallery_name" value="{$galleryData.gallery_name}" size="42"/>
						</p>
					</div>						
					<div class="article">
						<h4><a href="#" {if isset($errorArray.gallery_description)}class="error"{/if}>Description</a></h4>					
						<p class="short">
							<textarea id="gallery_description" name="gallery_description" rows="5" cols="70">{$galleryData.gallery_description}</textarea>		
						</p>						
					</div>					
					<div class="article">
						<p class="short">
							<a class="link" href="javascript:submitForm();">Save Details</a>
						</p>
					</div>					
				</div>				
				</form>
				<div class="col"></div>				
				<div class="col">
					<div class="article">
						<h4><a href="{if isset($galleryData)}/admin/galleries/images.php?code={$galleryData.gallery_code}{else}#{/if}">Gallery Images</a></h4>
						<p class="short line">
							List of all the images for this gallery. {if !isset($galleryData)}<br /><br /><span class="error">You can only add the images after a gallery has been created.</span>{/if}
						</p>
					</div>					
				</div>					
				<div class="clr"></div>
				<h3>Current Image Galleries</h3>
				{if isset($galleryData)}
				<div id="tableContent" align="center">				
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="detailsForm" id="detailsForm" action="/admin/galleries/images.php?code={$galleryData.gallery_code}" method="post">
							<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<th>Added</th>
								<th>Filename</th>
								<th>Image</th>
								<th>Description</th>
							   </tr>
							  {foreach from=$galleryimageData item=item}
							  <tr>							  
								<td align="left" class="alt">
									{$item.galleryimage_added|date_format}
								</td>													
								<td align="left" class="alt">
									{$item.galleryimage_name}
								</td>
								<td align="left" class="alt">
									<img src="http://{$domainData.campaign_domain}{$item.galleryimage_path}/{$images.tiny.code}{$item.galleryimage_code}{$item.galleryimage_extension}" width="100" />
								</td>								
								<td align="left" class="alt">
									{$item.galleryimage_description}
								</td>							
							  </tr>
							  {foreachelse}
								<tr>
									<td colspan="8">There are no current items in the system.</td>
								</tr>
							  {/foreach}  						  						  							  
							</table>
						</form>
					</div>
					</div>
					{else}
					<span class="error">No gallery created yet.</span><br /><br />
					{/if}
					<div class="clr"></div>
			</div>
			{include_php file='includes/footer.php'}
		</div>
		{literal}
		<script type="text/javascript">
		function submitForm() {
			nicEditors.findEditor('gallery_description').saveContent();
			document.forms.detailsForm.submit();					 
		}
		
		$(document).ready(function() {
			
			new nicEditor({
				iconsPath	: '/admin/library/javascript/nicedit/nicEditorIcons.gif',
				buttonList 	: ['bold','italic','underline','left','center', 'ol', 'ul', 'xhtml', 'fontFormat', 'fontFamily', 'fontSize', 'unlink', 'link', 'strikethrough', 'superscript', 'subscript'],
				maxHeight 	: '800'
			}).panelInstance('gallery_description');
				
		});
		
		</script>
		{/literal}			
	</body>
</html>