<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}
		<script type="text/javascript" language="javascript" src="default.js"></script>
		<title>Invoices | {$domainData.campaign_company}</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/invoices/">Invoices</a></p>
			<p class="linebreak"></p>
			<div id="main">
				<!-- <a class="link" href="/admin/invoices/details.php">Add a New Invoice</a> -->
				<div id="tableContent" align="center">
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="htmlForm" id="htmlForm" action="/admin/invoices/" method="post">
							<table border="0" cellspacing="0" cellpadding="0" id="dataTable">							
								<thead>
								<tr>
									<th>Added</th>
									<th>Reference</th>
									<th>Full Name</th>						
									<th>Total Amount</th>
									<th>Payments</th>
									<th>Due Amount</th>
								</tr>
								</thead>							
							   <tbody>
							  {foreach from=$invoiceData item=item}
							  <tr>
								<td>{$item.invoice_added|date_format}</td>
								<td align="left"><a href="/admin/invoices/details.php?code={$item.invoice_code}">{$item.invoice_code}</a></td>	
								<td align="left">{$item.participant_name} {$item.participant_surname}</td>
								<td align="left">R {$item.total_amount|number_format:2:".":","}</td>		
								<td align="left">R {$item.payment_amount|number_format:2:".":","}</td>	
								<td align="left">R {$item.due_amount|number_format:2:".":","}</td>		
							  </tr>
							  {/foreach}     
							  </tbody>
							</table>
						 </form>
					 </div>
					 <!-- End Content Table -->
					<div class="clear"></div>
				</div>
			</div>							
			<div class="clr"></div>
			{include_php file='includes/footer.php'}
			</div>
	</body>
</html>