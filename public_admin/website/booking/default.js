$(document).ready(function(){
	odataTable = $('#dataTable').dataTable({					
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",							
		"bSort": false,
		"bFilter": false,
		"bInfo": false,
		"iDisplayLength": 20,
		"bLengthChange": false							
	});		

	odataTable.fnFilter('');
	
});

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

function changeStatus(code, status) {
	if(confirm('Are you sure you want to change this item status?')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
				data: "status_code="+code+"&status="+status,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert('Item status changed!');
							window.location.href = window.location.href;
						} else {
							alert(data.error);
						}
				}
		});							
	}
	return false;
}