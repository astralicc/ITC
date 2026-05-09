<?php require 'form-validation.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">

  <title>Form Guru</title>
</head>

<body class="bg-light">

  <div class="d-flex justify-content-center align-items-center min-vh-100">

    <div style="width: 500px;">

      <h1 class="mb-4">Form Guru</h1>

      <form action="" method="post">

        <!-- Database Error Message -->
        <?php if ($database_error_message) { ?>
          <div class="alert alert-danger">
            <?php echo htmlspecialchars($database_error_message) ?>
          </div>
        <?php } ?>

        <!-- Success Message -->
        <?php if ($success_message) { ?>
          <div class="alert alert-success mt-3">
            <?php echo htmlspecialchars($success_message) ?>
          </div>
        <?php } ?>

        <!-- Nama Guru -->
        <div class="mb-3">
          <label for="teacher_name" class="form-label">Nama Guru</label>
          <input
            type="text"
            id="teacher_name"
            name="teacher_name"
            class="form-control <?php echo $name_error ? 'is-invalid' : '' ?>"
            placeholder="Nama Guru"
            value="<?php echo htmlspecialchars($_POST['teacher_name'] ?? '') ?>">
          <?php if ($name_error) { ?>
            <div class="invalid-feedback d-block"><?php echo htmlspecialchars($name_error) ?></div>
          <?php } ?>
        </div>

        <!-- NIP Guru -->
        <div class="mb-3">
          <label for="teacher_nip" class="form-label">NIP Guru</label>
          <input
            type="number"
            id="teacher_nip"
            name="teacher_nip"
            class="form-control <?php echo $nip_error ? 'is-invalid' : '' ?>"
            placeholder="NIP Guru (18 digit)"
            value="<?php echo htmlspecialchars($_POST['teacher_nip'] ?? '') ?>">
          <?php if ($nip_error) { ?>
            <div class="invalid-feedback d-block"><?php echo htmlspecialchars($nip_error) ?></div>
          <?php } ?>
        </div>

        <!-- Mata Pelajaran -->
        <div class="mb-3">
          <label for="teacher_mapel" class="form-label">Mata Pelajaran Guru</label>
          <select
            name="teacher_mapel"
            id="teacher_mapel"
            class="form-select <?php echo $mapel_error ? 'is-invalid' : '' ?>">
            <option value="">Pilih Mata Pelajaran Guru</option>
            <option value="ak" <?php if (($_POST['teacher_mapel'] ?? '') === 'ak')   echo 'selected'; ?>>Akuntansi</option>
            <option value="br" <?php if (($_POST['teacher_mapel'] ?? '') === 'br')   echo 'selected'; ?>>Bisnis Retail</option>
            <option value="mp" <?php if (($_POST['teacher_mapel'] ?? '') === 'mp')   echo 'selected'; ?>>Manajemen Perkantoran</option>
            <option value="rpl" <?php if (($_POST['teacher_mapel'] ?? '') === 'rpl')  echo 'selected'; ?>>Rekayasa Perangkat Lunak</option>
            <option value="umum" <?php if (($_POST['teacher_mapel'] ?? '') === 'umum') echo 'selected'; ?>>Umum</option>
          </select>
          <?php if ($mapel_error) { ?>
            <div class="invalid-feedback d-block"><?php echo htmlspecialchars($mapel_error) ?></div>
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