<?php
// Task 16: XSS protection helper - use e() for ALL output
function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function start_session(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
}

// Task 5: protect pages
function require_login(): void {
    start_session();
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

// CSRF token helpers (used for delete / forms)
function csrf_token(): string {
    start_session();
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_check(string $token): bool {
    start_session();
    return !empty($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

// Task 14: Image upload with validation (type, size, unique name)
function upload_product_image(array $file, ?string &$error): ?string {
    if ($file['error'] === UPLOAD_ERR_NO_FILE) return null;
    if ($file['error'] !== UPLOAD_ERR_OK) { $error = 'Upload failed.'; return null; }
    if ($file['size'] > 2 * 1024 * 1024)  { $error = 'Image must be 2MB or smaller.'; return null; }

    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);   // real MIME, not client-supplied
    if (!isset($allowed[$mime])) { $error = 'Only JPG, PNG, GIF or WEBP images are allowed.'; return null; }

    $name = bin2hex(random_bytes(8)) . '_' . time() . '.' . $allowed[$mime];  // unique name
    $dir = __DIR__ . '/../uploads/';
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    if (!move_uploaded_file($file['tmp_name'], $dir . $name)) { $error = 'Could not save image.'; return null; }
    return $name;
}
