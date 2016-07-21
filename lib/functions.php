<?php
/**
 * Global functions library
 *
 * @package premise-portfolio\lib
 */


if ( ! function_exists( 'pwpp_get_thumbnail' ) ) {
	/**
	 * Must be ran within the Loop
	 *
	 * @return string html for the featured image
	 */
	function pwpp_get_thumbnail() {

		global $post;

		//  start with an empty string
		$_link_html = '';
		// check if there is a post thumbnail
		if ( has_post_thumbnail() ) {

			// get the image link option
			$link = (string) premise_get_value( 'premise_portfolio[featured-image-link]', 'post' );

			// Img url
			$img_url = (string) wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

			/**
			 * Check how to link the features image
			 */
			switch( $link ) {
				case 'no-link' :
					$_link_html = '<div class="pwpp-post-thumbnail" style="background-image: url( ' . esc_url( $img_url ) . ' );"></div>';
					break;

				case 'attachment' :
					$_link_html = '<a href="' . esc_url( get_attachment_link( get_post_thumbnail_id( $post->ID ) ) ) . '" class="premise-block">
						<div class="pwpp-post-thumbnail" style="background-image: url( ' . esc_url( $img_url ) . ' );"></div>
					</a>';
					break;

				case 'image' :
					$_link_html = '<a href="' . esc_url( wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) ) . '" class="premise-block">
						<div class="pwpp-post-thumbnail" style="background-image: url( ' . esc_url( $img_url ) . ' );"></div>
					</a>';
					break;

				case 'lightbox' :
					add_action( 'wp_footer', 'pwpp_init_lightbox', 20 ); // insert lightbox to footer
					$_link_html = '<a href="javascript:void(0);" class="premise-block pwpp-lightbox-link" data-pwpp-lightbox-content="' . esc_url( $img_url ) . '">
						<div class="pwpp-post-thumbnail" style="background-image: url( ' . esc_url( $img_url ) . ' );"></div>
					</a>';
					break;

				default :
					$_link_html = '<div class="pwpp-post-thumbnail" style="background-image: url( ' . esc_url( $img_url ) . ' );"></div>';
					break;
			}
		}

		// return the link html
		return (string) $_link_html;
	}
}



if ( ! function_exists( 'pwpp_the_thumbanail' ) ) {
	/**
	 * Displays the post thumbnail for the premise protfolio plugin
	 *
	 * @return string html for featured image in remise prtfolio single post
	 */
	function pwpp_the_thumbanail() {
		echo pwpp_get_thumbnail();
	}
}




if ( ! function_exists( 'pwpp_init_lightbox' ) ) {
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
}