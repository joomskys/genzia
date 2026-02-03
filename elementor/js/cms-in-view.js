(function ($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var InViewHandler = function ($scope, $) {
        let items = [];

        function init() {
            items = Array.from(document.querySelectorAll('[data-observed="true"]'));

            if (items.length === 0) return;

            items.forEach(item => {
                const options = {
                    root: null, // viewport
                    rootMargin: '0px',
                    threshold: item.getAttribute('data-threshold') || 0.3 // Trigger when 30% of the element is visible
                };

                let observer = new IntersectionObserver(handleIntersection, options);
                observer.observe(item);
            });
        }

        // Handle intersection changes
        function handleIntersection(entries) {
            entries.forEach(entry => {
                const item = entry.target;

                if (entry.isIntersecting) {
                    item.classList.add('in-view');
                } else {
                    item.classList.remove('in-view');
                }
            });
        }

        // Initialize on DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    };
    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_posts_grid.default', InViewHandler);
    });
})(jQuery);