<?php
// Task 4 + Task 17: Login with password_verify(), sessions and "Remember Me" cookie
require_once 'config/db.php';
require_once 'includes/functions.php';
start_session();

if (!empty($_SESSION['user_id'])) { header('Location: dashboard.php'); exit; }

$error = '';
$rememberedUser = $_COOKIE['remember_username'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare('SELECT id, username, password FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);                 // prevent session fixation
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];

        if (!empty($_POST['remember'])) {            // Remember Me: store username for 30 days
            setcookie('remember_username', $user['username'], [
                'expires' => time() + 60*60*24*30, 'path' => '/',
                'httponly' => true, 'samesite' => 'Lax'
            ]);
        } else {
            setcookie('remember_username', '', time() - 3600, '/');
        }
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Invalid username or password.';
}
$pageTitle = 'Login';
include 'includes/header.php';
?>
<h1>Login</h1>
<?php if ($rememberedUser): ?><p>Welcome back, <strong><?= e($rememberedUser) ?></strong>!</p><?php endif; ?>
<?php if ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?>
<form method="post">
  <label>Username</label>
  <input type="text" name="username" value="<?= e($rememberedUser) ?>" required>
  <label>Password</label>
  <input type="password" name="password" required>
  <label style="font-weight:normal"><input type="checkbox" name="remember" <?= $rememberedUser ? 'checked' : '' ?>> Remember me</label>
  <br><button type="submit">Login</button>
</form>
<?php include 'includes/footer.php'; ?>
