<?php
require_once BDTWTS_DIR . 'includes/class-bdtwts-utils.php';
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://boomdevs.com/
 * @since      1.0.0
 *
 * @package    Tribute_Wordpress_Testimonial_Slider_Plugin
 * @subpackage Tribute_Wordpress_Testimonial_Slider_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Tribute_Wordpress_Testimonial_Slider_Plugin
 * @subpackage Tribute_Wordpress_Testimonial_Slider_Plugin/public
 * @author     BoomDevs <admin@boomdevs.com>
 */
class Tribute_Wordpress_Testimonial_Slider_Plugin_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	public $localize_hook = 'tribute-wordpress-testimonial-frontend-slider-free';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		if(Boomdevs_BDTWTS_Utils::isProActivated()) {
			$this->localize_hook = 'tribute-wordpress-testimonial-frontend-slider-pro';
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . 'bootstrap', plugin_dir_url( __FILE__ ) . '../dist/bootstrap-grid.min.css', array(), '4.0.0', 'all' );
		wp_enqueue_style( 'fa5', plugin_dir_url( __FILE__ ) . '../public/css/all.css', array(), '5.13.0', 'all' );
		wp_enqueue_style( 'fa5-v4-shims', plugin_dir_url( __FILE__ ) . '../public/css/v4-shims.css', array(), '5.13.0', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . '../dist/frontend.css', array(), time(), 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tribute_Wordpress_Testimonial_Slider_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tribute_Wordpress_Testimonial_Slider_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( 'tribute-wordpress-testimonial-frontend-slider-free', plugin_dir_url( __FILE__ ) . '../dist/frontend.js', array( 'jquery' ), time(), true );

        wp_localize_script($this->localize_hook, 'url', [
            'rest_api_url' => home_url('/wp-json/tribute-wordpress-testimonial-slider/v1'),
        ]);
	}
}
