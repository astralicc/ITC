<?php
require_once __DIR__ . '/database.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {

  $stmt = mysqli_prepare($conn, "
    DELETE FROM guru
    WHERE teacher_id = ?
  ");

  if (!$stmt) {
    header("Location: crud-guru.php?error=prepare");
    exit;
  }

  mysqli_stmt_bind_param($stmt, "i", $id);
  $delete = mysqli_stmt_execute($stmt);

  $affected = mysqli_stmt_affected_rows($stmt);

  mysqli_stmt_close($stmt);

  if ($delete && $affected > 0) {
    header("Location: crud-guru.php?success=delete");
    exit;
  } else {
    header("Location: crud-guru.php?error=delete");
    exit;
  }
} else {
  header("Location: crud-guru.php?error=invalid");
  exit;
}
