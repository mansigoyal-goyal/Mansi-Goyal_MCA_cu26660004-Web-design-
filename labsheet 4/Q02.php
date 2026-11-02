<?php
// Q2: php.ini should contain display_errors = On and error_reporting = E_ALL.
ini_set('display_errors', '1');
error_reporting(E_ALL);
$pageTitle = 'Q2 - PHP Configuration';
require 'includes/header.php';
?>
<section class="card">
<h1>Question 2: Configure PHP error reporting</h1>
<p>Set these directives in the active php.ini file, then restart Apache:</p>
<pre>display_errors = On
error_reporting = E_ALL</pre>
<p><strong>Current display_errors:</strong> <?= htmlspecialchars((string)ini_get('display_errors')) ?></p>
<p><strong>Current error_reporting:</strong> <?= htmlspecialchars((string)error_reporting()) ?></p>
<p>Use <code>phpinfo()</code> to confirm the loaded configuration file and settings. See <a href="Q02-phpinfo.php">Q2 phpinfo page</a>.</p>
</section>
<?php require 'includes/footer.php'; ?>