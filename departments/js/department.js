/* ==============================================================
   GECM Department Detail Page Interactions
   Tabs navigation, dynamic top heading update, and smooth mobile scrolling
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
                window.scrollTo({ top: Math.max(0, targetY), behavior: 'smooth' });
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

    window.addEventListener('hashchange', checkHash);
    checkHash();
});
