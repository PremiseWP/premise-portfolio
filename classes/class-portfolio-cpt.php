<?php
/**
 * Build and display the options page
 *
 * @package premise-portfolio\classes
 */



/**
* This class registers our custom post type and adds the meta box necessary
*/
class PWPP_Portfolio_CPT {

	/**
	 * Plugin instance.
	 *
	 * @see get_instance()
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * the cutom post type supported
	 *
	 * @var array
	 */
	public $post_type = array( 'premise_portfolio' );

	/**
	 * creates our custom post type. The custom post type class neeeds to be initiated on init. so we run it here.
	 *
	 * @see 	init()
	 * @since 	1.0.0
	 */
	public function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {

			$portfolio_cpt = new PremiseCPT( array(
				'plural' => 'Portfolio Items',
				'singular' => 'Portfolio Item',
				'post_type_name' => 'premise_portfolio',
				'slug' => 'premise-portfolio',
			), array(
				'supports' => array(
					'title',
					'editor',
					'auhtor',
					'thumbnail',
				),
				'menu_icon' => 'dashicons-portfolio',
			) );

			$portfolio_cpt->register_taxonomy(
				array(
					'taxonomy_name' => 'premise-portfolio-category',
					'singular' => __( 'Portfolio Category', 'pwpp' ),
					'plural' => __( 'Portfolio Categories', 'pwpp' ),
					'slug' => 'premise-portfolio-category',
				)
			);

			$portfolio_cpt->register_taxonomy(
				array(
					'taxonomy_name' => 'premise-portfolio-tag',
					'singular' => __( 'Portfolio Tag', 'psmb' ),
					'plural' => __( 'Portfolio Tags', 'psmb' ),
					'slug' => 'premise-portfolio-tag',
				),
				array(
					'hierarchical' => false, // No sub-tags.
				)
			);

			$this->init();
		}
	}

	/**
	 * Access this plugin’s working instance
	 *
	 * @since   1.0.0
	 * @return  object instance of this class
	 */
	public static function get_instance() {
		null === self::$instance and self::$instance = new self;

		return self::$instance;
	}

	/**
	 * initiate our plugin and registers the necessary hooks for our custom post type to work properly
	 *
	 * @return void does not return anything
	 */
	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'do_save' ), 10 );
	}

	/**
	 * Add the meta box if within our custom post type
	 *
	 * @param string $post_type the cusotm post type currently loaded
	 */
	public function add_meta_boxes( $post_type ) {
		if ( in_array( $post_type, $this->post_type ) ) {
			add_meta_box( 'pwpp-cpt-meta-box', 'Portfolio Item Options', array( $this, 'render_meta_box' ), 'premise_portfolio', 'normal', 'high' );
		}
	}

	/**
	 * render the metabox content
	 *
	 * @return strinf the html for the meta box content
	 */
	public function render_meta_box() {
		wp_nonce_field( 'premise_portfolio_nonce_check', 'premise_portfolio_nonce' );

		// Add a call to action
		$cfields = premise_get_value( 'pwpp_portfolio[custom-fields]', 'post' );
		?>
			<h4>Add Custom Meta Data To This Project</h4>
			<div class="pwpfd-wrapper">
				<?php

				$i = 1;
				foreach ( (array) $cfields as $k => $field ) {

					?><div class="<?php echo ( $i == count( $cfields ) ) ? 'pwpp-project-custom-fields' : 'pwpfd-duplicate-this'; ?>">
						<div class="premise-row"><?

							premise_field_section( array(
								array(
									'type'          => 'text',
									'label'         => 'Key',
									'name'          => 'pwpp_portfolio[custom-fields]['.$k.'][key]',
									'wrapper_class' => 'span4',
									'context'       => 'post',
								),
								array(
									'type'          => 'textarea',
									'label'         => 'value',
									'name'          => 'pwpp_portfolio[custom-fields]['.$k.'][value]',
									'wrapper_class' => 'span8',
									'context'       => 'post',
								),
							) );

						?></div>
					</div><?

					$i++;
				} ?>
			</div>
			<script type="text/javascript">
				(function($) {
					$(document).ready(function(){
						$( '.pwpp-project-custom-fields' ).premiseFieldDuplicate();
					});
				}(jQuery));
			</script>
		<?php
	}

	/**
	 * Save our custom post type met data
	 *
	 * @param  int $post_id the post id for the post currently being edited
	 * @return void         does not return anything
	 */
	public function do_save( $post_id ) {
		// Add nonce for security and authentication.
        $nonce_name   = isset( $_POST['premise_portfolio_nonce'] ) ? $_POST['premise_portfolio_nonce'] : '';
        $nonce_action = 'premise_portfolio_nonce_check';

        // Check if nonce is set.
        if ( ! isset( $nonce_name ) ) {
            return;
        }

        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
            return;
        }

        // Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) {
            return;
        }

        // Check if not a revision.
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }

        $pwpp_mb = $_POST['pwpp_portfolio'];

        update_post_meta( $post_id, 'pwpp_portfolio', $pwpp_mb );
	}

	/*
	 STATIC METHODS
	 */

	/**
	 * filter the content for our portfolio items
	 *
	 * @param  string $content the content to filter
	 * @return string          the content filtered
	 */
	public static function portfolio_content_filter( $content ) {
		global $post;
		if ( 'premise_portfolio' == $post->post_type
			 && is_single() ) {
			return self::single_portfolio_content( $content );
		}
		return $content;
	}

	/**
	 * get the portfolio content
	 *
	 * @return string html for content
	 */
	public static function single_portfolio_content( $cont ) {
		ob_start();
		pwpp_the_custom_fields(); ?>

		<!-- The content -->
		<div class="pwpp-post-content">
			<?php echo $cont; ?>
		</div>

		<!-- The category -->
		<div class="pwpp-post-category">
			<?php echo ( $category_list = get_the_term_list( get_the_id(), 'premise-portfolio-category' ) )
				? 'Categories: ' . $category_list
				: ''; ?>
		</div>

		<!-- The tags -->
		<div class="pwpp-post-tags">
			<?php echo ( $tag_list = get_the_term_list( get_the_id(), 'premise-portfolio-tag' ) )
				? 'Tags: ' . $tag_list
				: ''; ?>
		</div><?
		return ob_get_clean();
	}

	/**
	 * Filter the excerpt length for permise portfilio items. defaults to 22
	 *
	 * @wp_hook excerpt_length
	 *
	 * @param   int $length excerpt legth
	 * @return  int         new excerpt length
	 */
	public static function portfolio_excerpt_trim( $length ) {
		global $post;
		if ( 'premise_portfolio' == $post->post_type  ) {
			return ( $new_length = apply_filters( 'pwp_portfolio_loop_excerpt' ) )
					 ? $new_length
					 : $length;
		}
		return $length;
	}
}
