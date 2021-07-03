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
              <form id="validate-basic" action="/invoice/item.php?code={$invoiceData.invoice_code}" method="POST" data-validate="parsley" class="form parsley-form">			
				<p>Below is a list of items under this invoice.</p>
				<table class="table table-bordered">	
					<thead>
					  <tr>				
						<th valign="top">Name</th>
						<th valign="top">Description</th>
						<th valign="top">Quantity</th>
						<th valign="top">Unit Price</th>
						<th valign="top"></th>		
						<th valign="top"></th>	
					  </tr>
					</thead>
					<tbody>
					{foreach from=$invoiceitemData item=item}
					  <tr>	
						<td valign="top">{$item.invoiceitem_name}</td>
						<td valign="top">{$item.invoiceitem_description}</td>
						<td valign="top">{$item.invoiceitem_quantity}</td>
						<td valign="top">R {$item.invoiceitem_amount|number_format:0:".":","}</td>
						<td valign="top">
							<button value="Update" class="btn btn-notice" onclick="invoiceitemUpdateModal('{$item.invoiceitem_code}', '{$item.invoiceitem_name}', '{$item.invoiceitem_description}', '{$item.invoiceitem_quantity}','{$item.invoiceitem_amount}'); return false;">Update</button>
						</td>						
						<td valign="top">
							<button value="Delete" class="btn btn-danger" onclick="deleteModal('{$item.invoiceitem_code}', '{$item.invoice_code}', 'item'); return false;">Delete</button>
						</td>		
					  </tr>			     
					{foreachelse}
						<tr>
							<td align="center" colspan="6">There are currently no items</td>
						</tr>					
					{/foreach}
					</tbody>					  
				</table>
				<p>Add new item below</p>
                <div class="form-group">
					<label for="invoiceitem_name">Name</label>
					<input type="text" id="invoiceitem_name" name="invoiceitem_name" class="form-control" data-required="true" />
					{if isset($errorArray.invoiceitem_name)}<br /><span class="error">{$errorArray.invoiceitem_name}</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="invoiceitem_description">Description</label>
					<textarea id="invoiceitem_description" name="invoiceitem_description" class="form-control" data-required="true"></textarea>
					{if isset($errorArray.invoiceitem_description)}<br /><span class="error">{$errorArray.invoiceitem_description}</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="invoiceitem_quantity">Quantity in numbers</label>
					<input type="text" id="invoiceitem_quantity" name="invoiceitem_quantity" class="form-control" data-required="true" value="1" />
					{if isset($errorArray.invoiceitem_quantity)}<br /><span class="error">{$errorArray.invoiceitem_quantity}</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="invoiceitem_amount">Item Amount (exl. vat)</label>
					<input type="text" id="invoiceitem_amount" name="invoiceitem_amount" class="form-control" data-required="true" />
					{if isset($errorArray.invoiceitem_amount)}<br /><span class="error">{$errorArray.invoiceitem_amount}</span>{/if}					  
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
				<a class="list-group-item" href="#">
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

	function invoiceitemUpdateModal(code, name, description, quantity, price) {
		$('#invoiceitemcode').val(code);
		$('#invoiceitemname').val(name);
		$('#invoiceitemdescription').val(description);
		$('#invoiceitemquantity').val(quantity);
		$('#invoiceitemprice').val(price);
		$('#invoiceitemUpdateModal').modal('show');
		return false;
	}
	
	function invoiceitemUpdate() {
		
		var code 			= $('#invoiceitemcode').val();
		var name			= $('#invoiceitemname').val();
		var description	= $('#invoiceitemdescription').val();
		var quantity 		= $('#invoiceitemquantity').val();
		var price 			= $('#invoiceitemprice').val();
		
		$.ajax({
				type: "POST",
				url: "item.php?code={/literal}{$invoiceData.invoice_code}{literal}",
				data: "update_code="+code+"&name="+name+"&description="+description+"&quantity="+quantity+"&price="+price,
				dataType: "json",
				success: function(data){
					if(data.result == 1) {
						window.location.href = window.location.href;
					} else {
						$('#invoiceitemUpdateModal').modal('hide');
						$.howl ({
						  type: 'info'
						  , title: 'Notification'
						  , content: data.error
						  , sticky: $(this).data ('sticky')
						  , lifetime: 7500
						  , iconCls: $(this).data ('icon')
						});	
					}
				}
		});								

		return false;
	}	
</script>
{/literal}
<!-- Modal -->
<div class="modal fade" id="invoiceitemUpdateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Update Item</h4>
			</div>
			<div class="modal-body">
                <div class="form-group">
					<label for="invoiceitemname">Name</label>
					<input type="text" name="invoiceitemname" id="invoiceitemname" class="form-control" data-required="true" />  
                </div>
                <div class="form-group">
					<label for="invoiceitemdescription">Description</label>
					<textarea name="invoiceitemdescription" id="invoiceitemdescription" class="form-control" data-required="true"></textarea>  
                </div>
                <div class="form-group">
					<label for="invoiceitemquantity">Quantity in numbers</label>
					<input type="text" name="invoiceitemquantity" id="invoiceitemquantity" class="form-control" data-required="true" />  
                </div>				
                <div class="form-group">
					<label for="invoiceitemprice">Price (exl. vat)</label>
					<input type="text" name="invoiceitemprice" id="invoiceitemprice" class="form-control" data-required="true" />  
                </div>				
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:invoiceitemUpdate();">Update</button>
				<input type="hidden" id="invoiceitemcode" name="invoiceitemcode" value=""/>
			</div>
		</div>
	</div>
</div>
<!-- modal -->
</html>