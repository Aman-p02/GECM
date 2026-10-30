/* ==============================================================
   GECM Department Detail Page Interactions
   Modern Horizontal Nav & Dynamic Pane Switching
   ============================================================== */

document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.dept-tab-btn, .dept-nav-link');
    const tabPanes = document.querySelectorAll('.dept-pane, .dept-tab-content');

    function activateTab(tabId, shouldScroll = false) {
        if (!tabId) return;
        tabId = tabId.replace('#', '');

        // Map alias tabs
        if (tabId === 'iab' || tabId === 'iab-2025-26' || tabId === 'iab-2023-24') {
            tabId = 'advisory-board';
        }
        if (tabId === 'nl' || tabId === 'nl-vol1-issue2' || tabId === 'nl-vol1-issue1') {
            tabId = 'newsletters';
        }

        const targetPane = document.getElementById('tab-' + tabId);
        if (!targetPane) return;

        // Reset all buttons and panes
        tabButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.parentElement) {
                btn.parentElement.classList.remove('active');
            }
        });

        tabPanes.forEach(pane => {
            pane.classList.remove('active');
        });

        // Activate matching button(s)
        const matchedButtons = document.querySelectorAll(`[data-tab="${tabId}"]`);
        matchedButtons.forEach(btn => {
            btn.classList.add('active');
            if (btn.parentElement) {
                btn.parentElement.classList.add('active');
            }
            // On mobile, scroll active tab into view
            if (window.innerWidth <= 768) {
                try {
                    btn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                } catch (e) {}
            }
        });

        // Activate pane
        targetPane.classList.add('active');

        // Optional smooth scroll to content
        if (shouldScroll && window.innerWidth <= 768) {
            const navBar = document.querySelector('.dept-sticky-nav-bar');
            const offset = navBar ? navBar.offsetHeight + 10 : 60;
            const targetY = targetPane.getBoundingClientRect().top + window.pageYOffset - offset;
            window.scrollTo({ top: Math.max(0, targetY), behavior: 'smooth' });
        }
    }

    // Attach click listeners to tabs
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

    // Hash listener
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
});
