(function ($) {
  "use strict";
  
  // Preloader
  $(window).on('load', function () {
    if ($('#preloader').length) {
      $('#preloader').delay(100).fadeOut('slow', function () {
        $(this).remove();
      });
    }
  });

  // Back to top button
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('.back-to-top').fadeIn('slow');
    } else {
      $('.back-to-top').fadeOut('slow');
    }
  });
  $('.back-to-top').click(function(){
    $('html, body').animate({scrollTop : 0},1500, 'easeInOutExpo');
    return false;
  });
  
	var nav = $('nav');
	var navHeight = nav.outerHeight();

	/*--/ ScrollReveal /Easy scroll animations for web and mobile browsers /--*/
	window.sr = ScrollReveal();
	sr.reveal('.foo', { duration: 1000, delay: 15 });

	/*--/ Carousel owl /--*/
	$('#carousel').owlCarousel({
		loop: true,
		margin: -1,
		items: 1,
		nav: true,
		navText: ['<i class="ion-ios-arrow-back" aria-hidden="true"></i>', '<i class="ion-ios-arrow-forward" aria-hidden="true"></i>'],
		autoplay: true,
		autoplayTimeout: 3000,
		autoplayHoverPause: true
	});

	/*--/ Animate Carousel /--*/
	$('.intro-carousel').on('translate.owl.carousel', function () {
		$('.intro-content .intro-title').removeClass('zoomIn animated').hide();
		$('.intro-content .intro-price').removeClass('fadeInUp animated').hide();
		$('.intro-content .intro-title-top, .intro-content .spacial').removeClass('fadeIn animated').hide();
	});

	$('.intro-carousel').on('translated.owl.carousel', function () {
		$('.intro-content .intro-title').addClass('zoomIn animated').show();
		$('.intro-content .intro-price').addClass('fadeInUp animated').show();
		$('.intro-content .intro-title-top, .intro-content .spacial').addClass('fadeIn animated').show();
	});
	
	/*--/ Navbar Collapse /--*/
	$('.search-box-collapse').on('click', function () {
		$('body').removeClass('box-collapse-closed').addClass('box-collapse-open');
	});
	$('.close-box-collapse, .click-closed').on('click', function () {
		$('body').removeClass('box-collapse-open').addClass('box-collapse-closed');
		$('.menu-list ul').slideUp(700);
	});

	/*--/ Navbar Menu Reduce /--*/
	$(window).trigger('scroll');
	$(window).bind('scroll', function () {
		var pixels = 50;
		var top = 1200;
		if ($(window).scrollTop() > pixels) {
			$('.navbar-default').addClass('navbar-reduce');
			$('.navbar-default').removeClass('navbar-trans');
		} else {
			$('.navbar-default').addClass('navbar-trans');
			$('.navbar-default').removeClass('navbar-reduce');
		}
		if ($(window).scrollTop() > top) {
			$('.scrolltop-mf').fadeIn(1000, "easeInOutExpo");
		} else {
			$('.scrolltop-mf').fadeOut(1000, "easeInOutExpo");
		}
	});

	/*--/ Property owl /--*/
	$('#property-carousel').owlCarousel({
		loop: true,
		margin: 30,
		responsive: {
			0: {
				items: 1,
			},
			769: {
				items: 2,
			},
			992: {
				items: 3,
			}
		}
	});

	/*--/ Property owl owl /--*/
	$('#property-single-carousel').owlCarousel({
		loop: true,
		margin: 0,  
		nav: true,
		navText: ['<i class="ion-ios-arrow-back" aria-hidden="true"></i>', '<i class="ion-ios-arrow-forward" aria-hidden="true"></i>'],
		responsive: {
			0: {
				items: 1,
			}
		}
	});

	/*--/ News owl /--*/
	$('#new-carousel').owlCarousel({
		loop: true,
		margin: 30,
		responsive: {
			0: {  
				items: 1,
			},
			769: {
				items: 2,
			},
			992: {
				items: 3,
			}
		}
	});

	/*--/ Testimonials owl /--*/
	$('#testimonial-carousel').owlCarousel({
		margin: 0,
		autoplay: true,
		nav: true,
		animateOut: 'fadeOut',
		animateIn: 'fadeInUp',
		navText: ['<i class="ion-ios-arrow-back" aria-hidden="true"></i>', '<i class="ion-ios-arrow-forward" aria-hidden="true"></i>'],
		autoplayTimeout: 4000,
		autoplayHoverPause: true,
		responsive: {
			0: {
				items: 1,
			}
		}
	});

})(jQuery);



(function(){

	if ($(window).width() <= 1200)
	{
		$('.search_sf_container').removeClass('flx_search_cont');
		$('.search_sort_cont').removeClass('col-md-6');
		$('.seach_filter_cont').removeClass('col-md-6');
		$('.search_sort_cont').addClass('col-md-12');
		$('.seach_filter_cont').addClass('col-md-12');
	}
	else
	{
		$('.search_sf_container').addClass('flx_search_cont');
		$('.search_sort_cont').removeClass('col-md-12');
		$('.seach_filter_cont').removeClass('col-md-12');
		$('.search_sort_cont').addClass('col-md-6');
		$('.seach_filter_cont').addClass('col-md-6');
	}

	$(window).resize(function(){
		if ($(window).width() <= 1200)
		{
			$('.search_sf_container').removeClass('flx_search_cont');
			$('.search_sort_cont').removeClass('col-md-6');
			$('.seach_filter_cont').removeClass('col-md-6');
			$('.search_sort_cont').addClass('col-md-12');
			$('.seach_filter_cont').addClass('col-md-12');
		}
		else
		{
			$('.search_sf_container').addClass('flx_search_cont');
			$('.search_sort_cont').removeClass('col-md-12');
			$('.seach_filter_cont').removeClass('col-md-12');
			$('.search_sort_cont').addClass('col-md-6');
			$('.seach_filter_cont').addClass('col-md-6');
		}

	});
}());
var europeCountry= [
	'Austria','Albania','Andorra','Belarus','Belgium',
	'Bulgaria','Bosnia and Herzegovina','Vatican','Hungary',
	'Germany','Guernsey','Gibraltar','Greece','Denmark',
	'Jersey','Ireland','Iceland','Spain','Italy','Kosovo',
	'Latvia','Lithuania','Liechtenstein','Luxembourg',
	'Macedonia','Malta','Moldova','Monaco','Netherlands',
	'Norway','Isle of Man','Holy See (Vatican City)','Poland',
	'Portugal','Russia','Romania','San Marino','Serbia',
	'Slovakia','Slovenia','United Kingdom','Ukraine',
	'Faroe Islands','Finland','France','Croatia','Montenegro',
	'Czech Republic','Switzerland','Sweden',
	'Svalbard and Jan Mayen','Estonia'
];

(function(){
	for (let i in europeCountry){
		$('#country_search').append('\
			<option class="country_option">'
			+ europeCountry[i] +
			'</option>\
		');
	}
}());

$('#country_search').change(function(){
	$val = $(this).val();

	if ($val !== "Select Country")
		getCity($val, null);
});

function getCity($country){

	var url = "http://api.geonames.org/searchJSON?q="+ $country +"&username=aikrof";
	$('.city_option').remove()
	$.getJSON(url, function(data, status){
    	if (data.geonames)
    	{
    		for (let i = 1; i < data.geonames.length; ++i){
    			$('#city_search').append('\
					<option class="city_option">'
					+ data.geonames[i].toponymName +
					'</option>\
				');
    		}
    	}
	});
}
