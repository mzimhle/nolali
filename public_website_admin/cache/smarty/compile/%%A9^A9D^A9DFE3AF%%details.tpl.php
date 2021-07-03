<?php /* Smarty version 2.6.20, created on 2015-05-27 14:41:37
         compiled from booking/details.tpl */ ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
 Management System</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</head>
<body>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header">
	<h2 class="content-header-title">Booking</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/booking/">Booking</a></li>
	<li><a href="#"><?php if (isset ( $this->_tpl_vars['bookingData'] )): ?><?php echo $this->_tpl_vars['bookingData']['booking_person_name']; ?>
 - <?php echo $this->_tpl_vars['bookingData']['booking_person_email']; ?>
<?php else: ?>Add a booking<?php endif; ?></a></li>
	<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					<?php if (isset ( $this->_tpl_vars['bookingData'] )): ?><?php echo $this->_tpl_vars['bookingData']['booking_person_name']; ?>
 - <?php echo $this->_tpl_vars['bookingData']['booking_person_email']; ?>
<?php else: ?>Add a booking<?php endif; ?>
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/booking/details.php<?php if (isset ( $this->_tpl_vars['bookingData'] )): ?>?code=<?php echo $this->_tpl_vars['bookingData']['booking_code']; ?>
<?php endif; ?>" method="POST" data-validate="parsley" class="form parsley-form">
                <div class="form-group">
                  <label for="booking_person_name">Fullname</label>
                  <input type="text" id="booking_person_name" name="booking_person_name" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['bookingData']['booking_person_name']; ?>
" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['booking_person_name'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['booking_person_name']; ?>
</span><?php endif; ?>					  
                </div>
                <div class="form-group">
                  <label for="booking_person_email">Email Address</label>
                  <input type="text" id="booking_person_email" name="booking_person_email" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['bookingData']['booking_person_email']; ?>
" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['booking_person_email'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['booking_person_email']; ?>
</span><?php endif; ?>					  
                </div>
                <div class="form-group">
                  <label for="booking_person_number">Cellphone / Telephone Number</label>
                  <input type="text" id="booking_person_number" name="booking_person_number" class="form-control" value="<?php echo $this->_tpl_vars['bookingData']['booking_person_number']; ?>
" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['booking_person_number'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['booking_person_number']; ?>
</span><?php endif; ?>					  
                </div>
                <div class="form-group">
                  <label for="areapost_name">Area</label>
                  <input type="text" id="areapost_name" name="areapost_name" class="form-control" value="<?php echo $this->_tpl_vars['bookingData']['areapost_name']; ?>
" />
				  <input type="hidden" id="areapost_code" name="areapost_code" value="<?php echo $this->_tpl_vars['bookingData']['areapost_code']; ?>
" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['booking_person_number'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['booking_person_number']; ?>
</span><?php endif; ?>					  
                </div>	
                <div class="form-group">
                  <label for="booking_startdate">Start date and time</label>
                  <input type="text" id="booking_startdate" name="booking_startdate" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['bookingData']['booking_startdate']; ?>
" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['booking_startdate'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['booking_startdate']; ?>
</span><?php endif; ?>					  
                </div>
                <div class="form-group">
                  <label for="booking_enddate">End date and time</label>
                  <input type="text" id="booking_enddate" name="booking_enddate" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['bookingData']['booking_enddate']; ?>
" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['booking_enddate'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['booking_enddate']; ?>
</span><?php endif; ?>					  
                </div>				
                <div class="form-group">
					<label for="booking_message">Message / Note</label>
					<textarea id="booking_message" name="booking_message" class="form-control wysihtml5" rows="3"><?php echo $this->_tpl_vars['bookingData']['booking_message']; ?>
</textarea>
					<?php if (isset ( $this->_tpl_vars['errorArray']['booking_message'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['booking_message']; ?>
</span><?php endif; ?>					  
                </div>				
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->
		<div class="col-sm-3">
			<div class="list-group">  
				<a class="list-group-item" href="/booking/">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<?php if (isset ( $this->_tpl_vars['bookingData'] )): ?>					
				<a class="list-group-item" href="#">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 
				<a class="list-group-item" href="/booking/item.php?code=<?php echo $this->_tpl_vars['bookingData']['booking_code']; ?>
">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Items
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/booking/payment.php?code=<?php echo $this->_tpl_vars['bookingData']['booking_code']; ?>
">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Payments
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>				
				<a class="list-group-item" href="/booking/generate.php?code=<?php echo $this->_tpl_vars['bookingData']['booking_code']; ?>
">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Generate PDF Invoice
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>				
				<?php endif; ?>
			</div> <!-- /.list-group -->
        </div>			
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php echo '
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$( "#areapost_name" ).autocomplete({
		source: "/feeds/areapost.php",
		minLength: 2,
		select: function( event, ui ) {
			if(ui.item.id == \'\') {
				$(\'#areapost_name\').html(\'\');
				$(\'#areapost_code\').val(\'\');					
			} else {
				$(\'#areapost_name\').html(\'<b>\' + ui.item.value + \'</b>\');
				$(\'#areapost_code\').val(ui.item.id);	
			}
			$(\'#areapost_name\').val(\'\');										
		}
	});
	
	$( "#booking_startdate" ).datetimepicker({
		defaultDate: "+1w",
		dateFormat: \'yy-mm-dd\',
		changeMonth: true,
		numberOfMonths: 3,
		onClose: function( selectedDate ) {
			$( "#booking_enddate" ).datetimepicker( "option", "minDate", selectedDate );
		}
	});
	
	$( "#booking_enddate" ).datetimepicker({
		defaultDate: "+1w",
		dateFormat: \'yy-mm-dd\',
		changeMonth: true,
		numberOfMonths: 3,
		onClose: function( selectedDate ) {
			$( "#booking_startdate" ).datetimepicker( "option", "maxDate", selectedDate );
		}
	});	
});
</script>
'; ?>

</html>