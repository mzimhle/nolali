<?php
/* Smarty version 3.1.34-dev-7, created on 2022-09-06 22:31:05
  from 'C:\sites\nolali.loc\public_admin\default.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_6317ae0967ad99_98772633',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7873c8408829b9e72ce910df97fceb42872690f5' => 
    array (
      0 => 'C:\\sites\\nolali.loc\\public_admin\\default.tpl',
      1 => 1661366920,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6317ae0967ad99_98772633 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\sites\\nolali.loc\\public_admin\\library\\classes\\smarty\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),));
?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php include_once ('C:\sites\nolali.loc\public_admin\includes\meta.php');?>

    <!-- Meta -->
    <meta name="description" content="Share Manager">
    <meta name="author" content="Share Manager">
    <title>Share Manager</title>
  </head>
  <body class="dashboard-4">
	<?php include_once ('C:\sites\nolali.loc\public_admin\includes\header.php');?>

    <div class="slim-mainpanel">
      <div class="container pd-t-50">  
        <div class="row">
          <div class="col-lg-12">
            <h3 class="tx-inverse mg-b-15">Welcome back administrator!</h3>
            <p class="mg-b-20">Welcome to the Yam Accounting Solution backend system, here you will be able to over see all activities by all clients</p>
			<form action="/" method="POST">
				<div class="row">	
					<div class="col-sm-6">			  
						<div class="form-group has-error">
							<label for="account_id">Account</label>
							<select id="account_id" name="account_id" class="form-control is-invalid">
							<option value=""> -- Select an account -- </option>
							<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['accountPairs']->value,'selected'=>(($tmp = @$_smarty_tpl->tpl_vars['account']->value)===null||$tmp==='' ? '' : $tmp)),$_smarty_tpl);?>

							</select>
							<code>Please add the account of the entity</code>								
						</div>
					</div>						
					<div class="col-md-6">					
						<div class="form-group">
							<label>Select Entity</label>
							<select class="form-control" id="entity_id" name="entity_id">
								<option value=""> --- Select an entity --- </option>
							</select>
						</div>
					</div>				
				</div>
				<div class="form-actions text-left">
					<input type="submit" value="Select" class="btn btn-primary" />
				</div>	
			</form>			
          </div><!-- col-6 -->
        </div><!-- row -->	
		<hr />
		</div><!-- container -->
    </div><!-- slim-mainpanel -->
	<?php include_once ('C:\sites\nolali.loc\public_admin\includes\footer.php');?>

	
	<?php echo '<script'; ?>
 type="text/javascript">
		$(document).ready(function() {
			changeEntity();
			$("#account_id").change(function() {
				changeEntity();
			});			
		});

		function changeEntity() {
			$.ajax({
				type: "GET",
				url: "default.php",
				data: "getentity="+$('#account_id').val(),
				dataType: "html",
				success: function(html){
					$('#entity_id').html(html);
				}
			});
		}
	<?php echo '</script'; ?>
>
	
  </body>
</html>
<?php }
}
