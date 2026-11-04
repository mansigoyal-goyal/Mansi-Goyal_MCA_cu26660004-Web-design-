<?php
// Task 7 + 14: Insert product with prepared statement and image upload
require_once 'config/db.php';
require_once 'includes/functions.php';
require_login();

$errors = []; $name = $category = ''; $price = $stock = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? ''); $category = trim($_POST['category'] ?? '');
    $price = $_POST['price'] ?? ''; $stock = $_POST['stock'] ?? '';

    if ($name === '' || strlen($name) > 100) $errors[] = 'Name is required (max 100 chars).';
    if ($category === '')                    $errors[] = 'Category is required.';
    if (!is_numeric($price) || $price < 0)   $errors[] = 'Price must be a positive number.';
    if (!ctype_digit((string)$stock))        $errors[] = 'Stock must be a whole number.';

    $imgErr = null;
    $image = upload_product_image($_FILES['image'] ?? ['error' => UPLOAD_ERR_NO_FILE], $imgErr);
    if ($imgErr) $errors[] = $imgErr;

    if (!$errors) {
        $stmt = $conn->prepare('INSERT INTO products (name, category, price, stock, image) VALUES (?, ?, ?, ?, ?)');
        $p = (float)$price; $s = (int)$stock;
        $stmt->bind_param('ssdis', $name, $category, $p, $s, $image);
        $stmt->execute();
        header('Location: products.php?msg=' . urlencode('Product added.'));
        exit;
    }
}
$pageTitle = 'Add Product';
include 'includes/header.php';
?>
<h1>Add Product</h1>
<?php foreach ($errors as $er): ?><div class="error"><?= e($er) ?></div><?php endforeach; ?>
<form method="post" enctype="multipart/form-data">
  <label>Name</label><input type="text" name="name" value="<?= e($name) ?>" required>
  <label>Category</label><input type="text" name="category" value="<?= e($category) ?>" required>
  <label>Price</label><input type="number" step="0.01" name="price" value="<?= e($price) ?>" required>
  <label>Stock</label><input type="number" name="stock" value="<?= e($stock) ?>" required>
  <label>Image (JPG/PNG/GIF/WEBP, max 2MB)</label><input type="file" name="image" accept="image/*">
  <br><br><button type="submit">Save</button> <a class="btn btn-gray" href="products.php">Cancel</a>
</form>
<?php include 'includes/footer.php'; ?>
