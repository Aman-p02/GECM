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

// ==============================================================
// Facility Laboratory Image Slider & Real-Time Touch Gestures
// ==============================================================
function setLabSlide(slider, targetIndex, animate = true) {
    if (!slider) return;
    const slidesContainer = slider.querySelector('.dept-lab-slides');
    const slides = slider.querySelectorAll('.dept-lab-slide');
    const dots = slider.querySelectorAll('.dept-lab-dot');
    const counter = slider.querySelector('.dept-lab-slide-counter');
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

    if (counter) {
        counter.textContent = `${idx + 1} / ${total}`;
    }
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
    initLabLightbox();
}

// ==============================================================
// Facility Laboratory Full-Screen Lightbox / Image Viewer
// ==============================================================
let activeLightbox = null;

function ensureLightboxElement() {
    let lb = document.getElementById('deptLightbox');
    if (lb) return lb;

    lb = document.createElement('div');
    lb.id = 'deptLightbox';
    lb.className = 'dept-lightbox';
    lb.setAttribute('aria-hidden', 'true');
    lb.setAttribute('role', 'dialog');
    lb.setAttribute('aria-label', 'Laboratory Image Preview');

    lb.innerHTML = `
        <div class="dept-lightbox-backdrop" data-lb-action="close"></div>
        <div class="dept-lightbox-container">
            <button type="button" class="dept-lightbox-btn dept-lightbox-close" data-lb-action="close" aria-label="Close image preview">
                <i class="fas fa-times"></i>
            </button>
            <button type="button" class="dept-lightbox-btn dept-lightbox-prev" data-lb-action="prev" aria-label="Previous photo">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button type="button" class="dept-lightbox-btn dept-lightbox-next" data-lb-action="next" aria-label="Next photo">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="dept-lightbox-stage">
                <div class="dept-lightbox-figure">
                    <img class="dept-lightbox-img" src="" alt="" loading="eager">
                    <div class="dept-lightbox-info">
                        <span class="dept-lightbox-lab"></span>
                        <span class="dept-lightbox-divider">&bull;</span>
                        <span class="dept-lightbox-caption"></span>
                        <span class="dept-lightbox-counter"></span>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(lb);

    // Event delegation for lightbox buttons
    lb.addEventListener('click', e => {
        const actionBtn = e.target.closest('[data-lb-action]');
        if (!actionBtn) return;
        const action = actionBtn.getAttribute('data-lb-action');
        if (action === 'close') {
            closeLabLightbox();
        } else if (action === 'prev') {
            navigateLightbox(-1);
        } else if (action === 'next') {
            navigateLightbox(1);
        }
    });

    // Touch swipe inside lightbox on mobile
    let touchStartX = 0;
    let touchEndX = 0;
    let touchStartY = 0;
    let touchEndY = 0;

    lb.addEventListener('touchstart', e => {
        if (e.touches && e.touches.length === 1) {
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
            touchEndX = touchStartX;
            touchEndY = touchStartY;
        }
    }, { passive: true });

    lb.addEventListener('touchmove', e => {
        if (e.touches && e.touches.length === 1) {
            touchEndX = e.touches[0].clientX;
            touchEndY = e.touches[0].clientY;
        }
    }, { passive: true });

    lb.addEventListener('touchend', () => {
        const diffX = touchEndX - touchStartX;
        const diffY = touchEndY - touchStartY;
        if (Math.abs(diffX) > 40 && Math.abs(diffX) > Math.abs(diffY)) {
            if (diffX < 0) {
                navigateLightbox(1); // Swipe left -> next image
            } else {
                navigateLightbox(-1); // Swipe right -> prev image
            }
        }
    }, { passive: true });

    return lb;
}

function openLabLightbox(frame, clickedIndex = 0) {
    const card = frame.closest('.dept-lab-card');
    const labTitle = card ? (card.querySelector('.dept-lab-title')?.textContent.trim() || '') : '';
    const slides = frame.querySelectorAll('.dept-lab-slide');
    const items = [];

    if (slides.length > 0) {
        slides.forEach(slide => {
            const img = slide.querySelector('img');
            const cap = slide.querySelector('.dept-lab-slide-caption');
            if (img) {
                items.push({
                    src: img.getAttribute('src') || img.src,
                    alt: img.getAttribute('alt') || '',
                    caption: cap ? cap.textContent.trim() : (img.getAttribute('alt') || '')
                });
            }
        });
    } else {
        const img = frame.querySelector('img');
        if (img) {
            items.push({
                src: img.getAttribute('src') || img.src,
                alt: img.getAttribute('alt') || '',
                caption: img.getAttribute('alt') || labTitle
            });
        }
    }

    if (!items.length) return;

    const lb = ensureLightboxElement();
    const safeIndex = Math.max(0, Math.min(clickedIndex, items.length - 1));

    activeLightbox = {
        frame,
        items,
        currentIndex: safeIndex,
        labTitle
    };

    updateLightboxView();

    lb.classList.add('is-open');
    lb.setAttribute('aria-hidden', 'false');
    document.body.classList.add('dept-lightbox-locked');

    window.addEventListener('keydown', handleLightboxKeydown);
}

function updateLightboxView() {
    if (!activeLightbox) return;
    const { items, currentIndex, labTitle } = activeLightbox;
    const item = items[currentIndex];
    if (!item) return;

    const lb = document.getElementById('deptLightbox');
    if (!lb) return;

    const imgEl = lb.querySelector('.dept-lightbox-img');
    const labEl = lb.querySelector('.dept-lightbox-lab');
    const capEl = lb.querySelector('.dept-lightbox-caption');
    const counterEl = lb.querySelector('.dept-lightbox-counter');
    const prevBtn = lb.querySelector('.dept-lightbox-prev');
    const nextBtn = lb.querySelector('.dept-lightbox-next');

    // Smooth image load fade
    imgEl.style.opacity = '0.35';
    imgEl.onload = () => {
        imgEl.style.opacity = '1';
    };
    imgEl.src = item.src;
    imgEl.alt = item.alt || item.caption || labTitle;

    if (labEl) labEl.textContent = labTitle;
    if (capEl) capEl.textContent = item.caption || item.alt || '';

    if (items.length > 1) {
        if (counterEl) {
            counterEl.textContent = `${currentIndex + 1} / ${items.length}`;
            counterEl.style.display = 'block';
        }
        if (prevBtn) prevBtn.classList.remove('is-hidden');
        if (nextBtn) nextBtn.classList.remove('is-hidden');
    } else {
        if (counterEl) counterEl.style.display = 'none';
        if (prevBtn) prevBtn.classList.add('is-hidden');
        if (nextBtn) nextBtn.classList.add('is-hidden');
    }

    // Sync card slider underneath
    if (activeLightbox.frame && activeLightbox.frame.classList.contains('dept-lab-slider')) {
        setLabSlide(activeLightbox.frame, currentIndex);
    }
}

function navigateLightbox(direction) {
    if (!activeLightbox || activeLightbox.items.length <= 1) return;
    const total = activeLightbox.items.length;
    let nextIndex = activeLightbox.currentIndex + direction;
    if (nextIndex < 0) nextIndex = total - 1;
    if (nextIndex >= total) nextIndex = 0;
    activeLightbox.currentIndex = nextIndex;
    updateLightboxView();
}

function closeLabLightbox() {
    const lb = document.getElementById('deptLightbox');
    if (lb) {
        lb.classList.remove('is-open');
        lb.setAttribute('aria-hidden', 'true');
    }
    document.body.classList.remove('dept-lightbox-locked');
    window.removeEventListener('keydown', handleLightboxKeydown);
    activeLightbox = null;
}

function handleLightboxKeydown(e) {
    if (!activeLightbox) return;
    if (e.key === 'Escape') {
        e.preventDefault();
        closeLabLightbox();
    } else if (e.key === 'ArrowLeft') {
        e.preventDefault();
        navigateLightbox(-1);
    } else if (e.key === 'ArrowRight') {
        e.preventDefault();
        navigateLightbox(1);
    }
}

function initLabLightbox() {
    ensureLightboxElement();
    const frames = document.querySelectorAll('.dept-lab-image-frame');
    frames.forEach(frame => {
        // Inject subtle zoom hint icon if not already added
        if (!frame.querySelector('.dept-lab-zoom-hint')) {
            const hint = document.createElement('span');
            hint.className = 'dept-lab-zoom-hint';
            hint.setAttribute('aria-hidden', 'true');
            hint.setAttribute('title', 'Click to view photo large');
            hint.innerHTML = '<i class="fas fa-search-plus"></i>';
            frame.appendChild(hint);
        }

        // Attach click listener for opening lightbox
        if (!frame._lbClickBound) {
            frame._lbClickBound = true;
            frame.addEventListener('click', e => {
                if (e.target.closest('.dept-lab-slide-nav') || e.target.closest('.dept-lab-dot')) {
                    return;
                }
                if (frame._justSwiped) {
                    return;
                }
                const currentSlide = parseInt(frame.getAttribute('data-current-slide') || '0', 10);
                openLabLightbox(frame, currentSlide);
            });
        }
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
        if (tabId === 'faculty' || tabId === 'activities') {
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

        if (tabId === 'facilities') {
            initLabSliders();
        }

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
            // Allow anchor links with valid href (e.g. GTU syllabus portal) to navigate normally
            if (this.tagName === 'A' && this.getAttribute('href') && this.getAttribute('href') !== '#') {
                return;
            }

            const tabId = this.getAttribute('data-tab');
            if (tabId && tabId !== 'faculty' && tabId !== 'activities') {
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
