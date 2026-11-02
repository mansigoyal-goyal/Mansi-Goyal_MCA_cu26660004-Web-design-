<?php
$pageTitle = 'Q14 - Database User Privileges';
require 'includes/header.php';
?>
<section class="card"><h1>Question 14: Create a restricted MySQL user</h1>
<p>Run these commands as a MySQL administrator. Replace the password with a strong unique password and update <code>includes/config.php</code> to match.</p>
<pre>CREATE USER 'college_app'@'localhost'
IDENTIFIED BY 'ChangeThisPassword!';

GRANT SELECT, INSERT, UPDATE
ON college_db.*
TO 'college_app'@'localhost';

SHOW GRANTS FOR 'college_app'@'localhost';</pre>
<p>This user intentionally does not receive DELETE, DROP or database administration privileges. Run table creation using an administrator account if necessary.</p>
</section><?php require 'includes/footer.php'; ?>