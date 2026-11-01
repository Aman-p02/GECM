<?php
$page_title = "Contact Us | Government Engineering College, Modasa";
$active_page = "contact";
$root_path = "";
$extra_css = "css/contact.css";

require_once __DIR__ . '/includes/header.php';
?>

<div class="contact-page" id="mainContent">

    <!-- Page Hero Banner -->
    <header class="contact-hero">
        <div class="container">
            <span class="contact-kicker">GET IN TOUCH</span>
            <h1 class="contact-heading">Contact Us</h1>
            <p class="contact-lead">
                Reach out to Government Engineering College, Modasa for academic inquiries, admissions, administration, and campus visits.
            </p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="contact-content">
        <div class="container">

            <!-- Contact Grid (Map & Campus Details) -->
            <div class="contact-grid">

                <!-- Left Column: Interactive Map -->
                <div class="contact-map-card">
                    <div class="contact-map-header">
                        <div class="contact-card-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <div>
                            <h2 class="contact-card-title">Campus Location</h2>
                            <p class="contact-card-subtitle">Shamlaji Road, Modasa, Gujarat</p>
                        </div>
                    </div>
                    <div class="contact-map-frame">
                        <iframe
                            src="https://maps.google.com/maps?q=Government+Engineering+College+Modasa,+Shamlaji+Road,+Modasa,+Gujarat+383315&amp;t=&amp;z=16&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Government Engineering College Modasa Campus Map">
                        </iframe>
                    </div>
                </div>

                <!-- Right Column: Campus Details & Working Hours -->
                <div class="contact-info-column">

                    <!-- College Campus Info Card -->
                    <div class="contact-info-card">
                        <h2 class="contact-section-title">College Campus</h2>
                        <ul class="contact-details-list">
                            <li class="contact-item">
                                <div class="contact-item-icon">
                                    <i class="fas fa-home"></i>
                                </div>
                                <div class="contact-item-content">
                                    <span class="contact-item-label">Campus Address</span>
                                    <span class="contact-item-value">Shamlaji Road, Modasa, District Aravalli, Gujarat, India 383315</span>
                                </div>
                            </li>
                            <li class="contact-item">
                                <div class="contact-item-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-item-content">
                                    <span class="contact-item-label">Official Email</span>
                                    <a href="mailto:gec-modasa-dte@gujarat.gov.in" class="contact-item-link">gec-modasa-dte@gujarat.gov.in</a>
                                </div>
                            </li>
                            <li class="contact-item">
                                <div class="contact-item-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="contact-item-content">
                                    <span class="contact-item-label">Phone Numbers</span>
                                    <span class="contact-item-value">
                                        <a href="tel:+9102774242633" class="contact-item-link">(+91) 02774 242 633</a> / 
                                        <a href="tel:+9102774242634" class="contact-item-link">634</a>
                                    </span>
                                </div>
                            </li>
                            <li class="contact-item">
                                <div class="contact-item-icon">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div class="contact-item-content">
                                    <span class="contact-item-label">Official Website</span>
                                    <a href="http://www.gecmodasa.ac.in" target="_blank" rel="noopener noreferrer" class="contact-item-link">http://www.gecmodasa.ac.in</a>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Working Hours Card -->
                    <div class="contact-info-card">
                        <h2 class="contact-section-title">Working Hours</h2>
                        <ul class="contact-hours-list">
                            <li class="hours-row">
                                <span class="hours-day">Monday &ndash; Friday:</span>
                                <span class="hours-time">10:30am to 6:10pm</span>
                            </li>
                            <li class="hours-row">
                                <span class="hours-day">Saturday:</span>
                                <span class="hours-time">10:30am to 6:10pm <span class="hours-badge">Closed on 2nd &amp; 4th</span></span>
                            </li>
                            <li class="hours-row closed">
                                <span class="hours-day">Sunday:</span>
                                <span class="hours-time">Closed</span>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>

            <!-- "Why we are?" Mission Statement Section -->
            <div class="contact-mission-card">
                <div class="contact-mission-header">
                    <h2 class="contact-section-title">Why we are?</h2>
                </div>
                <div class="contact-mission-body">
                    <p>The mission of Government Engineering College, Modasa is to deliver technical programs and service to meet the changing need of society and industry and thereby contribute to the overall techno-economical development of the State in particular and national in general and improve quality of life of communities.</p>
                </div>
            </div>

        </div>
    </main>

</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>

