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

var locationAPI_KEY = [
	'a97523dfa785d53e7c6bf1e50b1c2b5d',
	'0bd339ee908bdf4f26e4276960e05822',
	'b8e605eba06cbb901ec40222d952e5bd',
	'1b99b07e9caf808ad0d5e9640fac9cd0',
	'17e1d4695748c6cd585c533c792b6ac9',
	'0c78ea4ff7d3ff899694cb53c9b3ad6c'
];

(function(){
	data = getCountry(null);
}());

$('#country_search').change(function(){
	$val = $(this).val();

	if ($val !== "Select Country")
		getCity($val, null);
});

function getCountry($api_key){
	var url = 'http://htmlweb.ru/geo/api.php?location=Европа&json&api_key=' + '0c78ea4ff7d3ff899694cb53c9b3ad6c';
	
	$.getJSON(url, function(data, status){
		console.log(data);
    	// if (data)
    	// 	addDataToSelect($('#country_search'), data, "country_option");
	});
}

function getCity($country, $api_key){
	id = "";

	for (let elem of $('.country_option')){
		if (elem.innerHTML === $country)
		{
			id = elem.getAttribute('id');
			break;
		}
	}
	if (id === "")
		return;

	// var url = 'http://htmlweb.ru/geo/api.php?country='+ id +'&json&api_key=' + $api_key;
	
	var url = 'http://htmlweb.ru/geo/api.php?country='+ id +'&id=200&sql&api_key=';

	$.getJSON(url, function(data, status){
		console.log(data);
    	if (data)
    	{

    	}
	});
}

function addDataToSelect($parent, data, $class){
	asd = "";
	for (let i in data){
		if (data[i].english !== undefined
			&& data[i].english !== "")
		{
			asd += data[i].english + ',';
			// $parent.append('\
			//  	<option class='+ $class +'\
			//  		id='+ data[i].id +' onclick="setCountry(this);">'
			//  	+ data[i].english +
			//  	'</option>\
			// ');
		}
	}

	console.log(asd);
}