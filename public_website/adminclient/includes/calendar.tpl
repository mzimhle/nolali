{literal}
<script type="text/javascript" language="javascript">		
$(document).ready(function() {
	
	var calendar = $('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month'
		},
		selectable: true,
		selectHelper: true,
		select: function(start, end, allDay) {
			
			var check = $.fullCalendar.formatDate(start,'yyyy-MM-dd');
			var today = $.fullCalendar.formatDate(new Date(),'yyyy-MM-dd');			
			
			if(check < today) {
				alert('You cannot book past dates.')
			} else {
				var startdate = new Date(start);
				var enddate = new Date(end);			
				window.location.href = '/admin/daily-bookings/details.php?startdate='+startdate.format('yyyy-mm-dd')+'&enddate='+enddate.format('yyyy-mm-dd');				
			}
		},
		editable: true,
		events: bookings
	});
});
</script>
{/literal}