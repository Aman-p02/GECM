<?php
$redirectComm = $_GET['doc'] ?? $_GET['c'] ?? '';
if (in_array($redirectComm, ['anti-ragging', 'sexual-harassment', 'women-development-cell'])) {
    header("Location: committees.php?c=" . urlencode($redirectComm));
    exit;
}

$page_title = "Right to Information (RTI) Act & Mandatory Disclosure | GEC Modasa";
$active_page = 'mandatory-disclosure';
$extra_css = 'css/mandatory-disclosure.css';
require_once __DIR__ . '/includes/header.php';

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
            <h1 class="md-heading"><a href="mandatory-disclosure.php" style="color: inherit; text-decoration: none;">Mandatory Disclosures &amp; RTI</a></h1>
        </div>
    </section>

    <!-- Top Horizontal Sub-Navbar with Dropdowns -->
    <nav class="md-subnav-bar" aria-label="Administration and Disclosures Navigation">
        <div class="md-subnav-wrap">
            <ul class="md-subnav-list" role="navigation">
                
                <!-- Campus Committees Link -->
                <li class="md-subnav-item">
                    <a href="committees.php" class="md-subnav-toggle" style="text-decoration: none;">
                        <span>Campus Committees</span>
                        <i class="fas fa-chevron-right subnav-chevron" style="transform: none; font-size: 11px;"></i>
                    </a>
                </li>

                <!-- Mandatory Disclosures Dropdown (Direct Official PDF Documents) -->
                <li class="md-subnav-item has-dropdown">
                    <button type="button" class="md-subnav-toggle is-current" aria-expanded="false" aria-haspopup="true">
                        <span>Mandatory Disclosures (PDFs)</span>
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
