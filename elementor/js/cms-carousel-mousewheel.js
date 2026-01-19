(function($) {
    // CMS Swiper Mouse Wheel
    var CMSSwiperMouseWheelHandler = function($scope, $) {
        const Swiper = elementorFrontend.utils.swiper,
            carousel             = $scope.find(".cms-carousel-mousewheel"),
            direction            = carousel.data('direction'),
            spaceBetween         = carousel.data('spacebetween'),
            speed                = carousel.data('speed'),
            hoverPause           = carousel.data('hoverpause'),
            disableOnInteraction = carousel.data('disableoninteraction'),
            loop                 = carousel.data('loop'),
            carousel_settings = {
                wrapperClass: 'cms-swiper-wrapper',
                slideClass: 'cms-swiper-slide',
                slidesPerView: 'auto',
                slidesPerGroup: 1,
                centeredSlides: true,
                spaceBetween: 0,
                //speed: speed,
                //watchSlidesProgress: true,
                //watchSlidesVisibility: true,
                autoplay: false,
                loop: false,
                navigation: false,
                pagination: {
                    el: ".cms-carousel-dots",
                    clickable: true,
                    bulletClass: 'cms-swiper-pagination-bullet',
                    bulletActiveClass: 'cms-swiper-pagination-bullet-active active',
                },
                mousewheel: {
                    enabled: true,
                    releaseOnEdges: true,
                    //sensitivity: settings.mousewheel_sensitivity
                },
                //https://www.google.com/search?q=swiper+mousewheel+releaseOnEdges+not+work+when+loop+true&sca_esv=1dfb77f5f82eed46&sxsrf=AE3TifPOVdAvFqvUUfvgPxPeH9uFYRuz8Q%3A1755138868384&ei=NEudaICGF5zK1e8P7ZjJkAg&ved=0ahUKEwiA8J_moYmPAxUcZfUHHW1MEoIQ4dUDCBA&uact=5&oq=swiper+mousewheel+releaseOnEdges+not+work+when+loop+true&gs_lp=Egxnd3Mtd2l6LXNlcnAiOHN3aXBlciBtb3VzZXdoZWVsIHJlbGVhc2VPbkVkZ2VzIG5vdCB3b3JrIHdoZW4gbG9vcCB0cnVlMgUQIRigAUiOI1DBBVizH3ABeAGQAQCYAc4BoAGOEqoBBjAuMTQuMbgBA8gBAPgBAZgCEKAC4xLCAgoQABiwAxjWBBhHwgIFEAAY7wXCAgcQIRigARgKwgIEECEYFZgDAIgGAZAGBpIHBjEuMTQuMaAHoUCyBwYwLjE0LjG4B9USwgcHMC43LjguMcgHOQ&sclient=gws-wiz-serp
                /*on: {
                    reachEnd: function(swiper) {
                        // When the end of the original content is reached
                        swiper.mousewheel.releaseOnEdges = true;
                    },
                    reachBeginning: function(swiper) {
                        // When the beginning of the original content is reached
                        swiper.mousewheel.releaseOnEdges = true;
                    },
                    slideChange: function(swiper) {
                        // Reset releaseOnEdges when not at the edges
                        if (!swiper.isBeginning && !swiper.isEnd) {
                            swiper.mousewheel.releaseOnEdges = false;
                        }
                    },
                }*/
            };
        carousel.each(function(index, element) {
            var swiper = new Swiper(element, carousel_settings);
        });
    };
    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_products_category.default', CMSSwiperMouseWheelHandler);
    });
})(jQuery);