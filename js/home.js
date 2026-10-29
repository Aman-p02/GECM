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
    // 3. Gallery Slider
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
            heroTimer = setInterval(nextHeroSlide, 3000);
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
