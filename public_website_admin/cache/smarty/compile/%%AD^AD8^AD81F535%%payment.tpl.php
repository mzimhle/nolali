<?php /* Smarty version 2.6.20, created on 2015-05-22 13:11:27
         compiled from catalogue/invoice/payment.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'catalogue/invoice/payment.tpl', 52, false),)), $this); ?>
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
			<li><a href="#">REF#<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
 - <?php echo $this->_tpl_vars['invoiceData']['invoice_person_name']; ?>
</a></li>
			<li class="active">Payments</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Payments List
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/catalogue/invoice/payment.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
				<p>Below is a list of payments under this invoice.</p>
				<table class="table table-bordered">	
					<thead>
					  <tr>				
						<th valign="top">Amount</th>
						<th valign="top">Date of payment</th>
						<th valign="top">Proof of payment</th>		
						<th valign="top"></th>
					  </tr>
					</thead>
					<tbody>
					<?php $_from = $this->_tpl_vars['invoicepaymentData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					  <tr>	
						<td valign="top">R <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['invoicepayment_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
						<td valign="top"><?php echo $this->_tpl_vars['item']['invoicepayment_paid_date']; ?>
</td>
						<td valign="top"><?php if ($this->_tpl_vars['item']['invoicepayment_file'] == ''): ?>N / A<?php else: ?><a href="http://<?php echo $this->_tpl_vars['domainData']['campaign_domain']; ?>
<?php echo $this->_tpl_vars['item']['invoicepayment_file']; ?>
" target="_blank">Download</a><?php endif; ?></td>					
						<td valign="top">
							<button value="Delete" class="btn btn-danger" onclick="deleteModal('<?php echo $this->_tpl_vars['item']['invoicepayment_code']; ?>
', '<?php echo $this->_tpl_vars['item']['invoice_code']; ?>
', 'payment'); return false;">Delete</button>
						</td>		
					  </tr>			     
					<?php endforeach; else: ?>
						<tr>
							<td align="center" colspan="6">There are currently no payments</td>
						</tr>					
					<?php endif; unset($_from); ?>
					</tbody>					  
				</table>
				<p>Add new payment below</p>
                <div class="form-group">
					<label for="invoicepayment_amount">Payment Amount</label>
					<input type="text" id="invoicepayment_amount" name="invoicepayment_amount" class="form-control" data-required="true" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['invoicepayment_amount'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['invoicepayment_amount']; ?>
</span><?php endif; ?>					  
                </div>
                <div class="form-group">
					<label for="">Date of payment</label>
					<input type="text" id="invoicepayment_paid_date" name="invoicepayment_paid_date" class="form-control" data-required="true" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['invoicepayment_paid_date'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['invoicepayment_paid_date']; ?>
</span><?php endif; ?>					  
                </div>
                <div class="form-group">
					<label for="invoicepayment_amount">Proof of payment file</label>
					<input type="file" name="paymentfile" id="paymentfile">
					<?php if (isset ( $this->_tpl_vars['errorArray']['paymentfile'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['paymentfile']; ?>
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
				<a class="list-group-item" href="/catalogue/invoice/details.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 
				<a class="list-group-item" href="/catalogue/invoice/payment.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Items
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="#">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Payments
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/catalogue/invoice/generate.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
">
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

<?php echo '
<script type="text/javascript">
jQuery(document).ready(function() {
	$( "#invoicepayment_paid_date" ).datepicker({
	  defaultDate: "+1w",
	  dateFormat: \'yy-mm-dd\',
	  changeMonth: true,
	  changeYear: true
	});
});
</script>
'; ?>

</html>