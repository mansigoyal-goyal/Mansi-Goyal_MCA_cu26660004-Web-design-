<?php
$pageTitle = 'Q6 - Insert Student';
require 'includes/header.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $date = $_POST['enrollment_date'] ?? '';
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        $message = 'Enter a name, valid email and enrollment date.';
    } else {
        try {
            require_once 'includes/db.php';
            $stmt = getPDO()->prepare('INSERT INTO students (name, email, enrollment_date) VALUES (:name, :email, :date)');
            $stmt->execute(['name' => $name, 'email' => $email, 'date' => $date]);
            $message = 'Student inserted successfully. New ID: ' . getPDO()->lastInsertId();
        } catch (PDOException $e) { $message = 'Insert failed. Check for duplicate email or database setup.'; }
    }
}
?>
<section class="card"><h1>Question 6: Insert student using prepared statement</h1>
<?php if ($message): ?><p class="notice"><?= htmlspecialchars($message) ?></p><?php endif; ?>
<form method="post">
<label>Name</label><input name="name" required maxlength="100">
<label>Email</label><input name="email" type="email" required maxlength="150">
<label>Enrollment date</label><input name="enrollment_date" type="date" required>
<button type="submit">Insert Student</button>
</form></section>
<?php require 'includes/footer.php'; ?>