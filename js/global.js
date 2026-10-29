/**
 * GECM Global JavaScript
 * Handles site-wide navigation toggle and navbar scroll effects.
 * Supports both new (.hdr-*) and legacy (.hamburger / .nav-links) class names.
 */
document.addEventListener("DOMContentLoaded", () => {

    // ── Mobile Navigation Toggle ───────────────────────────────────────────
    // New header classes
    const hdrHamburger = document.getElementById("hamburgerBtn");
    const hdrNavList   = document.getElementById("mainNavLinks");

    // Legacy fallback classes (used in department sub-pages that still render old HTML)
    const legacyHamburger = document.querySelector(".hamburger:not(#hamburgerBtn)");
    const legacyNavLinks  = document.querySelector(".nav-links");

    function toggleNav(btn, list, openClass) {
        if (!btn || !list) return;
        const isOpen = list.classList.contains(openClass);
        list.classList.toggle(openClass, !isOpen);
        btn.setAttribute("aria-expanded", String(!isOpen));

        // Close when any nav link is clicked
        list.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", () => {
                list.classList.remove(openClass);
                btn.setAttribute("aria-expanded", "false");
                if (btn.classList.contains("active")) btn.classList.remove("active");
            }, { once: true });
        });
    }

    // New hamburger (renders from updated header.php)
    if (hdrHamburger && hdrNavList) {
        hdrHamburger.addEventListener("click", () => {
            toggleNav(hdrHamburger, hdrNavList, "is-open");
        });
    }

    // Legacy hamburger (for sub-pages that haven't refreshed the HTML yet)
    if (legacyHamburger && legacyNavLinks) {
        legacyHamburger.addEventListener("click", () => {
            legacyHamburger.classList.toggle("active");
            legacyNavLinks.classList.toggle("active");
        });
        legacyNavLinks.querySelectorAll("li a").forEach(link => {
            link.addEventListener("click", () => {
                legacyHamburger.classList.remove("active");
                legacyNavLinks.classList.remove("active");
            });
        });
    }

    // Close nav on outside click (both variants)
    document.addEventListener("click", (e) => {
        if (hdrHamburger && hdrNavList && hdrNavList.classList.contains("is-open")) {
            if (!hdrHamburger.contains(e.target) && !hdrNavList.contains(e.target)) {
                hdrNavList.classList.remove("is-open");
                hdrHamburger.setAttribute("aria-expanded", "false");
            }
        }
        if (legacyHamburger && legacyNavLinks && legacyNavLinks.classList.contains("active")) {
            if (!legacyHamburger.contains(e.target) && !legacyNavLinks.contains(e.target)) {
                legacyHamburger.classList.remove("active");
                legacyNavLinks.classList.remove("active");
            }
        }
    });

    // ── Constant Sticky Navbar Controller ───────────────────────────────────
    // When the user scrolls down, only the logo/brand row scrolls away.
    // The navbar stays constant and permanently fixed at the top of the viewport.
    const stickyNav = document.getElementById("mainNavbar") || document.querySelector(".hdr-nav") || document.querySelector(".navbar");
    const brandRow  = document.querySelector(".hdr-brand") || document.querySelector(".site-header") || document.querySelector(".logo-container");

    if (stickyNav) {
        // Invisible placeholder element so page content doesn't jump when navbar is fixed
        const navPlaceholder = document.createElement("div");
        navPlaceholder.id = "stickyNavPlaceholder";
        navPlaceholder.style.display = "none";
        stickyNav.parentNode.insertBefore(navPlaceholder, stickyNav);

        function updateStickyNav() {
            let threshold = 80;
            if (brandRow) {
                // Calculate position relative to document top
                const brandRect = brandRow.getBoundingClientRect();
                threshold = window.scrollY + brandRect.bottom;
            }

            if (window.scrollY >= threshold) {
                if (!stickyNav.classList.contains("is-sticky-fixed")) {
                    navPlaceholder.style.height = `${stickyNav.offsetHeight}px`;
                    navPlaceholder.style.display = "block";
                    stickyNav.classList.add("is-sticky-fixed");
                }
            } else {
                if (stickyNav.classList.contains("is-sticky-fixed")) {
                    stickyNav.classList.remove("is-sticky-fixed");
                    navPlaceholder.style.display = "none";
                }
            }
        }

        window.addEventListener("scroll", updateStickyNav, { passive: true });
        window.addEventListener("resize", () => {
            if (stickyNav.classList.contains("is-sticky-fixed")) {
                navPlaceholder.style.height = `${stickyNav.offsetHeight}px`;
            }
        });
        // Initial run
        updateStickyNav();
    }
});
