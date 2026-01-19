(function ($) {
    "use strict";
    // CMSProcessHandler
    var CMSProcessHandler = function($scope, $) {
        // Swiper Scroll
        const Swiper = elementorFrontend.utils.swiper,
            carousel = $scope.find(".cms-swiper-vertical"),
            carousel_settings = {
                direction: "vertical",
                mousewheel: true,
                parallax: false,
                autoplay: {
                    delay: 2000,
                    pauseOnMouseEnter: true
                },
                slidesPerView: 3,
                slidesPerGroup: 1,
                spaceBetween: 56,
                speed: 1000,
                navigation: false,
                pagination: false,
                loop: true,
                on:{
                    afterInit: function(swiper) {
                        /*swiper.appendSlide(
                          '<div class="swiper-slide"></div>'
                        );*/
                        let thumbsSliderEls = $scope.find('.cms-process-banners');
                        if (thumbsSliderEls.length > 0) {
                            let thumbsSlider = new Swiper(thumbsSliderEls, {
                                loop: false,
                                slidesPerView: 1,
                                slidesPerGroup: 1,
                                effect: 'fade',
                                on: {
                                    afterInit: function(thumbsSwiper) {
                                        swiper.thumbs = {
                                            swiper: thumbsSwiper
                                        };
                                    },
                                },
                            });
                        }
                    }
                },
                breakpoints:{
                    1025 : {
                        slidesPerView: 2,
                        slidesPerGroup: 1
                    }
                }
            };
        carousel.each(function(index, element) {
            var swiper = new Swiper(carousel, carousel_settings);
        });
    };
    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_process.default', CMSProcessHandler);
    } );
})(jQuery);