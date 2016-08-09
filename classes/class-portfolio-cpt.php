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
		new PremiseCPT( array(
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
				'custom-fields',
			),
		) );
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
		if ( in_array( $post_type, $this->post_type ) )
			add_meta_box( 'pwpp-cpt-meta-box', 'Portfolio Item Options', array( $this, 'render_meta_box' ), 'premise_portfolio', 'normal', 'high' );
	}



	/**
	 * render the metabox content
	 *
	 * @return strinf the html for the meta box content
	 */
	public function render_meta_box() {
		wp_nonce_field( 'premise_portfolio_nonce_check', 'premise_portfolio_nonce' );

		// Add a call to action
		?>
		<div class="premise-row">
			<div class="col2">
				<h4>Insert A Call To Action</h4>
				<p><i class="description">This is the main button displayed under the featured image.</i></p>
				<?php
				// the url
				premise_field( 'text', array(
					'name' => 'premise_portfolio[cta-url]',
					'placeholder' => 'project url',
					'label' => 'Call to Action URL',
					'context' => 'post',
				) );

				// the text
				premise_field( 'text', array(
					'name' => 'premise_portfolio[cta-text]',
					'placeholder' => 'Go to project',
					'label' => 'Call to Action Text',
					'context' => 'post',
				) );
				?>

				<h4>Excerpt Length</h4>
				<?php
				premise_field( 'text', array(
					'name' => 'premise_portfolio[excerpt]',
					'placeholder' => '22',
					'label' => 'Enter number of words',
					'context' => 'post',
					'style' => 'max-width: 60px;',
				) );
				?>
			</div>
		</div>
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

        $pwpp_mb = $_POST['premise_portfolio'];

        update_post_meta( $post_id, 'premise_portfolio', $pwpp_mb );
	}


	/*
		Loading the template
	 */


	/**
	 * replace the template for our portfolio items
	 *
	 * By naming a a file 'single-premise-portfolio.php' and placing it in the theme's directory
	 * the plugin will try to load that theme instead of our default. This makes it very easy to
	 * create custom templates for the plugin. Looks for the file in the child theme first, then
	 * the parent theme if it cant find it. lastly it loads our default template if neither theme
	 * had the file 'single-premise-portfolio.php'. And of course, if we are not in the premise-portfolio
	 * post_type then we return the template that Wordpress was going to load - we dont change anything.
	 *
	 * @wp_hook  template_include
	 *
	 * @param  string $template the current template. the one would normally be loaded.
	 * @return string           the new template. either our own template our the theme's template. or the current template
	 */
	function portfolio_page_template( $template ) {
		global $post;

		if ( 'premise_portfolio' == $post->post_type  ) {
			// check if the theme is trying to overwrite the template
			$new_template = locate_template( array( 'single-premise-portfolio.php' ) );
			if ( '' != $new_template ) {
				return $new_template ;
			}
			return (string) PWPP_PATH . '/view/single-premise-portfolio.php';
		}
		return $template;
	}



	/**
	 * Filter the excerpt length for permise portfilio items. defaults to 22
	 * but can be cnfigurable from the backend.
	 *
	 * @wp_hook excerpt_length
	 *
	 * @param  int $length excerpt legth
	 * @return int         new excerpt length
	 */
	function portfolio_excerpt_trim( $length ) {
		global $post;

		if ( 'premise_portfolio' == $post->post_type  ) {
			return ( '' !== $new_length = ( string ) premise_get_value( 'premise_portfolio[excerpt]', array( 'context' => 'post', 'id' => $post->ID ) ) ) ? $new_length : 22;
		}
		return $length;
	}
}
