<?php
/**
 * The file that defines the plugin ajax class's
 */
class Tribute_Rest_Api {
    
    /**
     * Resgister rest api route
     */
    public function tribute_rest_routes() {
        register_rest_route( 'tribute-wordpress-testimonial-slider/v1', '/testimonials', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => [ $this, 'get_testimonials' ],
            'args' => [
                'id'
            ],
            'permission_callback' =>  '__return_true',
        ]);

        register_rest_route( 'tribute-wordpress-testimonial-slider/v1', '/settings', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => [ $this, 'get_widget_settings' ],
            'args' => [
                'id'
            ],
            'permission_callback' =>  '__return_true',
        ]);
        register_rest_route('tribute-wordpress-testimonial-slider/v1', 'testimonialsLists', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => [ $this, 'testimonials_list' ],
            'args' => [
                'id'
            ],
            'permission_callback' =>  '__return_true',
        ]);
    }
    /**
     * Get testimonials by id
     *
     * @since 1.0.0
     */
    public function testimonials_list($request) {
        $tribute_widget_meta_value = get_post_meta( $_GET['id'], 'tribute_widget_meta', true );
       
        $tribute_widget = json_decode($tribute_widget_meta_value);
        
        $testimonial_id = [];
        $testimonial_info = [];
        if($tribute_widget->testimonialQueryParam == 'category') {
            foreach ( $tribute_widget->selectedTestimonial as $selectedTestimonila ) {
                $testimonial_id[] = (array)$selectedTestimonila;
            }
            $the_query = new WP_Query( array(
                'post_type' => 'tribute-testimonials',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'tribute-testimonial-categories',
                        'field'    => 'id',
                        'terms' => explode(',', implode( ',', array_column($testimonial_id, 'value')))
                    ),
                ),
            ));

            $testimonials = $the_query->posts;
            foreach($testimonials as $key => $testimonial) {
                $testimonial_info[] = array(
                    'testimonial_meta' => get_post_meta( $testimonial->ID, 'tribute_testimonial_meta_', true )
                );
            }
        } else {
            foreach ( $tribute_widget->selectedTestimonial as $selectedTestimonila ) {
                $testimonial_id[] = (array)$selectedTestimonila;
            }
            $args = array(
                'post_type' => 'tribute-testimonials',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'post__in' => explode(',', implode( ',', array_column($testimonial_id, 'value')))
            );
            $testimonials = get_posts($args);
            foreach($testimonials as $key => $testimonial) {
                $testimonial_info[]    = array(
                    'testimonial_meta' => get_post_meta( $testimonial->ID, 'tribute_testimonial_meta_', true )
                );
            }
        }

        return rest_ensure_response($testimonial_info);
    }

    /**
     * Get widget settings by id
     *
     * @since 1.0.0
     */
    public function get_widget_settings($request) {
        $tribute_widget_meta_value = get_post_meta( $_GET['id'], 'tribute_widget_meta', true );
        $tribute_widget = json_decode($tribute_widget_meta_value);
        return rest_ensure_response($tribute_widget);
    }

    /**
     * Get testimonial by id
     *
     * @since 1.0.0
     */
    public function get_testimonials($request) {

        $testimonial_info = array();
        if( $_GET['queryBy'] == 'category' ) {
            $the_query = new WP_Query( array(
                'post_type' => 'tribute-testimonials',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'tribute-testimonial-categories',
                        'field'    => 'id',
                        'terms' => $_GET['ID']
                    ),
                ),
            ) );

            $testimonials = $the_query->posts;
            foreach($testimonials as $key => $testimonial) {
                $testimonial_meta    = get_post_meta( $testimonial->ID, 'tribute_testimonial_meta_', true );
                $testimonial_info[] = array(
                    'id'        => $testimonial->ID,
                    'title'     => $testimonial->post_title,
                    'testimonial_meta' => $testimonial_meta
                );

            }
        } elseif( $_GET['queryBy'] == 'testimonial' ) {
            $args = array(
                'post_type' => 'tribute-testimonials',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'numberposts' => count($_GET['ID']),
                'post_status' => 'publish',
                'post__in' => $_GET['ID']
            );

            $testimonials = get_posts($args);
            foreach($testimonials as $key => $testimonial) {
                $testimonial_meta    = get_post_meta( $testimonial->ID, 'tribute_testimonial_meta_', true );
                $testimonial_info[] = array(
                    'id'        => $testimonial->ID,
                    'title'     => $testimonial->post_title,
                    'testimonial_meta' => $testimonial_meta
                );

            }
        } else {
            $testimonial_info = array('Please select query param');
        }

        return rest_ensure_response( $testimonial_info );
    }
}