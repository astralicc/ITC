<?php require 'form-validation.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">

  <title>Form Siswa</title>
</head>

<body class="bg-light">

  <div class="d-flex justify-content-center align-items-center min-vh-100">

    <div style="width: 500px;">

      <h1 class="mb-4">Form Siswa</h1>

      <form action="" method="post">

        <!-- Database Error Message -->
        <?php if ($database_error_message) { ?>
          <div class="alert alert-danger mt-3">
            <?php echo htmlspecialchars($database_error_message) ?>
          </div>
        <?php } ?>

        <!-- Success Message -->
        <?php if ($success_message) { ?>
          <div class="alert alert-success mt-3">
            <?php echo htmlspecialchars($success_message) ?>
          </div>
        <?php } ?>

        <!-- Nama Siswa -->
        <div class="mb-3">
          <label for="student_name" class="form-label">Nama Siswa</label>
          <input
            type="text"
            id="student_name"
            name="student_name"
            class="form-control <?php echo $name_error ? 'is-invalid' : '' ?>"
            placeholder="Nama Siswa"
            value="<?php echo htmlspecialchars($_POST['student_name'] ?? '') ?>">
          <?php if ($name_error) { ?>
            <div class="invalid-feedback d-block"><?php echo htmlspecialchars($name_error) ?></div>
          <?php } ?>
        </div>

        <!-- NIS Siswa -->
        <div class="mb-3">
          <label for="student_nis" class="form-label">NIS Siswa</label>
          <input
            type="number"
            id="student_nis"
            name="student_nis"
            class="form-control <?php echo $nis_error ? 'is-invalid' : '' ?>"
            placeholder="NIS Siswa (5 digit)"
            value="<?php echo htmlspecialchars($_POST['student_nis'] ?? '') ?>">
          <?php if ($nis_error) { ?>
            <div class="invalid-feedback d-block"><?php echo htmlspecialchars($nis_error) ?></div>
          <?php } ?>
        </div>

        <!-- NISN Siswa -->
        <div class="mb-3">
          <label for="student_nisn" class="form-label">NISN Siswa</label>
          <input
            type="number"
            id="student_nisn"
            name="student_nisn"
            class="form-control <?php echo $nisn_error ? 'is-invalid' : '' ?>"
            placeholder="NISN Siswa (10 digit)"
            value="<?php echo htmlspecialchars($_POST['student_nisn'] ?? '') ?>">
          <?php if ($nisn_error) { ?>
            <div class="invalid-feedback d-block"><?php echo htmlspecialchars($nisn_error) ?></div>
          <?php } ?>
        </div>

        <!-- Kelas Siswa  -->
        <div class="mb-3">
          <label for="student_class" class="form-label">Kelas</label>
          <select
            name="student_class"
            id="student_class"
            class="form-select <?php echo $class_error ? 'is-invalid' : '' ?>">
            <option value="">Pilih Kelas</option>
            <option value="X" <?php if (($_POST['student_class'] ?? '') == 'X')   echo 'selected'; ?>>X</option>
            <option value="XI" <?php if (($_POST['student_class'] ?? '') == 'XI')  echo 'selected'; ?>>XI</option>
            <option value="XII" <?php if (($_POST['student_class'] ?? '') == 'XII') echo 'selected'; ?>>XII</option>
          </select>
          <?php if ($class_error) { ?>
            <div class="invalid-feedback d-block"><?php echo htmlspecialchars($class_error) ?></div>
          <?php } ?>
        </div>

        <!-- Jurusan Siswa  -->
        <div class="mb-3">
          <label for="student_major" class="form-label">Jurusan</label>
          <select
            name="student_major"
            id="student_major"
            class="form-select <?php echo $major_error ? 'is-invalid' : '' ?>">
            <option value="">Pilih Jurusan</option>

            <!-- Akuntansi -->
            <option value="AK" <?php if (($_POST['student_major'] ?? '') == 'AK')   echo 'selected'; ?>>Akuntansi</option>
            <option value="AK 1" <?php if (($_POST['student_major'] ?? '') == 'AK 1') echo 'selected'; ?>>Akuntansi 1</option>
            <option value="AK 2" <?php if (($_POST['student_major'] ?? '') == 'AK 2') echo 'selected'; ?>>Akuntansi 2</option>

            <!-- Bisnis Retail -->
            <option value="BR" <?php if (($_POST['student_major'] ?? '') == 'BR')   echo 'selected'; ?>>Bisnis Retail</option>
            <option value="BR 1" <?php if (($_POST['student_major'] ?? '') == 'BR 1') echo 'selected'; ?>>Bisnis Retail 1</option>
            <option value="BR 2" <?php if (($_POST['student_major'] ?? '') == 'BR 2') echo 'selected'; ?>>Bisnis Retail 2</option>

            <!-- Manajemen Perkantoran -->
            <option value="MP" <?php if (($_POST['student_major'] ?? '') == 'MP')   echo 'selected'; ?>>Manajemen Perkantoran</option>
            <option value="MP 1" <?php if (($_POST['student_major'] ?? '') == 'MP 1') echo 'selected'; ?>>Manajemen Perkantoran 1</option>
            <option value="MP 2" <?php if (($_POST['student_major'] ?? '') == 'MP 2') echo 'selected'; ?>>Manajemen Perkantoran 2</option>

            <!-- Rekayasa Perangkat Lunak -->
            <option value="RPL" <?php if (($_POST['student_major'] ?? '') == 'RPL')   echo 'selected'; ?>>Rekayasa Perangkat Lunak</option>
            <option value="RPL 1" <?php if (($_POST['student_major'] ?? '') == 'RPL 1') echo 'selected'; ?>>RPL 1</option>
            <option value="RPL 2" <?php if (($_POST['student_major'] ?? '') == 'RPL 2') echo 'selected'; ?>>RPL 2</option>

          </select>
          <?php if ($major_error) { ?>
            <div class="invalid-feedback d-block"><?php echo htmlspecialchars($major_error) ?></div>
          <?php } ?>
        </div>

        <button type="submit" class="btn btn-primary mt-2 w-100">
          Submit
        </button>

      </form>

      <!-- Back Button -->
      <div class="mb-3 mt-5 d-flex justify-content-center">
        <a href="../index.php" class="btn btn-secondary">
          ← Kembali Ke Halaman Utama
        </a>
      </div>

    </div>

  </div>

</body>

</html>