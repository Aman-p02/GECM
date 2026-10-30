// Department tab navigation and URL hash routing

document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.us-subnav-link, .dept-tab-btn, .dept-nav-link');
    const tabPanes = document.querySelectorAll('.us-tab-pane, .dept-pane, .dept-tab-content');
    const subNavList = document.querySelector('.us-subnav-list');

    // Switch active tab and display matching content pane
    function activateTab(tabId, shouldScroll = false) {
        if (!tabId) return;
        tabId = tabId.replace('#', '');

        // Map tab aliases to primary section IDs
        if (tabId === 'about' || tabId === 'vision-mission') {
            tabId = 'vision';
        }
        if (tabId === 'iab' || tabId === 'iab-2025-26' || tabId === 'iab-2023-24') {
            tabId = 'advisory-board';
        }
        if (tabId === 'nl' || tabId === 'nl-vol1-issue2' || tabId === 'nl-vol1-issue1') {
            tabId = 'newsletters';
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
            // Ensure selected tab is visible inside scrollable nav strip
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

        // Scroll to content on mobile screens if triggered by user click
        if (shouldScroll && window.innerWidth <= 768) {
            const navBar = document.querySelector('.us-subnav-bar') || document.querySelector('.dept-sticky-nav-bar');
            const offset = navBar ? navBar.offsetHeight + 10 : 70;
            const targetY = targetPane.getBoundingClientRect().top + window.pageYOffset - offset;
            window.scrollTo({ top: Math.max(0, targetY), behavior: 'smooth' });
        }
    }

    // Attach click events to all sub-navigation buttons
    tabButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
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

    // Sync tab state with window location hash
    function handleHash() {
        const hash = window.location.hash.substring(1);
        if (hash === 'syllabus') {
            window.location.href = 'https://syllabus.gtu.ac.in/';
            return;
        }
        if (hash) {
            activateTab(hash, false);
        } else {
            activateTab('vision', false);
        }
    }

    window.addEventListener('hashchange', handleHash);
    handleHash();
});
