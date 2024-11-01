<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://boomdevs.com/
 * @since      1.0.0
 *
 * @package    Tribute_Wordpress_Testimonial_Slider_Plugin
 * @subpackage Tribute_Wordpress_Testimonial_Slider_Plugin/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Tribute_Wordpress_Testimonial_Slider_Plugin
 * @subpackage Tribute_Wordpress_Testimonial_Slider_Plugin/includes
 * @author     BoomDevs <admin@boomdevs.com>
 */
class BDTWTS {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Tribute_Wordpress_Testimonial_Slider_Plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'BDTWTS_VERSION' ) ) {
			$this->version = BDTWTS_VERSION;
		} else {
			$this->version = '1.0.4';
		}
		$this->plugin_name = 'tribute-wordpress-testimonial-slider';

		$this->load_dependencies();
		$this->set_locale();
		$this->register_menu();
		$this->register_custom_posts();
		$this->register_meta_box();
		$this->register_rest_api_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->handle_custom_post_messages();
		$this->tribute_widget_dashboard();

		if(! Boomdevs_BDTWTS_Utils::isProActivated()) {
			$this->shortcode_generate();
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Tribute_Wordpress_Testimonial_Slider_Plugin_Loader. Orchestrates the hooks of the plugin.
	 * - Tribute_Wordpress_Testimonial_Slider_Plugin_i18n. Defines internationalization functionality.
	 * - Tribute_Wordpress_Testimonial_Slider_Plugin_Admin. Defines all hooks for the admin area.
	 * - Tribute_Wordpress_Testimonial_Slider_Plugin_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
         * This library use for metabox
         */
        require_once BDTWTS_DIR . 'libs/codestar-framework/codestar-framework.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once BDTWTS_DIR . 'includes/class-bdtwts-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once BDTWTS_DIR . 'includes/class-tribute-wordpress-testimonial-slider-plugin-i18n.php';

        /**
         * The class responsible for defining all custom posts action
         */
        require_once BDTWTS_DIR . 'includes/class-bdtwts-custom-posts.php';

		/**
		 * The class responsible for all custom posts messages
		 */
		require_once BDTWTS_DIR . 'includes/class-bdtwts-messages.php';

        /**
         * The class responsible for defining all menu action
         */
        require_once BDTWTS_DIR . 'includes/class-tribute-menu.php';

		/**
         * The class responsible for defining all ajax hooks.
         */
        require_once BDTWTS_DIR . 'includes/class-tribute-rest-api.php';

        /**
         * The class responsible for defining all meta boxes action
         */
		require_once BDTWTS_DIR . 'includes/class-tribute-meta-box.php';

		/**
		 * Shortcode generator for slider
		 */
        require_once BDTWTS_DIR . 'includes/class-tribute-shortcode-generator.php';

		/**
         * The class responsible for defining testimonial widget dashboard
         */
        require_once BDTWTS_DIR . 'includes/class-tribute-widget-dashboard.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once BDTWTS_DIR . 'admin/class-bdtwts-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once BDTWTS_DIR . 'public/class-tribute-wordpress-testimonial-slider-plugin-public.php';

    // add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links' );


		$this->loader = new Tribute_Wordpress_Testimonial_Slider_Plugin_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Tribute_Wordpress_Testimonial_Slider_Plugin_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Tribute_Wordpress_Testimonial_Slider_Plugin_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Tribute_Wordpress_Testimonial_Slider_Plugin_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_head', $plugin_admin, 'enqueue_styles', 999 );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts', 999);
	}

    /**
     * Register admin page menu
     */
    private function register_menu() {
        $menu = new Tribute_Menu();
        $this->loader->add_action( 'admin_menu', $menu, 'tribute_admin_menu' );
    }

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Tribute_Wordpress_Testimonial_Slider_Plugin_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles', 999 );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts', 999999);

	}

	/**
	 * Register shortcode generator
	 *
	 * @return void
	 */
    private function shortcode_generate() {
	    $shortcode_generator_obj = new Tribute_Shortcode_Generator();
	    add_shortcode('tribute_testimonials_slider', [$shortcode_generator_obj, 'shortcode_render']);
    }

    /**
     * Register plugin custom post
     *
     * @access   private
     */
	private function register_custom_posts() {
        $custom_posts = new BDTWTS_Custom_Posts();
        $this->loader->add_action( 'init', $custom_posts, 'tribute_register_custom_post' );
		$this->loader->add_action( 'init', $custom_posts, 'tribute_testimonial_register_taxonomy' );
    }

	/**
	 * Register custom post type messages
	 *
	 * @return void
	 */
	private function handle_custom_post_messages() {
		$custom_message = new BDTWTS_message();
		$this->loader->add_filter( 'bulk_post_updated_messages', $custom_message, 'bulk_post_updated_messages_filter', 10, 2 );
	}
	/**
	 * Register meta box
	 *
	 * @return void
	 */
    private function register_meta_box() {
        $meta_box = new Tribute_Meta_Box();
		$meta_box->tribute_testimonial_register_meta_boxes();
		$this->loader->add_action( 'add_meta_boxes', $meta_box, 'testimonial_register_widget_metabox' );
		$this->loader->add_filter('screen_options_show_screen', $meta_box, 'remove_screen_option');
		$this->loader->add_action( 'save_post', $meta_box, 'testimonial_widget_meta_save' );
		$this->loader->add_action( 'admin_menu', $meta_box, 'remove_publish_box' );
    }
	private function tribute_widget_dashboard() {
		$widgetDashboard = new Tribute_Widget_Dashboard();
		$this->loader->add_filter( 'manage_tribute-widgets_posts_columns', $widgetDashboard, 'filter_posts_columns', 10, 2 );
		$this->loader->add_action( 'manage_tribute-widgets_posts_custom_column', $widgetDashboard, 'custom_column_value', 10, 2);
	}


	/**
     * Register plugin rest api hooks.
     *
     * @since    1.0.0
     * @access   private
     */
    private function register_rest_api_hooks() {
        $plugin_rest_api = new Tribute_Rest_Api();
		$this->loader->add_action( 'rest_api_init', $plugin_rest_api, 'tribute_rest_routes');
    }

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Tribute_Wordpress_Testimonial_Slider_Plugin_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}