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
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3655.8070267710344!2d73.30058861543886!3d23.46740928472938!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395df3d0a0b22a07%3A0xc660d5b1beaf323e!2sGovernment%20Engineering%20College%20Modasa!5e0!3m2!1sen!2sin!4v1689255018698!5m2!1sen!2sin"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Government Engineering College Modasa Campus Map">
                        </iframe>
                    </div>
                    <div class="contact-map-footer">
                        <a href="https://maps.google.com/?q=Government+Engineering+College+Modasa" target="_blank" rel="noopener noreferrer" class="contact-map-btn">
                            <i class="fas fa-directions"></i> Open in Google Maps
                        </a>
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
