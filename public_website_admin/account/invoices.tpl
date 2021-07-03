<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>MailBok - My Clients</title>
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
	<h2 class="content-header-title">My Invoices</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/account/">My Account</a></li>
	<li class="active">List</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-md-12">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-hand-o-up"></i>
                My Invoices List
              </h3>
            </div> <!-- /.portlet-header -->			  
            <div class="portlet-content">           			
              <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover" data-provide="datatable" data-display-rows="6" data-paginate="true" data-info="true">
				<thead>
			  <tr>
				<th>Added</th>
				<th>Account</th>
				<th>#Reference</th>					
				<th>Amount</th>
				<th>Amount Paid</th>
				<th>Amount due</th>
				<th></th>
				<th></th>
			   </tr>
			   </thead>
			   <tbody>
			  {foreach from=$invoiceData item=item}
			  <tr>
				<td>{$item.invoice_added|date_format}</td>
				<td align="left">{$item.account_name} ( {$item.account_email} - {$item.account_number} )</td>				
				<td align="left">
					<a href="/invoice/details.php?code={$item.invoice_code}" class="{if $item.invoice_active eq '0'}error{else}success{/if}">
						#{$item.invoice_reference}	
					</a>
				</td>
				<td>R {$item.invoice_amount_total|number_format:2:".":","}</td>
				<td>R {$item.invoice_amount_paid|number_format:2:".":","}</td>
				<td>R {$item.invoice_amount_due|number_format:2:".":","}</td>		
				<td><a href="http://www.mailbok.co.za{$item.invoice_pdf}" target="_blank">Download</a></td>
				{if $item.invoice_active eq '0'}
					<td class="error" align="center">Not Paid</td>
				{else}
					<td class="success" align="center">Paid</td>
				{/if}
			  </tr>
			  {/foreach}     
			  </tbody>
                </table>
              </div> <!-- /.table-responsive -->
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
</html>
