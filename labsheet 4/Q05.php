<?php
$pageTitle = 'Q5 - Create Students Table';
require 'includes/header.php';
?>
<section class="card">
<h1>Question 5: Create students table using PHP</h1>
<?php
try {
    require_once 'includes/db.php';
    $sql = "CREATE TABLE IF NOT EXISTS students (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        enrollment_date DATE NOT NULL
    ) ENGINE=InnoDB";
    getPDO()->exec($sql);
    echo '<div class="notice">students table created or already exists.</div>';
} catch (PDOException $e) {
    echo '<div class="error">Could not create table. Check database connection and privileges.</div>';
}
?>
</section>
<?php require 'includes/footer.php'; ?>