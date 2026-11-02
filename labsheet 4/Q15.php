<?php
session_start();
$pageTitle = 'Q15 - Session Management';
require 'includes/header.php';
if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: Q15.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $displayName = trim($_POST['display_name'] ?? '');
    if ($displayName !== '') {
        session_regenerate_id(true);
        $_SESSION['display_name'] = $displayName;
    }
}
?>
<section class="card"><h1>Question 15: PHP session management</h1>
<?php if (isset($_SESSION['display_name'])): ?>
<div class="notice">Session active. Hello, <?= htmlspecialchars($_SESSION['display_name']) ?>.</div>
<a class="button" href="Q15.php?logout=1">Clear session</a>
<?php else: ?>
<form method="post"><label>Enter your name</label><input name="display_name" required><button>Start Session</button></form>
<?php endif; ?>
<p><code>session_start()</code> starts or resumes a session, and <code>$_SESSION</code> stores data between page requests.</p>
</section><?php require 'includes/footer.php'; ?>