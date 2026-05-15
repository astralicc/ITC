<?php

$conn = mysqli_connect('localhost', 'root', '', 'itc_formsekolah');

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$query = "INSERT INTO guru (teacher_uid, teacher_name, teacher_nip, teacher_mapel) VALUES (?, ?, ?, ?)";
