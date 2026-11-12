<?php
/**
 * Faculty Profile General Details Form
 */
$pageTitle = 'General Information';
$pageHeading = 'General Profile Information';
$activeTab = 'profile';

require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $website = trim($_POST['website'] ?? '');
    $experience = trim($_POST['experience'] ?? '');
    $date_of_joining = !empty($_POST['date_of_joining']) ? $_POST['date_of_joining'] : null;
    $date_of_joining_govt = !empty($_POST['date_of_joining_govt']) ? $_POST['date_of_joining_govt'] : null;
    $area_of_interest = trim($_POST['area_of_interest'] ?? '');

    if (empty($name) || empty($designation)) {
        $error = 'Name and Designation are required fields.';
    } else {
        // Handle Photo Upload if provided
        $photo_url = $faculty['photo_url'];

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['photo'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfo, $file['tmp_name']);
            finfo_close($fileInfo);

            if (!in_array($mimeType, $allowedTypes)) {
                $error = 'Invalid image format. Only JPG, PNG, and WebP are allowed.';
            } elseif ($file['size'] > 3 * 1024 * 1024) {
                $error = 'Photo file size exceeds 3MB limit.';
            } else {
                $deptFolder = strtolower($faculty['dept_code']);
                $uploadDir = __DIR__ . '/../../uploads/faculty/' . $deptFolder . '/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $newFileName = 'fac_' . $faculty['id'] . '_' . time() . '.' . strtolower($ext);
                $destination = $uploadDir . $newFileName;

                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $photo_url = 'uploads/faculty/' . $deptFolder . '/' . $newFileName;
                } else {
                    $error = 'Failed to upload photo. Please check folder permissions.';
                }
            }
        }

        if (empty($error)) {
            try {
                // Secure parameterized update bounded strictly to logged in faculty ID
                $stmt = $pdo->prepare("UPDATE faculties SET 
                    name = ?, 
                    designation = ?, 
                    email = ?, 
                    website = ?, 
                    experience = ?, 
                    date_of_joining = ?, 
                    date_of_joining_govt = ?, 
                    area_of_interest = ?, 
                    photo_url = ?, 
                    updated_at = NOW() 
                    WHERE id = ?");
                
                $stmt->execute([
                    $name,
                    $designation,
                    $email,
                    $website,
                    $experience,
                    $date_of_joining,
                    $date_of_joining_govt,
                    $area_of_interest,
                    $photo_url,
                    (int)$faculty['id']
                ]);

                setFacultyFlash('success', 'Profile information updated successfully! Changes are live on your public page.');
                header('Location: index.php');
                exit;
            } catch (Exception $e) {
                $error = 'Update failed: ' . $e->getMessage();
            }
        }
    }
}
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fa-solid fa-id-card"></i> Edit Basic Profile</h3>
        <span style="font-size:12px; color:var(--text-muted);">
            Department: <strong><?= htmlspecialchars($faculty['dept_code']) ?></strong> | Username: <strong><?= htmlspecialchars($faculty['username']) ?></strong>
        </span>
    </div>

    <div class="admin-card-body">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php" enctype="multipart/form-data">
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="name">
                        Full Name with Prefix <span class="required">*</span>
                    </label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($faculty['name'] ?? '') ?>" required>
                    <small style="color:var(--text-muted); font-size:11px;">e.g. Dr. Mahesh B. Chavda</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="designation">
                        Designation <span class="required">*</span>
                    </label>
                    <input type="text" name="designation" id="designation" class="form-control" value="<?= htmlspecialchars($faculty['designation'] ?? '') ?>" required>
                    <small style="color:var(--text-muted); font-size:11px;">e.g. Associate Professor & Head</small>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="email">Official / Academic Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($faculty['email'] ?? '') ?>" placeholder="name@gecmodasa.ac.in">
                </div>

                <div class="form-group">
                    <label class="form-label" for="website">Personal Website / Google Scholar Link</label>
                    <input type="url" name="website" id="website" class="form-control" value="<?= htmlspecialchars($faculty['website'] ?? '') ?>" placeholder="https://scholar.google.com/...">
                </div>
            </div>

            <div class="grid-3">
                <div class="form-group">
                    <label class="form-label" for="experience">Total Experience</label>
                    <input type="text" name="experience" id="experience" class="form-control" value="<?= htmlspecialchars($faculty['experience'] ?? '') ?>" placeholder="e.g. 15+ Years">
                </div>

                <div class="form-group">
                    <label class="form-label" for="date_of_joining">Date of Joining GECM</label>
                    <input type="date" name="date_of_joining" id="date_of_joining" class="form-control" value="<?= htmlspecialchars($faculty['date_of_joining'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="date_of_joining_govt">Date of Joining Govt. Service</label>
                    <input type="date" name="date_of_joining_govt" id="date_of_joining_govt" class="form-control" value="<?= htmlspecialchars($faculty['date_of_joining_govt'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="area_of_interest">Area of Interest / Specialization</label>
                <textarea name="area_of_interest" id="area_of_interest" class="form-control" placeholder="e.g. Machine Learning, Cloud Computing, Distributed Systems, Computer Networks"><?= htmlspecialchars($faculty['area_of_interest'] ?? '') ?></textarea>
                <small style="color:var(--text-muted); font-size:11px;">Separate multiple areas with commas.</small>
            </div>

            <div class="form-group" style="padding: 16px; background-color: #f8fafc; border-radius: var(--radius-sm); border: 1px dashed var(--border-color);">
                <label class="form-label" for="photo">Update Profile Photo</label>
                <div style="display:flex; align-items:center; gap:20px; flex-wrap:wrap;">
                    <img src="<?= htmlspecialchars($photoPath) ?>" alt="Current Avatar" style="width:70px; height:70px; border-radius:50%; object-fit:cover; border:2px solid var(--accent-orange);" onerror="this.src='../assets/images/faculty/default.jpg'">
                    <div style="flex:1; min-width:240px;">
                        <input type="file" name="photo" id="photo" class="form-control" accept="image/png, image/jpeg, image/webp">
                        <small style="color:var(--text-muted); font-size:11px; display:block; margin-top:4px;">
                            Supported formats: JPG, PNG, WEBP (Max 3MB). Leave blank to keep current photo.
                        </small>
                    </div>
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:24px;">
                <button type="submit" class="btn btn-navy">
                    <i class="fa-solid fa-floppy-disk"></i> Save Profile Changes
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
