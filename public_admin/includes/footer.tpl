<script type="text/javascript" src="/library/javascript/jquery.js"></script>
<script type="text/javascript" src="/library/javascript/popper.js"></script>
<script type="text/javascript" src="/library/javascript/bootstrap.js"></script>
<script type="text/javascript" src="/library/javascript/jquery.cookie.js"></script>
<script type="text/javascript" src="/library/javascript/moment.js"></script>
<script type="text/javascript" src="/library/javascript/jquery-ui.js"></script>
<script type="text/javascript" src="/library/javascript/summernote-0.8.18-dist/summernote-bs4.min.js"></script>
<script type="text/javascript" src="/library/javascript/jquery.dataTables.min.js"></script>
<div class="slim-footer">
	<div class="container">
		<p>Copyright 2022 &copy; All Rights Reserved.</p>
		<p>Designed and developed by: <a href="http://www.nolaliosombululayo.com">Nolali O Sombululayo</a></p>
	</div><!-- container -->
</div><!-- slim-footer -->
{literal}
<script type="text/javascript" language="Javascript">
function link(url) {
    window.location.href = url;
}

function deleteitem() {
    
    var id 		= $('#itemcode').val();
    var page 	= $('#itempage').val();
    var code 	= $('#maincode').val();
    var reload 	= $('#itemreload').val();
    var status  = $('#itemstatus').val();

    parameter = '&status='+status;
    if(code != '') {
        parameter = '&id='+code;
    }
    
    $.ajax({
        type: "GET",
        url: page+".php",
        data: "delete_id="+id+parameter,
        dataType: "json",
        success: function(data){
            if(data.result == 1) {
                if(reload == 0) {
                    if(typeof oTable != 'undefined') {
                        $('#deleteModal').modal('hide');						
                        oTable.fnDraw();
                    } else {
                        window.location.href = window.location.href;
                    }
                } else {
                    window.location.href = window.location.href;
                }
            } else {
                
                $('#deleteModal').modal('hide');
                
                $.howl ({
                  type: 'danger'
                  , title: 'Error Message'
                  , content: data.error
                  , sticky: $(this).data ('sticky')
                  , lifetime: 7500
                  , iconCls: $(this).data ('icon')
                });
                if(typeof oTable != 'undefined') {
                    oTable.fnDraw();
                }							
            }
        }
    });
    
    return false;
}

function addProductModal(id, page, type) {
    $.ajax({
        type: "GET",
        url: page+".php",
        data: "getproducts=1&id="+id,
        dataType: "html",
        success: function(data){
			$('#invoiceid').val(id);
			$('#invoicepage').val(page);
			$('#invoicetype').val(type);
			$('#productlist').html(data);
			$('#addProductModal').modal('show');
        }
    });
    return false;
}

function deleteModal(id, code, page, status = 1, reload = 0) {
    $('#itemcode').val(id);
    $('#maincode').val(code);
    $('#itempage').val(page);
    $('#itemstatus').val(status);
    $('#itemreload').val(reload);
    $('#deleteModal').modal('show');
    return false;
}

function changeSubStatus() {
    var id 		= $('#itemsubcode').val();
    var status	= $('#itemsubstatus').val();
    var page 	= $('#itemsubpage').val();	
    var parent 	= $('#itemsubparent').val();
    
    $.ajax({
		type: "GET",
		url: page+".php?id="+parent,
		data: "status_id="+id+"&status="+status,
		dataType: "json",
		success: function(data){
			if(data.result == 1) {
				window.location.href = window.location.href;
			} else {
				$('#statusModal').modal('hide');
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

function statusSubModal(id, status, page, parent) {
    $('#itemsubcode').val(id);
    $('#itemsubstatus').val(status);
    $('#itemsubpage').val(page);
    $('#itemsubparent').val(parent);
    $('#statusSubModal').modal('show');
}

function changestatus() {
    
    var id 		= $('#itemcode').val();
    var status	= $('#itemstatus').val();
    var page 	= $('#itempage').val();
    
    $.ajax({
        type: "GET",
        url: page+".php",
        data: "status_code="+id+"&status="+status,
        dataType: "json",
        success: function(data){
            if(data.result == 1) {
                window.location.href = window.location.href;
            } else {
                $('#statusModal').modal('hide');
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

function statusModal(id, status, page) {
    $('#itemcode').val(id);
    $('#itemstatus').val(status);
    $('#itempage').val(page);
    $('#statusModal').modal('show');
}

function addProduct() {

    var invoiceid	= $('#invoiceid').val();
    var invoicepage	= $('#invoicepage').val();
    var invoicetype	= $('#invoicetype').val();
	var modal_product_quantity = $('#modal_product_quantity').val();
    var modal_product_id = $('#modal_product_id').val();
	var modal_product_price = $('#modal_product_price :selected').val();
	
    $.ajax({
        type: "GET",
        url: invoicepage+".php",
        data: "addproduct=1&id="+invoiceid+"&type="+invoicetype+"&modal_product_id="+modal_product_id+"&modal_product_quantity="+modal_product_quantity+"&modal_product_price="+modal_product_price,
        dataType: "json",
        success: function(data){
            if(data.result == 1) {
				if(typeof oTable != 'undefined') {
					$('#addProductModal').modal('hide');						
					oTable.fnDraw();
				} else {
					window.location.href = window.location.href;
				}
            } else {
				alert(data.error);						
            }
        }
    });
    
    return false;
}

function getProductPrice(id) {
	$.ajax({
		type: "GET",
		url: "/includes/footer.php",
		data: "getproductprice="+id,
		dataType: "html",
		success: function(data){
			$('#modal_product_price').html(data);
		}
	});
	return false;
}

function addCompany() {
    $.ajax({
        type: "GET",
        url: "/includes/footer.php",
        data: "addcompany=1&company_id="+$('#modal_company_id').val()+"&company_name="+$('#modal_company_name').val()+"&company_cellphone="+$('#modal_company_cellphone').val()+"&company_email="+$('#modal_company_email').val()+"&company_address="+$('#modal_company_address').val(),
        dataType: "json",
        success: function(data){
            if(data.result == 1) {
				alert('Company added successfully');	
				$('#companyModal').modal('hide');					
            } else {
				alert(data.error);						
            }
        }
    });
    return false;
}

function companyModal(id='') {
	if(id != '' ) {
		$.ajax({
			type: "GET",
			url: "/includes/footer.php",
			data: "getcompany="+id,
			dataType: "json",
			success: function(data){
				$('#modal_company_id').val(data.company_id);
				$('#modal_company_name').val(data.company_name);
				$('#modal_company_cellphone').val(data.company_cellphone);
				$('#modal_company_email').val(data.company_email);
				$('#modal_company_address').val(data.company_address);
			}
		});
	}
	$('#companyModal').modal('show');	
    return false;
}

function addParticipantModal(id='') {

	$('#addParticipantError').hide();
	$('#addParticipantSuccess').hide();
	
    if(id != '') {
		$.ajax({
			type: "GET",
			url: "/includes/footer.php",
			data: "getParticipant="+id,
			dataType: "json",
			success: function(data){
				if(data.result == 1) {
					$('#participant_id').val(id);
					$('#participant_name').val(data.data.participant_name);
					$('#participant_cellphone').val(data.data.participant_cellphone);
					$('#participant_email').val(data.data.participant_email);				
					$('#participant_address').val(data.data.participant_address);
					$('#addParticipantModal').modal('show');
					return false;
				} else {
					alert(data.error);
					return false;
				}
			}
		});
	}
    $('#addParticipantModal').modal('show');
}

function addParticipant() {

	$('#addParticipantError').hide();
	$('#addParticipantSuccess').hide();
	
    var participant_id			= $('#participant_id').val();
    var participant_name		= $('#participant_name').val();
    var participant_cellphone	= $('#participant_cellphone').val();
	var participant_email 		= $('#participant_email').val();
	var participant_address		= $('#participant_address').val();
	
    $.ajax({
        type: "POST",
        url: "/includes/footer.php",
        data: "addUpdateParticipant=1&participant_id="+participant_id+"&participant_name="+participant_name+"&participant_cellphone="+participant_cellphone+"&participant_email="+participant_email+"&participant_address="+participant_address,
        dataType: "json",
        success: function(data){
            if(data.result == 1) {
				if(typeof oTable != 'undefined') {
					oTable.fnDraw();
				}
				if($('#search_participant_name').length) {
					$('#search_participant_id').val(data.id);
					$('#search_participant_name').val(data.message);
				}
				$('#addParticipantModal').modal('hide');
            } else {
				$('#addParticipantError').show();
				$('#addParticipantError p').html(data.message);						
            }
        }
    });
    
    return false;
}

function addProductCategoryModal(id='') {

	$('#addProductCategoryError').hide();
	$('#addProductCategorySuccess').hide();
	
    if(id != '') {
		$.ajax({
			type: "GET",
			url: "/includes/footer.php",
			data: "getProductCategory="+id,
			dataType: "json",
			success: function(data){
				if(data.result == 1) {
					$('#productcategory_id').val(id);
					$('#productcategory_name').val(data.data.productcategory_name);
					$('#addProductCategoryModal').modal('show');
					return false;
				} else {
					alert(data.error);
					return false;
				}
			}
		});
	}
    $('#addProductCategoryModal').modal('show');
}

function addProductCategory() {

	$('#addProductCategoryError').hide();
	$('#addProductCategorySuccess').hide();
	
    var productcategory_id		= $('#modal_productcategory_id').val();
    var productcategory_name	= $('#modal_productcategory_name').val();

    $.ajax({
        type: "POST",
        url: "/includes/footer.php",
        data: "addUpdateProductCategory=1&productcategory_id="+productcategory_id+"&productcategory_name="+productcategory_name,
        dataType: "json",
        success: function(data){
            if(data.result == 1) {
				window.location.href = window.location.href;
            } else {
				$('#addProductCategoryError').show();
				$('#addProductCategoryError p').html(data.message);						
            }
        }
    });
    
    return false;
}

function viewInvoiceModal(id) {
	$.ajax({
		type: "GET",
		url: "/includes/footer.php",
		data: "viewInvoice="+id,
		dataType: "json",
		success: function(data){
			if(data.result == 1) {
				$('.invoice_code').html(data.data.invoice_code);
				$('#invoice_type').html(data.data.invoice_type.toLowerCase());
				$('#invoice_paid_paid').html(data.data.invoice_paid_paid);
				$('#invoice_date_payment').html(data.data.invoice_date_payment);
				$('#invoice_text').html(data.data.invoice_text);
				$('#invoice_participant_name').html(data.data.participant_name);
				$('#invoice_participant_cellphone').html(data.data.participant_cellphone);
				$('#invoice_participant_email').html(data.data.participant_email);				
				$('#invoice_participant_address').html(data.data.participant_address);
				$('#invoice_amount_due').html('R '+data.data.invoice_amount_due);
				$('#invoice_amount_paid').html('R '+data.data.invoice_amount_paid);
				$('#invoice_amount_total').html('R '+data.data.invoice_amount_total);
				// Items.
				if(data.data.invoiceitems.length != 0) {
					var htmlItems = '<table class="table table-bordered" width="100%">';
					if(data.data.invoice_type == 'BOOKING') {
						htmlItems += '<thead><tr><th>Booking</th><th>Days</th><th>Unit Price</th><th>Total Price</th></tr></thead>';
					} else {
						htmlItems += '<thead><tr><th>Title</th><th>Description</th><th>Quantity</th><th>Unit Price</th><th>Total Price</th></tr></thead>';
					}
					var item = [];
					
					for(i = 0; i < data.data.invoiceitems.length; i++) {
						item = data.data.invoiceitems[i];
						if(data.data.invoice_type == 'BOOKING') {
							htmlItems += '<tr><td>'+item.invoiceitem_title+'</td><td>'+item.invoiceitem_quantity+'</td><td>R '+item.invoiceitem_amount_unit+'</td><td>R '+item.invoiceitem_amount_total+'</td></tr>';
						} else {
							htmlItems += '<tr><td>'+item.invoiceitem_title+'</td><td>'+item.invoiceitem_text+'</td><td>'+item.invoiceitem_quantity+'</td><td>R '+item.invoiceitem_amount_unit+'</td><td>R '+item.invoiceitem_amount_total+'</td></tr>';
						}
					}
				} else {
					var htmlItems = '<p>There are currently no items in this invoice</p>';
				}
				$('#htmlItems').html(htmlItems);
				$('#viewInvoiceModal').modal('show');
				return false;
			} else {
				alert(data.error);
				return false;
			}
		}
	});
	return false;
}
</script>
{/literal}
<!-- Modal -->
<div class="modal fade" id="viewInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Invoice view <span class="invoice_code success"></span></h4>
			</div>
			<div class="modal-body">
                <div class="row">	
                   <div class="col-sm-12">
						The <span id="invoice_type" class="success"></span> by client <span id="invoice_participant_name" class="success"></span> with address <span id="invoice_participant_address" class="success"></span> has the following details:<br /><br />
						<table class="table" width="100%">
							<tr><th>Total Amount</th><td id="invoice_amount_total"></td></tr>
							<tr><th>Paid Amount</th><td id="invoice_amount_paid"></td></tr>
							<tr><th>Due Amount</th><td id="invoice_amount_due"></td></tr>
							<tr><th>Due Amount</th><td id="invoice_amount_due"></td></tr>
						</table>
						<p>Below are the details of the items bought:</p>
						<div id="htmlItems">
						</div>
                    </div>
                </div>							
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="addProductCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add / Update Product Category</h4>
			</div>
			<div class="modal-body">
                <div class="row">	
                   <div class="col-sm-12">
                        <div class="form-group">
							<p>Below is where you can add or update a product category</p>
							<div class="alert alert-danger mg-b-0" role="alert" id="addProductCategoryError" name="addProductCategoryError">
								<strong>Oh snap!</strong><br />
								<p></p>
							</div>	
							<div class="alert alert-success" role="alert" id="addProductCategorySuccess" name="addProductCategorySuccess">
								<strong>Well done!</strong><br />
								<p>You have successfully added/updated a Product Category.</p>
							</div>							
						</div>	
                    </div>
                </div>			
                <div class="row">
                    <div class="col-sm-12">				
                        <div class="form-group has-error">
                            <label for="productcategory_name">Name</label>
                            <input type="text" id="modal_productcategory_name" name="modal_productcategory_name" class="form-control is-invalid"  value="" />	
                            <code class="tx-info" class="tx-info">Please add/update the name</code>
                        </div>
                    </div>				
                </div>						
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:addProductCategory();">Submit</button>
				<input type="hidden" id="modal_productcategory_id" name="modal_productcategory_id" value="" />
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="addParticipantModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add / Update Participant</h4>
			</div>
			<div class="modal-body">
                <div class="row">	
                   <div class="col-sm-12">
                        <div class="form-group">
							<p>Below is where you can add or update a participant</p>
							<div class="alert alert-danger mg-b-0" role="alert" id="addParticipantError" name="addParticipantError">
								<strong>Oh snap!</strong><br />
								<p></p>
							</div>	
							<div class="alert alert-success" role="alert" id="addParticipantSuccess" name="addParticipantSuccess">
								<strong>Well done!</strong><br />
								<p>You have successfully added/updated a participant.</p>
							</div>							
						</div>	
                    </div>
                </div>			
                <div class="row">
                    <div class="col-sm-12">				
                        <div class="form-group has-error">
                            <label for="participant_name">Name</label>
                            <input type="text" id="participant_name" name="participant_name" class="form-control is-invalid"  value="" />	
                            <code class="tx-info" class="tx-info">Please add all names</code>
                        </div>
                    </div>				
                </div>	
                <div class="row">
                    <div class="col-sm-12">				
                        <div class="form-group">
                            <label for="participant_cellphone">Cellphone</label>
                            <input type="text" id="participant_cellphone" name="participant_cellphone" class="form-control"  value="" />	
                            <code class="tx-info">Please add all names</code>										
                        </div>
                    </div>					
                </div>
				<div class="row">
                    <div class="col-sm-12">	
                        <div class="form-group">
                            <label for="participant_email">Email</label>
                            <input type="text" id="participant_email" name="participant_email" class="form-control"  value="" />	
                            <code class="tx-info">Please add the email address</code>										
                        </div>
                    </div>
                </div>
				<div class="row">
                    <div class="col-sm-12">	
                        <div class="form-group">
                            <label for="participant_address">Physical / Postal Address</label>
                            <input type="text" id="participant_address" name="participant_address" class="form-control"  value="" />	
                            <code class="tx-info">Please add the address</code>										
                        </div>
                    </div>
                </div>					
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:addParticipant();">Submit</button>
				<input type="hidden" id="participant_id" name="participant_id" value="" />
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="companyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add / Update Company</h4>
			</div>
			<div class="modal-body">
				<p>Below is where you can add / update a company</p>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="modal_product_quantity">Name</label>
							<input type="text" name="modal_company_name" id="modal_company_name" class="form-control is-invalid" value="" />
							<code>Add name of the company</code>
						</div>
					</div>					
				</div>	
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="modal_company_cellphone">Cellphone</label>
							<input type="text" name="modal_company_cellphone" id="modal_company_cellphone" class="form-control is-invalid" value="" />
							<code>Add cellphone of the company</code>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="modal_company_email">Email Address</label>
							<input type="text" name="modal_company_email" id="modal_company_email" class="form-control is-invalid" value="" />
							<code>Add email of the company</code>
						</div>
					</div>						
				</div>				
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="modal_company_address">Physical Address</label>
							<input type="text" name="modal_company_address" id="modal_company_address" class="form-control is-invalid" value="" />
							<code>Add physical address of the company</code>
						</div>
					</div>						
				</div>				
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:addCompany();">Add</button>
				<input type="hidden" id="modal_company_id" name="modal_company_id" value="" />
			</div>
		</div>
	</div>
</div>
<!-- modal -->
<!-- Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Product</h4>
			</div>
			<div class="modal-body">
				<p>Below is where you can add a product for this invoice. Select your product below</p>
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label for="modal_product_name">Select a product</label>
							<input type="text" name="modal_product_name" id="modal_product_name" class="form-control is-invalid" />	
							<input type="hidden" name="modal_product_id" id="modal_product_id" />
							<code>Type the first 3 letters of the product and select from the drop down</code>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label for="pricelist">Price</label>
							<select name="modal_product_price" id="modal_product_price" class="form-control">
								<option value=""> -- Please select a product -- </option>
							</select>
							<code>Price drop down wil display after product has been selected.</code>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="modal_product_quantity">Quantity</label>
							<input type="text" name="modal_product_quantity" id="modal_product_quantity" class="form-control is-invalid" value="1" />
							<code>Quantity is the amount of items based on the selected price selected.</code>
						</div>
					</div>
				</div>				
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:addProduct();">Add</button>
				<input type="hidden" id="invoiceid" name="invoiceid" value="" />
				<input type="hidden" id="invoicepage" name="invoicepage" value="" />
				<input type="hidden" id="invoicetype" name="invoicetype" value="" />
			</div>
		</div>
	</div>
</div>
<!-- modal -->
<!-- Modal -->
<div class="modal fade" id="statusSubModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Change Status</h4>
			</div>
			<div class="modal-body">Are you sure you want to change this item's status?</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:changeSubStatus();">Change Item Status</button>
				<input type="hidden" id="itemsubcode" name="itemsubcode" value="" />
				<input type="hidden" id="itemsubstatus" name="itemsubstatus" value="" />
				<input type="hidden" id="itemsubpage" name="itemsubpage" value=""/>
				<input type="hidden" id="itemsubparent" name="itemsubparent" value=""/>
			</div>
		</div>
	</div>
</div>
<!-- modal -->
<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="itemtitle" name="itemtitle">View Information</h4>
			</div>
			<div class="modal-body" id="itempage" name="itempage"></div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- modal -->
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Block / Delete Item</h4>
			</div>
			<div class="modal-body">Are you sure you want to delete / block this item?</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:deleteitem();">Delete Item</button>
				<input type="hidden" id="itemcode" name="itemcode" value=""/>
				<input type="hidden" id="itempage" name="itempage" value=""/>
				<input type="hidden" id="maincode" name="maincode" value=""/>
				<input type="hidden" id="itemreload" name="itemreload" value=""/>
                <input type="hidden" id="itemstatus" name="itemstatus" value=""/>
			</div>
		</div>
	</div>
</div>
<!-- modal -->
<!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Change Item Status</h4>
			</div>
			<div class="modal-body">Are you sure you want to change this item's status?</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:changestatus();">Change Item Status</button>
				<input type="hidden" id="itemcode" name="itemcode" value="" />
				<input type="hidden" id="itemstatus" name="itemstatus" value="" />
				<input type="hidden" id="itempage" name="itempage" value=""/>
			</div>
		</div>
	</div>
</div>
<!-- modal -->
