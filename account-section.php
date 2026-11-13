<?php
$page_title = "Account Section :: Government Engineering College, Modasa";
$active_page = 'account-section';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

$accountData = null;
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM account_section LIMIT 1");
    $accountData = $stmt ? $stmt->fetch() : null;
}

$title = $accountData['title'] ?? 'Account Section - GEC Modasa';
$description = $accountData['description'] ?? 'The Account Section manages all institutional financial transactions, student fee collection, scholarships disbursement, grants from government and funding agencies, payroll processing, and audit compliance for Government Engineering College, Modasa.';
$inCharge = $accountData['in_charge_name'] ?? 'Dr. M. A. Patel';
$inChargeDesig = $accountData['in_charge_designation'] ?? 'Associate Prof. in Sci. and Hum. Dept. (Account Section In-Charge)';
$cashier = $accountData['cashier_name'] ?? 'Shri Vipul Damor';
$location = $accountData['office_location'] ?? 'Administrative Block, Ground Floor, Room No. 102';
$email = $accountData['contact_email'] ?? 'accounts@gecmodasa.ac.in';
$phone = $accountData['contact_phone'] ?? '02774-242633';
$services = $accountData['services_offered'] ?? "• Student Tuition Fee & Term Fee Collection\n• Government & Non-Government Scholarships Processing (Digital Gujarat, NSP, MYSY)\n• Staff Salary & Remuneration Processing\n• Purchase & Procurement Billing\n• Statutory Audits & Financial Reporting";
?>

<div style="background-color: #f8fafc; min-height: calc(100vh - 280px); padding: 30px 0 60px 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <div style="max-width: 1140px; margin: 0 auto; padding: 0 20px;">
        
        <!-- Breadcrumbs -->
        <div style="font-size: 13px; color: #64748b; margin-bottom: 24px;">
            <a href="index.php" style="color: #0284c7; text-decoration: none;"><i class="fas fa-home"></i></a>
            <span style="color: #cbd5e1; margin: 0 6px;">/</span>
            <span>Administration</span>
            <span style="color: #cbd5e1; margin: 0 6px;">/</span>
            <span style="color: #1e293b; font-weight: 500;">Account Section</span>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 35px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);">
            <div style="border-bottom: 2px solid #0284c7; padding-bottom: 12px; margin-bottom: 25px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;"><?= htmlspecialchars($title) ?></h1>
            </div>

            <p style="font-size: 15px; line-height: 1.75; color: #334155; margin-bottom: 30px; text-align: justify;">
                <?= nl2br(htmlspecialchars($description)) ?>
            </p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-bottom: 35px;">
                
                <!-- Key Staff Card -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px;">
                    <div style="font-size: 16px; font-weight: 700; color: #0284c7; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-users-cog"></i> Key Personnel
                    </div>
                    <div style="margin-bottom: 12px;">
                        <div style="font-size: 12.5px; text-transform: uppercase; color: #64748b; font-weight: 600;">Officer In-Charge</div>
                        <div style="font-size: 15px; font-weight: 700; color: #1e293b;"><?= htmlspecialchars($inCharge) ?></div>
                        <div style="font-size: 13.5px; color: #475569;"><?= htmlspecialchars($inChargeDesig) ?></div>
                    </div>
                    <div>
                        <div style="font-size: 12.5px; text-transform: uppercase; color: #64748b; font-weight: 600;">Cashier / Staff</div>
                        <div style="font-size: 15px; font-weight: 700; color: #1e293b;"><?= htmlspecialchars($cashier) ?></div>
                    </div>
                </div>

                <!-- Office & Contact Card -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px;">
                    <div style="font-size: 16px; font-weight: 700; color: #0284c7; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-map-marker-alt"></i> Office &amp; Contact
                    </div>
                    <div style="margin-bottom: 10px;">
                        <div style="font-size: 12.5px; text-transform: uppercase; color: #64748b; font-weight: 600;">Location</div>
                        <div style="font-size: 14.5px; color: #1e293b;"><?= htmlspecialchars($location) ?></div>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <div style="font-size: 12.5px; text-transform: uppercase; color: #64748b; font-weight: 600;">Email</div>
                        <a href="mailto:<?= htmlspecialchars($email) ?>" style="font-size: 14.5px; color: #0284c7; text-decoration: none; font-weight: 500;"><?= htmlspecialchars($email) ?></a>
                    </div>
                    <div>
                        <div style="font-size: 12.5px; text-transform: uppercase; color: #64748b; font-weight: 600;">Phone</div>
                        <a href="tel:<?= preg_replace('/[^0-9+]/', '', $phone) ?>" style="font-size: 14.5px; color: #0284c7; text-decoration: none; font-weight: 500;"><?= htmlspecialchars($phone) ?></a>
                    </div>
                </div>

            </div>

            <!-- Key Responsibilities & Services -->
            <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 24px;">
                <h2 style="font-size: 17px; font-weight: 700; color: #1e293b; margin: 0 0 14px 0; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
                    Key Responsibilities &amp; Student Services
                </h2>
                <div style="font-size: 14.5px; line-height: 1.8; color: #334155; white-space: pre-line;">
                    <?= htmlspecialchars($services) ?>
                </div>
            </div>

        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

