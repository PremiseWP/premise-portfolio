<?php 
/**
 * Build and display the options page
 *
 * @package premise-portfolio\classes
 */



/**
* 
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
	 * Plugin url
	 *
	 * @var string
	 */
	public $plugin_url = PLUGIN_URL;




	/**
	 * Plugin path
	 *
	 * @var strin
	 */
	public $plugin_path = PLUGIN_PATH;





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
	 * initiate our plugin
	 * 
	 * @return void does not return anything
	 */
	public function init() {
		add_action( 'meta_boxes', array( $this, 'add_meta_boxes' ) );
	}




	public function add_meta_boxes() {
		add_meta_box( 'metabox' );
	}
}

?>