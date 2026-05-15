<?php

$conn = mysqli_connect('localhost', 'root', '', 'itc_formsekolah');

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$query = "INSERT INTO siswa 
(student_uid, student_name, student_nis, student_nisn, student_class, student_major) 
VALUES (?, ?, ?, ?, ?, ?)";
