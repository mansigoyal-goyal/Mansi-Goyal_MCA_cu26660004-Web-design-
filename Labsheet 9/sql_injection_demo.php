<?php
// Task 15: SQL injection - vulnerable vs. secure (EDUCATIONAL DEMO ONLY)
require_once 'config/db.php';
require_once 'includes/functions.php';
start_session();

$name = $_GET['name'] ?? '';
$vulnRows = $safeRows = []; $vulnSql = ''; $vulnErr = '';

if ($name !== '') {
    // ❌ VULNERABLE: user input concatenated straight into SQL
    $vulnSql = "SELECT id, name, price FROM products WHERE name = '$name'";
    try { $vulnRows = $conn->query($vulnSql)->fetch_all(MYSQLI_ASSOC); }
    catch (mysqli_sql_exception $ex) { $vulnErr = $ex->getMessage(); }

    // ✅ SECURE: prepared statement - input is treated purely as data
    $stmt = $conn->prepare('SELECT id, name, price FROM products WHERE name = ?');
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $safeRows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
$pageTitle = 'SQL Injection Demo';
include 'includes/header.php';

function render_rows(array $rows) {
    if (!$rows) { echo '<p>No rows.</p>'; return; }
    echo '<table><tr><th>ID</th><th>Name</th><th>Price</th></tr>';
    foreach ($rows as $r) echo '<tr><td>' . e($r['id']) . '</td><td>' . e($r['name']) . '</td><td>' . e($r['price']) . '</td></tr>';
    echo '</table>';
}
?>
<h1>SQL Injection Demo</h1>
<p>Try: <code>Mouse</code> (normal) then <code>' OR '1'='1</code> (attack).</p>
<form method="get"><input type="text" name="name" value="<?= e($name) ?>"><br><br><button>Search</button></form>
<?php if ($name !== ''): ?>
<div class="cols">
  <div>
    <h2 style="color:#dc2626">❌ Vulnerable</h2>
    <pre><?= e($vulnSql) ?></pre>
    <?php if ($vulnErr): ?><div class="error"><?= e($vulnErr) ?></div><?php endif; ?>
    <?php render_rows($vulnRows); ?>
  </div>
  <div>
    <h2 style="color:#16a34a">✅ Prepared statement</h2>
    <pre>SELECT id, name, price FROM products WHERE name = ?</pre>
    <?php render_rows($safeRows); ?>
  </div>
</div>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
