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

  <script>
    function check(input) {
        if (input.value != document.getElementById('password').value) {
            input.setCustomValidity('Die Passwörter müssen übereinstimmen');
        } else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }

</script>
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
      <p class="login-box-msg">Passwort zurücksetzen</p>


    <?php

    if(isset($_GET['user_name'])){
        $user_name = htmlspecialchars($_GET['user_name']);
    }else{
        $user_name = "";
    }


    if(isset($_GET['user_secret'])){
        $secret = htmlspecialchars($_GET['user_secret']);
    }else{
        $secret = "";
    }


    if(isset($error)){
      echo "<p class='logn-box-msg bg-danger' style='text-align:center'>$error</p>";
    }
    ?>
      
    
      <form action="login_set_password_script.php" method="post">
        <div class="input-group mb-3">
          <input required type="email" class="form-control" name="mail" placeholder="E-Mail" value="<?php echo $user_name; ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input required  type="text" class="form-control" name="secret" placeholder="Sicherheitscode" value="<?php echo $secret; ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-key"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input required  type="password" class="form-control" name="password" id="password" placeholder="neues Passwort">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input required  type="password" class="form-control" name="password_repeat" placeholder="neues Passwort wiederholen" oninput="check(this)">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
          <p class="mb-1">
        <a href="login.php">zur Anmeldung</a>
      </p>
          </div>
          <!-- /.col -->
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block">Passwort ändern</button>
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
