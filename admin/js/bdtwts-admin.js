(function($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */
    $('.shortcode__copy').on('click', function() {
        // alert($(this).text());
        if ($(this).parent().find(".shortcode_copied").length !== 1) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(this).html()).select();
            document.execCommand("copy");
            $temp.remove();
            $("<span class='shortcode_copied'>Copied</span>").appendTo(this).fadeIn('slow');
            setTimeout(function() {
                $('.shortcode_copied').remove().fadeOut(5000);
            }, 5000);
        } else {
            alert('This shortcode already Copied');
        }
    });

    $('.post-type-tribute_testimonial .csf-field-slider .csf-input-number').attr({
        "max": 5, // substitute your own
        "min": 1 // values (or variables) here
    });


    $('.post-type-tribute_testimonial #titlewrap input').attr({
            "required": true,
        })
        // titlewrap
})(jQuery);