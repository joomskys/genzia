(function($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSParallaxMouseMoveHandler = function( $scope, $ ) {
            $(window).on('mousemove', function(e) {
                var w = $(window).width();
                var h = $(window).height();
                var offsetX = 0.5 - e.clientX / w;
                var offsetY = 0.5 - e.clientY / h;

                $scope.find(".cms-parallax-mouse-move").each(function(i, el) {
                    var offset = parseInt($(el).data('offset'));
                    var translate = "translate3d(" + Math.round(offsetX * offset) + "px," + Math.round(offsetY * offset) + "px, 0px)";

                    $(el).css({
                        'transform': translate
                    });
                });
            });
        };

    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function() {
        //elementorFrontend.hooks.addAction('frontend/element_ready/cms_banner.default', WidgetCMSParallaxMouseMoveHandler);
        //elementorFrontend.hooks.addAction('frontend/element_ready/cms_theme_ai_image_generate.default', WidgetCMSParallaxMouseMoveHandler);
        //elementorFrontend.hooks.addAction('frontend/element_ready/cms_theme_chatbot.default', WidgetCMSParallaxMouseMoveHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_slider.default', WidgetCMSParallaxMouseMoveHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_video_player.default', WidgetCMSParallaxMouseMoveHandler);
    });
})(jQuery);