(function ($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var StackingAccordionHandler = function ($scope, $) {
        // // Initialize on DOM ready
        // if (document.readyState === 'loading') {
        //     document.addEventListener('DOMContentLoaded', () => {
        //         new StackingAccordion('.stacking-accordion');
        //     });
        // } else {
        //     new StackingAccordion('.stacking-accordion');
        // }
        if ($scope.find('.stacking-accordion').length === 0) {
            return;
        }
        new StackingAccordion('.stacking-accordion');
    };
    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/cms_accordion.default', StackingAccordionHandler);
    });

    /**
     * Stacking Accordion - Scroll-based UI Component
     * 
     * A scroll-driven accordion where:
     * - Only one item is active (fully expanded) at a time
     * - Content height transitions are driven by scroll position, not time
     * - The component becomes sticky when it reaches the viewport top
     * - At the end, it sticks to the bottom of the spacer
     * - Scrolling controls which item is expanded
     * - Fully reversible scroll interaction
     * 
     * DOM Structure:
     * - stacking-accordion-spacer (outermost, provides total scroll height)
     *   - stacking-accordion-wrapper (maintains accordion's natural height)
     *     - stacking-accordion (the actual accordion, becomes sticky)
     */

    class StackingAccordion {
        constructor(containerSelector) {
            this.container = document.querySelector(containerSelector);
            if (!this.container) {
                console.error('Stacking Accordion: Container not found');
                return;
            }

            this.items = Array.from(this.container.querySelectorAll('.stacking-accordion-item'));
            this.itemCount = this.items.length;

            // Configuration
            this.scrollPerItem = window.innerHeight * 0.8; // Scroll distance to transition between items
            this.contentHeights = []; // Store natural content heights

            // State
            this.currentProgress = 0; // 0 to itemCount - 1
            // this.stickyPosition = 'top'; // 'top' or 'bottom'

            this.init();
        }

        init() {
            // Create the DOM structure: spacer > wrapper > container
            this.createStructure();

            // Measure natural content heights
            this.measureContentHeights();

            // Set initial state - first item active
            this.setProgress(0);

            // Update heights after initial setup
            this.updateHeights();

            // Listen for scroll events
            this.boundScrollHandler = this.onScroll.bind(this);
            window.addEventListener('scroll', this.boundScrollHandler, { passive: true });

            // Handle resize
            window.addEventListener('resize', () => {
                this.measureContentHeights();
                this.updateHeights();
            });

            // Initial update
            this.onScroll();
        }

        createStructure() {
            // Create spacer (outermost container that provides scroll height)
            this.spacer = document.createElement('div');
            this.spacer.className = 'stacking-accordion-spacer';

            // Create wrapper (maintains accordion's natural height position)
            this.wrapper = document.createElement('div');
            this.wrapper.className = 'stacking-accordion-wrapper';

            // Build the structure: spacer > wrapper > container
            this.container.parentNode.insertBefore(this.spacer, this.container);
            this.spacer.appendChild(this.wrapper);
            this.wrapper.appendChild(this.container);
        }

        updateHeights() {
            // Get accordion's natural height
            const accordionHeight = this.container.offsetHeight;

            // Set wrapper height to match accordion
            this.wrapper.style.height = `${accordionHeight}px`;

            // Spacer height = wrapper height + scroll distance for all transitions
            const scrollRange = (this.itemCount - 1) * this.scrollPerItem;
            const totalSpacerHeight = accordionHeight + scrollRange;
            this.spacer.style.height = `${totalSpacerHeight}px`;
        }

        measureContentHeights() {
            this.contentHeights = [];

            this.items.forEach((item, index) => {
                const content = item.querySelector('.stacking-accordion-content');

                // Temporarily expand to measure
                const originalMaxHeight = content.style.maxHeight;
                const originalOpacity = content.style.opacity;
                // const originalPadding = content.style.padding;

                content.style.maxHeight = 'none';
                content.style.opacity = '1';
                // content.style.padding = '0 0 40px 0';
                content.style.overflow = 'visible';

                this.contentHeights[index] = content.scrollHeight;

                // Restore
                content.style.maxHeight = originalMaxHeight;
                content.style.opacity = originalOpacity;
                // content.style.padding = originalPadding;
                content.style.overflow = 'hidden';
            });
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
                const spacerRect = this.spacer.getBoundingClientRect();
                const spacerTop = this.getSpacerOffsetTop();
                const scrollY = window.pageYOffset;
                const viewportHeight = window.innerHeight;
                const accordionHeight = this.container.offsetHeight;

                // Calculate scroll progress within the spacer
                const scrollIntoSpacer = scrollY - spacerTop;
                const scrollRange = (this.itemCount - 1) * this.scrollPerItem;

                // Determine if we're in the sticky range
                const isInStickyRange = spacerRect.top <= 0 && spacerRect.bottom >= accordionHeight;

                if (isInStickyRange) {
                    // Calculate progress based on how far we've scrolled into the spacer
                    const rawProgress = scrollIntoSpacer / this.scrollPerItem;
                    const clampedProgress = Math.max(0, Math.min(this.itemCount - 1, rawProgress));
                    this.setProgress(clampedProgress);

                    // // Determine sticky position
                    // // When spacer bottom is close to viewport bottom, stick to bottom
                    // if (spacerRect.bottom <= viewportHeight) {
                    //     if (this.stickyPosition !== 'bottom') {
                    //         this.stickyPosition = 'bottom';
                    //         this.container.classList.remove('is-sticky-top');
                    //         this.container.classList.add('is-sticky-bottom');
                    //     }
                    // } else {
                    //     if (this.stickyPosition !== 'top') {
                    //         this.stickyPosition = 'top';
                    //         this.container.classList.remove('is-sticky-bottom');
                    //         this.container.classList.add('is-sticky-top');
                    //     }
                    // }
                } else {
                    // // Not in sticky range
                    // this.container.classList.remove('is-sticky-top', 'is-sticky-bottom');
                    // this.stickyPosition = null;

                    // Set progress based on position
                    if (spacerRect.top > 0) {
                        // Above the spacer - show first item
                        this.setProgress(0);
                    } else {
                        // Below the spacer - show last item
                        this.setProgress(this.itemCount - 1);
                    }
                }
            });
        }

        setProgress(progress) {
            this.currentProgress = progress;

            const currentIndex = Math.floor(progress);
            const nextIndex = Math.min(currentIndex + 1, this.itemCount - 1);
            const transitionProgress = progress - currentIndex; // 0 to 1 within each transition

            this.items.forEach((item, index) => {
                const content = item.querySelector('.stacking-accordion-content');
                const naturalHeight = this.contentHeights[index] || 0;

                let heightPercent = 0;
                let opacity = 0;
                let isActive = false;

                if (index < currentIndex) {
                    // Items before current: fully collapsed
                    heightPercent = 0;
                    opacity = 0;
                    isActive = false;
                } else if (index === currentIndex) {
                    if (currentIndex === nextIndex) {
                        // Last item - fully expanded
                        heightPercent = 1;
                        opacity = 1;
                        isActive = true;
                    } else {
                        // Current item transitioning out
                        heightPercent = 1 - transitionProgress;
                        opacity = 1 - transitionProgress;
                        isActive = transitionProgress < 0.5;
                    }
                } else if (index === nextIndex) {
                    // Next item transitioning in
                    heightPercent = transitionProgress;
                    opacity = transitionProgress;
                    isActive = transitionProgress >= 0.5;
                } else {
                    // Items after next: fully collapsed
                    heightPercent = 0;
                    opacity = 0;
                    isActive = false;
                }

                // Apply styles directly for smooth scroll-driven animation
                const targetHeight = naturalHeight * heightPercent;
                content.style.maxHeight = `${targetHeight}px`;
                content.style.opacity = opacity;
                // content.style.padding = heightPercent > 0 ? `0 0 ${40 * heightPercent}px 0` : '0';

                // Update active class for header styling
                if (isActive) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }

                // Update title opacity based on how "active" the item is
                const title = item.querySelector('.stacking-accordion-title');
                // const indicator = item.querySelector('.stacking-accordion-indicator');

                if (index === currentIndex || index === nextIndex) {
                    // Items involved in transition
                    let titleOpacity;
                    if (index === currentIndex && currentIndex !== nextIndex) {
                        titleOpacity = 0.4 + 0.6 * (1 - transitionProgress);
                    } else if (index === nextIndex) {
                        titleOpacity = 0.4 + 0.6 * transitionProgress;
                    } else {
                        titleOpacity = 1;
                    }
                    title.style.opacity = titleOpacity;
                    // indicator.style.opacity = titleOpacity;
                } else {
                    title.style.opacity = '0.4';
                    // indicator.style.opacity = '0.4';
                }
            });
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