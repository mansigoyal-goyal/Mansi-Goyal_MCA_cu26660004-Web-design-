<?php
$pageTitle = 'Q1 - Apache Localhost Test';
require 'includes/header.php';
?>
<section class="card">
<h1>Question 1: Configure and verify Apache locally</h1>
<p>This page itself is the default <code>index.php</code> test page. If it loads at <code>http://localhost/your-folder/</code>, Apache is serving PHP correctly.</p>
<div class="notice">Apache/PHP page loaded successfully.</div>
<p><strong>Server software:</strong> <?= htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'Not available') ?></p>
<p><strong>Document root:</strong> <?= htmlspecialchars($_SERVER['DOCUMENT_ROOT'] ?? 'Not available') ?></p>
<p>For the root URL <code>http://localhost</code>, place an <code>index.php</code> or <code>index.html</code> file directly in Apache's document root (such as XAMPP's <code>htdocs</code>).</p>
</section>
<?php require 'includes/footer.php'; ?>
