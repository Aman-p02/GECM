<?php
$page_title = "Student Section :: Government Engineering College, Modasa";
$active_page = 'student-section';
$extra_css = 'css/student-section.css';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

// Fetch tab data from database
$tabsData = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM student_section_tabs ORDER BY display_order ASC, id ASC");
        if ($stmt) {
            $rows = $stmt->fetchAll();
            foreach ($rows as $r) {
                $tabsData[$r['tab_key']] = $r;
            }
        }
    } catch (Exception $e) {
        // Fallback gracefully
        $tabsData = [];
    }
}
?>

<div class="student-wrapper">
    <div class="student-container">

        <!-- Header bar matching Image 2: Title on Left, Breadcrumb on Right -->
        <div class="student-header-bar">
            <h1 class="student-page-title">Student Section</h1>
            <nav class="student-breadcrumbs" aria-label="Breadcrumb">
                <a href="index.php" title="Home"><i class="fas fa-home"></i></a>
                <span class="crumb-sep">/</span>
                <span>Student Corner</span>
                <span class="crumb-sep">/</span>
                <span class="crumb-current">Student Section</span>
            </nav>
        </div>

        <!-- Institutional Navigation Tabs matching Image 2 -->
        <nav class="student-tabs-nav" aria-label="Student Section Categories">
            <button type="button" class="student-tab-btn active" data-target="tab-about">About</button>
            <button type="button" class="student-tab-btn" data-target="tab-registration">Registration Process</button>
            <button type="button" class="student-tab-btn" data-target="tab-fees-structure">Fees Structure</button>
            <button type="button" class="student-tab-btn" data-target="tab-fees-payment">Fees Payment</button>
            <button type="button" class="student-tab-btn" data-target="tab-bus-concession">Bus concession</button>
            <button type="button" class="student-tab-btn" data-target="tab-admission-cancellation">Admission Cancellation</button>
            <button type="button" class="student-tab-btn" data-target="tab-institute-transfer">Institute Transfer</button>
            <button type="button" class="student-tab-btn" data-target="tab-student-icard">Student I-Card</button>
            <button type="button" class="student-tab-btn" data-target="tab-gtu-certificates">GTU Certificates</button>
            <button type="button" class="student-tab-btn" data-target="tab-bonafide-certificate">Bonafide / Character Certificate</button>
            <button type="button" class="student-tab-btn" data-target="tab-name-correction">Name Correction</button>
            <button type="button" class="student-tab-btn" data-target="tab-transcript">Transcript</button>
            <button type="button" class="student-tab-btn" data-target="tab-no-due-certificate">No Due Certificate</button>
            <button type="button" class="student-tab-btn" data-target="tab-education-verification">Student Education Verification</button>
        </nav>

        <!-- ========================================================================= -->
        <!-- TAB 1: ABOUT -->
        <!-- ========================================================================= -->
        <div class="student-tab-pane active" id="tab-about">
            <div class="pane-header">
                <h2 class="pane-title"><i class="fas fa-university"></i> About Student Section</h2>
                <p class="pane-subtitle">Central Academic &amp; Administrative Affairs Service Desk</p>
            </div>
            
            <p style="font-size: 15px; line-height: 1.7; color: #334155; margin-bottom: 20px;">
                The Student Section at Government Engineering College, Modasa serves as the primary administrative bridge connecting students with the college administration, Gujarat Technological University (GTU), and the Directorate of Technical Education (DTE), Government of Gujarat. The section is dedicated to delivering transparent, efficient, and student-friendly academic administration from initial admission to graduation.
            </p>

            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 24px 0 14px 0;">Primary Responsibilities &amp; Services</h3>
            <ul class="student-bullet-list">
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span>Processing ACPC admission reporting, student registration, and university enrollment verification.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span>Maintenance of permanent student academic records, branch registers, and university roll lists.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span>Issuance of official institutional certificates including Bonafide, Character, Leaving Certificate, and No Due clearance.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span>Coordination and endorsement of GSRTC student bus concession passes and railway concessions.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span>Administration and verification of government scholarship schemes including Digital Gujarat, MYSY, NSP, and PMSSS.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span>Assistance with GTU academic certificates, exam forms, transcripts, institute transfers, and third-party education verification.</span>
                </li>
            </ul>

            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 28px 0 14px 0;">Office Helpdesk Information</h3>
            <div class="office-grid">
                <div class="office-card">
                    <div class="office-card-title"><i class="fas fa-map-marker-alt"></i> Office Location</div>
                    <p class="office-card-val">Ground Floor, Administrative Block<br>GEC Modasa Campus</p>
                </div>
                <div class="office-card">
                    <div class="office-card-title"><i class="fas fa-clock"></i> Working Hours</div>
                    <p class="office-card-val">10:30 AM to 05:30 PM (Mon to Sat)<br><small style="color: #64748b;">Lunch: 01:30 PM to 02:00 PM</small></p>
                </div>
                <div class="office-card">
                    <div class="office-card-title"><i class="fas fa-calendar-times"></i> Holidays</div>
                    <p class="office-card-val">2nd &amp; 4th Saturdays, Sundays<br>&amp; Government Public Holidays</p>
                </div>
                <div class="office-card">
                    <div class="office-card-title"><i class="fas fa-envelope"></i> Contact Channel</div>
                    <p class="office-card-val">gec-modasa-dte@gujarat.gov.in<br>Phone: +91 2774 242631</p>
                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 2: REGISTRATION PROCESS -->
        <!-- ========================================================================= -->
        <div class="student-tab-pane" id="tab-registration">
            <div class="pane-header">
                <h2 class="pane-title"><i class="fas fa-user-plus"></i> Registration Process</h2>
                <p class="pane-subtitle">Admission Reporting &amp; GTU University Enrollment Guidelines</p>
            </div>

            <p style="font-size: 14.5px; line-height: 1.65; color: #334155; margin-bottom: 20px;">
                All candidates allotted admission to Government Engineering College, Modasa through the Admission Committee for Professional Courses (ACPC), Gujarat must complete the mandatory institutional registration process as outlined below:
            </p>

            <div class="step-list">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-body">
                        <p class="step-text"><strong>In-Person Reporting:</strong> Report to the GEC Modasa Student Section on the reporting dates prescribed in your ACPC allotment schedule.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-body">
                        <p class="step-text"><strong>Allotment Verification:</strong> Present the original ACPC Admission Slip / Allotment Letter along with the token tuition fee payment receipt.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-body">
                        <p class="step-text"><strong>Registration Form Submission:</strong> Fill out the college student bio-data registration form and paste two recent passport size photographs.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <div class="step-body">
                        <p class="step-text"><strong>Document Verification:</strong> Submit one set of self-attested photocopies of all qualifying examination certificates and produce originals for spot verification.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">5</div>
                    <div class="step-body">
                        <p class="step-text"><strong>Roll Number Allotment &amp; GTU Portal:</strong> Receive your temporary institute roll number. Once university enrollment numbers are announced, register on the GTU Student Portal (student.gtu.ac.in).</p>
                    </div>
                </div>
            </div>

            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 28px 0 14px 0;">Mandatory Documents Checklist</h3>
            <ul class="student-bullet-list">
                <li class="student-bullet-item"><i class="fas fa-check-circle student-bullet-icon"></i><span>ACPC Admission Allotment Letter and Token Fee Payment Receipt.</span></li>
                <li class="student-bullet-item"><i class="fas fa-check-circle student-bullet-icon"></i><span>10th (SSC) Board Marksheet and Certificate.</span></li>
                <li class="student-bullet-item"><i class="fas fa-check-circle student-bullet-icon"></i><span>12th (HSC) Marksheet / Diploma Final Year Marksheets.</span></li>
                <li class="student-bullet-item"><i class="fas fa-check-circle student-bullet-icon"></i><span>School Leaving Certificate (LC) / Transfer Certificate (TC).</span></li>
                <li class="student-bullet-item"><i class="fas fa-check-circle student-bullet-icon"></i><span>GUJCET / JEE Main Entrance Examination Scorecard.</span></li>
                <li class="student-bullet-item"><i class="fas fa-check-circle student-bullet-icon"></i><span>Caste Certificate / Non-Creamy Layer (NCL) Certificate / EWS Certificate (if applicable).</span></li>
                <li class="student-bullet-item"><i class="fas fa-check-circle student-bullet-icon"></i><span>Recent Passport Size Color Photographs (4 copies).</span></li>
                <li class="student-bullet-item"><i class="fas fa-check-circle student-bullet-icon"></i><span>Photocopy of Student's Aadhar Card and Bank Passbook (for scholarship purposes).</span></li>
            </ul>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 3: FEES STRUCTURE -->
        <!-- ========================================================================= -->
        <div class="student-tab-pane" id="tab-fees-structure">
            <div class="pane-header">
                <h2 class="pane-title"><i class="fas fa-file-invoice-dollar"></i> Fees Structure</h2>
                <p class="pane-subtitle">Government Approved Tuition &amp; Term Fees for B.E. &amp; M.E. Programs</p>
            </div>

            <div class="student-callout">
                <div class="student-callout-title"><i class="fas fa-info-circle"></i> Government Tuition Fee Exemption for Female Students</div>
                <p class="student-callout-text">
                    Under the visionary <strong>Kanya Kelavani Policy</strong> of the Government of Gujarat, all female students admitted to Government Engineering College, Modasa are granted <strong>100% Tuition Fee Exemption / Waiver</strong> across all undergraduate engineering programs.
                </p>
            </div>

            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 24px 0 12px 0;">Institutional Term Fees Breakdown</h3>
            <div class="student-table-wrap">
                <table class="student-table">
                    <thead>
                        <tr>
                            <th style="width: 46%;">Fee Component</th>
                            <th style="width: 27%;">Bachelor of Engineering (B.E.)</th>
                            <th style="width: 27%;">Master of Engineering (M.E.)</th>
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

            <ul class="student-bullet-list">
                <li class="student-bullet-item"><i class="fas fa-chevron-circle-right student-bullet-icon"></i><span>University Enrollment Fees and Semester Examination Fees are collected separately as per notifications issued by Gujarat Technological University (GTU).</span></li>
                <li class="student-bullet-item"><i class="fas fa-chevron-circle-right student-bullet-icon"></i><span>Hostel Accommodation and Mess Fees are separate and subject to hostel admission criteria.</span></li>
            </ul>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 4: FEES PAYMENT -->
        <!-- ========================================================================= -->
        <div class="student-tab-pane" id="tab-fees-payment">
            <div class="pane-header">
                <h2 class="pane-title"><i class="fas fa-credit-card"></i> Fees Payment</h2>
                <p class="pane-subtitle">Online Institutional Fee Collection Guidelines</p>
            </div>

            <p style="font-size: 14.5px; line-height: 1.65; color: #334155; margin-bottom: 20px;">
                To ensure digital accountability, safety, and transparent governance, all college term fees and institute dues must be paid exclusively through online payment channels. Cash transactions at college counters are strictly prohibited.
            </p>

            <div class="step-list">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-body">
                        <p class="step-text">Visit the official SBI Collect portal or the designated state e-payment platform.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-body">
                        <p class="step-text">Select State of Corporate/Institution: <strong>Gujarat</strong> and Type: <strong>Educational Institutions</strong>.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-body">
                        <p class="step-text">Select Educational Institution Name: <strong>GOVERNMENT ENGINEERING COLLEGE MODASA</strong>.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <div class="step-body">
                        <p class="step-text">Choose the appropriate payment category (e.g., <em>Term Fee / Admission Fee / Hostel Fee</em>).</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">5</div>
                    <div class="step-body">
                        <p class="step-text">Fill in your Enrollment Number, Branch, Semester, and Mobile Number accurately, then proceed with Net Banking, UPI, or Debit/Credit Card.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">6</div>
                    <div class="step-body">
                        <p class="step-text">Download and print the official transaction e-Receipt. Submit a copy to the student section counter for term registration endorsement.</p>
                    </div>
                </div>
            </div>

            <div style="margin-top: 25px;">
                <a href="https://www.onlinesbi.sbi/sbicollect/icollecthome.htm" target="_blank" rel="noopener noreferrer" class="student-btn">
                    <i class="fas fa-external-link-alt"></i> Proceed to SBI Collect Portal
                </a>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 5: BUS CONCESSION -->
        <!-- ========================================================================= -->
        <div class="student-tab-pane" id="tab-bus-concession">
            <div class="pane-header">
                <h2 class="pane-title"><i class="fas fa-bus"></i> Bus concession</h2>
                <p class="pane-subtitle">GSRTC Student Bus Pass &amp; Commuter Concession Procedure</p>
            </div>

            <p style="font-size: 14.5px; line-height: 1.65; color: #334155; margin-bottom: 20px;">
                Students commuting daily to Government Engineering College, Modasa from towns and rural regions of Aravalli, Sabarkantha, Gandhinagar, and surrounding districts are eligible for subsidized bus travel concession passes provided by the Gujarat State Road Transport Corporation (GSRTC).
            </p>

            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 24px 0 14px 0;">Procedure for Availing GSRTC Bus Concession</h3>
            <ul class="student-bullet-list">
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span>Collect the prescribed GSRTC Student Concession Pass Application Form from the college student section or from your local GSRTC Bus Station Concession Counter.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span>Fill in your details, departure bus station, destination station (GEC Modasa / Modasa ST Depot), and distance.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span>Attach a copy of your valid College ID Card and current term fee receipt.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span>Submit the form at the GEC Modasa Student Section counter for official verification, endorsement, and institutional seal by the Principal / Authorized Officer.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span>Present the endorsed form along with passport size photographs at the GSRTC Modasa Bus Depot Concession Counter to obtain your monthly or semester concession pass.</span>
                </li>
            </ul>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 6: ADMISSION CANCELLATION -->
        <!-- ========================================================================= -->
        <div class="student-tab-pane" id="tab-admission-cancellation">
            <div class="pane-header">
                <h2 class="pane-title"><i class="fas fa-user-times"></i> Admission Cancellation</h2>
                <p class="pane-subtitle">Formal Withdrawal &amp; Fee Refund Guidelines</p>
            </div>

            <p style="font-size: 14.5px; line-height: 1.65; color: #334155; margin-bottom: 20px;">
                Students who have secured admission at GEC Modasa and wish to withdraw or cancel their admission due to upgrade in subsequent ACPC rounds or personal circumstances must adhere to the official withdrawal procedure:
            </p>

            <div class="step-list">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-body">
                        <p class="step-text"><strong>Submit Formal Application:</strong> Prepare a formal written application requesting admission cancellation addressed to the Principal, stating clear reasons along with your ACPC Roll Number and branch.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-body">
                        <p class="step-text"><strong>Parent / Guardian Consent:</strong> The application must bear the signatures of both the student and the parent / legal guardian.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-body">
                        <p class="step-text"><strong>No Due Clearance:</strong> Obtain clearance signatures on the college No Due certificate from the parent department, central library, hostel, and accounts section.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <div class="step-body">
                        <p class="step-text"><strong>Submission of Documents:</strong> Submit the completed application, original fee receipt, ACPC allotment letter, and college ID card to the Student Section.</p>
                    </div>
                </div>
            </div>

            <div class="student-callout warning">
                <div class="student-callout-title"><i class="fas fa-exclamation-triangle"></i> Fee Refund Policy</div>
                <p class="student-callout-text">
                    Refund of tuition fees and security deposits is governed strictly as per ACPC Gujarat and AICTE withdrawal norms based on the official cutoff date of reporting.
                </p>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 7: INSTITUTE TRANSFER -->
        <!-- ========================================================================= -->
        <div class="student-tab-pane" id="tab-institute-transfer">
            <div class="pane-header">
                <h2 class="pane-title"><i class="fas fa-exchange-alt"></i> Institute Transfer</h2>
                <p class="pane-subtitle">Gujarat Technological University (GTU) Inter-College Transfer Regulations</p>
            </div>

            <p style="font-size: 14.5px; line-height: 1.65; color: #334155; margin-bottom: 20px;">
                Inter-college institute transfers for degree engineering students are governed strictly by the statutory rules and calendar notifications issued by Gujarat Technological University (GTU).
            </p>

            <ul class="student-bullet-list">
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span><strong>Eligibility:</strong> Transfers are generally permissible at the beginning of the 3rd semester (2nd Year) for eligible students who have satisfied GTU progression criteria without pending disciplinary cases.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span><strong>Seat Availability:</strong> Transfer is strictly subject to the availability of clear vacant seats in the relevant branch at the receiving institute.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span><strong>NOC Requirements:</strong> Students must obtain a formal No Objection Certificate (NOC) from both the parent college (GEC Modasa) and the proposed receiving college.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span><strong>GTU Portal Application:</strong> Submit the transfer application through the GTU Student Portal (student.gtu.ac.in) along with requisite university fees within the announced timeline.</span>
                </li>
            </ul>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 8: STUDENT I-CARD -->
        <!-- ========================================================================= -->
        <div class="student-tab-pane" id="tab-student-icard">
            <div class="pane-header">
                <h2 class="pane-title"><i class="fas fa-id-card"></i> Student I-Card</h2>
                <p class="pane-subtitle">College Identity Card Issuance &amp; Replacement Rules</p>
            </div>

            <p style="font-size: 14.5px; line-height: 1.65; color: #334155; margin-bottom: 20px;">
                The College Identity Card is an essential official credential that confirms a student's active enrollment at Government Engineering College, Modasa. It is required for campus entry, library book issue, laboratory access, and university examinations.
            </p>

            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 24px 0 14px 0;">Issuance of New ID Card</h3>
            <ul class="student-bullet-list">
                <li class="student-bullet-item"><i class="fas fa-check-circle student-bullet-icon"></i><span>Issued free of cost to newly admitted 1st year and D2D students upon completion of the college registration process.</span></li>
                <li class="student-bullet-item"><i class="fas fa-check-circle student-bullet-icon"></i><span>Students must carry their ID card at all times inside the college premises and present it upon request by faculty or security personnel.</span></li>
            </ul>

            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 24px 0 14px 0;">Procedure for Duplicate ID Card (In Case of Loss / Damage)</h3>
            <div class="step-list">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-body">
                        <p class="step-text">Submit a written application to the Student Section stating the reason for loss or damage.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-body">
                        <p class="step-text">Deposit the nominal duplicate ID card processing fee (Rs. 50/-) at the accounts desk.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-body">
                        <p class="step-text">Submit one fresh passport size photograph to receive the replacement card within 2 working days.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 9: GTU CERTIFICATES -->
        <!-- ========================================================================= -->
        <div class="student-tab-pane" id="tab-gtu-certificates">
            <div class="pane-header">
                <h2 class="pane-title"><i class="fas fa-certificate"></i> GTU Certificates</h2>
                <p class="pane-subtitle">University Credentials, Endorsements &amp; Academic Records</p>
            </div>

            <p style="font-size: 14.5px; line-height: 1.65; color: #334155; margin-bottom: 20px;">
                The Student Section assists students and graduates in processing applications for university-level credentials issued by Gujarat Technological University (GTU):
            </p>

            <ul class="student-bullet-list">
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span><strong>Provisional Degree Certificate (PDC):</strong> Issued upon successful completion of all degree requirements and credit clearances across all 8 semesters.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span><strong>Migration Certificate:</strong> Required when seeking admission to postgraduate programs in other universities across India or abroad.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span><strong>Duplicate Grade Card / Marksheet:</strong> Facilitation for replacement of lost, stolen, or damaged semester grade cards.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span><strong>Medium of Instruction Certificate:</strong> Official institute certificate certifying that the medium of instruction throughout the B.E. program was English.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span><strong>CPI to Percentage Equivalence Certificate:</strong> Conversion statement endorsed as per GTU official formula: <em>Percentage = (CPI - 0.75) * 10</em>.</span>
                </li>
            </ul>

            <div style="margin-top: 25px;">
                <a href="https://www.student.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="student-btn">
                    <i class="fas fa-external-link-alt"></i> Visit GTU Student Portal
                </a>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 10: BONAFIDE / CHARACTER CERTIFICATE -->
        <!-- ========================================================================= -->
        <div class="student-tab-pane" id="tab-bonafide-certificate">
            <div class="pane-header">
                <h2 class="pane-title"><i class="fas fa-file-signature"></i> Bonafide / Character Certificate</h2>
                <p class="pane-subtitle">Application Procedure for Institutional Verification Certificates</p>
            </div>

            <p style="font-size: 14.5px; line-height: 1.65; color: #334155; margin-bottom: 20px;">
                Bonafide and Character certificates are issued by the institute to bonafide enrolled students for legitimate personal, academic, and financial purposes.
            </p>

            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 24px 0 14px 0;">Certificate Categories</h3>
            <div class="office-grid" style="margin-bottom: 24px;">
                <div class="office-card">
                    <div class="office-card-title"><i class="fas fa-id-badge"></i> Bonafide Certificate</div>
                    <p class="office-card-val">Required for opening student bank accounts, educational loans, scholarship applications, passport / visa formalities, and bus pass verification.</p>
                </div>
                <div class="office-card">
                    <div class="office-card-title"><i class="fas fa-award"></i> Character / Conduct Certificate</div>
                    <p class="office-card-val">Certifies student discipline, moral conduct, and academic standing during their tenure at GEC Modasa for employment or higher studies.</p>
                </div>
            </div>

            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 24px 0 14px 0;">Application Steps</h3>
            <ul class="student-bullet-list">
                <li class="student-bullet-item"><i class="fas fa-chevron-circle-right student-bullet-icon"></i><span>Collect the Bonafide Application Slip from the student section or write a formal request specifying the purpose.</span></li>
                <li class="student-bullet-item"><i class="fas fa-chevron-circle-right student-bullet-icon"></i><span>Attach a photocopy of your valid College ID Card and current term fee receipt.</span></li>
                <li class="student-bullet-item"><i class="fas fa-chevron-circle-right student-bullet-icon"></i><span>Submit the application at the student section counter during working hours.</span></li>
                <li class="student-bullet-item"><i class="fas fa-chevron-circle-right student-bullet-icon"></i><span>Certificates are normally processed and delivered within 1 to 2 working days free of charge.</span></li>
            </ul>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 11: NAME CORRECTION -->
        <!-- ========================================================================= -->
        <div class="student-tab-pane" id="tab-name-correction">
            <div class="pane-header">
                <h2 class="pane-title"><i class="fas fa-edit"></i> Name Correction</h2>
                <p class="pane-subtitle">Procedure for Correction of Student Name, Father's Name, or Surname</p>
            </div>

            <p style="font-size: 14.5px; line-height: 1.65; color: #334155; margin-bottom: 20px;">
                In the event of typographical errors or discrepancies in a student's name, parent's name, or surname between college records, GTU enrollment, and matriculation records, corrections must be rectified through the established procedure:
            </p>

            <ul class="student-bullet-list">
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span><strong>Base Reference Document:</strong> As per Gujarat Technological University norms, the student's name in university records must strictly match the name printed on the 10th (SSC) Board Marksheet / Certificate.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span><strong>Legal Name Change:</strong> In cases of legal changes in name, surname, or religion, a copy of the official Government Gazette notification along with an affidavit is mandatory.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span><strong>Submission:</strong> Submit a formal application to the Student Section enclosing the SSC marksheet, Aadhar card, and current GTU grade card. The institute forwards the verified dossier to the GTU Registrar for permanent record update.</span>
                </li>
            </ul>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 12: TRANSCRIPT -->
        <!-- ========================================================================= -->
        <div class="student-tab-pane" id="tab-transcript">
            <div class="pane-header">
                <h2 class="pane-title"><i class="fas fa-scroll"></i> Transcript</h2>
                <p class="pane-subtitle">Official Academic Transcripts for Higher Education Abroad &amp; Credential Evaluation</p>
            </div>

            <p style="font-size: 14.5px; line-height: 1.65; color: #334155; margin-bottom: 20px;">
                Graduates and alumni applying to international universities or foreign credential assessment agencies (such as WES, IQAS, ICAS, CES) require officially stamped and sealed academic transcripts.
            </p>

            <div class="step-list">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-body">
                        <p class="step-text">Apply online for official university transcripts through the GTU Online Transcript Portal.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-body">
                        <p class="step-text">Bring verified sets of semester grade cards, degree certificate, and GTU transcript documents to GEC Modasa Student Section.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-body">
                        <p class="step-text">The Student Section verifies each semester marksheet against college registers and places the official college seal and registrar endorsement.</p>
                    </div>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <div class="step-body">
                        <p class="step-text">Transcripts are placed inside tamper-evident official institutional envelopes, signed across the flap, and sealed for submission.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 13: NO DUE CERTIFICATE -->
        <!-- ========================================================================= -->
        <div class="student-tab-pane" id="tab-no-due-certificate">
            <div class="pane-header">
                <h2 class="pane-title"><i class="fas fa-check-double"></i> No Due Certificate</h2>
                <p class="pane-subtitle">Clearance Procedure for Final Year Passouts &amp; Withdrawing Students</p>
            </div>

            <p style="font-size: 14.5px; line-height: 1.65; color: #334155; margin-bottom: 20px;">
                A No Due Certificate (Clearance Certificate) is mandatory for final semester graduating students prior to obtaining caution money refunds, original certificates, transfer certificates, or official transcripts:
            </p>

            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 24px 0 14px 0;">Clearance Checklist &amp; Countersignatures</h3>
            <ul class="student-bullet-list">
                <li class="student-bullet-item"><i class="fas fa-check-circle student-bullet-icon"></i><span><strong>Parent Engineering Department:</strong> Clearance of lab equipment, departmental library books, and project reports from respective HoD.</span></li>
                <li class="student-bullet-item"><i class="fas fa-check-circle student-bullet-icon"></i><span><strong>Central Library:</strong> Return of all borrowed reference books, cancellation of borrower tickets, and clearance of any pending library dues.</span></li>
                <li class="student-bullet-item"><i class="fas fa-check-circle student-bullet-icon"></i><span><strong>Hostel &amp; Mess:</strong> Physical room handover, furniture inventory verification, and mess clearance from Hostel Rector / Warden.</span></li>
                <li class="student-bullet-item"><i class="fas fa-check-circle student-bullet-icon"></i><span><strong>Gymkhana &amp; Sports Section:</strong> Return of sports gear and gymkhana equipment.</span></li>
                <li class="student-bullet-item"><i class="fas fa-check-circle student-bullet-icon"></i><span><strong>Accounts Section:</strong> Final tuition fee audit and caution money deposit refund authorization.</span></li>
            </ul>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 14: STUDENT EDUCATION VERIFICATION -->
        <!-- ========================================================================= -->
        <div class="student-tab-pane" id="tab-education-verification">
            <div class="pane-header">
                <h2 class="pane-title"><i class="fas fa-user-check"></i> Student Education Verification</h2>
                <p class="pane-subtitle">Credential Verification Service for Employers, Screening Agencies &amp; Embassies</p>
            </div>

            <p style="font-size: 14.5px; line-height: 1.65; color: #334155; margin-bottom: 20px;">
                Government Engineering College, Modasa provides education credential verification services for prospective employers, corporate background verification (BGV) partners, embassies, and academic bodies verifying the genuineness of degrees and grade sheets issued to its alumni.
            </p>

            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 24px 0 14px 0;">Official Verification Submission Protocol</h3>
            <ul class="student-bullet-list">
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span>All verification requests must be dispatched from official corporate or institutional email addresses to <strong>gec-modasa-dte@gujarat.gov.in</strong>.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span>Attach clear scanned PDF copies of the candidate's Degree Certificate and Final Semester Marksheet / Grade Card.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span>Attach a signed authorization / consent letter from the alumnus permitting the verification check.</span>
                </li>
                <li class="student-bullet-item">
                    <i class="fas fa-chevron-circle-right student-bullet-icon"></i>
                    <span>Standard institutional turnaround time for formal verification responses is <strong>3 to 5 business working days</strong>.</span>
                </li>
            </ul>

            <div class="office-grid" style="margin-top: 20px;">
                <div class="office-card">
                    <div class="office-card-title"><i class="fas fa-envelope"></i> Verification Email</div>
                    <p class="office-card-val">gec-modasa-dte@gujarat.gov.in</p>
                </div>
                <div class="office-card">
                    <div class="office-card-title"><i class="fas fa-phone"></i> Telephone Contact</div>
                    <p class="office-card-val">+91 2774 242631</p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.student-tab-btn');
    const tabPanes = document.querySelectorAll('.student-tab-pane');

    function activateTab(targetId) {
        let found = false;
        tabButtons.forEach(btn => {
            if (btn.getAttribute('data-target') === targetId) {
                btn.classList.add('active');
                found = true;
            } else {
                btn.classList.remove('active');
            }
        });

        tabPanes.forEach(pane => {
            if (pane.getAttribute('id') === targetId) {
                pane.classList.add('active');
            } else {
                pane.classList.remove('active');
            }
        });

        return found;
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            activateTab(targetId);
            const hashKey = targetId.replace('tab-', '');
            if (history.pushState) {
                history.pushState(null, null, '#' + hashKey);
            } else {
                window.location.hash = hashKey;
            }
        });
    });

    // Check URL hash on page load
    const hash = window.location.hash.replace('#', '').toLowerCase();
    if (hash) {
        const targetId = 'tab-' + hash;
        activateTab(targetId);
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
