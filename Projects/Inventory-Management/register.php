<?php 
require __DIR__ . 'logic.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  <link rel="stylesheet" href="style.css">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <title>Register</title>
</head>

<body>

  <div class="d-flex justify-content-center align-items-center min-vh-100">

    <div style="width: 500px;">

      <h1 class="mb-4">Register</h1>

      <form action="" method="post">

        <!-- Name -->
        <div class="mb-3">

          <label for="student_name" class="form-label">
            Name
          </label>

          <input
            type="text"
            id="student_name"
            name="student_name"
            class="form-control"
            placeholder="Name">

        </div>

        <!-- Email -->
        <div class="mb-3">

          <label for="student_nis" class="form-label">
            Email
          </label>

          <input
            type="email"
            id="student_nis"
            name="student_nis"
            class="form-control"
            placeholder="Email">

        </div>

        <!-- Password -->
        <div class="mb-3">

          <label for="student_nisn" class="form-label">
            Password
          </label>

          <input
            type="password"
            id="student_nisn"
            name="student_nisn"
            class="form-control"
            placeholder="Password">

        </div>

        <button type="submit" class="btn btn-primary mt-2 w-100">
          Submit
        </button>

    </div>

    </form>

  </div>

  </div>

</body>

</html>