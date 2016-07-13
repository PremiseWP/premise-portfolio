<?php
/**
 * Plugin Name: Premise Portfolio
 * Description: Plugin to display beautiful portfolio. Is meant to be silmple, user friednly, yet extremely flexible.
 * Plugin URI:	
 * Version:     1.0.0
 * Author:      Premise WP <info@premisewp.com> by: Mario Vallejo
 * Author URI:  http://premisewp.com
 * License:     GPL
 *
 * @prefix PWPP - Premise WP Portfolio
 *
 * @package premise-portfolio
 */

// Block direct access to this file.
defined( 'ABSPATH' ) or die();




/**
 * Define plugin path
 */
define( 'PWPP_PATH', plugin_dir_path( __FILE__ ) );




/**
 * Define plugin url
 */
define( 'PWPP_URL', plugin_dir_url( __FILE__ ) );




// Instantiate our main class and setup plugin
// Must use 'plugins_loaded' hook.
add_action( 'plugins_loaded', array( Premise_Portfolio::get_instance(), 'init' ) );

/**
 * Load Plugin!
 *
 * This is plugin main class.
 */
class Premise_Portfolio {


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
	public $plugin_url = PWPP_URL;




	/**
	 * Plugin path
	 *
	 * @var strin
	 */
	public $plugin_path = PWPP_PATH;





	/**
	 * Constructor. Intentionally left empty and public.
	 *
	 * @see 	init()
	 * @since 	1.0
	 */
	public function __construct() {}





	/**
	 * Access this plugin’s working instance
	 *
	 * @since   1.0
	 * @return  object instance of this class
	 */
	public static function get_instance() {
		null === self::$instance and self::$instance = new self;

		return self::$instance;
	}





	/**
	 * Setup Premise
	 *
	 * Does includes and registers hooks.
	 *
	 * @since   1.0
	 */
	public function init() {
		$this->do_includes();
		$this->do_hooks();
	}






	/**
	 * Includes
	 *
	 * @since 1.0
	 */
	protected function do_includes() {

		// Require Premise WP.
		if ( ! class_exists( 'Premise_WP' ) ) {

			// Require Premise WP plugin with the help of TGM Plugin Activation.
			require_once PWPP_PATH . 'lib/class-tgm-plugin-activation.php';

			add_action( 'tgmpa_register', array( $this, 'require_premise' ) );
		}

		
	}





	/**
	 * Premise Hooks
	 *
	 * Registers and enqueues scripts, adds classes to the body of DOM
	 */
	public function do_hooks() {

		# add hooks here
	}




	/**
	 * Require Premise WP if the class Premise_WP does not exist.
	 *
	 * @wp_hook tgmpa_register
	 * @see  do_includes()
	 * 
	 * @return void does not return anything
	 */
	public function resquire_premise() {
		
		$plugins = array(
			array(
				'name'               => 'Premise WP',
				'slug'               => 'Premise-WP',
				'source'             => 'https://github.com/PremiseWP/Premise-WP/archive/master.zip',
				'required'           => true,
				'version'            => '1.4.2',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
				'is_callable'        => '',
			),
		);

		$config = array(
			'id'           => 'pwpp-portfolio',
			'default_path' => '',
			'menu'         => 'pwpp-portfolio-install-plugins',
			'parent_slug'  => 'themes.php',
			'capability'   => 'edit_theme_options',
			'has_notices'  => true,
			'dismissable'  => true,
			'dismiss_msg'  => '',
			'is_automatic' => false,
			'message'      => '',
		);

		tgmpa( $plugins, $config );

	}
}