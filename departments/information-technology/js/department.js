// Department navigation, URL hash routing, scroll reveal, and publication year filter

// Global publication filter function accessible from inline onchange or programmatic calls
function filterPublicationsByYear(selectedYear) {
    const yearFilter = document.getElementById('pubYearFilter');
    const countBadge = document.getElementById('pubCountBadge');
    const emptyState = document.getElementById('pubEmptyState');
    const pubItems = document.querySelectorAll('.dept-citation-item');

    if (!pubItems.length) return;

    if (yearFilter && yearFilter.value !== selectedYear) {
        yearFilter.value = selectedYear;
    }

    const sel = (selectedYear || 'all').trim();
    let visibleCount = 0;
    const totalCount = pubItems.length;

    pubItems.forEach(item => {
        const itemYear = (item.getAttribute('data-year') || '').trim();
        if (sel === 'all' || itemYear === sel) {
            item.style.display = '';
            item.classList.remove('is-filtered-out');
            visibleCount++;
            // Soft reveal animation
            item.classList.remove('is-revealed');
            setTimeout(() => item.classList.add('is-revealed'), 25);
        } else {
            item.style.display = 'none';
            item.classList.add('is-filtered-out');
        }
    });

    if (emptyState) {
        emptyState.style.display = (visibleCount === 0) ? 'block' : 'none';
    }

    if (countBadge) {
        if (sel === 'all') {
            countBadge.innerHTML = `Showing <strong>${totalCount}</strong> publications`;
        } else {
            countBadge.innerHTML = `Showing <strong>${visibleCount}</strong> of <strong>${totalCount}</strong> in <strong>${sel}</strong>`;
        }
    }
}
window.filterPublicationsByYear = filterPublicationsByYear;

function initDepartment() {
    const tabButtons = document.querySelectorAll('.dept-subnav-link');
    const tabPanes = document.querySelectorAll('.dept-tab-pane');
    const subNavList = document.querySelector('.dept-subnav-list');
    const subNav = document.getElementById('deptSubNav') || document.querySelector('.dept-subnav-bar');

    // 1. Scroll Reveal Observer definition
    const revealSelectors = [
        '.dept-section-header',
        '.dept-stat-item',
        '.dept-feature-card',
        '.dept-overview-grid',
        '.dept-about-overview',
        '.dept-objective-card',
        '.dept-faculty-card',
        '.dept-lab-card',
        '.dept-activity-card',
        '.dept-avenue-card',
        '.dept-facility-item',
        '.dept-citation-item',
        '.dept-board-card',
        '.dept-newsletter-card'
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
            rootMargin: '0px 0px -40px 0px',
            threshold: 0.08
        });
    }

    function setupRevealElements(container = document) {
        if (!container) return;

        const gridSelectors = [
            '.dept-faculty-roster',
            '.dept-labs-showcase',
            '.dept-objectives-grid',
            '.dept-periodical-grid',
            '.dept-avenues-grid',
            '.dept-facilities-grid',
            '.dept-citations-list',
            '.dept-stats-strip'
        ];

        gridSelectors.forEach(sel => {
            container.querySelectorAll(sel).forEach(grid => {
                Array.from(grid.children).forEach((child, idx) => {
                    child.classList.add(`stagger-${(idx % 4) + 1}`);
                });
            });
        });

        const elements = container.querySelectorAll(revealSelectors.join(', '));
        elements.forEach(el => {
            if (!el.classList.contains('dept-reveal')) {
                el.classList.add('dept-reveal');
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    setTimeout(() => el.classList.add('is-revealed'), 40);
                } else if (revealObserver) {
                    revealObserver.observe(el);
                } else {
                    el.classList.add('is-revealed');
                }
            } else if (!el.classList.contains('is-revealed')) {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    el.classList.add('is-revealed');
                } else if (revealObserver) {
                    revealObserver.observe(el);
                }
            }
        });
    }

    // 2. Publication Filter Controller Setup
    function initPublicationYearFilter() {
        const yearFilter = document.getElementById('pubYearFilter');
        const pubItems = document.querySelectorAll('.dept-citation-item');

        if (!yearFilter || !pubItems.length) return;

        // Ensure data-year attributes exist on all items
        const yearCounts = {};
        let totalCount = 0;

        pubItems.forEach(item => {
            let year = (item.getAttribute('data-year') || '').trim();
            if (!year) {
                const dateEl = item.querySelector('.dept-citation-date');
                if (dateEl) {
                    const match = dateEl.textContent.match(/\b(20\d\d)\b/);
                    if (match) {
                        year = match[1];
                        item.setAttribute('data-year', year);
                    }
                }
            }

            if (year) {
                yearCounts[year] = (yearCounts[year] || 0) + 1;
                totalCount++;
            }
        });

        // If dropdown options were not pre-rendered, populate dynamically
        if (yearFilter.options.length <= 1) {
            const sortedYears = Object.keys(yearCounts).sort((a, b) => parseInt(b, 10) - parseInt(a, 10));
            yearFilter.innerHTML = '';
            const allOption = document.createElement('option');
            allOption.value = 'all';
            allOption.textContent = `All Years (${totalCount})`;
            yearFilter.appendChild(allOption);

            sortedYears.forEach(year => {
                const opt = document.createElement('option');
                opt.value = year;
                opt.textContent = `${year} (${yearCounts[year]})`;
                yearFilter.appendChild(opt);
            });
        }

        // Attach change listener to dropdown
        yearFilter.addEventListener('change', function () {
            filterPublicationsByYear(this.value);
        });
    }

    // 3. Tab switching and URL routing
    function activateTab(tabId, shouldScroll = false) {
        if (!tabId) return;
        tabId = tabId.replace('#', '');

        // Map tab aliases to primary section IDs
        if (tabId === 'vision' || tabId === 'mission') {
            tabId = 'vision-mission';
        }
        if (tabId === 'advisory-board' || tabId === 'newsletters' || tabId === 'iab' || tabId === 'nl' || tabId === 'faculty' || tabId === 'activities') {
            return;
        }

        const targetPane = document.getElementById('tab-' + tabId);
        if (!targetPane) return;

        // Reset all buttons and tab panes
        tabButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.parentElement) {
                btn.parentElement.classList.remove('active');
            }
            btn.setAttribute('aria-selected', 'false');
        });

        tabPanes.forEach(pane => {
            pane.classList.remove('active');
        });

        // Activate button matching selected tab ID
        const matchedButtons = document.querySelectorAll(`[data-tab="${tabId}"]`);
        matchedButtons.forEach(btn => {
            btn.classList.add('active');
            btn.setAttribute('aria-selected', 'true');
            if (btn.parentElement) {
                btn.parentElement.classList.add('active');
            }
            if (subNavList) {
                try {
                    const btnRect = btn.getBoundingClientRect();
                    const listRect = subNavList.getBoundingClientRect();
                    if (btnRect.left < listRect.left || btnRect.right > listRect.right) {
                        btn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                    }
                } catch (e) {}
            }
        });

        // Show target content pane
        targetPane.classList.add('active');

        // Reveal elements inside the newly active tab pane
        setupRevealElements(targetPane);

        // Smoothly scroll to content if user is scrolled past the subnav
        if (shouldScroll) {
            const mainNav = document.getElementById('mainNavbar') || document.querySelector('.hdr-nav') || document.querySelector('.navbar');
            const mainNavHeight = (window.innerWidth > 768 && mainNav) ? (Math.round(mainNav.getBoundingClientRect().height) || 52) : 0;
            if (subNav) {
                const subNavRect = subNav.getBoundingClientRect();
                if (subNavRect.top <= mainNavHeight + 2) {
                    const targetY = subNav.offsetTop - mainNavHeight;
                    window.scrollTo({ top: Math.max(0, targetY), behavior: 'smooth' });
                }
            }
        }
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            const tabId = this.getAttribute('data-tab');
            if (tabId && tabId !== 'advisory-board' && tabId !== 'newsletters' && tabId !== 'faculty' && tabId !== 'activities') {
                e.preventDefault();
                if (history.pushState) {
                    history.pushState(null, null, '#' + tabId);
                } else {
                    window.location.hash = tabId;
                }
                activateTab(tabId, true);
            } else {
                e.preventDefault();
            }
        });
    });

    // Subnav sticky top position calculation
    function updateStickySubnavPosition() {
        if (!subNav) return;
        if (window.innerWidth > 768) {
            const mainNav = document.getElementById('mainNavbar') || document.querySelector('.hdr-nav') || document.querySelector('.navbar');
            if (mainNav) {
                const navHeight = Math.round(mainNav.getBoundingClientRect().height) || 52;
                document.documentElement.style.setProperty('--site-main-nav-height', `${navHeight}px`);
                subNav.style.top = `${navHeight}px`;
            } else {
                subNav.style.top = '52px';
            }
        } else {
            document.documentElement.style.setProperty('--site-main-nav-height', '0px');
            subNav.style.top = '0px';
        }
    }

    updateStickySubnavPosition();
    window.addEventListener('resize', updateStickySubnavPosition, { passive: true });
    window.addEventListener('scroll', updateStickySubnavPosition, { passive: true });

    // Initializations
    initPublicationYearFilter();
    setupRevealElements(document);

    // Initial hash handling
    function handleHash() {
        const hash = window.location.hash.substring(1);
        if (hash === 'syllabus') {
            window.location.href = 'https://syllabus.gtu.ac.in/';
            return;
        }
        if (hash) {
            activateTab(hash, false);
        } else {
            activateTab('about', false);
        }
    }

    window.addEventListener('hashchange', handleHash);
    handleHash();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDepartment);
} else {
    initDepartment();
}
