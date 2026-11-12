<?php
/**
 * GEC MODASA - Image & PDF Upload Handler
 * Supports direct file uploads from PC with validation and preview.
 */

function handleImageUpload($fileOrKey, $subfolder = 'general', $existingPath = null, $urlFallback = null) {
    $file = null;
    if (is_array($fileOrKey) && isset($fileOrKey['name'])) {
        $file = $fileOrKey;
    } elseif (is_string($fileOrKey) && isset($_FILES[$fileOrKey])) {
        $file = $_FILES[$fileOrKey];
    }

    if ($file && $file['error'] === UPLOAD_ERR_OK) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExtensions)) {
            return [
                'success' => false,
                'error'   => 'Invalid file format. Allowed formats: JPG, JPEG, PNG, WEBP, GIF.'
            ];
        }

        if ($file['size'] > 10 * 1024 * 1024) {
            return [
                'success' => false,
                'error'   => 'File size exceeds maximum limit of 10MB.'
            ];
        }

        // Clean subfolder name (e.g. dept_activities/civil)
        $cleanSubfolder = trim(str_replace('\\', '/', $subfolder), '/');
        $targetDir = realpath(__DIR__ . '/../../uploads');
        if (!$targetDir) {
            $targetDir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads';
        }
        $targetDir .= DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $cleanSubfolder) . DIRECTORY_SEPARATOR;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Clean base filename without slash/subfolder path
        $baseNamePrefix = basename(str_replace('\\', '/', $cleanSubfolder));
        $cleanFilename = $baseNamePrefix . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $targetFile = $targetDir . $cleanFilename;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return [
                'success' => true,
                'path'    => 'uploads/' . $cleanSubfolder . '/' . $cleanFilename
            ];
        } else {
            return [
                'success' => false,
                'error'   => 'Could not upload file to server.'
            ];
        }
    }

    // Check optional URL fallback
    if (!empty($urlFallback) && trim($urlFallback) !== '') {
        return [
            'success' => true,
            'path'    => trim($urlFallback)
        ];
    }

    // Keep existing path if editing
    if (!empty($existingPath)) {
        return [
            'success' => true,
            'path'    => $existingPath
        ];
    }

    return [
        'success' => false,
        'error'   => 'Please select an image file from your PC.'
    ];
}

function getAdminImageSrc($path) {
    if (empty($path)) {
        return 'https://via.placeholder.com/60?text=No+Img';
    }
    if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0 || strpos($path, '//') === 0) {
        return $path;
    }
    return '../' . ltrim($path, '/');
}

/**
 * Handle PDF Document Uploads with validation (max 25MB)
 */
function handlePdfUpload($fileOrKey, $subfolder = 'documents', $existingPath = null) {
    $file = null;
    if (is_array($fileOrKey) && isset($fileOrKey['name'])) {
        $file = $fileOrKey;
    } elseif (is_string($fileOrKey) && isset($_FILES[$fileOrKey])) {
        $file = $_FILES[$fileOrKey];
    }

    if ($file && $file['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($ext !== 'pdf') {
            return [
                'success' => false,
                'error'   => 'Only PDF documents (.pdf) are allowed.'
            ];
        }

        if ($file['size'] > 25 * 1024 * 1024) {
            return [
                'success' => false,
                'error'   => 'PDF file size exceeds maximum limit of 25MB.'
            ];
        }

        $cleanSubfolder = trim(str_replace('\\', '/', $subfolder), '/');
        $targetDir = realpath(__DIR__ . '/../../uploads');
        if (!$targetDir) {
            $targetDir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads';
        }
        $targetDir .= DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $cleanSubfolder) . DIRECTORY_SEPARATOR;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Clean base filename prefix without directory slashes!
        $baseNamePrefix = basename(str_replace('\\', '/', $cleanSubfolder));
        $cleanFilename = $baseNamePrefix . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.pdf';
        $targetFile = $targetDir . $cleanFilename;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $bytes = $file['size'];
            $formattedSize = ($bytes >= 1048576) ? number_format($bytes / 1048576, 1) . ' MB' : number_format($bytes / 1024, 0) . ' KB';

            return [
                'success'   => true,
                'path'      => 'uploads/' . $cleanSubfolder . '/' . $cleanFilename,
                'file_size' => $formattedSize
            ];
        } else {
            return [
                'success' => false,
                'error'   => 'Could not save PDF file to server.'
            ];
        }
    }

    if (!empty($existingPath)) {
        return [
            'success' => true,
            'path'    => $existingPath
        ];
    }

    return [
        'success' => false,
        'error'   => 'Please select a valid PDF file.'
    ];
}
