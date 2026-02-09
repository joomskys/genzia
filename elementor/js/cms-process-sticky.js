(function ($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var StackingCardHandler = function ($scope, $) {
        if ($scope.find('.stacking-cards').length === 0) {
            return;
        }
        // Initialize on DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                new StackingCards('.stacking-cards');
            });
        } else {
            new StackingCards('.stacking-cards');
        }
    };
    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_process.default', StackingCardHandler);
    });

    /**
 * Stacking Cards - Scroll-based UI Component
 * 
 * Cards stack from bottom as user scrolls:
 * - Initial state: All cards below viewport (invisible)
 * - Scrolling down: Cards slide up and stack progressively
 * - Scrolling up: Cards slide back down (fully reversible)
 * - Section is sticky while cards are animating
 * 
 * DOM Structure:
 * - stacking-cards-section (the section element)
 *   - stacking-cards-spacer (provides scroll height)
 *     - stacking-cards-wrapper (sticky container)
 *       - stacking-cards (contains all cards)
 */

    class StackingCards {
        constructor(containerSelector) {
            this.container = document.querySelector(containerSelector);
            if (!this.container) {
                console.error('Stacking Cards: Container not found');
                return;
            }

            this.section = this.container.closest('.stacking-cards-section');
            this.cards = Array.from(this.container.querySelectorAll('.stack-card'));
            this.cardCount = this.cards.length;

            this.scrollPerCard = window.innerHeight * 0.8; // Scroll distance per card
            this.stackOffset = 20; // Vertical offset between stacked cards

            // State
            this.currentProgress = 0;

            this.init();
        }

        init() {
            // Create the DOM structure
            this.createStructure();

            // Calculate dimensions
            this.updateDimensions();

            // Listen for scroll events
            this.boundScrollHandler = this.onScroll.bind(this);
            window.addEventListener('scroll', this.boundScrollHandler, { passive: true });

            // Handle resize
            window.addEventListener('resize', () => {
                this.updateDimensions();
            });

            // Initial update
            this.onScroll();
        }

        createStructure() {
            // Create spacer (provides scroll height for the animation)
            this.spacer = document.createElement('div');
            this.spacer.className = 'stacking-cards-spacer';

            // Create wrapper (sticky container)
            this.wrapper = document.createElement('div');
            this.wrapper.className = 'stacking-cards-wrapper';

            // Build structure: spacer > wrapper > container
            this.container.parentNode.insertBefore(this.spacer, this.container);
            this.spacer.appendChild(this.wrapper);
            this.wrapper.appendChild(this.container);

            // Style the spacer
            this.spacer.style.cssText = 'position: relative; width: 100%;';

            // Style the wrapper for sticky behavior
            this.wrapper.style.cssText = `
            position: sticky;
            top: 50%;
            width: 100%;
            height: 70vh;
            max-height:900px;
            display: flex;
            justify-content: center;
            align-items:center;
            overflow: visible;
            transform: translateY(-50%);
        `;

            // Style the container
            this.container.style.cssText = `
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
        `;
        }

        updateDimensions() {
            // Calculate card height
            const firstCard = this.cards[0];
            if (firstCard) {
                this.cardHeight = firstCard.offsetHeight || window.innerHeight * 0.6;
            }

            // Total scroll height = scroll distance for all cards
            const totalScrollHeight = (this.cardCount + 1) * this.scrollPerCard;
            this.spacer.style.height = `${totalScrollHeight + window.innerHeight}px`;
        }

        getSpacerOffsetTop() {
            let element = this.spacer;
            let offsetTop = 0;
            while (element) {
                offsetTop += element.offsetTop;
                element = element.offsetParent;
            }
            return offsetTop;
        }

        onScroll() {
            requestAnimationFrame(() => {
                const spacerTop = this.getSpacerOffsetTop();
                const scrollY = window.pageYOffset;
                const viewportHeight = window.innerHeight;

                // Calculate how far into the section we've scrolled
                const scrollIntoSection = scrollY - spacerTop;

                // Calculate overall progress (0 to cardCount)
                const totalProgress = scrollIntoSection / this.scrollPerCard;

                // Update each card based on progress
                this.updateCards(totalProgress);
            });
        }

        updateCards(totalProgress) {
            this.cards.forEach((card, index) => {
                // Calculate this card's individual progress (0 to 2)
                // 0-1: translateY animation (slide up)
                // 1-2: rotation animation (after card is in position)
                const cardProgress = Math.max(0, Math.min(2, totalProgress - index));

                // Apply transforms
                this.transformCard(card, index, cardProgress, totalProgress);
            });
        }

        transformCard(card, index, cardProgress, totalProgress) {
            // Two-phase animation:
            // Phase 1 (progress 0-1): Card slides up from below viewport to translateY(0)
            // Phase 2 (progress 1-2): Card rotates from 0 to target rotation

            if (cardProgress <= 0) {
                // Card hasn't started animating - keep it below viewport
                card.style.transform = 'translateY(120vh) rotate(0deg)';
                card.style.zIndex = index;
                return;
            }

            // Phase 1: TranslateY animation (progress 0 to 1)
            const translateProgress = Math.min(1, cardProgress);
            const easedTranslate = this.easeOutCubic(translateProgress);

            const startY = window.innerHeight * 1.2;
            const currentY = startY * (1 - easedTranslate);

            // Phase 2: Rotation animation (progress 1 to 2)
            const rotateProgress = Math.max(0, Math.min(1, cardProgress - 1));
            const easedRotate = this.easeOutCubic(rotateProgress);

            // Target rotation based on card index (each card has unique final rotation)
            // const targetRotation = (index + 1) * -1.5; // Card 0: -1.5°, Card 1: -3°, Card 2: -4.5°, etc.
            const targetRotation = index % 2 === 0 ? -5 : 5; // Card 0: -1.5°, Card 1: +1.5°, Card 2: -4.5°, etc.
            const currentRotation = targetRotation * easedRotate;

            // Apply transforms
            card.style.transform = `
            translateY(${currentY}px)
            rotate(${currentRotation}deg)
        `;

            // Z-index: cards currently animating (phase 1) should be on top
            const isSliding = cardProgress > 0 && cardProgress < 1;
            card.style.zIndex = isSliding ? 100 + index : index;
        }

        easeOutCubic(t) {
            return 1 - Math.pow(1 - t, 3);
        }

        easeInOutCubic(t) {
            return t < 0.5
                ? 4 * t * t * t
                : 1 - Math.pow(-2 * t + 2, 3) / 2;
        }

        destroy() {
            window.removeEventListener('scroll', this.boundScrollHandler);

            // Restore original DOM structure
            if (this.spacer && this.spacer.parentNode) {
                this.spacer.parentNode.insertBefore(this.container, this.spacer);
                this.spacer.parentNode.removeChild(this.spacer);
            }
        }
    }
})(jQuery);