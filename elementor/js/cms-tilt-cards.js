(function ($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var TiltCardsHandler = function ($scope, $) {
        if ($scope.find('.tilt-card').length === 0) {
            return;
        }

        // Configuration
        const CONFIG = {
            maxTiltAngle: 20,        // Maximum rotation angle in degrees
            perspective: 1200,       // CSS perspective value in pixels
            smoothingFactor: 0.1,    // Lower = smoother but slower response
            deadZone: 0.05,          // Percentage of viewport as dead zone at center
            throttleMs: 16           // ~60fps throttle for scroll events
        };

        // State
        let cards = [];
        let viewportHeight = window.innerHeight;
        let viewportCenter = viewportHeight / 2;
        let ticking = false;
        let currentTilts = new Map(); // Store current tilt values for smoothing

        /**
         * Initialize the tilt cards effect
         */
        function init() {
            cards = document.querySelectorAll('.tilt-card');

            if (cards.length === 0) {
                console.warn('TiltCards: No cards found with class .tilt-card');
                return;
            }

            // Initialize current tilts map
            cards.forEach(card => {
                currentTilts.set(card, 0);
            });

            // Update viewport dimensions
            updateViewportDimensions();

            // Bind events
            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', onResize, { passive: true });

            // Initial calculation
            requestAnimationFrame(updateAllCards);

            console.log(`TiltCards: Initialized with ${cards.length} cards`);
        }

        /**
         * Update viewport dimensions
         */
        function updateViewportDimensions() {
            viewportHeight = window.innerHeight;
            viewportCenter = viewportHeight / 2;
        }

        /**
         * Handle scroll events with throttling
         */
        function onScroll() {
            if (!ticking) {
                requestAnimationFrame(() => {
                    updateAllCards();
                    ticking = false;
                });
                ticking = true;
            }
        }

        /**
         * Handle resize events
         */
        function onResize() {
            updateViewportDimensions();
            updateAllCards();
        }

        /**
         * Calculate the tilt angle for a card based on its position
         * @param {HTMLElement} card - The card element
         * @returns {number} - The tilt angle in degrees
         */
        function calculateTiltAngle(card) {
            const rect = card.getBoundingClientRect();
            const cardCenter = rect.top + (rect.height / 2);

            // Calculate distance from viewport center
            // Negative when card is above center, positive when below
            const distanceFromCenter = cardCenter - viewportCenter;

            // Normalize to a range of -1 to 1
            // Using viewport height as the reference for full tilt range
            const normalizedDistance = distanceFromCenter / (viewportHeight / 2);

            // Apply dead zone at center for a stable flat position
            const deadZoneApplied = applyDeadZone(normalizedDistance, CONFIG.deadZone);

            // Clamp the value to prevent extreme angles
            const clampedDistance = Math.max(-1, Math.min(1, deadZoneApplied));

            // Calculate tilt angle
            // When card is below center (positive distance): negative angle (tilted back)
            // When card is above center (negative distance): positive angle (tilted forward)
            const tiltAngle = -clampedDistance * CONFIG.maxTiltAngle;

            return tiltAngle;
        }

        /**
         * Apply a dead zone to create a stable neutral position at center
         * @param {number} value - The normalized distance value
         * @param {number} deadZone - The size of the dead zone (0-1)
         * @returns {number} - The adjusted value
         */
        function applyDeadZone(value, deadZone) {
            if (Math.abs(value) < deadZone) {
                return 0;
            }

            // Smoothly remap the value outside the dead zone
            const sign = value > 0 ? 1 : -1;
            const adjustedValue = (Math.abs(value) - deadZone) / (1 - deadZone);

            return sign * adjustedValue;
        }

        /**
         * Smoothly interpolate between current and target tilt values
         * @param {number} current - Current tilt angle
         * @param {number} target - Target tilt angle
         * @param {number} factor - Smoothing factor (0-1)
         * @returns {number} - Interpolated tilt angle
         */
        function smoothTilt(current, target, factor) {
            // Use linear interpolation for smooth transitions
            return current + (target - factor) * factor;
        }

        /**
         * Update all cards with their tilt values
         */
        function updateAllCards() {
            cards.forEach(card => {
                const cardInner = card.querySelector('.tilt-card-inner');
                if (!cardInner) return;

                const targetTilt = calculateTiltAngle(card);
                const currentTilt = currentTilts.get(card) || 0;

                // Apply smoothing for fluid motion
                // Using a simple approach: directly use calculated value for immediate response
                const newTilt = targetTilt;

                // Store the new tilt value
                currentTilts.set(card, newTilt);

                // Apply the transform
                applyTilt(cardInner, newTilt);
            });
        }

        /**
         * Apply the tilt transform to a card
         * @param {HTMLElement} element - The card inner element
         * @param {number} angle - The rotation angle in degrees
         */
        function applyTilt(element, angle) {
            // Combine perspective and rotateX for 3D effect
            // perspective() must come before rotateX() for proper 3D rendering
            const transform = `perspective(${CONFIG.perspective}px) rotateX(${angle.toFixed(2)}deg)`;
            element.style.transform = transform;
        }

        /**
         * Clean up event listeners
         */
        function destroy() {
            window.removeEventListener('scroll', onScroll);
            window.removeEventListener('resize', onResize);

            // Reset all cards
            cards.forEach(card => {
                const cardInner = card.querySelector('.tilt-card-inner');
                if (cardInner) {
                    cardInner.style.transform = '';
                }
            });

            currentTilts.clear();
            cards = [];
        }

        // Expose public API
        window.TiltCards = {
            init,
            destroy,
            refresh: updateAllCards
        };

        // Auto-initialize on DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    };
    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_posts_grid.default', TiltCardsHandler);
    });
})(jQuery);