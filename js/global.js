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
        } else {
            // Opening menu: auto-expand active section dropdown if present
            const activeSubLink = list.querySelector(".hdr-dd-link.is-active");
            if (activeSubLink) {
                const parent = activeSubLink.closest(".hdr-nav-item.has-dropdown");
                if (parent) parent.classList.add("is-sub-open");
            }
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

    // Global Mobile Department Navigation Integration (Replaces main navbar on mobile <= 768px with Dept Menu + Home)
    function initGlobalDepartmentNav() {
        const deptSubNav = document.getElementById("deptSubNav") || document.querySelector(".dept-subnav-bar");
        if (!deptSubNav) return;

        const mainNavList = document.getElementById("mainNavLinks");
        const hamburgerBtn = document.getElementById("hamburgerBtn");
        if (!mainNavList || !hamburgerBtn) return;

        let defaultNavHtml = null;

        function buildDeptNav() {
            const subnavItems = deptSubNav.querySelectorAll(".dept-subnav-list > li");
            let html = `
                <li class="hdr-nav-item">
                    <a href="../../index.php" class="hdr-nav-link dept-home-nav-link">
                        Home
                    </a>
                </li>
            `;

            subnavItems.forEach(item => {
                const dropdownToggle = item.querySelector(".dept-dropdown-toggle");
                const dropdownMenu = item.querySelector(".dept-subnav-menu");

                if (dropdownToggle && dropdownMenu) {
                    const toggleText = (dropdownToggle.querySelector("span")?.textContent || dropdownToggle.textContent || "").trim();
                    const menuLinks = dropdownMenu.querySelectorAll(".dept-subnav-menu-link, a");

                    let subLinksHtml = "";
                    menuLinks.forEach(subLink => {
                        const tabId = subLink.getAttribute("data-tab") || "";
                        const rowId = subLink.getAttribute("data-row-id") || "";
                        const text = subLink.textContent.trim();
                        subLinksHtml += `<li><a href="javascript:void(0);" class="hdr-dd-link" data-tab="${tabId}" data-row-id="${rowId}">${text}</a></li>`;
                    });

                    html += `
                        <li class="hdr-nav-item has-dropdown">
                            <a href="javascript:void(0);" class="hdr-nav-link">
                                ${toggleText} <i class="fas fa-chevron-down hdr-arrow"></i>
                            </a>
                            <div class="hdr-dropdown">
                                <ul class="hdr-dd-list">
                                    ${subLinksHtml}
                                </ul>
                            </div>
                        </li>
                    `;
                } else {
                    const linkOrBtn = item.querySelector(".dept-subnav-link");
                    if (!linkOrBtn) return;

                    const isLink = linkOrBtn.tagName === "A";
                    const href = linkOrBtn.getAttribute("href");
                    const dataTab = linkOrBtn.getAttribute("data-tab");
                    const text = (linkOrBtn.querySelector("span")?.textContent || linkOrBtn.textContent || "").trim();

                    if (isLink && href && href !== "#") {
                        const target = linkOrBtn.getAttribute("target") || "_self";
                        html += `
                            <li class="hdr-nav-item">
                                <a href="${href}" target="${target}" rel="noopener noreferrer" class="hdr-nav-link dept-ext-nav-link">
                                    ${text}
                                </a>
                            </li>
                        `;
                    } else if (dataTab) {
                        const isActive = linkOrBtn.classList.contains("active") || linkOrBtn.getAttribute("aria-selected") === "true";
                        html += `
                            <li class="hdr-nav-item">
                                <a href="javascript:void(0);" class="hdr-nav-link ${isActive ? 'active is-active' : ''}" data-tab="${dataTab}">
                                    ${text}
                                </a>
                            </li>
                        `;
                    }
                }
            });

            return html;
        }

        function checkAndApplyMobileNav() {
            if (window.innerWidth <= 768) {
                if (!defaultNavHtml) {
                    defaultNavHtml = mainNavList.innerHTML;
                }
                if (mainNavList.getAttribute("data-mode") !== "department") {
                    mainNavList.innerHTML = buildDeptNav();
                    mainNavList.setAttribute("data-mode", "department");
                    bindDeptMobileEvents();
                }
            } else {
                if (defaultNavHtml && mainNavList.getAttribute("data-mode") === "department") {
                    mainNavList.innerHTML = defaultNavHtml;
                    mainNavList.setAttribute("data-mode", "default");
                }
            }
        }

        function bindDeptMobileEvents() {
            // Tab links inside drawer
            mainNavList.querySelectorAll("[data-tab]").forEach(link => {
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    const tabId = this.getAttribute("data-tab");
                    const rowId = this.getAttribute("data-row-id");

                    // Close mobile drawer
                    mainNavList.classList.remove("is-open");
                    hamburgerBtn.setAttribute("aria-expanded", "false");
                    hamburgerBtn.classList.remove("is-active");

                    if (tabId) {
                        if (typeof window.activateTab === "function") {
                            window.activateTab(tabId, !rowId);
                        } else {
                            const subBtn = deptSubNav.querySelector(`.dept-subnav-link[data-tab="${tabId}"]`);
                            if (subBtn) subBtn.click();
                        }

                        // Update data-active-tab on .dept-page and body
                        const deptPage = document.querySelector(".dept-page") || document.body;
                        deptPage.setAttribute("data-active-tab", tabId);
                        document.body.setAttribute("data-active-tab", tabId);
                    }

                    // Update active highlight in mobile drawer
                    mainNavList.querySelectorAll(".hdr-nav-link, .hdr-dd-link").forEach(el => {
                        el.classList.remove("active", "is-active");
                    });
                    this.classList.add("active");

                    if (rowId) {
                        setTimeout(() => {
                            const targetEl = document.getElementById(rowId);
                            if (targetEl) {
                                const elY = targetEl.getBoundingClientRect().top + window.pageYOffset - 70;
                                window.scrollTo({ top: Math.max(0, elY), behavior: "smooth" });
                                targetEl.classList.remove("is-row-highlight");
                                void targetEl.offsetWidth;
                                targetEl.classList.add("is-row-highlight");
                            }
                        }, 260);
                    } else if (tabId) {
                        setTimeout(() => {
                            const scrollTarget = document.querySelector(".dept-main-content") || document.getElementById("tab-" + tabId);
                            if (scrollTarget) {
                                const targetY = scrollTarget.getBoundingClientRect().top + window.pageYOffset - 60;
                                window.scrollTo({ top: Math.max(0, targetY), behavior: "smooth" });
                            }
                        }, 100);
                    }
                });
            });

            // Accordion toggle for mobile dropdowns
            mainNavList.querySelectorAll(".hdr-nav-item.has-dropdown > .hdr-nav-link").forEach(toggle => {
                toggle.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const parent = this.closest(".hdr-nav-item.has-dropdown");
                    if (!parent) return;
                    const isOpen = parent.classList.contains("is-sub-open");
                    mainNavList.querySelectorAll(".hdr-nav-item.has-dropdown.is-sub-open").forEach(item => {
                        if (item !== parent) item.classList.remove("is-sub-open");
                    });
                    parent.classList.toggle("is-sub-open", !isOpen);
                });
            });

            // Close drawer when external links or Home link clicked
            mainNavList.querySelectorAll(".dept-ext-nav-link, .dept-home-nav-link").forEach(link => {
                link.addEventListener("click", function () {
                    mainNavList.classList.remove("is-open");
                    hamburgerBtn.setAttribute("aria-expanded", "false");
                    hamburgerBtn.classList.remove("is-active");
                });
            });
        }

        checkAndApplyMobileNav();
        window.addEventListener("resize", checkAndApplyMobileNav, { passive: true });
    }

    initGlobalDepartmentNav();
});
