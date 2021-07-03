<?php /* Smarty version 2.6.20, created on 2015-05-22 13:12:10
         compiled from catalogue/invoice/generate.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'catalogue/invoice/generate.tpl', 39, false),)), $this); ?>
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
			<li><a href="/catalogue/invoice/">Invoice</a></li>
			<li><a href="#">REF#<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
 - <?php echo $this->_tpl_vars['invoiceData']['invoice_person_name']; ?>
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
              <form id="validate-basic" action="/catalogue/invoice/generate.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
				<p>This is where you will be generating the <span class="success"><?php echo $this->_tpl_vars['invoiceData']['invoice_make']; ?>
</span>.</p>
				<p><b><i><?php echo ((is_array($_tmp=@$this->_tpl_vars['invoiceData']['invoice_notes'])) ? $this->_run_mod_handler('default', true, $_tmp, "N / A") : smarty_modifier_default($_tmp, "N / A")); ?>
</i></b></p>
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
				<p class="error">To generate an invoice, please click on the below button</p><br />
                <div class="form-group"><button type="submit" class="btn btn-primary">Generate PDF</button></div>
				<?php if ($this->_tpl_vars['invoiceData']['invoice_pdf'] != ''): ?>
					<p><a href="http://<?php echo $this->_tpl_vars['domainData']['campaign_domain']; ?>
<?php echo $this->_tpl_vars['invoiceData']['invoice_pdf']; ?>
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
				<a href="/catalogue/invoice/" class="list-group-item">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="#">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 
				<a class="list-group-item" href="/catalogue/invoice/item.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Items
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/catalogue/invoice/payment.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
">
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
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</html>