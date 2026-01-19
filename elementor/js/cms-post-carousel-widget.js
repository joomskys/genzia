(function ($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSPostCarouselHandler = function ($scope, $) {
        const carouselEls = $scope.find('.cms-carousel'),
              dots_style = carouselEls.data('dots');
        if (carouselEls.length === 0) {
            return;
        }

        const carousel_btn = $scope.find('.cms-carousel-button'),
            carousel_dots = $scope.find('.cms-carousel-dots');
        const cmsSwiper = elementorFrontend.utils.swiper,
            settings = getSettings(),
            slidesToShow = (settings.slides_to_show!='auto') ? +settings.slides_to_show || 3 : 'auto',

            isSingleSlide = 1 === slidesToShow,
            breakpoints = elementorFrontend.config.responsive.activeBreakpoints,
            defaultSlidesToShowMap = {
                mobile: 1,
                tablet: isSingleSlide ? 1 : 2
            },
            defaultSpaceBetween = 40,
            dots_type = (dots_style !=='undefined') ? dots_style : settings.dots_type; 
        //
        const swiperOptions = {
            slideActiveClass: 'swiper-slide-active active',
            slidesPerView: slidesToShow,
            loop: 'yes' === settings.infinite,
            centeredSlides: 'yes' === settings.centeredslide,
            speed: settings.speed,
            handleElementorBreakpoints: true,
            //
            watchSlidesProgress: true,
            watchSlidesVisibility: true,
            slideVisibleClass: 'swiper-slide-visible',
            //
            //grabCursor: true
        };
        swiperOptions.breakpoints = {};

        let lastBreakpointSlidesToShowValue = slidesToShow;
        if ('yes' === settings.autoplay) {
            swiperOptions.autoplay = {
                delay: settings.autoplay_speed,
                disableOnInteraction: 'yes' === settings.pause_on_interaction,
                pauseOnMouseEnter: 'yes' === settings.pause_on_hover,
                reverseDirection: 'true' === settings.slide_direction
            };
        }
        if (isSingleSlide) {
            swiperOptions.effect = settings.effect;
            if ('fade' === settings.effect) {
                swiperOptions.fadeEffect = {
                    crossFade: true
                };
            }
        } else {
            if(settings.slides_to_show == 'auto'){
                swiperOptions.slidesPerGroup = 1;
            } else {
                swiperOptions.slidesPerGroup = +settings.slides_to_scroll || slidesToShow;
            }
        }
        if (settings.space_between) {
            swiperOptions.spaceBetween = elementorFrontend.utils.controls.getResponsiveControlValue(settings, 'space_between', 'size') || defaultSpaceBetween;
        }

        if (settings.dots_type === 'circle' || settings.dots_type === 'number' || settings.dots_type === 'custom' || typeof settings.dots_type === 'undefined') {
            settings.dots_type = 'bullets';
        }
        if (settings.dots_type === 'current-of-total') {
            settings.dots_type = 'custom';
        }

        if ('yes' === settings.dots) {
            let dotsEl = $scope.find('.cms-carousel-dots');
            swiperOptions.pagination = {
                el: dotsEl[0],
                type: settings.dots_type,
                bulletClass: 'cms-swiper-pagination-bullet',
                bulletActiveClass: 'cms-swiper-pagination-bullet-active active',
                clickable: true,
                formatFractionCurrent: function (number) {
                    if (number < 10) number = '0' + number;
                    return number;
                },
                formatFractionTotal: function (number) {
                    if (number < 10) number = '0' + number;
                    return number;
                },
                renderBullet: function (index, className) {
                    var number = (index + 1);
                    if (number < 10) number = '0' + number;
                    return '<span class="' + className + '">' + number + "</span>";
                    //return '<span class="' + className + '"></span>';
                },
                renderFraction: function (currentClass, totalClass) {
                    return '<span class="' + currentClass + '"></span> / ' + '<span class="' + totalClass + '"></span>';
                },
                renderCustom: function (swiper, current, total) {
                    if (dots_type === 'current-of-total') {
                        return current + ' of ' + total;
                    } else if (dots_type === 'custom') {
                        return;
                    }
                }
            };

            let dotsChildren = dotsEl.children();
            if (dotsChildren.length > 0) {
                swiperOptions.pagination.renderBullet = function (index, className) {
                    let dotsChild = dotsChildren.eq(index)
                    dotsChild.addClass(className);
                    return dotsChild.prop('outerHTML');
                };
            }

            let numberOfDots = getSettings('number_of_dots');
            if (typeof numberOfDots != 'undefined') {
                swiperOptions.pagination.dynamicBullets = true;
                swiperOptions.pagination.dynamicMainBullets = numberOfDots;
                swiperOptions.pagination.bulletClass = 'cms-swiper-pagination-bullet-custom';
                swiperOptions.pagination.bulletActiveClass = 'active';
                swiperOptions.initialSlide = numberOfDots + 1;
            }
        }
        if ('yes' === settings.lazyload) {
            swiperOptions.lazy = {
                loadPrevNext: true,
                loadPrevNextAmount: 1
            };
        }

        if ('yes' === settings.mousewheel) {
            swiperOptions.mousewheel = {
                enabled: true,
                releaseOnEdges: 'yes' === settings.mousewheel_releaseOnEdges,
                sensitivity: settings.mousewheel_sensitivity
            };
            swiperOptions.loop = false;
        }

        swiperOptions.on = {
            beforeInit: function (swiper) {
                // hide all elements will run animation on all slides
                swiper.slides.find('[data-cms-animation]').each(function () {
                    $(this).addClass('elementor-invisible');
                });
                // add image lazy loaded
                swiper.slides.find('.cms-lazy').each(function () {
                    $(this).addClass('cms-lazy-loaded');
                });
                // remove image effect
                swiper.slides.find('.cms-slider-img').each(function () {
                    $(this).removeClass('cms-slider-img-effect');
                });
            },
            init: function (swiper) {
                // calculate nav vertical position
                var activeIndex = this.activeIndex,
                    current = this.slides.eq(activeIndex),
                    // top
                    based = current.find('.swiper-nav-vert'),
                    offset_top = based.prev(),
                    // bottom
                    based_bottom = current.find('.swiper-nav-vert-bottom'),
                    offset_bottom = based_bottom.prev();
                if (based != 'undefined') {
                    var based_h = (offset_top.outerHeight(true) + based.outerHeight() / 2) - carousel_btn.outerHeight();
                    if (based.parents('.cms-carousel')) {
                        if (based_h) {
                            based.parents('.elementor-widget-container').find('.cms-carousel-button').css('top', based_h + 'px');
                        }
                    }
                };
                if (based_bottom != 'undefined') {
                    var based_bottom_h = (offset_bottom.outerHeight(true) + based_bottom.outerHeight() / 2) - carousel_btn.outerHeight(true) + carousel_dots.outerHeight(true);
                    if (based_bottom.parents('.cms-carousel')) {
                        if (based_bottom_h) {
                            based_bottom.parents('.elementor-widget-container').find('.cms-carousel-button').css({
                                'bottom': based_bottom_h + 'px',
                                'top': 'auto'
                            });
                        }
                    }
                };
                // Add min height for Excerpt
                $('.cms-mb').each(function () {
                    var $min_h = ($(this).outerHeight() + 8) * -1;
                    $(this).css('--mb', $min_h + 'px');
                });
            },
            resize: function (swiper) {
                // calculate nav vertical position
                var activeIndex = this.activeIndex,
                    current = this.slides.eq(activeIndex),
                    // top
                    based = current.find('.swiper-nav-vert'),
                    offset_top = based.prev(),
                    // bottom
                    based_bottom = current.find('.swiper-nav-vert-bottom'),
                    offset_bottom = based_bottom.prev();
                if (based != 'undefined') {
                    var based_h = offset_top.outerHeight(true) + based.outerHeight() / 2;
                    if (based.parents('.cms-carousel')) {
                        if (based_h) {
                            based.parents('.elementor-widget-container').find('.cms-carousel-button').css('top', based_h + 'px');
                        }
                    }
                }
                if (based_bottom != 'undefined') {
                    var based_bottom_h = (offset_bottom.outerHeight(true) + based_bottom.outerHeight() / 2) - carousel_btn.outerHeight(true) + carousel_dots.outerHeight(true);
                    if (based_bottom.parents('.cms-carousel')) {
                        if (based_bottom_h) {
                            based_bottom.parents('.elementor-widget-container').find('.cms-carousel-button').css({
                                'bottom': based_bottom_h + 'px',
                                'top': 'auto'
                            });
                        }
                    }
                };
                // Add min height for Excerpt
                $('.cms-mb').each(function () {
                    var $min_h = ($(this).outerHeight() + 8) * -1;
                    $(this).css('--mb', $min_h + 'px');
                });
            },
            afterInit: function (swiper) {
                let thumbsSliderEls = $scope.find('.thumbs-slider');
                if (thumbsSliderEls.length > 0) {
                    new cmsSwiper(thumbsSliderEls, {
                        loop: false,
                        slidesPerView: 1,
                        effect: 'fade',
                        on: {
                            afterInit: function (thumbsSwiper) {
                                swiper.controller.control = thumbsSwiper;
                                thumbsSwiper.controller.control = swiper;
                            },
                        },
                    });
                }
            },
            slideChange: function (swiper) {
                let loopedSlides = swiper.loopedSlides;
                if (loopedSlides !== null) {
                    let activeIndex = swiper.activeIndex;
                    let current = swiper.slides.eq(activeIndex);
                    // lazy load image
                    current.find('.cms-lazy').each(function () {
                        // remove css class/style
                        let item = $(this);
                        item.removeClass('lazy-loading').addClass('cms-lazy-loaded');
                    });
                    // animation
                    current.find('[data-cms-animation]').each(function () {
                        let item = $(this);
                        let animation_key = item.data('cms-animation');
                        let animation_delay_key = item.data('cms-animation-delay');
                        item.addClass('elementor-invisible').removeClass('animated ' + getSettings(animation_key));
                        setTimeout(function () {
                            item.removeClass('elementor-invisible').addClass('animated ' + getSettings(animation_key));
                        }, getSettings(animation_delay_key));
                    });
                    //
                    current.find('[data-settings]').each(function () {
                        let item = $(this);
                        let animation_settings = item.data('settings');
                        let e_animation_key = animation_settings.animation;
                        let e_animation_delay_key = animation_settings.animation_delay;
                        item.addClass('elementor-invisible').removeClass('animated ' + e_animation_key);
                        setTimeout(function () {
                            item.removeClass('elementor-invisible').addClass('animated ' + e_animation_key);
                        }, e_animation_delay_key);
                    });
                    // image effect
                    current.find('.cms-slider-img').each(function () {
                        let item = $(this);
                        item.removeClass('cms-slider-img-effect');
                        setTimeout(function () {
                            item.addClass('cms-slider-img-effect');
                        }, 50);
                    });
                    // re-play counter
                    current.find('.cms-counter-number').each(function () {
                        var $number = $(this),
                            data = $number.data();

                        $number.text(data.fromValue);

                        var decimalDigits = data.toValue.toString().match(/\.(.*)/);

                        if (decimalDigits) {
                            data.rounding = decimalDigits[1].length;
                        }

                        $number.numerator(data);
                    });

                    for (let i = loopedSlides - 1; i >= 0; i--) {
                        nextSlideIndex = ++activeIndex;
                        nextSlide = swiper.slides.eq(nextSlideIndex);
                        // animation
                        nextSlide.find('[data-cms-animation]').each(function () {
                            let item = $(this);
                            let animation_key = item.data('cms-animation');
                            let animation_delay_key = item.data('cms-animation-delay');
                            item.addClass('elementor-invisible').removeClass('animated ' + getSettings(animation_key));
                            setTimeout(function () {
                                item.removeClass('elementor-invisible').addClass('animated ' + getSettings(animation_key));
                            }, getSettings(animation_delay_key));
                        });
                        //
                        nextSlide.find('[data-settings]').each(function () {
                            let item = $(this);
                            let animation_settings = item.data('settings');
                            let e_animation_key = animation_settings.animation;
                            let e_animation_delay_key = animation_settings.animation_delay;
                            item.addClass('elementor-invisible').removeClass('animated ' + e_animation_key);
                            setTimeout(function () {
                                item.removeClass('elementor-invisible').addClass('animated ' + e_animation_key);
                            }, e_animation_delay_key);
                        });
                        // image effect
                        nextSlide.find('.cms-slider-img').each(function () {
                            let item = $(this);
                            item.removeClass('cms-slider-img-effect');
                            setTimeout(function () {
                                item.addClass('cms-slider-img-effect');
                            }, 50);
                        });
                        // Counter
                        nextSlide.find('.cms-counter-number').each(function () {
                            var $number = $(this),
                                data = $number.data();

                            $number.text(data.fromValue);

                            var decimalDigits = data.toValue.toString().match(/\.(.*)/);

                            if (decimalDigits) {
                                data.rounding = decimalDigits[1].length;
                            }

                            $number.numerator(data);
                        });
                    }
                }
            }
        };

        $.each(carouselEls, function (i, carouselEl) {
            carouselEl = $(carouselEl);
            // responsive
            $.each(Object.keys(breakpoints).reverse(), function (i, breakpointName) {
                // Tablet has a specific default `slides_to_show`.
                const defaultSlidesToShow = defaultSlidesToShowMap[breakpointName] ? defaultSlidesToShowMap[breakpointName] : lastBreakpointSlidesToShowValue;
                const defaultSlidesPerGroup = defaultSlidesToShowMap[breakpointName] ? defaultSlidesToShowMap[breakpointName] : lastBreakpointSlidesToShowValue;
                swiperOptions.breakpoints[breakpoints[breakpointName].value] = {
                    slidesPerView: +settings['slides_to_show_' + breakpointName] || defaultSlidesToShow,
                    slidesPerGroup: +settings['slides_to_scroll_' + breakpointName] || defaultSlidesPerGroup
                };
                if (settings.space_between) {
                    swiperOptions.breakpoints[breakpoints[breakpointName].value].spaceBetween = elementorFrontend.utils.controls.getResponsiveControlValue(settings, 'space_between', 'size', breakpointName) || defaultSpaceBetween;
                }
                lastBreakpointSlidesToShowValue = +settings['slides_to_show_' + breakpointName] || defaultSlidesToShow;

            });
            // arrows
            if ('yes' === settings.arrows) {
                swiperOptions.navigation = {
                    prevEl: '.cms-carousel-button-prev',
                    nextEl: '.cms-carousel-button-next'
                };
            }
            new cmsSwiper(carouselEl, {
                ...swiperOptions
            });

            // if (settings['autoplay'] === 'yes' && settings['pause_on_hover'] === 'yes') {
            //     $(this).on({
            //         mouseenter: function mouseenter() {
            //             this.swiper.autoplay.stop();
            //         },
            //         mouseleave: function mouseleave() {
            //             this.swiper.autoplay.start();
            //         }
            //     });
            // }
            carouselEl.on('load', function (e, res) {
                if (res.status == true) {
                    this.swiper.destroy();
                    carouselEl.find('.swiper-wrapper').html(res.data.html);
                    new cmsSwiper(carouselEl, {
                        ...swiperOptions
                    });
                }
            });
        });

        function getSettings(setting) {
            let settings = {};
            const modelCID = $scope.data('model-cid') || '',
                isEdit = $scope.hasClass('elementor-element-edit-mode');
            if (isEdit && modelCID) {
                const data = elementorFrontend.config.elements.data[modelCID],
                    attributes = data.attributes;
                let type = attributes.widgetType || attributes.elType;
                if (attributes.isInner) {
                    type = 'inner-' + type;
                }
                let dataKeys = elementorFrontend.config.elements.keys[type];
                if (!dataKeys) {
                    dataKeys = elementorFrontend.config.elements.keys[type] = [];
                    $.each(data.controls, (name, control) => {
                        if (control.frontend_available) {
                            dataKeys.push(name);
                        }
                    });
                }
                $.each(data.getActiveControls(), function (controlKey) {
                    if (-1 !== dataKeys.indexOf(controlKey)) {
                        let value = attributes[controlKey];
                        if (value.toJSON) {
                            value = value.toJSON();
                        }
                        settings[controlKey] = value;
                    }
                });
            } else {
                settings = $scope.data('settings') || {};
            }
            return getItems(settings, setting);
        }

        function getItems(items, itemKey) {
            if (itemKey) {
                const keyStack = itemKey.split('.'),
                    currentKey = keyStack.splice(0, 1);
                if (!keyStack.length) {
                    return items[currentKey];
                }
                if (!items[currentKey]) {
                    return;
                }
                return this.getItems(items[currentKey], keyStack.join('.'));
            }
            return items;
        }

        $scope.on('click', '.grid-filter-wrap .filter-item', function () {
            let _this = $(this);
            if (_this.hasClass('active') || _this.hasClass('activated') || $scope.hasClass('filtering')) {
                return false;
            }

            let settings = $scope.find('.cms-post-carousel').data('settings') || {};
            let filter = _this.data('filter');
            if (typeof filter == 'undefined' || filter == "*" || filter == '') {
                filter = '';
            }
            settings.source = [filter];

            $.ajax({
                url: main_data.ajax_url,
                type: 'POST',
                beforeSend: function () {
                    $scope.addClass('filtering');
                    _this.addClass('activating');
                },
                data: {
                    action: 'genzia_load_more_post_grid',
                    settings: settings
                }
            }).done(function (res) {
                if (res.status == true) {
                    $scope.find('.cms-carousel').trigger('load', res);
                    $scope.find('.grid-filter-wrap .filter-item').removeClass('active');
                    $scope.find('.grid-filter-wrap .filter-item').removeClass('activated');
                    _this.addClass('active');
                    _this.addClass('activated');
                } else if (res.status == false) {

                }
            }).fail(function (res) {

            }).always(function () {
                $scope.removeClass('filtering');
                _this.removeClass('activating');
            });

            return false;
        });
    };

    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_fancy_box.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_posts_carousel.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_counter.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_slider.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_clients.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_tabs.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_teams.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_testimonials.default', WidgetCMSPostCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_pricing.default', WidgetCMSPostCarouselHandler);
        //theme
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_headline.default', WidgetCMSPostCarouselHandler);
    });
})(jQuery);