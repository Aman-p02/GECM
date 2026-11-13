<?php
$page_title = "Institutional Development Plan (IDP) :: Government Engineering College, Modasa";
$active_page = 'about';
$extra_css = 'css/idp.css';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

// Fetch active IDP document
$idpDoc = null;
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM idp_documents WHERE is_active = 1 ORDER BY id DESC LIMIT 1");
    $idpDoc = $stmt ? $stmt->fetch() : null;
}
?>

<div class="idp-hero">
    <div class="container" style="max-width: 1140px; margin: 0 auto; padding: 0 20px;">
        <div style="font-size: 13px; color: #93c5fd; margin-bottom: 8px;">
            <a href="index.php" style="color: #93c5fd; text-decoration: none;">Home</a> / 
            <a href="overview.php" style="color: #93c5fd; text-decoration: none;">About</a> / 
            <span style="color: #ffffff;">Institutional Development Plan</span>
        </div>
        <h1 class="idp-hero-title">Institutional Development Plan (IDP)</h1>
        <p class="idp-hero-subtitle">
            Strategic roadmap and long-term vision formulated under the National Education Policy (NEP 2020) and State Directorate of Technical Education for academic excellence, infrastructure modernization, and research innovation.
        </p>
    </div>
</div>

<div class="container" style="max-width: 1140px; margin: 0 auto 60px auto; padding: 0 20px;">
    
    <!-- IDP Document Download Box -->
    <?php if ($idpDoc): ?>
        <div class="idp-download-box">
            <div class="idp-download-info" style="display: flex; gap: 16px; align-items: center;">
                <div style="width: 50px; height: 50px; background: #dcfce7; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #16a34a; font-size: 24px; flex-shrink: 0;">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <div>
                    <h3><?= htmlspecialchars($idpDoc['title']) ?></h3>
                    <p>Planning Horizon: <strong><?= htmlspecialchars($idpDoc['cycle_years'] ?? '2025-2030') ?></strong> &bull; Size: <?= htmlspecialchars($idpDoc['file_size'] ?? 'PDF Document') ?></p>
                </div>
            </div>
            <div>
                <a href="<?= htmlspecialchars($idpDoc['file_path']) ?>" target="_blank" class="btn-idp-download">
                    <i class="fas fa-download"></i> Download Full IDP Document
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="idp-download-box" style="background: #f8fafc; border-color: #cbd5e1;">
            <div class="idp-download-info" style="display: flex; gap: 16px; align-items: center;">
                <div style="width: 50px; height: 50px; background: #e2e8f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 22px; flex-shrink: 0;">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <h3 style="color: #334155;">Institutional Development Plan (IDP) 2025-2030</h3>
                    <p style="color: #64748b;">The official document is being updated by the institutional planning committee.</p>
                </div>
            </div>
            <div>
                <span style="color: #64748b; font-size: 13px; font-weight: 500;">Document Available Soon</span>
            </div>
        </div>
    <?php endif; ?>

    <!-- Strategic Framework & Focus Areas -->
    <div class="idp-card">
        <h2 class="idp-section-title">
            <i class="fas fa-compass" style="color: #0284c7;"></i> Strategic Vision &amp; Objectives
        </h2>
        <p style="font-size: 14.5px; line-height: 1.7; color: #475569; margin-bottom: 20px;">
            The Institutional Development Plan of Government Engineering College, Modasa charts a progressive path towards transforming the institute into a center of engineering innovation, multidisciplinary research, and socially responsive technology education. Designed in synchronization with Gujarat Technological University (GTU) and the Government of Gujarat, the IDP defines strategic benchmarks across five core pillars.
        </p>

        <div class="idp-pillars-grid">
            <div class="idp-pillar-card">
                <h4><i class="fas fa-graduation-cap"></i> 1. Academic Excellence &amp; NEP 2020</h4>
                <p>Curriculum enrichment with multidisciplinary minors, project-based experiential learning, credit transfers, and enhanced digital pedagogy.</p>
            </div>
            <div class="idp-pillar-card">
                <h4><i class="fas fa-microscope"></i> 2. Research &amp; Innovation</h4>
                <p>Strengthening the SSIP &amp; DIC incubation hubs, sponsored faculty research projects, patent filings, and industry consultancy labs.</p>
            </div>
            <div class="idp-pillar-card">
                <h4><i class="fas fa-handshake"></i> 3. Industry Partnerships &amp; MoUs</h4>
                <p>Expanding industrial collaborations in North Gujarat and Sanand/Ahmedabad industrial belts for student internships and campus placements.</p>
            </div>
            <div class="idp-pillar-card">
                <h4><i class="fas fa-leaf"></i> 4. Sustainable &amp; Green Campus</h4>
                <p>Solar energy adoption, rooftop rainwater harvesting, smart campus surveillance, and modernized hostel living standards.</p>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

