<?php
require_once __DIR__ . '/../auth/auth-guard.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: index.php');
  exit;
}

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
  $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid product ID.'];
  header('Location: index.php');
  exit;
}

// Fetch the product name before deleting (for the flash message)
$stmt = $conn->prepare("SELECT name FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
  $_SESSION['flash'] = ['type' => 'error', 'message' => 'Product not found.'];
  header('Location: index.php');
  exit;
}

$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

// ── Placeholder (remove when using real DB) ──
$product = ['name' => 'Product #' . $id];

$_SESSION['flash'] = [
  'type'    => 'success',
  'message' => "Product \"{$product['name']}\" deleted successfully.",
];

header('Location: index.php');
exit;