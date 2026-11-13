<?php
$page_title = "Faculty Activities & Professional Development | Government Engineering College, Modasa";
$active_page = "faculty_activities";
$root_path = "";
$extra_css = "css/activities-hub.css";

require_once __DIR__ . '/includes/header.php';
?>

<div class="act-hub-page" id="mainContent">

    <!-- Page Hero Banner -->
    <header class="act-hero">
        <div class="act-hero-inner">
            <span class="act-kicker">ACADEMIC &amp; RESEARCH LEADERSHIP</span>
            <h1 class="act-heading" style="margin-bottom: 0;">Faculty Activities &amp; Development</h1>
        </div>
    </header>

    <!-- Clean Placeholder / Under Development State -->
    <main class="act-container" style="margin-top: 36px; margin-bottom: 60px;">
        <div style="background: #ffffff; border: 1px solid #eef2f6; border-radius: 16px; padding: 72px 24px; text-align: center; box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.03); max-width: 820px; margin: 0 auto;">
            <div style="width: 72px; height: 72px; border-radius: 50%; background: #fff7ed; color: #ff8800; display: inline-flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 20px; border: 1px solid rgba(255, 136, 0, 0.2);">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h2 style="font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif); font-size: 1.85rem; font-weight: 800; color: #111111; margin: 0 0 12px; letter-spacing: -0.02em;">
                Section Under Development
            </h2>
            <p style="color: #64748b; font-size: 1.02rem; line-height: 1.6; max-width: 540px; margin: 0 auto 28px;">
                The Faculty Activities portal is currently being updated with verified academic records, research publications, STTPs, and conference details across all departments.
            </p>
            <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                <a href="college-activities.php" class="btn" style="background: #111111; color: #ffffff; padding: 10px 22px; border-radius: 9999px; font-weight: 600; font-size: 0.90rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-calendar-alt"></i> College Activities
                </a>
                <a href="departmental-activities.php" class="btn" style="background: #f1f5f9; color: #1e293b; padding: 10px 22px; border-radius: 9999px; font-weight: 600; font-size: 0.90rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; border: 1px solid #e2e8f0;">
                    <i class="fas fa-layer-group"></i> Departmental Activities
                </a>
            </div>
        </div>
    </main>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
