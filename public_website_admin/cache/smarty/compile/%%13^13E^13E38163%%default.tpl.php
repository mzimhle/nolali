<?php /* Smarty version 2.6.20, created on 2015-05-26 16:30:21
         compiled from catalogue/item/default.tpl */ ?>
<!DOCTYPE html>
 Management System</title>
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

    foreach ($_from as $this->_tpl_vars['item']):
?>
/<?php echo $this->_tpl_vars['item']['productitemimage_path']; ?>
/tny_<?php echo $this->_tpl_vars['item']['productitemimage_code']; ?>
<?php echo $this->_tpl_vars['item']['productitemimage_extension']; ?>
">
/<?php echo $this->_tpl_vars['item']['productitemimage_path']; ?>
/tny_<?php echo $this->_tpl_vars['item']['productitemimage_code']; ?>
<?php echo $this->_tpl_vars['item']['productitemimage_extension']; ?>
" width="60" />
"><?php echo $this->_tpl_vars['item']['productitem_name']; ?>
</a></td>	
</td>	
', '', 'default'); return false;" class="btn btn-danger">Delete</button>
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
