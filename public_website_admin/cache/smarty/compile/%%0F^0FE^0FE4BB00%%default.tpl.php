<?php /* Smarty version 2.6.20, created on 2015-05-26 16:30:15
         compiled from catalogue/product/default.tpl */ ?>
<!DOCTYPE html>
 Management System</title>
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

    foreach ($_from as $this->_tpl_vars['item']):
?>
/<?php echo $this->_tpl_vars['item']['productimage_path']; ?>
/big_<?php echo $this->_tpl_vars['item']['productimage_code']; ?>
<?php echo $this->_tpl_vars['item']['productimage_extension']; ?>
" target="_blank">
/<?php echo $this->_tpl_vars['item']['productimage_path']; ?>
/tny_<?php echo $this->_tpl_vars['item']['productimage_code']; ?>
<?php echo $this->_tpl_vars['item']['productimage_extension']; ?>
" width="60" />
"><?php echo $this->_tpl_vars['item']['product_name']; ?>
</a></td>	
</td>	
', '', 'default'); return false;" class="btn btn-danger">Delete</button>
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
