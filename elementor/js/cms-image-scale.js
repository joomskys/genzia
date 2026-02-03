(function ($) {
    'use strict';

    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var ImageScaleHandler = function ($scope, $) {
        // State
        let section = null;
        let wrapper = null;
        let container = null;
        let scrollStart = 0;
        let scrollEnd = 0;

        // Utility: Clamp value between min and max
        function clamp(value, min, max) {
            return Math.min(Math.max(value, min), max);
        }

        // Initialize the image scale animation
        function initImageScale() {
            section = document.querySelector('.image-scale-section');
            wrapper = document.querySelector('.image-scale-wrapper');
            container = document.querySelector('.image-scale-container');

            if (!section || !container || !wrapper) return;

            // Calculate scroll trigger points
            calculateScrollPoints();

            // Attach scroll listener
            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', () => {
                calculateScrollPoints();
                onScroll();
            });

            // Initial update
            onScroll();
        }

        // Calculate where animation starts and ends
        function calculateScrollPoints() {
            if (!section) return;

            const rect = section.getBoundingClientRect();
            const scrollY = window.scrollY;

            // Animation starts when section top reaches viewport top
            scrollStart = scrollY + rect.top;

            // Animation ends after scrolling through the section
            // Use the extra height (beyond 100vh) for the animation duration
            scrollEnd = scrollStart + (section.offsetHeight - window.innerHeight);
        }

        // Handle scroll events
        function onScroll() {
            if (!section || !container || !wrapper) return;

            const scrollY = window.scrollY;

            // Calculate progress through the animation (0 to 1)
            const rawProgress = (scrollY - scrollStart) / (scrollEnd - scrollStart);
            const progress = clamp(rawProgress, 0, 1);

            // Apply easing for smoother animation
            const easedProgress = easeInOutQuad(progress);

            // Update CSS custom property for scale progress on both wrapper and container
            wrapper.style.setProperty('--scale-progress', easedProgress);
            container.style.setProperty('--scale-progress', easedProgress);
        }

        // Easing function - smooth in and out
        function easeInOutQuad(x) {
            return x < 0.5 ? 2 * x * x : 1 - Math.pow(-2 * x + 2, 2) / 2;
        }

        // Initialize on DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initImageScale);
        } else {
            initImageScale();
        }
    };
    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_banner.default', ImageScaleHandler);
    });
})(jQuery);
