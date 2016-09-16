/**
 * JS for premise protfolio
 */
( function( $ ) {

	$( document ).ready( function() {

		var pwppLoopHoverAnimation = $ ( '.pwpp-loop-hover-animation' );

		( pwppLoopHoverAnimation.length ) ? pwppLoopAnimateOnHover() : false;


		function pwppLoopAnimateOnHover() {
			pwppLoopHoverAnimation.mouseenter( function() {
				var hover = $(this).attr( 'data-hover-state' );

				if ( '' !== hover ) {
					if ( hover.match( '#' ) ) {
						$(this).find( '.pwpp-post-thumbnail' ).css({
							'background-image': '',
							'background-color': hover,
						} );
					}
					else {
						$(this).find( '.pwpp-post-thumbnail' ).css({
							'background-image': 'url('+hover+')',
							'background-color': '',
						} );
					}
				}
			} );

			pwppLoopHoverAnimation.mouseleave( function() {
				var hover = $(this).attr( 'data-normal-state' );

				if ( '' !== hover ) {
					if ( hover.match( '#' ) ) {
						$(this).find( '.pwpp-post-thumbnail' ).css({
							'background-image': '',
							'background-color': hover,
						} );
					}
					else {
						$(this).find( '.pwpp-post-thumbnail' ).css({
							'background-image': 'url('+hover+')',
							'background-color': '',
						} );
					}
				}
			} );
		}
	} );

} ( jQuery ) );