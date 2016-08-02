<?php
/**
 * Global functions library
 *
 * @package premise-portfolio\lib
 */


/**
 * Must be ran within the Loop
 *
 * @return string html for the featured image
 */
function pwpp_get_thumbnail() {

	global $post;

	// check if there is a post thumbnail
	if ( has_post_thumbnail() ) {

		// Img url
		$img_url = (string) wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

		$_html = '<div class="pwpp-post-thumbnail-wrapper">';

			$_html .= '<div class="pwpp-post-thumbnail" style="background-image: url( ' . esc_url( $img_url ) . ' );"></div>';

		$_html .= '</div>';

		return (string) $_html;
	}

	// return the link html
	return (string) $_link_html;
}



/**
 * Displays the post thumbnail for the premise protfolio plugin
 *
 * @return string html for featured image in remise prtfolio single post
 */
function pwpp_the_thumbnail() {
	echo pwpp_get_thumbnail();
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