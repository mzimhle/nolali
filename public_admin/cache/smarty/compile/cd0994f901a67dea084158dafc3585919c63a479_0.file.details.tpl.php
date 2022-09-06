<?php
/* Smarty version 3.1.34-dev-7, created on 2022-09-07 00:20:27
  from 'C:\sites\nolali.loc\public_admin\commodity\booking\details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_6317c7ab02fdf2_86346768',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cd0994f901a67dea084158dafc3585919c63a479' => 
    array (
      0 => 'C:\\sites\\nolali.loc\\public_admin\\commodity\\booking\\details.tpl',
      1 => 1662501336,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6317c7ab02fdf2_86346768 (Smarty_Internal_Template $_smarty_tpl) {
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
			<li class="breadcrumb-item"><a href="/commodity/booking/details.php?id=<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['invoice_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['invoice_code'];?>
</a></li>
			<?php } else { ?>
			<li class="breadcrumb-item active" aria-current="page">Add</li>
			<?php }?>
			<li class="breadcrumb-item"><a href="/ommodity/booking/">Booking</a></li>
			<li class="breadcrumb-item"><a href="/ommodity/booking/">Product</a></li>
            <li class="breadcrumb-item"><a href="/"><?php echo $_smarty_tpl->tpl_vars['activeAccount']->value['account_name'];?>
</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Bookings</h6>
        </div><!-- slim-pageheader -->
        <div class="section-wrapper card card-latest-activity mg-t-20">
			<label class="section-title"><?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {?>Details of <?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['invoice_code'];
} else { ?>Add new bookings<?php }?></label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the booking</p>				
            <div class="row">
                <div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
                    <?php if (isset($_smarty_tpl->tpl_vars['errors']->value)) {?><div class="alert alert-danger" role="alert"><strong><?php echo $_smarty_tpl->tpl_vars['errors']->value;?>
</strong></div><?php }?>				
                    <form action="/commodity/booking/details.php<?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {?>?id=<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['invoice_id'];
}?>" method="POST">
                        <div class="row">
                            <div class="col-sm-10">				
                                <div class="form-group has-error">
                                    <label for="search_participant_name">Search participant</label>
                                    <input type="text" id="search_participant_name" name="search_participant_name" class="form-control is-invalid" value="<?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {
echo $_smarty_tpl->tpl_vars['invoiceData']->value['participant_name'];?>
 ( <?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['participant_cellphone'];?>
 )<?php }?>" />	
                                    <input type="hidden" id="search_participant_id" name="search_participant_id" value="<?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {
echo $_smarty_tpl->tpl_vars['invoiceData']->value['participant_id'];
}?>" />	
                                    <code>Please select the participant this invoice belongs to</code>								
                                </div>
                            </div>
                            <div class="col-sm-2">				
                                <div class="form-group has-error">
                                    <label for="search_participant_name">&nbsp;</label><br />
									<input type="button" onclick="addParticipantModal(); return false;" value="New Participant" class="btn btn-secondary fr">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">				
                                <div class="form-group has-error">
                                    <label for="product_id">Search booking product</label>
                                    <input type="text" id="product_name" name="product_name" class="form-control is-invalid" value="<?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {
echo $_smarty_tpl->tpl_vars['invoiceData']->value['product_name'];?>
 at R <?php echo number_format($_smarty_tpl->tpl_vars['invoiceData']->value['price_amount'],2,',','.');?>
 per session<?php }?>" />	
                                    <input type="hidden" id="price_id" name="price_id" value="<?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {
echo $_smarty_tpl->tpl_vars['invoiceData']->value['price_id'];
}?>" />	
                                    <code>Please select the product to book</code>								
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">				
                                <div class="form-group has-error">
                                    <label for="product_id">Start Date</label>
                                    <input type="text" id="invoiceitem_date_start" name="invoiceitem_date_start" class="form-control is-invalid" value="<?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {
echo $_smarty_tpl->tpl_vars['invoiceData']->value['invoiceitem_date_start'];
}?>" />	
                                    <code>Please select the start date of this booking</code>								
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group has-error">
                                    <label for="product_id">End Date</label>
                                    <input type="text" id="invoiceitem_date_end" name="invoiceitem_date_end" class="form-control is-invalid" value="<?php if (isset($_smarty_tpl->tpl_vars['invoiceData']->value)) {
echo $_smarty_tpl->tpl_vars['invoiceData']->value['invoiceitem_date_end'];
}?>" />
                                    <code>Please select the end date of this booking</code>	
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">	
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
        // Datepicker
        $('#invoiceitem_date_start').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
		  dateFormat: 'yy-mm-dd',
		  minDate : 0
        });		
        $('#invoiceitem_date_end').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
		  dateFormat: 'yy-mm-dd',
		  minDate : 0
        });			
        $( "#product_name" ).autocomplete({
            source: "/feeds/booking.php",
            minLength: 2,
            select: function( event, ui ) {
                if(ui.item.id == '') {
                    $('#product_name').html('');
                    $('#price_id').val('');					
                } else {
                    $('#product_name').val(ui.item.value);
                    $('#price_id').val(ui.item.id);
                }
                $('#product_name').val('');										
            }
        });		
    });
    <?php echo '</script'; ?>
>
    
  </body>
</html>
<?php }
}
