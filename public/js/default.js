jQuery(window).on('load', function() {   
    
    // HIDE PRELAODER
    $(".preloader").addClass("hide-preloader");
  
});


jQuery(document).ready(function($) {
	"use strict";
    
    // PORTFOLIO GALLERY 
 //    $('.portfolio a').featherlightGallery({
	// 	previousIcon: '&#9664;',   
	// 	nextIcon: '&#9654;',         
	// 	galleryFadeIn: 100,
	// 	galleryFadeOut: 300    
	// });
    

});

(function(){
	if ($('.navigation-button').hasClass('second'))
		$('.first').remove();
}());

$('.navigation-button i').mouseover(function(){
	$('.i').toggleClass('i_b');
});

$('.navigation-button i').mouseout(function(){
	$('.i').toggleClass('i_b');
});