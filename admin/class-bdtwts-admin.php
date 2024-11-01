<?php
require_once BDTWTS_DIR . 'includes/class-bdtwts-utils.php';
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://boomdevs.com/
 * @since      1.0.0
 *
 * @package    Tribute_Wordpress_Testimonial_Slider_Plugin
 * @subpackage Tribute_Wordpress_Testimonial_Slider_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tribute_Wordpress_Testimonial_Slider_Plugin
 * @subpackage Tribute_Wordpress_Testimonial_Slider_Plugin/admin
 * @author     BoomDevs <admin@boomdevs.com>
 */
class Tribute_Wordpress_Testimonial_Slider_Plugin_Admin {

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

	public $localize_hook_initiate = 'tribute_wordpress_testimonial_grid_slider_free';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		if(Boomdevs_BDTWTS_Utils::isProActivated()) {
			$this->localize_hook_initiate = 'tribute_wordpress_testimonial_grid_slider_pro';
		}

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		$screen = get_current_screen();
		if ( $screen->id === 'tribute-widgets') {
			wp_enqueue_style( 'fa5', plugin_dir_url( __FILE__ ) . '../public/css/all.css', array(), '5.13.0', 'all' );
			wp_enqueue_style( 'fa5-v4-shims', plugin_dir_url( __FILE__ ) . '../public/css/v4-shims.css', array(), '5.13.0', 'all' );
			wp_enqueue_style( $this->plugin_name . 'bootstrap', plugin_dir_url( __FILE__ ) . '../dist/bootstrap-grid.min.css', array(), '4.0.0', 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . '../dist/bundle.css', array(), time(), 'all' );
		}
		if($screen->id === 'tribute-widgets' || $screen->id === 'tribute-testimonials') {
			wp_enqueue_style( $this->plugin_name . 'admin-css', plugin_dir_url( __FILE__ ) . 'css/bdtwts-admin.css', array(), time(), 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */

	public function enqueue_scripts() {
		wp_enqueue_script( 'tribute_wordpress_testimonial_grid_slider_free', plugin_dir_url( __FILE__ ) . '../dist/bundle.js', array( 'jquery' ), time(), true );
		
		// Get testimonials
		$testimonial_info = array();
        $the_query = new WP_Query( array(
            'post_type' => 'tribute-testimonials',
			'post_status' => 'publish',
			'posts_per_page' => -1,
        ) );
        $testimonials = $the_query->posts;
        foreach($testimonials as $key => $testimonial) {
			$testimonial_info[] = array(
				'value'        	=> $testimonial->ID,
				'label'     	=> $testimonial->post_title,
			);
        }

		// Get testimonial categories
		$testimonial_categories = get_terms( array(
			'taxonomy' => 'tribute-testimonial-categories',
			'orderby' => 'name',
			'order'   => 'ASC',
			'hide_empty' => false
		));

        // Testimonial widgets lists
        $the_query = new WP_Query( array(
            'post_type' => 'tribute-widgets',
            'post_status' => 'publish',
			'posts_per_page' => -1,
        ) );

        $testimonial_widgets = [];
        $widgets_lists = $the_query->posts;
        foreach($widgets_lists as $key => $widget_list) {
            $widget_meta = get_post_meta($widget_list->ID,'tribute_widget_meta',true);
            $widgetObj = json_decode($widget_meta);
            if ($widgetObj !== null) {
                $testimonial_widgets[] = array(
                    'value'        	=> $widget_list->ID,
                    'label'     	=> json_decode($widget_meta)->widgetName,
                );
            }
        }

		array_unshift($testimonial_widgets, array(
            'value' => 'none',
            'label' => 'Select testimonial'
        ));

		// Testimonial widget style
		$tribute_widget = [];
		if(isset($_GET['post'])) {
			$tribute_widget_meta_value = get_post_meta( $_GET['post'], 'tribute_widget_meta', true );
			$tribute_widget = json_decode($tribute_widget_meta_value);
		}

		wp_localize_script($this->localize_hook_initiate, 'tributeInfo', [
			'testimonials' => $testimonial_info,
            'widgets_lists' => $testimonial_widgets,
			'testimonials_categories' => $testimonial_categories,
			'pluginUri' => plugin_dir_url( __DIR__ ),
			'rest_api_url' => home_url('/wp-json/tribute-wordpress-testimonial-slider/v1'),
			'nonce' => wp_create_nonce('wp_rest'),
			'tribute_widget' => $tribute_widget,
			'plugin_name' => str_replace('-', ' ', $this->plugin_name),
			'plugin_version' => $this->version
		]);
		wp_enqueue_script( $this->plugin_name . 'main', plugin_dir_url( __FILE__ ) . 'js/bdtwts-admin.js', array( 'jquery' ), time(), true );
	}
}