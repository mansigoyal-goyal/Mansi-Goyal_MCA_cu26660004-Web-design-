<?php
$pageTitle = 'Q8 - Update Student Email';
require 'includes/header.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $email = trim($_POST['email'] ?? '');
    if (!$id || !filter_var($email, FILTER_VALIDATE_EMAIL)) $message = 'Enter a valid student ID and email.';
    else {
        try {
            require_once 'includes/db.php';
            $stmt = getPDO()->prepare('UPDATE students SET email = :email WHERE id = :id');
            $stmt->execute(['email' => $email, 'id' => $id]);
            $message = $stmt->rowCount() ? 'Student email updated.' : 'No row changed. Check the ID or whether the email is unchanged.';
        } catch (PDOException $e) { $message = 'Update failed. The email may already be in use.'; }
    }
}
?>
<section class="card"><h1>Question 8: Update a student's email</h1>
<?php if ($message): ?><p class="notice"><?= htmlspecialchars($message) ?></p><?php endif; ?>
<form method="post"><label>Student ID</label><input type="number" name="id" min="1" required><label>New email</label><input type="email" name="email" required><button>Update Email</button></form>
</section><?php require 'includes/footer.php'; ?>