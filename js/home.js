/**
 * Home page scripts for carousels, sliders, and notice board.
 */
document.addEventListener("DOMContentLoaded", () => {
    // ==============================================================
    // 1. Alumni Carousel Auto-Scroll
    // ==============================================================
    const alumniCarousel = document.getElementById("alumniCarousel");
    const alumniLeftBtn = document.getElementById("alumniLeftBtn") || document.querySelector(".alumni-wrapper .left-btn");
    const alumniRightBtn = document.getElementById("alumniRightBtn") || document.querySelector(".alumni-wrapper .right-btn");

    if (alumniCarousel) {
        const cards = Array.from(alumniCarousel.children);

        function checkAlumniOverflow() {
            const hasOverflow = alumniCarousel.scrollWidth > alumniCarousel.clientWidth + 5;
            if (!hasOverflow) {
                alumniCarousel.classList.add("no-overflow");
                if (alumniLeftBtn) alumniLeftBtn.style.display = "none";
                if (alumniRightBtn) alumniRightBtn.style.display = "none";
            } else {
                alumniCarousel.classList.remove("no-overflow");
                if (alumniLeftBtn) alumniLeftBtn.style.display = "flex";
                if (alumniRightBtn) alumniRightBtn.style.display = "flex";
            }
            return hasOverflow;
        }

        checkAlumniOverflow();
        window.addEventListener("resize", checkAlumniOverflow);

        let isAlumniPaused = false;
        let scrollDirection = 1; // 1: right, -1: left
        let alumniSpeed = 0.75;

        function autoScrollAlumni() {
            if (!isAlumniPaused && checkAlumniOverflow()) {
                alumniCarousel.scrollLeft += alumniSpeed * scrollDirection;
                const maxScroll = alumniCarousel.scrollWidth - alumniCarousel.clientWidth;
                if (alumniCarousel.scrollLeft >= maxScroll - 2) {
                    scrollDirection = -1;
                } else if (alumniCarousel.scrollLeft <= 2) {
                    scrollDirection = 1;
                }
            }
            requestAnimationFrame(autoScrollAlumni);
        }

        // Auto-scroll when overflow exists
        if (cards.length > 3) {
            requestAnimationFrame(autoScrollAlumni);
        }

        // Pause on hover and touch
        alumniCarousel.addEventListener("mouseenter", () => {
            isAlumniPaused = true;
        });

        alumniCarousel.addEventListener("mouseleave", () => {
            isAlumniPaused = false;
        });

        alumniCarousel.addEventListener("touchstart", () => {
            isAlumniPaused = true;
        }, { passive: true });

        alumniCarousel.addEventListener("touchend", () => {
            setTimeout(() => {
                isAlumniPaused = false;
            }, 2000);
        }, { passive: true });

        // Carousel controls
        if (alumniLeftBtn && alumniRightBtn) {
            alumniLeftBtn.addEventListener("click", () => {
                isAlumniPaused = true;
                const scrollAmount = 304; // Card width + gap
                alumniCarousel.scrollBy({ left: -scrollAmount, behavior: "smooth" });
                setTimeout(() => { isAlumniPaused = false; }, 2500);
            });

            alumniRightBtn.addEventListener("click", () => {
                isAlumniPaused = true;
                const scrollAmount = 304;
                alumniCarousel.scrollBy({ left: scrollAmount, behavior: "smooth" });
                setTimeout(() => { isAlumniPaused = false; }, 2500);
            });
        }
    }

    // ==============================================================
    // 2. Interactive Touch/Swipe & Auto Slider Helper
    // ==============================================================
    function setupSwipeableSlider(sliderId, dotsId, slideSelector, autoIntervalMs = 3500) {
        const slider = document.getElementById(sliderId);
        const dotsContainer = document.getElementById(dotsId);
        if (!slider) return;

        const slides = slider.querySelectorAll(slideSelector);
        const totalSlides = slides.length;
        if (totalSlides === 0) return;

        const container = slider.parentElement || slider;
        let currentSlide = 0;
        let autoTimer = null;
        let startX = 0;
        let startY = 0;
        let currentX = 0;
        let isDragging = false;
        let isHorizontalSwipe = null;
        let hasMovedSignificantly = false;
        const swipeThreshold = 40;

        // Generate Dots
        if (dotsContainer) {
            dotsContainer.innerHTML = "";
            slides.forEach((_, index) => {
                const dot = document.createElement("span");
                dot.classList.add("dot");
                if (index === 0) dot.classList.add("active");
                dot.setAttribute("role", "button");
                dot.setAttribute("aria-label", `Slide ${index + 1}`);
                dot.addEventListener("click", () => {
                    goToSlide(index);
                    restartAutoTimer();
                });
                dotsContainer.appendChild(dot);
            });
        }

        const dots = dotsContainer ? dotsContainer.querySelectorAll(".dot") : [];

        function updateDots() {
            dots.forEach((dot, index) => {
                dot.classList.toggle("active", index === currentSlide);
            });
        }

        function goToSlide(index, withTransition = true) {
            currentSlide = (index + totalSlides) % totalSlides;
            slider.style.transition = withTransition ? "transform 0.75s cubic-bezier(0.25, 1, 0.5, 1)" : "none";
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;
            updateDots();
        }

        function nextSlide() {
            goToSlide(currentSlide + 1);
        }

        function prevSlide() {
            goToSlide(currentSlide - 1);
        }

        function startAutoTimer() {
            if (totalSlides > 1 && !autoTimer) {
                autoTimer = setInterval(nextSlide, autoIntervalMs);
            }
        }

        function stopAutoTimer() {
            if (autoTimer) {
                clearInterval(autoTimer);
                autoTimer = null;
            }
        }

        function restartAutoTimer() {
            stopAutoTimer();
            startAutoTimer();
        }

        // Pointer / Touch / Mouse Drag Events
        function getClientX(e) {
            return e.touches && e.touches.length > 0 ? e.touches[0].clientX : e.clientX;
        }

        function getClientY(e) {
            return e.touches && e.touches.length > 0 ? e.touches[0].clientY : e.clientY;
        }

        function handleDragStart(e) {
            if (totalSlides <= 1) return;
            if (e.type === "mousedown" && e.button !== 0) return;

            isDragging = true;
            isHorizontalSwipe = null;
            hasMovedSignificantly = false;
            startX = getClientX(e);
            startY = getClientY(e);
            currentX = startX;

            stopAutoTimer();
            slider.style.transition = "none";
        }

        function handleDragMove(e) {
            if (!isDragging) return;

            const posX = getClientX(e);
            const posY = getClientY(e);
            const diffX = posX - startX;
            const diffY = posY - startY;

            // Determine gesture intent on initial movement
            if (isHorizontalSwipe === null) {
                if (Math.abs(diffX) > 6 || Math.abs(diffY) > 6) {
                    isHorizontalSwipe = Math.abs(diffX) >= Math.abs(diffY);
                }
            }

            if (!isHorizontalSwipe) {
                return; // Allow native vertical page scrolling
            }

            // Cancel vertical scroll while dragging slider
            if (e.cancelable && e.type.startsWith("touch")) {
                e.preventDefault();
            }

            if (Math.abs(diffX) > 8) {
                hasMovedSignificantly = true;
                container.classList.add("is-dragging");
            }

            currentX = posX;
            const containerWidth = container.offsetWidth || 1;
            const baseOffset = -currentSlide * 100;
            let dragPercent = (diffX / containerWidth) * 100;

            // Resistance on bounds
            if ((currentSlide === 0 && diffX > 0) || (currentSlide === totalSlides - 1 && diffX < 0)) {
                dragPercent *= 0.35;
            }

            slider.style.transform = `translateX(${baseOffset + dragPercent}%)`;
        }

        function handleDragEnd() {
            if (!isDragging) return;
            isDragging = false;
            container.classList.remove("is-dragging");

            const diffX = currentX - startX;

            if (isHorizontalSwipe && hasMovedSignificantly) {
                if (diffX < -swipeThreshold) {
                    // Swiped Left -> Next
                    if (currentSlide < totalSlides - 1) {
                        goToSlide(currentSlide + 1);
                    } else {
                        goToSlide(0);
                    }
                } else if (diffX > swipeThreshold) {
                    // Swiped Right -> Previous
                    if (currentSlide > 0) {
                        goToSlide(currentSlide - 1);
                    } else {
                        goToSlide(totalSlides - 1);
                    }
                } else {
                    // Snap back
                    goToSlide(currentSlide);
                }
            } else {
                goToSlide(currentSlide);
            }

            isHorizontalSwipe = null;
            hasMovedSignificantly = false;
            restartAutoTimer();
        }

        // Prevent ghost clicks on links when dragging
        container.addEventListener("click", (e) => {
            if (hasMovedSignificantly) {
                e.preventDefault();
                e.stopPropagation();
            }
        }, true);

        // Prevent dragging image elements
        container.querySelectorAll("img").forEach(img => {
            img.addEventListener("dragstart", (e) => e.preventDefault());
        });

        // Touch event listeners
        container.addEventListener("touchstart", handleDragStart, { passive: true });
        container.addEventListener("touchmove", handleDragMove, { passive: false });
        container.addEventListener("touchend", handleDragEnd);
        container.addEventListener("touchcancel", handleDragEnd);

        // Mouse event listeners for desktop hand-drag
        container.addEventListener("mousedown", handleDragStart);
        window.addEventListener("mousemove", handleDragMove);
        window.addEventListener("mouseup", handleDragEnd);

        // Pause on desktop mouse hover, resume on mouse leave
        container.addEventListener("mouseenter", () => {
            if (!isDragging) stopAutoTimer();
        });
        container.addEventListener("mouseleave", () => {
            if (!isDragging) startAutoTimer();
        });

        // Start initial auto slider
        startAutoTimer();
    }

    // Initialize Recent Events Slider (Touch/Swipe + Auto-slide)
    setupSwipeableSlider("eventsSlider", "sliderDots", ".event-slide", 5000);

    // Initialize Latest Shots Slider (Touch/Swipe + Auto-slide)
    setupSwipeableSlider("shotsSlider", "shotsSliderDots", ".shot-slide", 5500);

    // ==============================================================
    // 4. Department Carousel Controls
    // ==============================================================
    const deptGrid = document.getElementById("deptGrid");
    const deptLeftBtn = document.getElementById("deptLeftBtn");
    const deptRightBtn = document.getElementById("deptRightBtn");

    if (deptGrid) {
        if (deptLeftBtn && deptRightBtn) {
            deptLeftBtn.addEventListener("click", () => {
                const card = deptGrid.querySelector(".dept-card");
                const scrollDistance = card ? card.offsetWidth + 26 : 280;
                deptGrid.scrollBy({ left: -scrollDistance, behavior: "smooth" });
            });

            deptRightBtn.addEventListener("click", () => {
                const card = deptGrid.querySelector(".dept-card");
                const scrollDistance = card ? card.offsetWidth + 26 : 280;
                deptGrid.scrollBy({ left: scrollDistance, behavior: "smooth" });
            });
        }

        // Mobile active card peek & scale transition
        const updateActiveDeptCard = () => {
            if (window.innerWidth > 768) {
                deptGrid.querySelectorAll(".dept-card").forEach(c => c.classList.remove("is-active"));
                return;
            }
            const gridRect = deptGrid.getBoundingClientRect();
            const gridCenter = gridRect.left + gridRect.width / 2;
            const cards = deptGrid.querySelectorAll(".dept-card");
            let closestCard = null;
            let minDistance = Infinity;

            cards.forEach(card => {
                const cardRect = card.getBoundingClientRect();
                const cardCenter = cardRect.left + cardRect.width / 2;
                const distance = Math.abs(gridCenter - cardCenter);
                if (distance < minDistance) {
                    minDistance = distance;
                    closestCard = card;
                }
            });

            cards.forEach(card => {
                if (card === closestCard) {
                    card.classList.add("is-active");
                } else {
                    card.classList.remove("is-active");
                }
            });
        };

        deptGrid.addEventListener("scroll", updateActiveDeptCard, { passive: true });
        updateActiveDeptCard();
        window.addEventListener("resize", updateActiveDeptCard, { passive: true });
    }

    // ==============================================================
    // 5. Hero Background Carousel
    // ==============================================================
    const heroSection = document.getElementById("about");
    const heroSlides = document.querySelectorAll(".hero-slide");
    const heroDots = document.querySelectorAll(".hero-dot");
    const heroPrevBtn = document.getElementById("heroPrevBtn");
    const heroNextBtn = document.getElementById("heroNextBtn");

    if (heroSlides.length > 0) {
        let currentHeroIndex = 0;
        let heroTimer = null;

        function showHeroSlide(index) {
            if (index >= heroSlides.length) {
                currentHeroIndex = 0;
            } else if (index < 0) {
                currentHeroIndex = heroSlides.length - 1;
            } else {
                currentHeroIndex = index;
            }

            heroSlides.forEach((slide, i) => {
                if (i === currentHeroIndex) {
                    slide.classList.add("active");
                } else {
                    slide.classList.remove("active");
                }
            });

            heroDots.forEach((dot, i) => {
                if (i === currentHeroIndex) {
                    dot.classList.add("active");
                } else {
                    dot.classList.remove("active");
                }
            });
        }

        function nextHeroSlide() {
            showHeroSlide(currentHeroIndex + 1);
        }

        function prevHeroSlide() {
            showHeroSlide(currentHeroIndex - 1);
        }

        function startHeroAutoplay() {
            stopHeroAutoplay();
            heroTimer = setInterval(nextHeroSlide, 5000);
        }

        function stopHeroAutoplay() {
            if (heroTimer) {
                clearInterval(heroTimer);
                heroTimer = null;
            }
        }

        if (heroPrevBtn) {
            heroPrevBtn.addEventListener("click", () => {
                prevHeroSlide();
                startHeroAutoplay();
            });
            heroPrevBtn.addEventListener("mouseenter", stopHeroAutoplay);
            heroPrevBtn.addEventListener("mouseleave", startHeroAutoplay);
        }

        if (heroNextBtn) {
            heroNextBtn.addEventListener("click", () => {
                nextHeroSlide();
                startHeroAutoplay();
            });
            heroNextBtn.addEventListener("mouseenter", stopHeroAutoplay);
            heroNextBtn.addEventListener("mouseleave", startHeroAutoplay);
        }

        heroDots.forEach(dot => {
            dot.addEventListener("click", (e) => {
                const idx = parseInt(e.currentTarget.getAttribute("data-index"), 10);
                if (!isNaN(idx)) {
                    showHeroSlide(idx);
                    startHeroAutoplay();
                }
            });
            dot.addEventListener("mouseenter", stopHeroAutoplay);
            dot.addEventListener("mouseleave", startHeroAutoplay);
        } );

        if (heroSection) {
            let touchStartX = 0;
            let touchEndX = 0;

            heroSection.addEventListener("touchstart", (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            heroSection.addEventListener("touchend", (e) => {
                touchEndX = e.changedTouches[0].screenX;
                const diffX = touchStartX - touchEndX;

                if (Math.abs(diffX) > 40) {
                    if (diffX > 0) {
                        nextHeroSlide();
                    } else {
                        prevHeroSlide();
                    }
                }
                startHeroAutoplay();
            }, { passive: true });
        }

        startHeroAutoplay();
    }

    // ==============================================================
    // 6. Notice Board Marquee
    // ==============================================================
    const noticeContainer = document.querySelector(".notice-scroll-container");
    const noticeMarquee = document.querySelector(".notice-marquee");
    const noticeList = document.querySelector(".notice-list");

    if (noticeContainer && noticeMarquee && noticeList) {
        // Activate scrolling when items exceed container height
        if (noticeList.children.length > 4 && noticeList.offsetHeight > noticeContainer.offsetHeight) {
            const cloneList = noticeList.cloneNode(true);
            cloneList.setAttribute("aria-hidden", "true");
            noticeMarquee.appendChild(cloneList);
            noticeMarquee.classList.add("is-scrolling");
        } else {
            noticeMarquee.classList.remove("is-scrolling");
        }
    }
});
