<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>{$domainData.campaign_name} Management System</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	{include_php file='includes/css.php'}
</head>
<body>
{include_php file='includes/header.php'}
<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header">
	<h2 class="content-header-title">Booking</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/booking/">Booking</a></li>
	<li class="active">List</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-md-12">
		<button class="btn btn-secondary fr" type="button" onclick="link('/booking/details.php'); return false;">Add a new Booking</button><br/ ><br />
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-hand-o-up"></i>
                Booking's List
              </h3>
            </div> <!-- /.portlet-header -->			  
            <div class="portlet-content">           			
                <div class="form-group">
					<label for="client_code">Search by name, surname or cellphone number</label>
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
{include_php file='includes/footer.php'}
{literal}<script type="text/javascript">var oTable	= null;</script>{/literal}
{include_php file='includes/javascript.php'}
{literal}
<script type="text/javascript">
$(document).ready(function() {
	getAll();
});

function getAll() {				
	var html		= '';
	
	var asInitVals 	= new Array();
	
	/* Clear table contants first. */			
	$('#tableContent').html('');
	
	$('#tableContent').html('<table class="table" id="dataTable"><thead><tr><th>Added</th><th>Person Fullname</th><th>Person Contact</th><th>Start Date - End Date</th><th></th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="6">There are currently no records<td></tr></tbody></table>');	
		
	oTable = $('#dataTable').dataTable({					
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
		"sAjaxSource": "?action=tablesearch&search="+$('#search').val(),
		"fnServerData": function ( sSource, aoData, fnCallback ) {
			$.getJSON( sSource, aoData, function (json) {
				if (json.result === false) {
					$('#tablebody').html('<tr><td colspan="6" align="center">There are currently no records</td></tr>');
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
{/literal}
</body>
</html>
