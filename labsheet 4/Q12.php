<?php
session_start();
$pageTitle = 'Q12 - User Authentication';
require 'includes/header.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    try {
        require_once 'includes/db.php';
        $stmt = getPDO()->prepare('SELECT id, username, password_hash FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $message = 'Login successful. Welcome, ' . $user['username'] . '.';
        } else $message = 'Invalid username or password.';
    } catch (PDOException $e) { $message = 'Authentication table not ready. Run sql/setup.sql and Q21 first.'; }
}
?>
<section class="card"><h1>Question 12: User authentication</h1>
<?php if ($message): ?><p class="notice"><?= htmlspecialchars($message) ?></p><?php endif; ?>
<form method="post"><label>Username</label><input name="username" required><label>Password</label><input type="password" name="password" required><button>Login</button></form>
<p>Create a user record with Q21 before testing login. Passwords are checked using <code>password_verify()</code>.</p>
</section><?php require 'includes/footer.php'; ?>