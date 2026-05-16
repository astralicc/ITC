<?php
require_once __DIR__ . '/../auth/auth-guard.php';

/* ── Queries ── */
$stmt = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("SELECT COUNT(*) FROM products");
$total = $stmt->fetchColumn();

$stmt = $conn->query("SELECT COUNT(*) FROM products WHERE stock = 0");
$out_of_stock = $stmt->fetchColumn();

$stmt = $conn->query("SELECT COUNT(*) FROM products WHERE stock > 0 AND stock <= 5");
$low_stock = $stmt->fetchColumn();

/* FIX: prevent NULL from SUM() */
$stmt = $conn->query("SELECT COALESCE(SUM(price * stock), 0) FROM products");
$inventory_value = $stmt->fetchColumn();


/* ── Helper ── */
function stockBadge(int $stock): string
{
  if ($stock === 0) return '<span class="stock-badge out-of-stock">Out of Stock</span>';
  if ($stock <= 5)  return '<span class="stock-badge low-stock">Low: ' . $stock . '</span>';
  return '<span class="stock-badge in-stock">' . $stock . ' in stock</span>';
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Products</title>
</head>

<body>
  <div class="app-container">

    <div class="page-header">
      <div class="page-header-left">
        <h1>Products Dashboard</h1>
        <p>Manage your product inventory</p>
      </div>
      <div class="page-header-actions">
        <a href="../auth/logout.php" class="logout-btn">&#x2192; Logout</a>
      </div>
    </div>

    <?php if ($flash): ?>
      <div class="alert <?= $flash['type'] ?>">
        <span class="alert-icon"><?= $flash['type'] === 'success' ? '✓' : '!' ?></span>
        <?= htmlspecialchars($flash['message']) ?>
      </div>
    <?php endif; ?>

    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div>
          <h3>Total Products</h3>
          <p><?= $total ?></p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon warning">⚠️</div>
        <div>
          <h3>Low Stock</h3>
          <p><?= $low_stock ?></p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon danger">🚫</div>
        <div>
          <h3>Out of Stock</h3>
          <p><?= $out_of_stock ?></p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon success">💰</div>
        <div>
          <h3>Inventory Value</h3>
          <p>$<?= number_format($inventory_value ?? 0, 0) ?></p>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="table-toolbar">
        <div class="search-box">
          <span class="search-icon">🔍</span>
          <input type="text" id="searchInput" placeholder="Search by name or SKU…">
        </div>
        <a href="create.php" class="btn btn-primary">&#43; Add Product</a>
      </div>

      <table class="product-table" id="productTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>SKU</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Added</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($products as $p): ?>
            <tr>
              <td class="product-id"><?= $p['id'] ?></td>

              <td class="product-name">
                <?= htmlspecialchars($p['name']) ?>
              </td>

              <td>
                <span class="product-sku">
                  <?= htmlspecialchars($p['sku']) ?>
                </span>
              </td>

              <td class="product-price">
                $<?= number_format($p['price'] ?? 0, 2) ?>
              </td>

              <td>
                <?= stockBadge((int)($p['stock'] ?? 0)) ?>
              </td>

              <td>
                <?= htmlspecialchars($p['created_at']) ?>
              </td>

              <td>
                <div class="row-actions">
                  <a href="edit.php?id=<?= $p['id'] ?>" class="btn-icon edit" title="Edit">✏️</a>

                  <button
                    class="btn-icon delete"
                    title="Delete"
                    onclick="openDeleteModal(
                      <?= $p['id'] ?>,
                      '<?= htmlspecialchars(addslashes($p['name'])) ?>'
                    )">
                    🗑️
                  </button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="pagination">
        <a href="#" class="page-btn disabled">&#8592;</a>
        <a href="#" class="page-btn active">1</a>
        <a href="#" class="page-btn">2</a>
        <a href="#" class="page-btn">&#8594;</a>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="modal-overlay" id="deleteModal">
    <div class="modal">
      <div class="modal-icon">🗑️</div>
      <h3>Delete Product</h3>
      <p>Are you sure you want to delete <span class="product-highlight" id="modalProductName"></span>?</p>
      <p>This action cannot be undone.</p>

      <div class="modal-actions">
        <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>

        <form id="deleteForm" method="POST" action="delete.php" style="flex:1;display:flex;">
          <input type="hidden" name="id" id="modalProductId">
          <button type="submit" class="btn btn-danger" style="flex:1;justify-content:center;">
            Delete
          </button>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('searchInput').addEventListener('input', function () {
      const q = this.value.toLowerCase();

      document.querySelectorAll('#productTable tbody tr').forEach(row => {
        const name = row.cells[1].textContent.toLowerCase();
        const sku = row.cells[2].textContent.toLowerCase();

        row.style.display = (name.includes(q) || sku.includes(q)) ? '' : 'none';
      });
    });

    function openDeleteModal(id, name) {
      document.getElementById('modalProductId').value = id;
      document.getElementById('modalProductName').textContent = name;
      document.getElementById('deleteModal').classList.add('open');
    }

    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.remove('open');
    }

    document.getElementById('deleteModal').addEventListener('click', function (e) {
      if (e.target === this) closeDeleteModal();
    });
  </script>
</body>
</html>