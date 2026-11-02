<?php
$pageTitle = 'Q20 - PHP Extensions';
require 'includes/header.php';
$extensions = ['mysqli', 'pdo_mysql', 'mbstring', 'curl'];
?>
<section class="card"><h1>Question 20: Check active PHP extensions</h1>
<table><tr><th>Extension</th><th>Status</th></tr>
<?php foreach ($extensions as $extension): ?>
<tr><td><?= htmlspecialchars($extension) ?></td><td><?= extension_loaded($extension) ? 'Enabled' : 'Not enabled' ?></td></tr>
<?php endforeach; ?>
</table>
<p>To enable an extension, open the active <code>php.ini</code>, remove the leading semicolon from the relevant <code>extension=</code> line, save and restart Apache. Verify again on this page.</p>
</section><?php require 'includes/footer.php'; ?>