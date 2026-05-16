<?php
require_once __DIR__ . '/../auth/auth-guard.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
  header('Location: index.php');
  exit;
}

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$product) {
  header('Location: index.php');
  exit;
}

// ── Placeholder product ──
// $product = ['id' => $id, 'name' => 'Wireless Headphones', 'sku' => 'WH-1001', 'price' => 89.99, 'stock' => 34];

$errors = [];
$old    = $product; // pre-fill form

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $old = $_POST;

  $name  = trim($_POST['name']  ?? '');
  $sku   = trim($_POST['sku']   ?? '');
  $price = trim($_POST['price'] ?? '');
  $stock = trim($_POST['stock'] ?? '');

  if ($name  === '') $errors['name']  = 'Product name is required.';
  if ($sku   === '') $errors['sku']   = 'SKU is required.';
  if ($price === '' || !is_numeric($price) || $price < 0)
    $errors['price'] = 'Enter a valid price (e.g. 9.99).';
  if ($stock === '' || !ctype_digit($stock))
    $errors['stock'] = 'Stock must be a whole number.';

  if (empty($errors)) {
    $stmt = $conn->prepare("UPDATE products SET name=?, sku=?, price=?, stock=? WHERE id=?");
    $stmt->execute([$name, $sku, $price, $stock, $id]);
    
    $_SESSION['flash'] = ['type' => 'success', 'message' => "Product \"$name\" updated successfully."];
    header('Location: index.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Edit Product</title>
</head>

<body>
  <div class="app-container narrow">

    <nav class="breadcrumb">
      <a href="index.php">Products</a>
      <span class="breadcrumb-sep">›</span>
      <span>Edit Product</span>
    </nav>

    <div class="page-header">
      <div class="page-header-left">
        <h1>Edit Product</h1>
        <p>Update the details for <strong><?= htmlspecialchars($product['name']) ?></strong></p>
      </div>
    </div>

    <?php if (!empty($errors)): ?>
      <div class="alert error">
        <span class="alert-icon">!</span>
        Please fix the errors below before saving.
      </div>
    <?php endif; ?>

    <div class="form-card">
      <p class="form-section-title">Product Details</p>

      <form method="POST" action="edit.php?id=<?= $id ?>" novalidate>

        <!-- Name -->
        <div class="form-grid single" style="margin-bottom:18px;">
          <div class="form-group">
            <label for="name">Product Name <span class="required">*</span></label>
            <input
              type="text" id="name" name="name"
              class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
              placeholder="e.g. Wireless Headphones"
              value="<?= htmlspecialchars($old['name'] ?? '') ?>">
            <?php if (isset($errors['name'])): ?>
              <span class="invalid-feedback"><?= $errors['name'] ?></span>
            <?php endif; ?>
          </div>
        </div>

        <!-- SKU + Price -->
        <div class="form-grid">
          <div class="form-group">
            <label for="sku">SKU <span class="required">*</span></label>
            <input
              type="text" id="sku" name="sku"
              class="form-control <?= isset($errors['sku']) ? 'is-invalid' : '' ?>"
              placeholder="e.g. WH-1001"
              value="<?= htmlspecialchars($old['sku'] ?? '') ?>">
            <span class="form-hint">Must be unique across all products.</span>
            <?php if (isset($errors['sku'])): ?>
              <span class="invalid-feedback"><?= $errors['sku'] ?></span>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="price">Price <span class="required">*</span></label>
            <div class="input-group">
              <span class="input-addon">$</span>
              <input
                type="number" id="price" name="price"
                class="form-control"
                placeholder="0.00" min="0" step="0.01"
                value="<?= htmlspecialchars($old['price'] ?? '') ?>">
            </div>
            <?php if (isset($errors['price'])): ?>
              <span class="invalid-feedback"><?= $errors['price'] ?></span>
            <?php endif; ?>
          </div>
        </div>

        <!-- Stock -->
        <div class="form-grid" style="margin-bottom:0;">
          <div class="form-group">
            <label for="stock">Stock <span class="required">*</span></label>
            <input
              type="number" id="stock" name="stock"
              class="form-control <?= isset($errors['stock']) ? 'is-invalid' : '' ?>"
              placeholder="0" min="0" step="1"
              value="<?= htmlspecialchars($old['stock'] ?? '') ?>">
            <?php if (isset($errors['stock'])): ?>
              <span class="invalid-feedback"><?= $errors['stock'] ?></span>
            <?php endif; ?>
          </div>
        </div>

        <div class="form-actions">
          <a href="index.php" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success">&#10003; Save Changes</button>
        </div>

      </form>
    </div>

  </div>
</body>

</html>