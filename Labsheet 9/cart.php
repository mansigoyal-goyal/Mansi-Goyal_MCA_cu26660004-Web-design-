<?php
// Task 18: Session-based shopping cart (add / update / remove)
require_once 'config/db.php';
require_once 'includes/functions.php';
require_login();

$_SESSION['cart'] = $_SESSION['cart'] ?? [];   // [product_id => qty]

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    switch ($_POST['action'] ?? '') {
        case 'add':
            $stmt = $conn->prepare('SELECT id FROM products WHERE id = ? AND stock > 0');
            $stmt->bind_param('i', $id); $stmt->execute();
            if ($stmt->get_result()->num_rows) $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
            break;
        case 'update':
            $qty = (int)($_POST['qty'] ?? 1);
            if ($qty <= 0) unset($_SESSION['cart'][$id]); else $_SESSION['cart'][$id] = $qty;
            break;
        case 'remove':
            unset($_SESSION['cart'][$id]);
            break;
    }
    header('Location: cart.php');
    exit;
}

$items = []; $grand = 0;
if ($_SESSION['cart']) {
    $ids = array_keys($_SESSION['cart']);
    $ph = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $conn->prepare("SELECT id, name, price, stock FROM products WHERE id IN ($ph)");
    $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);
    $stmt->execute();
    foreach ($stmt->get_result() as $r) {
        $r['qty'] = $_SESSION['cart'][$r['id']];
        $r['subtotal'] = $r['qty'] * $r['price'];
        $grand += $r['subtotal'];
        $items[] = $r;
    }
}
$pageTitle = 'Cart';
include 'includes/header.php';
?>
<h1>Shopping Cart</h1>
<?php if (!empty($_GET['error'])): ?><div class="error"><?= e($_GET['error']) ?></div><?php endif; ?>
<?php if (!empty($_GET['ok'])): ?><div class="success"><?= e($_GET['ok']) ?></div><?php endif; ?>
<?php if (!$items): ?>
  <p>Your cart is empty. <a href="products.php">Browse products</a></p>
<?php else: ?>
<table>
  <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th></th></tr>
  <?php foreach ($items as $it): ?>
  <tr>
    <td><?= e($it['name']) ?></td>
    <td>₹<?= number_format($it['price'], 2) ?></td>
    <td>
      <form method="post" style="display:flex;gap:6px">
        <input type="hidden" name="action" value="update"><input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
        <input type="number" name="qty" min="0" max="<?= (int)$it['stock'] ?>" value="<?= (int)$it['qty'] ?>" style="width:80px">
        <button>Update</button>
      </form>
    </td>
    <td>₹<?= number_format($it['subtotal'], 2) ?></td>
    <td>
      <form method="post"><input type="hidden" name="action" value="remove"><input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
      <button class="btn-danger">Remove</button></form>
    </td>
  </tr>
  <?php endforeach; ?>
  <tr><th colspan="3" style="text-align:right">Total</th><th colspan="2">₹<?= number_format($grand, 2) ?></th></tr>
</table>
<br>
<form method="post" action="checkout.php">
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
  <button>Checkout</button>
</form>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
