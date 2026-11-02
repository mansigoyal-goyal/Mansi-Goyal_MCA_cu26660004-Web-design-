<?php
$pageTitle = 'Q19 - PDO Transactions';
require 'includes/header.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require_once 'includes/db.php';
        $pdo = getPDO();
        $pdo->beginTransaction();

        $studentStmt = $pdo->prepare('INSERT INTO students (name, email, enrollment_date) VALUES (?, ?, CURDATE())');
        $studentStmt->execute([trim($_POST['name'] ?? ''), trim($_POST['email'] ?? '')]);
        $studentId = (int)$pdo->lastInsertId();

        // A second related operation is written to the audit table.
        $auditStmt = $pdo->prepare('INSERT INTO activity_log (student_id, activity) VALUES (?, ?)');
        $auditStmt->execute([$studentId, 'Student record created']);

        $pdo->commit();
        $message = 'Transaction committed. Student and activity log were both saved.';
    } catch (Throwable $e) {
        if (isset($pdo) && $pdo->inTransaction()) $pdo->rollBack();
        $message = 'Transaction rolled back. Check the input, database tables and connection.';
    }
}
?>
<section class="card"><h1>Question 19: PDO transaction management</h1>
<?php if ($message): ?><p class="notice"><?= htmlspecialchars($message) ?></p><?php endif; ?>
<form method="post"><label>Student name</label><input name="name" required><label>Student email</label><input type="email" name="email" required><button>Run Transaction</button></form>
<p>Both inserts succeed together, or the transaction is rolled back. Create the <code>activity_log</code> table using <code>sql/setup.sql</code>.</p>
</section><?php require 'includes/footer.php'; ?>