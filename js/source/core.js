/**
 * JS for premise protfolio
 */
( function( $ ) {

	// var ;

	$( document ).ready( function() {

		pwppBindEvents();

	} );


	function pwppBindEvents() {
		( $( '#pwpp-portfolio-grid').length ) ? pwppsGridItemsSameHeight() : false;
	}



	function pwppsGridItemsSameHeight() {
		$( window ).load( function() {
			premiseSameHeight( '#pwpp-portfolio-grid .pwpp-item' );
		} );
	}

} ( jQuery ) );