(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', function ($scope, settings) {

        // lazy load image
        var GlobalLazyLoad = function ($scope, $) {
            $.each($scope.find('.cms-lazy'), function (index, item) {
                const observer = elementorModules.utils.Scroll.scrollObserver({
                    callback: event => {
                        if (event.isInViewport) {
                            // remove css class
                            $(this).removeClass('lazy-loading').addClass('cms-lazy-loaded');
                            // add style
                            var duration = $(this).data('duration');
                            if (typeof duration != 'undefined') {
                                $(this).css({
                                    'animation-duration': duration + 'ms'
                                });
                            }
                        }
                    }
                });
                observer.observe(item);
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/global', GlobalLazyLoad);
        /**
         * Animate
         * Make animate re-play
         * 
         * */
        var GlobalWidgetAnimateHandler = function ($scope, $) {
            $.each($scope.find('.elementor-invisible'), function (index, item) {
                const observer = elementorModules.utils.Scroll.scrollObserver({
                    callback: event => {
                        var animate = $(this),
                            data = animate.data('settings');
                        if (typeof data != 'undefined' && typeof data['animation'] != 'undefined') {
                            if (event.isInViewport) {
                                animate.addClass('cms-inview');
                                //
                                setTimeout(function () {
                                    animate.removeClass('elementor-invisible').addClass('animated ' + data['animation']);
                                }, data['animation_delay']);
                            } else {
                                // Revert
                                animate.removeClass('cms-inview');
                                /*setTimeout(function() {
                                    animate.addClass('elementor-invisible').removeClass('animated ' + data['animation']);
                                }, data['animation_delay']);*/
                            }
                        }
                    }
                });
                observer.observe(item);
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/global', GlobalWidgetAnimateHandler);
        // Equal Height
        var CMSEqualHeight = function ($scope, $) {
            $.each($scope.find('.cms-equal-item'), function (index, item) {
                var self = $(this),
                    target = '#' + self.data('equal'),
                    equal_item = self.parents('.cms-equal').find(target),
                    self_h = self.innerHeight();
                equal_item.css({
                    'min-height': self_h
                });
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/global', CMSEqualHeight);
        // Accordion
        var WidgetCMSAccordionHandler = function ($scope, $) {
            $scope.find('.cms-accordion-title').on('click', function (e) {
                e.preventDefault();
                var self = $(this);
                if (self.hasClass('animating')) {
                    return false;
                }
                self.addClass('animating');
                var target = self.data('target');
                var target2 = self.data('target2');
                var parent = self.parents('.cms-accordion-wrap');
                var active_items = parent.find('.cms-accordion-title.active');
                $.each(active_items, function (index, item) {
                    var item_target = $(item).data('target');
                    var item_target2 = $(item).data('target2');
                    if (item_target != target) {
                        $(item).removeClass('active');
                        self.parent().removeClass('active');
                        $(item_target).slideUp(400);
                    }
                    if (item_target2 != target2) {
                        $(item).removeClass('active');
                        self.parent().removeClass('active');
                        $(item_target2).slideDown(400);
                    }
                });

                if (self.hasClass('active')) {
                    self.parent().removeClass('active');
                    self.removeClass('active');
                    $(target).slideUp(400);
                } else {
                    self.parents('.cms-accordion').find('.cms-accordion-item').removeClass('active');
                    self.parents('.cms-accordion').find('.cms-accordion-title').removeClass('active');
                    self.parents('.cms-accordion').find('.cms-accordion-content').slideUp(400);
                    self.parents('.cms-accordion').find('.cms-accordion-content2').slideUp(400);
                    self.parent().addClass('active');
                    self.addClass('active');
                    $(target).slideDown(400);
                    $(target2).slideDown(400);
                }
                setTimeout(function () {
                    self.removeClass('animating');
                }, 400);
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/global', WidgetCMSAccordionHandler);

        // Counter
        var WidgetCMSCounterHandler = function ($scope, $) {
            elementorFrontend.waypoint($scope.find('.cms-counter-number'), function () {
                var $number = $(this),
                    data = $number.data();

                var decimalDigits = data.toValue.toString().match(/\.(.*)/);

                if (decimalDigits) {
                    data.rounding = decimalDigits[1].length;
                }

                $number.numerator(data);

            }, {
                offset: 0,
                triggerOnce: true
            });

            // add class active to counter chart bar
            elementorFrontend.waypoint($scope.find('.cms-counter-chart-bar'), function () {
                $(this).addClass('active');
            });
            //
            $scope.find('.counter-item').on('click', function (e) {
                e.preventDefault();
                var self = $(this);
                if (self.hasClass('animating')) {
                    return false;
                }
                self.addClass('animating');
                var target = self.data('target');
                var parent = self.parents('.cms-counter-sticky');
                var active_items = parent.find('.counter-item.active');
                $.each(active_items, function (index, item) {
                    var item_target = $(item).data('target');
                    if (item_target != target) {
                        //$(item).removeClass('active');
                        //self.parent().removeClass('active');
                        //$(item_target).slideUp(400);
                        //$(item_target).removeClass('active');
                    }
                });

                if (self.hasClass('active')) {
                    //self.parent().removeClass('active');
                    //self.removeClass('active');
                    //$(target).slideUp(400);
                    //$(target).removeClass('active');
                } else {
                    self.parent().addClass('active');
                    self.addClass('active');
                    //$(target).slideDown(400);
                    $(target).addClass('active');
                }
                setTimeout(function () {
                    self.removeClass('animating');
                }, 400);
            });
            $scope.find('.counter-item').on('hover', function (e) {
                e.preventDefault();
                var self = $(this);
                if (self.hasClass('animating')) {
                    return false;
                }
                self.addClass('animating');
                var target = self.data('target');
                var parent = self.parents('.cms-counter-sticky');
                var active_items = parent.find('.counter-item.active');
                $.each(active_items, function (index, item) {
                    var item_target = $(item).data('target');
                    if (item_target != target) {
                        $(item).removeClass('active');
                        self.parent().removeClass('active');
                        //$(item_target).slideUp(400);
                        $(item_target).removeClass('active');
                    }
                });

                if (self.hasClass('active')) {
                    //self.parent().removeClass('active');
                    //self.removeClass('active');
                    //$(target).slideUp(400);
                    //$(target).removeClass('active');
                } else {
                    //$(target).slideDown(400);
                    self.parent().addClass('active');
                    self.addClass('active');
                    $(target).addClass('active');
                }
                setTimeout(function () {
                    self.removeClass('animating');
                }, 400);
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/global', WidgetCMSCounterHandler);
        // Tabs
        var WidgetCMSTabsHandler = function ($scope, $) {
            $scope.find(".cms-tab-title").on("click mouseenter touch", function (e) {
                e.preventDefault();
                var target = $(this).data("target");
                var target_dots = $(this).data("target-dots");
                var target_pointer = $(this).data("target-pointer");
                var parent = $(this).parents(".cms-tabs");
                // hide all
                parent.find(".cms-tabs-content").hide().removeClass('active');
                parent.find(".cms-tab-title").removeClass('active');
                // Show current
                $(this).addClass("active");
                parent.find(target).show().addClass('active');
                parent.find(target_dots).addClass('active');
                parent.find(target_pointer).addClass('active');
                // Get Current
                var current = $(this).data('current');
                parent.find('.current-count').addClass('active').html(current);
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/global', WidgetCMSTabsHandler);

        // CountDown
        var WidgetCMSCountDownHandler = function ($scope, $) {
            var countdown = $scope.find(".cms-countdown");
            countdown.each(function () {
                var _this = $(this);
                var count_down = $(this).find('> div').data("count-down");
                setInterval(function () {
                    var startDateTime = new Date().getTime();
                    var endDateTime = new Date(count_down).getTime();
                    var distance = endDateTime - startDateTime;
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    var text_day = days !== 1 ? _this.attr('data-days') : _this.attr('data-day');
                    var text_hour = hours !== 1 ? _this.attr('data-hours') : _this.attr('data-hour');
                    var text_minu = minutes !== 1 ? _this.attr('data-minutes') : _this.attr('data-minute');
                    var text_second = seconds !== 1 ? _this.attr('data-seconds') : _this.attr('data-second');
                    days = days < 10 ? '0' + days : days;
                    hours = hours < 10 ? '0' + hours : hours;
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    seconds = seconds < 10 ? '0' + seconds : seconds;

                    _this.html('' +
                        '<div class="countdown-item"><div class="countdown-item-inner"><div class="countdown-amount">' + days + '</div><div class="countdown-period">' + text_day + '</div></div></div>' +
                        '<div class="countdown-item"><div class="countdown-item-inner"><div class="countdown-amount">' + hours + '</div><div class="countdown-period">' + text_hour + '</div></div></div>' +
                        '<div class="countdown-item"><div class="countdown-item-inner"><div class="countdown-amount">' + minutes + '</div><div class="countdown-period">' + text_minu + '</div></div></div>' +
                        '<div class="countdown-item"><div class="countdown-item-inner"><div class="countdown-amount">' + seconds + '</div><div class="countdown-period">' + text_second + '</div></div></div>'
                    );
                }, 100);
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/global', WidgetCMSCountDownHandler);
        // CMS Text Scroll with Swiper
        var CMSTextScrollHandler = function ($scope, $) {
            const carousel = $scope.find(".cms-text-scroll");
            if (carousel.length === 0) {
                return;
            }
            // Swiper Text Scroll
            const cmsSwiper = typeof Swiper !== 'undefined' ? Swiper : elementorFrontend.utils.swiper,
                direction = carousel.data('direction'),
                spaceBetween = carousel.data('spacebetween'),
                speed = carousel.data('speed'),
                hoverPause = carousel.data('hoverpause'),
                disableOnInteraction = carousel.data('disableoninteraction'),
                loop = carousel.data('loop'),
                carousel_settings = {
                    wrapperClass: 'cms-swiper-wrapper',
                    slideClass: 'cms-swiper-slide',
                    slidesPerView: 'auto',
                    centeredSlides: true,
                    spaceBetween: spaceBetween,
                    speed: speed,
                    watchSlidesProgress: true,
                    watchSlidesVisibility: true,
                    autoplay: {
                        delay: 0.001,
                        disableOnInteraction: 'yes' === disableOnInteraction ? true : false,
                        pauseOnMouseEnter: 'yes' === hoverPause ? true : false,
                        //pauseOnMouseEnter: false,
                        reverseDirection: direction
                    },
                    loop: 'yes' === loop ? true : false,
                    navigation: false,
                    pagination: false
                };
            carousel.each(function (index, element) {
                new cmsSwiper(element, carousel_settings);
            });
        };
        // Make sure you run this code under Elementor.
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_text_scroll.default', CMSTextScrollHandler);
        //elementorFrontend.hooks.addAction('frontend/element_ready/cms_gallery.default', CMSTextScrollHandler);
        //elementorFrontend.hooks.addAction('frontend/element_ready/cms_countdown.default', CMSTextScrollHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_video_player.default', CMSTextScrollHandler);

        // CMS Progress Bar
        var WidgetCMSProgressBarHandler = function ($scope, $) {
            elementorFrontend.waypoint($scope.find('.cms-progress-bar-wrap'), function () {
                var $progressbar_w = $(this).find('.cms-progress-bar-w'),
                    $progressbar_h = $(this).find('.cms-progress-bar-h');
                $progressbar_w.css('width', $progressbar_w.data('width') + '%');
                $progressbar_h.css('height', $progressbar_h.data('height') + '%');

                var $number = $(this).find('.cms-progress-bar-number'),
                    data = $number.data(),
                    decimalDigits = data.toValue.toString().match(/\.(.*)/);
                if (decimalDigits) {
                    data.rounding = decimalDigits[1].length;
                }
                $number.numerator(data);
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/global', WidgetCMSProgressBarHandler);
        // CMS Image Cursor
        var WidgetCMSPointerImageCursor = function ($scope, $) {
            var $links = $scope.find('.cms-img-cursor'),
                x = 0,
                y = 0,
                currentXCPosition = 0,
                currentYCPosition = 0;

            if ($links.length) {
                $links.on(
                    'mouseenter',
                    function () {
                        $links.removeClass('cms--active');
                        $(this).addClass('cms--active');
                    }
                ).on(
                    'mousemove',
                    function (event) {
                        var $thisLink = $(this),
                            $followInfoHolder = $thisLink.find('.cms-cursor-pointer'),
                            $followImage = $followInfoHolder.find('.cms-cursor--pointer'),
                            $followImageItem = $followImage.find('img'),
                            followImageWidth = $followImageItem.width(),
                            followImagesCount = parseInt($followImage.data('images-count'), 10),
                            followImagesSrc = $followImage.data('images'),
                            $followTitle = $followInfoHolder.find('.cms-cursor--title'),
                            itemWidth = $thisLink.outerWidth(),
                            itemHeight = $thisLink.outerHeight(),
                            itemOffsetTop = $thisLink.offset().top - $(window).scrollTop(),
                            itemOffsetLeft = $thisLink.offset().left;
                        x = (event.clientX - itemOffsetLeft) >> 0;
                        y = (event.clientY - itemOffsetTop) >> 0;

                        if (x > itemWidth) {
                            currentXCPosition = itemWidth;
                        } else if (x < 0) {
                            currentXCPosition = 0;
                        } else {
                            currentXCPosition = x;
                        }

                        if (y > itemHeight) {
                            currentYCPosition = itemHeight;
                        } else if (y < 0) {
                            currentYCPosition = 0;
                        } else {
                            currentYCPosition = y;
                        }

                        if (followImagesCount > 1) {
                            var imagesUrl = followImagesSrc.split('|'),
                                itemPartSize = itemWidth / followImagesCount;

                            $followImageItem.removeAttr('srcset');

                            if (currentXCPosition < itemPartSize) {
                                $followImageItem.attr('src', imagesUrl[0]);
                            }

                            // -2 is constant - to remove first and last item from the loop
                            for (var index = 1; index <= (followImagesCount - 2); index++) {
                                if (currentXCPosition >= itemPartSize * index && currentXCPosition < itemPartSize * (index + 1)) {
                                    $followImageItem.attr('src', imagesUrl[index]);
                                }
                            }

                            if (currentXCPosition >= itemWidth - itemPartSize) {
                                $followImageItem.attr('src', imagesUrl[followImagesCount - 1]);
                            }
                        }

                        $followImage.css({
                            'top': itemHeight / 2,
                        });
                        $followTitle.css({
                            'transform': 'translateY(' + -(parseInt(itemHeight, 10) / 2 + currentYCPosition) + 'px)',
                            'left': -(currentXCPosition - followImageWidth / 2),
                        });
                        $followInfoHolder.css({
                            'top': currentYCPosition,
                            'left': currentXCPosition
                        });
                    }
                ).on(
                    'mouseleave',
                    function () {
                        $links.removeClass('cms--active');
                    }
                );
            }
        }
        elementorFrontend.hooks.addAction('frontend/element_ready/global', WidgetCMSPointerImageCursor);
        // Parallax
        var CMSParallax = function ($scope, $) {
            var $items = $scope.find('.cms-parallax'),
                parallaxInstances = $('[data-parallax]');
            if (parallaxInstances.length && typeof ParallaxScroll === 'object') {
                ParallaxScroll.init(); //initialization removed from plugin js file to have it run only on non-touch devices
            }
        }
        elementorFrontend.hooks.addAction('frontend/element_ready/global', CMSParallax);
        /**
         * Draw svg
         * @param $scope The Widget wrapper element as a jQuery element
         * @param $ The jQuery alias
         */
        var WidgetCMSDrawSVGHandler = function ($scope, $) {
            $('.cms-drawsvg').each(function () {
                var svg = $(this).find('svg'),
                    path = svg.find('path'),
                    totalDistance = svg[0].clientHeight - window.innerHeight,
                    pathLength = path[0].getTotalLength();
                //
                $(window).on('scroll', function () {
                    var distance = window.scrollY,
                        percentage = distance / totalDistance,
                        strokedashoffset = pathLength * (1 - percentage);

                    path.css({
                        'stroke-dasharray': pathLength,
                        'stroke-dashoffset': strokedashoffset
                    });
                });
            });
        };
        var WidgetCMSDrawSVGHandler_Waypoint = function ($scope, $) {
            $.each($scope.find('.cms-drawsvg'), function (index, item) {
                var svg = $(this).find('svg'),
                    path = svg.find('path'),
                    totalDistance = svg[0].clientHeight - window.innerHeight,
                    pathLength = path[0].getTotalLength();
                //
                const observer = elementorModules.utils.Scroll.scrollObserver({
                    callback: event => {
                        if (event.isInViewport) {
                            var distance = window.scrollY,
                                percentage = distance / totalDistance,
                                strokedashoffset = pathLength * (1 - percentage);
                            path.css({
                                'stroke-dasharray': pathLength,
                                'stroke-dashoffset': strokedashoffset
                            });
                        }
                    }
                });
                observer.observe(item);
            });
        };
        // Make sure you run this code under Elementor.
        elementorFrontend.hooks.addAction('frontend/element_ready/global', WidgetCMSDrawSVGHandler);
    });
}(jQuery));