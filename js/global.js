/**
 * Global scripts for site navigation and sticky header.
 */
document.addEventListener("DOMContentLoaded", () => {

    // Mobile Navigation Toggle
    const hdrHamburger = document.getElementById("hamburgerBtn");
    const hdrNavList   = document.getElementById("mainNavLinks");
    const legacyHamburger = document.querySelector(".hamburger:not(#hamburgerBtn)");
    const legacyNavLinks  = document.querySelector(".nav-links");

    function resetMobileSubpanels() {
        document.querySelectorAll(".hdr-nav-item.has-dropdown.is-sub-open").forEach(item => {
            item.classList.remove("is-sub-open");
        });
    }

    function toggleNav(btn, list, openClass) {
        if (!btn || !list) return;
        const isOpen = list.classList.contains(openClass);
        list.classList.toggle(openClass, !isOpen);
        btn.setAttribute("aria-expanded", String(!isOpen));
        btn.classList.toggle("is-active", !isOpen);

        if (isOpen) {
            resetMobileSubpanels();
        }

        list.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", () => {
                if (window.innerWidth <= 768 && link.closest(".has-dropdown") && link.classList.contains("hdr-nav-link")) {
                    return;
                }
                list.classList.remove(openClass);
                btn.setAttribute("aria-expanded", "false");
                btn.classList.remove("is-active");
                if (btn.classList.contains("active")) btn.classList.remove("active");
                resetMobileSubpanels();
            });
        });
    }

    // Mobile In-Place Accordion Submenu Toggle (opens directly underneath)
    const dropdownToggles = document.querySelectorAll(".hdr-nav-item.has-dropdown > .hdr-nav-link");
    dropdownToggles.forEach(toggleLink => {
        toggleLink.addEventListener("click", function (e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                e.stopPropagation();
                const parentItem = this.closest(".hdr-nav-item");
                const isOpen = parentItem.classList.contains("is-sub-open");

                // Collapse other open dropdowns for a clean accordion flow
                document.querySelectorAll(".hdr-nav-item.has-dropdown.is-sub-open").forEach(item => {
                    if (item !== parentItem) item.classList.remove("is-sub-open");
                });

                parentItem.classList.toggle("is-sub-open", !isOpen);
            }
        });
    });

    document.querySelectorAll(".hdr-dd-link").forEach(subLink => {
        subLink.addEventListener("click", () => {
            if (window.innerWidth <= 768 && hdrHamburger && hdrNavList) {
                hdrNavList.classList.remove("is-open");
                hdrHamburger.setAttribute("aria-expanded", "false");
                hdrHamburger.classList.remove("is-active");
                resetMobileSubpanels();
            }
        });
    });

    if (hdrHamburger && hdrNavList) {
        hdrHamburger.addEventListener("click", () => {
            toggleNav(hdrHamburger, hdrNavList, "is-open");
        });
    }

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

    // Dismiss menu on outside click
    document.addEventListener("click", (e) => {
        if (hdrHamburger && hdrNavList && hdrNavList.classList.contains("is-open")) {
            if (!hdrHamburger.contains(e.target) && !hdrNavList.contains(e.target)) {
                hdrNavList.classList.remove("is-open");
                hdrHamburger.setAttribute("aria-expanded", "false");
                hdrHamburger.classList.remove("is-active");
                resetMobileSubpanels();
            }
        }
        if (legacyHamburger && legacyNavLinks && legacyNavLinks.classList.contains("active")) {
            if (!legacyHamburger.contains(e.target) && !legacyNavLinks.contains(e.target)) {
                legacyHamburger.classList.remove("active");
                legacyNavLinks.classList.remove("active");
            }
        }
    });

    // Navigation link active & click state (Main nav + sub-options)
    const allNavLinks = document.querySelectorAll(".hdr-nav-link, .hdr-dd-link, .nav-links li a");
    const currentPath = window.location.pathname.replace(/\/$/, "");
    const currentHash = window.location.hash;

    allNavLinks.forEach(link => {
        const href = link.getAttribute("href");
        if (href && href !== "#") {
            try {
                const linkUrl = new URL(link.href, window.location.origin);
                const linkPath = linkUrl.pathname.replace(/\/$/, "");
                if (linkPath && linkPath === currentPath && (currentHash === "" || linkUrl.hash === currentHash)) {
                    link.classList.add("is-active");
                    const parentDropdown = link.closest(".hdr-nav-item.has-dropdown");
                    if (parentDropdown && window.innerWidth <= 768) {
                        parentDropdown.classList.add("is-sub-open");
                    }
                }
            } catch (err) {}
        }

        link.addEventListener("click", function () {
            allNavLinks.forEach(item => item.classList.remove("is-active", "active"));
            this.classList.add("is-active");
        });
    });

    // Sticky Navigation Controller
    const stickyNav = document.getElementById("mainNavbar") || document.querySelector(".hdr-nav") || document.querySelector(".navbar");
    const brandRow  = document.querySelector(".hdr-brand") || document.querySelector(".site-header") || document.querySelector(".logo-container");

    if (stickyNav) {
        const navPlaceholder = document.createElement("div");
        navPlaceholder.id = "stickyNavPlaceholder";
        navPlaceholder.style.display = "none";
        stickyNav.parentNode.insertBefore(navPlaceholder, stickyNav);

        function updateStickyNav() {
            let threshold = 80;
            if (brandRow) {
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

        updateStickyNav();
    }
});
