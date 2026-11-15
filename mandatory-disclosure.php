<?php
$page_title = "Anti-Ragging Committee & Mandatory Disclosures | GEC Modasa";
$active_page = 'mandatory-disclosure';
$extra_css = 'css/mandatory-disclosure.css';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

// Committee & Disclosure Categories for Subnav Dropdowns
$committeeItems = [
    'anti-ragging' => [
        'slug'  => 'anti-ragging',
        'title' => 'Anti-Ragging Committee'
    ],
    'sexual-harassment' => [
        'slug'  => 'sexual-harassment',
        'title' => 'Sexual Harassment Committee'
    ],
    'women-development-cell' => [
        'slug'  => 'women-development-cell',
        'title' => 'Women development Cell'
    ]
];

$disclosureItems = [
    'rti-proactive' => [
        'slug'  => 'rti-proactive',
        'title' => 'RTI Pro-Active Disclosure'
    ],
    'aicte' => [
        'slug'  => 'aicte',
        'title' => 'AICTE Mandatory Disclosure'
    ],
    'financial-statements' => [
        'slug'  => 'financial-statements',
        'title' => 'Financial Statements'
    ],
    'accreditation' => [
        'slug'  => 'accreditation',
        'title' => 'Accreditation'
    ],
    'institute-establishment' => [
        'slug'  => 'institute-establishment',
        'title' => 'Institute Establishment Resolution'
    ],
    'rti-booklet' => [
        'slug'  => 'rti-booklet',
        'title' => 'RTI Booklet (2005)'
    ]
];
?>

<div class="md-page-wrapper">

    <!-- Page Hero Banner -->
    <section class="md-hero">
        <div class="container md-container">
            <span class="md-kicker">INSTITUTIONAL STATUTORY BODIES</span>
            <h1 class="md-heading">Mandatory Disclosures &amp; Committees</h1>
            <p class="md-lead">
                Statutory regulatory disclosures and institutional committees of Government Engineering College, Modasa. Access direct documents from the navigation bar above or view official committee details below.
            </p>
        </div>
    </section>

    <!-- Top Horizontal Sub-Navbar with Dropdowns -->
    <nav class="md-subnav-bar" aria-label="Committees and Disclosures Navigation">
        <div class="md-subnav-wrap">
            <ul class="md-subnav-list" role="navigation">
                
                <!-- Campus Committee Dropdown -->
                <li class="md-subnav-item has-dropdown">
                    <button type="button" class="md-subnav-toggle" aria-expanded="false" aria-haspopup="true">
                        <span>Campus Committee</span>
                        <i class="fas fa-chevron-down subnav-chevron"></i>
                    </button>
                    <ul class="md-subnav-dropdown" role="menu">
                        <?php foreach ($committeeItems as $cItem): ?>
                            <li role="none">
                                <a href="disclosure-pdf.php?doc=<?= urlencode($cItem['slug']) ?>" target="_blank" rel="noopener noreferrer" class="md-subnav-dd-link" role="menuitem">
                                    <span><?= htmlspecialchars($cItem['title']) ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <!-- Mandatory Disclosures Dropdown -->
                <li class="md-subnav-item has-dropdown">
                    <button type="button" class="md-subnav-toggle" aria-expanded="false" aria-haspopup="true">
                        <span>Mandatory Disclosures</span>
                        <i class="fas fa-chevron-down subnav-chevron"></i>
                    </button>
                    <ul class="md-subnav-dropdown" role="menu">
                        <?php foreach ($disclosureItems as $dItem): ?>
                            <li role="none">
                                <a href="disclosure-pdf.php?doc=<?= urlencode($dItem['slug']) ?>" target="_blank" rel="noopener noreferrer" class="md-subnav-dd-link" role="menuitem">
                                    <span><?= htmlspecialchars($dItem['title']) ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>

    <!-- Main Content Container -->
    <div class="container md-container">

        <!-- Anti-Ragging Committee Institutional Card -->
        <article class="arc-content-card">
            
            <!-- Breadcrumbs -->
            <nav class="arc-breadcrumb" aria-label="Breadcrumb">
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <span class="sep">/</span>
                <a href="overview.php">About</a>
                <span class="sep">/</span>
                <span class="current">Anti-Ragging Committee</span>
            </nav>

            <!-- Card Header -->
            <header class="arc-header-block">
                <span class="arc-kicker">CAMPUS STATUTORY BODY</span>
                <h2 class="arc-main-title">Anti-Ragging Committee</h2>
            </header>

            <!-- Institutional Zero Tolerance Notice Box -->
            <div class="arc-callout-box">
                <div class="arc-callout-badge">
                    <i class="fas fa-shield-alt"></i> ZERO TOLERANCE POLICY
                </div>
                <p class="arc-callout-text">
                    Government Engineering College, Modasa adheres strictly to regulatory norms to ensure an entirely ragging-free campus. Any conduct that compromises student dignity or safety is met with immediate disciplinary and statutory action.
                </p>
            </div>

            <!-- Body Narrative -->
            <div class="arc-prose">
                <p>
                    Ragging undermines individual dignity and disrupts the academic and emotional well-being of students. In adherence to national educational regulations established to curb this menace, Government Engineering College, Modasa maintains stringent preventive safeguards across all institutional blocks and student hostel facilities. Both students and their parents are required to submit formal compliance undertakings at the time of admission.
                </p>
                <p>
                    The Institute Anti-Ragging Committee is empowered to supervise campus activities, investigate complaints impartially, and take prompt punitive steps against any form of harassment, verbal misconduct, physical rudeness, or intimidating behaviour. Faculty squads conduct frequent monitoring across hostel zones and common areas to safeguard a welcoming and dignified learning environment for all newcomers.
                </p>
            </div>

            <!-- Committee Members Table Section -->
            <section class="arc-table-section" aria-label="Anti-Ragging Committee Members">
                <div class="arc-table-header-block">
                    <div>
                        <h3 class="arc-table-title">Anti Ragging Committee Members</h3>
                        <p class="arc-table-sub">Authorized institutional faculty members and supervisory authorities.</p>
                    </div>
                    <a href="disclosure-pdf.php?doc=anti-ragging" target="_blank" rel="noopener noreferrer" class="arc-download-btn">
                        <i class="fas fa-file-pdf"></i> View Official Notification (PDF)
                    </a>
                </div>

                <div class="arc-table-container">
                    <table class="arc-table">
                        <thead>
                            <tr>
                                <th class="arc-sr-cell">Sr. No.</th>
                                <th>Name of Faculty</th>
                                <th>Designation</th>
                                <th style="width: 170px;">Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="arc-sr-cell">1</td>
                                <td class="arc-faculty-name">Prof. (Dr.) U. V. Shah</td>
                                <td>Prof. &amp; Head, Mech Engg. Dept.</td>
                                <td><span class="arc-role-badge coordinator">Coordinator</span></td>
                            </tr>
                            <tr>
                                <td class="arc-sr-cell">2</td>
                                <td class="arc-faculty-name">Prof. P. R. Gamit</td>
                                <td>Assistant Prof., Computer Engg. Dept.</td>
                                <td><span class="arc-role-badge cocoordinator">Co-coordinator</span></td>
                            </tr>
                            <tr>
                                <td class="arc-sr-cell">3</td>
                                <td class="arc-faculty-name">All Hods &amp; Hostel team</td>
                                <td>Department Heads &amp; Hostel Wardens</td>
                                <td><span class="arc-role-badge member">Members</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Assistance Helpline Strip -->
                <div class="arc-helpline-strip">
                    <div class="arc-helpline-info">
                        <i class="fas fa-headset"></i>
                        <div>
                            <p class="arc-helpline-title">National Anti-Ragging Helpline (Toll-Free 24x7)</p>
                            <p class="arc-helpline-sub">Free assistance, counseling, and grievance reporting</p>
                        </div>
                    </div>
                    <div class="arc-helpline-number">
                        1800-180-5522
                    </div>
                </div>
            </section>

        </article>

    </div>
</div>

<!-- Interactive Scripts for Subnav Dropdowns -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownItems = document.querySelectorAll('.md-subnav-item.has-dropdown');

    function closeAllDropdowns() {
        dropdownItems.forEach(function(item) {
            item.classList.remove('is-open');
            const toggle = item.querySelector('.md-subnav-toggle');
            if (toggle) toggle.setAttribute('aria-expanded', 'false');
        });
    }

    dropdownItems.forEach(function(item) {
        const toggle = item.querySelector('.md-subnav-toggle');
        if (toggle) {
            toggle.addEventListener('click', function(e) {
                // Mobile tap toggle (<= 768px)
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    e.stopPropagation();

                    const isAlreadyOpen = item.classList.contains('is-open');
                    closeAllDropdowns();

                    if (!isAlreadyOpen) {
                        item.classList.add('is-open');
                        toggle.setAttribute('aria-expanded', 'true');
                    }
                }
            });
        }

        // Close dropdown when a document link inside is clicked
        const links = item.querySelectorAll('.md-subnav-dd-link');
        links.forEach(function(link) {
            link.addEventListener('click', function() {
                closeAllDropdowns();
            });
        });
    });

    // Close on outside click (mobile)
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.md-subnav-item.has-dropdown')) {
            closeAllDropdowns();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAllDropdowns();
        }
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
