<?php
$pageTitle = 'Q18 - Apache Logs';
require 'includes/header.php';
?>
<section class="card"><h1>Question 18: Test Apache logs</h1>
<p>This request is recorded in Apache's access log. A PHP warning/error can be recorded in the PHP/Apache error log depending on your configuration.</p>
<p>Common XAMPP log locations:</p>
<pre>xampp/apache/logs/access.log
xampp/apache/logs/error.log</pre>
<p>To test:</p>
<ol><li>Refresh this page several times and inspect <code>access.log</code>.</li><li>Check <code>error.log</code> after a controlled test error in a local-only environment.</li><li>Remove the test error after checking. Never display detailed errors on a public production server.</li></ol>
<p>Apache log paths can differ by operating system and installation.</p>
</section><?php require 'includes/footer.php'; ?>