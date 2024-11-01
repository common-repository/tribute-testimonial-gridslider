<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://boomdevs.com/
 * @since             1.0.0
 * @package           Tribute_Wordpress_Testimonial_Slider_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Tribute Testimonials – WordPress Testimonial Grid/Slider
 * Plugin URI:        https://boomdevs.com/product/tribute-testimonial-slider
 * Description:       Tribute - WordPress Testimonials plugin offers drag and drop testimonial builder with a live customizer to build any kind of grid or slider layout for your WordPress site.
 * Version:           1.0.4
 * Author:            BoomDevs
 * Author URI:        https://boomdevs.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bdbdtwts
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Plugin basic information.
 */
define( 'BDTWTS_DIR', plugin_dir_path( __FILE__ ) );
define( 'BDTWTS_NAME', 'bdtwts' );
define( 'BDTWTS_FULL_NAME', __( 'Tribute - WordPress Testimonial Grid/Slider', 'bdtwts' ) );
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BDTWTS_VERSION', '1.0.4' );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tribute-wordpress-testimonial-slider-activator.php
 */
function activate_tribute_wordpress_testimonial_slider_plugin() {
	require_once BDTWTS_DIR . 'includes/class-tribute-wordpress-testimonial-slider-activator.php';
	Tribute_Wordpress_Testimonial_Slider_Plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tribute-wordpress-testimonial-slider-deactivator.php
 */
function deactivate_tribute_wordpress_testimonial_slider_plugin() {
	require_once BDTWTS_DIR . 'includes/class-tribute-wordpress-testimonial-slider-deactivator.php';
	Tribute_Wordpress_Testimonial_Slider_Plugin_Deactivator::deactivate();
}


/**
 * Require Composer autoload
 */
require __DIR__ . '/vendor/autoload.php';


/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_tribute_testimonial_gridslider() {

    if ( ! class_exists( 'Appsero\Client' ) ) {
      require_once __DIR__ . '/appsero/src/Client.php';
    }

    $client = new Appsero\Client( 'f5e1c5a1-7aee-49ad-b46a-ae29dd5e9824', 'Tribute - WordPress Testimonial Grid/Slider', __FILE__ );

    // Active insights
    $client->insights()->init();

}

appsero_init_tracker_tribute_testimonial_gridslider();


//register_activation_hook( __FILE__, 'activate_tribute_wordpress_testimonial_slider_plugin' );
//register_deactivation_hook( __FILE__, 'deactivate_tribute_wordpress_testimonial_slider_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require BDTWTS_DIR . 'includes/class-bdtwts.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */


add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'tribute_plugin_page_link' );
 
function tribute_plugin_page_link( $actions ) {
   $actions[] = '<a class="doc_link" style="text-shadow: 1px 1px 1px #eee;font-weight: 700;" href="https://boomdevs.com/docs/tribute-wordpress-testimonial-grid-slider/">Docs</a>';
   $actions[] = '<a class="pro_link" style="color: #93003c;text-shadow: 1px 1px 1px #eee;font-weight: 700;" href="https://boomdevs.com/products/tribute-wordpress-testimonial-grid-slider" target="_blank">Go Pro</a>';
   return $actions;
}

// Remove all admin notice form widget
if ( isset($_GET['post_type']) && $_GET['post_type'] === 'tribute-widgets' ) {
	add_action('in_admin_header', 'tribute_remove_admin_notice', 9999);
}

if(isset($_GET['post']) &&  get_post_type($_GET['post']) === 'tribute-widgets') {
	add_action('in_admin_header', 'tribute_remove_admin_notice', 9999);
}
function tribute_remove_admin_notice() {
	remove_all_actions('admin_notices');
	remove_all_actions('all_admin_notices');
}

do_action( 'bdtwtsg/loaded' );

function run_tribute_wordpress_testimonial_slider_plugin() {

	$plugin = new BDTWTS();
	$plugin->run();

}
run_tribute_wordpress_testimonial_slider_plugin();
