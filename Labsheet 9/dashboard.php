<?php
// Task 5: Protected dashboard
require_once 'config/db.php';
require_once 'includes/functions.php';
require_login();

$uid = (int)$_SESSION['user_id'];
$stmt = $conn->prepare('SELECT COUNT(*) c FROM orders WHERE user_id = ?');
$stmt->bind_param('i', $uid);
$stmt->execute();
$orderCount = $stmt->get_result()->fetch_assoc()['c'];
$productCount = $conn->query('SELECT COUNT(*) c FROM products')->fetch_assoc()['c'];

$stmt = $conn->prepare('SELECT o.id, p.name, o.quantity, o.unit_price, o.created_at
                        FROM orders o JOIN products p ON p.id = o.product_id
                        WHERE o.user_id = ? ORDER BY o.id DESC LIMIT 10');
$stmt->bind_param('i', $uid);
$stmt->execute();
$orders = $stmt->get_result();

$pageTitle = 'Dashboard';
include 'includes/header.php';
?>
<h1>Dashboard</h1>
<p>Welcome, <strong><?= e($_SESSION['username']) ?></strong>!</p>
<p>Total products: <strong><?= (int)$productCount ?></strong> | Your orders: <strong><?= (int)$orderCount ?></strong></p>
<h2>Recent Orders</h2>
<table>
  <tr><th>#</th><th>Product</th><th>Qty</th><th>Unit Price</th><th>Date</th></tr>
  <?php while ($o = $orders->fetch_assoc()): ?>
  <tr><td><?= (int)$o['id'] ?></td><td><?= e($o['name']) ?></td><td><?= (int)$o['quantity'] ?></td>
      <td>₹<?= number_format($o['unit_price'], 2) ?></td><td><?= e($o['created_at']) ?></td></tr>
  <?php endwhile; ?>
</table>
<?php include 'includes/footer.php'; ?>
