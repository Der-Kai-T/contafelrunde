<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>contafelrunde.de | Administration</title>

  <link rel="icon" href="assets/img/logo.png">
  <!-- Use Font FHH Sans Serifo -->
  <link rel="stylesheet" href="css/font.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/adminlte.min.css">
</head>
<body class="hold-transition login-page dark-mode">
<div class="login-box">
  <div class="login-logo">
  <!-- img-width: 360px -->
    <a href="#"><b>contafelrunde.de</b><br>Administration</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Bitte melden Sie sich an</p>

      <?php
        if(isset($_GET['e'])){
          $error = "Benutzername und/oder Passwort sind falsch";
        }

      if(isset($success)){
        echo"<p class='login-box-msg bg-success' style='text-align:center;'>$success</p>";
      }
      
      if(isset($error)){
        echo"<p class='login-box-msg bg-danger' style='text-align:center;'>$error</p>";
      }
      ?>

      <form action="login_script.php" method="POST">
        <div class="input-group mb-3">
          <input required type="email" name="email" class="form-control" placeholder="E-Mail">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input required type="password" name="password" class="form-control" placeholder="Passwort">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
          <p class="mb-1">
        <a href="login_lost_password.php">Passwort vergessen</a>
      </p>

      <p class="mb-1">
        <a href="login_set_password.php">Passwort ändern</a>
      </p>
          </div>
          <!-- /.col -->
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block">Anmelden</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      
      
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
</body>
</html>
