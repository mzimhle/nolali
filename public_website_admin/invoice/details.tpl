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
	<li><a href="#">{if isset($invoiceData)}REF#{$invoiceData.invoice_code} - {$invoiceData.invoice_person_name}{else}Add an invoice{/if}</a></li>
	<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					{if isset($invoiceData)}REF#{$invoiceData.invoice_code} - {$invoiceData.invoice_person_name}{else}Add an invoice{/if}
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/invoice/details.php{if isset($invoiceData)}?code={$invoiceData.invoice_code}{/if}" method="POST" data-validate="parsley" class="form parsley-form">
                <div class="form-group">
                  <label for="invoice_person_name">Fullname</label>
                  <input type="text" id="invoice_person_name" name="invoice_person_name" class="form-control" data-required="true" value="{$invoiceData.invoice_person_name}" />
				{if isset($errorArray.invoice_person_name)}<span class="error">{$errorArray.invoice_person_name}</span>{/if}					  
                </div>
                <div class="form-group">
                  <label for="invoice_person_email">Email Address</label>
                  <input type="text" id="invoice_person_email" name="invoice_person_email" class="form-control" data-required="true" value="{$invoiceData.invoice_person_email}" />
				{if isset($errorArray.invoice_person_email)}<span class="error">{$errorArray.invoice_person_email}</span>{/if}					  
                </div>
                <div class="form-group">
                  <label for="invoice_person_number">Cellphone / Telephone Number</label>
                  <input type="text" id="invoice_person_number" name="invoice_person_number" class="form-control" value="{$invoiceData.invoice_person_number}" />
				{if isset($errorArray.invoice_person_number)}<span class="error">{$errorArray.invoice_person_number}</span>{/if}					  
                </div>
                <div class="form-group">
                  <label for="invoice_make">Type / Make</label>
				<select id="invoice_make" name="invoice_make" class="form-control"  data-required="true" >
					<option value=""> ---------------- </option>
					<option value="ESTIMATE" {if $invoiceData.invoice_make eq 'ESTIMATE'}SELECTED{/if}> Cost Estimate </option>
					<option value="INVOICE" {if $invoiceData.invoice_make eq 'INVOICE'}SELECTED{/if}> Invoice </option>
					<option value="QUOTATION" {if $invoiceData.invoice_make eq 'QUOTATION'}SELECTED{/if}> Quotation </option>
				</select>
				{if isset($errorArray.invoice_make)}<span class="error">{$errorArray.invoice_make}</span>{/if}					  
                </div>			
                <div class="form-group">
					<label for="invoice_notes">Message / Note</label>
					<textarea id="invoice_notes" name="invoice_notes" class="form-control" rows="3">{$invoiceData.invoice_notes}</textarea>
					{if isset($errorArray.invoice_notes)}<span class="error">{$errorArray.invoice_notes}</span>{/if}					  
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
				{if isset($invoiceData)}					
				<a class="list-group-item" href="#">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 
				<a class="list-group-item" href="/invoice/item.php?code={$invoiceData.invoice_code}">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Items
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/invoice/payment.php?code={$invoiceData.invoice_code}">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Payments
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>	
				<a class="list-group-item" href="/invoice/generate.php?code={$invoiceData.invoice_code}">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Generate PDF
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>					
				{/if}
			</div> <!-- /.list-group -->
        </div>			
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
{literal}
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$( "#areapost_name" ).autocomplete({
		source: "/feeds/areapost.php",
		minLength: 2,
		select: function( event, ui ) {
			if(ui.item.id == '') {
				$('#areapost_name').html('');
				$('#areapost_code').val('');					
			} else {
				$('#areapost_name').html('<b>' + ui.item.value + '</b>');
				$('#areapost_code').val(ui.item.id);	
			}
			$('#areapost_name').val('');										
		}
	});
	
	$( "#invoice_startdate" ).datetimepicker({
		defaultDate: "+1w",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		numberOfMonths: 3,
		onClose: function( selectedDate ) {
			$( "#invoice_enddate" ).datetimepicker( "option", "minDate", selectedDate );
		}
	});
	
	$( "#invoice_enddate" ).datetimepicker({
		defaultDate: "+1w",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		numberOfMonths: 3,
		onClose: function( selectedDate ) {
			$( "#invoice_startdate" ).datetimepicker( "option", "maxDate", selectedDate );
		}
	});	
});
</script>
{/literal}
</html>
