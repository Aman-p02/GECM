<?php
// Page configuration
$page_title = "Mechanical Engineering Department - Government Engineering College, Modasa";
$active_page = "departments";
$root_path = "../../";
$extra_css = "departments/mechanical/css/department.css";
$extra_js = "departments/mechanical/js/department.js";

// Include Header
include_once __DIR__ . '/../../includes/header.php';
?>

<!-- Department Header Banner -->
<section class="dept-hero-banner">
    <div class="container">
        <div class="dept-hero-content">
            <span class="dept-badge">Department Portal</span>
            <h1 class="dept-title">Mechanical Engineering</h1>
            <p class="dept-subtitle">Government Engineering College, Modasa</p>
        </div>
    </div>
</section>

<!-- Main Department Content Canvas (Ready for New Design) -->
<div class="dept-page-wrapper">
    <div class="container">
        <div class="dept-canvas-container" id="deptCanvas">
            <!-- New design content will be placed here -->
        </div>
    </div>
</div>

<?php
// Include Footer
include_once __DIR__ . '/../../includes/footer.php';
?>
