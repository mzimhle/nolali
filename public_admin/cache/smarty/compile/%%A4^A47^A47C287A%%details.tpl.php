<?php /* Smarty version 2.6.20, created on 2015-06-11 10:14:24
         compiled from website/administrator/details.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nolali - The Creative</title>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</head>
<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content agentType -->
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
			<li><a href="/website/administrator/" title="">Administrator</a></li>
			<li><?php if (isset ( $this->_tpl_vars['administratorData'] )): ?><?php echo $this->_tpl_vars['administratorData']['administrator_name']; ?>
 <?php echo $this->_tpl_vars['administratorData']['administrator_name']; ?>
<?php else: ?>Add an administrator<?php endif; ?></li>
        </ul>
	</div><!--breadcrumb--> 
	<div class="inner"> 
      <h2>Add / Edit Administrator</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/administrator/details.php<?php if (isset ( $this->_tpl_vars['administratorData'] )): ?>?code=<?php echo $this->_tpl_vars['administratorData']['administrator_code']; ?>
<?php endif; ?>" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
           <tr>
            <td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="administrator_name" id="administrator_name" value="<?php echo $this->_tpl_vars['administratorData']['administrator_name']; ?>
" size="30"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['administrator_name'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['administrator_name']; ?>
</em><?php endif; ?>
			</td>
            <td>
				<h4 class="error">Surname:</h4><br />
				<input type="text" name="administrator_surname" id="administrator_surname" value="<?php echo $this->_tpl_vars['administratorData']['administrator_surname']; ?>
" size="30"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['administrator_surname'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['administrator_surname']; ?>
</em><?php endif; ?>
			</td>
            <td>
				<h4 class="error">Email:</h4><br />
				<input type="text" name="administrator_email" id="administrator_email" value="<?php echo $this->_tpl_vars['administratorData']['administrator_email']; ?>
" size="30"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['administrator_email'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['administrator_email']; ?>
</em><?php endif; ?>
			</td>			
          </tr>
          <tr>		
            <td colspan="3">
				<h4 class="error">Cellphone:</h4><br />
				<input type="text" name="administrator_cellphone" id="administrator_cellphone" value="<?php echo $this->_tpl_vars['administratorData']['administrator_cellphone']; ?>
" size="30"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['administrator_cellphone'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['administrator_cellphone']; ?>
</em><?php endif; ?>
			</td>
          </tr>			  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="javascript:submitForm();" class="blue_button mrg_left_147 fl"><span>Update Administrator</span></a>   
        </div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
 </div> 	
<!-- End Content agentType -->
<?php echo '
<script type="text/javascript" language="javascript">
function submitForm() {
	document.forms.detailsForm.submit();		
}
</script>
'; ?>

 </div><!-- End Content agentType -->
 <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</div>
<!-- End Main Container -->
</body>
</html>