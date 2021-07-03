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