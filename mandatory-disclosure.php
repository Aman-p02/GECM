<?php
$page_title = "Mandatory Disclosure & Committees :: Government Engineering College, Modasa";
$active_page = 'mandatory-disclosure';
$extra_css = 'css/mandatory-disclosure.css';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

// Statutory Slugs and Metadata (Strictly institutional - no 'THE INSTITUTE')
$committeeItems = [
    'anti-ragging' => [
        'slug'     => 'anti-ragging',
        'title'    => 'Anti-Ragging Committee',
        'category' => 'Anti-Ragging Committee',
        'badge'    => 'Statutory Committee',
        'desc'     => 'Institutional compliance under AICTE & UGC regulations against ragging on campus and in hostels.'
    ],
    'sexual-harassment' => [
        'slug'     => 'sexual-harassment',
        'title'    => 'Sexual Harassment Committee',
        'category' => 'Sexual Harassment Committee',
        'badge'    => 'Statutory Committee',
        'desc'     => 'Internal Complaints Committee (ICC) constituted under the POSH Act 2013 and AICTE regulations.'
    ],
    'women-development-cell' => [
        'slug'     => 'women-development-cell',
        'title'    => 'Women development Cell',
        'category' => 'Women development Cell',
        'badge'    => 'Campus Cell',
        'desc'     => 'Dedicated institutional cell promoting gender equity, campus safety, and empowerment for female students & staff.'
    ]
];

$disclosureItems = [
    'rti-proactive' => [
        'slug'     => 'rti-proactive',
        'title'    => 'RTI Pro-Active Disclosure',
        'category' => 'RTI Pro-Active Disclosure',
        'badge'    => 'RTI Act 2005',
        'desc'     => 'Proactive institutional disclosures published under Section 4(1)(b) of the Right to Information Act, 2005.'
    ],
    'aicte' => [
        'slug'     => 'aicte',
        'title'    => 'AICTE Mandatory Disclosure',
        'category' => 'AICTE Mandatory Disclosure',
        'badge'    => 'AICTE Compliance',
        'desc'     => 'Official mandatory disclosure prescribed by the All India Council for Technical Education (AICTE), New Delhi.'
    ],
    'financial-statements' => [
        'slug'     => 'financial-statements',
        'title'    => 'Financial Statements',
        'category' => 'Financial Statements',
        'badge'    => 'Audit Reports',
        'desc'     => 'Audited annual statements, state budget allocations, and expenditure records of GEC Modasa.'
    ],
    'accreditation' => [
        'slug'     => 'accreditation',
        'title'    => 'Accreditation',
        'category' => 'Accreditation',
        'badge'    => 'NBA / NAAC',
        'desc'     => 'National Board of Accreditation (NBA), NAAC accreditation certificates, and official compliance reports.'
    ],
    'institute-establishment' => [
        'slug'     => 'institute-establishment',
        'title'    => 'Institute Establishment Resolution',
        'category' => 'Institute Establishment Resolution',
        'badge'    => 'Govt. Resolution',
        'desc'     => 'Official Government of Gujarat notifications, gazette records, and resolution establishing GEC Modasa.'
    ],
    'rti-booklet' => [
        'slug'     => 'rti-booklet',
        'title'    => 'RTI Booklet (2005)',
        'category' => 'RTI Booklet (2005)',
        'badge'    => 'RTI Act 2005',
        'desc'     => 'Official RTI handbook, PIO & Appellate Authority contact information, and public filing guidelines.'
    ]
];

// Fetch uploaded documents from database if present
$dbDocsByCategory = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM mandatory_disclosures WHERE is_active = 1 ORDER BY display_order ASC, id DESC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cat = $row['category'];
            if (!isset($dbDocsByCategory[$cat])) {
                $dbDocsByCategory[$cat] = [];
            }
            $dbDocsByCategory[$cat][] = $row;
        }
    } catch (PDOException $e) {
        error_log("Disclosures query error: " . $e->getMessage());
    }
}
?>

<div class="md-page-wrapper">

    <!-- Hero Section -->
    <section class="md-hero">
        <div class="container md-container">
            <span class="md-kicker">INSTITUTIONAL COMPLIANCE &amp; STATUTORY BODIES</span>
            <h1 class="md-heading">Mandatory Disclosures &amp; Committees</h1>
            <p class="md-lead">
                Official statutory disclosures under AICTE norms, Right to Information (RTI) Act 2005, and Government of Gujarat regulations. Click any item in the navigation bar to directly open the respective official document.
            </p>
        </div>
    </section>

    <!-- Top Horizontal Sub-Navbar (Department Style with Dropdowns) -->
    <nav class="md-subnav-bar" aria-label="Disclosures and Committees Navigation">
        <div class="md-subnav-wrap">
            <ul class="md-subnav-list" role="navigation">
                
                <!-- Campus Committee Dropdown (3 options) -->
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

                <!-- Mandatory Disclosures Dropdown (Remaining options) -->
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

        <!-- Section 1: Campus Statutory Committees -->
        <div class="md-card">
            <div class="md-card-header">
                <h2 class="md-card-title">
                    <i class="fas fa-users-cog" style="color: #009dff;"></i>
                    Campus Committees
                </h2>
                <span class="md-badge-count"><?= count($committeeItems) ?> Committees</span>
            </div>
            <ul class="md-list">
                <?php foreach ($committeeItems as $item): ?>
                    <?php 
                    $catDocs = $dbDocsByCategory[$item['category']] ?? [];
                    if (!empty($catDocs)):
                        foreach ($catDocs as $doc):
                    ?>
                        <li class="md-row">
                            <div class="md-left">
                                <div class="md-icon comm-icon">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="md-details">
                                    <div class="md-title-line">
                                        <h3 class="md-title"><?= htmlspecialchars($doc['title']) ?></h3>
                                        <span class="md-type-badge"><?= htmlspecialchars($item['badge']) ?></span>
                                    </div>
                                    <div class="md-meta">
                                        <?php if (!empty($doc['academic_year'])): ?>
                                            <span class="md-meta-item">
                                                <i class="far fa-calendar-alt"></i> <?= htmlspecialchars($doc['academic_year']) ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="md-meta-item">
                                            <i class="fas fa-shield-alt"></i> <?= htmlspecialchars($item['category']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="md-right">
                                <a href="<?= htmlspecialchars($doc['file_path']) ?>" target="_blank" rel="noopener noreferrer" class="md-view-btn">
                                    <i class="fas fa-eye"></i> View PDF
                                </a>
                            </div>
                        </li>
                    <?php 
                        endforeach;
                    else: 
                    ?>
                        <li class="md-row">
                            <div class="md-left">
                                <div class="md-icon comm-icon">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="md-details">
                                    <div class="md-title-line">
                                        <h3 class="md-title"><?= htmlspecialchars($item['title']) ?></h3>
                                        <span class="md-type-badge"><?= htmlspecialchars($item['badge']) ?></span>
                                    </div>
                                    <div class="md-meta">
                                        <span class="md-meta-item">
                                            <i class="fas fa-info-circle"></i> <?= htmlspecialchars($item['desc']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="md-right">
                                <a href="disclosure-pdf.php?doc=<?= urlencode($item['slug']) ?>" target="_blank" rel="noopener noreferrer" class="md-view-btn">
                                    <i class="fas fa-eye"></i> View PDF
                                </a>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Section 2: Mandatory Disclosures -->
        <div class="md-card">
            <div class="md-card-header">
                <h2 class="md-card-title">
                    <i class="fas fa-file-contract" style="color: #ff8800;"></i>
                    Mandatory Disclosures
                </h2>
                <span class="md-badge-count"><?= count($disclosureItems) ?> Disclosures</span>
            </div>
            <ul class="md-list">
                <?php foreach ($disclosureItems as $item): ?>
                    <?php 
                    $catDocs = $dbDocsByCategory[$item['category']] ?? [];
                    if (!empty($catDocs)):
                        foreach ($catDocs as $doc):
                    ?>
                        <li class="md-row">
                            <div class="md-left">
                                <div class="md-icon">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="md-details">
                                    <div class="md-title-line">
                                        <h3 class="md-title"><?= htmlspecialchars($doc['title']) ?></h3>
                                        <span class="md-type-badge"><?= htmlspecialchars($item['badge']) ?></span>
                                    </div>
                                    <div class="md-meta">
                                        <?php if (!empty($doc['academic_year'])): ?>
                                            <span class="md-meta-item">
                                                <i class="far fa-calendar-alt"></i> <?= htmlspecialchars($doc['academic_year']) ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="md-meta-item">
                                            <i class="fas fa-check-circle"></i> <?= htmlspecialchars($item['category']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="md-right">
                                <a href="<?= htmlspecialchars($doc['file_path']) ?>" target="_blank" rel="noopener noreferrer" class="md-view-btn">
                                    <i class="fas fa-eye"></i> View PDF
                                </a>
                            </div>
                        </li>
                    <?php 
                        endforeach;
                    else: 
                    ?>
                        <li class="md-row">
                            <div class="md-left">
                                <div class="md-icon">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="md-details">
                                    <div class="md-title-line">
                                        <h3 class="md-title"><?= htmlspecialchars($item['title']) ?></h3>
                                        <span class="md-type-badge"><?= htmlspecialchars($item['badge']) ?></span>
                                    </div>
                                    <div class="md-meta">
                                        <span class="md-meta-item">
                                            <i class="fas fa-info-circle"></i> <?= htmlspecialchars($item['desc']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="md-right">
                                <a href="disclosure-pdf.php?doc=<?= urlencode($item['slug']) ?>" target="_blank" rel="noopener noreferrer" class="md-view-btn">
                                    <i class="fas fa-eye"></i> View PDF
                                </a>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>
</div>

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
                // Mobile tap toggle (< 769px)
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

        // Close dropdown when a link inside is clicked
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
