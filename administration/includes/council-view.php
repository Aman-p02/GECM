<?php
/**
 * Institutional Council of Heads and Committees Template
 * Clean, Editorial Design Aligned with GECM Department Pages
 */
require_once __DIR__ . '/../../includes/db.php';

// Official in-memory datasets matching institutional images
$defaultCouncil = [
    ['section_name' => 'Human Resource (Faculty & Staff)', 'designation' => 'Convener', 'section_head' => 'Prof. (Dr.) J. A. Vadher (Principal)', 'display_order' => 1],
    ['section_name' => 'Student Affairs', 'designation' => 'Convener', 'section_head' => 'Dr. S. S. Singh (Prof. Civil Dept.)', 'display_order' => 2],
    ['section_name' => 'Store & Purchase', 'designation' => 'Convener', 'section_head' => 'Dr. U. K. Khare (Head of Civil Dept.)', 'display_order' => 3],
    ['section_name' => 'Academics', 'designation' => 'Convener', 'section_head' => 'Dr. V. J. Upadhyay (Head of Electrical Dept.)', 'display_order' => 4],
    ['section_name' => 'Infrastructure & Maintenance', 'designation' => 'Convener', 'section_head' => 'Dr. U. V. Shah (Head of Mechanical Dept.)', 'display_order' => 5],
    ['section_name' => 'Research, Industry & Outreach', 'designation' => 'Convener', 'section_head' => 'Dr. V. J. Upadhyay (Head of Electrical Dept.)', 'display_order' => 6],
    ['section_name' => 'Amenities', 'designation' => 'Convener', 'section_head' => 'Dr. U. V. Shah (Head of Mechanical Dept.)', 'display_order' => 7]
];

$defaultIQAC = [
    ['name' => 'Dr. J. A. Vadher', 'designation' => 'Principal', 'status_role' => 'Chairman', 'display_order' => 1],
    ['name' => 'Dr. V. J. Upadhyay', 'designation' => 'Prof. and Head Electrical Engg. Dept.', 'status_role' => 'Convener', 'display_order' => 2],
    ['name' => 'Prof. S. A. Vahora', 'designation' => 'Prof. and Head Information Tech. Dept.', 'status_role' => 'Member', 'display_order' => 3],
    ['name' => 'Dr. U. K. Khare', 'designation' => 'Prof. and Head Civil Engg. Dept.', 'status_role' => 'Member', 'display_order' => 4],
    ['name' => 'Dr. U. V. Shah', 'designation' => 'Prof. and Head Mechanical Engg. Dept.', 'status_role' => 'Member', 'display_order' => 5],
    ['name' => 'Prof. A. H. Dafda', 'designation' => 'Asso. Prof. and Head Electronics and Communication Department', 'status_role' => 'Member', 'display_order' => 6],
    ['name' => 'Prof. R. J. Jani', 'designation' => 'Asso. Prof. and Head of Automobile Engineering Department', 'status_role' => 'Member', 'display_order' => 7],
    ['name' => 'Prof. D. R. Tarachandani', 'designation' => 'Asso. Prof. and Head Applied Mechanics Department', 'status_role' => 'Member', 'display_order' => 8],
    ['name' => 'Dr. M. A. Patel', 'designation' => 'Asso. Prof. and Head Science & Humanities Department', 'status_role' => 'Member', 'display_order' => 9],
    ['name' => 'Prof. P. M. Mistri', 'designation' => 'Asst. Prof. Mech. Engg. Dept.', 'status_role' => 'Member', 'display_order' => 10],
    ['name' => 'Dr. A. B. Dhruv', 'designation' => 'Prof. and Head Mechanical Engg. Dept., Govt. Engg. College, Patan', 'status_role' => 'Member (Management Nominated)', 'display_order' => 11],
    ['name' => 'Mr. Vinod Gajjar', 'designation' => 'Director, V-Tek Makkers, Butal, Dhansura', 'status_role' => 'External Member', 'display_order' => 12],
    ['name' => 'Mr. Anand Savaliya', 'designation' => 'CEO, Kavyam Energy Pvt. Ltd.; Director, Rajkot Engg. Testing & Research Center', 'status_role' => 'External Member', 'display_order' => 13],
    ['name' => 'Mr. Nikhil Shah', 'designation' => 'NIFA Electronics Pvt. Ltd., Ahmedabad', 'status_role' => 'External Member', 'display_order' => 14],
    ['name' => 'Mr. Rakesh Gondaliya', 'designation' => 'Director, ScaleTech, Ahmedabad', 'status_role' => 'External Member', 'display_order' => 15]
];

$defaultHOD = [
    ['department_name' => 'Applied Mechanics Department', 'designation' => 'Associate Professor', 'faculty_name' => 'Prof. T. R. Tarachandani', 'display_order' => 1],
    ['department_name' => 'Automobile Department', 'designation' => 'Associate Professor', 'faculty_name' => 'Prof. R. J. Jani', 'display_order' => 2],
    ['department_name' => 'Civil Department', 'designation' => 'Professor', 'faculty_name' => 'Prof. U. K. Khare', 'display_order' => 3],
    ['department_name' => 'Computer Engineering Department', 'designation' => 'Associate Professor', 'faculty_name' => 'Prof. M. M. Goyani', 'display_order' => 4],
    ['department_name' => 'Electrical Department', 'designation' => 'Professor', 'faculty_name' => 'Prof. V. J. Upadhyay', 'display_order' => 5],
    ['department_name' => 'Electronics & Communication Department', 'designation' => 'Associate Professor', 'faculty_name' => 'Prof. A. H. Dafda', 'display_order' => 6],
    ['department_name' => 'Information Technology Department', 'designation' => 'Associate Professor', 'faculty_name' => 'Prof. S. A. Vahora', 'display_order' => 7],
    ['department_name' => 'Mechanical Department', 'designation' => 'Professor', 'faculty_name' => 'Prof. U. V. Shah', 'display_order' => 8],
    ['department_name' => 'Science and Humanities Department', 'designation' => 'Associate Professor', 'faculty_name' => 'Prof. M. A. Patel', 'display_order' => 9]
];

$defaultCells = [
    ['cell_name' => 'Gymkhana', 'designation' => 'Vice President', 'officer_name' => 'Prof. (Dr.) U. V. Shah (Head of Mechanical Dept.)', 'display_order' => 1],
    ['cell_name' => 'Antiragging Cell', 'designation' => 'Coordinator', 'officer_name' => 'Prof. (Dr.) U. V. Shah (Head of Mechanical Dept.)', 'display_order' => 2],
    ['cell_name' => 'Women Development Cell', 'designation' => 'Coordinator', 'officer_name' => 'Prof. S. K. Rana (Assistant Prof. in EC Dept.)', 'display_order' => 3],
    ['cell_name' => 'SC Internal Complaint Prevention Cell', 'designation' => 'Coordinator', 'officer_name' => 'Dr. S. S. Singh (Prof. Civil Dept.)', 'display_order' => 4],
    ['cell_name' => 'National Task Force (NTF) Student Mental Health Support Cell', 'designation' => 'Coordinator', 'officer_name' => 'Dr. R. N. Vaza (Asst. Prof. Computer Engg. Dept.)', 'display_order' => 5],
    ['cell_name' => 'Counselling (Psychology) Cell', 'designation' => 'Coordinator', 'officer_name' => 'Dr. H. R. Patel (Asst. Prof. IT Engg. Dept.)', 'display_order' => 6],
    ['cell_name' => 'Caste-Based Discrimination Cell', 'designation' => 'Coordinator', 'officer_name' => 'Dr. S. S. Singh (Prof. Civil Dept.)', 'display_order' => 7],
    ['cell_name' => 'Same Opportunities Cell', 'designation' => 'Coordinator', 'officer_name' => 'Dr. S. S. Singh (Prof. Civil Dept.)', 'display_order' => 8],
    ['cell_name' => 'GTU Cell (Room No. 1239)', 'designation' => 'Coordinator', 'officer_name' => 'Prof. L. S. Narsingani (Associate Prof. in Sci. and Hum. Dept.)', 'display_order' => 9],
    ['cell_name' => 'GTU Cell (Room No. 1239)', 'designation' => 'Co-Coordinator', 'officer_name' => 'Prof. D. H. Sahay (Assistant Prof. in Physics)', 'display_order' => 10],
    ['cell_name' => 'Training & Placement Cell', 'designation' => 'Coordinator', 'officer_name' => 'Prof. (Dr.) M. M. Goyani (Associate Prof. in Computer Dept.)', 'display_order' => 11],
    ['cell_name' => 'Training & Placement Cell', 'designation' => 'Co-Coordinator', 'officer_name' => 'Prof. P. M. Mistry (Assistant Prof. in Mechanical Dept.)', 'display_order' => 12],
    ['cell_name' => 'RTI Cell', 'designation' => 'Coordinator', 'officer_name' => 'Prof. D. A. Sagar (Assistant Prof. in Applied Mechanics Dept.)', 'display_order' => 13],
    ['cell_name' => 'RTI Cell', 'designation' => 'Co-Coordinator', 'officer_name' => 'Prof. R. P. Khatri (Assistant Prof. in Physics)', 'display_order' => 14],
    ['cell_name' => 'RTI Cell', 'designation' => 'Co-Coordinator', 'officer_name' => 'Prof. D. J. Bhayani (Assistant Prof. in English)', 'display_order' => 15],
    ['cell_name' => 'Student Section (Roll Call, ID Card, MIS, Transcripts & Certificates)', 'designation' => 'Coordinator', 'officer_name' => 'Prof. L. S. Narsingani (Associate Prof. in Sci. and Hum. Dept.)', 'display_order' => 16],
    ['cell_name' => 'Student Section', 'designation' => 'Co-Coordinator', 'officer_name' => 'Prof. K. K. Bhatt (Assistant Prof. in Electrical Dept.)', 'display_order' => 17],
    ['cell_name' => 'Student Scholarship (Government & Non-Government Schemes)', 'designation' => 'Coordinator', 'officer_name' => 'Prof. D. R. Tarachandani (Associate Prof. in Applied Mechanics Dept.)', 'display_order' => 18],
    ['cell_name' => 'Library', 'designation' => 'Coordinator', 'officer_name' => 'Dr. N. V. Upadhyay (Assistant Prof. in Electrical Dept.)', 'display_order' => 19],
    ['cell_name' => 'Library', 'designation' => 'Co-Coordinator', 'officer_name' => 'Prof. K. V. Fadadu (Assistant Prof. in Automobile Dept.)', 'display_order' => 20],
    ['cell_name' => 'Hostel Rector & Warden', 'designation' => 'Rector', 'officer_name' => 'Dr. U. V. Shah (Professor in Mechanical Dept.)', 'display_order' => 21],
    ['cell_name' => 'Hostel Rector & Warden', 'designation' => 'Assistant Rector', 'officer_name' => 'Prof. P. R. Gamit (Assistant Prof. in Computer Dept.)', 'display_order' => 22],
    ['cell_name' => 'Hostel Rector & Warden', 'designation' => 'Assistant Rector', 'officer_name' => 'Prof. P. V. Patel (Assistant Prof. in EC Dept.)', 'display_order' => 23],
    ['cell_name' => 'Account Section In-Charge', 'designation' => 'Coordinator', 'officer_name' => 'Dr. M. A. Patel (Associate Prof. in Sci. and Hum. Dept.)', 'display_order' => 24],
    ['cell_name' => 'Account Section In-Charge', 'designation' => 'Cashier', 'officer_name' => 'Shri Vipul Damor', 'display_order' => 25],
    ['cell_name' => 'Establishment Section', 'designation' => 'Head Clerk', 'officer_name' => 'P. K. Prajapati', 'display_order' => 26]
];

$defaultContacts = [
    ['sr_no' => 1, 'organization_name' => 'Gujarat Technological University, Ahmedabad', 'contact_number' => '079-263011500', 'display_order' => 1],
    ['sr_no' => 2, 'organization_name' => 'Public Health Center, Modasa', 'contact_number' => '02774-246526', 'display_order' => 2],
    ['sr_no' => 3, 'organization_name' => 'Post Office, Modasa', 'contact_number' => '02774-246481', 'display_order' => 3],
    ['sr_no' => 4, 'organization_name' => 'State Bank of India, Modasa', 'contact_number' => '02774-246222', 'display_order' => 4],
    ['sr_no' => 5, 'organization_name' => 'Police Station, Modasa', 'contact_number' => '02774-246660', 'display_order' => 5],
    ['sr_no' => 6, 'organization_name' => 'Fire Station, Modasa', 'contact_number' => '02774-246333', 'display_order' => 6],
    ['sr_no' => 7, 'organization_name' => 'GEC Modasa Campus Security / Main Gate', 'contact_number' => '02774-242633', 'display_order' => 7]
];

$councilList = $defaultCouncil;
$iqacList = $defaultIQAC;
$hodList = $defaultHOD;
$cellsList = $defaultCells;
$contactsList = $defaultContacts;
$headOfInstitute = 'Prof. (Dr.) J. A. Vadher';

// Sync principal name from profile if available
if (!empty($pdo)) {
    try {
        $pStmt = $pdo->query("SELECT name FROM principal_profile LIMIT 1");
        if ($pRow = $pStmt->fetch()) {
            if (!empty($pRow['name'])) {
                $headOfInstitute = $pRow['name'];
            }
        }
    } catch (Throwable $e) {
        // Silently continue with default head
    }
}

$root_path = $root_path ?? '../';
$extra_css = 'css/council-of-heads.css';
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="coh-page">
    <div class="coh-container">

        <!-- Department-style Hero Banner -->
        <header class="coh-hero-banner">
            <span class="coh-kicker">INSTITUTIONAL GOVERNANCE</span>
            <h1 class="coh-heading"><?= htmlspecialchars($page_heading ?? 'Council of Heads') ?></h1>
            <p class="coh-tagline">
                <?= htmlspecialchars($page_subheading ?? 'Administrative governance, departmental heads, Internal Quality Assurance Cell (IQAC), and statutory campus committees of Government Engineering College, Modasa.') ?>
            </p>
        </header>

        <!-- Head of the Institute Executive Card -->
        <section class="coh-exec-card" aria-label="Head of the Institute">
            <div class="coh-exec-content">
                <span class="coh-exec-kicker">Head of the Institute</span>
                <h3 class="coh-exec-name"><?= htmlspecialchars($headOfInstitute) ?></h3>
                <span class="coh-exec-desig">Principal &bull; Government Engineering College, Modasa</span>
            </div>
            <div>
                <a href="<?= $root_path ?>administration/principal" class="coh-exec-link">
                    <span>View Principal Profile</span>
                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </section>

        <!-- Administrative Narrative Introduction -->
        <div class="coh-lead-intro">
            Administration of the Institute is run by various offices such as the Principal Office, Student Section, Account Section, Establishment Section, and Purchase Section. These offices are situated in the Main Building (01). The list of officers concerned with respective offices is presented below.
        </div>

        <!-- 1. COUNCIL OF HEAD SECTION -->
        <section class="coh-section-block">
            <div class="coh-section-header">
                <span class="coh-section-kicker">EXECUTIVE LEADERSHIP</span>
                <h2>Council of Head</h2>
                <p>Functional administrative divisions and designated conveners steering campus operations.</p>
            </div>

            <div class="coh-table-wrap">
                <table class="coh-clean-table">
                    <thead>
                        <tr>
                            <th style="width: 38%;">Sections</th>
                            <th style="width: 20%;">Designation</th>
                            <th style="width: 42%;">Section Head</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($councilList as $row): ?>
                            <tr>
                                <td class="coh-primary-cell"><?= htmlspecialchars($row['section_name']) ?></td>
                                <td>
                                    <span class="coh-tag coh-tag-convener"><?= htmlspecialchars($row['designation']) ?></span>
                                </td>
                                <td><?= htmlspecialchars($row['section_head']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 2. INTERNAL QUALITY ASSURANCE CELL (IQAC) -->
        <section class="coh-section-block">
            <div class="coh-section-header">
                <span class="coh-section-kicker">ACADEMIC EXCELLENCE &amp; QUALITY</span>
                <h2>Internal Quality Assurance Cell (IQAC)</h2>
                <p>Formed for planning, guiding, and monitoring quality enhancement activities and institutional accreditation.</p>
            </div>

            <div class="coh-narrative-note">
                To maintain the momentum of quality consciousness is crucial in colleges. Every college should have an internal quality assurance system, with appropriate structure and processes, and with enough flexibility to meet the diverse needs of the stakeholders. Thus, Government Engineering College, Modasa has instituted the Internal Quality Assurance Cell to channelize and systematize efforts towards academic excellence.
            </div>

            <div class="coh-table-wrap">
                <table class="coh-clean-table">
                    <thead>
                        <tr>
                            <th style="width: 32%;">Name</th>
                            <th style="width: 48%;">Designation</th>
                            <th style="width: 20%;">Status / Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($iqacList as $row): 
                            $status = $row['status_role'];
                            $tagClass = 'coh-tag-member';
                            if (stripos($status, 'Chairman') !== false) {
                                $tagClass = 'coh-tag-chairman';
                            } elseif (stripos($status, 'Convener') !== false) {
                                $tagClass = 'coh-tag-convener';
                            } elseif (stripos($status, 'External') !== false) {
                                $tagClass = 'coh-tag-coordinator';
                            }
                        ?>
                            <tr>
                                <td class="coh-primary-cell"><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['designation']) ?></td>
                                <td>
                                    <span class="coh-tag <?= $tagClass ?>"><?= htmlspecialchars($status) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 3. HEAD OF DEPARTMENT -->
        <section class="coh-section-block">
            <div class="coh-section-header">
                <span class="coh-section-kicker">ACADEMIC DEPARTMENTS</span>
                <h2>Head of Department</h2>
                <p>Academic leaders heading engineering and applied sciences departments across the institution.</p>
            </div>

            <div class="coh-table-wrap">
                <table class="coh-clean-table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Department</th>
                            <th style="width: 25%;">Designation</th>
                            <th style="width: 35%;">Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hodList as $row): ?>
                            <tr>
                                <td class="coh-primary-cell"><?= htmlspecialchars($row['department_name']) ?></td>
                                <td><?= htmlspecialchars($row['designation']) ?></td>
                                <td class="coh-faculty-name"><?= htmlspecialchars($row['faculty_name']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 4. IMPORTANT CELLS AND COMMITTEES -->
        <section class="coh-section-block">
            <div class="coh-section-header">
                <span class="coh-section-kicker">CAMPUS WELFARE &amp; CELLS</span>
                <h2>Important Cells and Committees</h2>
                <p>Statutory cells, student welfare bodies, administrative facilities, and nodal officers.</p>
            </div>

            <div class="coh-table-wrap">
                <table class="coh-clean-table">
                    <thead>
                        <tr>
                            <th style="width: 38%;">Cells / Committees</th>
                            <th style="width: 22%;">Designation</th>
                            <th style="width: 40%;">Name of Officer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cellsList as $row): 
                            $desig = $row['designation'];
                            $tagClass = 'coh-tag-member';
                            if (stripos($desig, 'Vice President') !== false || stripos($desig, 'Chairman') !== false) {
                                $tagClass = 'coh-tag-chairman';
                            } elseif (stripos($desig, 'Convener') !== false) {
                                $tagClass = 'coh-tag-convener';
                            } elseif (stripos($desig, 'Coordinator') !== false || stripos($desig, 'Rector') !== false) {
                                $tagClass = 'coh-tag-coordinator';
                            }
                        ?>
                            <tr>
                                <td class="coh-primary-cell"><?= htmlspecialchars($row['cell_name']) ?></td>
                                <td>
                                    <span class="coh-tag <?= $tagClass ?>"><?= htmlspecialchars($desig) ?></span>
                                </td>
                                <td><?= htmlspecialchars($row['officer_name']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 5. IMPORTANT CONTACTS -->
        <section class="coh-section-block">
            <div class="coh-section-header">
                <span class="coh-section-kicker">INSTITUTIONAL DIRECTORY</span>
                <h2>Important Contacts</h2>
                <p>Key helpline numbers, university offices, emergency contacts, and administrative desks.</p>
            </div>

            <div class="coh-table-wrap">
                <table class="coh-clean-table">
                    <thead>
                        <tr>
                            <th style="width: 8%; text-align: center;">Sr.</th>
                            <th style="width: 58%;">Organization / Authority</th>
                            <th style="width: 34%;">Contact Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contactsList as $row): ?>
                            <tr>
                                <td style="text-align: center; color: var(--coh-muted); font-weight: 600;"><?= (int)$row['sr_no'] ?></td>
                                <td class="coh-primary-cell"><?= htmlspecialchars($row['organization_name']) ?></td>
                                <td>
                                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $row['contact_number']) ?>" class="coh-phone-link">
                                        <i class="fas fa-phone" style="font-size: 0.8rem;" aria-hidden="true"></i>
                                        <span><?= htmlspecialchars($row['contact_number']) ?></span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
