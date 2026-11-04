<?php
// Task 9: Edit form pre-filled with existing data + UPDATE query
require_once 'config/db.php';
require_once 'includes/functions.php';
require_login();

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$stmt = $conn->prepare('SELECT * FROM products WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
if (!$product) { header('Location: products.php'); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? ''); $category = trim($_POST['category'] ?? '');
    $price = $_POST['price'] ?? ''; $stock = $_POST['stock'] ?? '';

    if ($name === '')                      $errors[] = 'Name is required.';
    if ($category === '')                  $errors[] = 'Category is required.';
    if (!is_numeric($price) || $price < 0) $errors[] = 'Invalid price.';
    if (!ctype_digit((string)$stock))      $errors[] = 'Invalid stock.';

    $imgErr = null;
    $newImage = upload_product_image($_FILES['image'] ?? ['error' => UPLOAD_ERR_NO_FILE], $imgErr);
    if ($imgErr) $errors[] = $imgErr;

    if (!$errors) {
        $image = $newImage ?? $product['image'];
        $stmt = $conn->prepare('UPDATE products SET name=?, category=?, price=?, stock=?, image=? WHERE id=?');
        $p = (float)$price; $s = (int)$stock;
        $stmt->bind_param('ssdisi', $name, $category, $p, $s, $image, $id);
        $stmt->execute();
        if ($newImage && $product['image'] && is_file("uploads/{$product['image']}")) unlink("uploads/{$product['image']}");
        header('Location: products.php?msg=' . urlencode('Product updated.'));
        exit;
    }
    $product = array_merge($product, ['name' => $name, 'category' => $category, 'price' => $price, 'stock' => $stock]);
}
$pageTitle = 'Edit Product';
include 'includes/header.php';
?>
<h1>Edit Product #<?= (int)$id ?></h1>
<?php foreach ($errors as $er): ?><div class="error"><?= e($er) ?></div><?php endforeach; ?>
<form method="post" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= (int)$id ?>">
  <label>Name</label><input type="text" name="name" value="<?= e($product['name']) ?>" required>
  <label>Category</label><input type="text" name="category" value="<?= e($product['category']) ?>" required>
  <label>Price</label><input type="number" step="0.01" name="price" value="<?= e($product['price']) ?>" required>
  <label>Stock</label><input type="number" name="stock" value="<?= e($product['stock']) ?>" required>
  <label>Image</label>
  <?php if ($product['image']): ?><img class="thumb" src="uploads/<?= e($product['image']) ?>" alt=""><?php endif; ?>
  <input type="file" name="image" accept="image/*">
  <br><br><button type="submit">Update</button> <a class="btn btn-gray" href="products.php">Cancel</a>
</form>
<?php include 'includes/footer.php'; ?>
