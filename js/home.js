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
    // 1. Alumni Carousel Butter Smooth Infinite Auto-Scrolling (60 FPS)
    // ==============================================================
    const alumniCarousel = document.getElementById("alumniCarousel");
    const alumniLeftBtn = document.getElementById("alumniLeftBtn") || document.querySelector(".alumni-wrapper .left-btn");
    const alumniRightBtn = document.getElementById("alumniRightBtn") || document.querySelector(".alumni-wrapper .right-btn");

    if (alumniCarousel) {
        // Clone cards once to form an infinite seamless wrap
        const originalAlumniCards = Array.from(alumniCarousel.children);
        originalAlumniCards.forEach(card => {
            const clone = card.cloneNode(true);
            clone.setAttribute("aria-hidden", "true");
            alumniCarousel.appendChild(clone);
        });

        let isAlumniPaused = false;
        let alumniSpeed = 0.85; // Continuous butter-smooth pixel advancement
        let alumniRafId = null;

        function autoScrollAlumni() {
            if (!isAlumniPaused) {
                alumniCarousel.scrollLeft += alumniSpeed;
                const halfWidth = alumniCarousel.scrollWidth / 2;
                if (alumniCarousel.scrollLeft >= halfWidth) {
                    alumniCarousel.scrollLeft -= halfWidth;
                } else if (alumniCarousel.scrollLeft <= 0) {
                    alumniCarousel.scrollLeft += halfWidth;
                }
            }
            alumniRafId = requestAnimationFrame(autoScrollAlumni);
        }

        alumniRafId = requestAnimationFrame(autoScrollAlumni);

        // Pause on mouse hover & mobile touch
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
            }, 1800);
        }, { passive: true });

        // Left / Right Scroll Buttons
        if (alumniLeftBtn && alumniRightBtn) {
            alumniLeftBtn.addEventListener("click", () => {
                isAlumniPaused = true;
                const scrollAmount = 304; // Card width + gap
                alumniCarousel.scrollBy({ left: -scrollAmount, behavior: "smooth" });
                setTimeout(() => { isAlumniPaused = false; }, 2200);
            });

            alumniRightBtn.addEventListener("click", () => {
                isAlumniPaused = true;
                const scrollAmount = 304;
                alumniCarousel.scrollBy({ left: scrollAmount, behavior: "smooth" });
                setTimeout(() => { isAlumniPaused = false; }, 2200);
            });
        }
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
    // 4. Department Section Desktop Smooth Controls
    // ==============================================================
    const deptGrid = document.getElementById("deptGrid");
    const deptLeftBtn = document.getElementById("deptLeftBtn");
    const deptRightBtn = document.getElementById("deptRightBtn");

    if (deptGrid && deptLeftBtn && deptRightBtn) {
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
