/* ==============================================================
   GECM Department Detail Page Interactions
   - Scroll-triggered reveal loading for department elements
   - Smooth, slow, and graceful scrolling behavior
   - Tabs navigation, dynamic heading updates, and facility sub-tabs
   ============================================================== */

document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.dept-nav-link');
    const tabPanes = document.querySelectorAll('.dept-tab-content');
    const pageTitle = document.getElementById('deptPageTitle');

    // Title map for clean presentation
    const titleMap = {
        'about': 'About Department',
        'vision-mission': 'Vision and Mission',
        'syllabus': 'Syllabus',
        'faculty': 'Faculty',
        'activities': 'Activities',
        'facilities': 'Facilities',
        'publications': 'Publications',
        'advisory-board': 'Industry Advisory Board',
        'newsletters': 'News Letters'
    };

    /* ==========================================================
       1. Custom Smooth Slow Scroll Function (Easing Curve)
       ========================================================== */
    function smoothSlowScrollTo(targetY, duration = 850) {
        const startY = window.pageYOffset;
        const diff = targetY - startY;
        let startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            const elapsed = timestamp - startTime;
            const progress = Math.min(elapsed / duration, 1);
            // Ease-in-out cubic curve: slow start, graceful glide, gentle deceleration
            const ease = progress < 0.5
                ? 4 * progress * progress * progress
                : 1 - Math.pow(-2 * progress + 2, 3) / 2;

            window.scrollTo(0, startY + (diff * ease));

            if (progress < 1) {
                requestAnimationFrame(step);
            }
        }
        requestAnimationFrame(step);
    }

    /* ==========================================================
       2. Smooth Slow Mouse Wheel Scroll Enhancer
       ========================================================== */
    let isWheeling = false;
    let targetScrollY = window.pageYOffset;

    window.addEventListener('scroll', function () {
        if (!isWheeling) {
            targetScrollY = window.pageYOffset;
        }
    }, { passive: true });

    window.addEventListener('wheel', function (e) {
        // Allow default zoom / special keys
        if (e.ctrlKey || e.altKey) return;

        const delta = e.deltaY;
        const maxScroll = Math.max(0, document.documentElement.scrollHeight - window.innerHeight);

        // Slow down step multiplier (0.75 gives controlled, slow motion)
        targetScrollY = Math.max(0, Math.min(targetScrollY + delta * 0.75, maxScroll));

        if (!isWheeling) {
            isWheeling = true;
            runSmoothWheel();
        }
        e.preventDefault();
    }, { passive: false });

    function runSmoothWheel() {
        const currentY = window.pageYOffset;
        const diff = targetScrollY - currentY;

        if (Math.abs(diff) < 0.6) {
            window.scrollTo(0, targetScrollY);
            isWheeling = false;
            return;
        }

        // 0.085 interpolation factor gives a luxurious, slow, silky glide
        window.scrollTo(0, currentY + diff * 0.085);
        requestAnimationFrame(runSmoothWheel);
    }

    /* ==========================================================
       3. Scroll-Triggered Reveal Animation (Load on Scroll)
       ========================================================== */
    const revealSelectors = [
        '.dept-divider-title',
        '.dept-text-body',
        '.courses-card',
        '.peo-card',
        '.vision-quote-box',
        '.mission-bullet-list',
        '.faculty-simple-card',
        '.lab-simple-item',
        '.modern-lab-card',
        '.facility-tabs-container',
        '.facility-lead-intro'
    ].join(', ');

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
            rootMargin: '0px 0px -40px 0px', // trigger smoothly as user scrolls towards element
            threshold: 0.08
        });
    }

    function initScrollReveal(scope = document) {
        const elements = scope.querySelectorAll(revealSelectors);
        elements.forEach((el, index) => {
            if (!el.classList.contains('dept-scroll-reveal')) {
                el.classList.add('dept-scroll-reveal');
            }
            if (revealObserver) {
                // If element is already in the viewport right now, reveal it with slight stagger
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight - 30) {
                    setTimeout(() => {
                        el.classList.add('is-revealed');
                    }, Math.min(index * 60, 300));
                } else {
                    revealObserver.observe(el);
                }
            } else {
                el.classList.add('is-revealed');
            }
        });
    }

    /* ==========================================================
       4. Tab Activation & Navigation
       ========================================================== */
    function activateTab(tabId, shouldScroll = false) {
        if (!tabId) return;

        // Clean tabId (remove leading #)
        tabId = tabId.replace('#', '');

        const targetPane = document.getElementById('tab-' + tabId);
        const targetLink = document.querySelector(`.dept-nav-link[data-tab="${tabId}"]`);

        if (!targetPane || !targetLink) return;

        // Remove active class from all links and tabs
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.parentElement) {
                link.parentElement.classList.remove('active');
            }
        });

        tabPanes.forEach(pane => pane.classList.remove('active'));

        // Activate target link and pane
        targetLink.classList.add('active');
        if (targetLink.parentElement) {
            targetLink.parentElement.classList.add('active');
        }
        targetPane.classList.add('active');

        // Update Top Page Heading dynamically matching screenshots
        if (pageTitle && titleMap[tabId]) {
            pageTitle.textContent = titleMap[tabId];
        }

        // Initialize scroll reveal on newly activated pane
        setTimeout(() => {
            initScrollReveal(targetPane);
        }, 50);

        // On mobile / small screens, center the active pill in the horizontal nav
        if (window.innerWidth <= 768 && targetLink) {
            try {
                targetLink.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            } catch (err) {
                // fallback
            }
        }

        // Smooth slow scroll to content top if triggered by user click on mobile
        if (shouldScroll && window.innerWidth <= 768) {
            const contentPanel = document.querySelector('.dept-content-panel');
            if (contentPanel) {
                const stickyNav = document.querySelector('.dept-sidebar');
                const navHeight = stickyNav ? stickyNav.offsetHeight : 50;
                const targetY = contentPanel.getBoundingClientRect().top + window.pageYOffset - navHeight - 10;
                smoothSlowScrollTo(Math.max(0, targetY), 800);
            }
        }
    }

    // Attach click listeners to sidebar links
    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            const tabId = this.getAttribute('data-tab');
            if (tabId) {
                e.preventDefault();
                if (history.pushState) {
                    history.pushState(null, null, '#' + tabId);
                } else {
                    window.location.hash = tabId;
                }
                activateTab(tabId, true);
            }
            // Links without data-tab (like Syllabus) naturally open their href in new tab
        });
    });

    // Handle Hash changes & initial load
    function checkHash() {
        const hash = window.location.hash.substring(1);
        if (hash === 'syllabus') {
            window.location.href = 'https://syllabus.gtu.ac.in/';
            return;
        }
        if (hash && document.getElementById('tab-' + hash)) {
            activateTab(hash, false);
        } else {
            activateTab('about', false);
        }
    }

    /* ==========================================================
       5. Facilities Segmented Sub-tabs Handler
       ========================================================== */
    const facilityTabBtns = document.querySelectorAll('.facility-tab-btn');
    const facilityPanes = document.querySelectorAll('.facility-pane');

    facilityTabBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const subtabKey = this.getAttribute('data-subtab');
            if (!subtabKey) return;

            facilityTabBtns.forEach(b => b.classList.remove('active'));
            facilityPanes.forEach(p => p.classList.remove('active'));

            this.classList.add('active');

            const targetPane = document.getElementById('subtab-' + subtabKey);
            if (targetPane) {
                targetPane.classList.add('active');
                setTimeout(() => {
                    initScrollReveal(targetPane);
                }, 50);
            }
        });
    });

    window.addEventListener('hashchange', checkHash);
    checkHash();

    // Initial reveal of visible elements
    initScrollReveal(document);
});
