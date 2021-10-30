var ffMultipurposeSliderAutoplay = false;

if ( '1' == ffMultipurposeSliderOptions.slider.autoplay ) {
	ffMultipurposeSliderAutoplay = {
	    delay: ffMultipurposeSliderOptions.slider.autoplayDelay,
	};
}

var mainSlider = new Swiper ( '#slider-section', {
	autoHeight: true, //enable auto height
	loop: ( '1' == ffMultipurposeSliderOptions.slider.loop ),
	effect: ffMultipurposeSliderOptions.slider.effect,
	speed: parseInt( ffMultipurposeSliderOptions.slider.speed ),
	// If we need pagination
	pagination: {
		el: '.swiper-pagination',
		type: 'bullets',
		clickable: 'true',
	},

	autoplay: ffMultipurposeSliderAutoplay,
	// Navigation arrows
	navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	},

	// And if we need scrollbar
	scrollbar: {
		el: '.swiper-scrollbar',
	},
});

if ( 'undefined' != typeof mainSlider.el && '1' == ffMultipurposeSliderOptions.slider.autoplay && '1' == ffMultipurposeSliderOptions.slider.pauseOnHover ) {
	mainSlider.el.addEventListener( 'mouseenter', function( event ) {
		ffMultipurposeSlider.autoplay.stop();
	}, false);

	mainSlider.el.addEventListener( 'mouseleave', function( event ) {
		ffMultipurposeSlider.autoplay.start();
	}, false);
}

var swiperTestimonial = new Swiper( '.testimonial-content-wrapper.swiper-carousel-enabled', {
	slidesPerView: 1,
	loop: true,
	speed: 300,
	freeMode: true,
	spaceBetween: 40,
	pagination: {
		el: '.testimonial-content-wrapper.swiper-carousel-enabled .swiper-pagination',
		clickable: true,
	},
	disableOnInteraction: false,
	autoplay: {
	    delay: 5000,
	},
	// Navigation arrows
	navigation: {
		nextEl: '.testimonial-content-wrapper.swiper-carousel-enabled .swiper-button-next',
		prevEl: '.testimonial-content-wrapper.swiper-carousel-enabled .swiper-button-prev',
	},
	// Breakpoints
	breakpoints: {
			640 : {
			slidesPerView: 2,
			spaceBetween: 40,
		}
	}
});

if ( 'undefined' != typeof swiperTestimonial.el ) {
	swiperTestimonial.el.addEventListener( 'mouseenter', function( event ) {
		swiperTestimonial.autoplay.stop();
	}, false);

	swiperTestimonial.el.addEventListener( 'mouseleave', function( event ) {
		swiperTestimonial.autoplay.start();
	}, false);
}
