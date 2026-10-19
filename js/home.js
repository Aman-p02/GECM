/**
 * GECM Home Page JavaScript
 * Handles:
 * 1. Hero Background Carousel (autoplay, arrows, dots, touch swipe)
 * 2. Recent Events Slider
 * 3. Latest Shots Carousel
 * 4. Department auto-scroll on mobile
 * 5. Alumni Carousel scroll buttons
 */
document.addEventListener("DOMContentLoaded", () => {
    // ==============================================================
    // 1. Alumni Carousel Scrolling
    // ==============================================================
    const carousel = document.getElementById("alumniCarousel");
    const leftBtn = document.querySelector(".left-btn");
    const rightBtn = document.querySelector(".right-btn");

    if (carousel && leftBtn && rightBtn) {
        leftBtn.addEventListener("click", () => {
            carousel.scrollBy({ left: -300, behavior: "smooth" });
        });

        rightBtn.addEventListener("click", () => {
            carousel.scrollBy({ left: 300, behavior: "smooth" });
        });
    }

    // ==============================================================
    // 2. Recent Events Slider
    // ==============================================================
    const eventsSlider = document.getElementById("eventsSlider");
    const sliderDotsContainer = document.getElementById("sliderDots");

    if (eventsSlider && sliderDotsContainer) {
        const slides = eventsSlider.querySelectorAll(".event-slide");
        const totalSlides = slides.length;
        let currentSlide = 0;

        // Generate Dots
        slides.forEach((_, index) => {
            const dot = document.createElement("span");
            dot.classList.add("dot");
            if (index === 0) dot.classList.add("active");
            dot.addEventListener("click", () => {
                goToSlide(index);
            });
            sliderDotsContainer.appendChild(dot);
        });

        const dots = sliderDotsContainer.querySelectorAll(".dot");

        function goToSlide(index) {
            currentSlide = index;
            eventsSlider.style.transform = `translateX(-${currentSlide * 100}%)`;
            dots.forEach(dot => dot.classList.remove("active"));
            if (dots[currentSlide]) dots[currentSlide].classList.add("active");
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            goToSlide(currentSlide);
        }

        let slideInterval = setInterval(nextSlide, 3000);

        if (eventsSlider.parentElement) {
            eventsSlider.parentElement.addEventListener("mouseenter", () => {
                clearInterval(slideInterval);
            });

            eventsSlider.parentElement.addEventListener("mouseleave", () => {
                slideInterval = setInterval(nextSlide, 3000);
            });
        }
    }

    // ==============================================================
    // 3. Latest Shots Slider
    // ==============================================================
    const shotsSlider = document.getElementById("shotsSlider");
    const shotsSliderDotsContainer = document.getElementById("shotsSliderDots");

    if (shotsSlider && shotsSliderDotsContainer) {
        const shotSlides = shotsSlider.querySelectorAll(".shot-slide");
        const totalShotSlides = shotSlides.length;
        let currentShotSlide = 0;

        // Generate Dots
        shotSlides.forEach((_, index) => {
            const dot = document.createElement("span");
            dot.classList.add("dot");
            if (index === 0) dot.classList.add("active");
            dot.addEventListener("click", () => {
                goToShotSlide(index);
            });
            shotsSliderDotsContainer.appendChild(dot);
        });

        const shotDots = shotsSliderDotsContainer.querySelectorAll(".dot");

        function goToShotSlide(index) {
            currentShotSlide = index;
            shotsSlider.style.transform = `translateX(-${currentShotSlide * 100}%)`;
            shotDots.forEach(dot => dot.classList.remove("active"));
            if (shotDots[currentShotSlide]) shotDots[currentShotSlide].classList.add("active");
        }

        function nextShotSlide() {
            currentShotSlide = (currentShotSlide + 1) % totalShotSlides;
            goToShotSlide(currentShotSlide);
        }

        let shotSlideInterval = setInterval(nextShotSlide, 3500);

        if (shotsSlider.parentElement) {
            shotsSlider.parentElement.addEventListener("mouseenter", () => {
                clearInterval(shotSlideInterval);
            });

            shotsSlider.parentElement.addEventListener("mouseleave", () => {
                shotSlideInterval = setInterval(nextShotSlide, 3500);
            });
        }
    }

    // ==============================================================
    // 4. Department Auto-Scroll on Mobile
    // ==============================================================
    const deptGrid = document.querySelector(".dept-grid");
    let deptScrollInterval;

    function startDeptAutoScroll() {
        if (deptGrid) {
            if (deptScrollInterval) clearInterval(deptScrollInterval);
            deptScrollInterval = setInterval(() => {
                const scrollAmount = deptGrid.clientWidth + 15;
                if (deptGrid.scrollLeft + deptGrid.clientWidth >= deptGrid.scrollWidth - 20) {
                    deptGrid.scrollTo({ left: 0, behavior: "smooth" });
                } else {
                    deptGrid.scrollBy({ left: scrollAmount, behavior: "smooth" });
                }
            }, 3000);
        }
    }

    startDeptAutoScroll();
    window.addEventListener("resize", startDeptAutoScroll);

    if (deptGrid) {
        deptGrid.addEventListener("touchstart", () => clearInterval(deptScrollInterval));
        deptGrid.addEventListener("touchend", () => {
            setTimeout(startDeptAutoScroll, 2000);
        });
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
            heroTimer = setInterval(nextHeroSlide, 4500);
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
        }

        if (heroNextBtn) {
            heroNextBtn.addEventListener("click", () => {
                nextHeroSlide();
                startHeroAutoplay();
            });
        }

        heroDots.forEach(dot => {
            dot.addEventListener("click", (e) => {
                const idx = parseInt(e.currentTarget.getAttribute("data-index"), 10);
                if (!isNaN(idx)) {
                    showHeroSlide(idx);
                    startHeroAutoplay();
                }
            });
        });

        if (heroSection) {
            heroSection.addEventListener("mouseenter", stopHeroAutoplay);
            heroSection.addEventListener("mouseleave", startHeroAutoplay);

            let touchStartX = 0;
            let touchEndX = 0;

            heroSection.addEventListener("touchstart", (e) => {
                touchStartX = e.changedTouches[0].screenX;
                stopHeroAutoplay();
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
});
