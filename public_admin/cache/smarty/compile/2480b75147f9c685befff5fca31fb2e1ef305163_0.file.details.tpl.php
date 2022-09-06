<?php
/* Smarty version 3.1.34-dev-7, created on 2022-09-06 21:54:01
  from 'C:\sites\nolali.loc\public_admin\entity\details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_6317a5598df807_23333355',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2480b75147f9c685befff5fca31fb2e1ef305163' => 
    array (
      0 => 'C:\\sites\\nolali.loc\\public_admin\\entity\\details.tpl',
      1 => 1661273684,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6317a5598df807_23333355 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\sites\\nolali.loc\\public_admin\\library\\classes\\smarty\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),));
?>

<!DOCTYPE html>
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
			<?php if (isset($_smarty_tpl->tpl_vars['entityData']->value)) {?>
			<li class="breadcrumb-item active" aria-current="page">Details</li>
			<li class="breadcrumb-item"><?php echo $_smarty_tpl->tpl_vars['entityData']->value['entity_name'];?>
</li>
			<?php } else { ?>
			<li class="breadcrumb-item active" aria-current="page">Add entity</li>
			<?php }?>
			<li class="breadcrumb-item"><a href="/entity/">Entities</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Entities</h6>
        </div><!-- slim-pageheader -->
        <?php if (isset($_smarty_tpl->tpl_vars['entityData']->value)) {?>
        <ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/entity/details.php?id=<?php echo $_smarty_tpl->tpl_vars['entityData']->value['entity_id'];?>
" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/entity/map/?id=<?php echo $_smarty_tpl->tpl_vars['entityData']->value['entity_id'];?>
" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> MAP</a>
			</li>	  
        </ul>
        <?php }?>
        <div class="section-wrapper card card-latest-activity mg-t-20">
			<label class="section-title"><?php if (isset($_smarty_tpl->tpl_vars['entityData']->value)) {?>Update <?php echo $_smarty_tpl->tpl_vars['entityData']->value['entity_name'];
} else { ?>Add new entity<?php }?></label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the entity</p>		
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            <?php if (isset($_smarty_tpl->tpl_vars['errors']->value)) {?><div class="alert alert-danger" role="alert"><strong><?php echo $_smarty_tpl->tpl_vars['errors']->value;?>
</strong></div><?php }?>				
                <form action="/entity/details.php<?php if (isset($_smarty_tpl->tpl_vars['entityData']->value)) {?>?id=<?php echo $_smarty_tpl->tpl_vars['entityData']->value['entity_id'];
}?>" method="POST">
                    <div class="row">
                        <div class="col-sm-12">			  
                            <div class="form-group has-error">
								<label for="account_id">Account</label>
								<select id="account_id" name="account_id" class="form-control is-invalid">
								<option value=""> -- Select an account -- </option>
								<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['accountPairs']->value,'selected'=>(($tmp = @$_smarty_tpl->tpl_vars['entityData']->value['account_id'])===null||$tmp==='' ? '' : $tmp)),$_smarty_tpl);?>

								</select>
								<code>Please add the account of the entity</code>								
                            </div>
                        </div>						
                    </div>				
                    <div class="row">
                        <div class="col-sm-4">			  
                            <div class="form-group has-error">
                                <label for="entity_name">Name</label>
                                <input type="text" id="entity_name" name="entity_name" class="form-control is-invalid" value="<?php if (isset($_smarty_tpl->tpl_vars['entityData']->value)) {
echo $_smarty_tpl->tpl_vars['entityData']->value['entity_name'];
}?>" />
                                <code>Please add the name</code>								
                            </div>
                        </div>
                        <div class="col-sm-4">			  
                            <div class="form-group has-error">
                                <label for="entity_contact_email">Email Address</label>
                                <input type="text" id="entity_contact_email" name="entity_contact_email" class="form-control is-invalid" value="<?php if (isset($_smarty_tpl->tpl_vars['entityData']->value)) {
echo $_smarty_tpl->tpl_vars['entityData']->value['entity_contact_email'];
}?>" />
                                <code>Please add the email address</code>								
                            </div>
                        </div>
                        <div class="col-sm-4">			  
                            <div class="form-group has-error">
                                <label for="entity_contact_cellphone">Cellphone Number</label>
                                <input type="text" id="entity_contact_cellphone" name="entity_contact_cellphone" class="form-control is-invalid" value="<?php if (isset($_smarty_tpl->tpl_vars['entityData']->value)) {
echo $_smarty_tpl->tpl_vars['entityData']->value['entity_contact_cellphone'];
}?>" />
                                <code>Please add the cellphone number</code>								
                            </div>
                        </div>							
                    </div>
                    <div class="row">
                        <div class="col-sm-4">			  
                            <div class="form-group">
                                <label for="entity_url">Website</label>
                                <input type="text" id="entity_url" name="entity_url" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['entityData']->value)) {
echo $_smarty_tpl->tpl_vars['entityData']->value['entity_url'];
}?>" />
                                <code>Please add the website</code>								
                            </div>
                        </div>
                        <div class="col-sm-4">			  
                            <div class="form-group">
                                <label for="entity_map_latitude">Map Latitude</label>
                                <input type="text" id="entity_map_latitude" name="entity_map_latitude" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['entityData']->value)) {
echo $_smarty_tpl->tpl_vars['entityData']->value['entity_map_latitude'];
}?>" />
                                <code>Please add the latitude</code>								
                            </div>
                        </div>
                        <div class="col-sm-4">			  
                            <div class="form-group">
                                <label for="entity_map_longitude">Map Longitude </label>
                                <input type="text" id="entity_map_longitude" name="entity_map_longitude" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['entityData']->value)) {
echo $_smarty_tpl->tpl_vars['entityData']->value['entity_map_longitude'];
}?>" />
                                <code>Please add the longitude</code>								
                            </div>
                        </div>							
                    </div>
                    <div class="row">
                        <div class="col-sm-12">			  
                            <div class="form-group has-error">
                                <label for="entity_address_physical">Physical Address</label>
                                <input type="text" id="entity_address_physical" name="entity_address_physical" class="form-control is-invalid" value="<?php if (isset($_smarty_tpl->tpl_vars['entityData']->value)) {
echo $_smarty_tpl->tpl_vars['entityData']->value['entity_address_physical'];
}?>" />
                                <code>Please add the physical address</code>								
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">			  
                            <div class="form-group">
                                <label for="entity_address_postal">Postal Address</label>
                                <input type="text" id="entity_address_postal" name="entity_address_postal" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['entityData']->value)) {
echo $_smarty_tpl->tpl_vars['entityData']->value['entity_address_postal'];
}?>" />
                                <code>Please add the postal address</code>								
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">			  
                            <div class="form-group">
                                <label for="entity_number_registration">CIPRO Registration Number</label>
                                <input type="text" id="entity_number_registration" name="entity_number_registration" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['entityData']->value)) {
echo $_smarty_tpl->tpl_vars['entityData']->value['entity_number_registration'];
}?>" />
                                <code>Please add the registration number</code>								
                            </div>
                        </div>
                        <div class="col-sm-4">			  
                            <div class="form-group">
                                <label for="entity_number_tax">Tax Number</label>
                                <input type="text" id="entity_number_tax" name="entity_number_tax" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['entityData']->value)) {
echo $_smarty_tpl->tpl_vars['entityData']->value['entity_number_tax'];
}?>" />
                                <code>Please add the tax number</code>								
                            </div>
                        </div>
                        <div class="col-sm-4">			  
                            <div class="form-group">
                                <label for="entity_number_vat">Vat Number</label>
                                <input type="text" id="entity_number_vat" name="entity_number_vat" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['entityData']->value)) {
echo $_smarty_tpl->tpl_vars['entityData']->value['entity_number_vat'];
}?>" />
                                <code>Please add the vat number</code>								
                            </div>
                        </div>							
                    </div>
                    <div class="row">
                        <div class="col-md-6">	
                            <div class="form-actions text">
                                <input type="submit" value="<?php if (!isset($_smarty_tpl->tpl_vars['entityData']->value)) {?>Add<?php } else { ?>Update<?php }?>" class="btn btn-primary">
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
