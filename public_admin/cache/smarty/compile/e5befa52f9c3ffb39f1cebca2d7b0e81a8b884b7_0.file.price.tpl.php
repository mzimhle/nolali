<?php
/* Smarty version 3.1.34-dev-7, created on 2022-09-06 22:15:44
  from 'C:\sites\nolali.loc\public_admin\product\price.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_6317aa7020ff53_65938759',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e5befa52f9c3ffb39f1cebca2d7b0e81a8b884b7' => 
    array (
      0 => 'C:\\sites\\nolali.loc\\public_admin\\product\\price.tpl',
      1 => 1662495338,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6317aa7020ff53_65938759 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php include_once ('C:\sites\nolali.loc\public_admin\includes\meta.php');?>
	
  </head>
  <body>
	<?php include_once ('C:\sites\nolali.loc\public_admin\includes\header.php');?>

    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
			<ol class="breadcrumb slim-breadcrumb">
			<li class="breadcrumb-item active" aria-current="page">Prices</li>
			<li class="breadcrumb-item"><a href="/product/details.php?id=<?php echo $_smarty_tpl->tpl_vars['productData']->value['product_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['productData']->value['product_name'];?>
</a></li>
			<li class="breadcrumb-item"><a href="/product/">Products</a></li>	
			<li class="breadcrumb-item"><a href="/"><?php echo $_smarty_tpl->tpl_vars['activeAccount']->value['account_name'];?>
</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Products</h6>
        </div><!-- slim-pageheader -->
		<ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/product/details.php?id=<?php echo $_smarty_tpl->tpl_vars['productData']->value['product_id'];?>
" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/product/price.php?id=<?php echo $_smarty_tpl->tpl_vars['productData']->value['product_id'];?>
" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Price</a>
			</li>
			<li class="nav-item">
				<a href="/product/media.php?id=<?php echo $_smarty_tpl->tpl_vars['productData']->value['product_id'];?>
" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Media</a>
			</li>            
		</ul><br />	
        <div class="section-wrapper">
			<label class="section-title">Add price for <?php echo $_smarty_tpl->tpl_vars['productData']->value['product_name'];?>
</label>
			<p class="mg-b-20 mg-sm-b-10">Below is the list of prices for the product</p>		
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            <?php if (isset($_smarty_tpl->tpl_vars['errors']->value)) {?><div class="alert alert-danger" role="alert"><strong><?php echo $_smarty_tpl->tpl_vars['errors']->value;?>
</strong></div><?php }?>
			<form action="/product/price.php?id=<?php echo $_smarty_tpl->tpl_vars['productData']->value['product_id'];?>
" method="POST">
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>Name</td>	
                            <td>Type</td>	
                            <td>Original Price</td>	                            
							<td>Discount</td>
							<td>Amount</td>
							<td width="5%">Quantity</td>
							<td>Start Date</td>
							<td>End Date</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php if (isset($_smarty_tpl->tpl_vars['priceData']->value)) {?>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['priceData']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
						<tr>
                            <td <?php if ($_smarty_tpl->tpl_vars['item']->value['price_active'] == '1') {?>class="success"<?php } else { ?>class="error"<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['price_name'];?>
</td>
                            <td <?php if ($_smarty_tpl->tpl_vars['item']->value['price_active'] == '1') {?>class="success"<?php } else { ?>class="error"<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['price_type'];?>
</td>
							<td <?php if ($_smarty_tpl->tpl_vars['item']->value['price_active'] == '1') {?>class="success"<?php } else { ?>class="error"<?php }?>>R <?php echo number_format($_smarty_tpl->tpl_vars['item']->value['price_original'],2,".",",");?>
</td>
							<td <?php if ($_smarty_tpl->tpl_vars['item']->value['price_active'] == '1') {?>class="success"<?php } else { ?>class="error"<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['price_discount'];?>
%</td>
							<td <?php if ($_smarty_tpl->tpl_vars['item']->value['price_active'] == '1') {?>class="success"<?php } else { ?>class="error"<?php }?>>R <?php echo number_format($_smarty_tpl->tpl_vars['item']->value['price_amount'],2,".",",");?>
</td>
							<td <?php if ($_smarty_tpl->tpl_vars['item']->value['price_active'] == '1') {?>class="success"<?php } else { ?>class="error"<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['price_quantity'];?>
</td>
							<td <?php if ($_smarty_tpl->tpl_vars['item']->value['price_active'] == '1') {?>class="success"<?php } else { ?>class="error"<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['price_added'];?>
</td>
							<td <?php if ($_smarty_tpl->tpl_vars['item']->value['price_active'] == '1') {?>class="success"<?php } else { ?>class="error"<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['price_date_end'];?>
</td>
							<td <?php if ($_smarty_tpl->tpl_vars['item']->value['price_active'] == '1') {?>class="success"<?php } else { ?>class="error"<?php }?>><?php if ($_smarty_tpl->tpl_vars['item']->value['price_active'] == '1') {?><button class="btn" onclick="deleteModal('<?php echo $_smarty_tpl->tpl_vars['item']->value['price_id'];?>
', '<?php echo $_smarty_tpl->tpl_vars['productData']->value['product_id'];?>
', 'price'); return false;">Deactivate</button><?php } else { ?>N / A<?php }?></td>
						</tr>			     					
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					<?php } else { ?>
						<tr>
							<td align="center" colspan="8">There are currently no items</td>
						</tr>	
					<?php }?>						
					</tbody>					  
				</table>
				<br />
				<p>Add new price below</p>	
				<div class="row">
					<div class="col-sm-6">	
						<div class="form-group">
							<label for="price_name">Name</label>
							<input type="text" id="price_name" name="price_name" size="20" class="form-control" value="" />
							<span class="help-block text">Name of the price</span>	
						</div>	
					</div>					
					<div class="col-sm-6">	
						<div class="form-group">
							<label for="price_type">Type of payment is this</label>
							<select id="price_type" name="price_type" class="form-control">
                                <option value="ONCOFF"> Once Off </option>
                                <option value="MONTHLY"> Monthly </option>
                            </select>
							<span class="help-block text">Select the type of price this is</span>	
						</div>	
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-4">				
						<div class="form-group has-error">
							<label for="price_original">Price</label>
							<input type="text" id="price_original" name="price_original"  size="20" class="form-control" data-required="true"  />
							<span class="help-block text">Please add only number separated by a period ( . ) for cents.</span>	
						</div>
					</div>
					<div class="col-sm-4">	
						<div class="form-group has-error">
							<label for="price_quantity">Number of items</label>
							<input type="text" id="price_quantity" name="price_quantity"  size="20" class="form-control" data-required="true" value="1" />
							<span class="help-block text">Add the number of items for this amount</span>	
						</div>	
					</div>					
					<div class="col-sm-4">	
						<div class="form-group has-error">
							<label for="price_discount">Discount in percentage (%)</label>
							<input type="text" id="price_discount" name="price_discount"  size="20" class="form-control" data-required="true" value="0" />
							<span class="help-block text">This needs to be between 0 and 100</span>	
						</div>	
					</div>
				</div>                
				<div class="row">
					<div class="col-md-6">	
						<div class="form-actions text">
							<input type="submit" value="Add" class="btn btn-primary">
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

  </body>
</html>
<?php }
}
