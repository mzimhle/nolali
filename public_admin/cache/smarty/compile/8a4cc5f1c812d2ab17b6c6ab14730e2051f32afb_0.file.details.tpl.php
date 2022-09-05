<?php
/* Smarty version 3.1.34-dev-7, created on 2022-09-05 20:39:45
  from 'C:\sites\nolali.loc\public_admin\content\event\details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_63164271a148d2_27934518',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8a4cc5f1c812d2ab17b6c6ab14730e2051f32afb' => 
    array (
      0 => 'C:\\sites\\nolali.loc\\public_admin\\content\\event\\details.tpl',
      1 => 1662403181,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63164271a148d2_27934518 (Smarty_Internal_Template $_smarty_tpl) {
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
			<li class="breadcrumb-item"><a href="/">Event</a></li>	
			<li class="breadcrumb-item"><a href="/"><?php echo $_smarty_tpl->tpl_vars['activeEntity']->value['entity_name'];?>
</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Event</h6>
        </div><!-- slim-pageheader -->
        <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value)) {?>
		<ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/content/event/details.php?id=<?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_id'];?>
" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/content/event/media.php?id=<?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_id'];?>
" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Media</a>
			</li>		
		</ul><br />
        <?php }?>		
        <div class="section-wrapper">
			<label class="section-title"><?php if (isset($_smarty_tpl->tpl_vars['contentData']->value)) {?>Update <?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_name'];
} else { ?>Add new content<?php }?></label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the event</p>				
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            <?php if (isset($_smarty_tpl->tpl_vars['errors']->value)) {?><div class="alert alert-danger" role="alert"><strong><?php echo $_smarty_tpl->tpl_vars['errors']->value;?>
</strong></div><?php }?>				
            <form action="/content/event/details.php<?php if (isset($_smarty_tpl->tpl_vars['contentData']->value)) {?>?id=<?php echo $_smarty_tpl->tpl_vars['contentData']->value['content_id'];
}?>" method="POST">
                <div class="row">					
                    <div class="col-sm-12">			  
                        <div class="form-group has-error">
                            <label for="content_name">Name</label>
                            <input type="text" id="content_name" name="content_name" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['contentData']->value)) {
echo $_smarty_tpl->tpl_vars['contentData']->value['content_name'];
}?>" />
                            <code>Please add the name of the event</code>									
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
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%Y-%m-%d');
}?>" />
                            </div>
                            <code>Please add the date for the event to show from</code>									
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
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%Y-%m-%d');
}?>" />
                            </div>
                            <code>Please add the date for the event to end at</code>									
                        </div>
                    </div>	                    
				</div>     
                <div class="row">					
                    <div class="col-sm-6">			  
                        <div class="form-group has-error">
                            <label for="content_time_start">Start Time</label>     
                            <select id="content_time_start" name="content_time_start" class="form-control">
                            <option value=""> --- Choose start time --- </option>
                            <option value="08:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '08:00') {?>selected<?php }?>> 08:00 </option>
                            <option value="08:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '08:30') {?>selected<?php }?>> 08:30 </option>
                            <option value="09:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '09:00') {?>selected<?php }?>> 09:00 </option>
                            <option value="09:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '09:30') {?>selected<?php }?>> 09:30 </option>
                            <option value="10:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '10:00') {?>selected<?php }?>> 10:00 </option>                           
                            <option value="10:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '10:30') {?>selected<?php }?>> 10:30 </option>
                            <option value="11:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '11:00') {?>selected<?php }?>> 11:00 </option>
                            <option value="11:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '11:30') {?>selected<?php }?>> 11:30 </option>
                            <option value="12:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '12:00') {?>selected<?php }?>> 12:00 </option>
                            <option value="12:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '12:30') {?>selected<?php }?>> 12:30 </option>
                            <option value="13:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '13:00') {?>selected<?php }?>> 13:00 </option>
                            <option value="13:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '13:30') {?>selected<?php }?>> 13:30 </option>
                            <option value="14:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '14:00') {?>selected<?php }?>> 14:00 </option>
                            <option value="14:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '14:30') {?>selected<?php }?>> 14:30 </option>
                            <option value="15:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '15:00') {?>selected<?php }?>> 15:00 </option>
                            <option value="15:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '15:30') {?>selected<?php }?>> 15:30 </option>
                            <option value="16:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '16:00') {?>selected<?php }?>> 16:00 </option>
                            <option value="16:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '16:30') {?>selected<?php }?>> 16:30 </option>
                            <option value="17:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '17:00') {?>selected<?php }?>> 17:00 </option>
                            <option value="17:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '17:30') {?>selected<?php }?>> 17:30 </option>
                            <option value="18:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_start'],'%H:%M') == '18:00') {?>selected<?php }?>> 18:00 </option>
                            </select>
                            <code>Please add the time for the event to show from</code>									
                        </div>
                    </div>	
                    <div class="col-sm-6">			  
                        <div class="form-group has-error">
                            <label for="content_time_end">End Time</label>                        
                           <select id="content_time_end" name="content_time_end" class="form-control">
                            <option value=""> --- Choose start time --- </option>
                            <option value="08:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '08:00') {?>selected<?php }?>> 08:00 </option>
                            <option value="08:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '08:30') {?>selected<?php }?>> 08:30 </option>
                            <option value="09:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '09:00') {?>selected<?php }?>> 09:00 </option>
                            <option value="09:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '09:30') {?>selected<?php }?>> 09:30 </option>
                            <option value="10:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '10:00') {?>selected<?php }?>> 10:00 </option>                           
                            <option value="10:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '10:30') {?>selected<?php }?>> 10:30 </option>
                            <option value="11:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '11:00') {?>selected<?php }?>> 11:00 </option>
                            <option value="11:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '11:30') {?>selected<?php }?>> 11:30 </option>
                            <option value="12:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '12:00') {?>selected<?php }?>> 12:00 </option>
                            <option value="12:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '12:30') {?>selected<?php }?>> 12:30 </option>
                            <option value="13:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '13:00') {?>selected<?php }?>> 13:00 </option>
                            <option value="13:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '13:30') {?>selected<?php }?>> 13:30 </option>
                            <option value="14:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '14:00') {?>selected<?php }?>> 14:00 </option>
                            <option value="14:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '14:30') {?>selected<?php }?>> 14:30 </option>
                            <option value="15:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '15:00') {?>selected<?php }?>> 15:00 </option>
                            <option value="15:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '15:30') {?>selected<?php }?>> 15:30 </option>
                            <option value="16:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '16:00') {?>selected<?php }?>> 16:00 </option>
                            <option value="16:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '16:30') {?>selected<?php }?>> 16:30 </option>
                            <option value="17:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '17:00') {?>selected<?php }?>> 17:00 </option>
                            <option value="17:30" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '17:30') {?>selected<?php }?>> 17:30 </option>
                            <option value="18:00" <?php if (isset($_smarty_tpl->tpl_vars['contentData']->value) && smarty_modifier_date_format($_smarty_tpl->tpl_vars['contentData']->value['content_date_end'],'%H:%M') == '18:00') {?>selected<?php }?>> 18:00 </option>
                            </select>
                            <code>Please add the time for the event to end at</code>									
                        </div>
                    </div>	                    
				</div>
                <div class="row">					
                    <div class="col-sm-6">			  
                        <div class="form-group">
                            <label for="content_map_longitude">Longitude</label>                          
                            <input type="text" id="content_map_longitude" name="content_map_longitude" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['contentData']->value)) {
echo $_smarty_tpl->tpl_vars['contentData']->value['content_map_longitude'];
}?>" />
                            <code>Add line of longitude for the location of the event</code>									
                        </div>
                    </div>	
                    <div class="col-sm-6">			  
                        <div class="form-group">
                            <label for="content_map_latitude">Latitude</label>                       
                            <input type="text" id="content_map_latitude" name="content_map_latitude" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['contentData']->value)) {
echo $_smarty_tpl->tpl_vars['contentData']->value['content_map_latitude'];
}?>" />
                            <code>Add line of latitude for the location of the event</code>										
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
