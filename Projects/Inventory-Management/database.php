<?php
$hostname = 'localhos';
$username = 'root';
$password = '';
$database = 'inventory-practice-db';

try {
  $conn = new PDO("mysql:host=$hostname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  echo 'Connected successfully!';
} catch (PDOException $e) {
  echo 'Connection failed' . $e->getMessage();
}
