<?php
$pageTitle = 'Q16 - Cookie Preferences';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theme = ($_POST['theme'] ?? '') === 'dark' ? 'dark' : 'light';
    setcookie('preferred_theme', $theme, [
        'expires' => time() + (30 * 24 * 60 * 60),
        'path' => '/',
        'secure' => !empty($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    header('Location: Q16.php');
    exit;
}
require 'includes/header.php';
$theme = $_COOKIE['preferred_theme'] ?? 'not set';
?>
<section class="card"><h1>Question 16: Store user theme preference in a cookie</h1>
<p>Saved theme preference: <strong><?= htmlspecialchars($theme) ?></strong></p>
<form method="post"><label>Select theme</label><select name="theme"><option value="light">Light</option><option value="dark">Dark</option></select><button>Save Preference</button></form>
<p>The cookie is configured with HttpOnly and SameSite=Lax. HTTPS deployments should use Secure cookies.</p>
</section><?php require 'includes/footer.php'; ?>