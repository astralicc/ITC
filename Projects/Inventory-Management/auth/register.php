<?php
require __DIR__ . '/regis-logic.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  <link rel="stylesheet" href="../style.css">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <title>Register</title>
</head>

<body>

  <div class="d-flex justify-content-center align-items-center min-vh-100">

    <div style="width: 500px;">

      <h1 class="mb-4">Register</h1>

      <!-- Database Error Message -->
      <?php if ($database_error_message) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($database_error_message) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php } ?>

      <!-- Success Message -->
      <?php if ($success_message) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($success_message) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php } ?>

      <form action="" method="post">

        <!-- Name -->
        <div class="mb-3">

          <label for="student_name" class="form-label">
            Name
          </label>

          <input
            type="text"
            id="student_name"
            name="user_name"
            class="form-control <?= $name_error ? 'is-invalid' : '' ?>"
            placeholder="Name"
            value="<?= htmlspecialchars($_POST['user_name'] ?? '') ?>">

          <?php if ($name_error) { ?>
            <div class="invalid-feedback d-block">
              <?= htmlspecialchars($name_error) ?>
            </div>
          <?php } ?>

        </div>

        <!-- Email -->
        <div class="mb-3">

          <label for="student_nis" class="form-label">
            Email
          </label>

          <input
            type="email"
            id="student_nis"
            name="user_email"
            class="form-control <?= $email_error ? 'is-invalid' : '' ?>"
            placeholder="Email"
            value="<?= htmlspecialchars($_POST['user_email'] ?? '') ?>">

          <?php if ($email_error) { ?>
            <div class="invalid-feedback d-block">
              <?= htmlspecialchars($email_error) ?>
            </div>
          <?php } ?>

        </div>

        <!-- Password -->
        <div class="mb-3">

          <label for="student_nisn" class="form-label">
            Password
          </label>

          <input
            type="password"
            id="student_nisn"
            name="user_password"
            class="form-control <?= $password_error ? 'is-invalid' : '' ?>"
            placeholder="Password"
            value="">

          <?php if ($password_error) { ?>
            <div class="invalid-feedback d-block">
              <?= htmlspecialchars($password_error) ?>
            </div>
          <?php } ?>

        </div>

        <button type="submit" class="btn btn-primary mt-2 w-100">
          Submit
        </button>

        <div>
          <p class="auth-text">Already have an account? <a href="login.php">Login</a>
          </p>
        </div>

    </div>

    </form>

  </div>

  </div>

</body>

</html>