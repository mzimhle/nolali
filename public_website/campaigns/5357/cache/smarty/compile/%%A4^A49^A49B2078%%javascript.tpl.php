<?php /* Smarty version 2.6.20, created on 2015-07-22 05:20:46
         compiled from includes/javascript.tpl */ ?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/javascript/coin-slider.min.js"></script>
<script src="/javascript/jquery.cycle.all.js" type="text/javascript"></script>
<?php echo '
<script type="text/javascript">
$(function () {
	$(\'#slideshow\').cycle({
		timeout: 15000,
		fx: \'fade\',
		pager: \'#pager\',
		pause: 0,
		pauseOnPagerHover: 0
	});
	$(\'#featured\').cycle({
		timeout: 112000,
		fx: \'scrollUp\',
		pause: 0,
		pauseOnPagerHover: 0
	});
});
</script>
<script type="text/javascript" src="/javascript/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript">
$(function () {
	// $(".fancybox").fancybox();
});
</script>
'; ?>