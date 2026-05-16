<?php

require_once __DIR__ . '/../database.php';

session_start();
$success_message = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);

$database_error_message = null;
$name_error             = null;
$email_error            = null;
$password_error         = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $user_data = $_POST;

  $name = trim($user_data['user_name'] ?? '');
  $email = trim($user_data['user_email'] ?? '');
  $password = trim($user_data['user_password'] ?? '');

  // Name Validation
  if (empty($name)) {
    $name_error = 'Please fill the name field.';
  } elseif (!preg_match("/^[a-zA-Z]+(?: [a-zA-Z]+)*$/", $name)) {
    $name_error = 'This field only accepts alphabetic characters and one space.';
  } elseif (strlen($name) < 3) {
    $name_error = 'Name must be at least 3 characters long.';
  }

  // Email Validation
  if (empty($email)) {
    $email_error = 'Please fill the email field.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $email_error = 'Invalid email.';
  }

  // Password Validation
  if (empty($password)) {
    $password_error = 'Please fill the password field.';
  } elseif (strlen($password) < 8) {
    $password_error = 'Password must be at least 8 characters.';
  }

  // Register
  if (!$name_error && !$email_error && !$password_error) {

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "
      INSERT INTO users (name, email, password)
      VALUES (:name, :email, :password)
    ";

    $stmt = $conn->prepare($query);

    $data = [
      ':name' => $name,
      ':email' => $email,
      ':password' => $hashed_password,
    ];

    try {
      $query_execute = $stmt->execute($data);

      if ($query_execute) {
        $_SESSION['success_message'] = 'User created successfully!';

        header('Location: login.php');
        exit;
      }
    } catch (PDOException $e) {
      if (($e->errorInfo[1] ?? null) == 1062) {
        $email_error = 'Email already exists.';
      } else {

        $database_error_message = 'Database error occurred.';
      }
    }
  }
}
