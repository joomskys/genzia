(function($) {
    /**
     * Scroll Sticky Grow Up
     * 
     */
    var WidgetCMSScrollStickyGrowUp = function($scope, $) {
        let els = $scope.find('.cms-scroll-sticky-grow-up');
        let container = $scope.parents('.e-parent').first();
        $.each(els, (i, el) => {
            el = $(el);
            let pointer = $('<div>');
            pointer.css({
                position: 'absolute',
                top: 0,
                width: '100%',
                height: '100vh',
            });
            let anchor = el.find('.cms-scroll-sticky--grow-up').before(pointer);
            let target = el.find('.cms-scroll-sticky---grow-up');
            let target_opacity = el.find('.cms-scroll-sticky--show');
            let targetWidth = target.outerWidth();
            let targetHeight = target.outerHeight();
            let anchorWidth = anchor.outerWidth();
            let anchorHeight = anchor.outerHeight();
            let anchorRatio = anchorWidth / anchorHeight;
            let newTargetWidth = targetWidth;
            let newTargetHeight = targetHeight;
            if (anchorRatio < 1) {
                newTargetWidth = targetHeight * anchorRatio;
            } else {
                newTargetHeight = targetWidth / anchorRatio;
            }
            target.css('width', newTargetWidth);
            target.css('height', newTargetHeight);
            pointer.scroller({
                sensitivity: 50,
                callback: event => {
                    let { $element, isInViewport, isDisappearing, intersectionScrollDirection, scrollPercentage } = event;
                    if (isInViewport) {
                        let anchorViewportPercentage = anchor.getElementViewportPercentage();
                        if (anchorViewportPercentage >= 50) {
                            $element.scroller('onWindowScroll');
                            $element.scroller('onWindowResize');
                        } else {
                            $element.scroller('offWindowScroll');
                            $element.scroller('offWindowResize');
                        }
                    }
                },
                onWindowScroll: () => {
                    anchorWidth = anchor.outerWidth();
                    anchorHeight = anchor.outerHeight();
                    let elViewportPercentage = el.getElementViewportPercentage();
                    let anchorViewportPercentage = anchor.getElementViewportPercentage();
                    target.css('width', newTargetWidth + ((anchorWidth / 75) * (elViewportPercentage - 25)));
                    target.css('height', newTargetHeight + ((anchorHeight / 75) * (elViewportPercentage - 25)));
                    //
                    if(elViewportPercentage >= 75){
                        container.addClass('is-sticky'); // add class to parent
                    }
                    else{
                        container.removeClass('is-sticky'); // remove class from parent
                    }
                },
                onWindowResize: () => {
                    anchorWidth = anchor.outerWidth();
                    anchorHeight = anchor.outerHeight();
                    anchorRatio = anchorWidth / anchorHeight;
                    newTargetWidth = targetWidth;
                    newTargetHeight = targetHeight;
                    if (anchorRatio < 1) {
                        newTargetWidth = targetHeight * anchorRatio;
                    } else {
                        newTargetHeight = targetWidth / anchorRatio;
                    }
                    let elViewportPercentage = el.getElementViewportPercentage();
                    let anchorViewportPercentage = anchor.getElementViewportPercentage();
                    target.css('width', newTargetWidth + ((anchorWidth / 75) * (elViewportPercentage - 25)));
                    target.css('height', newTargetHeight + ((anchorHeight / 75) * (elViewportPercentage - 25)));
                    if(elViewportPercentage >= 75){
                        container.addClass('is-sticky'); // add class to parent
                    }
                    else{
                        container.removeClass('is-sticky'); // remove class from parent
                    }
                },
            });
        });
    };
    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_theme_scroll_sticky_grow_up.default', WidgetCMSScrollStickyGrowUp);
    });
})(jQuery);