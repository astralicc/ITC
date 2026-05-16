<?php
session_start();

require_once __DIR__ . '/../database.php';

$success_message = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);

$database_error_message = null;
$email_error            = null;
$password_error         = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $user_data = $_POST;

  $email = trim($user_data['user_email'] ?? '');
  $password = trim($user_data['user_password'] ?? '');

  // Email Validation
  if (empty($email)) {
    $email_error = 'Please fill the email field.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $email_error = 'Invalid email.';
  }

  // Password Validation
  if (empty($password)) {
    $password_error = 'Please fill the password field.';
  }

  // Login
  if (!$email_error && !$password_error) {
    $query = "
      SELECT * FROM users
      WHERE email = :email
      LIMIT 1
    ";

    $stmt = $conn->prepare($query);

    $stmt->execute([
      ':email' => $email
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      if (password_verify($password, $user['password'])) {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['name'] = $user['name'];

        header('Location: ../products/index.php');
        exit;
      } else {
        $password_error = 'Invalid credentials.';
      }
    } else {
      $email_error = 'Invalid credentials.';
    }
  }
}
