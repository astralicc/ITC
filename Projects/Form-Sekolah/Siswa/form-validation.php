<?php

$success_message        = null;
$database_error_message = null;
$name_error             = null;
$nis_error              = null;
$nisn_error             = null;
$class_error            = null;
$major_error            = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $student_data = $_POST;

  // VALIDATION

  // Validate name
  if (empty(trim($student_data['student_name'] ?? ''))) {
    $name_error = 'Isi nama murid.';
  } elseif (!preg_match("/^[a-zA-Z]+(?: [a-zA-Z]+)*$/", trim($student_data['student_name']))) {
    $name_error = 'Kolom ini hanya menerima karakter alfabet dan satu spasi.';
  }

  // Validate NIS (8–10 digits)
  if (empty(trim($student_data['student_nis'] ?? ''))) {
    $nis_error = 'Isi NIS murid.';
  } elseif (!ctype_digit($student_data['student_nis'])) {
    $nis_error = 'Kolom ini hanya menerima karakter angka.';
  } elseif (strlen($student_data['student_nis']) != 5) {
    $nis_error = 'NIS harus terdiri dari 5 digit.';
  }

  // Validate NISN
  if (empty(trim($student_data['student_nisn'] ?? ''))) {
    $nisn_error = 'Isi NISN murid.';
  } elseif (!ctype_digit($student_data['student_nisn'])) {
    $nisn_error = 'NISN hanya menerima karakter angka.';
  } elseif (strlen($student_data['student_nisn']) !== 10) {
    $nisn_error = 'NISN harus terdiri dari 10 digit.';
  }

  // Validate student_class
  $valid_classes = ['X', 'XI', 'XII'];
  if (empty($student_data['student_class'] ?? '')) {
    $class_error = 'Pilih kelas yang sesuai.';
  } elseif (!in_array($student_data['student_class'], $valid_classes)) {
    $class_error = 'Kelas tidak valid.';
  }

  // Validate student_major
  $valid_majors = ['AK', 'AK 1', 'AK 2', 'BR', 'BR 1', 'BR 2', 'MP', 'MP 1', 'MP 2', 'RPL', 'RPL 1', 'RPL 2'];
  if (empty($student_data['student_major'] ?? '')) {
    $major_error = 'Pilih jurusan yang sesuai.';
  } elseif (!in_array($student_data['student_major'], $valid_majors)) {
    $major_error = 'Jurusan tidak valid.';
  }

  // ── INSERT ────────────────────────────────────────────────────
  if (!$name_error && !$nis_error && !$nisn_error && !$class_error && !$major_error) {

    $student_uid   = uniqid("STD");
    $student_name  = trim($student_data['student_name']);
    $student_nis   = trim($student_data['student_nis']);
    $student_nisn  = trim($student_data['student_nisn']);
    $student_class = trim($student_data['student_class']);
    $student_major = trim($student_data['student_major']);

    $conn = mysqli_connect('localhost', 'root', '', 'itc_formsekolah');

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $query = "INSERT INTO siswa (student_uid, student_name, student_nis, student_nisn, student_class, student_major) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $student_uid, $student_name, $student_nis, $student_nisn, $student_class, $student_major);

    try {
      $stmt->execute();
      $success_message = "Data berhasil disimpan!";
      $_POST = [];
    } catch (mysqli_sql_exception $e) {
      if ($e->getCode() == 1062) {
        if (str_contains($e->getMessage(), 'student_nisn')) {
          $nisn_error = "NISN sudah terdaftar!";
        } else {
          $nis_error = "NIS sudah terdaftar!";
        }
      } else {
        $database_error_message = "Gagal menyimpan data.";
      }
    }

    $stmt->close();
    $conn->close();
  }
}
