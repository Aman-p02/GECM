/* ==============================================================
   GECM Department Detail Page Interactions
   - Scroll-triggered reveal loading across ALL department tabs
   - Smooth navigation scrolling and facility sub-tabs
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
       1. Smooth Scroll Helper Function
       ========================================================== */
    function smoothScrollTo(targetY, duration = 400) {
        const startY = window.pageYOffset;
        const diff = targetY - startY;
        let startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            const elapsed = timestamp - startTime;
            const progress = Math.min(elapsed / duration, 1);
            // Smooth natural easeOutCubic curve
            const ease = 1 - Math.pow(1 - progress, 3);

            window.scrollTo(0, startY + (diff * ease));

            if (progress < 1) {
                requestAnimationFrame(step);
            }
        }
        requestAnimationFrame(step);
    }

    /* ==========================================================
       2. Scroll-Triggered Reveal Animation (Load on Scroll for ALL Tabs)
       ========================================================== */
    const revealSelectors = [
        '.dept-divider-title',
        '.dept-text-body',
        '.courses-card',
        '.peo-card',
        '.vision-quote-box',
        '.mission-bullet-list',
        '.mission-bullet-list li',
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
            rootMargin: '0px 0px -100px 0px', // Trigger when element is well inside the viewport
            threshold: 0.15
        });
    }

    function setupTabReveal(container) {
        if (!container) return;

        const elements = container.querySelectorAll(revealSelectors);
        elements.forEach((el, index) => {
            el.classList.add('dept-scroll-reveal');
            el.classList.remove('is-revealed');

            // Check if element is currently within the visible viewport window
            const rect = el.getBoundingClientRect();
            if (rect.top >= 0 && rect.top < window.innerHeight - 60) {
                // Calm, slow stagger cascade for initial viewport items
                setTimeout(() => {
                    el.classList.add('is-revealed');
                }, Math.min(index * 220, 1100));
            } else {
                // For items below the screen, smoothly reveal as user scrolls down!
                if (revealObserver) {
                    revealObserver.observe(el);
                } else {
                    el.classList.add('is-revealed');
                }
            }
        });
    }

    /* ==========================================================
       3. Tab Activation & Navigation
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
        requestAnimationFrame(() => {
            setupTabReveal(targetPane);
        });

        // On mobile / small screens, center the active pill in the horizontal nav
        if (window.innerWidth <= 768 && targetLink) {
            try {
                targetLink.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            } catch (err) {
                // fallback
            }
        }

        // Smooth scroll to content top if triggered by user click on mobile
        if (shouldScroll && window.innerWidth <= 768) {
            const contentPanel = document.querySelector('.dept-content-panel');
            if (contentPanel) {
                const stickyNav = document.querySelector('.dept-sidebar');
                const navHeight = stickyNav ? stickyNav.offsetHeight : 50;
                const targetY = contentPanel.getBoundingClientRect().top + window.pageYOffset - navHeight - 10;
                smoothScrollTo(Math.max(0, targetY), 400);
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
       4. Facilities Segmented Sub-tabs Handler
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
                requestAnimationFrame(() => {
                    setupTabReveal(targetPane);
                });
            }
        });
    });

    window.addEventListener('hashchange', checkHash);
    checkHash();

    // Initial reveal on the active tab
    const initialActivePane = document.querySelector('.dept-tab-content.active');
    if (initialActivePane) {
        requestAnimationFrame(() => {
            setupTabReveal(initialActivePane);
        });
    }
});
