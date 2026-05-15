<?php
require_once __DIR__ . '/database.php';

$success_message        = null;
$database_error_message = null;
$name_error             = null;
$nip_error              = null;
$mapel_error            = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $teacher_data = $_POST;

  // Validate name
  if (empty(trim($teacher_data['teacher_name'] ?? ''))) {
    $name_error = 'Isi nama guru.';
  } elseif (!preg_match("/^[a-zA-Z]+(?: [a-zA-Z]+)*$/", trim($teacher_data['teacher_name']))) {
    $name_error = 'Kolom ini hanya menerima karakter alfabet dan satu spasi.';
  }

  // Validate NIP (18 digits)
  if (empty(trim($teacher_data['teacher_nip'] ?? ''))) {
    $nip_error = 'Isi NIP guru.';
  } elseif (!ctype_digit($teacher_data['teacher_nip'])) {
    $nip_error = 'Kolom ini hanya menerima karakter angka.';
  } elseif (strlen($teacher_data['teacher_nip']) !== 18) {
    $nip_error = 'NIP harus terdiri dari 18 digit.';
  }

  // Validate mapel
  $valid_mapel = ['ak', 'br', 'mp', 'rpl', 'umum'];
  if (empty($teacher_data['teacher_mapel'] ?? '')) {
    $mapel_error = 'Pilih mata pelajaran yang sesuai.';
  } elseif (!in_array($teacher_data['teacher_mapel'], $valid_mapel)) {
    $mapel_error = 'Mata pelajaran tidak valid.';
  }

  // Insert if no errors
  if (!$name_error && !$nip_error && !$mapel_error) {

    $teacher_uid   = uniqid("TCH");
    $teacher_name  = trim($teacher_data['teacher_name']);
    $teacher_nip   = trim($teacher_data['teacher_nip']);
    $teacher_mapel = trim($teacher_data['teacher_mapel']);

    $stmt = $conn->prepare($query);

    if (!$stmt) {
      die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssss", $teacher_uid, $teacher_name, $teacher_nip, $teacher_mapel);

    try {
      $stmt->execute();
      $success_message = "Data berhasil disimpan!";
      $_POST = [];
    } catch (mysqli_sql_exception $e) {
      if ($e->getCode() == 1062) {
        $nip_error = "NIP sudah terdaftar!";
      } else {
        $database_error_message = "Gagal menyimpan data.";
      }
    }

    $stmt->close();
    $conn->close();
  }
}
