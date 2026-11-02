<?php
// Q3: Create college_db using MySQL command line or phpMyAdmin.
$pageTitle = 'Q3 - Create Database';
require 'includes/header.php';
?>
<section class="card">
<h1>Question 3: Create college_db database</h1>
<p>Run the following SQL in MySQL Workbench, phpMyAdmin, or the MySQL command line:</p>
<pre>CREATE DATABASE college_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

SHOW DATABASES;</pre>
<p>Command line example: <code>mysql -u root -p</code>, then paste the SQL statements.</p>
</section>
<?php require 'includes/footer.php'; ?>