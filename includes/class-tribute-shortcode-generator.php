<?php

class Tribute_Shortcode_Generator{
    public function shortcode_render($atts) {
        $atts = shortcode_atts(
            array(
                'id' => 'id',
            ), $atts );
        $afterDescription = "";
        $beforeDescription = "";
        $afterRating = "";
        $beforeRating = "";
        $afterName = "";
        $beforeName = "";
        $afterDesignation = "";
        $beforeDesignation = "";
        $afterSocial = "";
        $beforeSocial = "";
        $afterBrandLogo = "";
        $beforeBrandLogo = "";
        $afterThumbnail = "";
        $beforeThumbnail = "";
        $afterAvatar = "";
        $beforeAvatar = "";
        $afterWrapper = "";
        $beforeWrapper = "";

        return "<div class='tributeFrontEndRoot' 
                id='tributeFrontEndRoot_{$atts['id']}'
                data-idAttr='tributeFrontEndRoot_{$atts['id']}' data-id='{$atts['id']}' data-afterWrapper='".$afterWrapper."' data-beforeWrapper='".$beforeWrapper."'  data-afterDescription='".$afterDescription."' data-beforeDescription='".$beforeDescription."' data-afterRating='".$afterRating."' data-beforeRating='".$beforeRating."' data-afterName='".$afterName."'  data-beforeName='".$beforeName."'  data-afterDesignation='".$afterDesignation."'  data-beforeDesignation='".$beforeDesignation."'  data-afterSocial='".$afterSocial."' data-beforeSocial='".$beforeSocial."' data-afterBrandLogo='".$afterBrandLogo."' data-beforeBrandLogo='".$beforeBrandLogo."' data-afterThumbnail='".$afterThumbnail."' data-beforeThumbnail='".$beforeThumbnail."' data-afterAvatar='".$afterAvatar."' data-beforeAvatar='".$beforeAvatar."'></div>";
    }
}