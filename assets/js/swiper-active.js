/**
 * Carvia Core - Frontend Scripts
 * Testimonial Carousel - Swiper Initialization
 */
( function ( $ ) {
	'use strict';

	function initCarviaTestimonialCarousel() {
		$( '.testimonial-swiper' ).each( function () {
			var $wrapper    = $( this );
			var $outerWrap  = $wrapper.closest( '.testimonial-carousel-wrapper' );
			var autoplay    = $wrapper.data( 'autoplay' ) === 'true' || $wrapper.data( 'autoplay' ) === true;
			var autoplaySpeed = parseInt( $wrapper.data( 'autoplay-speed' ), 10 ) || 3000;
			var slidesNum   = parseInt( $wrapper.data( 'slides' ), 10 ) || 2;
			var space       = parseInt( $wrapper.data( 'space' ), 10 ) || 30;

			var $prevBtn = $outerWrap.find( '.carvia-swiper-prev' );
			var $nextBtn = $outerWrap.find( '.carvia-swiper-next' );
			var $pag     = $wrapper.find( '.carvia-pagination' );

			var swiperOptions = {
				spaceBetween: space,
				grabCursor: true,
				speed: 600,
				breakpoints: {
					0: {
						slidesPerView: 1,
					},
					768: {
						slidesPerView: 2,
					},
					991: {
                        slidesPerView: 2,
                    },
                    1200: {
                        slidesPerView: slidesNum
                    },
                    1920: {
                        slidesPerView: slidesNum
					},
				},
			};

			if ( autoplay ) {
				swiperOptions.autoplay = {
					delay: autoplaySpeed,
					disableOnInteraction: false,
					pauseOnMouseEnter: true,
				};
			}

			if ( $prevBtn.length && $nextBtn.length ) {
				swiperOptions.navigation = {
					prevEl: $prevBtn[0],
					nextEl: $nextBtn[0],
				};
			}

			if ( $pag.length ) {
				swiperOptions.pagination = {
					el: $pag[0],
					clickable: true,
					dynamicBullets: true,
				};
			}

			// Destroy previous instance if exists.
			if ( $wrapper[0].swiper ) {
				$wrapper[0].swiper.destroy( true, true );
			}

			new Swiper( $wrapper[0], swiperOptions );
		} );
	}

	// Initialize on DOM ready.
	$( document ).ready( function () {
		initCarviaTestimonialCarousel();
	} );

	// Re-initialize on Elementor frontend init (editor preview).
	$( window ).on( 'elementor/frontend/init', function () {
		if ( typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks ) {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/carvia_testimonial_carousel.default', function ( $scope ) {
				initCarviaTestimonialCarousel();
			} );
		}
	} );

}( jQuery ) );