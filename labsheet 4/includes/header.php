<?php
$pageTitle = $pageTitle ?? 'PHP Practical';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="top"><div class="wrap"><a class="brand" href="index.php">PHP Practicals</a><span>Apache · PHP · MySQL</span></div></header>
<main class="wrap">
