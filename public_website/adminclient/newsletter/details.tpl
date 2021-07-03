<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>Newsletter | {$domainData.campaign_company}</title>
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/newsletter/">Newsletter</a> &raquo; 
				<a href="#">{if isset($newsletterData)}Edit newsletter{else}Add a newsletter{/if}</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
				<form id="detailsForm" name="detailsForm" action="/admin/newsletter/details.php{if isset($newsletterData)}?code={$newsletterData.newsletter_code}{/if}" method="post">
				<div class="col">
					<div class="article">
						<h4><a href="#">Status</a></h4>
						<p class="short">
							<input type="checkbox" name="newsletter_active" id="newsletter_active" value="1" {if $newsletterData.newsletter_active eq 1} checked="checked"{/if} />
						</p>
					</div>				
					<div class="article">
						<h4><a href="#" class="error">Name / Title</a></h4>
						<p class="short">
							<input type="text" name="newsletter_name" id="newsletter_name" value="{$newsletterData.newsletter_name}" size="70"/>
							{if isset($errorArray.newsletter_name)}<br /><em class="error">{$errorArray.newsletter_name}</em>{else}<em>As seen on the website</em>{/if}
						</p>
					</div>
					<div class="article">
						<h4><a href="#" class="error">Subject</a></h4>
						<p class="short">
							<input type="text" name="newsletter_subject" id="newsletter_subject" value="{$newsletterData.newsletter_subject}" size="70"/>
							{if isset($errorArray.newsletter_subject)}<br /><em class="error">{$errorArray.newsletter_subject}</em>{else}<em>As seen on the email subject</em>{/if}
						</p>
					</div>					
					<div class="article">
						<h4><a href="#" class="error">Description</a></h4>					
						<p class="short">
							<textarea id="newsletter_content" name="newsletter_content" rows="60" cols="100">{$newsletterData.newsletter_content}</textarea>		
						</p>						
					</div>					
					<div class="article">
						<p class="short">
							<a class="link" href="javascript:submitForm();">Save Details</a>
						</p>
					</div>						
				</div>			
				{if isset($newsletterData)}
				<div class="col">
					<div class="article">
						<h4><a href="/admin/newsletter/mail.php?code={$newsletterData.newsletter_code}">Sent Newsletter out</a></h4>
						<p class="short line">
							Click above to send it out
						</p>
					</div>									
				</div>	
				{/if}				
				</form>		

				<div class="clr"></div>
			</div>
			{include_php file='includes/footer.php'}
		</div>
		{literal}
		<script type="text/javascript">
		function submitForm() {
			nicEditors.findEditor('newsletter_content').saveContent();
			document.forms.detailsForm.submit();					 
		}
		
		function sendNewsletter() {
			document.forms.htmlForm.submit();					 
		}
		
		
		$(document).ready(function() {
			new nicEditor({
				iconsPath	: '/admin/library/javascript/nicedit/nicEditorIcons.gif',
				buttonList 	: ['bold','italic','underline','left','center', 'ol', 'ul', 'xhtml', 'fontFormat', 'fontFamily', 'fontSize', 'unlink', 'link', 'strikethrough', 'superscript', 'subscript', 'upload'],
				maxHeight 	: '1000',
				uploadURI : '/library/javascript/nicedit/nicUpload.php',
			}).panelInstance('newsletter_content');				
		});
		
		</script>
		{/literal}			
	</body>
</html>