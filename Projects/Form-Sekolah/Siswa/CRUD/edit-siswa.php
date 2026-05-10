<?php
require_once __DIR__ . '/database.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

/* GET DATA SISWA */
$stmt = mysqli_prepare($conn, "
  SELECT * FROM siswa
  WHERE student_id = ?
");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

$success = false;
$error   = false;

$nis_error  = null;
$nisn_error = null;

/* UPDATE DATA */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $student_name  = trim($_POST['student_name'] ?? '');
  $student_nis   = trim($_POST['student_nis'] ?? '');
  $student_nisn  = trim($_POST['student_nisn'] ?? '');
  $student_class = trim($_POST['student_class'] ?? '');
  $student_major = trim($_POST['student_major'] ?? '');

  /* VALIDASI NIS (5 digit) */
  if ($student_nis === '') {
    $nis_error = 'Isi NIS siswa.';
  } elseif (!ctype_digit($student_nis)) {
    $nis_error = 'NIS hanya boleh angka.';
  } elseif (strlen($student_nis) !== 5) {
    $nis_error = 'NIS harus 5 digit.';
  }

  /* VALIDASI NISN (10 digit) */
  if ($student_nisn === '') {
    $nisn_error = 'Isi NISN siswa.';
  } elseif (!ctype_digit($student_nisn)) {
    $nisn_error = 'NISN hanya boleh angka.';
  } elseif (strlen($student_nisn) !== 10) {
    $nisn_error = 'NISN harus 10 digit.';
  }

  if (!$nis_error && !$nisn_error) {

    $stmt = mysqli_prepare($conn, "
      UPDATE siswa SET
        student_name  = ?,
        student_nis   = ?,
        student_nisn  = ?,
        student_class = ?,
        student_major = ?
      WHERE student_id = ?
    ");

    mysqli_stmt_bind_param(
      $stmt,
      "sssssi",
      $student_name,
      $student_nis,
      $student_nisn,
      $student_class,
      $student_major,
      $id
    );

    $update = mysqli_stmt_execute($stmt);

    if ($update) {

      $success = true;

      $data['student_name']  = $student_name;
      $data['student_nis']   = $student_nis;
      $data['student_nisn']  = $student_nisn;
      $data['student_class'] = $student_class;
      $data['student_major'] = $student_major;

      header("refresh:2;url=crud-siswa.php");

    } else {
      $error = true;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Edit Siswa</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../style.css">
</head>

<body>

<div class="d-flex justify-content-center py-5">

  <div style="width: 500px;">

    <h1 class="text-center mb-4">Edit Data Siswa</h1>

    <?php if ($success) : ?>
      <div class="alert alert-success alert-dismissible fade show">
        Data berhasil diupdate!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?php if ($error) : ?>
      <div class="alert alert-danger alert-dismissible fade show">
        Data gagal diupdate!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <form method="POST">

      <!-- Nama -->
      <div class="mb-3">
        <label class="form-label">Nama Siswa</label>
        <input type="text" name="student_name" class="form-control"
          value="<?= htmlspecialchars($data['student_name']); ?>" required>
      </div>

      <!-- NIS -->
      <div class="mb-3">
        <label class="form-label">NIS</label>
        <input type="text" name="student_nis" maxlength="5"
          class="form-control <?= $nis_error ? 'is-invalid' : ''; ?>"
          value="<?= htmlspecialchars($data['student_nis']); ?>" required>

        <?php if ($nis_error): ?>
          <div class="invalid-feedback"><?= $nis_error; ?></div>
        <?php endif; ?>
      </div>

      <!-- NISN -->
      <div class="mb-3">
        <label class="form-label">NISN</label>
        <input type="text" name="student_nisn" maxlength="10"
          class="form-control <?= $nisn_error ? 'is-invalid' : ''; ?>"
          value="<?= htmlspecialchars($data['student_nisn']); ?>" required>

        <?php if ($nisn_error): ?>
          <div class="invalid-feedback"><?= $nisn_error; ?></div>
        <?php endif; ?>
      </div>

      <!-- Kelas -->
      <div class="mb-3">
        <label class="form-label">Kelas</label>
        <select name="student_class" class="form-select" required>
          <option value="">Pilih Kelas</option>
          <option value="X"  <?= $data['student_class'] == 'X' ? 'selected' : ''; ?>>X</option>
          <option value="XI" <?= $data['student_class'] == 'XI' ? 'selected' : ''; ?>>XI</option>
          <option value="XII" <?= $data['student_class'] == 'XII' ? 'selected' : ''; ?>>XII</option>
        </select>
      </div>

      <!-- Jurusan -->
      <div class="mb-3">
        <label class="form-label">Jurusan</label>
        <select name="student_major" class="form-select" required>
          <option value="">Pilih Jurusan</option>
          <option value="AK" <?= $data['student_major'] == 'AK' ? 'selected' : ''; ?>>Akuntansi</option>
          <option value="BR" <?= $data['student_major'] == 'BR' ? 'selected' : ''; ?>>Bisnis Retail</option>
          <option value="MP" <?= $data['student_major'] == 'MP' ? 'selected' : ''; ?>>Manajemen Perkantoran</option>
          <option value="RPL" <?= $data['student_major'] == 'RPL' ? 'selected' : ''; ?>>RPL</option>
          <option value="UMUM" <?= $data['student_major'] == 'UMUM' ? 'selected' : ''; ?>>Umum</option>
        </select>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Update Data</button>
      </div>

    </form>

    <div class="d-flex justify-content-center mt-4">
      <a href="crud-siswa.php" class="btn btn-secondary">
        ← Kembali
      </a>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>