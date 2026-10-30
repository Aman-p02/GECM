/**
 * ==============================================================
 * Department Portal Interactive Scripts
 * Government Engineering College, Modasa (GEC Modasa)
 * ==============================================================
 */

document.addEventListener('DOMContentLoaded', () => {

    // -------------------------------------------------------------
    // 1. Faculty Filter & Real-Time Search
    // -------------------------------------------------------------
    const filterPills = document.querySelectorAll('.filter-pill');
    const searchInput = document.getElementById('facultySearchInput');
    const facultyItems = document.querySelectorAll('.faculty-member-item');
    const noMatchMsg = document.getElementById('noFacultyMatch');

    let currentFilter = 'all';
    let searchQuery = '';

    function applyFacultyFilters() {
        let visibleCount = 0;

        facultyItems.forEach(item => {
            const designation = item.getAttribute('data-designation') || '';
            const name = (item.getAttribute('data-name') || '').toLowerCase();
            const field = (item.getAttribute('data-field') || '').toLowerCase();

            const matchesFilter = (currentFilter === 'all') || (designation.toLowerCase() === currentFilter.toLowerCase());
            const matchesSearch = !searchQuery || name.includes(searchQuery) || field.includes(searchQuery);

            if (matchesFilter && matchesSearch) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        if (noMatchMsg) {
            noMatchMsg.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    if (filterPills.length > 0) {
        filterPills.forEach(pill => {
            pill.addEventListener('click', function () {
                filterPills.forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.getAttribute('data-filter') || 'all';
                applyFacultyFilters();
            });
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = this.value.trim().toLowerCase();
            applyFacultyFilters();
        });
    }

    // -------------------------------------------------------------
    // 2. Sticky Subnavigation Active State on Scroll
    // -------------------------------------------------------------
    const subnavLinks = document.querySelectorAll('.subnav-link');
    const sections = [];

    subnavLinks.forEach(link => {
        const targetId = link.getAttribute('href');
        if (targetId && targetId.startsWith('#')) {
            const section = document.querySelector(targetId);
            if (section) {
                sections.push({ id: targetId, section: section, link: link });
            }
        }
    });

    function updateActiveSubnav() {
        const scrollY = window.pageYOffset + 120;

        for (let i = sections.length - 1; i >= 0; i--) {
            const { section, link } = sections[i];
            const top = section.offsetTop;
            const height = section.offsetHeight;

            if (scrollY >= top && scrollY < top + height) {
                subnavLinks.forEach(l => l.classList.remove('active'));
                link.classList.add('active');

                // If mobile, ensure active link is scrolled into view in horizontal container
                if (window.innerWidth <= 768) {
                    link.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                }
                break;
            }
        }
    }

    window.addEventListener('scroll', updateActiveSubnav, { passive: true });

    // Smooth anchor click handling
    subnavLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId && targetId.startsWith('#')) {
                const targetEl = document.querySelector(targetId);
                if (targetEl) {
                    e.preventDefault();
                    const subnavHeight = document.getElementById('deptSubnav')?.offsetHeight || 60;
                    const targetTop = targetEl.getBoundingClientRect().top + window.pageYOffset - subnavHeight - 15;
                    window.scrollTo({
                        top: Math.max(0, targetTop),
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

});
