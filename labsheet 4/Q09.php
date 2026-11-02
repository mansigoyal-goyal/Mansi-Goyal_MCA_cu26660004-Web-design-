<?php
$pageTitle = 'Q9 - Delete Student';
require 'includes/header.php';
?>
<section class="card"><h1>Question 9: Delete student using GET parameter</h1>
<p>Use a URL such as <code>Q09.php?id=3</code>. For safety, this exercise displays a confirmation link before deleting.</p>
<?php
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id && isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    try {
        require_once 'includes/db.php';
        $stmt = getPDO()->prepare('DELETE FROM students WHERE id = :id');
        $stmt->execute(['id' => $id]);
        echo $stmt->rowCount() ? '<div class="notice">Student deleted.</div>' : '<p>No student found with that ID.</p>';
    } catch (PDOException $e) { echo '<div class="error">Delete failed. Check database setup.</div>'; }
} elseif ($id) {
    $confirmUrl = 'Q09.php?id=' . $id . '&confirm=yes';
    echo '<p>Confirm deletion of student ID ' . htmlspecialchars((string)$id) . '?</p><a class="button" href="' . htmlspecialchars($confirmUrl) . '">Confirm Delete</a>';
} else {
    echo '<p>Provide a valid positive student ID in the URL, for example <code>?id=3</code>.</p>';
}
?>
</section><?php require 'includes/footer.php'; ?>