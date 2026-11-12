<?php
// Set Page Variables
$page_title = "Developers Team - Government Engineering College, Modasa";
$page_description = "Meet the developers and technical team behind the design, architecture, and development of the Government Engineering College, Modasa official digital portal.";
$page_keywords = "GEC Modasa Developers, GECM Web Team, Government Engineering College Modasa Web Portal Developers";
$active_page = "developers";
$root_path = "";

// Include Header
include_once __DIR__ . '/includes/header.php';
?>

<style>
.dev-hero {
    background: linear-gradient(135deg, #0b192c 0%, #1e3e62 100%);
    color: #ffffff;
    padding: 90px 20px 80px 20px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.dev-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 50% 30%, rgba(255, 101, 0, 0.15), transparent 70%);
    pointer-events: none;
}

.dev-container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 2;
}

.dev-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 101, 0, 0.18);
    border: 1px solid rgba(255, 101, 0, 0.4);
    color: #ff914d;
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.dev-title {
    font-size: 2.8rem;
    font-weight: 800;
    margin-bottom: 16px;
    letter-spacing: -0.5px;
}

.dev-subtitle {
    font-size: 1.15rem;
    color: #cbd5e1;
    max-width: 680px;
    margin: 0 auto 28px auto;
    line-height: 1.6;
}

/* Coming Soon Showcase Card */
.dev-showcase {
    padding: 70px 20px;
    background: #f8fafc;
    min-height: 480px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.dev-card-coming {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    padding: 60px 30px;
    text-align: center;
    max-width: 650px;
    width: 100%;
}

.dev-icon-circle {
    width: 86px;
    height: 86px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(30, 62, 98, 0.1), rgba(255, 101, 0, 0.15));
    color: #ff6500;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 38px;
    margin: 0 auto 24px auto;
}

.dev-card-coming h2 {
    font-size: 1.9rem;
    font-weight: 700;
    color: #0b192c;
    margin-bottom: 12px;
}

.dev-card-coming p {
    font-size: 1rem;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 30px;
}

.dev-btn-home {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #0b192c;
    color: #ffffff !important;
    padding: 12px 28px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14.5px;
    transition: all 0.25s ease;
}

.dev-btn-home:hover {
    background: #ff6500;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 101, 0, 0.25);
}
</style>

<section class="dev-hero">
    <div class="dev-container">
        <span class="dev-badge"><i class="fas fa-code"></i> Engineering &amp; Innovation</span>
        <h1 class="dev-title">Developers Team</h1>
        <p class="dev-subtitle">
            The student engineers, technical architects, and designers responsible for crafting the modern web infrastructure of Government Engineering College, Modasa.
        </p>
    </div>
</section>

<section class="dev-showcase">
    <div class="dev-card-coming">
        <div class="dev-icon-circle">
            <i class="fas fa-laptop-code"></i>
        </div>
        <h2>Profile Showcase Coming Soon</h2>
        <p>
            The dedicated team portfolio, contributor profiles, system architecture highlights, and credits for GEC Modasa portal development will be published here shortly.
        </p>
        <a href="<?= $root_path ?>index.php" class="dev-btn-home">
            <i class="fas fa-arrow-left"></i> Return to Homepage
        </a>
    </div>
</section>

<?php
// Include Footer
include_once __DIR__ . '/includes/footer.php';
?>
