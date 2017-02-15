<?php
/**
 * Create and handle our shortcde to display portfolio items.
 *
 * @package premise-portfolio\classes
 */

/**
 * This class handles our shortcode. It displays and registers the shortcode.
 */
class PWPP_Shortcode {

	/**
	 * Plugin instance.
	 *
	 * @see get_instance()
	 *
	 * @var object
	 */
	protected static $instance = null;


	/**
	 * Holds the shortcode params for public use. This is useful for templating.
	 *
	 * @var array
	 */
	public static $params = array();


	/**
	 * Thes shortcode defaults
	 *
	 * @var array
	 */
	public $defaults = array(
		'grid' => 'row',
		'columns' => 'col4',
		'class' => '',
		'cat' => '',
	);


	protected  static $query_args = array(
		'post_type' => 'premise_portfolio',
		'posts_per_page' => -1,
	);


	/**
	 * Save the wp query
	 *
	 * @var null
	 */
	protected static $query = null;


	/**
	 * begin with a default template.
	 *
	 * @var string
	 */
	public $loop_tmpl = PWPP_PATH . '/view/loop-premise-portfolio.php';



	/**
	 * creates our custom post type. The custom post type class neeeds to be initiated on init. so we run it here.
	 *
	 * @see 	init()
	 * @since 	1.0.0
	 */
	public function __construct() {
		// set the default columns if it has been changed from the options page
		if ( $_cols = premise_get_value( 'pwpp_portfolio[loop][cols]' ) ) {
			$this->defaults['columns'] = esc_attr( $_cols );
		}

		self::$query_args = array(
			'post_type' => 'premise_portfolio',
			'posts_per_page' => -1,
		);
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
	public function init( $atts ) {
		// get these params and sve them in our object for public use.
		$a = shortcode_atts( $this->defaults, $atts, 'pwp_portfolio' );

		// normalize columns param
		$a['columns'] = (string) ( 6 >= (int) $a['columns'] && 2 <= (int) $a['columns'] ) ? 'col'.$a['columns'] : $a['columns'];

		// normalize categories
		if ( isset( $a['cat'] ) && ! empty( $a['cat'] ) ) {
			self::$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'premise-portfolio-category',
					'field'    => ( preg_match( '/[^0-9,]/', $a['cat'] ) ) ? 'slug'                    : 'term_id',
					'terms'    => ( preg_match( '/,/', $a['cat'] ) )       ? explode( ',', $a['cat'] ) : $a['cat'],
				),
			);
		}

		// Allow themes to override the tamllate that gets loaded
		if ( '' !== ( $new_loop_tmpl = locate_template( 'loop-premise-portfolio.php' ) ) ) {
			$this->loop_tmpl = $new_loop_tmpl;
		}

		return $this->do_loop();
	}



	/**
	 * performs the loop. returns the html for the posts grid
	 *
	 * @return string html for posts grid
	 */
	protected function do_loop() {
		$_html = '';

		// get the portfolio items
		self::$query = new WP_query( self::$query_args );

		// Get the template
		ob_start();
			include $this->loop_tmpl;
		$_html = ob_get_clean();

		return (string) $_html;
	}


	/*
		Helpers
	 */


	/**
	 * returns the shortcode grid param. called from our template pwpp_get_shortcode_atts().
	 *
	 * @see pwpp_get_shortcode_atts uses this function. located in lib/functions.php
	 *
	 * @return string column class to set the number of columns 1-6. defaults to 4. returns value already escaped using esc_attr();
	 */
	public static function get_shortcode_atts() {
		return self::$params;
	}


	/**
	 * return the query's have_posts() function
	 *
	 * @return mix return the wp have_posts() function scoped to our query of portfolio items
	 */
	public static function have_posts() {
		return self::$query->have_posts();
	}


	/**
	 * return the query's the_post() function
	 *
	 * @return mix return the wp the_post() function scoped to our query of portfolio items
	 */
	public static function the_post() {
		return self::$query->the_post();
	}
}

?>
