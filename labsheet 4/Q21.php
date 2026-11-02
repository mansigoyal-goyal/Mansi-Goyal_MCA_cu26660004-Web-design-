<?php
$pageTitle = 'Q21 - Password Hashing';
require 'includes/header.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || strlen($password) < 8) {
        $message = 'Enter a username and a password of at least 8 characters.';
    } else {
        try {
            require_once 'includes/db.php';
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = getPDO()->prepare('INSERT INTO users (username, password_hash) VALUES (:username, :hash)');
            $stmt->execute(['username' => $username, 'hash' => $hash]);
            $message = 'User created. The password was stored as a hash.';
        } catch (PDOException $e) { $message = 'Could not create user. Username may already exist or setup may be incomplete.'; }
    }
}
?>
<section class="card"><h1>Question 21: password_hash() and password_verify()</h1>
<?php if ($message): ?><p class="notice"><?= htmlspecialchars($message) ?></p><?php endif; ?>
<form method="post"><label>Username</label><input name="username" required><label>Password (minimum 8 characters)</label><input type="password" name="password" minlength="8" required><button>Create User</button></form>
<p>The password hash is stored in MySQL. Test authentication using Q12, which verifies the submitted password with <code>password_verify()</code>.</p>
</section><?php require 'includes/footer.php'; ?>