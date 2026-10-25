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

        // Map parent tabs to default sub-options
        if (tabId === 'advisory-board') tabId = 'iab-2025-26';
        if (tabId === 'newsletters') tabId = 'nl-vol1-issue2';

        const targetPane = document.getElementById('tab-' + tabId);
        const targetLink = document.querySelector(`.dept-nav-link[data-tab="${tabId}"]`);
        const targetSubLinks = document.querySelectorAll(`.dept-sub-link[data-tab="${tabId}"]`);

        if (!targetPane) return;

        // Remove active class from all links, parents, and sub-links
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.parentElement) {
                link.parentElement.classList.remove('active');
            }
        });

        const allSubLinks = document.querySelectorAll('.dept-sub-link');
        allSubLinks.forEach(sub => sub.classList.remove('active'));

        // Activate regular nav link if matched
        if (targetLink) {
            targetLink.classList.add('active');
            if (targetLink.parentElement) {
                targetLink.parentElement.classList.add('active');
            }
        }

        // Activate sub-links and expand their dropdown if matched
        if (targetSubLinks.length > 0) {
            targetSubLinks.forEach(sub => {
                sub.classList.add('active');
                const parentDropdown = sub.closest('.dept-sidebar-dropdown');
                if (parentDropdown) {
                    parentDropdown.classList.remove('closed');
                }
            });
        }

        tabPanes.forEach(pane => pane.classList.remove('active'));
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
        const scrollTarget = (targetSubLinks.length > 0) ? targetSubLinks[0] : targetLink;
        if (window.innerWidth <= 768 && scrollTarget) {
            try {
                scrollTarget.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
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
            // Links without data-tab (like Syllabus) naturally open their href in new tab
        });
    });

    // Sidebar Accordion Dropdown Headers (Industry Advisory Board, Newsletters)
    const dropdownHeaders = document.querySelectorAll('.dept-dropdown-header');
    dropdownHeaders.forEach(header => {
        header.addEventListener('click', function () {
            const parent = this.closest('.dept-sidebar-dropdown');
            if (parent) {
                parent.classList.toggle('closed');
            }
        });
    });

    // Sub-menu Links (IAB 2025-26, IAB 2023-24, Vol. 1 Issue 2, Vol. 1 Issue 1)
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

    // Handle Hash changes & initial load
    function checkHash() {
        const hash = window.location.hash.substring(1);
        if (hash === 'syllabus') {
            window.location.href = 'https://syllabus.gtu.ac.in/';
            return;
        }
        if (hash === 'advisory-board') {
            activateTab('iab-2025-26', false);
            return;
        }
        if (hash === 'newsletters') {
            activateTab('nl-vol1-issue2', false);
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

    // Year-Wise Dropdown Filter for Publications
    const pubYearSelect = document.getElementById('pubYearSelect');
    const pubCards = document.querySelectorAll('.publication-card');
    const pubCount = document.getElementById('pubCountBadge');

    if (pubCards.length > 0) {
        // Cache publication year on each card
        pubCards.forEach(card => {
            const dateSpan = card.querySelector('.publication-date span');
            let year = '';
            if (dateSpan) {
                const match = dateSpan.textContent.match(/\b(19\d\d|20\d\d)\b/);
                year = match ? match[1] : dateSpan.textContent.trim();
            }
            card.setAttribute('data-pub-year', year);
        });

        if (pubYearSelect) {
            pubYearSelect.addEventListener('change', function () {
                const selectedYear = this.value;
                let visibleCount = 0;

                pubCards.forEach(card => {
                    const cardYear = card.getAttribute('data-pub-year') || '';
                    if (selectedYear === 'all' || cardYear === selectedYear) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (pubCount) {
                    pubCount.innerHTML = '<i class="fas fa-file-alt"></i> ' + visibleCount + ' Publications';
                }
            });
        }
    }

    // Document Accordions (Industry Advisory Board & Newsletters)
    const accordionHeaders = document.querySelectorAll('.dept-doc-accordion-header');
    accordionHeaders.forEach(header => {
        header.addEventListener('click', function () {
            const parent = this.closest('.dept-doc-accordion');
            if (parent) {
                const isOpen = parent.classList.toggle('open');
                this.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            }
        });
    });
});
