<?php

$conn = mysqli_connect('localhost', 'root', '', 'db_absenitc');

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {

  $uid = uniqid();
  $name = $_POST['name_user'];
  $email = $_POST['email_user'];
  $password = $_POST['password_user'];

  $query = "INSERT INTO users (uid, name, email, password)
            VALUES ('$uid', '$name', '$email', '$password')";

  mysqli_query($conn, $query);

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

$result = mysqli_query($conn, "SELECT * FROM users");


?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap Demo</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <div class="container mt-5">
    <div class="row">
      <div class="col-3"></div>

      <div class="col-6">

        <div class="card-body p-5 shadow">

          <form method="post">

            <div class="form-group mb-3">
              <label for="name_user">Full Name</label>

              <input
                name="name_user"
                type="text"
                class="form-control"
                id="name_user"
                required>
            </div>

            <div class="form-group mb-3">
              <label for="email_user">Email address</label>

              <input
                name="email_user"
                type="email"
                class="form-control"
                id="email_user"
                required>

              <small class="text-muted">
                We'll never share your email with anyone else.
              </small>
            </div>

            <div class="form-group mb-3">
              <label for="password_user">Password</label>

              <input
                name="password_user"
                type="password"
                class="form-control"
                id="password_user"
                required>
            </div>

            <div class="form-group form-check mb-3">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">

              <label class="form-check-label" for="exampleCheck1">
                Check me out
              </label>
            </div>

            <button
              name="login"
              type="submit"
              class="btn btn-primary">
              Submit
            </button>

          </form>

          <?php if (mysqli_num_rows($result) > 0): ?>

            <table class="table table-bordered mt-4">

              <thead class="table-dark">
                <tr>
                  <th>No.</th>
                  <th>UID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Password</th>
                </tr>
              </thead>

              <tbody>

                <?php $no = 1; ?>

                <?php while ($row = mysqli_fetch_assoc($result)): ?>

                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['uid']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['password']) ?></td>
                  </tr>

                <?php endwhile; ?>

              </tbody>

            </table>

          <?php else: ?>

            <p class="text-muted mt-4">
              No data yet
            </p>

          <?php endif; ?>

        </div>

      </div>

      <div class="col-3"></div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>