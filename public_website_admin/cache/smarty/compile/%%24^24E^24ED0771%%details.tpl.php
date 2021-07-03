<?php /* Smarty version 2.6.20, created on 2015-05-22 12:54:19
         compiled from catalogue/invoice/details.tpl */ ?>
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
	<h2 class="content-header-title">Invoice</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/catalogue/">Catalogue</a></li>
	<li><a href="/catalogue/invoice/">Invoice</a></li>
	<li><a href="#"><?php if (isset ( $this->_tpl_vars['invoiceData'] )): ?>REF#<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
 - <?php echo $this->_tpl_vars['invoiceData']['invoice_person_name']; ?>
<?php else: ?>Add an invoice<?php endif; ?></a></li>
	<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					<?php if (isset ( $this->_tpl_vars['invoiceData'] )): ?>REF#<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
 - <?php echo $this->_tpl_vars['invoiceData']['invoice_person_name']; ?>
<?php else: ?>Add an invoice<?php endif; ?>
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/catalogue/invoice/details.php<?php if (isset ( $this->_tpl_vars['invoiceData'] )): ?>?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
<?php endif; ?>" method="POST" data-validate="parsley" class="form parsley-form">
                <div class="form-group">
                  <label for="invoice_person_name">Fullname</label>
                  <input type="text" id="invoice_person_name" name="invoice_person_name" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['invoiceData']['invoice_person_name']; ?>
" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['invoice_person_name'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['invoice_person_name']; ?>
</span><?php endif; ?>					  
                </div>
                <div class="form-group">
                  <label for="invoice_person_email">Email Address</label>
                  <input type="text" id="invoice_person_email" name="invoice_person_email" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['invoiceData']['invoice_person_email']; ?>
" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['invoice_person_email'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['invoice_person_email']; ?>
</span><?php endif; ?>					  
                </div>
                <div class="form-group">
                  <label for="invoice_person_number">Cellphone / Telephone Number</label>
                  <input type="text" id="invoice_person_number" name="invoice_person_number" class="form-control" value="<?php echo $this->_tpl_vars['invoiceData']['invoice_person_number']; ?>
" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['invoice_person_number'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['invoice_person_number']; ?>
</span><?php endif; ?>					  
                </div>
                <div class="form-group">
                  <label for="invoice_make">Type / Make</label>
				<select id="invoice_make" name="invoice_make" class="form-control"  data-required="true" >
					<option value=""> ---------------- </option>
					<option value="ESTIMATE" <?php if ($this->_tpl_vars['invoiceData']['invoice_make'] == 'ESTIMATE'): ?>SELECTED<?php endif; ?>> Cost Estimate </option>
					<option value="INVOICE" <?php if ($this->_tpl_vars['invoiceData']['invoice_make'] == 'INVOICE'): ?>SELECTED<?php endif; ?>> Invoice </option>
					<option value="QUOTATION" <?php if ($this->_tpl_vars['invoiceData']['invoice_make'] == 'QUOTATION'): ?>SELECTED<?php endif; ?>> Quotation </option>
				</select>
				<?php if (isset ( $this->_tpl_vars['errorArray']['invoice_make'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['invoice_make']; ?>
</span><?php endif; ?>					  
                </div>			
                <div class="form-group">
					<label for="invoice_notes">Message / Note</label>
					<textarea id="invoice_notes" name="invoice_notes" class="form-control" rows="3"><?php echo $this->_tpl_vars['invoiceData']['invoice_notes']; ?>
</textarea>
					<?php if (isset ( $this->_tpl_vars['errorArray']['invoice_notes'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['invoice_notes']; ?>
</span><?php endif; ?>					  
                </div>				
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->
		<div class="col-sm-3">
			<div class="list-group">  
				<a class="list-group-item" href="/catalogue/invoice/">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<?php if (isset ( $this->_tpl_vars['invoiceData'] )): ?>					
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
				<a class="list-group-item" href="/catalogue/invoice/generate.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Generate PDF
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

</html>