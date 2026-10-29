/* Department Page Scripts */

document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.dept-nav-link');
    const tabPanes = document.querySelectorAll('.dept-tab-content');
    const pageTitle = document.getElementById('deptPageTitle');

    // Section titles
    const titleMap = {
        'about': 'About Department',
        'vision-mission': 'Vision and Mission',
        'syllabus': 'Syllabus',
        'faculty': 'Faculty',
        'activities': 'Activities',
        'facilities': 'Facilities',
        'publications': 'Publications',
        'instruction-material': 'Instruction Material',
        'learning-resources': 'Learning Resources',
        'feedback': 'Feedback for Instruction material',
        'academic-calendar': 'Department Academic Calender',
        'advisory-board': 'Industry Advisory Board',
        'newsletters': 'News Letters',
        'iab-2025-26': 'Industry Advisory Board (IAB 2025-26)',
        'iab-2023-24': 'Industry Advisory Board (IAB 2023-24)',
        'nl-vol1-issue2': 'News Letters (Vol. 1 Issue 2)',
        'nl-vol1-issue1': 'News Letters (Vol. 1 Issue 1)'
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
        '.facility-lead-intro',
        '.dept-facilities-dual-grid',
        '.facility-items-list li',
        '.publication-card',
        '.dept-doc-accordion'
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
            rootMargin: '0px 0px -100px 0px',
            threshold: 0.15
        });
    }

    function setupTabReveal(container) {
        if (!container) return;

        const elements = container.querySelectorAll(revealSelectors);
        elements.forEach((el, index) => {
            el.classList.add('dept-scroll-reveal');
            el.classList.remove('is-revealed');

            const rect = el.getBoundingClientRect();
            const isInInitialView = rect.top >= 0 && rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.92;

            if (isInInitialView) {
                const staggerDelay = Math.min(index * 90, 500);
                setTimeout(() => {
                    el.classList.add('is-revealed');
                }, staggerDelay);
            } else if (revealObserver) {
                revealObserver.observe(el);
            } else {
                el.classList.add('is-revealed');
            }
        });
    }

    /* ==========================================================
       3. Tab Activation Function (Deep-link & State Management)
       ========================================================== */
    function activateTab(targetId, shouldScroll = false) {
        if (!targetId) return;

        const targetPane = document.getElementById('tab-' + targetId);
        if (!targetPane) return;

        // Switch active tab pane
        tabPanes.forEach(pane => pane.classList.remove('active'));
        targetPane.classList.add('active');

        // Update active class on top-level navigation
        navLinks.forEach(link => {
            const linkTab = link.getAttribute('data-tab');
            const parentLi = link.closest('li');
            if (linkTab === targetId) {
                link.classList.add('active');
                if (parentLi) parentLi.classList.add('active');
            } else {
                link.classList.remove('active');
                if (parentLi) parentLi.classList.remove('active');
            }
        });

        // Sub-links active state handling
        const allSubLinks = document.querySelectorAll('.dept-sub-link');
        const targetSubLinks = document.querySelectorAll(`.dept-sub-link[data-tab="${targetId}"]`);

        allSubLinks.forEach(sl => sl.classList.remove('active'));
        targetSubLinks.forEach(sl => {
            sl.classList.add('active');
            const parentDropdown = sl.closest('.dept-sidebar-dropdown');
            if (parentDropdown) {
                parentDropdown.classList.add('open');
                parentDropdown.classList.remove('closed');
            }
        });

        // Update breadcrumb / page title if present
        if (pageTitle && titleMap[targetId]) {
            pageTitle.textContent = titleMap[targetId];
        }

        // Initialize scroll reveal on the newly active pane
        setupTabReveal(targetPane);

        // Center active pill on mobile
        const targetLink = document.querySelector(`.dept-nav-link[data-tab="${targetId}"]`);
        const scrollTarget = (targetSubLinks.length > 0) ? targetSubLinks[0] : targetLink;
        if (window.innerWidth <= 768 && scrollTarget) {
            try {
                scrollTarget.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            } catch (err) {}
        }

        // Scroll to content container on mobile navigation
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

    // Attach click listeners to regular sidebar links
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
        });
    });

    // Sidebar accordion toggles
    const dropdownHeaders = document.querySelectorAll('.dept-dropdown-header');
    dropdownHeaders.forEach(header => {
        function toggleDropdown(e) {
            if (e) e.preventDefault();
            const parent = header.closest('.dept-sidebar-dropdown');
            if (parent) {
                const isOpen = parent.classList.contains('open');
                if (isOpen) {
                    parent.classList.remove('open');
                    parent.classList.add('closed');
                } else {
                    parent.classList.add('open');
                    parent.classList.remove('closed');
                }
            }
        }
        header.addEventListener('click', toggleDropdown);
        header.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                toggleDropdown(e);
            }
        });
    });

    // Sub-menu navigation links
    document.addEventListener('click', function (e) {
        const subLink = e.target.closest('.dept-sub-link');
        if (subLink) {
            const tabId = subLink.getAttribute('data-tab');
            if (tabId) {
                e.preventDefault();
                if (history.pushState) {
                    history.pushState(null, null, '#' + tabId);
                } else {
                    window.location.hash = tabId;
                }
                activateTab(tabId, true);
            }
        }
    });

    // Document accordion panels
    const docAccordions = document.querySelectorAll('.dept-doc-accordion');
    docAccordions.forEach(acc => {
        const header = acc.querySelector('.dept-doc-accordion-header');
        if (header) {
            header.addEventListener('click', function () {
                const isOpen = acc.classList.contains('open');
                if (isOpen) {
                    acc.classList.remove('open');
                } else {
                    acc.classList.add('open');
                }
            });
        }
    });

    // Handle initial hash on load
    const currentHash = window.location.hash.replace('#', '');
    if (currentHash && document.getElementById('tab-' + currentHash)) {
        activateTab(currentHash, false);
    } else {
        const defaultTab = 'about';
        const defaultPane = document.getElementById('tab-' + defaultTab);
        if (defaultPane) {
            setupTabReveal(defaultPane);
        }
    }

    // Hash change event listener
    window.addEventListener('hashchange', function () {
        const newHash = window.location.hash.replace('#', '');
        if (newHash && document.getElementById('tab-' + newHash)) {
            activateTab(newHash, true);
        }
    });
});

