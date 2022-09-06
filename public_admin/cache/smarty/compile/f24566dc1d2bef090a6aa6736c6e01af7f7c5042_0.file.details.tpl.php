<?php
/* Smarty version 3.1.34-dev-7, created on 2022-09-06 22:10:38
  from 'C:\sites\nolali.loc\public_admin\product\details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_6317a93e878641_46098184',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f24566dc1d2bef090a6aa6736c6e01af7f7c5042' => 
    array (
      0 => 'C:\\sites\\nolali.loc\\public_admin\\product\\details.tpl',
      1 => 1662495036,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6317a93e878641_46098184 (Smarty_Internal_Template $_smarty_tpl) {
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
			<?php if (isset($_smarty_tpl->tpl_vars['productData']->value)) {?>
			<li class="breadcrumb-item active" aria-current="page">Edit</li>
			<li class="breadcrumb-item"><?php echo $_smarty_tpl->tpl_vars['productData']->value['product_name'];?>
</li>
			<?php } else { ?>
			<li class="breadcrumb-item active" aria-current="page">Add</li>
			<?php }?>			
			<li class="breadcrumb-item"><a href="/">Products</a></li>	
			<li class="breadcrumb-item"><a href="/"><?php echo $_smarty_tpl->tpl_vars['activeAccount']->value['account_name'];?>
</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">products</h6>
        </div><!-- slim-pageheader -->
        <?php if (isset($_smarty_tpl->tpl_vars['productData']->value)) {?>
		<ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/product/details.php?id=<?php echo $_smarty_tpl->tpl_vars['productData']->value['product_id'];?>
" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/product/price.php?id=<?php echo $_smarty_tpl->tpl_vars['productData']->value['product_id'];?>
" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Price</a>
			</li>		
		</ul><br />
        <?php }?>		
        <div class="section-wrapper">
			<label class="section-title"><?php if (isset($_smarty_tpl->tpl_vars['productData']->value)) {?>Update <?php echo $_smarty_tpl->tpl_vars['productData']->value['product_name'];
} else { ?>Add new product<?php }?></label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the product</p>				
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            <?php if (isset($_smarty_tpl->tpl_vars['errors']->value)) {?><div class="alert alert-danger" role="alert"><strong><?php echo $_smarty_tpl->tpl_vars['errors']->value;?>
</strong></div><?php }?>				
            <form action="/product/details.php<?php if (isset($_smarty_tpl->tpl_vars['productData']->value)) {?>?id=<?php echo $_smarty_tpl->tpl_vars['productData']->value['product_id'];
}?>" method="POST">
                <div class="row">	
                    <div class="col-sm-4">			  
                        <div class="form-group has-error">
                            <label for="product_type">Type</label>
                                <select type="text" id="product_type" name="product_type" class="form-control">
                                    <option value=""> --- Select --- </option>
                                    <option value="PRODUCT" <?php if (isset($_smarty_tpl->tpl_vars['productData']->value) && $_smarty_tpl->tpl_vars['productData']->value['product_type'] == 'PRODUCT') {?>selected<?php }?>> PRODUCT </option>
                                    <option value="SERVICE" <?php if (isset($_smarty_tpl->tpl_vars['productData']->value) && $_smarty_tpl->tpl_vars['productData']->value['product_type'] == 'SERVICE') {?>selected<?php }?>> SERVICE </option>
                                    <option value="BOOK"  <?php if (isset($_smarty_tpl->tpl_vars['productData']->value) && $_smarty_tpl->tpl_vars['productData']->value['product_type'] == 'BOOK') {?>selected<?php }?>> BOOKING </option>
                                    <option value="CATALOG"  <?php if (isset($_smarty_tpl->tpl_vars['productData']->value) && $_smarty_tpl->tpl_vars['productData']->value['product_type'] == 'CATALOG') {?>selected<?php }?>> CATALOG </option>
                                </select>
                            <code>Please add the name of the product</code>									
                        </div>
                    </div>				
                    <div class="col-sm-8">			  
                        <div class="form-group has-error">
                            <label for="product_name">Name</label>
                            <input type="text" id="product_name" name="product_name" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['productData']->value)) {
echo $_smarty_tpl->tpl_vars['productData']->value['product_name'];
}?>" />
                            <code>Please add the name of the product</code>									
                        </div>
                    </div>				
				</div>
				<div class="row">
                    <div class="col-sm-12">			  
                        <div class="form-group">
                            <label for="product_text">Description</label>
                            <textarea id="product_text" name="product_text" class="form-control wysihtml5" rows="5"><?php if (isset($_smarty_tpl->tpl_vars['productData']->value)) {
echo $_smarty_tpl->tpl_vars['productData']->value['product_text'];
}?></textarea>
                            <code>Add description of the product</code>									
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-actions text">
                            <input type="submit" value="<?php if (!isset($_smarty_tpl->tpl_vars['productData']->value)) {?>Add<?php } else { ?>Update<?php }?>" class="btn btn-primary" />
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
 src="/library/javascript/summernote-0.8.18-dist/summernote-bs4.min.js"><?php echo '</script'; ?>
>
    
    <?php echo '<script'; ?>
 type="text/javascript">
    $(document).ready(function() {
        // Summernote editor
        $('#product_text').summernote({
          height: 150,
          tooltip: false
        })
    });
    <?php echo '</script'; ?>
>
    	
  </body>
</html>
<?php }
}
