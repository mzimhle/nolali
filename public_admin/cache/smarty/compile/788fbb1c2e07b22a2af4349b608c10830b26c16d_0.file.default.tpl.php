<?php
/* Smarty version 3.1.34-dev-7, created on 2022-09-05 23:18:47
  from 'C:\sites\nolali.loc\public_admin\invoice\default.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_631667b70984f7_80971271',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '788fbb1c2e07b22a2af4349b608c10830b26c16d' => 
    array (
      0 => 'C:\\sites\\nolali.loc\\public_admin\\invoice\\default.tpl',
      1 => 1661262865,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_631667b70984f7_80971271 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once ('C:\sites\nolali.loc\public_admin\includes\meta.php');?>

</head>
<body>
	<?php include_once ('C:\sites\nolali.loc\public_admin\includes\header.php');?>

    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
          <ol class="breadcrumb slim-breadcrumb">
			<li class="breadcrumb-item active" aria-current="page">Ad Hoc</li>
			<li class="breadcrumb-item"><a href="#">Invoice</a></li>
			<li class="breadcrumb-item"><a href="/"><?php echo $_smarty_tpl->tpl_vars['activeAccount']->value['account_name'];?>
</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
          </ol>
          <h6 class="slim-pagetitle">Invoice</h6>
        </div><!-- slim-pageheader -->
        <div class="section-wrapper">
		  <label class="section-title">Invoice List</label>
            <p class="mg-b-20 mg-sm-b-20">Below is a list of invoices you have added.</p>
            <div class="row">
                <div class="col-md-12">					
					<div class="row">						
						<div class="col-sm-12">				
							<div class="form-group">
								<label for="filter_search">Search by reference</label>
								<input type="text" id="filter_search" name="filter_search" class="form-control" value="" />
							</div>
						</div>
					</div>					
                    <div class="form-group">
                        <button type="button" onclick="getRecords(); return false;" class="btn btn-primary">Search</button>
                        <button class="btn btn-secondary fr" type="button" onclick="link('/invoice/details.php'); return false;">Add invoice</button>
                    </div>
                    <p>There are <span id="result_count" name="result_count" class="success">0</span> records showing. We are displaying <span id="result_display" name="result_display" class="success">0</span> records per page.</p>
                    <div id="tableContent" class="table-responsive" align="center"></div>
                </div>
            </div>
		  <!-- table-wrapper -->
        </div><!-- section-wrapper -->
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
	<?php include_once ('C:\sites\nolali.loc\public_admin\includes\footer.php');?>


<?php echo '<script'; ?>
 type="text/javascript">
	$(document).ready(function() {
		getRecords();
	});

	function getRecords() {
		var html		= '';
		var filter_search	= $('#filter_search').val() != 'undefined' ? $('#filter_search').val() : '';
		/* Clear table contants first. */			
		$('#tableContent').html('');
		$('#tableContent').html('<table cellpadding="0" cellspacing="0" width="100%" border="0" class="display" id="dataTable"><thead><tr><th>Type</th><th>Name</th><th>Invoice</th><th>Total</th><th>Paid</th><th>Due</th><th></th><th></th><th></th></tr></thead><tbody id="invoicebody"><tr><td colspan="8" align="center"></td></tr></tbody></table>');	

		oTable = $('#dataTable').dataTable({
			"bJQueryUI": true,
			"aoColumns" : [
				{ sWidth: "5%" },
				{ sWidth: "20%" },
				{ sWidth: "15%" },
				{ sWidth: "15%" },
				{ sWidth: "15%" },
				{ sWidth: "15%" },
				{ sWidth: "10%" },
				{ sWidth: "5%" },
				{ sWidth: "5%" }
			],
			"sPaginationType": "full_numbers",							
			"bSort": false,
			"bFilter": false,
			"bInfo": false,
			"iDisplayStart": 0,
			"iDisplayLength": 20,				
			"bLengthChange": false,									
			"bProcessing": true,
			"bServerSide": true,		
			"sAjaxSource": "?action=search&filter_csv=0&filter_search="+filter_search,
			"fnServerData": function ( sSource, aoData, fnCallback ) {
				$.getJSON( sSource, aoData, function (json) {
					if (json.result === false) {
						$('#invoicebody').html('<tr><td colspan="8" align="center">No results</td></tr>');
					} else {
						$('#result_count').html(json.iTotalDisplayRecords);
						$('#result_display').html(json.iTotalRecords);
					}
					fnCallback(json);
				});
			},
			"fnDrawCallback": function(){
			}
		});
		return false;
	}

	function sendInvoice() {
		
		var invoicecode = $('#invoicecode').val();
		
		$.ajax({
            type: "GET",
            url: "/invoice/",
            data: "mail_invoice_message="+invoicecode,
            dataType: "json",
            success: function(data){
                if(data.result == 1) {
                    $('#modal_invoice_success').show();
                    $('#modal_invoice_error').hide();
                } else {
                    $('#modal_invoice_success').hide();
                    $('#modal_invoice_error').show();
                    $('#modal_invoice_error .jGrowl-message').html(data.error);
                }
            }
		});								

		return false;
	}

	function openInvoiceModal(invoicecode) {
        $('#modal_invoice_success').hide();
        $('#modal_invoice_error').hide();
		$.ajax({
            type: "GET",
            url: "/invoice/",
            data: "get_invoice_details="+invoicecode,
            dataType: "json",
            success: function(data){
                if(data.result == 1) {
                    $('.modal-title').html(data.invoice.participant_name);
                    $('.modal_participant_name').html(data.invoice.participant_name);
                    $('.modal_invoice_id').html(data.invoice.invoice_code);
					$('.modal_invoice_due').html('R '+data.invoice.invoice_amount_due);
                    $('#invoicecode').val(data.invoice.invoice_id);
                    $('#sendInvoiceModal').modal('show');
                }
            }
		});	
	}     
<?php echo '</script'; ?>
>

<!-- Modal -->
<div class="modal fade" id="sendInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"><h4 class="modal-title"></h4></div>
			<div class="modal-body">
			<form id="sendInvoiceForm" name="sendInvoiceForm" method="post">
                <div class="form-group">
					<p>You are about to send an email with this invoice attached, to the client <span class="success modal_participant_name"></span>, it will show as coming from <span class="success"><?php echo $_smarty_tpl->tpl_vars['activeEntity']->value['entity_name'];?>
 < <?php echo $_smarty_tpl->tpl_vars['activeEntity']->value['entity_contact_email'];?>
 ></span>. The invoice reference is <span class="success modal_invoice_id"></span>. Amount due is <span class="success modal_invoice_due"></span></p>
                </div>		
                <div class="jgrowl-showcase" id="modal_invoice_error">
                    <div class="jGrowl">
                        <div class="jGrowl-notification growl-error">
                            <div class="jGrowl-header"><b>Error(s)!</b></div>
                            <div class="jGrowl-message"></div>
                        </div>
                    </div>
                </div> 
                <div class="jgrowl-showcase" id="modal_invoice_success">
                    <div class="jGrowl">
                        <div class="jGrowl-notification growl-success">
                            <div class="jGrowl-header"><b>Success!</b></div>
                            <div class="jGrowl-message">Email has been successfully sent out.</div>
                        </div>
                    </div>
                </div>
			</form>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default fl" type="button">Close</button>
				<button class="btn btn-warning" type="button" onclick="javascript:sendInvoice();">Send Invoice</button>
				<input type="hidden" id="invoicecode" name="invoicecode" value="" />
			</div>
		</div>
	</div>
</div>
<!-- modal -->
</body>
</html>
<?php }
}
