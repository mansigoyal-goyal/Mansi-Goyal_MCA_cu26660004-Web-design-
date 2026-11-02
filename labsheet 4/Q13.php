<?php
$pageTitle = 'Q13 - Image Upload';
require 'includes/header.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $maxSize = 2 * 1024 * 1024;
    $allowed = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'];
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($file['error'] !== UPLOAD_ERR_OK) $message = 'Upload failed. Error code: ' . $file['error'];
    elseif ($file['size'] > $maxSize) $message = 'File is larger than 2 MB.';
    elseif (!isset($allowed[$extension])) $message = 'Only JPG, JPEG, PNG and GIF files are allowed.';
    else {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        if ($mime !== $allowed[$extension]) $message = 'File content does not match the allowed image type.';
        else {
            $uploadDir = __DIR__ . '/uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $safeName = bin2hex(random_bytes(16)) . '.' . $extension;
            if (move_uploaded_file($file['tmp_name'], $uploadDir . $safeName)) $message = 'Image uploaded successfully as ' . $safeName;
            else $message = 'Could not save uploaded image.';
        }
    }
}
?>
<section class="card"><h1>Question 13: Upload and validate an image</h1>
<?php if ($message): ?><p class="notice"><?= htmlspecialchars($message) ?></p><?php endif; ?>
<form method="post" enctype="multipart/form-data"><label>Select image (maximum 2 MB)</label><input type="file" name="image" accept=".jpg,.jpeg,.png,.gif" required><button>Upload Image</button></form>
<p>For production, also disable PHP execution inside the uploads directory and apply server-side access controls.</p>
</section><?php require 'includes/footer.php'; ?>