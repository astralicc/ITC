<?php

$conn = mysqli_connect('localhost', 'root', '', 'itc_formsekolah');

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$query = mysqli_query($conn, "SELECT * FROM guru");

if (!$query) {
  die(mysqli_error($conn));
}
