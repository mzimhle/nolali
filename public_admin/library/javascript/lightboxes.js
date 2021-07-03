function sendJobMessage(jobseekerref, jobref) {
		window.scroll(0,0);
		$('body').append('<div id="overlay" style="background: #000; width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 100; opacity: 0.7; filter:alpha(opacity=70);"></div>');
		$('body').append('<div id="overlayloader" class="ui-corner-all" style="background: #ccc; padding: 5px; z-index: 5000; position: absolute; top: 40%; left: 45%;"><img src="/Images/extra/3dloader.gif" /> loading...</div>');
		$('body').append('<div id="coloursloader" style="display: none;"></div>');
		$("#coloursloader").load("/admin/lightboxes/sendjobmessage.php?jobSeekerRef="+jobseekerref+"&jobref="+jobref, function() {
			var container = $(this);
			container.dialog({
				modal: true,
				height: 630,
				width: 500,
				title: 'Send Message',
				draggable: false,
				resizable: false,
				open: function() {
					$('#overlayloader').remove();
				},
				close: function() {
					$('#overlay').remove();
				},
				show: 'fade'
			})
		});
		return false;	
}