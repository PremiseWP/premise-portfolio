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

		// get the image link - link to the cta url
		$link = (string) premise_get_value( 'premise_portfolio[cta-url]', 'post' );

		// Img url
		$img_url = (string) wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

		$_html = '<div class="pwpp-post-thumbnail-wrapper">';

			$_html .= ( '' !== $link ) ? '<a href="' . esc_url( $link ) . '" class="premise-block" target="_blank">' : '';

				$_html .= '<div class="pwpp-post-thumbnail" style="background-image: url( ' . esc_url( $img_url ) . ' );"></div>';

			$_html .= ( '' !== $link ) ? '</a>' : '';

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
function pwpp_the_thumbanail() {
	echo pwpp_get_thumbnail();
}



/**
 * outputs the htl required for us to use a ligthbox
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
function get_the_call_to_action() {
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