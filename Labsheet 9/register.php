<?php
// Task 3: Registration with server-side validation + password_hash()
require_once 'config/db.php';
require_once 'includes/functions.php';
start_session();

$errors = []; $success = '';
$username = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';

    if (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $username)) $errors[] = 'Username must be 3-30 letters, digits or underscores.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))       $errors[] = 'Enter a valid email address.';
    if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password))
        $errors[] = 'Password must be at least 8 characters with a letter and a digit.';
    if ($password !== $confirm) $errors[] = 'Passwords do not match.';

    if (!$errors) {
        $stmt = $conn->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) $errors[] = 'Username or email already exists.';
        $stmt->close();
    }

    if (!$errors) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $username, $email, $hash);
        $stmt->execute();
        $stmt->close();
        $success = 'Registration successful! You can now log in.';
        $username = $email = '';
    }
}
$pageTitle = 'Register';
include 'includes/header.php';
?>
<h1>Register</h1>
<?php foreach ($errors as $err): ?><div class="error"><?= e($err) ?></div><?php endforeach; ?>
<?php if ($success): ?><div class="success"><?= e($success) ?> <a href="login.php">Login</a></div><?php endif; ?>
<form method="post">
  <label>Username</label><input type="text" name="username" value="<?= e($username) ?>" required>
  <label>Email</label><input type="email" name="email" value="<?= e($email) ?>" required>
  <label>Password</label><input type="password" name="password" required>
  <label>Confirm Password</label><input type="password" name="confirm" required>
  <br><br><button type="submit">Register</button>
</form>
<?php include 'includes/footer.php'; ?>
