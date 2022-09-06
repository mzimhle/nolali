<?php
/* Smarty version 3.1.34-dev-7, created on 2022-09-06 22:09:17
  from 'C:\sites\nolali.loc\public_admin\product\default.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_6317a8ed0165d6_68712807',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fae922fce17840fb1bc4ee2af49502b30865f541' => 
    array (
      0 => 'C:\\sites\\nolali.loc\\public_admin\\product\\default.tpl',
      1 => 1662494952,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6317a8ed0165d6_68712807 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
  <head>
	<?php include_once ('C:\sites\nolali.loc\public_admin\includes\meta.php');?>
 
  </head>
  <body>
	<?php include_once ('C:\sites\nolali.loc\public_admin\includes\header.php');?>

    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
          <ol class="breadcrumb slim-breadcrumb">
			<li class="breadcrumb-item active" aria-current="page">Products</li>			
			<li class="breadcrumb-item"><a href="/"><?php echo $_smarty_tpl->tpl_vars['activeAccount']->value['account_name'];?>
</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
          </ol>
          <h6 class="slim-pagetitle">Products</h6>
        </div><!-- slim-pageheader -->
        <div class="section-wrapper">
		  <label class="section-title">product List</label>
            <p class="mg-b-20 mg-sm-b-20">Below is a list of product you have added.</p>
            <div class="row">
                <div class="col-md-12">					
                    <div class="row">
                        <div class="col-sm-4">				
                            <div class="form-group">
                                <label for="filter_type">Filter by type</label>
                                <select id="filter_type" name="filter_type" class="form-control">
                                    <option value=""> -- All -- </option>
                                    <option value="PRODUCT"> Products </option>
                                    <option value="SERVICE"> Services </option>
                                    <option value="BOOK"> Booking </option>
                                    <option value="CATALOG"> Catalog </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-8">				
                            <div class="form-group">
                                <label for="filter_search">Search by name</label>
                                <input type="text" id="filter_search" name="filter_search" class="form-control" value="" />
                            </div>
                        </div>
                    </div>					
                    <div class="form-group">
                        <button type="button" onclick="getRecords(); return false;" class="btn btn-primary">Search</button>
                        <button class="btn btn-secondary fr" type="button" onclick="link('/product/details.php'); return false;">Add a new product</button>
                    </div>
                    <p>There are <span id="result_count" name="result_count" class="success">0</span> records showing. We are displaying <span id="result_display" name="result_display" class="success">0</span> records per page.</p>
                    <div id="tableContent" class="table-responsive" align="center"></div>
                </div>
            </div>
		  <!-- table-wrapper -->
        </div><!-- section-wrapper -->
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
	<?php include_once ('C:\sites\nolali.loc\public_admin\includes\footer.php');?>

    <?php echo '<script'; ?>
 type="text/javascript" src="/library/javascript/jquery.dataTables.min.js"><?php echo '</script'; ?>
>
    
    <?php echo '<script'; ?>
 type="text/javascript">
    $(document).ready(function() {
        getRecords();
    });

    function getRecords() {
        var html				= '';
        var filter_search	= $('#filter_search').val() != 'undefined' ? $('#filter_search').val() : '';
        var filter_type	= $('#filter_type').val() != 'undefined' ? $('#filter_type').val() : '';
        /* Clear table contants first. */
        $('#tableContent').html('');
        $('#tableContent').html('<table cellpadding="0" cellspacing="0" width="100%" border="0" class="display" id="dataTable"><thead><tr><th>Price</th><th>Name</th><th>Description</th><th></th></tr></thead><tbody id="productbody"><tr><td colspan="3" align="center"></td></tr></tbody></table>');	

        oTable = $('#dataTable').dataTable({
            "bJQueryUI": true,
            "aoColumns" : [
                {sWidth: "20%"},
                {sWidth: "20%"},                
                {sWidth: "60%"},
                {sWidth: "5%"}
            ],
            "sPaginationType": "full_numbers",							
            "bSort": false,
            "bFilter": false,
            "bInfo": false,
            "iDisplayStart": 0,
            "iDisplayLength": 100,				
            "bLengthChange": false,									
            "bProcessing": true,
            "bServerSide": true,		
            "sAjaxSource": "?action=search&filter_csv=0&filter_search="+filter_search+"&filter_type="+filter_type,
            "fnServerData": function ( sSource, aoData, fnCallback ) {
                $.getJSON( sSource, aoData, function (json) {
                    if (json.result === false) {
                        $('#productbody').html('<tr><td colspan="3" align="center">No results</td></tr>');
                    } else {
                        $('#result_count').html(json.iTotalDisplayRecords);
                        $('#result_display').html(json.iTotalRecords);
                    }
                    fnCallback(json);
                });
            },
            "fnDrawCallback": function(){
            }
        });
        return false;
    }
    <?php echo '</script'; ?>
>
    	
  </body>
</html>
<?php }
}
