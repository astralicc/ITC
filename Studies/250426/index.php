<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'db_absenitc');


if (!isset($_SESSION['entries'])) {
  $_SESSION['entries'] = [];
}

if (isset($_POST['login'])) {
  $_SESSION['entries'][] = [
    'email'    => $_POST['email'],
    'password' => $_POST['password'],
  ];

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>typeshi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

  <div class="container">
    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <div class="card-body p-5">

          <form method="post">
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group mt-3">
              <label for="exampleInputPassword1">Password</label>
              <input name="password" type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="form-group form-check mt-3">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button name="login" type="submit" class="btn btn-primary mt-3">Submit</button>
          </form>

          <?php if (!empty($_SESSION['entries'])): ?>
            <table class="table table-bordered mt-4">
              <thead class="table-dark">
                <tr>
                  <th>No.</th>
                  <th>Email</th>
                  <th>Password</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($_SESSION['entries'] as $index => $entry): ?>
                  <tr>
                    <td><?= $index + 1 ?>.</td>
                    <td><?= htmlspecialchars($entry['email']) ?></td>
                    <td><?= htmlspecialchars($entry['password']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php else: ?>
            <p class="text-muted mt-4">Not inputted yet</p>
          <?php endif; ?>

        </div>
      </div>
      <div class="col-3"></div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>