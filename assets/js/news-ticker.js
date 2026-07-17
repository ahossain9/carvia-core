/**
 * Carvia Scrolling Marquee Widget - JavaScript
 *
 * Handles:
 *  - Reading data attributes from .carvia-marquee-track
 *  - Setting CSS animation speed dynamically
 *  - Setting item gap dynamically
 *  - Pause-on-hover
 *  - Play / Pause control buttons
 *  - Elementor editor re-init on setting change
 *
 * @package Carvia
 */

( function ( $ ) {
	'use strict';

	/**
	 * Init a single marquee wrapper element.
	 *
	 * @param {HTMLElement} wrapper  .carvia-marquee-wrapper
	 */
	function initMarquee( wrapper ) {
		var track     = wrapper.querySelector( '.carvia-marquee-track' );
		var trackWrap = wrapper.querySelector( '.carvia-marquee-track-wrapper' );

		if ( ! track ) {
			return;
		}

		var direction  = track.getAttribute( 'data-direction' ) || 'left';
		var speed      = parseFloat( track.getAttribute( 'data-speed' ) ) || 30;
		var gap        = parseFloat( track.getAttribute( 'data-gap' ) )   || 60;
		var pauseHover = track.getAttribute( 'data-pause-hover' ) !== 'false';

		/* ── Apply item gap ─────────────────────────────────────────────────── */
		var items      = track.querySelectorAll( '.carvia-marquee-item' );
		var separators = track.querySelectorAll( '.carvia-marquee-separator' );

		items.forEach( function ( item ) {
			item.style.marginRight = gap + 'px';
		} );

		separators.forEach( function ( sep ) {
			sep.style.marginLeft = gap + 'px';
		} );

		/* ── Set animation ──────────────────────────────────────────────────── */
		var animName = direction === 'right'
			? 'carvia-marquee-scroll-right'
			: 'carvia-marquee-scroll-left';

		track.style.animation = animName + ' ' + speed + 's linear infinite';

		/* ── Update fade overlay colours to match actual background ────────── */
		// (best-effort; only works if wrapper has a solid colour)
		var wrapperBg = window.getComputedStyle( wrapper ).backgroundColor;
		if ( trackWrap && wrapperBg && wrapperBg !== 'rgba(0, 0, 0, 0)' && wrapperBg !== 'transparent' ) {
			trackWrap.style.setProperty( '--carvia-marquee-bg', wrapperBg );
		}

		/* ── Pause on hover ─────────────────────────────────────────────────── */
		if ( pauseHover ) {
			wrapper.addEventListener( 'mouseenter', function () {
				track.classList.add( 'is-paused' );
				track.style.animationPlayState = 'paused';
			} );

			wrapper.addEventListener( 'mouseleave', function () {
				if ( ! wrapper.dataset.manualPause ) {
					track.classList.remove( 'is-paused' );
					track.style.animationPlayState = 'running';
				}
			} );
		}

		/* ── Play / Pause controls ──────────────────────────────────────────── */
		var btnPause = wrapper.querySelector( '.carvia-marquee-btn-pause' );
		var btnPlay  = wrapper.querySelector( '.carvia-marquee-btn-play' );

		if ( btnPause && btnPlay ) {
			btnPause.addEventListener( 'click', function () {
				track.style.animationPlayState = 'paused';
				track.classList.add( 'is-paused' );
				wrapper.dataset.manualPause = '1';
				btnPause.style.display = 'none';
				btnPlay.style.display  = '';
			} );

			btnPlay.addEventListener( 'click', function () {
				track.style.animationPlayState = 'running';
				track.classList.remove( 'is-paused' );
				delete wrapper.dataset.manualPause;
				btnPause.style.display = '';
				btnPlay.style.display  = 'none';
			} );
		}

		/* ── Accessibility: respect prefers-reduced-motion ─────────────────── */
		var reducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' );
		if ( reducedMotion.matches ) {
			track.style.animation = 'none';
		}

		reducedMotion.addEventListener( 'change', function () {
			if ( reducedMotion.matches ) {
				track.style.animation = 'none';
			} else {
				track.style.animation = animName + ' ' + speed + 's linear infinite';
			}
		} );
	}

	/**
	 * Init all marquee widgets on the page.
	 */
	function initAllMarquees() {
		document.querySelectorAll( '.carvia-marquee-wrapper' ).forEach( function ( wrapper ) {
			initMarquee( wrapper );
		} );
	}

	/* ── DOM ready ──────────────────────────────────────────────────────────── */
	document.addEventListener( 'DOMContentLoaded', initAllMarquees );

	/* ── Elementor frontend hooks ───────────────────────────────────────────── */
	$( window ).on( 'elementor/frontend/init', function () {
		if ( ! window.elementorFrontend ) {
			return;
		}

		elementorFrontend.hooks.addAction(
			'frontend/element_ready/carvia-scrolling-marquee.default',
			function ( $scope ) {
				var wrapper = $scope[ 0 ].querySelector( '.carvia-marquee-wrapper' );
				if ( wrapper ) {
					initMarquee( wrapper );
				}
			}
		);
	} );

} )( jQuery );