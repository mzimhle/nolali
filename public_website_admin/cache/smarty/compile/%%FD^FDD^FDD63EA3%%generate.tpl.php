<?php /* Smarty version 2.6.20, created on 2015-05-23 12:08:24
         compiled from booking/generate.tpl */ ?>
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
	<h2 class="content-header-title">Invoices</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="/booking/">Booking</a></li>
			<li><a href="#"><?php echo $this->_tpl_vars['bookingData']['booking_person_name']; ?>
 - <?php echo $this->_tpl_vars['bookingData']['booking_person_email']; ?>
</a></li>
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
              <form id="validate-basic" action="/booking/generate.php?code=<?php echo $this->_tpl_vars['bookingData']['booking_code']; ?>
" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
				<p>This is where you will be generating the <span class="success">INVOICE</span>.</p>
				<div class="form-group">
				<?php if (isset ( $this->_tpl_vars['errorArray']['generate_invoice'] )): ?>
					<?php if ($this->_tpl_vars['errorArray']['generate_invoice'] == ''): ?>
						<p class="success">Invoice has been successfully generated</p>
					<?php else: ?>
						<p class="error"><?php echo $this->_tpl_vars['errorArray']['generate_invoice']; ?>
</p>
					<?php endif; ?>
				<?php endif; ?>			  
                </div>
                <div class="form-group">
					<label for="invoice_notes">Message / Note</label>
					<textarea id="invoice_notes" name="invoice_notes" class="form-control" rows="3"></textarea>
					<?php if (isset ( $this->_tpl_vars['errorArray']['invoice_notes'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['invoice_notes']; ?>
</span><?php endif; ?>
                </div>					
				<p class="error">To generate an invoice, please click on the below button</p><br />
                <div class="form-group"><button type="submit" class="btn btn-primary">Generate PDF</button></div>
				<?php if ($this->_tpl_vars['bookingData']['invoice_pdf'] != ''): ?>
					<p><a href="http://<?php echo $this->_tpl_vars['domainData']['campaign_domain']; ?>
<?php echo $this->_tpl_vars['bookingData']['invoice_pdf']; ?>
" target="_blank">Click here for the PDF</a></p>
				<?php else: ?>
					<p class="error">Invoice not yet generated.</p>
				<?php endif; ?>
				<input type="hidden" value="1" id="generate_invoice" name="generate_invoice" />
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
				<a class="list-group-item" href="/booking/details.php?code=<?php echo $this->_tpl_vars['bookingData']['booking_code']; ?>
">
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
				<a class="list-group-item" href="#">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Generate PDF Invoice
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>			
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

</html>