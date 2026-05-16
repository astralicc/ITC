<?php

session_start();

require_once __DIR__ . '/../database.php';


if (!isset($_SESSION['user_id'])) {
  header('Location: ../auth/login.php');
  exit;
}
