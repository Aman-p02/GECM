<?php
/**
 * GEC MODASA — Image Upload Handler
 * Supports direct file uploads from PC with validation and preview.
 */

function handleImageUpload($fileKey, $subfolder = 'general', $existingPath = null, $urlFallback = null) {
    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES[$fileKey];
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

        $targetDir = __DIR__ . '/../../uploads/' . $subfolder . '/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $cleanFilename = $subfolder . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $targetFile = $targetDir . $cleanFilename;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return [
                'success' => true,
                'path'    => 'uploads/' . $subfolder . '/' . $cleanFilename
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
