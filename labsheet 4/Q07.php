<?php
$pageTitle = 'Q7 - Display Students';
require 'includes/header.php';
?>
<section class="card"><h1>Question 7: Display all student records</h1>
<?php
try {
    require_once 'includes/db.php';
    $students = getPDO()->query('SELECT id, name, email, enrollment_date FROM students ORDER BY id')->fetchAll();
    if ($students) {
        echo '<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Enrollment Date</th></tr>';
        foreach ($students as $student) {
            echo '<tr>';
            foreach ($student as $value) echo '<td>' . htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8') . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else echo '<p>No student records found.</p>';
} catch (PDOException $e) { echo '<div class="error">Could not retrieve records. Run Q5 first.</div>'; }
?>
</section><?php require 'includes/footer.php'; ?>