<?php
class Boomdevs_BDTWTS_Utils {
    public static function isProActivated() {
        
        if (class_exists('SureCart\Licensing\Client')) {
            $activation_key = get_option('tribute-wordpresstestimonialgrid/sliderpro_license_options');

            if( $activation_key && count($activation_key) > 0 && isset($activation_key['sc_license_key']) && $activation_key['sc_license_key'] !== '') {
                return true;
            }
        }else {
            if(class_exists('Tribute_Wordpress_Testimonial_Slider_Pro')) {
                return true;
            }
        }

        return false;
    }
}