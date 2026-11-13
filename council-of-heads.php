<?php
$page_title = "Council of Heads :: Government Engineering College, Modasa";
$active_page = 'council-of-heads';
$extra_css = 'css/council-of-heads.css';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

$principal = null;
$councilList = [];
$iqacList = [];
$hodList = [];
$cellsList = [];
$contactsList = [];

if ($pdo) {
    // Principal Info
    $pStmt = $pdo->query("SELECT name, designation FROM principal_profile LIMIT 1");
    $principal = $pStmt ? $pStmt->fetch() : null;

    // 1. Council of Heads
    $cStmt = $pdo->query("SELECT * FROM council_of_heads ORDER BY display_order ASC, id ASC");
    $councilList = $cStmt ? $cStmt->fetchAll() : [];

    // 2. IQAC Members
    $iqStmt = $pdo->query("SELECT * FROM iqac_members ORDER BY display_order ASC, id ASC");
    $iqacList = $iqStmt ? $iqStmt->fetchAll() : [];

    // 3. Head of Departments
    $hStmt = $pdo->query("SELECT * FROM head_of_departments ORDER BY display_order ASC, id ASC");
    $hodList = $hStmt ? $hStmt->fetchAll() : [];

    // 4. Important Cells & Committees
    $cellStmt = $pdo->query("SELECT * FROM important_cells ORDER BY display_order ASC, id ASC");
    $cellsList = $cellStmt ? $cellStmt->fetchAll() : [];

    // 5. Important Contacts
    $cntStmt = $pdo->query("SELECT * FROM important_contacts ORDER BY display_order ASC, id ASC");
    $contactsList = $cntStmt ? $cntStmt->fetchAll() : [];
}

$headOfInstitute = $principal['name'] ?? 'Prof. (Dr.) J. A. Vadher';
?>

<div class="coh-wrapper">
    <div class="coh-container">
        
        <!-- Breadcrumbs -->
        <div class="coh-breadcrumbs">
            <a href="index.php"><i class="fas fa-home"></i></a>
            <span style="color: #cbd5e1; margin: 0 6px;">/</span>
            <span>Administration</span>
            <span style="color: #cbd5e1; margin: 0 6px;">/</span>
            <span style="color: #1e293b; font-weight: 500;">Council of Heads</span>
        </div>

        <!-- Quick Jump Navigation -->
        <nav class="coh-nav-tabs" aria-label="Page Sections">
            <a href="#council-section" class="coh-tab-btn active"><i class="fas fa-users-cog"></i> Council of Head</a>
            <a href="#iqac-section" class="coh-tab-btn"><i class="fas fa-award"></i> IQAC Cell</a>
            <a href="#hod-section" class="coh-tab-btn"><i class="fas fa-user-tie"></i> Head of Department</a>
            <a href="#cells-section" class="coh-tab-btn"><i class="fas fa-sitemap"></i> Important Cells &amp; Committees</a>
            <a href="#contacts-section" class="coh-tab-btn"><i class="fas fa-phone-alt"></i> Important Contacts</a>
        </nav>

        <!-- 1. COUNCIL OF HEAD SECTION -->
        <section id="council-section" class="coh-section-card">
            <div class="coh-principal-banner">
                Head of the Institute: <?= htmlspecialchars($headOfInstitute) ?>
            </div>

            <div class="coh-title-wrap">
                <h2 class="coh-section-title">Council of Head</h2>
            </div>

            <div class="coh-table-wrap">
                <table class="coh-table">
                    <thead>
                        <tr>
                            <th style="width: 32%;">Sections</th>
                            <th style="width: 20%;">Designation</th>
                            <th style="width: 48%;">Section Head</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($councilList)): ?>
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 25px; color: #64748b;">No council information available.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($councilList as $row): ?>
                                <tr>
                                    <td class="coh-highlight-name"><?= htmlspecialchars($row['section_name']) ?></td>
                                    <td>
                                        <span class="coh-badge-convener"><?= htmlspecialchars($row['designation']) ?></span>
                                    </td>
                                    <td><?= htmlspecialchars($row['section_head']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 2. INTERNAL QUALITY ASSURANCE CELL (IQAC) -->
        <section id="iqac-section" class="coh-section-card">
            <div class="coh-title-wrap">
                <h2 class="coh-section-title">Internal Quality Assurance Cell</h2>
            </div>

            <p class="coh-description-text">
                To maintain the momentum of quality consciousness is crucial in colleges. Every college should have an internal quality assurance system. with appropriate structure and processes, and with enough flexibility to meet the diverse need of the stakeholders. Thus, Government Engineering College, Modasa is forming the "Internal Quality Assurance Cell". The IQAC is meant for planning, guiding and monitoring Quality Assurance and Quality enhancement activities of the GEC, Modasa. The IQAC may channelize and systematize the efforts and measures of GEC, Modasa towards academic excellence. IQAC Cell having below members is formed for above mentioned task.
            </p>

            <div class="coh-table-wrap">
                <table class="coh-table">
                    <thead>
                        <tr>
                            <th style="width: 32%;">Name</th>
                            <th style="width: 48%;">Designation</th>
                            <th style="width: 20%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($iqacList)): ?>
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 25px; color: #64748b;">No IQAC members found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($iqacList as $row): ?>
                                <tr>
                                    <td class="coh-highlight-name"><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['designation']) ?></td>
                                    <td>
                                        <?php if ($row['status_role'] === 'Chairman'): ?>
                                            <span class="coh-badge-chairman"><?= htmlspecialchars($row['status_role']) ?></span>
                                        <?php elseif ($row['status_role'] === 'Convener'): ?>
                                            <span class="coh-badge-convener"><?= htmlspecialchars($row['status_role']) ?></span>
                                        <?php else: ?>
                                            <span style="color: #475569; font-weight: 500;"><?= htmlspecialchars($row['status_role']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 3. HEAD OF DEPARTMENT -->
        <section id="hod-section" class="coh-section-card">
            <div class="coh-title-wrap">
                <h2 class="coh-section-title">Head of Department</h2>
            </div>

            <div class="coh-table-wrap">
                <table class="coh-table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Department</th>
                            <th style="width: 25%;">Designation</th>
                            <th style="width: 35%;">Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($hodList)): ?>
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 25px; color: #64748b;">No department heads listed.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($hodList as $row): ?>
                                <tr>
                                    <td class="coh-highlight-name"><?= htmlspecialchars($row['department_name']) ?></td>
                                    <td><?= htmlspecialchars($row['designation']) ?></td>
                                    <td style="font-weight: 600; color: #0284c7;"><?= htmlspecialchars($row['faculty_name']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 4. IMPORTANT CELLS AND COMMITTEES -->
        <section id="cells-section" class="coh-section-card">
            <div class="coh-title-wrap">
                <h2 class="coh-section-title">Important Cells and Committees</h2>
            </div>

            <div class="coh-table-wrap">
                <table class="coh-table">
                    <thead>
                        <tr>
                            <th style="width: 38%;">Cells</th>
                            <th style="width: 20%;">Designation</th>
                            <th style="width: 42%;">Name of Officer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($cellsList)): ?>
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 25px; color: #64748b;">No cells or committees available.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($cellsList as $row): ?>
                                <tr>
                                    <td class="coh-highlight-name"><?= htmlspecialchars($row['cell_name']) ?></td>
                                    <td>
                                        <span class="coh-badge-convener"><?= htmlspecialchars($row['designation']) ?></span>
                                    </td>
                                    <td><?= htmlspecialchars($row['officer_name']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 5. IMPORTANT CONTACTS -->
        <section id="contacts-section" class="coh-section-card">
            <div class="coh-title-wrap">
                <h2 class="coh-section-title">Important Contacts</h2>
            </div>

            <div class="coh-table-wrap">
                <table class="coh-table">
                    <thead>
                        <tr>
                            <th style="width: 10%; text-align: center;">Sr.</th>
                            <th style="width: 55%;">Organization / Authority</th>
                            <th style="width: 35%;">Contact Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($contactsList)): ?>
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 25px; color: #64748b;">No emergency contacts available.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($contactsList as $row): ?>
                                <tr>
                                    <td style="text-align: center; font-weight: 600; color: #64748b;"><?= (int)$row['sr_no'] ?></td>
                                    <td class="coh-highlight-name"><?= htmlspecialchars($row['organization_name']) ?></td>
                                    <td>
                                        <a href="tel:<?= preg_replace('/[^0-9+]/', '', $row['contact_number']) ?>" class="coh-contact-link">
                                            <i class="fas fa-phone-alt"></i> <?= htmlspecialchars($row['contact_number']) ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</div>

<script>
// Smooth scroll & active tab highlighting
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.coh-tab-btn');
    const sections = document.querySelectorAll('.coh-section-card');

    window.addEventListener('scroll', function() {
        let current = '';
        sections.forEach(function(section) {
            const sectionTop = section.offsetTop - 120;
            if (window.pageYOffset >= sectionTop) {
                current = '#' + section.getAttribute('id');
            }
        });

        tabs.forEach(function(tab) {
            tab.classList.remove('active');
            if (tab.getAttribute('href') === current) {
                tab.classList.add('active');
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

