/**
 * Theme JS
 * 
 * */
(function ($) {
    "use strict";

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.waypoint = elementorFrontend.waypoint || function (el, callback, args) {
            args = args || {};
            el = $(el);
            $.each(el, function (index, item) {
                const obj = $.extend({
                    callback: event => {
                        if (event.isInViewport) {
                            callback.apply(this, args);
                        }
                    }
                }, args);
                const observer = elementorModules.utils.Scroll.scrollObserver(obj);
                observer.observe(item);
            });
        };
    });

    // load more
    $(document).on('click', '.cms-load-more', function () {
        var gridEl = $(this).parents('.cms-grid');
        var loadmore = $(this).data('loadmore') || gridEl.data('loadmore');
        var layout_type = gridEl.data('layout');
        var loading_text = $(this).data('loading-text');
        var no_text = $(this).data('no-text');

        loadmore.maxPages = parseInt(gridEl.data('max-pages'));
        loadmore.paged = parseInt(gridEl.data('start-page')) + 1;

        gridEl.find('.cms-grid-overlay').addClass('loader');
        $(this).addClass('loading');
        $(this).find('.cms-btn-icon').addClass('loading');
        $(this).find('.cms-btn-text').text(loading_text);
        $.ajax({
            url: main_data.ajax_url,
            type: 'POST',
            beforeSend: function () {

            },
            data: {
                action: main_data.get_posts_action,
                settings: loadmore
            }
        }).done(function (res) {
            if (res.status == true) {
                let gridContent = gridEl.find('.cms-grid-content');
                if (gridContent.length == 0) {
                    gridContent = gridEl.find('.cms-grid-inner');
                }
                gridContent.append(res.data.html);
                gridEl.data('start-page', res.data.paged);
                gridEl.find('.cms-grid-overlay').removeClass('loader');
                gridEl.find('.cms-load-more').removeClass('loading');
                gridEl.find('.cms-btn-icon').removeClass('loading');
                gridEl.find('.cms-btn-text').text('Load More');
                if (res.data.paged == loadmore.maxPages) {
                    gridEl.find('.cms-load-more').addClass('no-more');
                    gridEl.find('.cms-btn-text').text(no_text);
                }
                if (layout_type == 'masonry') {
                    // $.sep_grid_refresh();
                    gridEl.find('.cms-grid-masonry').imagesLoaded(function () {
                        $.sep_grid_refresh();
                    });
                }
                $.each(gridEl.find('.elementor-invisible'), function (index, item) {
                    var animate = $(this),
                        data = animate.data('settings');
                    if (typeof data['animation'] != 'undefined' || typeof data['_animation'] != 'undefined') {
                        $(this).addClass('cms-inview');

                        setTimeout(function () {
                            animate.removeClass('elementor-invisible').addClass('animated ' + data['animation']);
                        }, data['animation_delay']);

                        if (typeof data['_animation'] != 'undefined') {
                            setTimeout(function () {
                                animate.addClass(data['_animation']);
                            }, data['_animation_delay']);
                        }
                    }
                });
            } else if (res.status == false) {
                gridEl.find('.cms-load-more').addClass('no-more');
            }
            $(document).trigger('load_more_done', gridEl, res);
        }).fail(function (res) {
            gridEl.find('.cms-load-more').addClass('no-more');
            $(document).trigger('load_more_fail', gridEl, res);
            return false;
        }).always(function () {
            $(document).trigger('load_more_always', gridEl);
            return false;
        });
    });

    // pagination
    $(document).on('click', '.cms-grid-pagination .ajax a.page-numbers', function () {
        var gridEl = $(this).parents('.cms-grid');
        var loadmore = gridEl.find('.cms-grid-pagination').data('loadmore') || gridEl.data('loadmore');
        var query_vars = gridEl.find('.cms-grid-pagination').data('query') || gridEl.data('query');
        var layout_type = gridEl.data('layout');
        var paged = $(this).attr('href');
        paged = paged.replace('#', '');
        loadmore.paged = parseInt(paged);
        query_vars.paged = parseInt(paged);
        gridEl.find('.cms-grid-overlay').addClass('loader');
        $('html,body').animate({
            scrollTop: gridEl.offset().top - 100
        }, 750);
        // reload pagination
        $.ajax({
            url: main_data.ajax_url,
            type: 'POST',
            beforeSend: function () {

            },
            data: {
                action: main_data.get_pagination_action,
                query_vars: query_vars
            }
        }).done(function (res) {
            if (res.status == true) {
                gridEl.find('.cms-grid-pagination').html(res.data.html);
                gridEl.find('.cms-grid-overlay').removeClass('loader');
            } else if (res.status == false) {}
        }).fail(function (res) {
            return false;
        }).always(function () {
            return false;
        });
        // load post
        $.ajax({
            url: main_data.ajax_url,
            type: 'POST',
            beforeSend: function () {

            },
            data: {
                action: main_data.get_posts_action,
                settings: loadmore
            }
        }).done(function (res) {
            if (res.status == true) {
                let gridContent = gridEl.find('.cms-grid-content');
                if (gridContent.length == 0) {
                    gridContent = gridEl.find('.cms-grid-inner');
                }
                gridContent.find('.cms-item').remove();
                gridContent.find('.cms-grid-item').remove();
                gridContent.find('.grid-item').remove();
                gridContent.append(res.data.html);
                gridEl.data('start-page', res.data.paged);
                if (layout_type == 'masonry') {
                    // $.sep_grid_refresh();
                    gridEl.find('.cms-grid-masonry').imagesLoaded(function () {
                        $.sep_grid_refresh();
                    });
                }
                $.each(gridEl.find('.elementor-invisible'), function (index, item) {
                    var animate = $(this),
                        data = animate.data('settings');
                    if (typeof data['animation'] != 'undefined' || typeof data['_animation'] != 'undefined') {
                        $(this).addClass('cms-inview');

                        setTimeout(function () {
                            animate.removeClass('elementor-invisible').addClass('animated ' + data['animation']);
                        }, data['animation_delay']);

                        if (typeof data['_animation'] != 'undefined') {
                            setTimeout(function () {
                                animate.addClass(data['_animation']);
                            }, data['_animation_delay']);
                        }
                    }
                });
            } else if (res.status == false) {}
        }).fail(function (res) {
            return false;
        }).always(function () {
            return false;
        });
        return false;
    });

    // post filter
    $(document).on('click', '.cms-grid .grid-filter-wrap .filter-item', function () {
        if ($(this).hasClass('active')) {
            return false;
        }
        let gridEl = $(this).parents('.cms-grid');
        gridEl.find('.grid-filter-wrap .filter-item').removeClass('active');
        $(this).addClass('active');

        let loadmore = gridEl.find('.cms-grid-pagination').data('loadmore') || gridEl.find('.cms-load-more').data('loadmore') || gridEl.data('loadmore');
        loadmore = $.extend({}, loadmore);
        let query_vars = gridEl.find('.cms-grid-pagination').data('query') || gridEl.find('.cms-load-more').data('query') || gridEl.data('query');
        let layout_type = gridEl.data('layout');
        let filter = $(this).data('filter');
        if (typeof filter == 'undefined' || filter == '*' || filter == '') {
            filter = '';
        } else {
            loadmore.source = [filter];
        }

        loadmore.paged = 1;
        query_vars.paged = 1;
        gridEl.find('.cms-grid-overlay').addClass('loader');

        // reload pagination
        $.ajax({
            url: main_data.ajax_url,
            type: 'POST',
            beforeSend: function () {

            },
            data: {
                action: main_data.get_pagination_action,
                query_vars: query_vars,
                filter: filter,
            }
        }).done(function (res) {
            if (res.status == true) {
                gridEl.find('.cms-grid-pagination').html(res.data.html);
                gridEl.find('.cms-grid-overlay').removeClass('loader');
            } else if (res.status == false) {}
        }).fail(function (res) {
            return false;
        }).always(function () {
            return false;
        });
        // load post
        $.ajax({
            url: main_data.ajax_url,
            type: 'POST',
            beforeSend: function () {

            },
            data: {
                action: main_data.get_posts_action,
                settings: loadmore
            }
        }).done(function (res) {
            if (res.status == true) {
                let gridContent = gridEl.find('.cms-grid-content');
                gridContent.find('.cms-item').remove();
                gridContent.find('.cms-grid-item').remove();
                gridEl.find('.cms-grid-inner .grid-item').remove();
                if (gridContent.length == 0) {
                    gridEl.find('.cms-grid-inner').append(res.data.html);
                } else {
                    gridContent.append(res.data.html);
                }
                gridEl.data('start-page', res.data.paged);
                if (layout_type == 'masonry') {
                    // $.sep_grid_refresh();
                    gridEl.find('.cms-grid-masonry').imagesLoaded(function () {
                        $.sep_grid_refresh();
                    });
                }
                $.each(gridEl.find('.elementor-invisible'), function (index, item) {
                    var animate = $(this),
                        data = animate.data('settings');
                    if (typeof data['animation'] != 'undefined' || typeof data['_animation'] != 'undefined') {
                        $(this).addClass('cms-inview');

                        setTimeout(function () {
                            animate.removeClass('elementor-invisible').addClass('animated ' + data['animation']);
                        }, data['animation_delay']);

                        if (typeof data['_animation'] != 'undefined') {
                            setTimeout(function () {
                                animate.addClass(data['_animation']);
                            }, data['_animation_delay']);
                        }
                    }
                });
            } else if (res.status == false) {}
        }).fail(function (res) {
            return false;
        }).always(function () {
            return false;
        });
        return false;
    });

    /* ===================
     Page reload 
     ===================== */
    var scroll_top;
    var last_scroll_top = 0;
    var $imgLogo = $('#cms-header .site-logo img');
    var srcLogo = $imgLogo.attr('src'),
        srcLogoMobile = $imgLogo.data('mobile'),
        logo_tablet_mobile_size = 1025;
    var dataSticky = $imgLogo.data('sticky'),
        dataStickyMobile = $imgLogo.data('sticky-mobile');
    var dataTransparent = $imgLogo.data('transparent'),
        dataTransparentMobile = $imgLogo.data('transparent-mobile');
    var $header = $('#cms-header'),
        $headerTransparent = $header.hasClass('transparent-on'),
        $headerStickyAlways = $header.hasClass('sticky-always'),
        $headerStickyScrollUp = $header.hasClass('sticky-scrollup'),
        $headerSettings = $header.data('settings'),
        $headerDefaultClass = (typeof $headerSettings != 'undefined' && typeof $headerSettings.default_class != 'undefined') ? $headerSettings.default_class.join(' ') : '',
        // Header Sticky
        $headerStickyClass = (typeof $headerSettings != 'undefined' && typeof $headerSettings.sticky_class != 'undefined') ? $headerSettings.sticky_class.join(' ') : '',
        // Header On Top
        $headerOnTopClass = (typeof $headerSettings != 'undefined' && typeof $headerSettings.ontop_class != 'undefined') ? $headerSettings.ontop_class.join(' ') : '';
    // Header transparent Height
    var $header_transparent_header_top_height = (typeof $('.cms-header-transparent #cms-header-top').outerHeight() !== 'undefined') ? $('.cms-header-transparent #cms-header-top').outerHeight(true) : 0,
        $header_transparent_header_height = (typeof $('.cms-header-transparent #cms-header').outerHeight() !== 'undefined') ? $('.cms-header-transparent #cms-header').outerHeight(true) : 0,
        $header_transparent_height = $header_transparent_header_top_height + $header_transparent_header_height;
    //
    var header_height = $header.outerHeight(),
        header_main_height = $('.cms-header-main').outerHeight();

    //
    $(window).on('load', function () {
        $(".cms-loader").fadeOut("slow");
        //  Min Height
        $('.cms-mb').each(function () {
            var $min_h = ($(this).outerHeight() + 8) * -1;
            $(this).css('--mb', $min_h + 'px');
        });
        //
        $('.cms-hover-next-prev').on('mouseenter', function () {
            $(this).prev().addClass('prev-item').removeClass('active');
            $(this).next().addClass('next-item').removeClass('active');
        });
        $('.cms-hover-next-prev').on('mouseleave', function () {
            $(this).prev().removeClass('prev-item');
            $(this).next().removeClass('next-item');
        });
        // All 
        $('.cms-hover-next-prev-all').on('mouseenter', function () {
            $(this).prevAll().addClass('prev-item').removeClass('active');
            $(this).nextAll().addClass('next-item').removeClass('active');
            $(this).addClass('swiper-slide-active active');
        });
        $('.cms-hover-next-prev-all').on('mouseleave', function () {
            $(this).prevAll().removeClass('prev-item');
            $(this).nextAll().removeClass('next-item');
        });
        //
        $('[data-hover-change]').on('mouseenter', function () {
            var $hover_target = $(this).data('hover-change');
            $(this).parents('body').find('.' + $hover_target).addClass('hover');
        });
        $('[data-hover-change]').on('mouseleave', function () {
            var $hover_target = $(this).data('hover-change');
            $(this).parents('body').find('.' + $hover_target).removeClass('hover');
        });
        //
        scroll_top = $(this).scrollTop();

        if ($(window).outerWidth() < logo_tablet_mobile_size && srcLogoMobile != null) {
            $($imgLogo).attr('src', srcLogoMobile);
        }
        // change class for header button
        if ($headerTransparent) {
            $header.removeClass($headerDefaultClass).addClass($headerOnTopClass);
            //
            setTimeout(function () {
                $('body').css('--cms-wrap-header-height', $header_transparent_height + 'px');
            }, 300);
            // Change class
            genzia_header_change('ontop');
        }
        //
        genzia_dropdown_touched_side();
        //genzia_header_cart_dropdown();
        // Hover Change Width
        genzia_hover_change_width();
        // WooCommerce
        genzia_single_product_gallery_arrows();
    });

    $(window).on('resize', function () {
        $('html').removeClass('cms-modal-opened');
        // Min Height
        $('.cms-mb').each(function () {
            var $min_h = ($(this).outerHeight() + 8) * -1;
            $(this).css('--mb', $min_h + 'px');
        });
        //
        if ($headerTransparent) {
            // Add wrap header height 
            var $header_transparent_header_top_height = (typeof $('.cms-header-transparent #cms-header-top').outerHeight() !== 'undefined') ? $('.cms-header-transparent #cms-header-top').outerHeight(true) : 0,
                $header_transparent_header_height = (typeof $('.cms-header-transparent #cms-header').outerHeight() !== 'undefined') ? $('.cms-header-transparent #cms-header').outerHeight(true) : 0,
                $header_transparent_height = $header_transparent_header_top_height + $header_transparent_header_height;
            setTimeout(function () {
                $('body').css('--cms-wrap-header-height', $header_transparent_height + 'px');
            }, 300);
        }
        // Fix Header
        if ($header.hasClass('header-sticky-show')) {
            $header.addClass('header-sticky-hidden').removeClass('header-sticky-show');
        }
        // Fix Logo
        if ($(window).outerWidth() < logo_tablet_mobile_size && srcLogoMobile != null) {
            $($imgLogo).attr('src', srcLogoMobile);
        } else {
            $($imgLogo).attr('src', srcLogo);
        }
        $('.cms-primary-menu-dropdown .sub-menu').removeClass('submenu-open').attr('style', '');
        // Dropdown Mega Menu
        genzia_dropdown_mega_menu_full_width();
        //genzia_header_cart_dropdown();
        genzia_dropdown_touched_side();
        // Hover change Width
        genzia_hover_change_width();
        // WooCommerce
        genzia_single_product_gallery_arrows();
    });

    /* ====================
        Scroll To Top
    ====================== */
    $(window).on('scroll', function () {
        scroll_top = $(this).scrollTop();
        genzia_header_sticky();
        genzia_scroll_to_top();
        last_scroll_top = scroll_top;
    });

    function genzia_scroll_to_top() {
        if (scroll_top > last_scroll_top && scroll_top > header_height + 300) {
            $('.scroll-top').removeClass('to-top-show').addClass('to-top-hidden');
        } else {
            $('.scroll-top').removeClass('to-top-hidden').addClass('to-top-show');
            if (scroll_top < header_height + 300) {
                $('.scroll-top').removeClass('to-top-hidden').removeClass('to-top-show');
            }
        }
    }
    /* ====================
        Header Sticky
    ====================== */
    function genzia_header_sticky() {
        if (scroll_top > last_scroll_top) {
            if ($headerStickyAlways) {
                // Header Sticky Always
                $header.removeClass($headerDefaultClass).removeClass($headerOnTopClass).addClass('header-sticky-show ' + $headerStickyClass);
                // Change class
                genzia_header_change('sticky');
            } else if ($headerStickyScrollUp) {
                // Hide Header Sticky
                $header.removeClass($headerDefaultClass).removeClass($headerOnTopClass).addClass('header-sticky-hidden ' + $headerStickyClass);
                // Change class
                genzia_header_change('sticky');
            }
        } else {
            // Show Header Sticky
            if ($headerStickyScrollUp) {
                $header.addClass('header-sticky-show').removeClass('header-sticky-hidden');
                // Change class
                genzia_header_change('sticky');
            }
            // Change class
            genzia_header_change('sticky');
            // Replace Sticky Logo
            $imgLogo.attr('src', dataSticky);
            if ($(window).outerWidth() < logo_tablet_mobile_size) {
                $($imgLogo).attr('src', dataStickyMobile);
            }
        }
        // Return Header Default
        if (scroll_top == 0 && !$headerTransparent) {
            // Show Header Default
            $header.removeClass($headerOnTopClass).removeClass('header-sticky-show ' + $headerStickyClass);
            $header.addClass($headerDefaultClass);
            // Change class
            genzia_header_change('default');
        }
        // Return Header Transparent
        if (scroll_top == 0 && $headerTransparent) {
            // Show Header Transparent
            $header.removeClass($headerDefaultClass).removeClass('header-sticky-show ' + $headerStickyClass);
            $header.addClass($headerOnTopClass);
            // Replace Transparent Logo
            $imgLogo.attr('src', dataTransparent);
            if ($(window).outerWidth() < logo_tablet_mobile_size) {
                $($imgLogo).attr('src', dataTransparentMobile);
            }
            // Change class
            genzia_header_change('ontop');
        }
    }

    $(document).ready(function () {
        setTimeout(function () {
            if ($('body').hasClass('has-header-top')) {
                $('body').css('--cms-header-top-height', $('#cms-header-top').outerHeight() + 'px');
            }
        }, 300);
        /* =================
         Menu Dropdown
         =================== */
        var $menu = $('.site-navigation-dropdown');
        $menu.find('.cms-primary-menu-dropdown li').each(function () {
            var $submenu = $(this).find('>.sub-menu');
            if ($submenu.length == 1) {
                $(this).on('mouseenter', function () {
                    if ($submenu.offset().left + $submenu.width() > $(window).width()) {
                        $submenu.addClass('back');
                    } else if ($submenu.offset().left < 0) {
                        $submenu.addClass('back');
                    }
                }).on('mouseleave', function () {
                    $submenu.removeClass('back');
                });
            }
        });

        $('.sub-menu .current-menu-item').parents('.menu-item-has-children').addClass('current-menu-ancestor');
        $('.mega-auto-width').parents('.megamenu').addClass('remove-pos');
        // add current ancestor for mega parent 
        $('.cms-emenu-6 > .cms-title').each(function () {
            var mega_url = $(this).attr("href");
            var mega_root = window.location.href;
            if (mega_url == mega_root) {
                $('.cms-emenu-6 > .cms-title').addClass('current');
                $('.cms-emenu-6 > .cms-title').parents('.menu-item-has-children').addClass('current-menu-ancestor');
            }
        });
        /* =================
         Menu Mobile
         =================== */
        $("#main-menu-mobile").on('click touch', function (e) {
            'use strict';
            e.preventDefault();
            if ($('html').hasClass('cms-modal-opened')) {
                $('html').removeClass('cms-modal-opened');
            } else {
                $('html').addClass('cms-modal-opened');
            }
            $('#cms-header').toggleClass('header-mobile-open');
            $(this).find('.open-menu').toggleClass('opened');
            $('.site-navigation').toggleClass('navigation-open');
            if (scroll_top < header_height) {
                $header.removeClass('header-sticky-hidden').removeClass('header-sticky-show ' + $headerStickyClass);
            }
            if (scroll_top < header_height) {
                if ($header.hasClass('transparent-on') && $header.hasClass('header-mobile-open')) {
                    //$($imgLogo).attr('src', dataSticky);
                } else {
                    //$($imgLogo).attr('src', srcLogo);
                }
            }
            if ($(window).outerWidth() < logo_tablet_mobile_size) {
                if (scroll_top < header_height) {
                    if ($header.hasClass('transparent-on') && $header.hasClass('header-mobile-open')) {
                        //$($imgLogo).attr('src', dataStickyMobile); // change logo when open mobile menu
                    } else {
                        $($imgLogo).attr('src', srcLogoMobile);
                    }
                }
            }
        });
        $("#main-menu-mobile-close").on('click touch', function () {
            e.preventDefault();
            $('html').removeClass('cms-modal-opened');
            $('#cms-header').removeClass('header-mobile-open');
            $('.site-navigation').removeClass('navigation-open');
            $('.open-menu').removeClass('opened');
        });
        /* Mobile Sub Menu */
        $('.main-menu-toggle').on('click touch', function (e) {
            e.preventDefault();
            $(this).toggleClass('open');
            $(this).parents('.menu-item').toggleClass('current-menu-item');
            $(this).parents('.menu-item').find('> .sub-menu').toggleClass('submenu-open');
            $(this).parent('.cms-menu-link').next('.sub-menu').slideToggle();
        });
        /**
         * Header Left
         * */
        $("#cms-header-left-show-menu").on('click touch', function (e) {
            e.preventDefault();
            $(this).toggleClass('open');
            //$('.site-navigation').toggleClass('header-left-open');
            //$(this).find('.open-menu').toggleClass('opened');
            $('.site-navigation').toggleClass('open');
        });
        // HTML Checkbox
        $('.cms-checkbox').on('click', function () {
            $(this).toggleClass('checked')
        });
        $('[checked=checked]').parent().toggleClass("checked");
        $('input[type=checkbox]').on('change', function () {
            $(this).parent().toggleClass("checked");
        });
        $('input[type=radio]').on('change', function () {
            $(this).parents('.wpcf7-radio').find('label').removeClass("checked");
            $(this).parent().toggleClass("checked");
        });
        // Toggle
        genzia_toggle();
        // Modal
        genzia_modal();
        // Dropdown Mega Menu
        genzia_dropdown_mega_menu_full_width();
        // Dropdown touched side
        genzia_dropdown_touched_side();
        // Footer
        genzia_footer();
        // Lazy load
        genzia_lazy_images();
        // Woo
        genzia_quantity_plus_minus_action();
        genzia_header_cart_dropdown();
        genzia_single_product_gallery_arrows();
        genzia_woocs_menu_change_currency();
        genzia_single_add_to_cart_loadding();
        // WPCF7
        genzia_wpcf7();
        // Select 2 
        genzia_select2();
    });
    // Ajax Complete
    $(document).ajaxComplete(function (event, xhr, settings) {
        "use strict";
        // Modal
        //genzia_modal();
        // WPCF7
        genzia_wpcf7();
        // WooCommerce
        genzia_single_product_gallery_arrows();
        // Select 2 
        genzia_select2();
    });
    /**
     * Toggle
     * 
     * */
    function genzia_toggle(){
        "use strict";
        $('.cms-toggle').each(function(){
            var toggle = $(this).data('toggle');
            //console.log(toggle);
            //$(this).toggleClass('open');
            //toggle.toggleClass('open');
        });
        $('.cms-toggle').on('click', function (e) {
            e.preventDefault();
            var toggle = $(this).data('toggle'),
            focus = $(this).data('focus');
            $(this).toggleClass('open');
            $(toggle).toggleClass('open');
            if (typeof focus != 'undefined') {
                setTimeout(function () {
                    $(focus).focus();
                }, 300);
            }
        });
        $('.cms-toggle-close').on('click', function (e) {
            e.preventDefault();
            var toggle = $(this).data('toggle');
            $(toggle).toggleClass('open');
        });
    }
    /**
     * Modal
     * 
     * */
    function genzia_modal() {
        "use strict";
        $('.cms-modal').each(function () {
            var modal_move        = $(this).data('modal-move'),
                modal_open        = $(this).data('modal'),
                modal_mode        = $(this).data('modal-mode'),
                modal_slide       = $(this).data('modal-slide'),
                modal_class       = $(this).data('modal-class'),
                modal_width       = $(this).data('modal-width'),
                modal_space       = $(this).data('modal-space'),
                modal_space_top   = parseInt($(modal_open).find('.cms-modal-content').css('padding-top')),
                modal_space_bot   = parseInt($(modal_open).find('.cms-modal-content').css('padding-bottom')),
                modal_hidden      = $(this).data('modal-hidden'),
                modal_placeholder = $(this).data('modal-placeholder'),
                close_text        = $(this).data('close-text');

            $(modal_open).addClass('cms-modal-' + modal_mode);
            $(modal_open).addClass('cms-modal-' + modal_mode + '-' + modal_slide);
            $(modal_open).addClass(modal_class);
            $(modal_open).css('--cms-modal-width', modal_width);
            $(modal_open).css('--cms-modal-content-space', modal_space);
            $(modal_open).css('--cms-modal-mousewheel-space', modal_space_top + modal_space_bot + 'px');
            if (typeof modal_placeholder != 'undefined') {
                $(modal_open).find('.search-popup .cms-search-popup-input').attr('placeholder', modal_placeholder);
            }
            if (typeof close_text != 'undefined' && typeof close_text != '') {
                $(modal_open).find('.cms-close').prepend(close_text);
            }
            if (typeof modal_hidden != 'undefined') {
                $(modal_open).find('.cms-close').attr('data-modal-hidden', modal_hidden);
            }
            // bring all modal to footer
            if (typeof modal_move != 'undefined') {
                var modal_html = $(modal_move).html();
                $(modal_move).remove();
                $('body').append(modal_html);
            }
        });
        $('.cms-modal').on('click', function (e) {
            e.preventDefault();
            var modal_open = $(this).data('modal'),
                focus = $(this).data('focus'),
                modal_slide = $(this).data('modal-slide'),
                overlay_class = $(this).data('overlay-class'),
                modal_space_top = parseInt($(modal_open).find('.cms-modal-content').css('padding-top')),
                modal_space_bot = parseInt($(modal_open).find('.cms-modal-content').css('padding-bottom')),
                modal_hidden = $(this).data('modal-hidden');
            $(this).toggleClass('open');
            $(modal_open).toggleClass('open');
            $(modal_open).css('--cms-modal-mousewheel-space', modal_space_top + modal_space_bot + 'px');
            if (typeof focus != 'undefined') {
                setTimeout(function () {
                    $(focus).focus();
                }, 300);
            }
            //
            $('html').toggleClass('cms-modal-opened');
            $('body').find('.cms-modal-overlay').addClass(overlay_class);
            $('body').find('.cms-modal-overlay').toggleClass('open');
            $('body').find('.cms-modal-overlay').attr('data-modal-hidden', modal_hidden);
            $(modal_hidden).css({
                'opacity': '0',
                'visibility': 'hidden'
            });
        });
        $('.cms-close').on('click', function (e) {
            e.preventDefault();
            var modal_hidden = $(this).data('modal-hidden');
            $('html').removeClass('cms-modal-opened');
            $(this).parents('.cms-modal-html').removeClass('open');
            $(this).parents('body').find('.cms-modal.open').removeClass('open');
            $(this).parents('body').find('.cms-modal-overlay.open').removeClass('open');
            // get back
            $(modal_hidden).css({
                'opacity': '',
                'visibility': ''
            });
        });
        $('.cms-modal-overlay').on('click', function (e) {
            e.preventDefault();
            var modal_hidden = $(this).data('modal-hidden');
            $(this).removeClass('open');
            $('html').removeClass('cms-modal-opened');
            $(this).parent().find('.cms-modal.open').removeClass('open');
            $(this).parent().find('.cms-modal-html.open').removeClass('open');
            // get back
            $(modal_hidden).css({
                'opacity': '',
                'visibility': ''
            });
        });
    }
    /**
     * Dropdown Mega Menu
     * Full Width
     **/
    function genzia_dropdown_mega_menu_full_width() {
        'use strict';
        var parentPos = $('.cms-primary-menu'),
            window_width = $(window).width();
        parentPos.find('.megamenu').each(function () {
            var megamenu = $(this).find('> .cms-megamenu-full');
            if (megamenu.length == 1 && $(this).offset().left != 'undefined') {
                var megamenuPos = $(this).offset().left;
                if (window_width > 1279) {
                    if (genzia_is_rtl()) {
                        megamenu.css({
                            'right': megamenuPos,
                            'left': 'auto'
                        });
                    } else {
                        megamenu.css({
                            'left': megamenuPos * -1,
                            'right': 'auto'
                        });
                    }
                } else {
                    megamenu.css({
                        'left': '',
                        'right': ''
                    });
                }
            }
            // Mega menu container
            var megamenu_container = $(this).find('> .cms-megamenu-container');
            if (megamenu_container.length == 1 && $(this).offset().left != 'undefined') {
                var megamenu_container_w = megamenu_container.outerWidth(),
                    menuoffset = megamenu_container.offset().left,
                    megamenuPos = (menuoffset + megamenu_container_w - window_width) / -1;

                if ((menuoffset + megamenu_container_w) > window_width) {
                    if (genzia_is_rtl()) {
                        megamenu_container.css({
                            'right': megamenuPos,
                            'left': 'auto'
                        });
                    } else {
                        megamenu_container.css({
                            'left': megamenuPos,
                            'right': 'auto'
                        });
                    }
                } else {
                    megamenu_container.css({
                        'left': '',
                        'right': ''
                    });
                }
            }
        });
    }
    /**
     * Dropdown Touched Side
     * */
    function genzia_dropdown_touched_side() {
        setTimeout(function () {
            $('.cms-touchedside').each(function () {
                var content = $(this).find(' .cms--touchedside'),
                    content_w = content.outerWidth(),
                    window_width = $(window).width(),
                    offsetLeft = $(this).offset().left,
                    offsetRight = window_width - offsetLeft - $(this).outerWidth(),
                    dropdown_offset = $(this).data('dropdown-offset');
                if (typeof dropdown_offset == 'undefined') {
                    dropdown_offset = 0;
                }
                //
                content.removeClass('back');
                $(this).attr('data-offset', offsetLeft);
                $(this).attr('data-cw', content_w);
                $(this).attr('data-vw', window_width);
                if (content.length == 1) {
                    if (genzia_is_rtl()) {
                        if (offsetRight + content_w > window_width) {
                            var position = offsetRight + content_w - window_width;
                            //content.css({'left':'auto', 'right': position*-1});
                            content.css({
                                'left': '0',
                                'right': 'auto',
                                'margin-inline-end': dropdown_offset
                            });
                            content.addClass('back');
                        } else {
                            content.css({
                                'left': 'auto',
                                'right': '0',
                                'margin-inline-start': dropdown_offset
                            });
                            content.removeClass('back');
                        }
                    } else {
                        if (offsetLeft + content_w > window_width) {
                            var position = offsetLeft + content_w - window_width;
                            //content.css({'left': position*-1, 'right':'auto'});
                            content.css({
                                'left': 'auto',
                                'right': '0',
                                'margin-inline-end': dropdown_offset
                            });
                            content.addClass('back');
                        } else {
                            content.css({
                                'left': '0',
                                'right': 'auto',
                                'margin-inline-start': dropdown_offset
                            });
                            content.removeClass('back');
                        }
                    }
                }
            });
        }, 1000);
    }
    /**
     * Header Change
     * 
     * */
    function genzia_header_change(index) {
        'use strict';
        $('.cms-header-change').each(function () {
            var $classes = $(this).data('classes');
            var $DefaultClass = (typeof $classes != 'undefined' && typeof $classes.default_class != 'undefined') ? $classes.default_class.join(' ') : '',
                // Header Sticky
                $StickyClass = (typeof $classes != 'undefined' && typeof $classes.sticky_class != 'undefined') ? $classes.sticky_class.join(' ') : '',
                // Header On Top
                $OnTopClass = (typeof $classes != 'undefined' && typeof $classes.transparent_class != 'undefined') ? $classes.transparent_class.join(' ') : '';
            switch (index) {
                case 'ontop':
                    $(this).removeClass($DefaultClass).removeClass($StickyClass).addClass($OnTopClass);
                    break;
                case 'sticky':
                    $(this).removeClass($DefaultClass).removeClass($OnTopClass).addClass($StickyClass);
                    break;
                case 'default':
                    $(this).removeClass($StickyClass).removeClass($OnTopClass).addClass($DefaultClass);
                    break;
            }
        });
    }
    /**
     * Switcher Toggle
     * 
     * */
    function genzia_switcher_toggle() {
        'use strict';
        $('.cms-toggle-switcher').each(function () {
            var switcher = $(this),
                default_color = switcher.parent().find('.default').data('color'),
                switched_color = switcher.parent().find('.switched').data('color');
            switcher.on('click touch', function () {
                $(this).toggleClass('cms-swiched');
                $(this).parent().find('.default').toggleClass('text-' + default_color);
                $(this).parent().find('.switched').toggleClass('text-' + switched_color);
            });
        });
    }
    /**
     * Footer
     * */
    function genzia_footer() {
        'use strict';
        var body_footer_fixed = $('.cms-footer-fixed'),
            footer_fixed = $('.cms-footer--fixed'),
            footer_fixed_h = footer_fixed.outerHeight();
        body_footer_fixed.css({
            'padding-bottom': footer_fixed_h,
            '--cms-footer-fixed-height': footer_fixed_h
        });
    }
    /*
     * Lazy Images
     */
    function genzia_lazy_images() {
        'use strict';
        setTimeout(function () {
            $('.cms-lazy').each(function () {
                $(this).removeClass('lazy-loading').addClass('cms-lazy-loaded');
            });
        }, 100);
    }
    /**
     * Check right to left
     */
    function genzia_is_rtl() {
        "use strict";
        var rtl = $('html[dir="rtl"]'),
            is_rtl = rtl.length ? true : false;
        return is_rtl;
    }
    /**
     * Hover Change Width
     * */
    function genzia_hover_change_width() {
        'use strict';
        var window_width = $(window).width();
        if (window_width > 1024) {
            $('[data-hover-target]').on('mouseenter', function () {
                var target = $(this).data('hover-target');
                $(this).addClass('active').css({
                    'width': '66.667%',
                    'flex': '0 0 66.667%'
                });
                if (target == 'next') {
                    var width = $(this).next().data('width');
                    $(this).next().removeClass('active').css({
                        'width': '33.333%',
                        'flex': '0 0 33.333%'
                    });
                }
                if (target == 'prev') {
                    var width = $(this).next().data('width');
                    $(this).prev().removeClass('active').css({
                        'width': '33.333%',
                        'flex': '0 0 33.333%'
                    });
                }
            });
        } else {
            $('[data-hover-target]').css({
                'width': '',
                'flex': ''
            });
        }
    }
    /**
     * Header WooCommerce Cart Dropdown
     * */
    function genzia_header_cart_dropdown() {
        "use strict";
        $('.site-header-cart').each(function () {
            var header_cart = $(this),
                header_cart_h = header_cart.outerHeight(),
                header_cart_content = header_cart.find('.cms-header-cart-dropdown'),
                header_cart_content_pos = ((header_main_height - header_cart_h) / 2 + header_cart_h);
            if (header_cart_content.length == 1) {
                header_cart_content.css('top', header_cart_content_pos);
                $(window).on('scroll', function () {
                    header_cart_content.removeClass('open');
                });
                header_cart.on('click touch', function () {
                    //$(this).toggleClass('active');
                    //header_cart_content.toggleClass('open');
                });
                header_cart.on('click touch', function (e) {
                    //e.preventDefault();
                    //$(this).parents('body').find('.cms-header-cart-dropdown').removeClass('open');
                    $(this).toggleClass('open');
                    header_cart_content.toggleClass("open");
                });
                $('body').on('click touch', function () {
                    //header_cart.removeClass('open');
                    //header_cart_content.removeClass('open');
                });
            }
        });
    }
    /**
     * WooCommerce 
     * Select 2 form product order form
     * */
    function genzia_select2() {
        'use strict';
        if (typeof jQuery.fn.select2 != 'undefined') {
            $('.woocommerce-ordering select').select2({
                theme: 'cms-dropdown',
                minimumResultsForSearch: -1
            });
        } else {
            $('.woocommerce-ordering select').addClass('no-select2');
        }
    }
    /*
     * WooCommerce Quantity action
     */
    function genzia_quantity_plus_minus_action() {
        "use strict";
        $(document).on('click', '.quantity .cms-qty-act', function () {
            var $this = $(this),
                spinner = $this.parents('.quantity'),
                input = spinner.find('input.qty'),
                step = input.attr('step'),
                min = input.attr('min'),
                max = input.attr('max'),
                value = parseInt(input.val());
            if (!value) value = 0;
            if (!step) step = 1;
            step = parseInt(step);
            if (!min) min = 0;
            var type = $this.hasClass('cms-qty-up') ? 'up' : 'down';
            switch (type) {
                case 'up':
                    if (!(max && value >= max))
                        input.val(value + step).change();
                    break;
                case 'down':
                    if (value > min)
                        input.val(value - step).change();
                    break;
            }
            if (max && (parseInt(input.val()) > max))
                input.val(max).change();
            if (parseInt(input.val()) < min)
                input.val(min).change();
        });
    }
    /**
     * WooCommerce Product Gallery
     * Flex direction Nav position
     * 
     * */
    function genzia_single_product_gallery_arrows() {
        'use strict';
        // fix arrow position
        if (typeof $.flexslider != 'undefined') {
            setTimeout(function () {
                $('.woocommerce-product-gallery').each(function () {
                    var flex_viewport = $(this).find('.flex-viewport'),
                        flex_viewport_h = flex_viewport.outerHeight(),
                        arrow_pos = (flex_viewport_h / 2),
                        arrow = $(this).find('.flex-direction-nav li');
                    arrow.css('top', arrow_pos);
                }), 1000
            });
        }
    }
    /**
     * WooCommerce Single Add to Cart Button
     * add loading class
     * 
     * */
    function genzia_single_add_to_cart_loadding(){
        // Add the 'loading' class when the add to cart button is clicked
        $('body').on('click', '.single_add_to_cart_button', function() {
            $(this).addClass('loading');
        });

        // Remove the 'loading' class after the product is added to the cart (WooCommerce AJAX event)
        $('body').on('added_to_cart', function() {
            $('.single_add_to_cart_button').removeClass('loading');
        });

        // Remove the 'loading' class if the AJAX request fails or completes without adding to cart
        $('body').on('wc_fragments_refreshed', function() {
            $('.single_add_to_cart_button').removeClass('loading');
        });
    }
    /**
     * WooCommerce Currency Switcher
     * 
     * Add currency to menu
     * **/
    function genzia_woocs_menu_change_currency() {
        'use strict';
        $('.cms-woocs').on('click', function (e) {
            e.preventDefault();
            var currency = $(this).data('currency');
            window.location.href = location.protocol + '//' + location.host + location.pathname + '?currency=' + currency;
        });
    }
    // Contact form 7
    function genzia_wpcf7() {
        'use strict';
        // add radio class active for default item
        $('.wpcf7-radio').each(function () {
            $('input[checked="checked"]').parents('.wpcf7-list-item').addClass('active');
        });
        // add radio class active on click
        $('.wpcf7-radio .wpcf7-list-item').on('click', function () {
            $(this).parent().find('.wpcf7-list-item').removeClass('active');
            $(this).toggleClass('active');
        });
        // add checkbox class active
        $('.wpcf7-checkbox .wpcf7-list-item').on('click', function () {
            $(this).toggleClass('active');
        });
        // date time
        $('.wpcf7-form-control-wrap.cms-date-time').on('click', function () {
            $(this).addClass('active');
        });
    }
})(jQuery);

// Animate on Scroll
(function ($) {
    "use strict";
    window.genzia_requestAnimFrame = function () {
        return (
            window.requestAnimationFrame ||
            window.webkitRequestAnimationFrame ||
            window.mozRequestAnimationFrame ||
            window.oRequestAnimationFrame ||
            window.msRequestAnimationFrame ||
            function (callback) {
                window.setTimeout(callback, 1000 / 60);
            }
        );
    }();
    window.genzia_floating_image_loop = function () {
        var win_w = window.innerWidth;
        var win_h = window.innerHeight;
        $('.cms_floating_image_image').each(function () {
            //var elem = $(this).find('.cms_floating_image_image');
            var bounds = this.getBoundingClientRect();
            if (bounds.top < win_h && bounds.bottom > 0) {
                var speed = $(this).attr('data-speed') / 10;
                //var speed = elem.attr( 'data-speed' ) / 10;
                var ypos = (bounds.top - win_h / 5) * speed;
                // elem.css( 'transform', 'translateY(' + ypos + 'px)' );
                $(this).css('transform', 'translateY(' + ypos + 'px)');
            }

        });
        window.genzia_floating_image_lock = false;
    }

    window.genzia_floating_image_lock = false;

    $(window).on('scroll', function () {
        if (!window.genzia_floating_image_lock) {
            window.genzia_floating_image_lock = true;
            genzia_requestAnimFrame(genzia_floating_image_loop);
        }
    });

    genzia_requestAnimFrame(genzia_floating_image_loop);

    $(window).on("load", function () {
        genzia_requestAnimFrame(genzia_floating_image_loop);
    });
})(jQuery);
/**
 * WPC Smart Wishlist
 * update wishlist count on header 
 */
jQuery(document).on('woosw_change_count', function (event, count) {
    jQuery('.wishlist-count').html(count);
    jQuery('.wishlist-icon').attr('data-count', count);
});
/**
 * WPC Smart Wishlist
 * update custom icon
 */
jQuery('.cms-woosw-btn').not('.woosw-added').on('click touch', function (e) {
    // change text
    jQuery(this).attr('data-hint', cms_woosw_vars.button_text_adding);
    jQuery(this).attr('aria-label', cms_woosw_vars.button_text_adding);
    // change icon
    jQuery(this).find('.cms-woosw-btn-icon').append(cms_woosw_vars.icon_loadding);
    jQuery(this).find('.cms-woosw-btn-icon').addClass('cms-loading');
});
jQuery(document).on('woosw_add', function (event, id) {
    // change text
    jQuery('.woosw-btn-' + id).attr('data-hint', woosw_vars.button_text_added);
    jQuery('.woosw-btn-' + id).attr('aria-label', woosw_vars.button_text_added);
    // change icon
    if (jQuery('.woosw-btn-' + id).hasClass('woosw-added')) {
        jQuery('.woosw-btn-' + id).find('.cms-woosw-btn-icon').html(cms_woosw_vars.icon_added).removeClass('cms-loading');
    }
});
jQuery(document).on('woosw_remove', function (event, product_id) {
    // change text
    jQuery('.woosw-btn-' + product_id).attr('data-hint', woosw_vars.button_text);
    jQuery('.woosw-btn-' + product_id).attr('aria-label', woosw_vars.button_text);
    // change icon
    if (jQuery('.woosw-btn-' + product_id).not('.woosw-added')) {
        jQuery('.woosw-btn-' + product_id).find('.cms-woosw-btn-icon').html(cms_woosw_vars.icon_normal).removeClass('cms-loading');
    }
});
jQuery(document).on('woosw_empty', function (event, id) {
    // change text
    jQuery('.woosw-btn').attr('data-hint', woosw_vars.button_text);
    jQuery('.woosw-btn').attr('aria-label', woosw_vars.button_text);
    // change icon
    jQuery('.woosw-btn').find('.cms-woosw-btn-icon').html(cms_woosw_vars.icon_normal).removeClass('cms-loading');
});

/**
 * WPC Smart Compare
 * update compare count on header 
 */
jQuery(document).on('woosc_change_count', function (event, count) {
    jQuery('.compare-count').html(count);
    jQuery('.compare-icon').attr('data-count', count);
});

/**
 * Popup Newsletter
 * 
 * */
(function ($) {
    'use strict';
    window.Core = {};
    Core.body = $('body');
    Core.html = $('html');
    Core.windowWidth = $(window).width();
    Core.windowHeight = $(window).height();
    Core.scroll = 0;
    $(window).on(
        'load',
        function () {
            SubscribeModal.init();
        }
    );

    var SubscribeModal = {
        init: function () {
            this.holder = $('#cms-subscribe-popup');

            if (this.holder.length) {
                var $preventHolder = this.holder.find('.cms-sp-prevent-inner'),
                    $modalClose = $('.cms-sp-close'),
                    disabledPopup = 'no';

                if ($preventHolder.length) {
                    var isLocalStorage = this.holder.hasClass('cms-sp-prevent-cookies'),
                        $preventInput = $preventHolder.find('.cms-sp-prevent-input');

                    if (isLocalStorage) {
                        disabledPopup = localStorage.getItem('disabledPopup');
                        sessionStorage.removeItem('disabledPopup');
                    } else {
                        disabledPopup = sessionStorage.getItem('disabledPopup');
                        localStorage.removeItem('disabledPopup');
                    }

                    $preventHolder.children().on(
                        'click',
                        function (e) {
                            $preventInput.val(this.checked);

                            if ($preventInput.attr('value') === 'true') {
                                if (isLocalStorage) {
                                    localStorage.setItem('disabledPopup', 'yes');
                                } else {
                                    sessionStorage.setItem('disabledPopup', 'yes');
                                }
                            } else {
                                if (isLocalStorage) {
                                    localStorage.setItem('disabledPopup', 'no');
                                } else {
                                    sessionStorage.setItem('disabledPopup', 'no');
                                }
                            }
                        }
                    );
                }

                if (disabledPopup !== 'yes') {
                    if (Core.body.hasClass('cms-sp-opened')) {
                        SubscribeModal.handleClassAndScroll('remove');
                    } else {
                        SubscribeModal.handleClassAndScroll('add');
                    }

                    $modalClose.on(
                        'click',
                        function (e) {
                            e.preventDefault();

                            SubscribeModal.handleClassAndScroll('remove');
                        }
                    );

                    // Close on escape
                    $(document).keyup(
                        function (e) {
                            if (e.keyCode === 27) { // KeyCode for ESC button is 27
                                SubscribeModal.handleClassAndScroll('remove');
                            }
                        }
                    );
                }
            }
        },

        handleClassAndScroll: function (option) {
            if (option === 'remove') {
                Core.body.removeClass('cms-sp-opened');
            }

            if (option === 'add') {
                Core.body.addClass('cms-sp-opened');
            }
        },
    };

})(jQuery);
/**
 * Genzia 
 * Mouse Cursor
 * 
 * **/
(function ($) {
    'use strict';
    // This case is important when theme is not active
    if (typeof GenziaCore !== 'object') {
        window.GenziaCore = {};
    }
    window.GenziaCore = {};
    GenziaCore.body = $('body');
    GenziaCore.html = $('html');
    GenziaCore.windowWidth = $(window).width();
    GenziaCore.windowHeight = $(window).height();
    GenziaCore.scroll = 0;

    $(document).ready(function () {
        CMSThemeCursor().init();
    });

    function CMSThemeCursor() {
        var cursorEnabled = GenziaCore.body.hasClass('cms-theme-cursor'),
            cursor = $('#cms-theme-cursor');
        // Move
        var moveCursor = function () {
            var transformCursor = function (x, y) {
                cursor.css({
                    'transform': 'translate3d(' + x + 'px, ' + y + 'px, 0)'
                });
            };
            var handleMove = function (e) {
                var x = e.clientX - cursor.width() / 2,
                    y = e.clientY - cursor.height() / 2;
                requestAnimationFrame(function () {
                    transformCursor(x, y);
                });
            };
            $(window).on('mousemove', handleMove);
        };
        // Hover
        var hoverClass = function () {
            $('.button').disabled = false;
            var items = 'a, button';
            var addCSSClass = function () {
                !cursor.hasClass('cms-hovering') && cursor.addClass('cms-hovering');
            };
            var removeCSSClass = function () {
                cursor.hasClass('cms-hovering') && cursor.removeClass('cms-hovering');
            };
            $(document).on('mouseenter', items, addCSSClass);
            $(document).on('mouseleave', items, removeCSSClass);
        };
        // Show Cursor
        var showCursor = function () {
            !cursor.hasClass('cms-visible') && cursor.addClass('cms-visible');
        }
        // Hide Cursor
        var hideCursor = function () {
            cursor.hasClass('cms-visible') && cursor.removeClass('cms-visible cms-hovering');
        };
        // Override Cursor
        var overrideCursor = function () {
            cursor.toggleClass('cms-override');
        };
        // Control Items
        var controlItems = function () {
            var items = $('.cms-hover-move');
            items.length &&
                items.each(function () {
                    var item = $(this),
                        inner = item.children(),
                        coeff = item.parent().data('move') == 'strict' ? 0.6 : 1,
                        limit = 9 * coeff;
                    var cX, cY, w, h, x, y, inRange; //position variables
                    var updatePosition = function () {
                        cX = cursor.offset().left;
                        cY = cursor.offset().top;
                        w = item.width();
                        h = item.height();
                        x = item.offset().left + w / 2;
                        y = item.offset().top + h / 2;
                        inRange = Math.abs(x - cX) < w * coeff && Math.abs(y - cY) < h * coeff;
                    };
                    var coords = function () {
                        return {
                            x: Math.abs(cX - x) < limit ? cX - x : limit * (cX - x) / Math.abs(cX - x),
                            y: Math.abs(cY - y) < limit ? cY - y : limit * (cY - y) / Math.abs(cY - y)
                        }
                    };
                    var moveItem = function () {
                        inner.addClass('cms-moving');
                        var deltaX = 0,
                            deltaY = 0,
                            dX = coords().x,
                            dY = coords().y;
                        var transformItem = function () {
                            deltaX += (coords().x - dX) / 5;
                            deltaY += (coords().y - dY) / 5;
                            deltaX.toFixed(2) !== dX.toFixed(2) &&
                                inner.css({
                                    'transform': 'translate3d(' + deltaX + 'px, ' + deltaY + 'px, 0)',
                                    'transition': '1s cubic-bezier(.2,.84,.5,1)'
                                });
                            dX = deltaX;
                            dY = deltaY;
                            requestAnimationFrame(function () {
                                inRange && transformItem();
                            });
                        };
                        transformItem();
                    };
                    var resetItem = function () {
                        inner
                            .removeClass('cms-moving')
                            .css({
                                'transition': 'transform 1.6s',
                                'transform': 'translate3d(0px, 0px, 0px)'
                            })
                            .one(GenziaCore.CMSTransitionEnd, function () {
                                inner.removeClass('cms-controlled');
                                inner.css({
                                    'transition': 'none'
                                });
                            });
                    };
                    var setState = function () {
                        updatePosition();

                        if (inRange) {
                            !inner.hasClass('cms-moving') && moveItem(); //start move
                        } else {
                            inner.hasClass('cms-moving') && resetItem();
                        }
                        requestAnimationFrame(setState);
                    };
                    requestAnimationFrame(setState);
                });
        };

        var changeCursor = function () {
            var instances = [{
                        type: 'light',
                        triggers: '.cms-cursor-light',
                        css_class : ''
                    },
                    {
                        type: 'dark',
                        triggers: '.cms-cursor-dark',
                        css_class : ''
                    },
                    {
                        type: 'preloader',
                        triggers: '.cms-page-spinner',
                        css_class : ''
                    },
                    {
                        type: 'drag-white',
                        triggers: '.cms-cursor-drag-white',
                        css_class : 'drag'
                    },
                    {
                        type: 'drag-black',
                        triggers: '.cms-cursor-drag-black',
                        css_class : 'drag'
                    },
                    {
                        type: 'drag-accent',
                        triggers: '.cms-cursor-drag-accent',
                        css_class : 'drag'
                    },
                    {
                        type: 'drag-vert',
                        triggers: '.cms-cursor-drag-vert',
                        css_class : 'drag-vert'
                    },
                    {
                        type: 'cursor-text',
                        triggers: '.cms-cursor-text',
                        css_class : 'cursor-text'
                    },
                    {
                        type: 'image',
                        cursor: '',
                        triggers: '.cms-cursor-img',
                        css_class : ''
                    },
                ],
            triggers  = '',
            css_class = '',
            hides     = 'a, video, iframe',
            overrides = '.cms-portfolio-list.cms-item-layout--info-on-hover-boxed .cms-e';

            var setCursor = function (type, css_class, text) {
                cursor.addClass('cms-' + type);
                cursor.addClass('cms-' + css_class);
                cursor.find('.cms-cursor-text').text(text);
            };

            var resetCursor = function () {
                instances.forEach(function (instance) {
                    cursor.removeClass('cms-' + instance.type);
                    cursor.removeClass('cms-' + instance.css_class);
                    cursor.find('.cms-cursor-text').empty();
                });
            };

            instances.forEach(function (instance, i) {
                triggers += instance.triggers;
                if (i + 1 < instances.length) triggers += ', ';

                $(document).on('mouseenter', instance.triggers, function () {
                    var text = $(this).data('cursor-text');
                    setCursor(instance.type, instance.css_class, text);
                });
            });

            $(document).on('mouseleave', triggers, resetCursor);
            $(document).on('mouseenter mouseleave', overrides, function () {
                overrideCursor();
            });
            $(document).on('mousemove', hides, function () {
                hideCursor();
            });
            $(document).on('mouseleave', hides, function () {
                showCursor();
            });
            $(document).on('mouseleave', hideCursor);
            $(document).on('mouseenter', showCursor);
        };

        var isIE = function () {

            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");
            var isIE = false;

            if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) // If Internet Explorer
            {
                isIE = true;

                if (cursorEnabled) {
                    GenziaCore.body.removeClass('cms-theme-cursor');
                }
            } else // If another browser
            {
                isIE = false;
            }

            return isIE;
        };

        var init = function () {
            $(document).one('mousemove', function () {
                showCursor();
            });
            moveCursor();
            hoverClass();
            controlItems();
            changeCursor();
        };

        return {
            init: function () {
                !Modernizr.touch && cursorEnabled && !isIE() && init();
            }
        }
    }
})(jQuery);

/**
 * Genzia 
 * add class when css sticky actived
 * **/
(function($) {
    "use strict";
    var stickyEls = $('.cms-sticky');
    $.each(stickyEls, function(index, stickyEl) {
        stickyEl = $(stickyEl);
        let observer = new IntersectionObserver(
            function([e]) {
                if (e.intersectionRatio < 1) {
                    $(e.target).removeClass('cms-sticky-active');
                } else {
                    $(e.target).addClass('cms-sticky-active');
                }
            }, { threshold: [1] }
        );
        observer.observe(stickyEl[0]);
    });
})(jQuery);