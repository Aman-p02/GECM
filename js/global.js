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

    // Dropdown Toggles: Desktop click-to-toggle (open/close) & Mobile Accordion
    const dropdownToggles = document.querySelectorAll(".hdr-nav-item.has-dropdown > .hdr-nav-link");
    dropdownToggles.forEach(toggleLink => {
        toggleLink.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            const parentItem = this.closest(".hdr-nav-item");
            if (!parentItem) return;

            // Mobile In-Place Accordion (<= 768px)
            if (window.innerWidth <= 768) {
                const isOpen = parentItem.classList.contains("is-sub-open");
                document.querySelectorAll(".hdr-nav-item.has-dropdown.is-sub-open").forEach(item => {
                    if (item !== parentItem) item.classList.remove("is-sub-open");
                });
                parentItem.classList.toggle("is-sub-open", !isOpen);
                return;
            }

            // Desktop Click Toggle (> 768px)
            const dropdown = parentItem.querySelector(".hdr-dropdown");
            let isCurrentlyOpen = false;

            if (parentItem.classList.contains("is-desktop-open")) {
                isCurrentlyOpen = true;
            } else if (!parentItem.classList.contains("is-desktop-closed") && dropdown) {
                const style = window.getComputedStyle(dropdown);
                if (style.visibility === "visible" && parseFloat(style.opacity) > 0.5) {
                    isCurrentlyOpen = true;
                }
            }

            // Close all other dropdowns
            document.querySelectorAll(".hdr-nav-item.has-dropdown").forEach(item => {
                if (item !== parentItem) {
                    item.classList.remove("is-desktop-open");
                    item.classList.add("is-desktop-closed");
                }
            });

            if (isCurrentlyOpen) {
                // If already open, clicking closes it
                parentItem.classList.remove("is-desktop-open");
                parentItem.classList.add("is-desktop-closed");
                this.blur();
            } else {
                // If closed, clicking opens it
                parentItem.classList.remove("is-desktop-closed");
                parentItem.classList.add("is-desktop-open");
            }
        });
    });

    // Reset desktop closed/open override on mouse leave
    document.querySelectorAll(".hdr-nav-item.has-dropdown").forEach(item => {
        item.addEventListener("mouseleave", function () {
            if (window.innerWidth > 768) {
                this.classList.remove("is-desktop-open", "is-desktop-closed");
            }
        });
    });

    document.querySelectorAll(".hdr-dd-link").forEach(subLink => {
        subLink.addEventListener("click", () => {
            // Close desktop dropdowns
            document.querySelectorAll(".hdr-nav-item.has-dropdown").forEach(item => {
                item.classList.remove("is-desktop-open");
                item.classList.add("is-desktop-closed");
            });

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
        // Desktop dropdown dismissal on outside click
        if (!e.target.closest(".hdr-nav-item.has-dropdown")) {
            document.querySelectorAll(".hdr-nav-item.has-dropdown").forEach(item => {
                item.classList.remove("is-desktop-open", "is-desktop-closed");
            });
        }

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

    // Reset any active states first
    allNavLinks.forEach(item => item.classList.remove("is-active", "active"));

    // Check for exact match on page load
    allNavLinks.forEach(link => {
        const href = link.getAttribute("href");
        if (!href || href === "#" || href.startsWith("javascript:")) return;

        try {
            const linkUrl = new URL(link.href, window.location.origin);
            const linkPath = linkUrl.pathname.replace(/\/$/, "");

            // 1. If browser URL has a hash (#about), match only that specific hash
            if (currentHash && linkUrl.hash) {
                if (linkUrl.hash === currentHash && (linkPath === currentPath || !linkUrl.pathname)) {
                    link.classList.add("is-active");
                }
            }
            // 2. If it's a dedicated subpage (e.g. /departments/computer/)
            else if (!linkUrl.hash && linkPath) {
                const isHomePath = (linkPath === "" || linkPath === "/GECM-main" || linkPath.endsWith("/index.php") || linkPath.endsWith("/index.html"));
                if (!isHomePath && linkPath === currentPath) {
                    link.classList.add("is-active");
                    const parentDropdown = link.closest(".hdr-nav-item.has-dropdown");
                    if (parentDropdown && window.innerWidth <= 768) {
                        parentDropdown.classList.add("is-sub-open");
                    }
                }
            }
        } catch (err) {}
    });

    allNavLinks.forEach(link => {
        link.addEventListener("click", function () {
            // Dropdown menu toggle links (e.g. Academic, Departments, Activities) should not get active underline on click
            if (this.closest(".has-dropdown") && this.classList.contains("hdr-nav-link")) {
                return;
            }
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
