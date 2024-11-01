<?php
class Tribute_Meta_Box {

    public function tribute_testimonial_register_meta_boxes()
    {
        if( class_exists( 'CSF' ) ) {

            $prefix = 'tribute_testimonial_meta_';

            CSF::createMetabox( $prefix, array(
                'title'              => esc_html__('Testimonial Meta', 'bdtwts'),
                'post_type'          => 'tribute-testimonials',
                'data_type'          => 'serialize',
                'context'            => 'advanced',
                'priority'           => 'default',
                'exclude_post_types' => array(),
                'page_templates'     => '',
                'post_formats'       => '',
                'show_restore'       => false,
                'enqueue_webfont'    => false,
                'async_webfont'      => false,
                'output_css'         => true,
                'nav'                => 'normal',
                'theme'              => 'dark',
                'class'              => '',
            ));

              // Create a section
            CSF::createSection( $prefix, array(
                'fields'            => array(
                    array(
                        'id'            => 'author_img',
                        'type'          => 'media',
                        'title'         => esc_html__('Image', 'bdtwts'),
                    ),
                    array(
                        'id'            => 'author_img_2',
                        'type'          => 'media',
                        'title'         => esc_html__('Avatar', 'bdtwts'),
                    ),
                    array(
                        'id'            => 'name',
                        'type'          => 'text',
                        'title'         => esc_html__('Name', 'bdtwts'),
                    ),
                    array(
                        'id'            => 'designation',
                        'type'          => 'text',
                        'title'         => esc_html__('Designation', 'bdtwts'),
                    ),
                    array(
                        'id'            => 'description',
                        'type'          => 'textarea',
                        'title'         => esc_html__('Description', 'bdtwts'),
                    ),
                    array(
                        'id'            => 'rating',
                        'type'          => 'slider',
                        'title'         => esc_html__('Rating', 'bdtwts'),
                        'min'           => 1,
                        'max'           => 5,
                        'step'          => 1,
                        'default'       => 1,
                    ),
                    array(
                        'id'            => 'brand_logo',
                        'type'          => 'media',
                        'title'         => esc_html__('Company logo', 'bdtwts'),
                    ),
                    array(
                        'id'            => 'social_media_info',
                        'type'          => 'repeater',
                        'title'         => esc_html__('Social info', 'bdtwts'),
                        'button_title'      => esc_html__('Add New', 'bdtwts'),
                        'fields'        => array(
                            array(
                                'id'      => 'social_icon',
                                'type'    => 'icon',
                                'default' => 'fa fa-facebook',
                            ),
                            array(
                                'id'            => 'social_media_links',
                                'type'          => 'text',
                                'title'         => esc_html__('Social media links', 'bdtwts'),
                            ),
                        ),
                    ),
                ),
            ));
        }
    }

    // Register meta box for testimonial widget
    public function testimonial_register_widget_metabox() {
        add_meta_box( 'tribute_widget_meta', __( 'Tribute widget meta', 'bdtwts' ), [$this, 'render_testimonial_widget_html'], 'tribute-widgets' );
        add_meta_box( 'tributeSettingsPanel', __( 'Tribute testimonial settings panel render', 'bdtwts' ), [$this, 'render_testimonial_widget_html'], 'tribute-widgets' );
    }

    // Render widget meta box html
    public function render_testimonial_widget_html($post) {
        $tribute_widget_meta_value = get_post_meta( $post->ID, 'tribute_widget_meta', true );
        esc_attr( $tribute_widget_meta_value );
        echo "<input type='hidden' name='tribute_widget_meta_field' id='tribute_widget_meta_value' value='{$tribute_widget_meta_value}'>";
    }

    // Save testimonial widget meta value
    function testimonial_widget_meta_save( $post_id ) {
        if ( array_key_exists( 'tribute_widget_meta_field', $_POST ) ) {
            update_post_meta(
                $post_id,
                'tribute_widget_meta',
                $_POST['tribute_widget_meta_field']
            );
        }
    }

    // Remove screen option
    public function remove_screen_option() {
        return false;
    }

    /**
     * Remove the Publish box
     */
    public function remove_publish_box() {}
}