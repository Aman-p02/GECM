<?php
$page_title = "Mandatory Disclosure & Campus Committees :: Government Engineering College, Modasa";
$active_page = 'about';
$extra_css = 'css/mandatory-disclosure.css';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

// Valid sections mapping
$sections = [
    // Committees
    'anti-ragging' => [
        'type' => 'committee',
        'slug' => 'anti-ragging',
        'title' => 'Anti-Ragging Committee',
        'group' => 'committee'
    ],
    'sexual-harassment' => [
        'type' => 'committee',
        'slug' => 'sexual-harassment',
        'title' => 'Sexual Harassment Committee',
        'group' => 'committee'
    ],
    'women-development-cell' => [
        'type' => 'committee',
        'slug' => 'women-development-cell',
        'title' => 'Women development Cell',
        'group' => 'committee'
    ],
    // Mandatory Disclosures
    'rti-proactive' => [
        'type' => 'disclosure',
        'category' => 'RTI Pro-Active Disclosure',
        'title' => 'RTI Pro-Active Disclosure',
        'group' => 'disclosure',
        'desc' => 'Pro-active disclosure under Section 4(1)(b) of the Right to Information Act, 2005 for Government Engineering College, Modasa.'
    ],
    'aicte' => [
        'type' => 'disclosure',
        'category' => 'AICTE Mandatory Disclosure',
        'title' => 'AICTE Mandatory Disclosure',
        'group' => 'disclosure',
        'desc' => 'Mandatory disclosure as prescribed by the All India Council for Technical Education (AICTE), New Delhi for engineering and technical programs.'
    ],
    'financial-statements' => [
        'type' => 'disclosure',
        'category' => 'Financial Statements',
        'title' => 'Financial Statements',
        'group' => 'disclosure',
        'desc' => 'Annual audited financial statements, state grant allocations, and expenditure reports of Government Engineering College, Modasa.'
    ],
    'accreditation' => [
        'type' => 'disclosure',
        'category' => 'Accreditation',
        'title' => 'Accreditation',
        'group' => 'disclosure',
        'desc' => 'National Board of Accreditation (NBA), NAAC accreditation status, and institutional compliance certificates.'
    ],
    'institute-establishment' => [
        'type' => 'disclosure',
        'category' => 'Institute Establishment Resolution',
        'title' => 'Institute Establishment Resolution',
        'group' => 'disclosure',
        'desc' => 'Government of Gujarat resolutions, gazette notifications, and official sanction orders establishing Government Engineering College, Modasa.'
    ],
    'rti-booklet' => [
        'type' => 'disclosure',
        'category' => 'RTI Booklet (2005)',
        'title' => 'RTI Booklet (2005)',
        'group' => 'disclosure',
        'desc' => 'Right to Information (RTI) statutory booklet, guidelines, appellate authorities, and Public Information Officer (PIO) details.'
    ]
];

$activeSectionKey = $_GET['section'] ?? 'anti-ragging';
if (!array_key_exists($activeSectionKey, $sections)) {
    $activeSectionKey = 'anti-ragging';
}

$currentSection = $sections[$activeSectionKey];
$isCommittee = ($currentSection['type'] === 'committee');

// Fetch data
$committeeInfo = null;
$committeeMembers = [];
$disclosureDocuments = [];

if ($pdo) {
    if ($isCommittee) {
        $stmt = $pdo->prepare("SELECT * FROM campus_committees WHERE committee_slug = ?");
        $stmt->execute([$currentSection['slug']]);
        $committeeInfo = $stmt->fetch();

        $stmtMem = $pdo->prepare("SELECT * FROM campus_committee_members WHERE committee_slug = ? ORDER BY sr_no ASC, display_order ASC, id ASC");
        $stmtMem->execute([$currentSection['slug']]);
        $committeeMembers = $stmtMem->fetchAll();
    } else {
        $stmtDoc = $pdo->prepare("SELECT * FROM mandatory_disclosures WHERE category = ? AND is_active = 1 ORDER BY display_order ASC, id DESC");
        $stmtDoc->execute([$currentSection['category']]);
        $disclosureDocuments = $stmtDoc->fetchAll();
    }
}
?>

<div class="md-page-wrapper">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div class="md-layout">
            
            <!-- Left Navigation Sidebar -->
            <aside class="md-sidebar" aria-label="Committees and Disclosures Navigation">
                
                <!-- Campus Committee Group -->
                <div class="md-nav-group">
                    <div class="md-group-header committee-header">
                        <span>CAMPUS COMMITTEE</span>
                        <i class="fas fa-chevron-down hdr-chevron"></i>
                    </div>
                    <ul class="md-nav-list">
                        <li class="md-nav-item">
                            <a href="mandatory-disclosure.php?section=anti-ragging" class="md-nav-link <?= ($activeSectionKey === 'anti-ragging') ? 'is-active' : '' ?>">
                                Anti-Ragging Committee
                            </a>
                        </li>
                        <li class="md-nav-item">
                            <a href="mandatory-disclosure.php?section=sexual-harassment" class="md-nav-link <?= ($activeSectionKey === 'sexual-harassment') ? 'is-active' : '' ?>">
                                Sexual Harassment Committee
                            </a>
                        </li>
                        <li class="md-nav-item">
                            <a href="mandatory-disclosure.php?section=women-development-cell" class="md-nav-link <?= ($activeSectionKey === 'women-development-cell') ? 'is-active' : '' ?>">
                                Women development Cell
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Mandatory Disclosures Group -->
                <div class="md-nav-group">
                    <div class="md-group-header disclosures-header active-header">
                        <span>MANDATORY DISCLOSURES</span>
                        <i class="fas fa-chevron-down hdr-chevron"></i>
                    </div>
                    <ul class="md-nav-list">
                        <li class="md-nav-item">
                            <a href="mandatory-disclosure.php?section=rti-proactive" class="md-nav-link <?= ($activeSectionKey === 'rti-proactive') ? 'is-active' : '' ?>">
                                RTI Pro-Active Disclosure
                            </a>
                        </li>
                        <li class="md-nav-item">
                            <a href="mandatory-disclosure.php?section=aicte" class="md-nav-link <?= ($activeSectionKey === 'aicte') ? 'is-active' : '' ?>">
                                AICTE Mandatory Disclosure
                            </a>
                        </li>
                        <li class="md-nav-item">
                            <a href="mandatory-disclosure.php?section=financial-statements" class="md-nav-link <?= ($activeSectionKey === 'financial-statements') ? 'is-active' : '' ?>">
                                Financial Statements
                            </a>
                        </li>
                        <li class="md-nav-item">
                            <a href="mandatory-disclosure.php?section=accreditation" class="md-nav-link <?= ($activeSectionKey === 'accreditation') ? 'is-active' : '' ?>">
                                Accreditation
                            </a>
                        </li>
                        <li class="md-nav-item">
                            <a href="mandatory-disclosure.php?section=institute-establishment" class="md-nav-link <?= ($activeSectionKey === 'institute-establishment') ? 'is-active' : '' ?>">
                                Institute Establishment Resolution
                            </a>
                        </li>
                        <li class="md-nav-item">
                            <a href="mandatory-disclosure.php?section=rti-booklet" class="md-nav-link <?= ($activeSectionKey === 'rti-booklet') ? 'is-active' : '' ?>">
                                RTI Booklet (2005)
                            </a>
                        </li>
                    </ul>
                </div>

            </aside>

            <!-- Main Content Area -->
            <main class="md-content-card">
                
                <!-- Content Top Bar with Breadcrumbs -->
                <div class="md-content-header">
                    <h1 class="md-title"><?= htmlspecialchars($currentSection['title']) ?></h1>
                    <div class="md-breadcrumbs">
                        <a href="index.php" title="Home"><i class="fas fa-home"></i></a>
                        <span class="sep">/</span>
                        <a href="overview.php">About</a>
                        <span class="sep">/</span>
                        <span><?= htmlspecialchars($currentSection['title']) ?></span>
                    </div>
                </div>

                <?php if ($isCommittee): ?>
                    <!-- ============================================== -->
                    <!-- CAMPUS COMMITTEE VIEW                          -->
                    <!-- ============================================== -->
                    <?php if ($committeeInfo): ?>
                        <div class="md-body-text">
                            <?php 
                            $paragraphs = explode("\n\n", $committeeInfo['description'] ?? '');
                            foreach ($paragraphs as $p):
                                $trimmed = trim($p);
                                if (!empty($trimmed)):
                            ?>
                                <p><?= nl2br(htmlspecialchars($trimmed)) ?></p>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>

                        <?php if (!empty($committeeInfo['objectives'])): ?>
                            <h2 class="md-section-subtitle">Objectives</h2>
                            <div class="md-body-text">
                                <?= nl2br(htmlspecialchars($committeeInfo['objectives'])) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($committeeInfo['vision'])): ?>
                            <h2 class="md-section-subtitle">Vision</h2>
                            <div class="md-body-text">
                                <p><?= nl2br(htmlspecialchars($committeeInfo['vision'])) ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($committeeInfo['mission'])): ?>
                            <h2 class="md-section-subtitle">Mission</h2>
                            <div class="md-body-text">
                                <p><?= nl2br(htmlspecialchars($committeeInfo['mission'])) ?></p>
                            </div>
                        <?php endif; ?>

                        <!-- Committee Members Table matching screenshot -->
                        <h2 class="md-section-subtitle" style="margin-top: 32px;"><?= htmlspecialchars($committeeInfo['committee_name']) ?></h2>

                        <div class="md-table-wrap">
                            <table class="md-table">
                                <thead>
                                    <tr>
                                        <th class="sr-col">Sr. No.</th>
                                        <th>Name of Faculty</th>
                                        <th>Designation</th>
                                        <th><?= ($currentSection['slug'] === 'women-development-cell') ? 'Mail ID' : 'Role' ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($committeeMembers)): ?>
                                        <tr>
                                            <td colspan="4" style="text-align: center; padding: 24px; color: #64748b;">
                                                Committee member list is currently being updated.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($committeeMembers as $mem): ?>
                                            <tr>
                                                <td class="sr-col"><?= htmlspecialchars($mem['sr_no']) ?></td>
                                                <td class="faculty-col"><?= htmlspecialchars($mem['faculty_name']) ?></td>
                                                <td><?= htmlspecialchars($mem['designation'] ?? '') ?></td>
                                                <td class="role-col">
                                                    <?php if ($currentSection['slug'] === 'women-development-cell' && filter_var($mem['role_or_email'], FILTER_VALIDATE_EMAIL)): ?>
                                                        <a href="mailto:<?= htmlspecialchars($mem['role_or_email']) ?>" style="color: #0284c7; text-decoration: none;">
                                                            <?= htmlspecialchars($mem['role_or_email']) ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <?= htmlspecialchars($mem['role_or_email'] ?? '') ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="md-empty-banner">
                            <i class="fas fa-info-circle"></i>
                            <h4>Information Being Updated</h4>
                            <p>Committee details will be available shortly.</p>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <!-- ============================================== -->
                    <!-- MANDATORY DISCLOSURE DOCUMENTS VIEW (PDF)      -->
                    <!-- ============================================== -->
                    <div class="md-body-text">
                        <p><?= htmlspecialchars($currentSection['desc']) ?></p>
                    </div>

                    <?php if (empty($disclosureDocuments)): ?>
                        <div class="md-empty-banner">
                            <i class="fas fa-file-pdf"></i>
                            <h4>Statutory Documents in Progress</h4>
                            <p>Official disclosure documents for <?= htmlspecialchars($currentSection['title']) ?> are being updated for the current academic session.</p>
                        </div>
                    <?php else: ?>
                        <div class="md-table-wrap">
                            <table class="md-table">
                                <thead>
                                    <tr>
                                        <th class="sr-col">Sr. No.</th>
                                        <th>Document Title</th>
                                        <th style="width: 160px;">Academic Year</th>
                                        <th style="width: 120px;">File Details</th>
                                        <th style="width: 150px; text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($disclosureDocuments as $idx => $doc): ?>
                                        <tr>
                                            <td class="sr-col"><?= $idx + 1 ?></td>
                                            <td class="faculty-col">
                                                <?= htmlspecialchars($doc['title']) ?>
                                            </td>
                                            <td><?= htmlspecialchars($doc['academic_year'] ?? '-') ?></td>
                                            <td>
                                                <span style="color: #64748b; font-size: 13px;">
                                                    <i class="fas fa-file-pdf" style="color: #dc2626;"></i> <?= htmlspecialchars($doc['file_size'] ?? 'PDF') ?>
                                                </span>
                                            </td>
                                            <td style="text-align: center;">
                                                <a href="<?= htmlspecialchars($doc['file_path']) ?>" target="_blank" class="btn-doc-download">
                                                    <i class="fas fa-download"></i> View / Download
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                <?php endif; ?>

            </main>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

