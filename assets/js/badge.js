/* Carvia Badge – curved text via SVG textPath + rAF rotation */
( function () {
	'use strict';

	var uid = 0;

	function buildCurvedText( root ) {
		var raw = root.getAttribute( 'data-carvia-badge' );
		if ( ! raw ) return;

		var cfg;
		try { cfg = JSON.parse( raw ); } catch ( e ) { return; }

		var svg    = root.querySelector( '.carvia-badge-svg' );
		if ( ! svg ) return;

		// Clear previous
		while ( svg.firstChild ) svg.removeChild( svg.firstChild );

		var size   = cfg.size   || 200;
		var radius = ( size / 2 ) * 0.78; // text orbit radius
		var cx     = size / 2;
		var cy     = size / 2;
		var id     = 'carvia-path-' + ( ++uid );

		// Define circular path
		var defs = document.createElementNS( 'http://www.w3.org/2000/svg', 'defs' );
		var path = document.createElementNS( 'http://www.w3.org/2000/svg', 'path' );
		path.setAttribute( 'id', id );
		// Full circle path starting at top (12 o'clock)
		path.setAttribute( 'd',
			'M ' + cx + ',' + ( cy - radius ) + ' ' +
			'A ' + radius + ',' + radius + ' 0 1 1 ' + ( cx - 0.001 ) + ',' + ( cy - radius )
		);
		defs.appendChild( path );
		svg.appendChild( defs );

		// Build text element
		var textEl = document.createElementNS( 'http://www.w3.org/2000/svg', 'text' );

		// Apply typography
		textEl.setAttribute( 'fill', cfg.textColor || '#1a3a1a' );
		if ( cfg.fontFamily && cfg.fontFamily !== 'inherit' ) {
			textEl.setAttribute( 'font-family', cfg.fontFamily );
		}
		if ( cfg.fontSize ) {
			textEl.setAttribute( 'font-size', cfg.fontSize );
		}
		if ( cfg.fontWeight ) {
			textEl.setAttribute( 'font-weight', cfg.fontWeight );
		}

		var tp = document.createElementNS( 'http://www.w3.org/2000/svg', 'textPath' );
		tp.setAttribute( 'href', '#' + id );
		tp.setAttribute( 'xlink:href', '#' + id );
		tp.setAttribute( 'startOffset', '0%' );

		// Apply letter-spacing via SVG attribute
		var charSp = cfg.charSp !== undefined ? cfg.charSp : 2;
		if ( charSp ) {
			textEl.setAttribute( 'letter-spacing', charSp );
		}

		var displayText = cfg.text || '';
		if ( cfg.textTransform === 'uppercase' ) displayText = displayText.toUpperCase();
		if ( cfg.textTransform === 'lowercase' ) displayText = displayText.toLowerCase();
		tp.textContent = displayText;

		textEl.appendChild( tp );
		svg.appendChild( textEl );

		// Set SVG viewBox
		svg.setAttribute( 'viewBox', '0 0 ' + size + ' ' + size );

		// Spin animation
		if ( cfg.rotate ) {
			var speed     = cfg.speed || 10; // seconds per full rotation
			var direction = cfg.direction === 'reverse' ? -1 : 1;
			var startTime = null;
			var rafId     = null;

			function tick( ts ) {
				if ( ! startTime ) startTime = ts;
				var elapsed = ( ts - startTime ) / 1000; // seconds
				var degrees = ( ( elapsed / speed ) % 1 ) * 360 * direction;
				svg.style.transform = 'rotate(' + degrees + 'deg)';
				svg.style.transformOrigin = '50% 50%';
				rafId = requestAnimationFrame( tick );
			}

			if ( rafId ) cancelAnimationFrame( rafId );
			rafId = requestAnimationFrame( tick );

			// Store cleanup reference
			root._carviaRaf = rafId;
			root._carviaCancelRaf = function () {
				if ( rafId ) cancelAnimationFrame( rafId );
			};
		}
	}

	function initAll( context ) {
		var ctx   = context || document;
		var roots = ctx.querySelectorAll( '.carvia-badge-root[data-carvia-badge]' );
		roots.forEach( function ( r ) {
			// Cancel previous animation if reinitializing
			if ( r._carviaCancelRaf ) r._carviaCancelRaf();
			buildCurvedText( r );
		} );
	}

	/* Elementor hooks */
	if ( typeof window.elementorFrontend !== 'undefined' ) {
		window.elementorFrontend.hooks.addAction(
			'frontend/element_ready/carvia-badge.default',
			function ( $scope ) {
				initAll( $scope[0] );
			}
		);
	} else {
		document.addEventListener( 'DOMContentLoaded', function () {
			initAll();
		} );
	}
} )();
