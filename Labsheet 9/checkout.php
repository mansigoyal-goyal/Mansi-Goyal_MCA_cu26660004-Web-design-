<?php
// Task 19: Checkout using a database transaction (BEGIN / COMMIT / ROLLBACK)
require_once 'config/db.php';
require_once 'includes/functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_check($_POST['csrf'] ?? '')) { http_response_code(403); die('Invalid request.'); }
if (empty($_SESSION['cart'])) { header('Location: cart.php'); exit; }

$uid = (int)$_SESSION['user_id'];

try {
    $conn->begin_transaction();                                    // BEGIN

    $sel = $conn->prepare('SELECT price, stock FROM products WHERE id = ? FOR UPDATE');   // lock row
    $ins = $conn->prepare('INSERT INTO orders (user_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)');
    $upd = $conn->prepare('UPDATE products SET stock = stock - ? WHERE id = ?');

    foreach ($_SESSION['cart'] as $pid => $qty) {
        $pid = (int)$pid; $qty = (int)$qty;
        $sel->bind_param('i', $pid); $sel->execute();
        $prod = $sel->get_result()->fetch_assoc();
        if (!$prod)                  throw new Exception("Product #$pid no longer exists.");
        if ($prod['stock'] < $qty)   throw new Exception("Not enough stock for product #$pid.");

        $price = (float)$prod['price'];
        $ins->bind_param('iiid', $uid, $pid, $qty, $price); $ins->execute();
        $upd->bind_param('ii', $qty, $pid);                  $upd->execute();
    }

    $conn->commit();                                               // COMMIT
    $_SESSION['cart'] = [];
    header('Location: cart.php?ok=' . urlencode('Order placed successfully!'));
} catch (Throwable $ex) {
    $conn->rollback();                                             // ROLLBACK
    header('Location: cart.php?error=' . urlencode($ex->getMessage()));
}
exit;
