(function ($) {
    "use strict";
    function Process(selector, config) {
        this.el = $(selector);
        // options do not effect CSS, has to be set seperately
        const defaults = {
            track: {
                endAtLast: false
            },
            viewPointBottom: false,
            viewPoint: 400
        };
        this.options = $.extend({}, defaults, config || {});
        $(document).ready(() => {
            this.init();
        });
        this.init = function () {
            this.el.addClass("is-loading");
            this.el.addClass("is-init");
            this.el.each(function () {
                this.offsetHeight;
            });
            this.el.removeClass("is-loading");
            this.animation();
            // this.trackHeight();

            let self = this;
            $(document).scroll(function () {
                self.animation();
            });
            $(document).resize(function () {
                // self.trackHeight();
            });
        };
        this.animation = function () {
            let self = this;

            let scrollTop = $(document).scrollTop();
            let viewPoint = scrollTop + this.options.viewPoint;
            if (this.options.viewPointBottom) {
                viewPoint = scrollTop + window.innerHeight - this.options.viewPoint;
            }

            this.updateTrack(viewPoint);

            $(".cms-process", this.el).each(function (i, v) {
                let top = $(this).offset().top;
                let bottom = $(this).offset().top + $(this).outerHeight(true);

                if (viewPoint < top) {
                    self.updateClasses(this, "is-below");
                } else if (viewPoint > bottom) {
                    self.updateClasses(this, "is-above is-visible active");
                } else {
                    self.updateClasses(this, "is-current is-visible active");
                }
            });
        };
        this.updateClasses = function (el, newClass) {
            $(el).removeClass("is-above is-current is-below is-visible active");
            $(el).addClass(newClass);
        };
        this.updateTrack = function (viewPoint) {
            const $el = this.el.next(".process__track");
            if ($el.length === 0) {
                return;
            }
            let top = $el.offset().top;
            let height = viewPoint - top;
            $el.height(height);
        };
        this.trackHeight = function () {
            let trackMax = this.el.outerHeight();
            this.el.next(".process__track").css("max-height", trackMax);
        };
    }
    class Elementor_Process {
        static instance;

        static getInstance() {
            if (!Elementor_Process.instance) {
                Elementor_Process.instance = new Elementor_Process();
            }
            return Elementor_Process.instance;
        }

        constructor() {
            $(window).on('elementor/frontend/init', () => {
                this.init();
            });
        }

        init() {
            elementorFrontend.hooks.addAction('frontend/element_ready/cms_process.default', ($scope, $) => {
                var wrapW = $scope.find('.cms-eprocess-scroll').width(),
                    lastHeight = $scope.find('.cms-process.last').outerHeight();
                //
                $scope.find('.cms-eprocess-scroll').css({
                    '--cms-eprocess-scroll-width': wrapW + 'px',
                    '--cms-eprocess-scroll-bar-height': 'calc(100% - ' + lastHeight + 'px)'
                });
                $(window).on("resize", function (event) {
                    var wrapW = $scope.find('.cms-eprocess-scroll').width(),
                        lastHeight = $scope.find('.cms-process.last').outerHeight();
                    //
                    $scope.find('.cms-eprocess-scroll').css({
                        '--cms-eprocess-scroll-width': wrapW + 'px',
                        '--cms-eprocess-scroll-bar-height': 'calc(100% - ' + lastHeight + 'px)'
                    });
                    //$mask.height($('body').height());
                });

                new Process($scope.find(".cms-eprocess--scroll"));
            });
        }
    }
    Elementor_Process.getInstance();
    //
    
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCMSGSAPHandler = function( $scope, $ ) {
        gsap.registerPlugin(ScrollTrigger);
        var pinContent = $scope.find(".cms-gsap-pin"),
            pinParent = pinContent.parents('.e-parent');
        /**
         * Scroll Horizontal
         *  
         * */
        if (window.gsap && window.ScrollTrigger && window.innerWidth > 1024) {
            gsap.timeline({ 
              scrollTrigger: { 
                trigger: pinParent,
                start: "top top", 
                end: "bottom bottom+=150",
                //endTrigger: $endTrigger_img[0],
                pin: true, 
                scrub: true,
                pinSpacing: false,
                toggleClass: {
                  targets: pinParent,
                  className: "cms-pinned"
                }
              }
            });
            //
            const process_block = document.getElementById('cms-scroll-horiz');
            if (process_block) {
                const processes = document.querySelectorAll('.cms-scroll-horiz-item');

                gsap.set(process_block, {
                    height: (processes.length / 1.5) * window.innerHeight
                });

                const tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: process_block,
                        scrub: true,
                        start: 'top -10%',
                        end: 'bottom bottom'
                    }
                });

                processes.forEach((proces, index) => {
                    const description = proces.querySelector('.cms-scroll-horiz-item-bottom');
                    const descriptionLv2 = proces.querySelector('.cms-scroll-horiz-item-bottom2');

                    if (descriptionLv2) {
                        gsap.set(descriptionLv2, { autoAlpha: 0 });
                    }

                    if ((processes.length - 1) > index) {
                        tl.to(proces, {
                            width: 200,
                            ease: 'none'
                        });

                        tl.to(description, {
                            autoAlpha: 0,
                            y: -70,
                            ease: 'none'
                        }, '<');

                        tl.to(descriptionLv2, {
                            autoAlpha: 1,
                            y: 0,
                            ease: 'none'
                        }, '<');
                    }
                });
            }
        }
    };
    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/cms_process.default', WidgetCMSGSAPHandler );
    } );
})(jQuery);