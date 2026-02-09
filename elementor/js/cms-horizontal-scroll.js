(function ($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var HorizontalScrollHandler = function ($scope, $) {
        if ($scope.find('.horizontal-scroll').length === 0) {
            return;
        }
        new HorizontalScroll('.horizontal-scroll');
    };
    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_teams.default', HorizontalScrollHandler);
    });

    /**
     * Horizontal Scroll - Scroll-based UI Component
     * 
     * Vertical scroll triggers horizontal movement:
     * - Section becomes sticky when reaching viewport top
     * - Cards start positioned to the right (showing first 4)
     * - Scroll moves cards left until last 4 are shown
     * - Fully reversible when scrolling up
     */

    class HorizontalScroll {
        constructor(sectionSelector) {
            this.section = document.querySelector(sectionSelector);
            if (!this.section) {
                console.error('Horizontal Scroll: Section not found');
                return;
            }

            this.track = this.section.querySelector('.cards-track');

            if (!this.track) {
                console.error('Horizontal Scroll: Required elements not found');
                return;
            }

            // Get all cards
            this.cards = this.track.querySelectorAll('.team-card');
            this.cardCount = this.cards.length;
            this.visibleCards = 4; // Number of cards visible at once

            this.init();
        }

        init() {
            // Create the spacer structure for sticky behavior
            this.createStructure();

            // Calculate dimensions
            this.updateDimensions();

            // Listen for scroll events
            this.boundScrollHandler = this.onScroll.bind(this);
            window.addEventListener('scroll', this.boundScrollHandler, { passive: true });

            // Handle resize
            window.addEventListener('resize', () => {
                this.updateDimensions();
                this.onScroll();
            });

            // Initial update
            this.onScroll();
        }

        createStructure() {
            // Create spacer to provide scroll height
            this.spacer = document.createElement('div');
            this.spacer.className = 'horizontal-scroll-spacer';

            // Create sticky wrapper
            this.wrapper = document.createElement('div');
            this.wrapper.className = 'horizontal-scroll-wrapper';

            // Get all children of the section
            const children = Array.from(this.section.children);

            // Insert spacer at the beginning of section
            this.section.insertBefore(this.spacer, this.section.firstChild);

            // Move all children into wrapper, then wrapper into spacer
            children.forEach(child => {
                this.wrapper.appendChild(child);
            });
            this.spacer.appendChild(this.wrapper);
        }

        updateDimensions() {
            // Calculate single card width with gap
            if (this.cards.length > 0) {
                const cardWidth = this.cards[0].offsetWidth;
                const gap = parseInt(window.getComputedStyle(this.track).gap) || 20;
                this.cardTotalWidth = cardWidth + gap;
            }

            // Calculate initial offset to right-align first 4 cards in viewport
            const viewportWidth = window.innerWidth;
            const visibleCardsWidth = this.visibleCards * this.cardTotalWidth - 20; // Subtract last gap
            // Position so last visible card's right edge aligns with viewport right edge
            this.initialOffset = viewportWidth - visibleCardsWidth;

            // Calculate end offset: -(totalListWidth - last4ItemsWidth)
            // Only last 4 items visible at the end, so the rest is off-screen to the left
            const totalTrackWidth = this.track.scrollWidth;
            const last4Width = visibleCardsWidth;
            this.endOffset = -(totalTrackWidth - last4Width);

            // Calculate horizontal distance for interpolation
            this.horizontalDistance = this.initialOffset - this.endOffset;

            // Get the wrapper's natural height
            const wrapperHeight = this.wrapper.offsetHeight;

            // Set spacer height = wrapper height + horizontal distance for scroll range
            const spacerHeight = wrapperHeight + this.horizontalDistance;
            this.spacer.style.height = `${spacerHeight}px`;

            // Set wrapper to sticky
            this.wrapper.style.cssText = `
            position: sticky;
            top: 60px;
            width: 100%;
            background-color: #f5f5f5;
        `;
        }

        getSectionOffsetTop() {
            let element = this.section;
            let offsetTop = 0;
            while (element) {
                offsetTop += element.offsetTop;
                element = element.offsetParent;
            }
            return offsetTop;
        }

        onScroll() {
            requestAnimationFrame(() => {
                const sectionTop = this.getSectionOffsetTop();
                const scrollY = window.pageYOffset;

                // Calculate how far into the section we've scrolled
                const scrollIntoSection = scrollY - sectionTop;

                // Calculate progress (0 to 1) based on horizontal distance
                const progress = Math.max(0, Math.min(1, scrollIntoSection / this.horizontalDistance));

                // Apply horizontal translation
                this.updateTrackPosition(progress);
            });
        }

        updateTrackPosition(progress) {
            // Progress 0: First 4 cards visible (translateX = initialOffset)
            // Progress 1: Last 4 cards visible (translateX = endOffset)
            // Linear interpolation between initial and end offsets
            const translateX = this.initialOffset - (progress * this.horizontalDistance);

            // Apply transform
            this.track.style.transform = `translateX(${translateX}px)`;
        }

        destroy() {
            window.removeEventListener('scroll', this.boundScrollHandler);

            // Restore original DOM structure
            if (this.wrapper && this.spacer) {
                const children = Array.from(this.wrapper.children);
                children.forEach(child => {
                    this.section.appendChild(child);
                });
                this.spacer.parentNode.removeChild(this.spacer);
            }

            // Reset track transform
            this.track.style.transform = '';
        }
    }
})(jQuery);