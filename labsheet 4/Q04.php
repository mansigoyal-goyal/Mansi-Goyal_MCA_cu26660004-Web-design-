<?php
$pageTitle = 'Q4 - PDO Connection';
require 'includes/header.php';
?>
<section class="card">
<h1>Question 4: Connect PHP to MySQL using PDO</h1>
<?php
try {
    require_once 'includes/db.php';
    $pdo = getPDO();
    echo '<div class="notice">Database connection successful.</div>';
} catch (PDOException $e) {
    echo '<div class="error">Connection failed. Check includes/config.php, MySQL service and database user.</div>';
}
?>
<p>The shared connection uses PDO exceptions, utf8mb4 and native prepared statements.</p>
</section>
<?php require 'includes/footer.php'; ?>