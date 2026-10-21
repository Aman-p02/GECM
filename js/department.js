/* ==============================================================
   GECM Department Detail Page Interactions
   Tabs navigation, deep linking, and smooth section switching
   ============================================================== */

document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.dept-nav-link');
    const tabPanes = document.querySelectorAll('.dept-tab-pane, .dept-tab-content');

    function activateTab(tabId) {
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

        // Activate target
        targetLink.classList.add('active');
        if (targetLink.parentElement) {
            targetLink.parentElement.classList.add('active');
        }
        targetPane.classList.add('active');

        // Scroll to content on small screens
        if (window.innerWidth < 900) {
            const panel = document.querySelector('.dept-content-panel');
            if (panel) {
                panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }

    // Attach click listeners to sidebar links
    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const tabId = this.getAttribute('data-tab');
            if (tabId) {
                window.location.hash = tabId;
                activateTab(tabId);
            }
        });
    });

    // Handle Hash changes & initial load
    function checkHash() {
        const hash = window.location.hash.substring(1);
        if (hash && document.getElementById('tab-' + hash)) {
            activateTab(hash);
        } else {
            activateTab('about');
        }
    }

    window.addEventListener('hashchange', checkHash);
    checkHash();
});
