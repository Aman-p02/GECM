<?php
$page_title = "Academic Programmes & Approved Intake | Government Engineering College, Modasa";
$active_page = "academics";
$root_path = "";
$extra_css = "css/courses.css";

require_once __DIR__ . '/includes/header.php';
?>

<div class="courses-page" id="mainContent">

    <!-- Page Hero Banner -->
    <header class="courses-hero">
        <div class="container">
            <span class="courses-kicker">ACADEMIC PROGRAMMES</span>
            <h1 class="courses-heading">Approved Degrees &amp; Course Intake</h1>
            <p class="courses-lead">
                Government Engineering College, Modasa offers AICTE-approved undergraduate and postgraduate programmes affiliated with Gujarat Technological University (GTU), Ahmedabad. Admissions are conducted through ACPC Gujarat.
            </p>

            <!-- Key metrics stats grid -->
            <div class="courses-stats-grid">
                <div class="courses-stat-card">
                    <span class="courses-stat-num">7</span>
                    <span class="courses-stat-label">UG (B.E.) Programmes</span>
                </div>
                <div class="courses-stat-card">
                    <span class="courses-stat-num">2</span>
                    <span class="courses-stat-label">PG (M.E.) Programmes</span>
                </div>
                <div class="courses-stat-card">
                    <span class="courses-stat-num">540</span>
                    <span class="courses-stat-label">Total Annual UG Intake</span>
                </div>
                <div class="courses-stat-card">
                    <span class="courses-stat-num">36</span>
                    <span class="courses-stat-label">Total Annual PG Intake</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Tables -->
    <main class="courses-content">
        <div class="container">

            <!-- Section 1: Under Graduate Courses -->
            <section class="courses-section" aria-labelledby="ugCoursesHeading">
                <div class="courses-section-header">
                    <span class="courses-section-kicker">4-YEAR BACHELOR OF ENGINEERING (B.E.)</span>
                    <h2 class="courses-section-title" id="ugCoursesHeading">Under Graduate Courses</h2>
                    <p class="courses-section-desc">
                        Undergraduate engineering degrees emphasizing strong theoretical foundations, practical laboratory experimentation, and industry readiness.
                    </p>
                </div>

                <div class="courses-table-card">
                    <div class="courses-table-wrap">
                        <table class="courses-table">
                            <thead>
                                <tr>
                                    <th>Program</th>
                                    <th>Commencement Year</th>
                                    <th>Present Intake</th>
                                    <th>Course Code as per (GTU)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="course-program-cell">
                                        <a href="<?= $root_path ?>departments/automobile/" class="course-program-link">
                                            <span>Automobile Engineering</span>
                                            <i class="fas fa-arrow-up-right-from-square"></i>
                                        </a>
                                    </td>
                                    <td class="course-year-cell">2008</td>
                                    <td><span class="course-intake-badge">30 Seats</span></td>
                                    <td><span class="course-code-pill">02</span></td>
                                </tr>
                                <tr>
                                    <td class="course-program-cell">
                                        <span>Civil Engineering</span>
                                    </td>
                                    <td class="course-year-cell">1984</td>
                                    <td><span class="course-intake-badge">120 Seats</span></td>
                                    <td><span class="course-code-pill">06</span></td>
                                </tr>
                                <tr>
                                    <td class="course-program-cell">
                                        <a href="<?= $root_path ?>departments/computer/" class="course-program-link">
                                            <span>Computer Engineering</span>
                                            <i class="fas fa-arrow-up-right-from-square"></i>
                                        </a>
                                    </td>
                                    <td class="course-year-cell">2001</td>
                                    <td><span class="course-intake-badge">120 Seats</span></td>
                                    <td><span class="course-code-pill">07</span></td>
                                </tr>
                                <tr>
                                    <td class="course-program-cell">
                                        <a href="<?= $root_path ?>departments/information-technology/" class="course-program-link">
                                            <span>Information and Technology</span>
                                            <i class="fas fa-arrow-up-right-from-square"></i>
                                        </a>
                                    </td>
                                    <td class="course-year-cell">1999</td>
                                    <td><span class="course-intake-badge">120 Seats</span></td>
                                    <td><span class="course-code-pill">16</span></td>
                                </tr>
                                <tr>
                                    <td class="course-program-cell">
                                        <span>Electrical Engineering</span>
                                    </td>
                                    <td class="course-year-cell">1984</td>
                                    <td><span class="course-intake-badge">60 Seats</span></td>
                                    <td><span class="course-code-pill">09</span></td>
                                </tr>
                                <tr>
                                    <td class="course-program-cell">
                                        <span>Electronics and Communications</span>
                                    </td>
                                    <td class="course-year-cell">1991</td>
                                    <td><span class="course-intake-badge">30 Seats</span></td>
                                    <td><span class="course-code-pill">11</span></td>
                                </tr>
                                <tr>
                                    <td class="course-program-cell">
                                        <a href="<?= $root_path ?>departments/mechanical/" class="course-program-link">
                                            <span>Mechanical Engineering</span>
                                            <i class="fas fa-arrow-up-right-from-square"></i>
                                        </a>
                                        <span class="course-nba-pill">NBA Accredited</span>
                                    </td>
                                    <td class="course-year-cell">1989</td>
                                    <td><span class="course-intake-badge">60 Seats</span></td>
                                    <td><span class="course-code-pill">19</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Section 2: Post Graduate Courses -->
            <section class="courses-section" aria-labelledby="pgCoursesHeading">
                <div class="courses-section-header">
                    <span class="courses-section-kicker">2-YEAR MASTER OF ENGINEERING (M.E.)</span>
                    <h2 class="courses-section-title" id="pgCoursesHeading">Post Graduate Courses</h2>
                    <p class="courses-section-desc">
                        Advanced postgraduate research and specialization degrees providing focused mastery in computing technologies and transportation engineering.
                    </p>
                </div>

                <div class="courses-table-card">
                    <div class="courses-table-wrap">
                        <table class="courses-table">
                            <thead>
                                <tr>
                                    <th>Program</th>
                                    <th>Commencement Year</th>
                                    <th>Present Intake</th>
                                    <th>Course Code as per (GTU)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="course-program-cell">
                                        <a href="<?= $root_path ?>departments/computer/" class="course-program-link">
                                            <span>Computer Engineering (Software Engineering)</span>
                                            <i class="fas fa-arrow-up-right-from-square"></i>
                                        </a>
                                    </td>
                                    <td class="course-year-cell">2010</td>
                                    <td><span class="course-intake-badge">18 Seats</span></td>
                                    <td><span class="course-code-pill">73</span></td>
                                </tr>
                                <tr>
                                    <td class="course-program-cell">
                                        <span>Transportation Engineering</span>
                                    </td>
                                    <td class="course-year-cell">2010</td>
                                    <td><span class="course-intake-badge">18 Seats</span></td>
                                    <td><span class="course-code-pill">69</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>
    </main>

</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>

