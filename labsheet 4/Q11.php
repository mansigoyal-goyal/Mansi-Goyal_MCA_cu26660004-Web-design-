<?php
$pageTitle = 'Q11 - Server Variables';
require 'includes/header.php';
?>
<section class="card"><h1>Question 11: Apache environment and server details</h1>
<table><tr><th>Server variable</th><th>Value</th></tr>
<?php
$keys = ['SERVER_SOFTWARE','SERVER_NAME','SERVER_ADDR','SERVER_PORT','DOCUMENT_ROOT','SCRIPT_NAME','REQUEST_METHOD','REQUEST_URI','HTTP_HOST'];
foreach ($keys as $key) {
    echo '<tr><td>' . htmlspecialchars($key) . '</td><td>' . htmlspecialchars($_SERVER[$key] ?? 'Not available') . '</td></tr>';
}
?>
</table>
</section><?php require 'includes/footer.php'; ?>