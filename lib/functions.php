<?php
/**
 * Global functions library
 *
 * @package premise-portfolio\lib
 */


/**
 * Must be called from within the Loop
 *
 * @return string html for the featured image
 */
function pwpp_get_loop_thumbnail() {

	global $post;
	$_html = '';

	$img_url =  premise_get_value( 'premise_portfolio[grid-view][normal-bg]', 'post' ) ?
					(string) premise_get_value( 'premise_portfolio[grid-view][normal-bg]', 'post' ) :
						(string) wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

	if ( $background = pwpp_validate_background( $img_url ) )
		$_html = '<div class="pwpp-post-thumbnail" style="'.$background.'"></div>';

	return (string) $_html;
}


/**
 * validates whether a background is usable (image url or hex color) abd returns it
 * as a string. Return false if background is not validated.
 *
 * @param  string $bg background to validate
 * @return mixed      background validated. false if not valid
 */
function pwpp_validate_background( $bg = '' ) {
	if ( ! empty( $bg ) ) {
		if ( preg_match('/^.*(jpg|png|jpeg|gif)$/i', $bg ) ) {
			return 'background-image: url( ' . esc_url( $bg ) . ' );';
		}
		if ( preg_match('/^#([0-9a-zA-Z]{3,6})/', $bg, $match ) ) {
			$match[1] = (string) ( 6 > strlen( $match[1] ) ) ? substr( $match[1].$match[1], 0, 6 ) : $match[1];
			return 'background-color: ' . esc_attr( '#' . $match[1] ) . ';';
		}
	}
	return false;
}


/**
 * get the html attributes for portfolio item
 *
 * @return string html for portfolio item attributes
 */
function pwpp_get_thumbnail_attrs( $classes = '' ) {
	$class = 'class="';
	$attrs = '';
	$gview = premise_get_value( 'premise_portfolio[grid-view]', 'post' );

	if ( $gview && is_array( $gview ) ) {
		$normal = isset( $gview['normal-bg'] )
					&& ! empty( $gview['normal-bg'] )
						? ' data-normal-state="' . esc_attr( $gview['normal-bg'] ) . '"'
							: '';
		$hover  = isset( $gview['hover-bg'] )
					&& ! empty( $gview['hover-bg'] )
						? ' data-hover-state="' . esc_attr( $gview['hover-bg']  ) . '"'
							: '';

		$attrs .= ( ! empty( $normal ) || ! empty( $hover ) ) ? $normal.$hover : '';
		$class .= ( ! empty( $hover ) ) ? 'pwpp-loop-hover-animation'          : ' pwpp-loop-default-animation';
	}

	$class .= ' ' . esc_attr( (string) $classes ) . '"';

	return $class.$attrs;
}



/**
 * Displays the post thumbnail for the premise protfolio plugin
 *
 * @return string html for featured image in remise prtfolio single post
 */
function pwpp_the_thumbnail( $view = 'post' ) {
	global $post;
	$url   = '';
	$bg    = '';
	$_html = '';

	if ( 'post' == $view && has_post_thumbnail() ) {
		$url = (string) wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
		$bg = 'background-image: url( ' . esc_url( $url ) . ' );';
	}
	else {
		if ( premise_get_value( 'premise_portfolio[grid-view][normal-bg]', 'post' ) ) {
			$url = (string) premise_get_value( 'premise_portfolio[grid-view][normal-bg]', 'post' );
		}
		elseif ( has_post_thumbnail() ) {
			$url = (string) wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
		}
		$bg = pwpp_validate_background( $url );
	}

	$_html = '<div class="pwpp-post-thumbnail-wrapper">
				<div class="pwpp-post-thumbnail" style="' . $bg . '"></div>
			</div>';
	echo $_html;
}



/**
 * outputs the html required for us to use a ligthbox
 *
 * @return string  html necessary for lightbox element
 */
function pwpp_init_lightbox() {
	// Main Wrapper
	$lightbox = '<div id="pwpp-lightbox-wrapper">
		<div id="pwpp-lightbox-inner">
			<div id="pwpp-lightbox-container">
				<i class="fa fa-spin fa-spinner pwpp-loading-icon"></i>
			</div>
		</div>
	</div>';

	echo (string) $lightbox;
}


/**
 * get the call to action html string
 *
 * @return string html for call to action
 */
function pwpp_get_the_call_to_action() {
	global $post;

	// set our variables
	$pwpp_portfolio = premise_get_value( 'premise_portfolio', array( 'context' => 'post', 'id' => $post->ID ) );

	// CTA
	$pwpp_cta_url  = (string) isset( $pwpp_portfolio['cta-url'] )  ? $pwpp_portfolio['cta-url']  : '';
	$pwpp_cta_text = (string) isset( $pwpp_portfolio['cta-text'] ) ? $pwpp_portfolio['cta-text'] : '';

	$_html = '';

	if ( '' !== $pwpp_cta_url ) : ob_start(); ?>
		<!-- The CTA -->
		<div class="pwpp-post-cta">
			<a href="<?php echo esc_url( $pwpp_portfolio['cta-url'] ); ?>" class="pwpp-post-cta-url" >

				<?php if ( '' !== $pwpp_cta_text ) : ?>
					<span class="pwpp-post-cta-text">
						<?php echo esc_html( $pwpp_portfolio['cta-text'] ); ?>
					</span>
				<?php endif; ?>

			</a>
		</div>
	<?php $_html = ob_get_clean();
	endif;

	return (string) $_html;
}


function pwpp_loop_item_attrs() {
	echo pwpp_get_thumbnail_attrs( 'pwpp-item ' . pwpp_get_grid_param() );
}


/**
 * get the grid parametter used in the shortcode being displayed
 *
 * @return string column class to use
 */
function pwpp_get_grid_param() {
	return PWPP_Shortcode::get_grid_param();
}


/**
 * returns the have posts() function from our query
 *
 * @return boolean checks if there are any posts in our loop
 */
function pwpp_have_posts() {
	return PWPP_Shortcode::have_posts();
}


/**
 * prepares the post within our loop
 *
 * @return void makes global functions and variable available for us.
 */
function pwpp_the_post() {
	return PWPP_Shortcode::the_post();
}


/**
 * return the cta url or false
 *
 * @return mix the url or false
 */
function pwpp_get_cta_url() {
	global $post;
	return premise_get_value( 'premise_portfolio[cta-url]', array( 'context' => 'post', 'id' => $post->ID ) );
}


/**
 * return the cta text or false
 *
 * @return mix the text or false
 */
function pwpp_get_cta_text() {
	global $post;
	return premise_get_value( 'premise_portfolio[cta-text]', array( 'context' => 'post', 'id' => $post->ID ) );
}


/**
 * get the custom fields for a portfolio item. must be called within the loop
 *
 * @return array|boolean array of custom field keys and values ( key => value ). false if nothing is found
 */
function pwpp_get_custom_fields() {
	$_cust_fields = premise_get_value( '', 'post' );

	if( ! $_cust_fields )
		return false;

	$cust_fields = array();
	foreach ( (array) $_cust_fields as $k => $v ) {
		if ( preg_match( '/^_/', $k )
			|| 'premise_portfolio' == $k )
				continue;

		$cust_fields[esc_html( $k )] = esc_html( $v[0] );
	}

	return $_cust_fields ? $cust_fields : false;
}



function pwpp_the_custom_fields( $format = 'dl' ) {

	if ( $cf = pwpp_get_custom_fields() ) {

		$list = '<div class="pwpp-custom-fields-container">';

			$list .= ( 'dl' !== $format ) ? '<table>' : '<dl>';
			foreach ($cf as $k => $v) {
				$key   = esc_html( $k );
				$value = esc_html( $v );

				$tags = ( 'dl' !== $format ) ? array( 'td', 'td' ) : array( 'dt', 'dd' );

				$list .= ( 'dl' !== $format ) ? '<tr>' : '';

				$list .= '<'.$tags[0].'>'.$key.'</'.$tags[0].'>
				  	<'.$tags[1].'>'.$value.'</'.$tags[1].'>';

				$list .= ( 'dl' !== $format ) ? '</tr>' : '';

			}
			$list .= ( 'dl' !== $format ) ? '</table>' : '</dl>';

		$list .= '</div>';

		echo $list;
	}
}