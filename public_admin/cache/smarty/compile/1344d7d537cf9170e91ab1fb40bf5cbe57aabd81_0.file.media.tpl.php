<?php
/* Smarty version 3.1.34-dev-7, created on 2022-09-05 20:41:48
  from 'C:\sites\nolali.loc\public_admin\content\event\media.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_631642ecc1eef7_57417395',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1344d7d537cf9170e91ab1fb40bf5cbe57aabd81' => 
    array (
      0 => 'C:\\sites\\nolali.loc\\public_admin\\content\\event\\media.tpl',
      1 => 1661979276,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_631642ecc1eef7_57417395 (Smarty_Internal_Template $_smarty_tpl) {
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
			<li class="breadcrumb-item active" aria-current="page">Images</li>
			<li class="breadcrumb-item"><a href="/content/event/details.php?id=<?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_name'];?>
</a></li>
			<li class="breadcrumb-item"><a href="/content/event/">Event</a></li>
            <li class="breadcrumb-item"><a href="/content/event/">Content</a></li>            
			<li class="breadcrumb-item"><a href="/"><?php echo $_smarty_tpl->tpl_vars['activeAccount']->value['account_name'];?>
</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Event</h6>
        </div><!-- slim-pageheader -->
		<ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/content/event/details.php?id=<?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_id'];?>
" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/content/event/price.php?id=<?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_id'];?>
" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Media</a>
			</li>		
		</ul><br />	
        <div class="section-wrapper">
          <label class="section-title">Images for  <?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_name'];?>
</label>	
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            <?php if (isset($_smarty_tpl->tpl_vars['errors']->value)) {?><div class="alert alert-danger" role="alert"><strong><?php echo $_smarty_tpl->tpl_vars['errors']->value;?>
</strong></div><?php }?>
			<form action="/content/event/media.php?id=<?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_id'];?>
" method="POST" enctype="multipart/form-data">
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td></td>	
							<td></td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php if (isset($_smarty_tpl->tpl_vars['mediaData']->value)) {?>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['mediaData']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
						<tr>
                            <td><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['site'];
echo $_smarty_tpl->tpl_vars['item']->value['media_path'];?>
tny_<?php echo $_smarty_tpl->tpl_vars['item']->value['media_code'];
echo $_smarty_tpl->tpl_vars['item']->value['media_ext'];?>
" width="40%" /></td>
							<td><?php if ($_smarty_tpl->tpl_vars['item']->value['media_primary'] == '0') {?><button class="btn" onclick="deleteModal('<?php echo $_smarty_tpl->tpl_vars['item']->value['media_id'];?>
', '<?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_id'];?>
', 'media'); return false;">Delete</button><?php } else { ?>N / A<?php }?></td>
							<td><?php if ($_smarty_tpl->tpl_vars['item']->value['media_primary'] == '0') {?><button class="btn" onclick="statusSubModal('<?php echo $_smarty_tpl->tpl_vars['item']->value['media_id'];?>
', '0', 'media', '<?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_id'];?>
'); return false;">Primary</button><?php } else { ?>N / A<?php }?></td>
						</tr>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					<?php } else { ?>
						<tr>
							<td align="center" colspan="3">There are currently no images</td>
						</tr>	
					<?php }?>						
					</tbody>					  
				</table>
				<div class="row">					
					<div class="col-sm-12">	
						<div class="form-group has-error">
							<label for="price_discount">Upload Image(s)</label><br />
							<input type="file" id="mediafiles[]" name="mediafiles[]" multiple /><br />
							<span class="help-block text">Please only upload <b>.jpg</b>, <b>.jpeg</b> and <b>.png</b></span>	
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
