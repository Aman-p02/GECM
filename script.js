// Mobile Navigation Toggle
const hamburger = document.querySelector(".hamburger");
const navLinks = document.querySelector(".nav-links");

if (hamburger) {
    hamburger.addEventListener("click", () => {
        hamburger.classList.toggle("active");
        navLinks.classList.toggle("active");
    });
}

// Close menu when a link is clicked
document.querySelectorAll(".nav-links li a").forEach(n => n.addEventListener("click", () => {
    hamburger.classList.remove("active");
    navLinks.classList.remove("active");
}));

// Navbar Scroll Effect
const header = document.querySelector(".header");
window.addEventListener("scroll", () => {
    if (window.scrollY > 50) {
        header.style.boxShadow = "0 4px 15px rgba(0,0,0,0.1)";
        header.style.padding = "0";
    } else {
        header.style.boxShadow = "var(--shadow)";
        // Optional: restore padding if you change it above
    }
});

// Alumni Carousel Scrolling
const carousel = document.getElementById("alumniCarousel");
const leftBtn = document.querySelector(".left-btn");
const rightBtn = document.querySelector(".right-btn");

if (carousel && leftBtn && rightBtn) {
    leftBtn.addEventListener("click", () => {
        carousel.scrollBy({
            left: -300,
            behavior: 'smooth'
        });
    });

    rightBtn.addEventListener("click", () => {
        carousel.scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    });
}

// Recent Events Slider
const eventsSlider = document.getElementById("eventsSlider");
const sliderDotsContainer = document.getElementById("sliderDots");

if (eventsSlider && sliderDotsContainer) {
    const slides = document.querySelectorAll(".event-slide");
    const totalSlides = slides.length;
    let currentSlide = 0;
    
    // Generate Dots
    slides.forEach((_, index) => {
        const dot = document.createElement("span");
        dot.classList.add("dot");
        if(index === 0) dot.classList.add("active");
        dot.addEventListener("click", () => {
            goToSlide(index);
        });
        sliderDotsContainer.appendChild(dot);
    });
    
    const dots = document.querySelectorAll(".slider-dots .dot");
    
    function goToSlide(index) {
        currentSlide = index;
        eventsSlider.style.transform = `translateX(-${currentSlide * 100}%)`;
        
        // Update Dots
        dots.forEach(dot => dot.classList.remove("active"));
        if(dots[currentSlide]) dots[currentSlide].classList.add("active");
    }
    
    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        goToSlide(currentSlide);
    }
    
    // Auto scroll every 3 seconds
    let slideInterval = setInterval(nextSlide, 3000);
    
    // Pause on hover
    eventsSlider.parentElement.addEventListener("mouseenter", () => {
        clearInterval(slideInterval);
    });
    
    eventsSlider.parentElement.addEventListener("mouseleave", () => {
        slideInterval = setInterval(nextSlide, 3000);
    });
}

// Department Auto-Scroll on Mobile
const deptGrid = document.querySelector('.dept-grid');
let deptScrollInterval;

function startDeptAutoScroll() {
    if (deptGrid) {
        if (deptScrollInterval) clearInterval(deptScrollInterval);
        deptScrollInterval = setInterval(() => {
            // Card width + gap (15px)
            const scrollAmount = deptGrid.clientWidth + 15;
            if (deptGrid.scrollLeft + deptGrid.clientWidth >= deptGrid.scrollWidth - 20) {
                // Reset to beginning when it reaches the end
                deptGrid.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                deptGrid.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }, 3000); // Slide exactly one item every 3 seconds
    } else {
        if (deptScrollInterval) {
            clearInterval(deptScrollInterval);
            deptScrollInterval = null;
        }
    }
}

// Start auto-scroll and handle window resize
startDeptAutoScroll();
window.addEventListener('resize', startDeptAutoScroll);

// Pause auto-scroll when user interacts with it
if (deptGrid) {
    deptGrid.addEventListener('touchstart', () => clearInterval(deptScrollInterval));
    deptGrid.addEventListener('touchend', () => {
        setTimeout(startDeptAutoScroll, 2000); // Resume after 2 seconds
    });
}

// ==============================================================
// Hero Background Carousel
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

        // Toggle active class on slides
        heroSlides.forEach((slide, i) => {
            if (i === currentHeroIndex) {
                slide.classList.add("active");
            } else {
                slide.classList.remove("active");
            }
        });

        // Toggle active class on indicators
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
        heroTimer = setInterval(nextHeroSlide, 4500); // Rotate every 4.5 seconds
    }

    function stopHeroAutoplay() {
        if (heroTimer) {
            clearInterval(heroTimer);
            heroTimer = null;
        }
    }

    // Navigation buttons
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

    // Dot indicators
    heroDots.forEach(dot => {
        dot.addEventListener("click", (e) => {
            const idx = parseInt(e.currentTarget.getAttribute("data-index"), 10);
            if (!isNaN(idx)) {
                showHeroSlide(idx);
                startHeroAutoplay();
            }
        });
    });

    // Pause on hover
    if (heroSection) {
        heroSection.addEventListener("mouseenter", stopHeroAutoplay);
        heroSection.addEventListener("mouseleave", startHeroAutoplay);

        // Mobile touch swipe gesture support
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
                    nextHeroSlide(); // Swiped left -> next
                } else {
                    prevHeroSlide(); // Swiped right -> prev
                }
            }
            startHeroAutoplay();
        }, { passive: true });
    }

    // Initialize Autoplay
    startHeroAutoplay();
}

