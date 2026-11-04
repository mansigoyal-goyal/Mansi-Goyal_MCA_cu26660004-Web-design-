<?php
require_once __DIR__ . '/functions.php';
start_session();
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle ?? 'WebApp') ?></title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<nav>
  <a href="products.php">Products</a>
  <?php if (!empty($_SESSION['user_id'])): ?>
    <a href="dashboard.php">Dashboard</a>
    <a href="product_add.php">Add Product</a>
    <a href="cart.php">Cart (<?= (int)$cartCount ?>)</a>
    <span class="spacer"></span>
    <span>Hi, <?= e($_SESSION['username']) ?></span>
    <a href="logout.php">Logout</a>
  <?php else: ?>
    <span class="spacer"></span>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
  <?php endif; ?>
</nav>
<main>
