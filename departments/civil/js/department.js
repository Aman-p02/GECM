function initDepartment() {
    const tabButtons = document.querySelectorAll('.dept-subnav-link[data-tab]');
    const tabPanes = document.querySelectorAll('.dept-tab-pane');
    const tabItems = document.querySelectorAll('.dept-subnav-item');

    function activateTab(tabId, updateHash = true) {
        if (!tabId) return;

        tabPanes.forEach(pane => {
            if (pane.id === `tab-${tabId}`) {
                pane.classList.add('active');
            } else {
                pane.classList.remove('active');
            }
        });

        tabButtons.forEach(btn => {
            const parentItem = btn.closest('.dept-subnav-item');
            if (btn.getAttribute('data-tab') === tabId) {
                btn.classList.add('active');
                btn.setAttribute('aria-selected', 'true');
                if (parentItem) parentItem.classList.add('active');
            } else {
                btn.classList.remove('active');
                btn.setAttribute('aria-selected', 'false');
                if (parentItem) parentItem.classList.remove('active');
            }
        });

        if (updateHash) {
            history.replaceState(null, '', `#${tabId}`);
        }
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const targetTab = btn.getAttribute('data-tab');
            if (targetTab) {
                e.preventDefault();
                activateTab(targetTab, true);
            }
        });
    });

    const currentHash = window.location.hash.replace('#', '').trim();
    if (currentHash) {
        const matchingPane = document.getElementById(`tab-${currentHash}`);
        if (matchingPane) {
            activateTab(currentHash, false);
        }
    }

    const revealElements = document.querySelectorAll('.dept-reveal');
    if ('IntersectionObserver' in window && revealElements.length > 0) {
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        revealElements.forEach(el => observer.observe(el));
    } else {
        revealElements.forEach(el => el.classList.add('is-revealed'));
    }
}

document.addEventListener('DOMContentLoaded', initDepartment);
