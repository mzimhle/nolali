<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	{include_php file="{$DOCUMENTROOT}/includes/meta.php"}    
  </head>
  <body>
	{include_php file="{$DOCUMENTROOT}/includes/header.php"}
    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
          <ol class="breadcrumb slim-breadcrumb">
			<li class="breadcrumb-item active" aria-current="page">Participants</li>
            <li class="breadcrumb-item"><a href="/">{$activeAccount.account_name}</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
          </ol>
          <h6 class="slim-pagetitle">Participants</h6>
        </div><!-- slim-pageheader -->
        <div class="section-wrapper">
		  <label class="section-title">Participants</label>
            <p class="mg-b-20 mg-sm-b-20">Below is a list of participants you have added.</p>
            <div class="row">
                <div class="col-md-12">	
                <div class="row">
					<div class="col-sm-12">				
						<div class="form-group">
							<label for="filter_search">Search by full name, cellphone or email address</label>
							<input type="text" id="filter_search" name="filter_search" class="form-control" value="" />
						</div>
					</div>
                </div>					
                <div class="form-group">
                    <button type="button" onclick="getRecords(); return false;" class="btn btn-primary">Search</button>
					<input type="button" onclick="addParticipantModal(); return false;" value="New Participant" class="btn btn-secondary fr">
                </div>
                <p>There are <span id="result_count" name="result_count" class="success">0</span> records showing. We are displaying <span id="result_display" name="result_display" class="success">0</span> records per page.</p>
                <div id="tableContent" class="table-responsive" align="center"></div>
                </div>
            </div>
		  <!-- table-wrapper -->
        </div><!-- section-wrapper -->
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
	{include_php file="{$DOCUMENTROOT}/includes/footer.php"}
    {literal}
    <script type="text/javascript">
    $(document).ready(function() {
        getRecords();
    });

    function getCSVRecords() {
        var filter_search   = $('#filter_search').val() != 'undefined' ? $('#filter_search').val() : '';
        window.location.href = "?action=search&filter_csv=1&filter_search="+filter_search;
        return false;
    }

    function getRecords() {

        var html            = '';
        var filter_search   = $('#filter_search').val() != 'undefined' ? $('#filter_search').val() : '';
        /* Clear table contants first. */			
        $('#tableContent').html('');
        $('#tableContent').html('<table cellpadding="0" cellspacing="0" width="100%" border="0" class="display" id="dataTable"><thead><tr><th>Name</th><th>Email</th><th>Cellphone</th><th>Address</th><th></th></tr></thead><tbody id="participantbody"><tr><td colspan="5" align="center"></td></tr></tbody></table>');	

        oTable = $('#dataTable').dataTable({
            "bJQueryUI": true,
            "aoColumns" : [
                { sWidth: "20%" },
                { sWidth: "25%" },
                { sWidth: "10%" },
                { sWidth: "40%" },
                { sWidth: "5%" }
            ],
            "sPaginationType": "full_numbers",							
            "bSort": false,
            "bFilter": false,
            "bInfo": false,
            "iDisplayStart": 0,
            "iDisplayLength": 20,				
            "bLengthChange": false,									
            "bProcessing": true,
            "bServerSide": true,		
            "sAjaxSource": "?action=search&filter_csv=0&filter_search="+filter_search,
            "fnServerData": function ( sSource, aoData, fnCallback ) {
                $.getJSON( sSource, aoData, function (json) {
                    if (json.result === false) {
                        $('#participantbody').html('<tr><td colspan="5" align="center">No results</td></tr>');
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
    </script>
    {/literal}
  </body>
</html>
