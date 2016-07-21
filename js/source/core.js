/**
 * JS for premise protfolio
 */
( function( $ ) {

	var lightboxLink = null;

	$( document ).ready( function() {

		lightboxLink = $( '.pwpp-lightbox-link' );

		pwppBindEvents();

	} );


	function pwppBindEvents() {
		( lightboxLink.length ) ? pwppStartLightbox() : false;
	}

	function pwppStartLightbox() {
		var content = lightboxLink.attr( 'data-pwpp-lightbox-content' );

		if ( '' !== content ) {
			lightboxLink.click( function() {
				pwppOpenLightbox( content );
			} );
		}

		return false;
	}


	function pwppOpenLightbox( cont ) {
		cont = cont || '';

		if ( '' !== cont ) {

			var wrapper = $( '#pwpp-lightbox-wrapper' ),
			// inner       = $( '#pwpp-lightbox-inner' ),
			container   = $( '#pwpp-lightbox-container' );

			wrapper.fadeIn( 'fast' );

			$.post( {
				url: cont,
				type: 'GET',
				succes: function( resp ) {
					console.log( resp );
				}
			} );

		}

		return false;
	}

} ( jQuery ) );