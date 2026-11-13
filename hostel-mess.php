<?php
$page_title = "Hostel & Mess Facility :: Government Engineering College, Modasa";
$active_page = 'hostel-mess';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

$hostelData = null;
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM hostel_mess LIMIT 1");
    $hostelData = $stmt ? $stmt->fetch() : null;
}

$title = $hostelData['title'] ?? 'Hostel & Mess Facility - GEC Modasa';
$overview = $hostelData['overview'] ?? 'Government Engineering College, Modasa provides safe, comfortable, and affordable on-campus hostel accommodation for both male and female students coming from different parts of Gujarat and other states. The hostels are equipped with essential amenities, round-the-clock security, and cooperative mess facilities.';
$boysCapacity = $hostelData['boys_hostel_capacity'] ?? '4 Blocks (Block A, B, C & D) accommodating 600+ students';
$girlsCapacity = $hostelData['girls_hostel_capacity'] ?? 'Dedicated Girls Hostel Block accommodating 200+ students with 24/7 female warden and security guard';
$rector = $hostelData['rector_name'] ?? 'Dr. U. V. Shah (Professor in Mechanical Dept.) - Rector';
$wardens = $hostelData['warden_info'] ?? "• Prof. P. R. Gamit (Assistant Prof. in Computer Dept.) - Assistant Rector\n• Prof. P. V. Patel (Assistant Prof. in EC Dept.) - Assistant Rector";
$mess = $hostelData['mess_details'] ?? 'Student-run cooperative mess providing hygienic, nutritious vegetarian breakfast, lunch, and dinner. The mess committee comprises student representatives and wardens to inspect food quality regularly.';
$rules = $hostelData['rules_regulations'] ?? "1. Hostel admission is granted strictly on merit basis according to prevailing government norms.\n2. Ragging in any form is strictly banned and punishable by immediate rustication and police action.\n3. Resident students must report back to the hostel before 8:00 PM (Girls) / 9:00 PM (Boys).\n4. Cleanliness and discipline inside rooms and common areas must be maintained at all times.";
?>

<div style="background-color: #f8fafc; min-height: calc(100vh - 280px); padding: 30px 0 60px 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <div style="max-width: 1140px; margin: 0 auto; padding: 0 20px;">
        
        <!-- Breadcrumbs -->
        <div style="font-size: 13px; color: #64748b; margin-bottom: 24px;">
            <a href="index.php" style="color: #0284c7; text-decoration: none;"><i class="fas fa-home"></i></a>
            <span style="color: #cbd5e1; margin: 0 6px;">/</span>
            <span>Administration</span>
            <span style="color: #cbd5e1; margin: 0 6px;">/</span>
            <span style="color: #1e293b; font-weight: 500;">Hostel &amp; Mess</span>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 35px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);">
            <div style="border-bottom: 2px solid #0284c7; padding-bottom: 12px; margin-bottom: 25px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;"><?= htmlspecialchars($title) ?></h1>
            </div>

            <p style="font-size: 15px; line-height: 1.75; color: #334155; margin-bottom: 30px; text-align: justify;">
                <?= nl2br(htmlspecialchars($overview)) ?>
            </p>

            <!-- Hostel Accommodation Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; margin-bottom: 35px;">
                
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px;">
                    <div style="font-size: 16px; font-weight: 700; color: #0284c7; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-male"></i> Boys' Hostel
                    </div>
                    <div style="font-size: 14.5px; line-height: 1.6; color: #334155;">
                        <?= htmlspecialchars($boysCapacity) ?>
                    </div>
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px;">
                    <div style="font-size: 16px; font-weight: 700; color: #0284c7; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-female"></i> Girls' Hostel
                    </div>
                    <div style="font-size: 14.5px; line-height: 1.6; color: #334155;">
                        <?= htmlspecialchars($girlsCapacity) ?>
                    </div>
                </div>

            </div>

            <!-- Rector & Mess Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; margin-bottom: 35px;">
                
                <!-- Rector and Wardens -->
                <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 22px;">
                    <div style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
                        <i class="fas fa-user-shield text-primary"></i> Hostel Administration
                    </div>
                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 12.5px; text-transform: uppercase; color: #64748b; font-weight: 600;">Rector</div>
                        <div style="font-size: 15px; font-weight: 700; color: #1e293b;"><?= htmlspecialchars($rector) ?></div>
                    </div>
                    <div>
                        <div style="font-size: 12.5px; text-transform: uppercase; color: #64748b; font-weight: 600; margin-bottom: 4px;">Assistant Rectors / Wardens</div>
                        <div style="font-size: 14px; line-height: 1.7; color: #334155; white-space: pre-line;"><?= htmlspecialchars($wardens) ?></div>
                    </div>
                </div>

                <!-- Mess Details -->
                <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 22px;">
                    <div style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
                        <i class="fas fa-utensils text-primary"></i> Mess &amp; Dining Facilities
                    </div>
                    <p style="font-size: 14px; line-height: 1.7; color: #334155; margin: 0; text-align: justify;">
                        <?= nl2br(htmlspecialchars($mess)) ?>
                    </p>
                </div>

            </div>

            <!-- Rules & Regulations -->
            <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 24px;">
                <h2 style="font-size: 17px; font-weight: 700; color: #1e293b; margin: 0 0 12px 0; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
                    <i class="fas fa-clipboard-list text-primary"></i> Key Rules &amp; Regulations
                </h2>
                <div style="font-size: 14.5px; line-height: 1.8; color: #334155; white-space: pre-line;">
                    <?= htmlspecialchars($rules) ?>
                </div>
            </div>

        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

