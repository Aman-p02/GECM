// Department navigation, URL hash routing, and scroll reveal

function initDepartment() {
    const tabButtons = document.querySelectorAll('.dept-subnav-link');
    const tabPanes = document.querySelectorAll('.dept-tab-pane');
    const subNavList = document.querySelector('.dept-subnav-list');
    const subNav = document.getElementById('deptSubNav') || document.querySelector('.dept-subnav-bar');

    // 1. Scroll Reveal Observer definition
    const revealSelectors = [
        '.dept-section-header',
        '.dept-stat-item',
        '.dept-quote-callout',
        '.dept-charter-card',
        '.dept-objective-card',
        '.dept-lab-card',
        '.dept-avenue-card',
        '.dept-facility-item',
        '.dept-citation-item'
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
            '.dept-labs-showcase',
            '.dept-objectives-grid',
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

    // 2. Tab switching and URL routing
    function activateTab(tabId, shouldScroll = false) {
        if (!tabId) return;
        tabId = tabId.replace('#', '');

        // Map tab aliases to primary section IDs
        if (tabId === 'vision' || tabId === 'mission') {
            tabId = 'vision-mission';
        }
        if (tabId === 'advisory-board' || tabId === 'iab' || tabId === 'industry-advisory-board') {
            tabId = 'advisory-board';
        }
        if (tabId === 'newsletters' || tabId === 'nl') {
            tabId = 'newsletters';
        }

        const targetPane = document.getElementById('tab-' + tabId);
        if (!targetPane) return;

        // Update data-active-tab on .dept-page and body (controls photo & stats visibility)
        const deptPage = document.querySelector('.dept-page') || document.body;
        deptPage.setAttribute('data-active-tab', tabId);
        document.body.setAttribute('data-active-tab', tabId);

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

        // Optional scroll to content top
        if (shouldScroll) {
            const navOffset = subNav ? subNav.offsetHeight + 60 : 120;
            const elementPosition = targetPane.getBoundingClientRect().top + window.pageYOffset;
            const offsetPosition = elementPosition - navOffset;

            window.scrollTo({
                top: Math.max(0, offsetPosition),
                behavior: 'smooth'
            });
        }
    }

    // Attach click events to subnav buttons
    tabButtons.forEach(btn => {
        if (btn.tagName === 'A' && btn.getAttribute('href') && btn.getAttribute('href').startsWith('http')) {
            return;
        }

        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const tabId = btn.getAttribute('data-tab');
            if (!tabId) return;

            if (history.pushState) {
                history.pushState(null, null, '#' + tabId);
            } else {
                location.hash = tabId;
            }

            activateTab(tabId, false);
        });
    });

    // Hash routing for deep-links
    function handleHashRouting() {
        const hash = window.location.hash.replace('#', '').trim();
        if (hash) {
            activateTab(hash, false);
        } else {
            activateTab('about', false);
        }
    }

    window.addEventListener('hashchange', handleHashRouting);

    // Initial setup on load
    handleHashRouting();
    setupRevealElements(document);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDepartment);
} else {
    initDepartment();
}

