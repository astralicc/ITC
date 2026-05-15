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

  <title>Form Siswa</title>
</head>

<body>

  <div class="d-flex justify-content-center align-items-center min-vh-100">

    <div style="width: 500px;">

      <h1 class="mb-4">Form Siswa</h1>

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


        <!-- Nama Siswa -->
        <div class="mb-3">

          <label for="student_name" class="form-label">
            Nama Siswa
          </label>

          <input
            type="text"
            id="student_name"
            name="student_name"
            class="form-control <?= $name_error ? 'is-invalid' : '' ?>"
            placeholder="Nama Siswa"
            value="<?= htmlspecialchars($_POST['student_name'] ?? '') ?>">

          <?php if ($name_error) { ?>
            <div class="invalid-feedback d-block">
              <?= htmlspecialchars($name_error) ?>
            </div>
          <?php } ?>

        </div>

        <!-- NIS -->
        <div class="mb-3">

          <label for="student_nis" class="form-label">
            NIS Siswa
          </label>

          <input
            type="number"
            id="student_nis"
            name="student_nis"
            class="form-control <?= $nis_error ? 'is-invalid' : '' ?>"
            placeholder="NIS Siswa (5 digit)"
            value="<?= htmlspecialchars($_POST['student_nis'] ?? '') ?>">

          <?php if ($nis_error) { ?>
            <div class="invalid-feedback d-block">
              <?= htmlspecialchars($nis_error) ?>
            </div>
          <?php } ?>

        </div>

        <!-- NISN -->
        <div class="mb-3">

          <label for="student_nisn" class="form-label">
            NISN Siswa
          </label>

          <input
            type="number"
            id="student_nisn"
            name="student_nisn"
            class="form-control <?= $nisn_error ? 'is-invalid' : '' ?>"
            placeholder="NISN Siswa (10 digit)"
            value="<?= htmlspecialchars($_POST['student_nisn'] ?? '') ?>">

          <?php if ($nisn_error) { ?>
            <div class="invalid-feedback d-block">
              <?= htmlspecialchars($nisn_error) ?>
            </div>
          <?php } ?>

        </div>

        <!-- Kelas -->
        <div class="mb-3">

          <label for="student_class" class="form-label">
            Kelas
          </label>

          <select
            name="student_class"
            id="student_class"
            class="form-select <?= $class_error ? 'is-invalid' : '' ?>">

            <option value="">Pilih Kelas</option>

            <option value="X"
              <?= (($_POST['student_class'] ?? '') == 'X') ? 'selected' : '' ?>>
              X
            </option>

            <option value="XI"
              <?= (($_POST['student_class'] ?? '') == 'XI') ? 'selected' : '' ?>>
              XI
            </option>

            <option value="XII"
              <?= (($_POST['student_class'] ?? '') == 'XII') ? 'selected' : '' ?>>
              XII
            </option>

          </select>

          <?php if ($class_error) { ?>
            <div class="invalid-feedback d-block">
              <?= htmlspecialchars($class_error) ?>
            </div>
          <?php } ?>

        </div>

        <!-- Jurusan -->
        <div class="mb-3">

          <label for="student_major" class="form-label">
            Jurusan
          </label>

          <select
            name="student_major"
            id="student_major"
            class="form-select <?= $major_error ? 'is-invalid' : '' ?>">

            <option value="">Pilih Jurusan</option>

            <!-- AK -->
            <option value="AK"
              <?= (($_POST['student_major'] ?? '') == 'AK') ? 'selected' : '' ?>>
              Akuntansi
            </option>

            <option value="AK 1"
              <?= (($_POST['student_major'] ?? '') == 'AK 1') ? 'selected' : '' ?>>
              Akuntansi 1
            </option>

            <option value="AK 2"
              <?= (($_POST['student_major'] ?? '') == 'AK 2') ? 'selected' : '' ?>>
              Akuntansi 2
            </option>

            <!-- BR -->
            <option value="BR"
              <?= (($_POST['student_major'] ?? '') == 'BR') ? 'selected' : '' ?>>
              Bisnis Retail
            </option>

            <option value="BR 1"
              <?= (($_POST['student_major'] ?? '') == 'BR 1') ? 'selected' : '' ?>>
              Bisnis Retail 1
            </option>

            <option value="BR 2"
              <?= (($_POST['student_major'] ?? '') == 'BR 2') ? 'selected' : '' ?>>
              Bisnis Retail 2
            </option>

            <!-- MP -->
            <option value="MP"
              <?= (($_POST['student_major'] ?? '') == 'MP') ? 'selected' : '' ?>>
              Manajemen Perkantoran
            </option>

            <option value="MP 1"
              <?= (($_POST['student_major'] ?? '') == 'MP 1') ? 'selected' : '' ?>>
              Manajemen Perkantoran 1
            </option>

            <option value="MP 2"
              <?= (($_POST['student_major'] ?? '') == 'MP 2') ? 'selected' : '' ?>>
              Manajemen Perkantoran 2
            </option>

            <!-- RPL -->
            <option value="RPL"
              <?= (($_POST['student_major'] ?? '') == 'RPL') ? 'selected' : '' ?>>
              Rekayasa Perangkat Lunak
            </option>

            <option value="RPL 1"
              <?= (($_POST['student_major'] ?? '') == 'RPL 1') ? 'selected' : '' ?>>
              RPL 1
            </option>

            <option value="RPL 2"
              <?= (($_POST['student_major'] ?? '') == 'RPL 2') ? 'selected' : '' ?>>
              RPL 2
            </option>

          </select>

          <?php if ($major_error) { ?>
            <div class="invalid-feedback d-block">
              <?= htmlspecialchars($major_error) ?>
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