$(document).ready(function(){
	odataTable = $('#dataTable').dataTable({					
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",							
		"bSort": true,
		"bFilter": true,
		"bInfo": false,
		"iDisplayLength": 40,
		"bLengthChange": false							
	});		

	odataTable.fnFilter('');
	
});