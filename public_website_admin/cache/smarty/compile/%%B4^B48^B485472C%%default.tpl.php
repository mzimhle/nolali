<?php /* Smarty version 2.6.20, created on 2015-05-22 12:54:11
         compiled from catalogue/invoice/default.tpl */ ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
 Management System</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</head>
<body>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header">
	<h2 class="content-header-title">Invoice</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/catalogue/">Catalogue</a></li>
	<li><a href="/catalogue/invoice/">Invoice</a></li>
	<li class="active">List</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-md-12">
		<button class="btn btn-secondary fr" type="button" onclick="link('/catalogue/invoice/details.php'); return false;">Add a new Invoice</button><br/ ><br />
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-hand-o-up"></i>
                Invoice's List
              </h3>
            </div> <!-- /.portlet-header -->			  
            <div class="portlet-content">           			
                <div class="form-group">
					<label for="client_code">Search by reference, fullname, contact name</label>
					<input type="text" class="form-control"  id="search" name="search" size="60" value="" /><br />
					<button type="button" onClick="getAll();" class="btn btn-primary">Search</button>
                </div>			 
				<div id="tableContent">Loading subscriber details..... Please wait...</div>	
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php echo '<script type="text/javascript">var oTable	= null;</script>'; ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php echo '
<script type="text/javascript">
$(document).ready(function() {
	getAll();
});

function getAll() {				
	var html		= \'\';
	
	var asInitVals 	= new Array();
	
	/* Clear table contants first. */			
	$(\'#tableContent\').html(\'\');
	
	$(\'#tableContent\').html(\'<table class="table" id="dataTable"><thead><tr><th>Added</th><th>Reference</th><th>Person Fullname</th><th>Person Contact</th><th>Total Item Amount</th><th>Paid Amount</th><th>Remainder</th><th>Type</th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="9">There are currently no records<td></tr></tbody></table>\');	
		
	oTable = $(\'#dataTable\').dataTable({					
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",							
		"bSort": false,
		"bFilter": false,
		"bInfo": false,
		"iDisplayStart": 0,
		"iDisplayLength": 20,				
		"bLengthChange": false,									
		"bProcessing": true,
		"bServerSide": true,		
		"sAjaxSource": "?action=tablesearch&search="+$(\'#search\').val(),
		"fnServerData": function ( sSource, aoData, fnCallback ) {
			$.getJSON( sSource, aoData, function (json) {
				if (json.result === false) {
					$(\'#tablebody\').html(\'<tr><td colspan="9" align="center">There are currently no records</td></tr>\');
				}
				fnCallback(json)
			});
		},
		"fnDrawCallback": function(){
		}
	});	
	return false;
}
</script>
'; ?>

</body>
</html>