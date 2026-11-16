<?php
$currentDoc = $_GET['doc'] ?? $_GET['c'] ?? '';
if ($currentDoc === 'anti-ragging') {
    $page_title = "Anti-Ragging Committee | GEC Modasa";
} elseif ($currentDoc === 'sexual-harassment') {
    $page_title = "Sexual Harassment Prevention Committee | GEC Modasa";
} elseif ($currentDoc === 'women-development-cell') {
    $page_title = "Women Development Cell (WDC) | GEC Modasa";
} else {
    $currentDoc = 'overview';
    $page_title = "Right to Information (RTI) Act & Mandatory Disclosure | GEC Modasa";
}

$active_page = 'mandatory-disclosure';
$extra_css = 'css/mandatory-disclosure.css';
require_once __DIR__ . '/includes/header.php';

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
        'title' => 'Women Development Cell (WDC)'
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
            <h1 class="md-heading"><a href="mandatory-disclosure.php" style="color: inherit; text-decoration: none;">Mandatory Disclosures &amp; Campus Committees</a></h1>
        </div>
    </section>

    <!-- Top Horizontal Sub-Navbar with Dropdowns -->
    <nav class="md-subnav-bar" aria-label="Campus Committees and Disclosures Navigation">
        <div class="md-subnav-wrap">
            <ul class="md-subnav-list" role="navigation">
                
                <!-- Campus Committees Dropdown -->
                <li class="md-subnav-item has-dropdown">
                    <button type="button" class="md-subnav-toggle <?= in_array($currentDoc, ['anti-ragging', 'sexual-harassment', 'women-development-cell']) ? 'is-current' : '' ?>" aria-expanded="false" aria-haspopup="true">
                        <span>Campus Committees</span>
                        <i class="fas fa-chevron-down subnav-chevron"></i>
                    </button>
                    <ul class="md-subnav-dropdown" role="menu">
                        <?php foreach ($committeeItems as $cItem): ?>
                            <li role="none">
                                <a href="mandatory-disclosure.php?doc=<?= urlencode($cItem['slug']) ?>" class="md-subnav-dd-link <?= ($currentDoc === $cItem['slug']) ? 'active' : '' ?>" role="menuitem">
                                    <span><?= htmlspecialchars($cItem['title']) ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <!-- Mandatory Disclosures Dropdown (Direct Official PDF Documents) -->
                <li class="md-subnav-item has-dropdown">
                    <button type="button" class="md-subnav-toggle <?= ($currentDoc === 'overview') ? 'is-current' : '' ?>" aria-expanded="false" aria-haspopup="true">
                        <span>Mandatory Disclosures</span>
                        <i class="fas fa-chevron-down subnav-chevron"></i>
                    </button>
                    <ul class="md-subnav-dropdown" role="menu">
                        <?php foreach ($disclosureItems as $dItem): ?>
                            <li role="none">
                                <a href="disclosure-pdf.php?doc=<?= urlencode($dItem['slug']) ?>" target="_blank" rel="noopener noreferrer" class="md-subnav-dd-link" role="menuitem">
                                    <span><?= htmlspecialchars($dItem['title']) ?></span>
                                    <i class="fas fa-file-pdf" style="font-size: 0.78rem; color: #e11d48; margin-left: auto;" aria-hidden="true"></i>
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

        <?php elseif ($currentDoc === 'women-development-cell'): ?>
            <!-- Women Development Cell Institutional Card -->
            <article class="rti-content-card" id="women-development-cell">


                <!-- Card Header -->
                <header class="rti-header-block">
                    <h2 class="rti-main-title">Women Development Cell (WDC)</h2>
                </header>

                <!-- Lead Text -->
                <div class="rti-lead-box">
                    <p class="rti-lead-text">
                        In congruence with the directives of the <strong>University Grants Commission (UGC)</strong> and <strong>Gujarat Technological University (GTU)</strong>, Government Engineering College, Modasa has established an active <strong>Women Development Cell (WDC)</strong>. The cell is dedicated to empowering women and maintaining a dignified, congenial academic and work environment where girl students, female faculty, and staff members can study, innovate, and realize their full potential.
                    </p>
                </div>

                <!-- Vision & Mission Block -->
                <div class="wdc-vision-mission-grid">
                    <div class="wdc-vm-card">
                        <span class="wdc-vm-badge vision">Vision</span>
                        <p class="wdc-vm-text">Strengthen the status of women and facilitate a congenial, dignified working and learning environment.</p>
                    </div>
                    <div class="wdc-vm-card">
                        <span class="wdc-vm-badge mission">Mission</span>
                        <p class="wdc-vm-text">To create an effective framework and sustainable practices ensuring equal rights and opportunities for women in the family, community, workplace, and in governance.</p>
                    </div>
                </div>

                <!-- Key Objectives Section -->
                <section class="rti-objectives-card" aria-label="Objectives of Women Development Cell">
                    <h3 class="rti-section-heading">
                        <i class="fas fa-bullseye"></i> Statutory Objectives
                    </h3>
                    <div class="rti-objectives-grid">
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">1</span>
                            <p class="rti-obj-text">Organize seminars and expert lectures for female students and faculties on health, safety, and essential life skills.</p>
                        </div>
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">2</span>
                            <p class="rti-obj-text">Create proactive social awareness among female staff members and students regarding rights, gender equity, and campus safety.</p>
                        </div>
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">3</span>
                            <p class="rti-obj-text">Inspire and motivate female students toward innovation, entrepreneurship, and startups aligned with the "Aatma Nirbhar Bharat" initiative.</p>
                        </div>
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">4</span>
                            <p class="rti-obj-text">Provide opportunities and programs enabling girls and female staff to be financially, mentally, and emotionally empowered to foster individual growth.</p>
                        </div>
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">5</span>
                            <p class="rti-obj-text">Provide personal, confidential counseling for both resident hostelites and day-scholar female students.</p>
                        </div>
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">6</span>
                            <p class="rti-obj-text">Maintain an active forum for discussion, leadership guidance, and interactive mentoring with eminent women achievers.</p>
                        </div>
                        <div class="rti-objective-item">
                            <span class="rti-obj-num">7</span>
                            <p class="rti-obj-text">Encourage proactive participation in collegiate and community development activities designed for women's holistic advancement.</p>
                        </div>
                    </div>
                </section>

                <!-- Committee Members Section -->
                <section class="rti-officers-section" aria-label="Women Development Cell Committee Members">
                    <h3 class="rti-officers-title">Committee Members</h3>

                    <div class="rti-officers-grid wdc-officers-grid">
                        <!-- Member 1 -->
                        <div class="rti-officer-card">
                            <div class="rti-officer-avatar" aria-hidden="true">
                                <span>SR</span>
                            </div>
                            <div class="rti-officer-info">
                                <span class="rti-officer-role">EC Dept.</span>
                                <h4 class="rti-officer-name">Prof. S. K. Rana</h4>
                                <p class="rti-officer-dept">Assistant Professor &bull; <a href="mailto:shilprana@gmail.com" class="wdc-email-link"><i class="far fa-envelope" aria-hidden="true"></i> shilprana@gmail.com</a></p>
                            </div>
                        </div>

                        <!-- Member 2 -->
                        <div class="rti-officer-card">
                            <div class="rti-officer-avatar" aria-hidden="true">
                                <span>TS</span>
                            </div>
                            <div class="rti-officer-info">
                                <span class="rti-officer-role">Electrical Dept.</span>
                                <h4 class="rti-officer-name">Prof. Trushna P. Shah</h4>
                                <p class="rti-officer-dept">Assistant Professor &bull; <a href="mailto:trushnaelect@gmail.com" class="wdc-email-link"><i class="far fa-envelope" aria-hidden="true"></i> trushnaelect@gmail.com</a></p>
                            </div>
                        </div>

                        <!-- Member 3 -->
                        <div class="rti-officer-card">
                            <div class="rti-officer-avatar" aria-hidden="true">
                                <span>RP</span>
                            </div>
                            <div class="rti-officer-info">
                                <span class="rti-officer-role">Computer Dept.</span>
                                <h4 class="rti-officer-name">Prof. Rinkal Prajapati</h4>
                                <p class="rti-officer-dept">Assistant Professor &bull; <a href="mailto:rinkal10feb@gmail.com" class="wdc-email-link"><i class="far fa-envelope" aria-hidden="true"></i> rinkal10feb@gmail.com</a></p>
                            </div>
                        </div>

                        <!-- Member 4 -->
                        <div class="rti-officer-card">
                            <div class="rti-officer-avatar" aria-hidden="true">
                                <span>HT</span>
                            </div>
                            <div class="rti-officer-info">
                                <span class="rti-officer-role">Civil Dept.</span>
                                <h4 class="rti-officer-name">Prof. Hinal Thakar</h4>
                                <p class="rti-officer-dept">Assistant Professor &bull; <a href="mailto:hinal_thakar@rediffmail.com" class="wdc-email-link"><i class="far fa-envelope" aria-hidden="true"></i> hinal_thakar@rediffmail.com</a></p>
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
