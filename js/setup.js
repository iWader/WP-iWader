$(document).ready(function() {
	
	/*	--------------------------------------------------------------------
		FlexSlider
	------------------------------------------------------------------------ */
	
	$('.flexslider').flexslider({
		controlNav: true
	});
	
	/*	--------------------------------------------------------------------
		Carousel - Portfolio
	------------------------------------------------------------------------ */
	
	$('.portfolio-carousel').find('.portfolio-items').carouFredSel({
		auto: false,
		responsive: true,
		
		prev: '#portfolio-carousel-prev',
		next: '#portfolio-carousel-next',
		scroll: 1,
		items: {
			width: 260,
			height: 'auto',
			visible: {
				min: 1,
				max: 3
			}
		}
	});
	
});