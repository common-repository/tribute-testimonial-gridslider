<?php
defined( 'ABSPATH' ) || exit;
/**
* Handle plugin menu
*
* @link       https://boomdevs.com
* @package    Tribute Testimonial slider
*/

class Tribute_Menu {
    /**
     * Register plugin admin page menu
     */
    public function tribute_admin_menu()
    {
        $parent_slug = 'tribute-widgets';
        $capability = 'manage_options';
        add_menu_page( __('Tribute', 'bdtwts'), __('Tribute', 'bdtwts'), $capability, $parent_slug, '', 'dashicons-format-chat', 40, null );
        add_submenu_page( $parent_slug, esc_html__('Testimonials', 'bdtwts'), esc_html__('Testimonials', 'bdtwts'), $capability, 'edit.php?post_type=tribute-testimonials');
        add_submenu_page( $parent_slug, esc_html__('Categories', 'bdtwts'), esc_html__('Categories', 'bdtwts'), $capability, 'edit-tags.php?taxonomy=tribute-testimonial-categories&post_type=tribute-testimonials');
    }
}