<?php
/* Smarty version 3.1.34-dev-7, created on 2022-09-05 19:20:34
  from 'C:\sites\nolali.loc\public_admin\content\announcement\details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_63162fe26e9665_47651538',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5b9d36efd0447b9b1652aedf667bb8cb9e6faa16' => 
    array (
      0 => 'C:\\sites\\nolali.loc\\public_admin\\content\\announcement\\details.tpl',
      1 => 1661979040,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63162fe26e9665_47651538 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\sites\\nolali.loc\\public_admin\\library\\classes\\smarty\\plugins\\modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
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
			<?php if (isset($_smarty_tpl->tpl_vars['contentData']->value)) {?>
			<li class="breadcrumb-item active" aria-current="page">Edit</li>
			<li class="breadcrumb-item"><?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_name'];?>
</li>
			<?php } else { ?>
			<li class="breadcrumb-item active" aria-current="page">Add</li>
			<?php }?>			
			<li class="breadcrumb-item"><a href="/">Announcement</a></li>	
			<li class="breadcrumb-item"><a href="/"><?php echo $_smarty_tpl->tpl_vars['activeEntity']->value['entity_name'];?>
</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Announcement</h6>
        </div><!-- slim-pageheader -->
        <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value)) {?>
		<ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/content/announcement/details.php?id=<?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_id'];?>
" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/content/announcement/media.php?id=<?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_id'];?>
" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Media</a>
			</li>		
		</ul><br />
        <?php }?>		
        <div class="section-wrapper">
			<label class="section-title"><?php if (isset($_smarty_tpl->tpl_vars['contentData']->value)) {?>Update <?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_name'];
} else { ?>Add new content<?php }?></label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the announcement</p>				
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            <?php if (isset($_smarty_tpl->tpl_vars['errors']->value)) {?><div class="alert alert-danger" role="alert"><strong><?php echo $_smarty_tpl->tpl_vars['errors']->value;?>
</strong></div><?php }?>				
            <form action="/content/announcement/details.php<?php if (isset($_smarty_tpl->tpl_vars['contentData']->value)) {?>?id=<?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_id'];
}?>" method="POST">
                <div class="row">					
                    <div class="col-sm-12">			  
                        <div class="form-group has-error">
                            <label for="content_name">Name</label>
                            <input type="text" id="content_name" name="content_name" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['contentData']->value)) {
echo $_smarty_tpl->tpl_vars['contentData']->value['content_name'];
}?>" />
                            <code>Please add the name of the announcement</code>									
                        </div>
                    </div>				
				</div>
                <div class="row">					
                    <div class="col-sm-6">			  
                        <div class="form-group has-error">
                            <label for="content_date_start">Start Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                    </div>
                                </div>                            
                            <input type="text" id="content_date_start" name="content_date_start" class="form-control" readonly value="<?php if (isset($_smarty_tpl->tpl_vars['contentData']->value)) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],"%Y-%m-%d");
}?>" />
                            </div>
                            <code>Please add the date for the announcement to show from</code>									
                        </div>
                    </div>	
                    <div class="col-sm-6">			  
                        <div class="form-group has-error">
                            <label for="content_date_end">End Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                    </div>
                                </div>                            
                            <input type="text" id="content_date_end" name="content_date_end" class="form-control" readonly value="<?php if (isset($_smarty_tpl->tpl_vars['contentData']->value)) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],"%Y-%m-%d");
}?>" />
                            </div>
                            <code>Please add the date for the announcement to end at</code>									
                        </div>
                    </div>	                    
				</div>                
				<div class="row">
                    <div class="col-sm-12">			  
                        <div class="form-group">
                            <label for="content_text">Description</label>
                            <textarea id="content_text" name="content_text" class="form-control wysihtml5" rows="20"><?php if (isset($_smarty_tpl->tpl_vars['contentData']->value)) {
echo $_smarty_tpl->tpl_vars['contentData']->value['content_text'];
}?></textarea>
                            <code>Add description of the content</code>									
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-actions text">
                            <input type="submit" value="<?php if (!isset($_smarty_tpl->tpl_vars['contentData']->value)) {?>Add<?php } else { ?>Update<?php }?>" class="btn btn-primary" />
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
        $('#content_text').summernote({
          height: 500,
          tooltip: false
        })
    });
        // Datepicker
        $('#content_date_start').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
		  dateFormat: 'yy-mm-dd',
		  minDate : 0
        });
        // Datepicker
        $('#content_date_end').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
		  dateFormat: 'yy-mm-dd',
		  minDate : 0
        });        
    <?php echo '</script'; ?>
>
    	
  </body>
</html>
<?php }
}
