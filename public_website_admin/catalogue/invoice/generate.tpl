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
	<h2 class="content-header-title">Invoices</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="/catalogue/invoice/">Invoice</a></li>
			<li><a href="#">REF#{$invoiceData.invoice_code} - {$invoiceData.invoice_person_name}</a></li>
			<li class="active">Generate PDF</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Generate PDF Invoice
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/catalogue/invoice/generate.php?code={$invoiceData.invoice_code}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
				<p>This is where you will be generating the <span class="success">{$invoiceData.invoice_make}</span>.</p>
				<p><b><i>{$invoiceData.invoice_notes|default:"N / A"}</i></b></p>
				<div class="form-group">
				{if isset($errorArray.generate_invoice)}
					{if $errorArray.generate_invoice eq ''}
						<p class="success">Invoice has been successfully generated</p>
					{else}
						<p class="error">{$errorArray.generate_invoice}</p>
					{/if}
				{/if}			  
                </div>
				<p class="error">To generate an invoice, please click on the below button</p><br />
                <div class="form-group"><button type="submit" class="btn btn-primary">Generate PDF</button></div>
				{if $invoiceData.invoice_pdf neq ''}
					<p><a href="http://{$domainData.campaign_domain}{$invoiceData.invoice_pdf}" target="_blank">Click here for the PDF</a></p>
				{else}
					<p class="error">Invoice not yet generated.</p>
				{/if}
				<input type="hidden" value="1" id="generate_invoice" name="generate_invoice" />
              </form>			  
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->
		<div class="col-sm-3">
			<div class="list-group">  
				<a href="/catalogue/invoice/" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="#">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 
				<a class="list-group-item" href="/catalogue/invoice/item.php?code={$invoiceData.invoice_code}">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Items
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/catalogue/invoice/payment.php?code={$invoiceData.invoice_code}">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Payments
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>	
				<a class="list-group-item" href="#">
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
</html>
