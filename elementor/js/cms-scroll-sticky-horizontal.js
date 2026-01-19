(function($) {
    var WidgetCMSServiceScroll = function($scope, $) {
        let els = $scope.find('.cms-scroll-sticky-horizontal'),
            els_breakpoint = els.data('breakpoint');
        //
        if(window.innerWidth <= els_breakpoint) return;
        //
        $.each(els, (i, el) => {
            el = $(el);
            const pointer = $('<div>');
            pointer.css({
                position: 'sticky',
                top: 0,
                width: '100%',
            });
            el.children().appendTo(pointer);
            el.append(pointer);
            const scrollItems = el.find('.cms-scroll-sticky-horizontal-item');
            let totalWidth = 0;
            $.each(scrollItems, function(iScrollItem, item) {
                item = $(item);
                totalWidth += item.outerWidth();
            });
            el.css('height', totalWidth + 300);
            setPosition(el);

            pointer.scroller({
                sensitivity: 0,
                callback: event => {
                    let { $element, isInViewport, isDisappearing, intersectionScrollDirection, scrollPercentage } = event;
                    if (isInViewport) {
                        $element.scroller('onWindowScroll');
                        $element.scroller('onWindowResize');
                    } else {
                        $element.scroller('offWindowScroll');
                        $element.scroller('offWindowResize');
                    }
                },
                onWindowScroll: () => {
                    setPosition(el);
                },
                onWindowResize: () => {
                    setPosition(el);
                },
            });
        });

        function getProcessing(el) {
            el = $(el);
            if (el.length == 0) {
                return false;
            }

            const fromTop = 0;
            const toTop = el.outerHeight() * -1;
            const elOffset = el[0].getBoundingClientRect();
            if (elOffset.top > fromTop) {
                return 0;
            } else if (elOffset.top <= fromTop && elOffset.top >= toTop) {
                if (elOffset.top >= 0) {
                    return (fromTop - elOffset.top) / (fromTop + Math.abs(toTop)) * 100;
                } else {
                    return (Math.abs(elOffset.top) + fromTop) / (fromTop + Math.abs(toTop)) * 100;
                }
            } else {
                return 100;
            }
        }

        function setPosition(el) {
            const scrollItems = el.find('.cms-scroll-sticky-horizontal-item');
            const processing = getProcessing(el);
            let scrollDistance = 0;
            $.each(scrollItems, function(iScrollItem, item) {
                item = $(item);
                scrollDistance += item.outerWidth();
            });
            let scrolled = processing / 100 * scrollDistance;
            let container = el.parents('.e-con-inner').first();
            let section = container.parent();
            let grid = el.find('.cms-scroll-sticky-horizontal-content'),
                grid_breakpoint = grid.data('break');
            let gridParent = grid.parent();
            let gridWidth = ((section.outerWidth() - container.outerWidth()) / 2 + gridParent.outerWidth() - parseInt(gridParent.css('padding-left')) - parseInt(grid.css('margin-left')));
            for (let i = 1; i < scrollItems.length; i++) {
                let scrollItem = $(scrollItems[i]);
                let scrollItemWidth = scrollItem.outerWidth();
                let offsetScroll = (gridWidth - scrollItemWidth) / (scrollItems.length - 1);
                if(window.innerWidth > grid_breakpoint){
                    if (scrolled <= (scrollItemWidth - offsetScroll) * i) {
                        scrollItem.css('transform', `translateX(-${scrolled}px)`);
                    } else {
                        scrollItem.css('transform', `translateX(-${(scrollItemWidth - offsetScroll) * i}px)`);
                    }
                } else {
                    scrollItem.css('transform','');
                }
            }
        }
    };
    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_teams.default', WidgetCMSServiceScroll);
    });
})(jQuery);