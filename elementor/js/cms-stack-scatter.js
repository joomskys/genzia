(function ($) {
    'use strict';

    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var StackScatterHandler = function ($scope, $) {
        // Configuration
        const config = {
            pinDuration: 500, // Scroll distance (vh) for the pinned animation
            animationEasing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
            transitionDuration: 400 // ms
        };

        // State
        let container = null;
        let cards = [];
        let scrollStart = 0;
        let scrollEnd = 0;
        let originalRotations = [];
        let cards_first = $scope.find('.stack-scatter-card-first');
        cards_first.parent().css('height',cards_first.outerHeight());
        
        // Utility: Linear interpolation
        function lerp(start, end, progress) {
            return start + (end - start) * progress;
        }

        // Utility: Clamp value between min and max
        function clamp(value, min, max) {
            return Math.min(Math.max(value, min), max);
        }

        // Get the original CSS rotation of a card
        function getRotation(index) {
            const rotations = [-6, 5, 9, 2, -11]; // Matches CSS
            return rotations[index] || 0;
        }

        // Initialize the stack scatter animation
        function initStackScatter() {
            container = document.querySelector('.stack-scatter--inner');
            cards = Array.from(document.querySelectorAll('.stack-scatter-card'));

            if (!container || cards.length === 0) return;

            // Store original rotations
            originalRotations = cards.map((_, i) => getRotation(i));

            // Set initial card styles for animation
            cards.forEach((card, i) => {
                card.style.transition = `transform ${config.transitionDuration}ms ${config.animationEasing}, 
                                     box-shadow ${config.transitionDuration}ms ease`;
                card.dataset.index = i;
                card.dataset.originalRotation = originalRotations[i];
            });

            // Calculate scroll trigger points
            calculateScrollPoints();

            // Attach scroll listener
            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', calculateScrollPoints);

            // Initial update
            onScroll();
        }

        // Calculate where pinning starts and ends
        function calculateScrollPoints() {
            if (!container) return;

            const rect = container.getBoundingClientRect();
            const scrollY = window.scrollY;

            // Animation starts when container top reaches viewport top
            scrollStart = scrollY + rect.top;

            // Animation ends after scrolling through all cards (one viewport height per card)
            scrollEnd = scrollStart + (cards.length * window.innerHeight);
        }

        // Handle scroll events
        function onScroll() {
            if (!container || cards.length === 0) return;

            const scrollY = window.scrollY;

            // Calculate progress through the animation (0 to 1)
            const rawProgress = (scrollY - scrollStart) / (scrollEnd - scrollStart);
            const progress = clamp(rawProgress, 0, 1);

            // Check if we're in the active scroll zone
            const isInZone = scrollY >= scrollStart && scrollY <= scrollEnd;

            // Handle pinning effect via CSS sticky (already handled in CSS)
            // Update each card based on scroll progress
            updateCards(progress);
        }

        // Update card transforms based on scroll progress
        function updateCards(progress) {
            const totalCards = cards.length;
            const progressPerCard = 1 / totalCards;
            const viewportHeight = window.innerHeight;

            cards.forEach((card, i) => {
                // Calculate when this card should animate
                const cardStartProgress = i * progressPerCard;

                // Calculate this card's individual progress (0 to 1)
                const cardProgress = clamp((progress - cardStartProgress) / progressPerCard, 0, 1);

                // Get original rotation
                const originalRotation = originalRotations[i];

                // Direct scroll-linked animation:
                // - Scroll DOWN → card moves UP and exits off the TOP of the screen
                // - Scroll UP → card comes back DOWN from above to original position

                let currentRotation;
                let currentScale;
                let currentZIndex;
                let translateY = 0;
                let opacity = 1;

                if (cardProgress === 0) {
                    // Card at original scattered position
                    currentRotation = originalRotation;
                    currentScale = 1;
                    currentZIndex = totalCards - i;
                    translateY = 0;
                    opacity = 1;
                } else {
                    // Card moves UP as you scroll DOWN
                    // At cardProgress = 1, card is fully off the top of the screen

                    // Move up: 0 → -(viewportHeight + card height buffer)
                    // This ensures the card exits completely off the top
                    translateY = lerp(0, -(viewportHeight + 400), cardProgress);

                    // Rotation flattens as it moves up
                    currentRotation = lerp(originalRotation, 0, Math.min(cardProgress * 2, 1));

                    // Scale slightly increases then decreases
                    if (cardProgress < 0.3) {
                        currentScale = lerp(1, 1.02, cardProgress / 0.3);
                    } else {
                        currentScale = lerp(1.02, 0.95, (cardProgress - 0.3) / 0.7);
                    }

                    // Fade out as it approaches the top
                    opacity = cardProgress < 0.7 ? 1 : lerp(1, 0, (cardProgress - 0.7) / 0.3);

                    // Bring to front while animating
                    currentZIndex = 10 + i;
                }

                // Apply transforms
                card.style.transform = `translateY(${translateY}px) rotate(${currentRotation}deg) scale(${currentScale})`;
                card.style.zIndex = currentZIndex;
                card.style.opacity = opacity;
            });
        }

        // Initialize on DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                initStackScatter();
            });
        } else {
            initStackScatter();
        }
    };
    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_accordion.default', StackScatterHandler);
    });
})(jQuery);
