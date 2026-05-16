<?php
require_once __DIR__ . '/../auth/auth-guard.php';

$errors = [];
$old    = [];

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
    $stmt = $conn->prepare("INSERT INTO products (name, sku, price, stock) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $sku, (float)$price, (int)$stock]);
    
    $_SESSION['flash'] = ['type' => 'success', 'message' => "Product \"$name\" created successfully."];
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
  <title>Add Product</title>
</head>

<body>
  <div class="app-container narrow">

    <nav class="breadcrumb">
      <a href="index.php">Products</a>
      <span class="breadcrumb-sep">›</span>
      <span>Add Product</span>
    </nav>

    <div class="page-header">
      <div class="page-header-left">
        <h1>Add Product</h1>
        <p>Fill in the details to create a new product</p>
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

      <form method="POST" action="create.php" novalidate>

        <!-- Name (full width) -->
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
            <div class="input-group <?= isset($errors['price']) ? 'is-invalid' : '' ?>">
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
            <label for="stock">Initial Stock <span class="required">*</span></label>
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
          <button type="submit" class="btn btn-primary">&#43; Create Product</button>
        </div>

      </form>
    </div>

  </div>
</body>

</html>