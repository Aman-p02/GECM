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
                        <li><a href="<?= $root_path ?? '' ?>#about"><i class="fas fa-angle-right"></i> About GECM</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Admissions</a></li>
                        <li><a href="<?= $root_path ?? '' ?>#departments"><i class="fas fa-angle-right"></i> Academics</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Placements</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Anti-Ragging Cell</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Grievance Redressal</a></li>
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
                <div class="footer-col map-col">
                    <h3>Location</h3>
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3655.8070267710344!2d73.30058861543886!3d23.46740928472938!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395df3d0a0b22a07%3A0xc660d5b1beaf323e!2sGovernment%20Engineering%20College%20Modasa!5e0!3m2!1sen!2sin!4v1689255018698!5m2!1sen!2sin"
                            width="100%" height="150" style="border:0; border-radius: 8px;" allowfullscreen=""
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Government Engineering College, Modasa. All Rights Reserved. Designed for GEC Modasa.</p>
            </div>
        </div>
    </footer>

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
