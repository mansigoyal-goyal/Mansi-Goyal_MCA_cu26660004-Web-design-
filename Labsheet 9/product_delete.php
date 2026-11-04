<?php
// Task 10: Secure delete handler (POST + CSRF token + prepared statement)
require_once 'config/db.php';
require_once 'includes/functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_check($_POST['csrf'] ?? '')) {
    http_response_code(403);
    die('Invalid request.');
}
$id = (int)($_POST['id'] ?? 0);

$stmt = $conn->prepare('SELECT image FROM products WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

try {
    $stmt = $conn->prepare('DELETE FROM products WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    if ($row && $row['image'] && is_file("uploads/{$row['image']}")) unlink("uploads/{$row['image']}");
    $msg = 'Product deleted.';
} catch (mysqli_sql_exception $ex) {
    $msg = 'Cannot delete: product is referenced by existing orders.';   // FK RESTRICT
}
header('Location: products.php?msg=' . urlencode($msg));
exit;
