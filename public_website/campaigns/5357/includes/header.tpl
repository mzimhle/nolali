<div id="header">
	<div class="header-box">
		<div id="slideshow">
			<div class="slide-text"><img src="/images/slide1.jpg" alt="" class="slidehalf" /></div>
			<div class="slide-text"> <img src="/images/slide2.jpg" alt="" class="slidehalf" /></div>
			<div class="slide-text"> <img src="/images/slide3.jpg" alt="" class="slidehalf" /></div>
			<div class="slide-text"> <img src="/images/slide4.jpg" alt="" class="slidehalf" /></div>
			<div class="slide-text"> <img src="/images/slide5.jpg" alt="" class="slidehalf" /></div>
		</div>
		
		<div id="box-nav-slider" style="width: 500px;"><div id="slideshow-navigation"><div id="pager"></div></div></div>
	</div>	
</div>
<div id="navigation">
	<ul class="nav">
		<li><a href="/" {if $page eq '' or $page eq '/'}class="current"{/if}>Home</a></li>
		<li><a href="/about-us/" {if $page eq 'about-us'}class="current"{/if}>About</a></li>
		<li><a href="/facility/" {if $page eq 'facility'}class="current"{/if}>Facilities</a></li>
		<li><a href="/gallery/" {if $page eq 'gallery'}class="current"{/if}>Gallery</a></li>
		<li><a href="/booking/" {if $page eq 'booking'}class="current"{/if}>Booking</a></li>
		<li><a href="/contact/" {if $page eq 'contact'}class="current"{/if}>Contact</a></li>
	</ul>
</div>