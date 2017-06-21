jQuery(document).ready(function($){

	/* Fancybox */
	$('.fancybox, .gallery a').fancybox({
		margin: 100,
		overlayColor: '#000',
		overlayOpacity: 0.7
	});

	/* FitVids */
	$('.fitvids, .entry-content').fitVids();

	/* Superfish menus */
	$('.sf-menu').superfish({
		animation: { height: 'show' },
		delay: 400,
		speed: 'fast',
		speedOut: 100
	});

	/* Superfish submenu indicators */
	$('.sf-menu > li > a.sf-with-ul').append(' <i class="fa fa-chevron-down"></i>');

	/* Home icon */
	var homeIconText = $('.sf-menu li.home-icon a').html();
	$('.sf-menu li.home-icon a').html('<span>' + homeIconText + '</span><i class="fa fa-home"></i>');

	/* Tabbed widget */
	$('.widget_fearless_tabs .widgets > div').not('.tab1').hide();

	$('.widget_fearless_tabs .headings a').click(function(){
		var newClass = $(this).parent().attr('class');

		$('.widget_fearless_tabs .headings a').removeClass('active');
		$('.widget_fearless_tabs .headings li.' + newClass + ' a').addClass('active');

		$('.widget_fearless_tabs .widgets > div').hide();
		$('.widget_fearless_tabs .widgets > div.' + newClass).show();
		return false;
	});

	/* Ticker */
	if ( $('#ticker #js-news').length > 0 ) {
		$('#ticker #js-news').ticker({
			controls: false,
			puaseOnItems: 5000,
			titleText: fearless_localized_strings.ticker_title
		});
	}

});

jQuery(window).load(function(){
	$ = jQuery;

	/* Featured slider */
	$('.featured-slider.flexslider, .gallery-slider.flexslider').flexslider({
		animation: 'fade',
		controlNav: false,
		nextText: '<i class="fa fa-angle-right"></i>',
		pauseOnHover: true,
		prevText: '<i class="fa fa-angle-left"></i>',
		slideshowSpeed: 8000,
		smoothHeight: true
	});
	$('.flexslider').hover(function(){
		$('.flexslider ul.flex-direction-nav').stop().animate({opacity: 1}, 300).show();
	}, function(){
		$('.flexslider ul.flex-direction-nav').stop().animate({opacity: 0}, 300);
	});

	/* Carousel slider */
	$('.carousel-slider.flexslider').flexslider({
		animation: 'slide',
		controlNav: false,
		directionNav: false,
		itemMargin: 25,
		itemWidth: 150,
		move: 1,
		slideshow: false,
		smoothHeight: false,
		start: function(slider){
			$('.carousel-direction-nav .prev').click(function(event){
				event.preventDefault();
				slider.flexAnimate( slider.getTarget('prev') );
			});
			$('.carousel-direction-nav .next').click(function(event){
				event.preventDefault();
				slider.flexAnimate( slider.getTarget('next') );
			});
		}
	});
	$('.gallery-slider-thumbnails a').click( function(){
		$('.gallery-slider.flexslider').flexslider( $(this).data('slide-index') );
		return false;
	});

});
