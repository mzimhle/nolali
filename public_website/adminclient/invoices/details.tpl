<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>{$domainData.campaign_company} | Admin | Invoices</title>
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum"><a class="first" href="/admin/">Home</a> &raquo; <a href="/admin/invoices/">Invoices</a> &raquo; <a href="#">{if isset($invoiceData)}Edit an invoice{else}Add an invoice{/if}</a></p>
			<p class="linebreak"></p>
			<div id="main">
				<form id="detailsForm" name="detailsForm" action="/admin/invoices/details.php{if isset($invoiceData)}?code={$invoiceData.invoice_code}{/if}" method="post">
				<div class="col">				
					<div class="article">
						<h4><a href="#">Created Date</a></h4>					
						<p class="short">
							{$invoiceData.invoice_added|date_format:"%A, %B %e, %Y"}
						</p>						
					</div>
					<div class="article">
						<h4><a href="#">Client</a></h4>	
						<span class="success">{$invoiceData.participant_name} {$invoiceData.participant_surname}</span>
					</div>							
					<div class="article">
					<br /><br />
						<h4><a href="#">Invoice Notes</a></h4>					
						<p class="short">
							<textarea id="invoice_notes" name="invoice_notes" rows="5" cols="69">{$invoiceData.invoice_notes}</textarea>		
						</p>						
					</div>					
					<div class="article">
						<p class="short">
							<a class="link" href="javascript:submitForm();">Save Details</a>
							<br /><br />
							{if isset($success)}<span class="success">Your details have been updated.</span>{/if}
						</p>
					</div>						
				</div>				
				<div class="col">
					{if $invoiceData.booking_code neq ''}
					<div class="article">
						<h4><a href="#">Booking being invoiced</a></h4>
						<div class="ui-widget">						
							<input type="hidden" name="booking_code" id="booking_code" value="{$invoiceData.booking_code}" />
							<a href="/admin/daily-bookings/details.php?code={$invoiceData.booking_code}">Click to view booking  #{$invoiceData.booking_code} from {$invoiceData.booking_startdate} to {$invoiceData.booking_enddate}</a><br /><br />
						</div>							
					</div>
					{/if}
					{if isset($invoiceData)}
						<div class="article">
							<h4><a href="#">Download latest created invoice</a></h4>
								{if $invoiceData.invoice_html neq ''}
								<a href="{$invoiceData.invoice_pdf}" target="_blank">Download PDF</a>
								{else}
								<span class="error">No pdf has been generated for this invoice.</span>
								{/if}
						</div>	
					{/if}
				</div>	
				</form>
				<div class="col">

					<div class="article">
						<h4><a href="{if isset($invoiceData)}/admin/invoices/items.php?code={$invoiceData.invoice_code}{else}#{/if}">Invoice Edit Item</a></h4>
						<p class="short line">
							Add / updated invoice items.
						</p>
					</div>

					<div class="article">
						<h4><a href="{if isset($invoiceData)}/admin/invoices/payments.php?code={$invoiceData.invoice_code}{else}#{/if}">Invoice Payments</a></h4>
						<p class="short line">
							Add / updated invoice items.
						</p>
					</div>					
					<div class="article">
						<h4><a href="{if isset($invoiceData)}/admin/invoices/documents.php?code={$invoiceData.invoice_code}{else}#{/if}">Invoice Documents</a></h4>
						<p class="short line">
							Add / updated invoice items.
						</p>
					</div>
					<div class="article">
						<h4><a href="{if isset($invoiceData)}/admin/invoices/invoice.php?code={$invoiceData.invoice_code}{else}#{/if}">Create and Send invoice</a></h4>
						<p class="short line">
							Create and send invoice to the client's contacts. You can also download the file as a pdf.
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
			nicEditors.findEditor('invoice_notes').saveContent();
			document.forms.detailsForm.submit();					 
		}
		
		$(document).ready(function() {
			new nicEditor({
				iconsPath	: '/admin/library/javascript/nicedit/nicEditorIcons.gif',
				buttonList 	: ['bold','italic','underline','left','center', 'ol', 'ul', 'xhtml', 'fontFormat', 'fontFamily', 'fontSize', 'unlink', 'link', 'strikethrough', 'superscript', 'subscript'],
				maxHeight 	: '800'
			}).panelInstance('invoice_notes');			
		});		
		</script>
		{/literal}			
	</body>
</html>