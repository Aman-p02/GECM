// Department navigation, URL hash routing, scroll reveal, and publication year filter - Applied Mechanics

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

        yearFilter.addEventListener('change', function () {
            filterPublicationsByYear(this.value);
        });
    }

    // 3. Tab switching and URL routing
    function activateTab(tabId, shouldScroll = false) {
        if (!tabId) return;
        tabId = tabId.replace('#', '');

        if (tabId === 'vision' || tabId === 'mission') {
            tabId = 'vision-mission';
        }
        if (tabId === 'advisory-board' || tabId === 'newsletters' || tabId === 'iab' || tabId === 'nl' || tabId === 'faculty' || tabId === 'activities') {
            return;
        }

        const targetPane = document.getElementById('tab-' + tabId);
        if (!targetPane) return;

        tabPanes.forEach(pane => pane.classList.remove('active'));
        tabButtons.forEach(btn => {
            btn.classList.remove('active');
            btn.setAttribute('aria-selected', 'false');
            const parentItem = btn.closest('.dept-subnav-item');
            if (parentItem) parentItem.classList.remove('active');
        });

        targetPane.classList.add('active');

        const matchingBtn = Array.from(tabButtons).find(btn => btn.getAttribute('data-tab') === tabId);
        if (matchingBtn) {
            matchingBtn.classList.add('active');
            matchingBtn.setAttribute('aria-selected', 'true');
            const parentItem = matchingBtn.closest('.dept-subnav-item');
            if (parentItem) parentItem.classList.add('active');

            if (subNavList) {
                const btnLeft = matchingBtn.offsetLeft;
                const btnWidth = matchingBtn.offsetWidth;
                const listWidth = subNavList.offsetWidth;
                subNavList.scrollTo({
                    left: btnLeft - (listWidth / 2) + (btnWidth / 2),
                    behavior: 'smooth'
                });
            }
        }

        setupRevealElements(targetPane);

        if (shouldScroll) {
            const navBottom = subNav ? subNav.getBoundingClientRect().bottom : 70;
            const paneTop = targetPane.getBoundingClientRect().top + window.pageYOffset;
            const scrollOffset = 14;
            window.scrollTo({
                top: paneTop - navBottom - scrollOffset,
                behavior: 'smooth'
            });
        }
    }

    tabButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            const isExternalLink = this.tagName === 'A' && this.getAttribute('target') === '_blank';
            if (isExternalLink) return;

            e.preventDefault();
            const tabId = this.getAttribute('data-tab');

            if (!tabId || tabId === 'advisory-board' || tabId === 'newsletters' || tabId === 'faculty' || tabId === 'activities') {
                return;
            }

            if (history.pushState) {
                history.pushState(null, null, '#' + tabId);
            } else {
                window.location.hash = tabId;
            }
            activateTab(tabId, true);
        });
    });

    window.addEventListener('hashchange', function () {
        const hash = window.location.hash.replace('#', '');
        if (hash) {
            activateTab(hash, true);
        }
    });

    const initialHash = window.location.hash.replace('#', '');
    if (initialHash && document.getElementById('tab-' + initialHash)) {
        activateTab(initialHash, false);
    } else {
        const activePane = document.querySelector('.dept-tab-pane.active') || document.getElementById('tab-about');
        if (activePane) {
            const initialTabId = activePane.id.replace('tab-', '');
            activateTab(initialTabId, false);
        }
    }

    setupRevealElements(document);
    initPublicationYearFilter();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDepartment);
} else {
    initDepartment();
}
