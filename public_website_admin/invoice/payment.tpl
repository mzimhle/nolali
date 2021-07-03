<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>{$domainData.campaign_name} Management System</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	{include_php file='includes/css.php'}
</head>
<body>
{include_php file='includes/header.php'}
<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header">
		<h2 class="content-header-title">Invoice</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="/invoice/">Invoice</a></li>
			<li><a href="#">REF#{$invoiceData.invoice_code} - {$invoiceData.invoice_person_name}</a></li>
			<li class="active">Items</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Items List
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/invoice/payment.php?code={$invoiceData.invoice_code}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
				<p>Below is a list of payments under this invoice.</p>
				<table class="table table-bordered">	
					<thead>
					  <tr>				
						<th valign="top">Amount</th>
						<th valign="top">Date of payment</th>
						<th valign="top">Proof of payment</th>		
						<th valign="top"></th>
					  </tr>
					</thead>
					<tbody>
					{foreach from=$invoicepaymentData item=item}
					  <tr>	
						<td valign="top">R {$item.invoicepayment_amount|number_format:0:".":","}</td>
						<td valign="top">{$item.invoicepayment_paid_date}</td>
						<td valign="top">{if $item.invoicepayment_file eq ''}N / A{else}<a href="http://{$item.campaign_domain}{$item.invoicepayment_file}" target="_blank">Download</a>{/if}</td>					
						<td valign="top">
							<button value="Delete" class="btn btn-danger" onclick="deleteModal('{$item.invoicepayment_code}', '{$item.invoice_code}', 'payment'); return false;">Delete</button>
						</td>		
					  </tr>			     
					{foreachelse}
						<tr>
							<td align="center" colspan="6">There are currently no payments</td>
						</tr>					
					{/foreach}
					</tbody>					  
				</table>
				<p>Add new payment below</p>
                <div class="form-group">
					<label for="invoicepayment_amount">Payment Amount</label>
					<input type="text" id="invoicepayment_amount" name="invoicepayment_amount" class="form-control" data-required="true" />
					{if isset($errorArray.invoicepayment_amount)}<br /><span class="error">{$errorArray.invoicepayment_amount}</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="">Date of payment</label>
					<input type="text" id="invoicepayment_paid_date" name="invoicepayment_paid_date" class="form-control" data-required="true" />
					{if isset($errorArray.invoicepayment_paid_date)}<br /><span class="error">{$errorArray.invoicepayment_paid_date}</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="invoicepayment_amount">Proof of payment file</label>
					<input type="file" name="paymentfile" id="paymentfile">
					{if isset($errorArray.paymentfile)}<br /><span class="error">{$errorArray.paymentfile}</span>{/if}					  
                </div>			
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
            </div> <!-- /.portlet-content --> 
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
		<div class="col-sm-3">
			<div class="list-group">  
				<a class="list-group-item" href="/invoice/">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/invoice/details.php?code={$invoiceData.invoice_code}">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 
				<a class="list-group-item" href="/invoice/payment.php?code={$invoiceData.invoice_code}">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Items
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="#">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Payments
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>	
				<a class="list-group-item" href="/invoice/generate.php?code={$invoiceData.invoice_code}">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Generate PDF
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>					
			</div> <!-- /.list-group -->
		</div>				
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
{literal}
<script type="text/javascript">
jQuery(document).ready(function() {
	$( "#invoicepayment_paid_date" ).datepicker({
	  defaultDate: "+1w",
	  dateFormat: 'yy-mm-dd',
	  changeMonth: true,
	  changeYear: true
	});
});
</script>
{/literal}
</html>