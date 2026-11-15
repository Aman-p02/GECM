<?php
$currentDoc = $_GET['doc'] ?? $_GET['c'] ?? 'rti-proactive';
if ($currentDoc === 'anti-ragging') {
    $page_title = "Anti-Ragging Committee | GEC Modasa";
} elseif ($currentDoc === 'sexual-harassment') {
    $page_title = "Sexual Harassment Prevention Committee | GEC Modasa";
} else {
    $currentDoc = 'rti-proactive';
    $page_title = "Right to Information (RTI) Act | GEC Modasa";
}

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
        </div>
    </section>

    <!-- Top Horizontal Sub-Navbar with Dropdowns -->
    <nav class="md-subnav-bar" aria-label="Committees and Disclosures Navigation">
        <div class="md-subnav-wrap">
            <ul class="md-subnav-list" role="navigation">
                
                <!-- Campus Committee Dropdown -->
                <li class="md-subnav-item has-dropdown">
                    <button type="button" class="md-subnav-toggle <?= in_array($currentDoc, ['anti-ragging', 'sexual-harassment']) ? 'is-current' : '' ?>" aria-expanded="false" aria-haspopup="true">
                        <span>Campus Committee</span>
                        <i class="fas fa-chevron-down subnav-chevron"></i>
                    </button>
                    <ul class="md-subnav-dropdown" role="menu">
                        <?php foreach ($committeeItems as $cItem): ?>
                            <li role="none">
                                <?php if ($cItem['slug'] === 'anti-ragging'): ?>
                                    <a href="mandatory-disclosure.php?doc=anti-ragging" class="md-subnav-dd-link <?= ($currentDoc === 'anti-ragging') ? 'active' : '' ?>" role="menuitem">
                                        <span><?= htmlspecialchars($cItem['title']) ?></span>
                                    </a>
                                <?php elseif ($cItem['slug'] === 'sexual-harassment'): ?>
                                    <a href="mandatory-disclosure.php?doc=sexual-harassment" class="md-subnav-dd-link <?= ($currentDoc === 'sexual-harassment') ? 'active' : '' ?>" role="menuitem">
                                        <span><?= htmlspecialchars($cItem['title']) ?></span>
                                    </a>
                                <?php else: ?>
                                    <a href="disclosure-pdf.php?doc=<?= urlencode($cItem['slug']) ?>" target="_blank" rel="noopener noreferrer" class="md-subnav-dd-link" role="menuitem">
                                        <span><?= htmlspecialchars($cItem['title']) ?></span>
                                    </a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <!-- Mandatory Disclosures Dropdown -->
                <li class="md-subnav-item has-dropdown">
                    <button type="button" class="md-subnav-toggle <?= ($currentDoc === 'rti-proactive') ? 'is-current' : '' ?>" aria-expanded="false" aria-haspopup="true">
                        <span>Mandatory Disclosures</span>
                        <i class="fas fa-chevron-down subnav-chevron"></i>
                    </button>
                    <ul class="md-subnav-dropdown" role="menu">
                        <?php foreach ($disclosureItems as $dItem): ?>
                            <li role="none">
                                <?php if ($dItem['slug'] === 'rti-proactive'): ?>
                                    <a href="mandatory-disclosure.php?doc=rti-proactive" class="md-subnav-dd-link <?= ($currentDoc === 'rti-proactive') ? 'active' : '' ?>" role="menuitem">
                                        <span><?= htmlspecialchars($dItem['title']) ?></span>
                                    </a>
                                <?php else: ?>
                                    <a href="disclosure-pdf.php?doc=<?= urlencode($dItem['slug']) ?>" target="_blank" rel="noopener noreferrer" class="md-subnav-dd-link" role="menuitem">
                                        <span><?= htmlspecialchars($dItem['title']) ?></span>
                                    </a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>

    <!-- Main Content Container -->
    <div class="container md-container">

        <?php if ($currentDoc === 'anti-ragging'): ?>
            <!-- Anti-Ragging Committee Institutional Card -->
            <article class="rti-content-card" id="anti-ragging">

                <!-- Card Header -->
                <header class="rti-header-block">
                    <h2 class="rti-main-title">Anti-Ragging Committee</h2>
                </header>

                <!-- Key Highlight Callout Box -->
                <div class="rti-lead-box">
                    <p class="rti-lead-text">
                        <strong>Zero Tolerance Mandate:</strong> Ragging is a serious offence that compromises student dignity and well-being. In strict compliance with the <strong>UGC Regulation on Curbing the Menace of Ragging in Higher Educational Institutions (2009)</strong>, Government Engineering College, Modasa maintains stringent preventive safeguards across academic departments and campus hostels. Both students and parents must submit statutory compliance undertakings at the time of admission.
                    </p>
                </div>

                <!-- Body Narrative -->
                <div class="rti-prose">
                    <p>
                        The Institute has established an Anti-Ragging Committee to ensure an entirely ragging-free campus. The committee is empowered to prohibit and strictly penalize any conduct—verbal, written, or physical—that involves teasing, discourtesy, rowdy or undisciplined behavior, or psychological harassment of freshers or any other students.
                    </p>
                    <p>
                        Faculty squads conduct frequent monitoring across department buildings, laboratories, common gathering spaces, and student hostel facilities to provide immediate assistance, prevent any untoward incidents, and enforce statutory disciplinary actions.
                    </p>
                </div>

                <!-- Committee Members Section -->
                <section class="rti-officers-section" aria-label="Anti-Ragging Committee Members">
                    <h3 class="rti-officers-title">Committee Members</h3>

                    <div class="rti-officers-grid">
                        <!-- Coordinator Card -->
                        <div class="rti-officer-card">
                            <div class="rti-officer-avatar" aria-hidden="true">
                                <span>US</span>
                            </div>
                            <div class="rti-officer-info">
                                <span class="rti-officer-role">Coordinator</span>
                                <h4 class="rti-officer-name">Prof. (Dr.) U. V. Shah</h4>
                                <p class="rti-officer-dept">Prof. &amp; Head &ndash; Mech Engg. Dept.</p>
                            </div>
                        </div>

                        <!-- Co-Coordinator Card -->
                        <div class="rti-officer-card">
                            <div class="rti-officer-avatar" aria-hidden="true">
                                <span>PG</span>
                            </div>
                            <div class="rti-officer-info">
                                <span class="rti-officer-role">Co-Coordinator</span>
                                <h4 class="rti-officer-name">Prof. P. R. Gamit</h4>
                                <p class="rti-officer-dept">Assistant Prof. &ndash; Computer Engg. Dept.</p>
                            </div>
                        </div>

                        <!-- Members Card -->
                        <div class="rti-officer-card">
                            <div class="rti-officer-avatar" aria-hidden="true">
                                <span>HT</span>
                            </div>
                            <div class="rti-officer-info">
                                <span class="rti-officer-role">Members</span>
                                <h4 class="rti-officer-name">All HoDs &amp; Hostel Team</h4>
                                <p class="rti-officer-dept">Department Heads &amp; Hostel Wardens</p>
                            </div>
                        </div>
                    </div>
                </section>

            </article>

        <?php elseif ($currentDoc === 'sexual-harassment'): ?>
            <!-- Sexual Harassment Prevention Committee Institutional Card -->
            <article class="rti-content-card" id="sexual-harassment">

                <!-- Card Header -->
                <header class="rti-header-block">
                    <h2 class="rti-main-title">Sexual Harassment Prevention Committee</h2>
                </header>

                <!-- Key Highlight Callout Box -->
                <div class="rti-lead-box">
                    <p class="rti-lead-text">
                        <strong>Institutional Commitment:</strong> Government Engineering College, Modasa is committed to providing a learning and working environment free from unlawful discrimination and sexual harassment. The institution ensures prompt, confidential, and effective resolution of incidents, encouraging informal resolution of discrimination grievances as close to the source as possible in strict accordance with statutory regulations.
                    </p>
                </div>

                <!-- Key Objectives Section -->
                <section class="rti-objectives-card" aria-label="Objectives of Sexual Harassment Prevention Committee">
                    <h3 class="rti-section-heading">
                        <i class="fas fa-bullseye"></i> Statutory Objectives
                    </h3>
                    <div class="rti-objectives-grid">
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">1</span>
                            <p class="rti-obj-text">Developing an organizational framework to address and resolve grievances of students and other campus stakeholders.</p>
                        </div>
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">2</span>
                            <p class="rti-obj-text">Enlightening students and staff regarding their duties, statutory rights, and procedural safeguards.</p>
                        </div>
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">3</span>
                            <p class="rti-obj-text">Ensuring fair, effective, and timely solutions for student and staff grievances.</p>
                        </div>
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">4</span>
                            <p class="rti-obj-text">Investigating reported causes of dissatisfaction with impartiality and complete confidentiality.</p>
                        </div>
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">5</span>
                            <p class="rti-obj-text">Obtaining, where possible, a speedy and equitable resolution to grievances in the best interest of a safe campus.</p>
                        </div>
                    </div>
                </section>

                <!-- Committee Members Section -->
                <section class="rti-officers-section" aria-label="Sexual Harassment Prevention Committee Members">
                    <h3 class="rti-officers-title">Committee Members</h3>

                    <div class="rti-officers-grid">
                        <!-- Coordinator Card -->
                        <div class="rti-officer-card">
                            <div class="rti-officer-avatar" aria-hidden="true">
                                <span>PS</span>
                            </div>
                            <div class="rti-officer-info">
                                <span class="rti-officer-role">Coordinator</span>
                                <h4 class="rti-officer-name">Prof. P. K. Shah</h4>
                                <p class="rti-officer-dept">Associate Prof. &ndash; Civil Engg. Dept.</p>
                            </div>
                        </div>

                        <!-- Co-Coordinator Card -->
                        <div class="rti-officer-card">
                            <div class="rti-officer-avatar" aria-hidden="true">
                                <span>SR</span>
                            </div>
                            <div class="rti-officer-info">
                                <span class="rti-officer-role">Co-Coordinator</span>
                                <h4 class="rti-officer-name">Prof. S. K. Rana</h4>
                                <p class="rti-officer-dept">Assistant Prof. &ndash; E.C. Engg. Dept.</p>
                            </div>
                        </div>

                        <!-- Members Card -->
                        <div class="rti-officer-card">
                            <div class="rti-officer-avatar" aria-hidden="true">
                                <span>AH</span>
                            </div>
                            <div class="rti-officer-info">
                                <span class="rti-officer-role">Members</span>
                                <h4 class="rti-officer-name">All HoDs</h4>
                                <p class="rti-officer-dept">Heads of Academic Departments</p>
                            </div>
                        </div>
                    </div>
                </section>

            </article>

        <?php else: ?>
            <!-- RTI Act Institutional Card -->
            <article class="rti-content-card" id="rti-act">

                <!-- Card Header -->
                <header class="rti-header-block">
                    <h2 class="rti-main-title">Right to Information (RTI) Act, 2005</h2>
                </header>

                <!-- Key Highlight Callout Box -->
                <div class="rti-lead-box">
                    <p class="rti-lead-text">
                        The <strong>Right to Information Act 2005</strong> mandates timely responses to citizen requests for government information. An initiative by the <strong>Department of Personnel and Training (DoPT)</strong>, Ministry of Personnel, Public Grievances and Pensions, it provides an official RTI Portal Gateway enabling citizens to quickly access details of First Appellate Authorities, Public Information Officers (PIOs), and statutory proactive disclosures across the Government of India and the Government of Gujarat.
                    </p>
                </div>

                <!-- Body Narrative -->
                <div class="rti-prose">
                    <p>
                        The fundamental object of the <strong>Right to Information Act</strong> is to empower citizens, promote transparency and accountability in the working of the Government, contain corruption, and make our democracy work for the people in real sense. An informed citizen is better equipped to keep necessary vigil on the instruments of governance and make the government more accountable to the governed.
                    </p>
                    <p>
                        In accordance with statutory mandates, Government Engineering College, Modasa adheres strictly to Section 4(1)(b) proactive disclosures, ensuring organized dissemination of official records, administrative decisions, academic circulars, and committee proceedings.
                    </p>
                </div>

                <!-- Key Objectives Section -->
                <section class="rti-objectives-card" aria-label="Key Objectives of RTI Act">
                    <h3 class="rti-section-heading">
                        <i class="fas fa-bullseye"></i> Objectives of the RTI Act
                    </h3>
                    <div class="rti-objectives-grid">
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">1</span>
                            <p class="rti-obj-text">To promote transparency and accountability in the functioning of the government.</p>
                        </div>
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">2</span>
                            <p class="rti-obj-text">To set up a practical regime for giving citizens access to information that is under the control of public authorities.</p>
                        </div>
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">3</span>
                            <p class="rti-obj-text">To empower the citizens as the law will promote the participation of the citizens in official decisions that directly affect their lives.</p>
                        </div>
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">4</span>
                            <p class="rti-obj-text">The effective implementation of RTI Act will build public trust in the government functioning.</p>
                        </div>
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">5</span>
                            <p class="rti-obj-text">It will lead to effective and efficient records management techniques needed to facilitate the provision of information in response to public interest.</p>
                        </div>
                    </div>
                </section>

                <!-- Committee Members Section -->
                <section class="rti-officers-section" aria-label="RTI Committee Members">
                    <h3 class="rti-officers-title">Committee Members</h3>

                    <div class="rti-officers-grid">
                        <!-- Coordinator Card -->
                        <div class="rti-officer-card">
                            <div class="rti-officer-avatar" aria-hidden="true">
                                <span>DS</span>
                            </div>
                            <div class="rti-officer-info">
                                <span class="rti-officer-role">Coordinator</span>
                                <h4 class="rti-officer-name">Prof. D. A. Sagar</h4>
                                <p class="rti-officer-dept">Assistant Professor &ndash; Applied Mechanics Dept.</p>
                            </div>
                        </div>

                        <!-- Co-Coordinator Card -->
                        <div class="rti-officer-card">
                            <div class="rti-officer-avatar" aria-hidden="true">
                                <span>RK</span>
                            </div>
                            <div class="rti-officer-info">
                                <span class="rti-officer-role">Co-Coordinator</span>
                                <h4 class="rti-officer-name">Prof. R. P. Khatri</h4>
                                <p class="rti-officer-dept">Assistant Professor &ndash; General Dept.</p>
                            </div>
                        </div>
                    </div>
                </section>

            </article>
        <?php endif; ?>

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
