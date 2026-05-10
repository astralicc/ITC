<?php
require_once __DIR__ . '/database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../style.css">

  <title>CRUD Guru</title>
</head>

<body>

  <div class="d-flex justify-content-center align-items-center min-vh-100">

    <div class="w-100 px-3" style="max-width: 900px;">

      <h1 class="mb-4">CRUD Guru</h1>

      <!-- Success Alert -->
      <?php if (isset($_GET['success']) && $_GET['success'] === 'delete') : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Data berhasil dihapus!
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Error Alert -->
      <?php if (isset($_GET['error']) && $_GET['error'] === 'delete') : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          Data gagal dihapus!
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <div class="table-responsive">

        <table class="table table-hover align-middle">

          <thead>
            <tr>
              <th>#</th>
              <th>ID Guru</th>
              <th>Nama Guru</th>
              <th>NIP Guru</th>
              <th>Mata Pelajaran Guru</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody>

            <?php
            $no = 1;

            $mapel = [
              'ak' => 'Akuntansi',
              'br' => 'Bisnis Retail',
              'mp' => 'Manajemen Perkantoran',
              'rpl' => 'Rekayasa Perangkat Lunak',
              'umum' => 'Umum'
            ];

            while ($row = mysqli_fetch_assoc($query)) :
            ?>

              <tr>

                <th scope="row"><?= $no++; ?></th>

                <td><?= htmlspecialchars($row['teacher_id']); ?></td>

                <td><?= htmlspecialchars($row['teacher_name']); ?></td>

                <td><?= htmlspecialchars($row['teacher_nip']); ?></td>

                <td>
                  <?= htmlspecialchars($mapel[$row['teacher_mapel']] ?? 'Tidak diketahui'); ?>
                </td>

                <td>

                  <div class="d-flex gap-2">

                    <a
                      href="edit-guru.php?id=<?= $row['teacher_id']; ?>"
                      class="btn btn-warning btn-sm">
                      Edit
                    </a>

                    <button
                      class="btn btn-danger btn-sm"
                      data-bs-toggle="modal"
                      data-bs-target="#deleteModal<?= $row['teacher_id']; ?>">
                      Delete
                    </button>

                  </div>

                  <!-- Delete Modal -->
                  <div
                    class="modal fade"
                    id="deleteModal<?= $row['teacher_id']; ?>"
                    tabindex="-1"
                    aria-hidden="true">

                    <div class="modal-dialog modal-dialog-centered">

                      <div class="modal-content">

                        <div class="modal-header">
                          <h5 class="modal-title">Hapus Data</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                          Yakin ingin menghapus data guru
                          <strong>
                            <?= htmlspecialchars($row['teacher_name']); ?>
                          </strong> ?
                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                          </button>

                          <a
                            href="delete-guru.php?id=<?= (int)$row['teacher_id']; ?>"
                            class="btn btn-danger">
                            Hapus
                          </a>

                        </div>

                      </div>

                    </div>

                  </div>

                </td>

              </tr>

            <?php endwhile; ?>

          </tbody>

        </table>

      </div>

      <div class="mb-3 mt-5 d-flex justify-content-center">
        <a href="../../index.php" class="btn btn-secondary">
          ← Kembali Ke Halaman Utama
        </a>
      </div>

    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>