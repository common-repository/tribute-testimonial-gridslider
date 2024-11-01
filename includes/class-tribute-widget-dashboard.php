<?php
defined( 'ABSPATH' ) || exit;
/**
 * Handle plugin widget for this plugin.
 *
 * @link       https://boomdevs.com
 * @package    Tribute Testimonial slider
 */

class Tribute_Widget_Dashboard {

    public function __construct() {
        add_filter( 'post_row_actions', [$this, 'remove_post_action'], 10, 1 );
    }

    // Add custom column in exercise
    public function filter_posts_columns( $columns ) {
        unset (
            $columns['title'],
            $columns['date']
        );
        $columns['name'] = esc_html__( 'Name', 'bdtwts' );
        $columns['shortcode'] = esc_html__( 'Shortcode', 'bdtwts' );
        $columns['date'] = esc_html__( 'Date', 'bdtwts' );
        return $columns;
    }

    // Set custom column value
    public function custom_column_value( $column, $post_id ) {
        if ( $column == 'name' ) {
            $post_status = get_post($post_id);
            if($post_status->post_status !== 'draft') {
                $widget = get_post_meta( $post_id, 'tribute_widget_meta', true );
                $widget_name = json_decode($widget)->widgetName;
                echo esc_html($widget_name);
            } else {
                echo wp_kses_post('<strong>
                    <a class="row-title" href="/wp-admin/post.php?post='.$post_id.'&action=edit" aria-label="“(no title)” (Edit)">Untitled</a> — <span class="post-state">Draft </span>
                </strong>');
            }
        }

        // Widget column
        if ( $column == 'shortcode' ) {
            $post_status = get_post($post_id);
            if($post_status->post_status !== 'draft') {
                echo wp_kses_post('<div class="shortcode__copy" style="cursor: pointer">[tribute_testimonials_slider id="'.$post_id.'"]</div>');
            } else {
                echo wp_kses_post('<div class="widget__draft" style="cursor: pointer">This widget under draft first publish your widget.</div>');
            }
        }
    }

    
    public function remove_post_action( $actions )
    {
        if( get_post_type() === 'tribute-widgets' || get_post_type() === 'tribute-testimonials' )
            unset( $actions['view'] );
            unset( $actions['inline hide-if-no-js'] );
        return $actions;
    }
}