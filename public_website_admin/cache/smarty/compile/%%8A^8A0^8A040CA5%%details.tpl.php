<?php /* Smarty version 2.6.20, created on 2015-05-17 12:21:45
         compiled from website/invoice/details.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nolali - The Creative</title>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<script type="text/javascript" language="javascript" src="default.js"></script>
</head>
<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content recruiter -->
  <div id="content">
    <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

  	<br />
	<div id="breadcrumb">
        <ul>
            <li><a href="/" title="Home">Home</a></li>
			<li><a href="/website/" title="Website">Website</a></li>
			<li><a href="#" title="Website"><span class="success"><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
</span></a></li>
			<li><a href="/website/invoice/" title="">Invoice</a></li>
			<li><?php if (isset ( $this->_tpl_vars['invoiceData'] )): ?>REF#<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
<?php else: ?>Add an invoice<?php endif; ?></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2><?php if (isset ( $this->_tpl_vars['invoiceData'] )): ?>Edit Campaign Invoice<?php else: ?>Add a Campaign Invoice<?php endif; ?></h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="<?php if (isset ( $this->_tpl_vars['invoiceData'] )): ?>/website/invoice/item.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
<?php else: ?>#<?php endif; ?>" title="Items">Items</a></li>
			<li><a href="<?php if (isset ( $this->_tpl_vars['invoiceData'] )): ?>/website/invoice/payment.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
<?php else: ?>#<?php endif; ?>" title="Payment">Payments</a></li>
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/invoice/details.php<?php if (isset ( $this->_tpl_vars['invoiceData'] )): ?>?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
<?php endif; ?>" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form"> 		  
          <tr>
            <td class="left_col error">
				<h4>Full name:</h4><br />
				<input type="text" name="invoice_person_name" id="invoice_person_name" value="<?php echo $this->_tpl_vars['invoiceData']['invoice_person_name']; ?>
" size="40"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['invoice_person_name'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['invoice_person_name']; ?>
</em><?php endif; ?>
			</td>
            <td class="left_col error">
				<h4>Emal address:</h4><br />
				<input type="text" name="invoice_person_email" id="invoice_person_email" value="<?php echo $this->_tpl_vars['invoiceData']['invoice_person_email']; ?>
" size="40"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['invoice_person_email'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['invoice_person_email']; ?>
</em><?php endif; ?>
			</td>
            <td class="left_col">
				<h4>Number:</h4><br />
				<input type="text" name="invoice_person_number" id="invoice_person_number" value="<?php echo $this->_tpl_vars['invoiceData']['invoice_person_number']; ?>
" size="40"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['invoice_person_number'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['invoice_person_number']; ?>
</em><?php endif; ?>
			</td>				
          </tr>		
          <tr>
            <td class="left_col error" valign="top">
				<h4>Make:</h4><br />
				<select id="invoice_make" name="invoice_make">
					<option value=""> ---------------- </option>
					<option value="ESTIMATE" <?php if ($this->_tpl_vars['invoiceData']['invoice_make'] == 'ESTIMATE'): ?>SELECTED<?php endif; ?>> Cost Estimate </option>
					<option value="INVOICE" <?php if ($this->_tpl_vars['invoiceData']['invoice_make'] == 'INVOICE'): ?>SELECTED<?php endif; ?>> Invoice </option>
					<option value="QUOTATION" <?php if ($this->_tpl_vars['invoiceData']['invoice_make'] == 'QUOTATION'): ?>SELECTED<?php endif; ?>> Quotation </option>
				</select>
				<?php if (isset ( $this->_tpl_vars['errorArray']['invoice_make'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['invoice_make']; ?>
</em><?php endif; ?>
			</td>
			<td class="left_col" colspan="2">
				<h4>Notes:</h4><br />
				<textarea name="invoice_notes" id="invoice_notes" rows="3" cols="80"><?php echo $this->_tpl_vars['invoiceData']['invoice_notes']; ?>
</textarea>
			</td>				
          </tr>
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="javascript:submitForm();" class="blue_button mrg_left_147 fl"><span>Save &amp; Complete</span></a>   
        </div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
 </div> 	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</div>
<?php echo '
<script type="text/javascript" language="javascript">
function submitForm() {
	document.forms.detailsForm.submit();					 
}
</script>
'; ?>

<!-- End Main Container -->
</body>
</html>