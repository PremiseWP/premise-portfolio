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

		add_filter( 'template_include', array( $this, 'portfolio_page_template' ), 99 );

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
		echo '<h4>Call to Action</h4>';

		// the url
		premise_field( 'text', array( 
			'name' => 'premise_portfolio[cta-url]', 
			'placeholder' => 'project url', 
			'label' => 'Call to Action URL', 
			'wrapper_class' => 'span4', 
			'context' => 'post', 
		) );

		// the text
		premise_field( 'text', array( 
			'name' => 'premise_portfolio[cta-text]', 
			'placeholder' => 'Go to project', 
			'label' => 'Call to Action URL', 
			'wrapper_class' => 'span4', 
			'context' => 'post', 
		) );
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
	

	function portfolio_page_template( $template ) {
// var_dump($template);
// var_dump(dirname( __FILE__ ) . '/view/single-premise-portfolio.php');
		if ( is_page( 'premise_portfolio' )  ) {
			$new_template = locate_template( array( 'single-premise-portfolio.php' ) );
			if ( '' != $new_template ) {
				return $new_template ;
			}
		}

		return (string) PWPP_PATH . '/view/single-premise-portfolio.php';
		// if ( $overridden_template = locate_template( 'some-template.php' ) ) {
		// 	// locate_template() returns path to file
		// 	// if either the child theme or the parent theme have overridden the template
		// 	load_template( $overridden_template );
		// }
		// else {
		// 	// If neither the child nor parent theme have overridden the template,
		// 	// we load the template from the 'templates' sub-directory of the directory this file is in
		// 	load_template( dirname( __FILE__ ) . '/templates/some-template.php' );
		// }
	}
}

?>