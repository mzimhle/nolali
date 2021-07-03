<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="{$link}javascript/coin-slider.min.js"></script>
<script src="{$link}javascript/jquery.cycle.all.js" type="text/javascript"></script>
{literal}
<script type="text/javascript">
$(function () {
	$('#slideshow').cycle({
		timeout: 15000,
		fx: 'fade',
		pager: '#pager',
		pause: 0,
		pauseOnPagerHover: 0
	});
	$('#featured').cycle({
		timeout: 112000,
		fx: 'scrollUp',
		pause: 0,
		pauseOnPagerHover: 0
	});
});
</script>
<script type="text/javascript" src="/campaign/javascript/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript">
$(function () {
	// $(".fancybox").fancybox();
});
</script>
{/literal}