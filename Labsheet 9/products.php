<?php
// Tasks 8, 11, 12, 13: list products + pagination + search/filter + sorting
require_once 'config/db.php';
require_once 'includes/functions.php';
start_session();

// --- Inputs ---
$q        = trim($_GET['q'] ?? '');
$category = trim($_GET['category'] ?? '');
$min      = ($_GET['min'] ?? '') !== '' ? (float)$_GET['min'] : null;
$max      = ($_GET['max'] ?? '') !== '' ? (float)$_GET['max'] : null;

// Task 13: sorting (whitelist column names - never put user input directly in ORDER BY)
$sortable = ['id', 'name', 'category', 'price', 'stock'];
$sort  = in_array($_GET['sort'] ?? '', $sortable, true) ? $_GET['sort'] : 'id';
$order = (($_GET['order'] ?? 'asc') === 'desc') ? 'DESC' : 'ASC';

// Task 12: build WHERE with LIKE and BETWEEN
$where = []; $types = ''; $params = [];
if ($q !== '')        { $where[] = 'name LIKE ?';     $types .= 's'; $params[] = "%$q%"; }
if ($category !== '') { $where[] = 'category = ?';    $types .= 's'; $params[] = $category; }
if ($min !== null && $max !== null) { $where[] = 'price BETWEEN ? AND ?'; $types .= 'dd'; $params[] = $min; $params[] = $max; }
elseif ($min !== null) { $where[] = 'price >= ?'; $types .= 'd'; $params[] = $min; }
elseif ($max !== null) { $where[] = 'price <= ?'; $types .= 'd'; $params[] = $max; }
$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Task 11: pagination with LIMIT / OFFSET
$perPage = 5;
$page    = max(1, (int)($_GET['page'] ?? 1));

$stmt = $conn->prepare("SELECT COUNT(*) c FROM products $whereSql");
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$total = (int)$stmt->get_result()->fetch_assoc()['c'];
$pages = max(1, (int)ceil($total / $perPage));
$page  = min($page, $pages);
$offset = ($page - 1) * $perPage;

$stmt = $conn->prepare("SELECT * FROM products $whereSql ORDER BY $sort $order LIMIT ? OFFSET ?");
$t2 = $types . 'ii'; $p2 = array_merge($params, [$perPage, $offset]);
$stmt->bind_param($t2, ...$p2);
$stmt->execute();
$result = $stmt->get_result();

$cats = $conn->query('SELECT DISTINCT category FROM products ORDER BY category');

// helper to build URLs while keeping filters
function url_with(array $over): string {
    return 'products.php?' . http_build_query(array_merge($_GET, $over));
}
function sort_link(string $col, string $label, string $cur, string $ord): string {
    $next = ($cur === $col && $ord === 'ASC') ? 'desc' : 'asc';
    $arrow = $cur === $col ? ($ord === 'ASC' ? ' ▲' : ' ▼') : '';
    return '<a href="' . e(url_with(['sort' => $col, 'order' => $next, 'page' => 1])) . '">' . e($label) . $arrow . '</a>';
}

$pageTitle = 'Products';
include 'includes/header.php';
$loggedIn = !empty($_SESSION['user_id']);
?>
<h1>Products</h1>
<?php if (!empty($_GET['msg'])): ?><div class="success"><?= e($_GET['msg']) ?></div><?php endif; ?>

<form method="get" class="filters">
  <div class="search-wrap">
    <label>Search name</label>
    <input type="text" id="search-box" name="q" value="<?= e($q) ?>" autocomplete="off" placeholder="Type to search...">
    <div id="suggestions"></div>
  </div>
  <div><label>Category</label>
    <select name="category"><option value="">All</option>
      <?php while ($c = $cats->fetch_assoc()): ?>
        <option <?= $category === $c['category'] ? 'selected' : '' ?>><?= e($c['category']) ?></option>
      <?php endwhile; ?>
    </select></div>
  <div><label>Min price</label><input type="number" step="0.01" name="min" value="<?= $min !== null ? e($min) : '' ?>"></div>
  <div><label>Max price</label><input type="number" step="0.01" name="max" value="<?= $max !== null ? e($max) : '' ?>"></div>
  <div><button type="submit">Filter</button></div>
</form>

<table>
  <tr>
    <th>Image</th>
    <th><?= sort_link('id', 'ID', $sort, $order) ?></th>
    <th><?= sort_link('name', 'Name', $sort, $order) ?></th>
    <th><?= sort_link('category', 'Category', $sort, $order) ?></th>
    <th><?= sort_link('price', 'Price', $sort, $order) ?></th>
    <th><?= sort_link('stock', 'Stock', $sort, $order) ?></th>
    <th>Actions</th>
  </tr>
  <?php if ($total === 0): ?><tr><td colspan="7">No products found.</td></tr><?php endif; ?>
  <?php while ($p = $result->fetch_assoc()): ?>
  <tr>
    <td><?php if ($p['image']): ?><img class="thumb" src="uploads/<?= e($p['image']) ?>" alt=""><?php endif; ?></td>
    <td><?= (int)$p['id'] ?></td>
    <td><?= e($p['name']) ?></td>
    <td><?= e($p['category']) ?></td>
    <td>₹<?= number_format($p['price'], 2) ?></td>
    <td><?= (int)$p['stock'] ?></td>
    <td>
      <?php if ($loggedIn): ?>
        <form method="post" action="cart.php" style="display:inline">
          <input type="hidden" name="action" value="add"><input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
          <button>Add to cart</button>
        </form>
        <a class="btn btn-gray" href="product_edit.php?id=<?= (int)$p['id'] ?>">Edit</a>
        <form method="post" action="product_delete.php" class="delete-form" style="display:inline">
          <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <button class="btn-danger">Delete</button>
        </form>
      <?php else: ?><a href="login.php">Login to buy</a><?php endif; ?>
    </td>
  </tr>
  <?php endwhile; ?>
</table>

<div class="pagination">
  <?php if ($page > 1): ?><a href="<?= e(url_with(['page' => $page - 1])) ?>">&laquo; Previous</a><?php endif; ?>
  <?php for ($i = 1; $i <= $pages; $i++): ?>
    <?php if ($i === $page): ?><span class="current"><?= $i ?></span>
    <?php else: ?><a href="<?= e(url_with(['page' => $i])) ?>"><?= $i ?></a><?php endif; ?>
  <?php endfor; ?>
  <?php if ($page < $pages): ?><a href="<?= e(url_with(['page' => $page + 1])) ?>">Next &raquo;</a><?php endif; ?>
</div>
<p><?= $total ?> product(s) found.</p>
<?php include 'includes/footer.php'; ?>
