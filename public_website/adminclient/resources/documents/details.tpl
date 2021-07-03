<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>{$domainData.campaign_company} | Admin | Document</title>
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/resources/">Resources</a> &raquo; 
				<a href="/admin/resources/documents/">Documents Groups</a>&raquo; 
				<a href="#">{if isset($campaigndocumentData)}Edit document group{else}Add a document group{/if}</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
				<form id="detailsForm" name="detailsForm" action="/admin/resources/documents/details.php{if isset($campaigndocumentData)}?code={$campaigndocumentData.campaigndocument_code}{/if}" method="post">
				<div class="col">				
					<div class="article">
						<h4><a href="#" {if isset($errorArray.campaigndocument_name)}class="error"{/if}>Name</a></h4>
						<p class="short">
							<input type="text" name="campaigndocument_name" id="campaigndocument_name" value="{$campaigndocumentData.campaigndocument_name}" size="42"/>
						</p>
					</div>						
					<div class="article">
						<h4><a href="#" {if isset($errorArray.campaigndocument_description)}class="error"{/if}>Description</a></h4>					
						<p class="short">
							<textarea id="campaigndocument_description" name="campaigndocument_description" rows="15" cols="69">{$campaigndocumentData.campaigndocument_description}</textarea>		
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
						<h4><a href="{if isset($campaigndocumentData)}/admin/resources/documents/item.php?code={$campaigndocumentData.campaigndocument_code}{else}#{/if}">Documents</a></h4>
						<p class="short line">
							List of all the documents in this document group. {if !isset($campaigndocumentData)}<br /><br /><span class="error">You can only add the documents after a group has been created.</span>{/if}
						</p>
					</div>					
				</div>					
				<div class="clr"></div>
			</div>
			{include_php file='includes/footer.php'}
		</div>
		{literal}
		<script type="text/javascript">
		function submitForm() {
			nicEditors.findEditor('campaigndocument_description').saveContent();
			document.forms.detailsForm.submit();					 
		}
		
		$(document).ready(function() {
			
			new nicEditor({
				iconsPath	: '/admin/library/javascript/nicedit/nicEditorIcons.gif',
				buttonList 	: ['bold','italic','underline','left','center', 'ol', 'ul', 'xhtml', 'fontFormat', 'fontFamily', 'fontSize', 'unlink', 'link', 'strikethrough', 'superscript', 'subscript'],
				maxHeight 	: '800'
			}).panelInstance('campaigndocument_description');
				
		});
		
		</script>
		{/literal}			
	</body>
</html>