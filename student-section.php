<?php
$page_title = "Student Section | Government Engineering College, Modasa";
$active_page = 'student-section';
$extra_css = 'css/student-section.css';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

// Define the 14 tabs
$allTabs = [
    ['id' => 'tab-about', 'name' => 'About', 'icon' => 'fas fa-university'],
    ['id' => 'tab-registration', 'name' => 'Registration Process', 'icon' => 'fas fa-user-plus'],
    ['id' => 'tab-fees-structure', 'name' => 'Fees Structure', 'icon' => 'fas fa-file-invoice-dollar'],
    ['id' => 'tab-fees-payment', 'name' => 'Fees Payment', 'icon' => 'fas fa-credit-card'],
    ['id' => 'tab-bus-concession', 'name' => 'Bus concession', 'icon' => 'fas fa-bus'],
    ['id' => 'tab-admission-cancellation', 'name' => 'Admission Cancellation', 'icon' => 'fas fa-user-times'],
    ['id' => 'tab-institute-transfer', 'name' => 'Institute Transfer', 'icon' => 'fas fa-exchange-alt'],
    ['id' => 'tab-student-icard', 'name' => 'Student I-Card', 'icon' => 'fas fa-id-card'],
    ['id' => 'tab-gtu-certificates', 'name' => 'GTU Certificates', 'icon' => 'fas fa-certificate'],
    ['id' => 'tab-bonafide-certificate', 'name' => 'Bonafide / Character Certificate', 'icon' => 'fas fa-file-signature'],
    ['id' => 'tab-name-correction', 'name' => 'Name Correction', 'icon' => 'fas fa-edit'],
    ['id' => 'tab-transcript', 'name' => 'Transcript', 'icon' => 'fas fa-scroll'],
    ['id' => 'tab-no-due-certificate', 'name' => 'No Due Certificate', 'icon' => 'fas fa-check-double'],
    ['id' => 'tab-education-verification', 'name' => 'Student Education Verification', 'icon' => 'fas fa-user-check']
];
?>

<div class="student-page" id="mainContent">

    <!-- Page Hero Banner (Consistent with Vision & Mission, About & Activities Hub) -->
    <header class="student-hero">
        <div class="student-hero-inner">
            <span class="student-kicker">STUDENT CORNER</span>
            <h1 class="student-heading">Student Section</h1>
            <p class="student-lead">
                Central administrative service desk for admissions reporting, university enrollment, official certificates, fee structures, and student verification.
            </p>
        </div>
    </header>

    <!-- Sub-Navigation Bar -->
    <nav class="student-nav-bar" id="studentNav" aria-label="Student Section Navigation">
        <div class="student-nav-inner">

            <!-- Desktop View: All 14 Options Fully Visible at Once (Flex Wrap, No Scroll) -->
            <ul class="student-tabs-grid" role="tablist">
                <?php foreach ($allTabs as $index => $tab): ?>
                    <li class="student-tab-item">
                        <button type="button" 
                                class="student-tab-pill <?= ($index === 0) ? 'active' : '' ?>" 
                                data-target="<?= $tab['id'] ?>" 
                                data-name="<?= htmlspecialchars($tab['name']) ?>"
                                data-icon="<?= $tab['icon'] ?>"
                                role="tab" 
                                aria-selected="<?= ($index === 0) ? 'true' : 'false' ?>">
                            <i class="<?= $tab['icon'] ?>"></i> <?= htmlspecialchars($tab['name']) ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Mobile View: Clean Hamburger / Dropdown Toggle -->
            <div class="student-mobile-nav" id="mobileNavWrapper">
                <button type="button" class="student-mobile-toggle" id="mobileTabToggle" aria-expanded="false" aria-controls="mobileTabsDropdown">
                    <div class="mobile-toggle-current">
                        <span class="mobile-toggle-badge" id="mobileCurrentIcon"><i class="fas fa-university"></i></span>
                        <span class="mobile-toggle-text" id="mobileCurrentText">About</span>
                    </div>
                    <div class="mobile-toggle-action">
                        <span class="mobile-action-label">Menu</span>
                        <i class="fas fa-bars mobile-bars-icon" id="mobileToggleIcon"></i>
                    </div>
                </button>
                <div class="student-mobile-dropdown" id="mobileTabsDropdown">
                    <ul class="student-mobile-list" role="tablist">
                        <?php foreach ($allTabs as $index => $tab): ?>
                            <li class="student-mobile-item">
                                <button type="button" 
                                        class="student-mobile-btn <?= ($index === 0) ? 'active' : '' ?>" 
                                        data-target="<?= $tab['id'] ?>"
                                        data-name="<?= htmlspecialchars($tab['name']) ?>"
                                        data-icon="<?= $tab['icon'] ?>"
                                        role="tab">
                                    <i class="<?= $tab['icon'] ?>"></i> <?= htmlspecialchars($tab['name']) ?>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="student-main-content">
        <div class="student-card">

            <!-- ========================================================================= -->
            <!-- TAB 1: ABOUT -->
            <!-- ========================================================================= -->
            <div class="student-tab-pane active" id="tab-about">
                <div class="pane-title-wrap">
                    <span class="pane-kicker">ADMINISTRATIVE OVERVIEW</span>
                    <h2 class="pane-heading"><i class="fas fa-university"></i> About Student Section</h2>
                    <p class="pane-desc">Central Academic Administration &amp; Student Affairs Desk</p>
                </div>
                
                <p class="student-body-text">
                    The Student Section at Government Engineering College, Modasa serves as the central administrative hub connecting students with the college administration, Gujarat Technological University (GTU), and the Directorate of Technical Education (DTE), Government of Gujarat. The section is dedicated to delivering transparent, efficient, and student-focused academic administration throughout a student's degree journey.
                </p>

                <h3 class="student-subheading"><i class="fas fa-tasks" style="color: #009dff;"></i> Key Responsibilities &amp; Student Services</h3>
                <ul class="student-list">
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span>Processing ACPC admission reporting, student registration, and university enrollment verification.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span>Maintenance of permanent student academic records, branch registers, and university roll lists.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span>Issuance of official institutional certificates including Bonafide, Character, Leaving Certificate, and No Due clearance.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span>Coordination and endorsement of GSRTC student bus concession passes and railway concessions.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span>Administration and verification of government scholarship schemes including Digital Gujarat, MYSY, NSP, and PMSSS.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span>Facilitating GTU academic certificates, exam forms, transcripts, institute transfers, and third-party education verification.</span>
                    </li>
                </ul>

                <h3 class="student-subheading"><i class="fas fa-headset" style="color: #009dff;"></i> Helpdesk &amp; Office Information</h3>
                <div class="desk-grid">
                    <div class="desk-card">
                        <div class="desk-card-title"><i class="fas fa-map-marker-alt"></i> Office Location</div>
                        <p class="desk-card-val">Ground Floor, Administrative Block<br>GEC Modasa Campus</p>
                    </div>
                    <div class="desk-card">
                        <div class="desk-card-title"><i class="fas fa-clock"></i> Working Hours</div>
                        <p class="desk-card-val">10:30 AM to 05:30 PM (Mon to Sat)<br><small style="color: #64748b;">Lunch: 01:30 PM to 02:00 PM</small></p>
                    </div>
                    <div class="desk-card">
                        <div class="desk-card-title"><i class="fas fa-calendar-times"></i> Holidays</div>
                        <p class="desk-card-val">2nd &amp; 4th Saturdays, Sundays<br>&amp; Government Public Holidays</p>
                    </div>
                    <div class="desk-card">
                        <div class="desk-card-title"><i class="fas fa-envelope"></i> Contact Channel</div>
                        <p class="desk-card-val">gec-modasa-dte@gujarat.gov.in<br>Phone: +91 2774 242631</p>
                    </div>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 2: REGISTRATION PROCESS -->
            <!-- ========================================================================= -->
            <div class="student-tab-pane" id="tab-registration">
                <div class="pane-title-wrap">
                    <span class="pane-kicker">ADMISSION REPORTING</span>
                    <h2 class="pane-heading"><i class="fas fa-user-plus"></i> Registration Process</h2>
                    <p class="pane-desc">Mandatory Guidelines for ACPC Admitted Candidates &amp; GTU Enrollment</p>
                </div>

                <p class="student-body-text">
                    All candidates allotted admission to Government Engineering College, Modasa through the Admission Committee for Professional Courses (ACPC), Gujarat must complete the formal college registration process as outlined below:
                </p>

                <div class="step-container">
                    <div class="modern-step-card">
                        <div class="modern-step-badge">1</div>
                        <p class="modern-step-content"><strong>In-Person Reporting:</strong> Report to the GEC Modasa Student Section on the designated reporting dates as per the ACPC admission schedule.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">2</div>
                        <p class="modern-step-content"><strong>Allotment Verification:</strong> Present the original ACPC Admission Slip / Allotment Letter along with the token tuition fee payment receipt.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">3</div>
                        <p class="modern-step-content"><strong>Registration Form Submission:</strong> Fill out the college student bio-data registration form and paste two recent passport size photographs.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">4</div>
                        <p class="modern-step-content"><strong>Document Verification:</strong> Submit one set of self-attested photocopies of qualifying examination certificates and present originals for spot verification.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">5</div>
                        <p class="modern-step-content"><strong>Roll Number &amp; University Portal:</strong> Receive your temporary institute roll number. Once university enrollment numbers are announced, register on the GTU Student Portal (student.gtu.ac.in).</p>
                    </div>
                </div>

                <h3 class="student-subheading"><i class="fas fa-clipboard-check" style="color: #009dff;"></i> Mandatory Documents Checklist</h3>
                <ul class="student-list">
                    <li class="student-list-item"><i class="fas fa-check-circle student-list-icon"></i><span>ACPC Admission Allotment Letter and Token Fee Payment Receipt.</span></li>
                    <li class="student-list-item"><i class="fas fa-check-circle student-list-icon"></i><span>10th (SSC) Board Marksheet and Passing Certificate.</span></li>
                    <li class="student-list-item"><i class="fas fa-check-circle student-list-icon"></i><span>12th (HSC) Marksheet / Diploma Final Semester Marksheets.</span></li>
                    <li class="student-list-item"><i class="fas fa-check-circle student-list-icon"></i><span>School Leaving Certificate (LC) / Transfer Certificate (TC).</span></li>
                    <li class="student-list-item"><i class="fas fa-check-circle student-list-icon"></i><span>GUJCET / JEE Main Entrance Examination Scorecard.</span></li>
                    <li class="student-list-item"><i class="fas fa-check-circle student-list-icon"></i><span>Caste Certificate / Non-Creamy Layer (NCL) Certificate / EWS Certificate (if applicable).</span></li>
                    <li class="student-list-item"><i class="fas fa-check-circle student-list-icon"></i><span>Recent Passport Size Color Photographs (4 copies).</span></li>
                    <li class="student-list-item"><i class="fas fa-check-circle student-list-icon"></i><span>Photocopy of Student's Aadhar Card and Bank Passbook (for scholarship purposes).</span></li>
                </ul>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 3: FEES STRUCTURE -->
            <!-- ========================================================================= -->
            <div class="student-tab-pane" id="tab-fees-structure">
                <div class="pane-title-wrap">
                    <span class="pane-kicker">GOVERNMENT NORMS</span>
                    <h2 class="pane-heading"><i class="fas fa-file-invoice-dollar"></i> Fees Structure</h2>
                    <p class="pane-desc">Government Approved Tuition &amp; Term Fees for B.E. &amp; M.E. Programs</p>
                </div>

                <div class="theme-callout">
                    <div class="theme-callout-title"><i class="fas fa-female"></i> 100% Tuition Fee Exemption for Female Students</div>
                    <p class="theme-callout-body">
                        Under the <strong>Kanya Kelavani Policy</strong> of the Government of Gujarat, all female students admitted to Government Engineering College, Modasa receive <strong>100% Tuition Fee Exemption / Waiver</strong> across all undergraduate engineering programs.
                    </p>
                </div>

                <h3 class="student-subheading"><i class="fas fa-table" style="color: #009dff;"></i> Institutional Term Fees Breakdown</h3>
                <div class="theme-table-wrap">
                    <table class="theme-table">
                        <thead>
                            <tr>
                                <th style="width: 44%;">Fee Component</th>
                                <th style="width: 28%;">Bachelor of Engineering (B.E.)</th>
                                <th style="width: 28%;">Master of Engineering (M.E.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tuition Fee (Boys)</td>
                                <td style="font-weight: 600; color: #0f172a;">Rs. 1,500 / Year</td>
                                <td style="font-weight: 600; color: #0f172a;">Rs. 3,000 / Year</td>
                            </tr>
                            <tr>
                                <td>Tuition Fee (Girls - 100% Exemption)</td>
                                <td style="font-weight: 600; color: #16a34a;">Rs. 0 (Nil)</td>
                                <td style="font-weight: 600; color: #16a34a;">Rs. 0 (Nil)</td>
                            </tr>
                            <tr>
                                <td>Caution Money Deposit (Refundable)</td>
                                <td>Rs. 250 (One Time at Admission)</td>
                                <td>Rs. 250 (One Time at Admission)</td>
                            </tr>
                            <tr>
                                <td>Gymkhana &amp; Sports Activities Fee</td>
                                <td>Rs. 100 / Term</td>
                                <td>Rs. 100 / Term</td>
                            </tr>
                            <tr>
                                <td>Library &amp; Reading Room Fee</td>
                                <td>Rs. 50 / Term</td>
                                <td>Rs. 50 / Term</td>
                            </tr>
                            <tr>
                                <td>Internal Examination &amp; Stationery Fee</td>
                                <td>Rs. 50 / Term</td>
                                <td>Rs. 50 / Term</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <ul class="student-list">
                    <li class="student-list-item"><i class="fas fa-chevron-circle-right student-list-icon"></i><span>University Enrollment Fees and Semester Examination Fees are collected separately as per notifications issued by Gujarat Technological University (GTU).</span></li>
                    <li class="student-list-item"><i class="fas fa-chevron-circle-right student-list-icon"></i><span>Hostel Accommodation and Mess Fees are separate and subject to hostel admission criteria.</span></li>
                </ul>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 4: FEES PAYMENT -->
            <!-- ========================================================================= -->
            <div class="student-tab-pane" id="tab-fees-payment">
                <div class="pane-title-wrap">
                    <span class="pane-kicker">DIGITAL PAYMENTS</span>
                    <h2 class="pane-heading"><i class="fas fa-credit-card"></i> Fees Payment</h2>
                    <p class="pane-desc">Online Institutional Fee Collection Guidelines</p>
                </div>

                <p class="student-body-text">
                    To ensure digital accountability, safety, and transparent governance, all college term fees and institute dues must be paid exclusively through online payment channels. Cash transactions at college counters are strictly prohibited.
                </p>

                <div class="step-container">
                    <div class="modern-step-card">
                        <div class="modern-step-badge">1</div>
                        <p class="modern-step-content">Visit the official SBI Collect portal or the designated state e-payment platform.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">2</div>
                        <p class="modern-step-content">Select State of Corporate/Institution: <strong>Gujarat</strong> and Type: <strong>Educational Institutions</strong>.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">3</div>
                        <p class="modern-step-content">Select Educational Institution Name: <strong>GOVERNMENT ENGINEERING COLLEGE MODASA</strong>.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">4</div>
                        <p class="modern-step-content">Choose the appropriate payment category (e.g., <em>Term Fee / Admission Fee / Hostel Fee</em>).</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">5</div>
                        <p class="modern-step-content">Fill in your Enrollment Number, Branch, Semester, and Mobile Number accurately, then proceed with Net Banking, UPI, or Debit/Credit Card.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">6</div>
                        <p class="modern-step-content">Download and print the official transaction e-Receipt. Submit a copy to the student section counter for term registration endorsement.</p>
                    </div>
                </div>

                <div style="margin-top: 24px;">
                    <a href="https://www.onlinesbi.sbi/sbicollect/icollecthome.htm" target="_blank" rel="noopener noreferrer" class="theme-action-btn">
                        <i class="fas fa-external-link-alt"></i> Proceed to SBI Collect Portal
                    </a>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 5: BUS CONCESSION -->
            <!-- ========================================================================= -->
            <div class="student-tab-pane" id="tab-bus-concession">
                <div class="pane-title-wrap">
                    <span class="pane-kicker">COMMUTER SERVICES</span>
                    <h2 class="pane-heading"><i class="fas fa-bus"></i> Bus concession</h2>
                    <p class="pane-desc">GSRTC Student Bus Pass &amp; Commuter Concession Procedure</p>
                </div>

                <p class="student-body-text">
                    Students commuting daily to Government Engineering College, Modasa from towns and rural regions of Aravalli, Sabarkantha, Gandhinagar, and surrounding districts are eligible for subsidized bus travel concession passes provided by the Gujarat State Road Transport Corporation (GSRTC).
                </p>

                <h3 class="student-subheading"><i class="fas fa-route" style="color: #009dff;"></i> Procedure for Availing GSRTC Bus Concession</h3>
                <ul class="student-list">
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span>Collect the prescribed GSRTC Student Concession Pass Application Form from the college student section or from your local GSRTC Bus Station Concession Counter.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span>Fill in your details, departure bus station, destination station (GEC Modasa / Modasa ST Depot), and distance.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span>Attach a copy of your valid College ID Card and current term fee receipt.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span>Submit the form at the GEC Modasa Student Section counter for official verification, endorsement, and institutional seal by the Principal / Authorized Officer.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span>Present the endorsed form along with passport size photographs at the GSRTC Modasa Bus Depot Concession Counter to obtain your monthly or semester concession pass.</span>
                    </li>
                </ul>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 6: ADMISSION CANCELLATION -->
            <!-- ========================================================================= -->
            <div class="student-tab-pane" id="tab-admission-cancellation">
                <div class="pane-title-wrap">
                    <span class="pane-kicker">ADMISSION CLEARANCE</span>
                    <h2 class="pane-heading"><i class="fas fa-user-times"></i> Admission Cancellation</h2>
                    <p class="pane-desc">Formal Withdrawal &amp; Fee Refund Guidelines</p>
                </div>

                <p class="student-body-text">
                    Students who have secured admission at GEC Modasa and wish to withdraw or cancel their admission due to upgrade in subsequent ACPC rounds or personal circumstances must adhere to the official withdrawal procedure:
                </p>

                <div class="step-container">
                    <div class="modern-step-card">
                        <div class="modern-step-badge">1</div>
                        <p class="modern-step-content"><strong>Submit Formal Application:</strong> Prepare a formal written application requesting admission cancellation addressed to the Principal, stating clear reasons along with your ACPC Roll Number and branch.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">2</div>
                        <p class="modern-step-content"><strong>Parent / Guardian Consent:</strong> The application must bear the signatures of both the student and the parent / legal guardian.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">3</div>
                        <p class="modern-step-content"><strong>No Due Clearance:</strong> Obtain clearance signatures on the college No Due certificate from the parent department, central library, hostel, and accounts section.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">4</div>
                        <p class="modern-step-content"><strong>Submission of Documents:</strong> Submit the completed application, original fee receipt, ACPC allotment letter, and college ID card to the Student Section.</p>
                    </div>
                </div>

                <div class="theme-callout warning">
                    <div class="theme-callout-title"><i class="fas fa-exclamation-triangle"></i> Fee Refund Policy</div>
                    <p class="theme-callout-body">
                        Refund of tuition fees and security deposits is governed strictly as per ACPC Gujarat and AICTE withdrawal norms based on the official cutoff date of reporting.
                    </p>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 7: INSTITUTE TRANSFER -->
            <!-- ========================================================================= -->
            <div class="student-tab-pane" id="tab-institute-transfer">
                <div class="pane-title-wrap">
                    <span class="pane-kicker">INTER-COLLEGE MIGRATION</span>
                    <h2 class="pane-heading"><i class="fas fa-exchange-alt"></i> Institute Transfer</h2>
                    <p class="pane-desc">Gujarat Technological University (GTU) Inter-College Transfer Regulations</p>
                </div>

                <p class="student-body-text">
                    Inter-college institute transfers for degree engineering students are governed strictly by the statutory rules and calendar notifications issued by Gujarat Technological University (GTU).
                </p>

                <ul class="student-list">
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span><strong>Eligibility:</strong> Transfers are generally permissible at the beginning of the 3rd semester (2nd Year) for eligible students who have satisfied GTU progression criteria without pending disciplinary cases.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span><strong>Seat Availability:</strong> Transfer is strictly subject to the availability of clear vacant seats in the relevant branch at the receiving institute.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span><strong>NOC Requirements:</strong> Students must obtain a formal No Objection Certificate (NOC) from both the parent college (GEC Modasa) and the proposed receiving college.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span><strong>GTU Portal Application:</strong> Submit the transfer application through the GTU Student Portal (student.gtu.ac.in) along with requisite university fees within the announced timeline.</span>
                    </li>
                </ul>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 8: STUDENT I-CARD -->
            <!-- ========================================================================= -->
            <div class="student-tab-pane" id="tab-student-icard">
                <div class="pane-title-wrap">
                    <span class="pane-kicker">CAMPUS IDENTITY</span>
                    <h2 class="pane-heading"><i class="fas fa-id-card"></i> Student I-Card</h2>
                    <p class="pane-desc">College Identity Card Issuance &amp; Replacement Rules</p>
                </div>

                <p class="student-body-text">
                    The College Identity Card is an essential official credential that confirms a student's active enrollment at Government Engineering College, Modasa. It is required for campus entry, library book issue, laboratory access, and university examinations.
                </p>

                <h3 class="student-subheading"><i class="fas fa-id-badge" style="color: #009dff;"></i> Issuance of New ID Card</h3>
                <ul class="student-list">
                    <li class="student-list-item"><i class="fas fa-check-circle student-list-icon"></i><span>Issued free of cost to newly admitted 1st year and D2D students upon completion of the college registration process.</span></li>
                    <li class="student-list-item"><i class="fas fa-check-circle student-list-icon"></i><span>Students must carry their ID card at all times inside the college premises and present it upon request by faculty or security personnel.</span></li>
                </ul>

                <h3 class="student-subheading"><i class="fas fa-clone" style="color: #009dff;"></i> Duplicate ID Card Process (In Case of Loss / Damage)</h3>
                <div class="step-container">
                    <div class="modern-step-card">
                        <div class="modern-step-badge">1</div>
                        <p class="modern-step-content">Submit a written application to the Student Section stating the reason for loss or damage.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">2</div>
                        <p class="modern-step-content">Deposit the nominal duplicate ID card processing fee (Rs. 50/-) at the accounts desk.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">3</div>
                        <p class="modern-step-content">Submit one fresh passport size photograph to receive the replacement card within 2 working days.</p>
                    </div>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 9: GTU CERTIFICATES -->
            <!-- ========================================================================= -->
            <div class="student-tab-pane" id="tab-gtu-certificates">
                <div class="pane-title-wrap">
                    <span class="pane-kicker">UNIVERSITY CREDENTIALS</span>
                    <h2 class="pane-heading"><i class="fas fa-certificate"></i> GTU Certificates</h2>
                    <p class="pane-desc">University Credentials, Endorsements &amp; Academic Records</p>
                </div>

                <p class="student-body-text">
                    The Student Section assists students and graduates in processing applications for university-level credentials issued by Gujarat Technological University (GTU):
                </p>

                <ul class="student-list">
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span><strong>Provisional Degree Certificate (PDC):</strong> Issued upon successful completion of all degree requirements and credit clearances across all 8 semesters.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span><strong>Migration Certificate:</strong> Required when seeking admission to postgraduate programs in other universities across India or abroad.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span><strong>Duplicate Grade Card / Marksheet:</strong> Facilitation for replacement of lost, stolen, or damaged semester grade cards.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span><strong>Medium of Instruction Certificate:</strong> Official institute certificate certifying that the medium of instruction throughout the B.E. program was English.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span><strong>CPI to Percentage Equivalence Certificate:</strong> Conversion statement endorsed as per GTU official formula: <em>Percentage = (CPI - 0.75) * 10</em>.</span>
                    </li>
                </ul>

                <div style="margin-top: 24px;">
                    <a href="https://www.student.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="theme-action-btn">
                        <i class="fas fa-external-link-alt"></i> Visit GTU Student Portal
                    </a>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 10: BONAFIDE / CHARACTER CERTIFICATE -->
            <!-- ========================================================================= -->
            <div class="student-tab-pane" id="tab-bonafide-certificate">
                <div class="pane-title-wrap">
                    <span class="pane-kicker">INSTITUTIONAL CERTIFICATES</span>
                    <h2 class="pane-heading"><i class="fas fa-file-signature"></i> Bonafide / Character Certificate</h2>
                    <p class="pane-desc">Application Procedure for Institutional Verification Certificates</p>
                </div>

                <p class="student-body-text">
                    Bonafide and Character certificates are issued by the institute to bonafide enrolled students for legitimate personal, academic, and financial purposes.
                </p>

                <h3 class="student-subheading"><i class="fas fa-layer-group" style="color: #009dff;"></i> Certificate Categories</h3>
                <div class="desk-grid" style="margin-bottom: 24px;">
                    <div class="desk-card">
                        <div class="desk-card-title"><i class="fas fa-id-badge"></i> Bonafide Certificate</div>
                        <p class="desk-card-val">Required for opening student bank accounts, educational loans, scholarship applications, passport / visa formalities, and bus pass verification.</p>
                    </div>
                    <div class="desk-card">
                        <div class="desk-card-title"><i class="fas fa-award"></i> Character / Conduct Certificate</div>
                        <p class="desk-card-val">Certifies student discipline, moral conduct, and academic standing during their tenure at GEC Modasa for employment or higher studies.</p>
                    </div>
                </div>

                <h3 class="student-subheading"><i class="fas fa-stream" style="color: #009dff;"></i> Application Steps</h3>
                <ul class="student-list">
                    <li class="student-list-item"><i class="fas fa-chevron-circle-right student-list-icon"></i><span>Collect the Bonafide Application Slip from the student section or write a formal request specifying the purpose.</span></li>
                    <li class="student-list-item"><i class="fas fa-chevron-circle-right student-list-icon"></i><span>Attach a photocopy of your valid College ID Card and current term fee receipt.</span></li>
                    <li class="student-list-item"><i class="fas fa-chevron-circle-right student-list-icon"></i><span>Submit the application at the student section counter during working hours.</span></li>
                    <li class="student-list-item"><i class="fas fa-chevron-circle-right student-list-icon"></i><span>Certificates are normally processed and delivered within 1 to 2 working days free of charge.</span></li>
                </ul>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 11: NAME CORRECTION -->
            <!-- ========================================================================= -->
            <div class="student-tab-pane" id="tab-name-correction">
                <div class="pane-title-wrap">
                    <span class="pane-kicker">RECORD RECTIFICATION</span>
                    <h2 class="pane-heading"><i class="fas fa-edit"></i> Name Correction</h2>
                    <p class="pane-desc">Procedure for Correction of Student Name, Father's Name, or Surname</p>
                </div>

                <p class="student-body-text">
                    In the event of typographical errors or discrepancies in a student's name, parent's name, or surname between college records, GTU enrollment, and matriculation records, corrections must be rectified through the established procedure:
                </p>

                <ul class="student-list">
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span><strong>Base Reference Document:</strong> As per Gujarat Technological University norms, the student's name in university records must strictly match the name printed on the 10th (SSC) Board Marksheet / Certificate.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span><strong>Legal Name Change:</strong> In cases of legal changes in name, surname, or religion, a copy of the official Government Gazette notification along with an affidavit is mandatory.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span><strong>Submission:</strong> Submit a formal application to the Student Section enclosing the SSC marksheet, Aadhar card, and current GTU grade card. The institute forwards the verified dossier to the GTU Registrar for permanent record update.</span>
                    </li>
                </ul>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 12: TRANSCRIPT -->
            <!-- ========================================================================= -->
            <div class="student-tab-pane" id="tab-transcript">
                <div class="pane-title-wrap">
                    <span class="pane-kicker">HIGHER EDUCATION</span>
                    <h2 class="pane-heading"><i class="fas fa-scroll"></i> Transcript</h2>
                    <p class="pane-desc">Official Academic Transcripts for Higher Education Abroad &amp; Credential Evaluation</p>
                </div>

                <p class="student-body-text">
                    Graduates and alumni applying to international universities or foreign credential assessment agencies (such as WES, IQAS, ICAS, CES) require officially stamped and sealed academic transcripts.
                </p>

                <div class="step-container">
                    <div class="modern-step-card">
                        <div class="modern-step-badge">1</div>
                        <p class="modern-step-content">Apply online for official university transcripts through the GTU Online Transcript Portal.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">2</div>
                        <p class="modern-step-content">Bring verified sets of semester grade cards, degree certificate, and GTU transcript documents to GEC Modasa Student Section.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">3</div>
                        <p class="modern-step-content">The Student Section verifies each semester marksheet against college registers and places the official college seal and registrar endorsement.</p>
                    </div>
                    <div class="modern-step-card">
                        <div class="modern-step-badge">4</div>
                        <p class="modern-step-content">Transcripts are placed inside tamper-evident official institutional envelopes, signed across the flap, and sealed for submission.</p>
                    </div>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 13: NO DUE CERTIFICATE -->
            <!-- ========================================================================= -->
            <div class="student-tab-pane" id="tab-no-due-certificate">
                <div class="pane-title-wrap">
                    <span class="pane-kicker">CLEARANCE PROTOCOL</span>
                    <h2 class="pane-heading"><i class="fas fa-check-double"></i> No Due Certificate</h2>
                    <p class="pane-desc">Clearance Procedure for Final Year Passouts &amp; Withdrawing Students</p>
                </div>

                <p class="student-body-text">
                    A No Due Certificate (Clearance Certificate) is mandatory for final semester graduating students prior to obtaining caution money refunds, original certificates, transfer certificates, or official transcripts:
                </p>

                <h3 class="student-subheading"><i class="fas fa-clipboard-list" style="color: #009dff;"></i> Clearance Checklist &amp; Countersignatures</h3>
                <ul class="student-list">
                    <li class="student-list-item"><i class="fas fa-check-circle student-list-icon"></i><span><strong>Parent Engineering Department:</strong> Clearance of lab equipment, departmental library books, and project reports from respective HoD.</span></li>
                    <li class="student-list-item"><i class="fas fa-check-circle student-list-icon"></i><span><strong>Central Library:</strong> Return of all borrowed reference books, cancellation of borrower tickets, and clearance of any pending library dues.</span></li>
                    <li class="student-list-item"><i class="fas fa-check-circle student-list-icon"></i><span><strong>Hostel &amp; Mess:</strong> Physical room handover, furniture inventory verification, and mess clearance from Hostel Rector / Warden.</span></li>
                    <li class="student-list-item"><i class="fas fa-check-circle student-list-icon"></i><span><strong>Gymkhana &amp; Sports Section:</strong> Return of sports gear and gymkhana equipment.</span></li>
                    <li class="student-list-item"><i class="fas fa-check-circle student-list-icon"></i><span><strong>Accounts Section:</strong> Final tuition fee audit and caution money deposit refund authorization.</span></li>
                </ul>
            </div>

            <!-- ========================================================================= -->
            <!-- TAB 14: STUDENT EDUCATION VERIFICATION -->
            <!-- ========================================================================= -->
            <div class="student-tab-pane" id="tab-education-verification">
                <div class="pane-title-wrap">
                    <span class="pane-kicker">CREDENTIAL VERIFICATION</span>
                    <h2 class="pane-heading"><i class="fas fa-user-check"></i> Student Education Verification</h2>
                    <p class="pane-desc">Credential Verification Service for Employers, Screening Agencies &amp; Embassies</p>
                </div>

                <p class="student-body-text">
                    Government Engineering College, Modasa provides education credential verification services for prospective employers, corporate background verification (BGV) partners, embassies, and academic bodies verifying the genuineness of degrees and grade sheets issued to its alumni.
                </p>

                <h3 class="student-subheading"><i class="fas fa-shield-alt" style="color: #009dff;"></i> Official Verification Submission Protocol</h3>
                <ul class="student-list">
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span>All verification requests must be dispatched from official corporate or institutional email addresses to <strong>gec-modasa-dte@gujarat.gov.in</strong>.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span>Attach clear scanned PDF copies of the candidate's Degree Certificate and Final Semester Marksheet / Grade Card.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span>Attach a signed authorization / consent letter from the alumnus permitting the verification check.</span>
                    </li>
                    <li class="student-list-item">
                        <i class="fas fa-chevron-circle-right student-list-icon"></i>
                        <span>Standard institutional turnaround time for formal verification responses is <strong>3 to 5 business working days</strong>.</span>
                    </li>
                </ul>

                <div class="desk-grid" style="margin-top: 20px;">
                    <div class="desk-card">
                        <div class="desk-card-title"><i class="fas fa-envelope"></i> Verification Email</div>
                        <p class="desk-card-val">gec-modasa-dte@gujarat.gov.in</p>
                    </div>
                    <div class="desk-card">
                        <div class="desk-card-title"><i class="fas fa-phone"></i> Telephone Contact</div>
                        <p class="desk-card-val">+91 2774 242631</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const desktopPills = document.querySelectorAll('.student-tab-pill');
    const mobileBtns = document.querySelectorAll('.student-mobile-btn');
    const tabPanes = document.querySelectorAll('.student-tab-pane');
    const mobileNavWrapper = document.getElementById('mobileNavWrapper');
    const mobileTabToggle = document.getElementById('mobileTabToggle');
    const mobileCurrentIcon = document.getElementById('mobileCurrentIcon');
    const mobileCurrentText = document.getElementById('mobileCurrentText');
    const mobileToggleIcon = document.getElementById('mobileToggleIcon');

    // Mobile Hamburger Menu Toggle
    if (mobileTabToggle) {
        mobileTabToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = mobileNavWrapper.classList.toggle('is-open');
            mobileTabToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            if (mobileToggleIcon) {
                if (isOpen) {
                    mobileToggleIcon.classList.remove('fa-bars');
                    mobileToggleIcon.classList.add('fa-times');
                } else {
                    mobileToggleIcon.classList.remove('fa-times');
                    mobileToggleIcon.classList.add('fa-bars');
                }
            }
        });

        // Close mobile dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!mobileNavWrapper.contains(e.target)) {
                mobileNavWrapper.classList.remove('is-open');
                mobileTabToggle.setAttribute('aria-expanded', 'false');
                if (mobileToggleIcon) {
                    mobileToggleIcon.classList.remove('fa-times');
                    mobileToggleIcon.classList.add('fa-bars');
                }
            }
        });
    }

    // Activate Tab by ID
    function activateTab(targetId, tabName, tabIcon) {
        // Desktop pills
        desktopPills.forEach(pill => {
            const isMatch = (pill.getAttribute('data-target') === targetId);
            if (isMatch) {
                pill.classList.add('active');
                pill.setAttribute('aria-selected', 'true');
                if (!tabName) tabName = pill.getAttribute('data-name');
                if (!tabIcon) tabIcon = pill.getAttribute('data-icon');
            } else {
                pill.classList.remove('active');
                pill.setAttribute('aria-selected', 'false');
            }
        });

        // Mobile buttons
        mobileBtns.forEach(btn => {
            const isMatch = (btn.getAttribute('data-target') === targetId);
            if (isMatch) {
                btn.classList.add('active');
                if (!tabName) tabName = btn.getAttribute('data-name');
                if (!tabIcon) tabIcon = btn.getAttribute('data-icon');
            } else {
                btn.classList.remove('active');
            }
        });

        // Tab Content Panes
        tabPanes.forEach(pane => {
            if (pane.getAttribute('id') === targetId) {
                pane.classList.add('active');
            } else {
                pane.classList.remove('active');
            }
        });

        // Update Mobile Current Label & Icon
        if (mobileCurrentText && tabName) {
            mobileCurrentText.textContent = tabName;
        }
        if (mobileCurrentIcon && tabIcon) {
            mobileCurrentIcon.innerHTML = '<i class="' + tabIcon + '"></i>';
        }

        // Close mobile menu if open
        if (mobileNavWrapper) {
            mobileNavWrapper.classList.remove('is-open');
            if (mobileTabToggle) mobileTabToggle.setAttribute('aria-expanded', 'false');
            if (mobileToggleIcon) {
                mobileToggleIcon.classList.remove('fa-times');
                mobileToggleIcon.classList.add('fa-bars');
            }
        }
    }

    // Click on desktop pills
    desktopPills.forEach(pill => {
        pill.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const tabName = this.getAttribute('data-name');
            const tabIcon = this.getAttribute('data-icon');
            activateTab(targetId, tabName, tabIcon);
            
            const hashKey = targetId.replace('tab-', '');
            if (history.pushState) {
                history.pushState(null, null, '#' + hashKey);
            } else {
                window.location.hash = hashKey;
            }
        });
    });

    // Click on mobile dropdown items
    mobileBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const tabName = this.getAttribute('data-name');
            const tabIcon = this.getAttribute('data-icon');
            activateTab(targetId, tabName, tabIcon);

            const hashKey = targetId.replace('tab-', '');
            if (history.pushState) {
                history.pushState(null, null, '#' + hashKey);
            } else {
                window.location.hash = hashKey;
            }

            // Smooth scroll to card
            const mainContent = document.querySelector('.student-main-content');
            if (mainContent) {
                const navHeight = document.getElementById('studentNav')?.offsetHeight || 60;
                const topPos = mainContent.getBoundingClientRect().top + window.pageYOffset - navHeight - 10;
                window.scrollTo({ top: topPos, behavior: 'smooth' });
            }
        });
    });

    // Handle initial hash on page load
    const currentHash = window.location.hash.replace('#', '').toLowerCase();
    if (currentHash) {
        const potentialTargetId = 'tab-' + currentHash;
        const matchingPill = document.querySelector('.student-tab-pill[data-target="' + potentialTargetId + '"]');
        if (matchingPill) {
            activateTab(potentialTargetId, matchingPill.getAttribute('data-name'), matchingPill.getAttribute('data-icon'));
        }
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
