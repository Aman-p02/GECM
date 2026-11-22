/**
 * GEC MODASA - ACTIVITIES HUB ENGINE
 * Multi-Image Carousel Slider, Scroll Lock Modal Controller, and Reveal Animations
 */
(function() {
    'use strict';

    // Active auto-slide timers keyed by slider ID
    const actSliderTimers = {};

    /**
     * Retrieve slider state and DOM elements
     */
    function getActSliderData(sliderId) {
        const wrap = document.getElementById(sliderId);
        if (!wrap) return null;

        const slides = wrap.querySelectorAll('.act-modal-slide');
        const dots = wrap.querySelectorAll('.act-slider-dot');
        const counter = document.getElementById('counter_' + sliderId);
        const count = slides.length;
        let activeIdx = 0;

        slides.forEach((slide, i) => {
            if (slide.classList.contains('is-active')) {
                activeIdx = i;
            }
        });

        return { wrap, slides, dots, counter, count, activeIdx };
    }

    /**
     * Jump to a specific slide index with Hardware-Accelerated Track Glide
     */
    window.goToActSlide = function(sliderId, targetIdx) {
        const data = getActSliderData(sliderId);
        if (!data || data.count <= 1) return;

        const nextIdx = (targetIdx + data.count) % data.count;

        // Move the flex track via GPU translate3d smoothly
        const slider = data.wrap.querySelector('.act-modal-slider');
        if (slider) {
            slider.style.transform = 'translate3d(-' + (nextIdx * 100) + '%, 0, 0)';
        }

        data.slides.forEach((slide, i) => {
            slide.classList.toggle('is-active', i === nextIdx);
        });

        // Update dots indicators
        data.dots.forEach((dot, i) => {
            dot.classList.toggle('is-active', i === nextIdx);
        });

        // Update counter badge
        if (data.counter) {
            data.counter.textContent = (nextIdx + 1) + ' / ' + data.count;
        }
    };

    /**
     * Advance to the next slide
     */
    window.nextActSlide = function(sliderId) {
        const data = getActSliderData(sliderId);
        if (!data || data.count <= 1) return;
        window.goToActSlide(sliderId, data.activeIdx + 1);
    };

    /**
     * Return to the previous slide
     */
    window.prevActSlide = function(sliderId) {
        const data = getActSliderData(sliderId);
        if (!data || data.count <= 1) return;
        window.goToActSlide(sliderId, data.activeIdx - 1);
    };

    /**
     * Start automatic slideshow (runs every 3.2 seconds for slow, smooth transitions)
     */
    window.startActSliderTimer = function(sliderId) {
        window.stopActSliderTimer(sliderId);
        const wrap = document.getElementById(sliderId);
        if (!wrap) return;

        const count = parseInt(wrap.getAttribute('data-slide-count') || '1', 10);
        if (count <= 1) return;

        actSliderTimers[sliderId] = setInterval(() => {
            window.nextActSlide(sliderId);
        }, 3200);
    };

    /**
     * Stop automatic slideshow
     */
    window.stopActSliderTimer = function(sliderId) {
        if (actSliderTimers[sliderId]) {
            clearInterval(actSliderTimers[sliderId]);
            delete actSliderTimers[sliderId];
        }
    };

    /**
     * Stop all running slider timers
     */
    window.stopAllActSliders = function() {
        Object.keys(actSliderTimers).forEach(id => {
            window.stopActSliderTimer(id);
        });
    };

    /**
     * Initialize event handlers on all sliders on the page
     */
    function initActSliders() {
        document.querySelectorAll('.act-modal-slider-wrap').forEach(wrap => {
            const sliderId = wrap.id;
            if (!sliderId) return;

            // Pause on mouse hover, resume on mouse leave (if modal is open)
            wrap.addEventListener('mouseenter', () => window.stopActSliderTimer(sliderId));
            wrap.addEventListener('mouseleave', () => {
                const modal = wrap.closest('.act-modal-backdrop');
                if (modal && (modal.classList.contains('is-active') || modal.classList.contains('is-open'))) {
                    window.startActSliderTimer(sliderId);
                }
            });

            // Touch gesture support (swipe left/right on mobile devices)
            let touchStartX = 0;
            let touchStartY = 0;

            wrap.addEventListener('touchstart', (e) => {
                touchStartX = e.touches[0].clientX;
                touchStartY = e.touches[0].clientY;
                window.stopActSliderTimer(sliderId);
            }, { passive: true });

            wrap.addEventListener('touchend', (e) => {
                const diffX = e.changedTouches[0].clientX - touchStartX;
                const diffY = e.changedTouches[0].clientY - touchStartY;

                if (Math.abs(diffX) > 40 && Math.abs(diffX) > Math.abs(diffY)) {
                    if (diffX < 0) {
                        window.nextActSlide(sliderId);
                    } else {
                        window.prevActSlide(sliderId);
                    }
                }

                const modal = wrap.closest('.act-modal-backdrop');
                if (modal && (modal.classList.contains('is-active') || modal.classList.contains('is-open'))) {
                    window.startActSliderTimer(sliderId);
                }
            }, { passive: true });
        });
    }

    /**
     * Body scroll locking utilities
     */
    function lockScroll() {
        document.documentElement.classList.add("act-modal-open");
        document.body.classList.add("act-modal-open");
        document.documentElement.style.overflow = "hidden";
        document.body.style.overflow = "hidden";
    }

    function unlockScroll() {
        document.documentElement.classList.remove("act-modal-open");
        document.body.classList.remove("act-modal-open");
        document.documentElement.style.overflow = "";
        document.body.style.overflow = "";
    }

    /**
     * Open Activity Detail Modal
     */
    window.openActModal = function(id) {
        const modal = document.getElementById(id);
        if (!modal) return;

        modal.classList.add('is-active', 'is-open');
        lockScroll();

        // Start auto-slide if modal contains a multi-image slider
        const sliderWrap = modal.querySelector('.act-modal-slider-wrap');
        if (sliderWrap && sliderWrap.id) {
            window.goToActSlide(sliderWrap.id, 0);
            window.startActSliderTimer(sliderWrap.id);
        }
    };

    /**
     * Close Activity Detail Modal
     */
    window.closeActModal = function(id) {
        const modal = document.getElementById(id);
        if (!modal) return;

        modal.classList.remove('is-active', 'is-open');

        // Stop auto-slide if modal contains a multi-image slider
        const slider = modal.querySelector('.act-modal-slider-wrap');
        if (slider && slider.id) {
            window.stopActSliderTimer(slider.id);
        }

        // Only unlock if no other modal is currently active
        const remainingOpen = document.querySelectorAll('.act-modal-backdrop.is-active, .act-modal-backdrop.is-open');
        if (remainingOpen.length === 0) {
            unlockScroll();
        }
    };

    /**
     * Close all open modals
     */
    window.closeAllActModals = function() {
        document.querySelectorAll('.act-modal-backdrop.is-active, .act-modal-backdrop.is-open').forEach(m => {
            m.classList.remove('is-active', 'is-open');
        });
        window.stopAllActSliders();
        unlockScroll();
    };

    /**
     * Close modal on backdrop click
     */
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('act-modal-backdrop')) {
            window.closeActModal(e.target.id);
        }
    });

    /**
     * Close modal on Escape key press
     */
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            window.closeAllActModals();
        }
    });

    /**
     * Scroll Reveal Animations System
     */
    const revealSelectors = [
        '.act-reveal',
        '.act-card',
        '.act-toolbar-strip',
        '.act-hero-inner'
    ];

    let revealObserver = null;
    if ('IntersectionObserver' in window) {
        revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            root: null,
            rootMargin: '0px 0px 30px 0px',
            threshold: 0.02
        });
    }

    window.setupActReveal = function(container = document) {
        if (!container) return;
        const elements = container.querySelectorAll(revealSelectors.join(', '));
        const viewportHeight = window.innerHeight || document.documentElement.clientHeight;

        elements.forEach(el => {
            if (el.classList.contains('act-card') && el.style.display === 'none') return;
            if (!el.classList.contains('act-reveal')) {
                el.classList.add('act-reveal');
            }
            const rect = el.getBoundingClientRect();
            if (rect.top < viewportHeight - 20 && rect.bottom > 0) {
                setTimeout(() => el.classList.add('is-revealed'), 60);
            } else if (revealObserver) {
                revealObserver.observe(el);
            } else {
                el.classList.add('is-revealed');
            }
        });
    };

    // Auto-initialize on DOM ready
    document.addEventListener('DOMContentLoaded', () => {
        initActSliders();
        window.setupActReveal(document);
    });

})();
