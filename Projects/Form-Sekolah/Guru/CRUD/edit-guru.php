<?php
require_once __DIR__ . '/database.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = mysqli_prepare($conn, "
  SELECT * FROM guru
  WHERE teacher_id = ?
");

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$data = mysqli_fetch_assoc($result);

$success = false;
$error   = false;

$nip_error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $teacher_name  = trim($_POST['teacher_name'] ?? '');
  $teacher_nip   = trim($_POST['teacher_nip'] ?? '');
  $teacher_mapel = trim($_POST['teacher_mapel'] ?? '');

  if ($teacher_nip === '') {

    $nip_error = 'Isi NIP guru.';
  } elseif (!ctype_digit($teacher_nip)) {

    $nip_error = 'Kolom ini hanya menerima karakter angka.';
  } elseif (strlen($teacher_nip) !== 18) {

    $nip_error = 'NIP harus terdiri dari 18 digit.';
  }

  if (!$nip_error) {

    $stmt = mysqli_prepare($conn, "
      UPDATE guru SET
        teacher_name = ?,
        teacher_nip = ?,
        teacher_mapel = ?
      WHERE teacher_id = ?
    ");

    mysqli_stmt_bind_param(
      $stmt,
      "sssi",
      $teacher_name,
      $teacher_nip,
      $teacher_mapel,
      $id
    );

    $update = mysqli_stmt_execute($stmt);

    if ($update) {

      $success = true;

      // Update displayed data
      $data['teacher_name']   = $teacher_name;
      $data['teacher_nip']    = $teacher_nip;
      $data['teacher_mapel']  = $teacher_mapel;

      header("refresh:2;url=crud-guru.php");
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

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

  <title>Edit Guru</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">

  <link rel="stylesheet" href="../../style.css">

</head>

<body>

  <div class="d-flex justify-content-center align-items-center min-vh-100">

    <div style="width: 500px;">

      <!-- Title -->
      <h1 class="text-center mb-4">
        Edit Data Guru
      </h1>


      <!-- Success Alert -->
      <?php if ($success) : ?>

        <div
          class="alert alert-success alert-dismissible fade show"
          role="alert">

          Data berhasil diupdate!

          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
          </button>

        </div>

      <?php endif; ?>


      <!-- Error Alert -->
      <?php if ($error) : ?>

        <div
          class="alert alert-danger alert-dismissible fade show"
          role="alert">

          Data gagal diupdate!

          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
          </button>

        </div>

      <?php endif; ?>


      <!-- Form -->
      <form action="" method="POST">

        <!-- Nama Guru -->
        <div class="mb-3">

          <label class="form-label">
            Nama Guru
          </label>

          <input
            type="text"
            name="teacher_name"
            class="form-control"
            value="<?= htmlspecialchars($data['teacher_name']); ?>"
            required>

        </div>


        <!-- NIP Guru -->
        <div class="mb-3">

          <label class="form-label">
            NIP Guru
          </label>

          <input
            type="text"
            inputmode="numeric"
            maxlength="18"
            name="teacher_nip"
            class="form-control <?= $nip_error ? 'is-invalid' : ''; ?>"
            value="<?= htmlspecialchars($data['teacher_nip']); ?>"
            required>

          <?php if ($nip_error) : ?>

            <div class="invalid-feedback">

              <?= htmlspecialchars($nip_error); ?>

            </div>

          <?php endif; ?>

        </div>


        <!-- Mata Pelajaran -->
        <div class="mb-3">

          <label class="form-label">
            Mata Pelajaran
          </label>

          <select
            name="teacher_mapel"
            class="form-select"
            required>

            <option value="">
              Pilih Mata Pelajaran
            </option>

            <option
              value="ak"
              <?= $data['teacher_mapel'] == 'ak' ? 'selected' : ''; ?>>

              Akuntansi

            </option>

            <option
              value="br"
              <?= $data['teacher_mapel'] == 'br' ? 'selected' : ''; ?>>

              Bisnis Retail

            </option>

            <option
              value="mp"
              <?= $data['teacher_mapel'] == 'mp' ? 'selected' : ''; ?>>

              Manajemen Perkantoran

            </option>

            <option
              value="rpl"
              <?= $data['teacher_mapel'] == 'rpl' ? 'selected' : ''; ?>>

              Rekayasa Perangkat Lunak

            </option>

            <option
              value="umum"
              <?= $data['teacher_mapel'] == 'umum' ? 'selected' : ''; ?>>

              Umum

            </option>

          </select>

        </div>


        <!-- Submit Button -->
        <div class="d-grid">

          <button
            type="submit"
            class="btn btn-primary">

            Update Data

          </button>

        </div>

      </form>


      <!-- Back Button -->
      <div class="d-flex justify-content-center mt-4">

        <a
          href="crud-guru.php"
          class="btn btn-secondary">

          ← Kembali Ke Halaman CRUD

        </a>

      </div>

    </div>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>