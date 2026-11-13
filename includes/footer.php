    <!-- Footer -->
    <footer id="contact" class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col about-col">
                    <div class="footer-logo-container">
                        <div class="footer-logo-bg">
                            <img src="<?= $root_path ?? '' ?>logos/logo.png" alt="Logo" class="footer-logo">
                        </div>
                        <span class="footer-logo-text">GEC Modasa, Gujarat</span>
                    </div>
                    <p>Government Engineering College, Modasa aims to impart quality technical education and foster
                        holistic development of students to meet the global challenges.</p>
                    <div class="social-links footer-socials">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-col links-col">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="<?= ($root_path ?? '') ?>overview.php"><i class="fas fa-angle-right"></i> About GECM</a></li>
                        <li><a href="<?= ($root_path ?? '') ?>principal.php"><i class="fas fa-angle-right"></i> Principal Profile</a></li>
                        <li><a href="<?= ($root_path ?? '') ?>council-of-heads.php"><i class="fas fa-angle-right"></i> Council of Heads</a></li>
                        <li><a href="<?= ($root_path ?? '') ?>facilities.php"><i class="fas fa-angle-right"></i> Facilities</a></li>
                        <li><a href="<?= ($root_path ?? '') ?>mandatory-disclosure.php"><i class="fas fa-angle-right"></i> Mandatory Disclosures</a></li>
                        <li><a href="<?= ($root_path ?? '') ?>committees.php?c=anti-ragging"><i class="fas fa-angle-right"></i> Anti-Ragging Committee</a></li>
                        <li><a href="<?= ($root_path ?? '') ?>admission.php"><i class="fas fa-angle-right"></i> Admissions</a></li>
                        <li><a href="<?= ($root_path ?? '') ?>courses.php"><i class="fas fa-angle-right"></i> Courses &amp; Intake</a></li>
                        <li><a href="<?= ($root_path ?? '') ?>contact.php"><i class="fas fa-angle-right"></i> Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-col contact-col">
                    <h3>Contact Us</h3>
                    <ul class="contact-list">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Shamlaji Road, Modasa,<br>Dist. Aravalli, Gujarat - 383315</span>
                        </li>
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            <span>+91 2774 242631</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>gec-modasa-dte@gujarat.gov.in</span>
                        </li>
                    </ul>
                </div>
                <div class="footer-col dev-col">
                    <h3>Developers Team</h3>
                    <ul>
                        <li><a href="<?= $root_path ?? '' ?>developers/"><i class="fas fa-angle-right"></i> View Developers</a></li>
                    </ul>
                </div>
                <div class="footer-col map-col">
                    <h3>Location</h3>
                    <div class="map-container">
                        <iframe
                            src="https://maps.google.com/maps?q=Government+Engineering+College+Modasa,+Shamlaji+Road,+Modasa,+Gujarat+383315&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                            width="100%" height="150" style="border:0; border-radius: 8px;" allowfullscreen=""
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            title="Government Engineering College Modasa Map"></iframe>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Government Engineering College, Modasa. All Rights Reserved. Designed for GEC Modasa.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Floating Button -->
    <button type="button" id="backToTopBtn" class="back-to-top-btn" aria-label="Back to Top" title="Back to Top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="<?= $root_path ?? '' ?>js/global.js?v=<?= file_exists(__DIR__ . '/../js/global.js') ? filemtime(__DIR__ . '/../js/global.js') : time() ?>"></script>
<?php if (isset($extra_js)): ?>
    <?php if (is_array($extra_js)): ?>
        <?php foreach ($extra_js as $js_file): ?>
    <script src="<?= ($root_path ?? '') . htmlspecialchars($js_file); ?>?v=<?= file_exists(__DIR__ . '/../' . $js_file) ? filemtime(__DIR__ . '/../' . $js_file) : time() ?>"></script>
        <?php endforeach; ?>
    <?php else: ?>
    <script src="<?= ($root_path ?? '') . htmlspecialchars($extra_js); ?>?v=<?= file_exists(__DIR__ . '/../' . $extra_js) ? filemtime(__DIR__ . '/../' . $extra_js) : time() ?>"></script>
    <?php endif; ?>
<?php endif; ?>
</body>

</html>
