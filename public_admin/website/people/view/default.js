$(document).ready(function(){
	getAll();
	
});

function getAll() {				
	var html		= '';

	var asInitVals 	= new Array();
	
	/* Clear table contants first. */			
	$('.content_table').html('');
	
	$('.content_table').html('<table class="table" id="dataTable"><thead><tr><th></th><th>Added</th><th>Campaign</th><th>Fullname</th><th>Email</th><th>Cell</th><th></th><th></th></tr></thead><tbody id="tablebody" name="tablebody"><tr><td colspan="7">There are currently no records<td></tr></tbody></table>');	
		
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
					$('#tablebody').html('<tr><td colspan="7" align="center">There are currently no records</td></tr>');
				}
				fnCallback(json)
			});
		},
		"fnDrawCallback": function(){
		}
	});	
	return false;
}

function deleteitem(code) {					
	if(confirm('Are you sure you want to delete this item?')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
				data: "delete_code="+code,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert('Item deleted!');
							window.location.href = window.location.href;
						} else {
							alert(data.error);
						}
				}
		});							
	}
	
	return false;
	
}