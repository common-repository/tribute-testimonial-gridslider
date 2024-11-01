<?php
defined( 'ABSPATH' ) || exit;
/**
 * Handle plugin custom posts for this plugin.
 *
 * @link       https://boomdevs.com
 * @package    Tribute Testimonial slider
 */

class BDTWTS_Custom_Posts {
    
    // Tribute testimonial
    public static $testimonial_post_type = 'tribute-testimonials';
    public static $testimonial_widget = 'tribute-widgets';

    /**
     * Register tribute testimonial post.
     */
    public function tribute_register_custom_post() {
        $testimonial_args = [
            'labels' => [
                'menu_name'          => esc_html__( 'Testimonials', 'bdtwts' ),
                'name_admin_bar'     => esc_html__( 'Testimoinal', 'bdtwts' ),
                'add_new'            => esc_html__( 'Add testimoinal', 'bdtwts' ),
                'add_new_item'       => esc_html__( 'Add new testimoinal', 'bdtwts' ),
                'new_item'           => esc_html__( 'New testimoinal', 'bdtwts' ),
                'edit_item'          => esc_html__( 'Edit testimoinal', 'bdtwts' ),
                'view_item'          => esc_html__( 'View testimoinal', 'bdtwts' ),
                'update_item'        => esc_html__( 'View testimoinal', 'bdtwts' ),
                'all_items'          => esc_html__( 'All testimonials', 'bdtwts' ),
                'search_items'       => esc_html__( 'Search testimonials', 'bdtwts' ),
                'parent_item_colon'  => esc_html__( 'Parent testimoinal', 'bdtwts' ),
                'not_found'          => esc_html__( 'No testimonials found', 'bdtwts' ),
                'not_found_in_trash' => esc_html__( 'No testimonials found in Trash', 'bdtwts' ),
                'name'               => esc_html__( 'Testimonials', 'bdtwts' ),
                'singular_name'      => esc_html__( 'Testimoinal', 'bdtwts' ),
            ],
            'public'              => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => false,
            'show_in_rest'        => false,
            'capability_type'     => 'page',
            'hierarchical'        => false,
            'has_archive'         => true,
            'query_var'           => true,
            'can_export'          => true,
            'rewrite_no_front'    => false,
            'show_in_menu'        => false,
            'menu_icon'           => 'dashicons-editor-insertmore',
            'supports' => [
                'title',
            ],

            'rewrite' => true
        ];

        $tribute_widget_args = [
            'label'  => esc_html__( 'Widgets', 'text-domain' ),
            'labels' => [
                'menu_name'          => esc_html__( 'Widgets', 'bdtwts' ),
                'name_admin_bar'     => esc_html__( 'Widget', 'bdtwts' ),
                'add_new'            => esc_html__( 'Add widget', 'bdtwts' ),
                'add_new_item'       => esc_html__( 'Add new widget', 'bdtwts' ),
                'new_item'           => esc_html__( 'New widget', 'bdtwts' ),
                'edit_item'          => esc_html__( 'Edit widget', 'bdtwts' ),
                'view_item'          => esc_html__( 'View widget', 'bdtwts' ),
                'update_item'        => esc_html__( 'View widget', 'bdtwts' ),
                'all_items'          => esc_html__( 'All widgets', 'bdtwts' ),
                'search_items'       => esc_html__( 'Search widgets', 'bdtwts' ),
                'parent_item_colon'  => esc_html__( 'Parent Widget', 'bdtwts' ),
                'not_found'          => esc_html__( 'No widgets found', 'bdtwts' ),
                'not_found_in_trash' => esc_html__( 'No widgets found in Trash', 'bdtwts' ),
                'name'               => esc_html__( 'Tribute testimonial widgets', 'bdtwts' ),
                'singular_name'      => esc_html__( 'Tribute testimonial widgets', 'bdtwts' ),
            ],
            'public'              => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => false,
            'show_in_rest'        => false,
            'capability_type'     => 'page',
            'hierarchical'        => false,
            'has_archive'         => true,
            'query_var'           => true,
            'can_export'          => true,
            'rewrite_no_front'    => false,
            'show_in_menu'        => 'tribute-widgets',
            'supports' => ['title'],
            
            'rewrite' => true
        ];
    
        register_post_type( BDTWTS_Custom_Posts::$testimonial_post_type, $testimonial_args );
        register_post_type( BDTWTS_Custom_Posts::$testimonial_widget, $tribute_widget_args );
    }

    public function tribute_testimonial_register_taxonomy() {
        register_taxonomy(
            'tribute-testimonial-categories',
            'tribute-testimonials',
            array(
                'hierarchical' => true,
                'label' => esc_html__( 'Categories', 'bdtwts' ),
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'themes',
                    'with_front' => false
                )
            )
        );
    }
}