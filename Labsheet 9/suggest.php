<?php
// Task 20: AJAX endpoint returning JSON suggestions
require_once 'config/db.php';
header('Content-Type: application/json; charset=utf-8');

$q = trim($_GET['q'] ?? '');
if (strlen($q) < 2) { echo '[]'; exit; }

$like = "%$q%";
$stmt = $conn->prepare('SELECT DISTINCT name FROM products WHERE name LIKE ? ORDER BY name LIMIT 8');
$stmt->bind_param('s', $like);
$stmt->execute();
$names = array_column($stmt->get_result()->fetch_all(MYSQLI_ASSOC), 'name');
echo json_encode($names);
