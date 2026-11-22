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

/**
 * Handle Multiple Images Upload (e.g. for activity photo galleries/sliders)
 */
function handleMultipleImageUpload($filesKey, $subfolder = 'cell_activities') {
    $uploadedPaths = [];
    if (!isset($_FILES[$filesKey]) || !is_array($_FILES[$filesKey]['name'])) {
        return $uploadedPaths;
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $cleanSubfolder = trim(str_replace('\\', '/', $subfolder), '/');
    $targetDir = realpath(__DIR__ . '/../../uploads');
    if (!$targetDir) {
        $targetDir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads';
    }
    $targetDir .= DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $cleanSubfolder) . DIRECTORY_SEPARATOR;

    if (!is_dir($targetDir)) {
        @mkdir($targetDir, 0777, true);
    }

    $fileCount = count($_FILES[$filesKey]['name']);
    for ($i = 0; $i < $fileCount; $i++) {
        if ($_FILES[$filesKey]['error'][$i] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES[$filesKey]['name'][$i], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedExtensions)) {
                continue;
            }
            if ($_FILES[$filesKey]['size'][$i] > 10 * 1024 * 1024) {
                continue;
            }

            $cleanFilename = basename(str_replace('\\', '/', $cleanSubfolder)) . '_gal_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $targetFile = $targetDir . $cleanFilename;

            if (move_uploaded_file($_FILES[$filesKey]['tmp_name'][$i], $targetFile)) {
                $uploadedPaths[] = 'uploads/' . $cleanSubfolder . '/' . $cleanFilename;
            }
        }
    }

    return $uploadedPaths;
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

/**
 * Safely delete an uploaded file from disk.
 *
 * @param string|null $relativePath Relative path to uploaded file (e.g. 'uploads/hostel/file.pdf')
 * @return bool True if deleted or already absent, False on failure
 */
function deleteUploadedFile($relativePath) {
    if (empty($relativePath)) {
        return false;
    }

    // Do not touch external URLs
    if (strpos($relativePath, 'http://') === 0 || strpos($relativePath, 'https://') === 0 || strpos($relativePath, '//') === 0) {
        return false;
    }

    $baseUploads = realpath(__DIR__ . '/../../uploads');
    if (!$baseUploads) {
        $baseUploads = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads';
    }

    // Strip traversal and leading slashes
    $cleanRel = ltrim(str_replace(['../', '..\\'], '', $relativePath), '/\\');
    if (strpos($cleanRel, 'uploads/') === 0 || strpos($cleanRel, 'uploads\\') === 0) {
        $cleanRel = substr($cleanRel, 8);
    }

    $fullPath = $baseUploads . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $cleanRel);

    if (file_exists($fullPath) && is_file($fullPath)) {
        return @unlink($fullPath);
    }

    return true;
}

/**
 * Automatically sanitizes PDF internal /Title metadata so browsers (Chrome/Edge/Firefox)
 * display the official document title on the browser tab instead of scanner/merger tags
 * like "MergedFile", "Untitled", etc.
 *
 * Keeps file byte-length strictly identical so xref offsets are preserved.
 */
function sanitizePdfTitle($filePath, $cleanTitle = 'Rules and Regulations for Hostel Students - GEC Modasa') {
    if (!file_exists($filePath) || !is_file($filePath)) {
        return false;
    }

    $content = file_get_contents($filePath);
    if ($content === false) {
        return false;
    }

    $pos = strpos($content, '/Title (');
    if ($pos === false) {
        return true;
    }

    $endPos = strpos($content, ')', $pos + 8);
    if ($endPos === false) {
        return false;
    }

    $currentTitle = substr($content, $pos + 8, $endPos - ($pos + 8));

    // If title has unwanted automated strings
    if (stripos($currentTitle, 'Merged') !== false || stripos($currentTitle, 'Untitled') !== false || stripos($currentTitle, 'Scan') !== false) {
        $oldLen = strlen($currentTitle);
        $cleanSlice = substr($cleanTitle, 0, $oldLen);
        if (strlen($cleanSlice) < $oldLen) {
            $cleanSlice = str_pad($cleanSlice, $oldLen, ' ');
        }
        $content = substr_replace($content, $cleanSlice, $pos + 8, $oldLen);
        file_put_contents($filePath, $content);
        return true;
    }

    return true;
}
