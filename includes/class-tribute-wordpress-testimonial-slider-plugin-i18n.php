<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://boomdevs.com/
 * @since      1.0.0
 *
 * @package    Tribute_Wordpress_Testimonial_Slider_Plugin
 * @subpackage Tribute_Wordpress_Testimonial_Slider_Plugin/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Tribute_Wordpress_Testimonial_Slider_Plugin
 * @subpackage Tribute_Wordpress_Testimonial_Slider_Plugin/includes
 * @author     BoomDevs <admin@boomdevs.com>
 */
class Tribute_Wordpress_Testimonial_Slider_Plugin_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'tribute-wordpress-testimonial-slider',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}
