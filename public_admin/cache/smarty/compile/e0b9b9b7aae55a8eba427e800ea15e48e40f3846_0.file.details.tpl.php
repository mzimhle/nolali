<?php
/* Smarty version 3.1.34-dev-7, created on 2022-08-31 22:22:13
  from 'C:\sites\nolali.loc\public_admin\invoice\details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_630fc2f5b14660_53310708',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e0b9b9b7aae55a8eba427e800ea15e48e40f3846' => 
    array (
      0 => 'C:\\sites\\nolali.loc\\public_admin\\invoice\\details.tpl',
      1 => 1661804303,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_630fc2f5b14660_53310708 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php include_once ('C:\sites\nolali.loc\public_admin\includes\meta.php');?>

    <link href="/css/summernote-bs4.css" rel="stylesheet">
  </head>
  <body>
	<?php include_once ('C:\sites\nolali.loc\public_admin\includes\header.php');?>

    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
			<ol class="breadcrumb slim-breadcrumb">
			<?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {?>
			<li class="breadcrumb-item active" aria-current="page">Edit</li>
			<li class="breadcrumb-item"><a href="/invoice/details.php?id=<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['invoice_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['invoice_code'];?>
</a></li>
			<?php } else { ?>
			<li class="breadcrumb-item active" aria-current="page">Add</li>
			<?php }?>
			<li class="breadcrumb-item"><a href="/invoice/">Ad Hoc</a></li>
			<li class="breadcrumb-item"><a href="/invoice/">Invoice</a></li>
            <li class="breadcrumb-item"><a href="/"><?php echo $_smarty_tpl->tpl_vars['activeAccount']->value['account_name'];?>
</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Invoice</h6>
        </div><!-- slim-pageheader -->
        <?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {?>
		<ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/invoice/details.php?id=<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['invoice_id'];?>
" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/invoice/item.php?id=<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['invoice_id'];?>
" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Items</a>
			</li>		
		</ul>
        <?php }?>
        <div class="section-wrapper card card-latest-activity mg-t-20">
			<label class="section-title"><?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {?>Details of <?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['invoice_code'];
} else { ?>Add new invoice<?php }?></label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the invoice</p>				
            <div class="row">
                <div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
                    <?php if (isset($_smarty_tpl->tpl_vars['errors']->value)) {?><div class="alert alert-danger" role="alert"><strong><?php echo $_smarty_tpl->tpl_vars['errors']->value;?>
</strong></div><?php }?>				
                    <form action="/invoice/details.php<?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {?>?id=<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['invoice_id'];
}?>" method="POST">
                        <div class="row">
                            <div class="col-sm-4">			
                                <div class="form-group has-error">
                                    <label for="invoice_date_payment">Expiry Date</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<i class="icon ion-calendar tx-16 lh-0 op-6"></i>
											</div>
										</div>
										<input type="text" class="form-control" id="invoice_date_payment" name="invoice_date_payment" value="<?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {
echo $_smarty_tpl->tpl_vars['invoiceData']->value['invoice_date_payment'];
}?>" readonly />
									</div>
									<code>Please select expiry date of invoice</code>
                                </div>
                            </div>
                            <?php if (!isset($_smarty_tpl->tpl_vars['entity']->value)) {?>
                            <div class="col-sm-8">
                                <div class="form-group has-error">
                                    <label for="search_entity_name">Search for entity</label>
                                    <input type="text" id="search_entity_name" name="search_entity_name" class="form-control is-invalid" value="<?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {
echo $_smarty_tpl->tpl_vars['invoiceData']->value['entity_name'];?>
 ( <?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['entity_contact_cellphone'];?>
 )<?php }?>" />	
                                    <input type="hidden" id="search_entity_id" name="search_entity_id" value="<?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {
echo $_smarty_tpl->tpl_vars['invoiceData']->value['entity_id'];
}?>" />	
                                    <code>Please select owner of the invoice</code>
                                </div>
                            </div>
                            <?php } else { ?>
                            <div class="col-sm-5">
                                <div class="form-group has-error">
                                    <label for="search_participant_name">Search for participant</label>
                                    <input type="text" id="search_participant_name" name="search_participant_name" class="form-control is-invalid" value="<?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {
echo $_smarty_tpl->tpl_vars['invoiceData']->value['participant_name'];?>
 ( <?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['participant_cellphone'];?>
 )<?php }?>" />
                                    <input type="hidden" id="search_participant_id" name="search_participant_id" value="<?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {
echo $_smarty_tpl->tpl_vars['invoiceData']->value['participant_id'];
}?>" />	
                                    <code>Select owner of the invoice</code>
                                </div>
                            </div>
                            <div class="col-md-3">	
                                <div class="form-group has-error">
                                    <label for="search_participant_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="button" value="<?php if (!isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {?>Add<?php } else { ?>Change<?php }?> participant" class="btn btn-primary form-control" onclick="addParticipantModal(); return false;">
                                </div>
                            </div>                            
                            <?php }?>
                        </div>						
                        <div class="row">
                            <div class="col-md-12">	
                                <div class="form-actions text">
                                    <input type="submit" value="<?php if (!isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {?>Add<?php } else { ?>Update<?php }?>" class="btn btn-primary">
                                </div>
                            </div>
                        </div>			
                    </form>
                </div><!-- col-4 -->
            </div><!-- row -->
        </div><!-- section-wrapper -->
		
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
	<?php include_once ('C:\sites\nolali.loc\public_admin\includes\footer.php');?>

    
    <?php echo '<script'; ?>
 type="text/javascript">
    $(document).ready(function() {	
        // Datepicker
        $('#invoice_date_payment').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
		  dateFormat: 'yy-mm-dd',
		  minDate : 0
        });
		// Feed	        
        <?php if (!isset($_smarty_tpl->tpl_vars['entity']->value)) {?>	
        $( "#search_entity_name" ).autocomplete({
            source: "/feeds/entity.php",
            minLength: 2,
            select: function( event, ui ) {
                if(ui.item.id == '') {
                    $('#search_entity_name').html('');
                    $('#search_entity_id').val('');					
                } else {
                    $('#search_entity_name').val(ui.item.value);
                    $('#search_entity_id').val(ui.item.id);
                }
                $('#search_entity_name').val('');										
            }
        });
        <?php } else { ?>
        $( "#search_participant_name" ).autocomplete({
            source: "/feeds/participant.php",
            minLength: 2,
            select: function( event, ui ) {
                if(ui.item.id == '') {
                    $('#search_participant_name').html('');
                    $('#search_participant_id').val('');					
                } else {
                    $('#search_participant_name').val(ui.item.value);
                    $('#search_participant_id').val(ui.item.id);
                }
                $('#search_participant_name').val('');										
            }
        });
        <?php }?>
        
    });
    <?php echo '</script'; ?>
>
    
  </body>
</html>
<?php }
}
