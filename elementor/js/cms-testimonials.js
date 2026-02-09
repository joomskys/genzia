(function ($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var MoveUpHandler = function ($scope, $) {
        // Configuration
        const config = {
            // Delay between each card starting (smaller = more overlap)
            cardDelay: 0.04,
            // Duration of each card's animation
            animationDuration: 0.15,
            // Viewport height buffer for exit
            exitBuffer: 200
        };

        // State
        let section = null;
        let cards = [];
        let scrollStart = 0;
        let scrollEnd = 0;

        // Utility: Clamp value between min and max
        function clamp(value, min, max) {
            return Math.min(Math.max(value, min), max);
        }

        // Initialize
        function initTestimonials() {
            section = document.querySelector('.cms-ettmn-section');
            cards = Array.from(document.querySelectorAll('.cms-item-scroll-up'));

            if (!section || cards.length === 0) return;

            // Calculate scroll points
            calculateScrollPoints();

            // Attach listeners
            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', () => {
                calculateScrollPoints();
                onScroll();
            });

            // Initial update
            onScroll();
        }

        // Calculate scroll trigger points
        function calculateScrollPoints() {
            if (!section) return;

            const rect = section.getBoundingClientRect();
            const scrollY = window.scrollY;
            const viewportHeight = window.innerHeight;

            // Start animation when 30% of the cards container is visible
            // This means we start earlier by offsetting the scroll start
            const earlyStartOffset = viewportHeight * 0.7; // Start when 30% visible (100% - 70%)

            scrollStart = scrollY + rect.top - earlyStartOffset;
            scrollEnd = scrollStart + (section.offsetHeight - viewportHeight) + earlyStartOffset;
        }

        // Handle scroll
        function onScroll() {
            if (!section || cards.length === 0) return;

            const scrollY = window.scrollY;
            const viewportHeight = window.innerHeight;

            // Calculate overall progress through section (0 to 1)
            const rawProgress = (scrollY - scrollStart) / (scrollEnd - scrollStart);
            const progress = clamp(rawProgress, 0, 1);

            const totalCards = cards.length;

            // Phase 1: Cards appear (first 50% of scroll) - RIGHT to LEFT order
            // Phase 2: Cards exit to top (last 50% of scroll) - RIGHT to LEFT order
            const appearPhaseEnd = 0.5;
            const exitPhaseStart = 0.5;

            cards.forEach((card, index) => {
                // REVERSE the index for right-to-left animation
                // Last card in DOM (rightmost) animates first
                const reverseIndex = totalCards - 1 - index;

                // Calculate when this card should appear (overlapping timing)
                // Each card starts shortly after the previous, creating a following effect
                const cardAppearStart = reverseIndex * config.cardDelay;
                const cardAppearEnd = cardAppearStart + config.animationDuration;

                // Calculate when this card should exit (overlapping timing)
                const cardExitStart = exitPhaseStart + (reverseIndex * config.cardDelay);
                const cardExitEnd = cardExitStart + config.animationDuration;

                let translateY;
                let opacity;

                if (progress < cardAppearStart) {
                    // Card hasn't appeared yet - below viewport
                    translateY = viewportHeight + 100;
                    opacity = 0;
                    card.classList.remove('visible', 'exiting');
                } else if (progress >= cardAppearStart && progress < cardAppearEnd) {
                    // Card is appearing - animate from bottom to position
                    const appearProgress = (progress - cardAppearStart) / (cardAppearEnd - cardAppearStart);
                    const easedProgress = easeOutCubic(appearProgress);

                    // Rest position at 0 (natural flexbox position)
                    translateY = (viewportHeight + 100) * (1 - easedProgress);
                    opacity = easedProgress;
                    card.classList.add('visible');
                    card.classList.remove('exiting');
                } else if (progress >= cardAppearEnd && progress < cardExitStart) {
                    // Card is in rest position
                    translateY = 0;
                    opacity = 1;
                    card.classList.add('visible');
                    card.classList.remove('exiting');
                } else if (progress >= cardExitStart && progress < cardExitEnd) {
                    // Card is exiting - animate to top
                    const exitProgress = (progress - cardExitStart) / (cardExitEnd - cardExitStart);
                    const easedProgress = easeInCubic(exitProgress);

                    translateY = -(config.exitBuffer + viewportHeight * 0.3) * easedProgress;
                    opacity = 1 - easedProgress;
                    card.classList.add('visible', 'exiting');
                } else {
                    // Card has exited - above viewport
                    translateY = -(config.exitBuffer + viewportHeight * 0.3);
                    opacity = 0;
                    card.classList.remove('visible');
                    card.classList.add('exiting');
                }

                // Apply transforms
                card.style.transform = `translateY(${translateY}px)`;
                card.style.opacity = opacity;
            });
        }

        // Easing functions
        function easeOutCubic(x) {
            return 1 - Math.pow(1 - x, 3);
        }

        function easeInCubic(x) {
            return x * x * x;
        }

        // Initialize on DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initTestimonials);
        } else {
            initTestimonials();
        }
    };
    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_testimonials.default', MoveUpHandler);
    });
})(jQuery);