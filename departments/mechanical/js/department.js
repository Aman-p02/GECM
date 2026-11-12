// Department navigation, URL hash routing, scroll reveal, and publication year filter

// Global publication filter function accessible from inline onchange or programmatic calls
function filterPublicationsByYear(selectedYear) {
    const yearFilter = document.getElementById('pubYearFilter') || document.querySelector('.dept-pub-select');
    const countBadge = document.getElementById('pubCountBadge') || document.querySelector('.dept-pub-badge');
    const emptyState = document.getElementById('pubEmptyState') || document.querySelector('.dept-pub-empty');
    const pubItems = document.querySelectorAll('.dept-citation-item');

    if (!pubItems.length) return;

    if (yearFilter && yearFilter.value !== selectedYear) {
        yearFilter.value = selectedYear;
    }

    const sel = (selectedYear || 'all').toString().trim();
    let visibleCount = 0;
    const totalCount = pubItems.length;

    pubItems.forEach(item => {
        const itemYear = (item.getAttribute('data-year') || '').trim();
        if (sel === 'all' || itemYear === sel) {
            item.style.removeProperty('display');
            item.classList.remove('is-filtered-out');
            visibleCount++;
            // Soft reveal animation
            item.classList.remove('is-revealed');
            setTimeout(() => item.classList.add('is-revealed'), 25);
        } else {
            item.style.setProperty('display', 'none', 'important');
            item.classList.add('is-filtered-out');
        }
    });

    if (emptyState) {
        if (visibleCount === 0) {
            emptyState.style.setProperty('display', 'block', 'important');
        } else {
            emptyState.style.setProperty('display', 'none', 'important');
        }
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
window.filterDeptPubs = function(yr) { filterPublicationsByYear(yr); };

// ==============================================================
// Facility Laboratory Image Slider & Real-Time Touch Gestures
// ==============================================================
function setLabSlide(slider, targetIndex, animate = true) {
    if (!slider) return;
    const slidesContainer = slider.querySelector('.dept-lab-slides');
    const slides = slider.querySelectorAll('.dept-lab-slide');
    const dots = slider.querySelectorAll('.dept-lab-dot');
    const total = slides.length;
    if (total <= 1) return;

    let idx = targetIndex;
    if (idx < 0) idx = total - 1;
    if (idx >= total) idx = 0;

    slider.setAttribute('data-current-slide', idx);

    if (slidesContainer) {
        if (!animate) {
            slidesContainer.style.transition = 'none';
        } else {
            slidesContainer.style.transition = 'transform 0.38s cubic-bezier(0.25, 1, 0.5, 1)';
        }
        slidesContainer.style.transform = `translateX(-${idx * 100}%)`;
    }

    slides.forEach((s, i) => {
        if (i === idx) {
            s.classList.add('active');
        } else {
            s.classList.remove('active');
        }
    });

    dots.forEach((d, i) => {
        if (i === idx) {
            d.classList.add('active');
            d.setAttribute('aria-current', 'true');
        } else {
            d.classList.remove('active');
            d.removeAttribute('aria-current');
        }
    });

}

function resetLabSliderTimer(slider) {
    if (!slider) return;
    if (slider._autoSlideTimer) {
        clearInterval(slider._autoSlideTimer);
        slider._autoSlideTimer = null;
    }
    let delay = parseInt(slider.getAttribute('data-autoplay') || '4000', 10);
    // On mobile / phone view, slow down auto-slide interval so photos can be viewed comfortably
    if (window.innerWidth <= 768) {
        delay = Math.max(delay, 7000);
    }
    if (delay > 0) {
        slider._autoSlideTimer = setInterval(() => {
            if (!slider.matches(':hover') && !document.hidden && !slider.classList.contains('is-dragging')) {
                const current = parseInt(slider.getAttribute('data-current-slide') || '0', 10);
                setLabSlide(slider, current + 1);
            }
        }, delay);
    }
}

function prevLabSlide(btn, e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    const slider = btn.closest('.dept-lab-slider');
    if (!slider) return;
    const current = parseInt(slider.getAttribute('data-current-slide') || '0', 10);
    setLabSlide(slider, current - 1);
    resetLabSliderTimer(slider);
}

function nextLabSlide(btn, e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    const slider = btn.closest('.dept-lab-slider');
    if (!slider) return;
    const current = parseInt(slider.getAttribute('data-current-slide') || '0', 10);
    setLabSlide(slider, current + 1);
    resetLabSliderTimer(slider);
}

function goLabSlide(dot, index, e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    const slider = dot.closest('.dept-lab-slider');
    if (!slider) return;
    setLabSlide(slider, index);
    resetLabSliderTimer(slider);
}

function bindLabSliderGestures(slider) {
    if (!slider || slider._gesturesBound) return;
    slider._gesturesBound = true;

    const slidesContainer = slider.querySelector('.dept-lab-slides');
    if (!slidesContainer) return;

    let startX = 0;
    let startY = 0;
    let currentX = 0;
    let currentY = 0;
    let isDragging = false;
    let isHorizontalSwipe = false;
    let hasDragged = false;
    let currentSlideIdx = 0;
    let sliderWidth = 0;
    let totalSlides = slider.querySelectorAll('.dept-lab-slide').length;

    if (totalSlides <= 1) return;

    function handleDragStart(clientX, clientY) {
        currentSlideIdx = parseInt(slider.getAttribute('data-current-slide') || '0', 10);
        totalSlides = slider.querySelectorAll('.dept-lab-slide').length;
        sliderWidth = slider.offsetWidth || 300;
        startX = clientX;
        startY = clientY;
        currentX = clientX;
        currentY = clientY;
        isDragging = true;
        isHorizontalSwipe = false;
        hasDragged = false;

        // Pause auto timer during hand touch
        if (slider._autoSlideTimer) {
            clearInterval(slider._autoSlideTimer);
            slider._autoSlideTimer = null;
        }
        slider.classList.add('is-dragging');
    }

    function handleDragMove(clientX, clientY, e) {
        if (!isDragging) return;
        currentX = clientX;
        currentY = clientY;

        const diffX = currentX - startX;
        const diffY = currentY - startY;

        if (Math.hypot(diffX, diffY) > 8) {
            hasDragged = true;
        }

        if (!isHorizontalSwipe) {
            // Determine vertical page scrolling vs horizontal image swiping
            if (Math.abs(diffY) > Math.abs(diffX) && Math.abs(diffY) > 8) {
                // User is scrolling the page vertically
                isDragging = false;
                slider.classList.remove('is-dragging');
                return;
            }
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 8) {
                isHorizontalSwipe = true;
                slidesContainer.style.transition = 'none';
            }
        }

        if (isHorizontalSwipe) {
            if (e && e.cancelable) {
                e.preventDefault();
            }
            // Add resistance at edge boundaries
            let delta = diffX;
            if ((currentSlideIdx === 0 && diffX > 0) || (currentSlideIdx === totalSlides - 1 && diffX < 0)) {
                delta = diffX * 0.32;
            }
            slidesContainer.style.transform = `translateX(calc(-${currentSlideIdx * 100}% + ${delta}px))`;
        }
    }

    function handleDragEnd() {
        if (!isDragging) return;
        isDragging = false;
        slider.classList.remove('is-dragging');

        if (hasDragged) {
            slider._justSwiped = true;
            setTimeout(() => {
                slider._justSwiped = false;
            }, 260);
        }

        if (isHorizontalSwipe) {
            const diffX = currentX - startX;
            const threshold = Math.max(sliderWidth * 0.15, 40);

            slidesContainer.style.transition = 'transform 0.36s cubic-bezier(0.25, 1, 0.5, 1)';

            if (diffX < -threshold) {
                // Swiped left -> next slide
                if (currentSlideIdx < totalSlides - 1) {
                    setLabSlide(slider, currentSlideIdx + 1);
                } else {
                    setLabSlide(slider, currentSlideIdx);
                }
            } else if (diffX > threshold) {
                // Swiped right -> previous slide
                if (currentSlideIdx > 0) {
                    setLabSlide(slider, currentSlideIdx - 1);
                } else {
                    setLabSlide(slider, 0);
                }
            } else {
                // Not dragged past threshold -> snap back to current
                setLabSlide(slider, currentSlideIdx);
            }
        }

        resetLabSliderTimer(slider);
    }

    // --- Touch Events for Mobile (Phone / Tablet) ---
    slider.addEventListener('touchstart', e => {
        if (e.touches && e.touches.length === 1) {
            handleDragStart(e.touches[0].clientX, e.touches[0].clientY);
        }
    }, { passive: true });

    slider.addEventListener('touchmove', e => {
        if (e.touches && e.touches.length === 1) {
            handleDragMove(e.touches[0].clientX, e.touches[0].clientY, e);
        }
    }, { passive: false });

    slider.addEventListener('touchend', () => {
        handleDragEnd();
    }, { passive: true });

    slider.addEventListener('touchcancel', () => {
        handleDragEnd();
    }, { passive: true });

    // --- Mouse Drag for Desktop / Emulators ---
    slider.addEventListener('mousedown', e => {
        if (e.button !== 0) return;
        if (e.target.closest('.dept-lab-slide-nav') || e.target.closest('.dept-lab-dot')) return;
        e.preventDefault();
        handleDragStart(e.clientX, e.clientY);

        function onMouseMove(moveEvent) {
            handleDragMove(moveEvent.clientX, moveEvent.clientY, moveEvent);
        }

        function onMouseUp() {
            window.removeEventListener('mousemove', onMouseMove);
            window.removeEventListener('mouseup', onMouseUp);
            handleDragEnd();
        }

        window.addEventListener('mousemove', onMouseMove);
        window.addEventListener('mouseup', onMouseUp);
    });

    // Pause on hover
    slider.addEventListener('mouseenter', () => {
        if (slider._autoSlideTimer) {
            clearInterval(slider._autoSlideTimer);
            slider._autoSlideTimer = null;
        }
    });

    slider.addEventListener('mouseleave', () => {
        if (!isDragging) {
            resetLabSliderTimer(slider);
        }
    });
}

function initLabSliders() {
    const sliders = document.querySelectorAll('.dept-lab-slider');
    sliders.forEach(slider => {
        slider.setAttribute('data-current-slide', '0');
        setLabSlide(slider, 0, false);
        resetLabSliderTimer(slider);
        bindLabSliderGestures(slider);
    });

    // Prevent any click zoom/enlarge on laboratory images
    document.querySelectorAll('.dept-lab-image-frame img').forEach(img => {
        img.addEventListener('click', e => {
            e.preventDefault();
        });
    });
}

window.prevLabSlide = prevLabSlide;
window.nextLabSlide = nextLabSlide;
window.goLabSlide = goLabSlide;

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

    // 2. Publication Filter Controller Setup
    function initPublicationYearFilter() {
        const yearFilter = document.getElementById('pubYearFilter') || document.querySelector('.dept-pub-select');
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
        if (tabId === 'advisory-board' || tabId === 'iab' || tabId === 'industry-advisory-board') {
            tabId = 'industry-advisory-board';
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
                } catch (e) { }
            }
        });

        // Update active highlight in mobile navigation drawer as well
        const mainNavList = document.getElementById('mainNavLinks');
        if (mainNavList) {
            mainNavList.querySelectorAll('.hdr-nav-link, .hdr-dd-link').forEach(el => {
                if (el.getAttribute('data-tab') === tabId) {
                    el.classList.add('active', 'is-active');
                } else {
                    el.classList.remove('active', 'is-active');
                }
            });
        }

        // Show target content pane
        targetPane.classList.add('active');

        // Reveal elements inside the newly active tab pane
        setupRevealElements(targetPane);

        if (tabId === 'facilities') {
            initLabSliders();
        }

        // Smoothly scroll to content
        if (shouldScroll) {
            if (window.innerWidth <= 768) {
                // Mobile view: scroll smoothly to content
                const scrollTarget = document.querySelector('.dept-main-content') || targetPane;
                if (scrollTarget) {
                    const headerHeight = 60;
                    const targetY = scrollTarget.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                    window.scrollTo({ top: Math.max(0, targetY), behavior: 'smooth' });
                }
            } else {
                // Desktop view: scroll if past subnav
                const mainNav = document.getElementById('mainNavbar') || document.querySelector('.hdr-nav') || document.querySelector('.navbar');
                const mainNavHeight = mainNav ? (Math.round(mainNav.getBoundingClientRect().height) || 52) : 0;
                if (subNav) {
                    const subNavRect = subNav.getBoundingClientRect();
                    if (subNavRect.top <= mainNavHeight + 2) {
                        const targetY = subNav.offsetTop - mainNavHeight;
                        window.scrollTo({ top: Math.max(0, targetY), behavior: 'smooth' });
                    }
                }
            }
        }
    }
    window.activateTab = activateTab;

    // Mobile Department Navigation Integration (Replaces main navbar on mobile with simple Dept Menu + Home)
    function setupMobileDepartmentNav() {
        const mainNavList = document.getElementById('mainNavLinks');
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        if (!mainNavList || !hamburgerBtn) return;

        let defaultNavHtml = null;
        let deptNavHtml = null;

        function buildDeptNav() {
            if (deptNavHtml) return deptNavHtml;

            deptNavHtml = `
                <li class="hdr-nav-item">
                    <a href="../../index.php" class="hdr-nav-link">
                        Home
                    </a>
                </li>
                <li class="hdr-nav-item">
                    <a href="javascript:void(0);" class="hdr-nav-link" data-tab="about">
                        About
                    </a>
                </li>
                <li class="hdr-nav-item">
                    <a href="javascript:void(0);" class="hdr-nav-link" data-tab="vision-mission">
                        Vision &amp; Mission
                    </a>
                </li>
                <li class="hdr-nav-item">
                    <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="hdr-nav-link" id="deptMobileSyllabusLink">
                        GTU Syllabus
                    </a>
                </li>
                <li class="hdr-nav-item">
                    <a href="javascript:void(0);" class="hdr-nav-link" data-tab="facilities">
                        Facilities
                    </a>
                </li>
                <li class="hdr-nav-item">
                    <a href="javascript:void(0);" class="hdr-nav-link" data-tab="publications">
                        Publications
                    </a>
                </li>
                <li class="hdr-nav-item">
                    <a href="javascript:void(0);" class="hdr-nav-link" data-tab="instruction-material">
                        Instruction Material
                    </a>
                </li>
                <li class="hdr-nav-item">
                    <a href="javascript:void(0);" class="hdr-nav-link" data-tab="learning-resources">
                        Learning Resources
                    </a>
                </li>
                <li class="hdr-nav-item">
                    <a href="javascript:void(0);" class="hdr-nav-link" data-tab="instruction-feedback">
                        Feedback for Instruction material
                    </a>
                </li>
                <li class="hdr-nav-item has-dropdown">
                    <a href="javascript:void(0);" class="hdr-nav-link">
                        Department Academic Calendar <i class="fas fa-chevron-down hdr-arrow"></i>
                    </a>
                    <div class="hdr-dropdown">
                        <ul class="hdr-dd-list">
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="academic-calendar" data-row-id="cal-even-2025-26">EVEN 2025-26</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="academic-calendar" data-row-id="cal-odd-2025-26">ODD 2025-26</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="academic-calendar" data-row-id="cal-even-2024-25">EVEN 2024-25</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="academic-calendar" data-row-id="cal-odd-2024-25-rev">ODD 2024-25 (Revised)</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="academic-calendar" data-row-id="cal-odd-2024-25">ODD 2024-25</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="academic-calendar" data-row-id="cal-even-2023-24-rev">EVEN 2023-24 (Revised)</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="academic-calendar" data-row-id="cal-even-2023-24">EVEN 2023-24</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="academic-calendar" data-row-id="cal-odd-2023-24">ODD 2023-24</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="academic-calendar" data-row-id="cal-even-2022-23">EVEN 2022-23</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="academic-calendar" data-row-id="cal-odd-2022-23">ODD 2022-23</a></li>
                        </ul>
                    </div>
                </li>
                <li class="hdr-nav-item has-dropdown">
                    <a href="javascript:void(0);" class="hdr-nav-link">
                        Industry Advisory Board <i class="fas fa-chevron-down hdr-arrow"></i>
                    </a>
                    <div class="hdr-dropdown">
                        <ul class="hdr-dd-list">
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="industry-advisory-board" data-row-id="iab-2025-26">IAB 2025-26</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="industry-advisory-board" data-row-id="iab-2024-25">IAB 2024-25</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="industry-advisory-board" data-row-id="iab-2023-24">IAB 2023-24</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="industry-advisory-board" data-row-id="iab-2022-23">IAB 2022-23</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="industry-advisory-board" data-row-id="iab-2021-22">IAB 2021-22</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="industry-advisory-board" data-row-id="iab-2020-21">IAB 2020-21</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="industry-advisory-board" data-row-id="iab-2019-20">IAB 2019-20</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="industry-advisory-board" data-row-id="iab-2018-19">IAB 2018-19</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="industry-advisory-board" data-row-id="iab-2017-18">IAB 2017-18</a></li>
                        </ul>
                    </div>
                </li>
                <li class="hdr-nav-item has-dropdown">
                    <a href="javascript:void(0);" class="hdr-nav-link">
                        News Letters <i class="fas fa-chevron-down hdr-arrow"></i>
                    </a>
                    <div class="hdr-dropdown">
                        <ul class="hdr-dd-list">
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="newsletters" data-row-id="nl-2025">News Letter 2025</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="newsletters" data-row-id="nl-2024">News Letter 2024</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="newsletters" data-row-id="nl-2023">News Letter 2023</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="newsletters" data-row-id="nl-2022">News Letter 2022</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="newsletters" data-row-id="nl-2021">News Letter 2021</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="newsletters" data-row-id="nl-2020">News Letter 2020</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="newsletters" data-row-id="nl-2019">News Letter 2019</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="newsletters" data-row-id="nl-2018">News Letter 2018</a></li>
                            <li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="newsletters" data-row-id="nl-2017">News Letter 2017</a></li>
                        </ul>
                    </div>
                </li>
            `;
            return deptNavHtml;
        }

        function checkAndApplyMobileNav() {
            if (window.innerWidth <= 768) {
                if (!defaultNavHtml) {
                    defaultNavHtml = mainNavList.innerHTML;
                }
                if (mainNavList.getAttribute('data-mode') !== 'department') {
                    mainNavList.innerHTML = buildDeptNav();
                    mainNavList.setAttribute('data-mode', 'department');
                    bindDeptMobileEvents();
                }
            } else {
                if (defaultNavHtml && mainNavList.getAttribute('data-mode') === 'department') {
                    mainNavList.innerHTML = defaultNavHtml;
                    mainNavList.setAttribute('data-mode', 'default');
                }
            }
        }

        function bindDeptMobileEvents() {
            // Tab links inside drawer
            mainNavList.querySelectorAll('[data-tab]').forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const tabId = this.getAttribute('data-tab');
                    const rowId = this.getAttribute('data-row-id');

                    // Close mobile drawer
                    mainNavList.classList.remove('is-open');
                    hamburgerBtn.setAttribute('aria-expanded', 'false');
                    hamburgerBtn.classList.remove('is-active');

                    if (tabId) {
                        if (history.pushState) {
                            history.pushState(null, null, '#' + tabId);
                        } else {
                            window.location.hash = tabId;
                        }
                        activateTab(tabId, !rowId);
                    }

                    if (rowId) {
                        setTimeout(() => {
                            const targetEl = document.getElementById(rowId);
                            if (targetEl) {
                                const elY = targetEl.getBoundingClientRect().top + window.pageYOffset - 70;
                                window.scrollTo({ top: Math.max(0, elY), behavior: 'smooth' });
                                targetEl.classList.remove('is-row-highlight');
                                void targetEl.offsetWidth;
                                targetEl.classList.add('is-row-highlight');
                            }
                        }, 260);
                    }
                });
            });

            // Accordion toggle for mobile dropdowns
            mainNavList.querySelectorAll('.hdr-nav-item.has-dropdown > .hdr-nav-link').forEach(toggle => {
                toggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const parent = this.closest('.hdr-nav-item.has-dropdown');
                    if (!parent) return;
                    const isOpen = parent.classList.contains('is-sub-open');
                    mainNavList.querySelectorAll('.hdr-nav-item.has-dropdown.is-sub-open').forEach(item => {
                        if (item !== parent) item.classList.remove('is-sub-open');
                    });
                    parent.classList.toggle('is-sub-open', !isOpen);
                });
            });

            // Close drawer when GTU Syllabus or Home is tapped
            const syllabusLink = mainNavList.querySelector('#deptMobileSyllabusLink');
            if (syllabusLink) {
                syllabusLink.addEventListener('click', function () {
                    mainNavList.classList.remove('is-open');
                    hamburgerBtn.setAttribute('aria-expanded', 'false');
                    hamburgerBtn.classList.remove('is-active');
                });
            }
        }

        checkAndApplyMobileNav();
        window.addEventListener('resize', checkAndApplyMobileNav, { passive: true });
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            // Allow anchor links with valid href (e.g. GTU syllabus portal) to navigate normally
            if (this.tagName === 'A' && this.getAttribute('href') && this.getAttribute('href') !== '#') {
                return;
            }

            const tabId = this.getAttribute('data-tab');
            if (tabId) {
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

    // 4. Subnav dropdown menus controller
    function initSubnavDropdowns() {
        const dropdownItems = document.querySelectorAll('.dept-subnav-dropdown');

        function positionMenu(item) {
            const btn = item.querySelector('.dept-dropdown-toggle') || item.querySelector('.dept-subnav-link');
            const menu = item.querySelector('.dept-subnav-menu');
            if (!btn || !menu) return;

            const rect = btn.getBoundingClientRect();
            menu.style.top = `${Math.round(rect.bottom + 4)}px`;
            const menuWidth = menu.offsetWidth || 230;
            let left = Math.round(rect.left);
            if (left + menuWidth > window.innerWidth - 12) {
                left = Math.max(12, window.innerWidth - menuWidth - 12);
            }
            menu.style.left = `${left}px`;
        }

        function closeAllMenus() {
            dropdownItems.forEach(item => {
                item.classList.remove('is-open');
                const btn = item.querySelector('.dept-dropdown-toggle');
                const menu = item.querySelector('.dept-subnav-menu');
                if (btn) btn.setAttribute('aria-expanded', 'false');
                if (menu) menu.classList.remove('is-open');
            });
        }

        dropdownItems.forEach(item => {
            const btn = item.querySelector('.dept-dropdown-toggle') || item.querySelector('.dept-subnav-link');
            const menu = item.querySelector('.dept-subnav-menu');
            if (!btn || !menu) return;

            btn.addEventListener('click', function (e) {
                const isArrowClick = e.target.closest('.dept-subnav-arrow');
                const isOpen = item.classList.contains('is-open');

                if (isArrowClick) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (isOpen) {
                        closeAllMenus();
                    } else {
                        closeAllMenus();
                        item.classList.add('is-open');
                        menu.classList.add('is-open');
                        btn.setAttribute('aria-expanded', 'true');
                        positionMenu(item);
                    }
                } else {
                    const tabId = btn.getAttribute('data-tab');
                    if (tabId) {
                        activateTab(tabId, true);
                    }
                    if (!isOpen) {
                        closeAllMenus();
                        item.classList.add('is-open');
                        menu.classList.add('is-open');
                        btn.setAttribute('aria-expanded', 'true');
                        positionMenu(item);
                    } else {
                        closeAllMenus();
                    }
                }
            });

            item.addEventListener('mouseenter', function () {
                if (window.innerWidth > 992) {
                    closeAllMenus();
                    item.classList.add('is-open');
                    menu.classList.add('is-open');
                    btn.setAttribute('aria-expanded', 'true');
                    positionMenu(item);
                }
            });

            item.addEventListener('mouseleave', function () {
                if (window.innerWidth > 992) {
                    closeAllMenus();
                }
            });
        });

        document.querySelectorAll('.dept-subnav-menu-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                closeAllMenus();

                const tabId = this.getAttribute('data-tab');
                const rowId = this.getAttribute('data-row-id');

                if (tabId) {
                    activateTab(tabId, true);
                }

                if (rowId) {
                    setTimeout(() => {
                        const targetEl = document.getElementById(rowId);
                        if (targetEl) {
                            targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            targetEl.classList.remove('is-row-highlight');
                            void targetEl.offsetWidth;
                            targetEl.classList.add('is-row-highlight');
                        }
                    }, 220);
                }
            });
        });

        document.addEventListener('click', function (e) {
            if (!e.target.closest('.dept-subnav-dropdown') && !e.target.closest('.dept-subnav-menu')) {
                closeAllMenus();
            }
        });

        window.addEventListener('scroll', function () {
            closeAllMenus();
        }, { passive: true });

        window.addEventListener('resize', function () {
            closeAllMenus();
        }, { passive: true });
    }

    // 5. Horizontal scroll indicator & 'More' navigation hint controller
    function initSubnavScrollHint() {
        const wrap = document.getElementById('deptSubNavWrap');
        const list = document.getElementById('deptSubNavList') || document.querySelector('.dept-subnav-list');
        const prevBtn = document.getElementById('deptNavScrollPrev');
        const nextBtn = document.getElementById('deptNavScrollNext');
        if (!wrap || !list || !nextBtn) return;

        function updateScrollState() {
            const scrollLeft = Math.ceil(list.scrollLeft);
            const maxScroll = list.scrollWidth - list.clientWidth;
            const tolerance = 6;

            // Show/hide prev button & left fade
            if (scrollLeft > tolerance) {
                wrap.classList.add('has-overflow-left');
                if (prevBtn) {
                    prevBtn.classList.add('is-visible');
                }
            } else {
                wrap.classList.remove('has-overflow-left');
                if (prevBtn) {
                    prevBtn.classList.remove('is-visible');
                }
            }

            // Show/hide next button & right fade
            if (maxScroll - scrollLeft > tolerance) {
                wrap.classList.add('has-overflow-right');
                nextBtn.classList.add('is-visible');
            } else {
                wrap.classList.remove('has-overflow-right');
                nextBtn.classList.remove('is-visible');
            }
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                list.scrollBy({ left: -260, behavior: 'smooth' });
            });
        }

        nextBtn.addEventListener('click', () => {
            nextBtn.classList.remove('pulse-hint');
            list.scrollBy({ left: 260, behavior: 'smooth' });
        });

        list.addEventListener('scroll', updateScrollState, { passive: true });
        window.addEventListener('resize', updateScrollState, { passive: true });

        // Initial check and attention pulse
        setTimeout(() => {
            updateScrollState();
            if (nextBtn.classList.contains('is-visible')) {
                nextBtn.classList.add('pulse-hint');
                setTimeout(() => nextBtn.classList.remove('pulse-hint'), 5500);
            }
        }, 150);
    }

    // Initializations
    initPublicationYearFilter();
    initSubnavDropdowns();
    initSubnavScrollHint();
    setupMobileDepartmentNav();
    setupRevealElements(document);
    initLabSliders();

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
