<?php require 'form-validation.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  <link rel="stylesheet" href="../../style.css">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <title>Form Guru</title>
</head>

<body>

  <div class="d-flex justify-content-center align-items-center min-vh-100">

    <div style="width: 500px;">

      <h1 class="mb-4">Form Guru</h1>

      <!-- Database Error Message -->
      <?php if ($database_error_message) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($database_error_message) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php } ?>

      <!-- Success Message -->
      <?php if ($success_message) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($success_message) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php } ?>

      <form action="" method="post">


        <!-- Nama Guru -->
        <div class="mb-3">

          <label for="teacher_name" class="form-label">
            Nama Guru
          </label>

          <input
            type="text"
            id="teacher_name"
            name="teacher_name"
            class="form-control <?= $name_error ? 'is-invalid' : '' ?>"
            placeholder="Nama Guru"
            value="<?= htmlspecialchars($_POST['teacher_name'] ?? '') ?>">

          <?php if ($name_error) { ?>
            <div class="invalid-feedback d-block">
              <?= htmlspecialchars($name_error) ?>
            </div>
          <?php } ?>

        </div>

        <!-- NIP Guru -->
        <div class="mb-3">

          <label for="teacher_nip" class="form-label">
            NIP Guru
          </label>

          <input
            type="number"
            id="teacher_nip"
            name="teacher_nip"
            class="form-control <?= $nip_error ? 'is-invalid' : '' ?>"
            placeholder="NIP Guru (18 digit)"
            value="<?= htmlspecialchars($_POST['teacher_nip'] ?? '') ?>">

          <?php if ($nip_error) { ?>
            <div class="invalid-feedback d-block">
              <?= htmlspecialchars($nip_error) ?>
            </div>
          <?php } ?>

        </div>

        <!-- Mata Pelajaran -->
        <div class="mb-3">

          <label for="teacher_mapel" class="form-label">
            Mata Pelajaran Guru
          </label>

          <select
            name="teacher_mapel"
            id="teacher_mapel"
            class="form-select <?= $mapel_error ? 'is-invalid' : '' ?>">

            <option value="">Pilih Mata Pelajaran Guru</option>

            <option value="ak"
              <?= (($_POST['teacher_mapel'] ?? '') === 'ak') ? 'selected' : '' ?>>
              Akuntansi
            </option>

            <option value="br"
              <?= (($_POST['teacher_mapel'] ?? '') === 'br') ? 'selected' : '' ?>>
              Bisnis Retail
            </option>

            <option value="mp"
              <?= (($_POST['teacher_mapel'] ?? '') === 'mp') ? 'selected' : '' ?>>
              Manajemen Perkantoran
            </option>

            <option value="rpl"
              <?= (($_POST['teacher_mapel'] ?? '') === 'rpl') ? 'selected' : '' ?>>
              Rekayasa Perangkat Lunak
            </option>

            <option value="umum"
              <?= (($_POST['teacher_mapel'] ?? '') === 'umum') ? 'selected' : '' ?>>
              Umum
            </option>

          </select>

          <?php if ($mapel_error) { ?>
            <div class="invalid-feedback d-block">
              <?= htmlspecialchars($mapel_error) ?>
            </div>
          <?php } ?>

        </div>

        <button type="submit" class="btn btn-primary mt-2 w-100">
          Submit
        </button>

      </form>

      <!-- Back Button -->
      <div class="mb-3 mt-5 d-flex justify-content-center">

        <a href="../../index.php" class="btn btn-secondary">
          ← Kembali Ke Halaman Utama
        </a>

      </div>

    </div>

  </div>

</body>

</html>