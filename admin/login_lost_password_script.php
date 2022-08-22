<?php

include("include/functions.php");
include("include/db_connect.php");
include("include/db_querys.php");
include("include/times.php");
include("include/mailhandler.php");
    $global_domain = "http://localhost/contafelrunde/";

    $email 		= $_POST['email'];


    //check if user exists

    $sql        = "SELECT * FROM tr_user WHERE tr_user_mail = :mail";

    $pdo 		= new PDO($pdo_mysql, $pdo_db_user, $pdo_db_pwd);

    $statement	= $pdo->prepare($sql);
	
	$statement->bindParam(':mail', $email);
	
	
	$statement->execute();

    while($row = $statement->fetch()){
        $user_data = $row;
    }


    if(isset($user_data)){
        //update password and secret
        $new_secret = generate_secret();

        $tr_user_id              = $user_data['tr_user_id'];
        $name                    = $user_data['tr_user_name'];
        $email                   = $user_data['tr_user_mail'];

        $data['tr_user_secret']     = $new_secret;
        

        $data['tr_user_modify_id']  = $tr_user_id;
        $data['tr_user_modify_ts']  = time();


        $where = array();
        $wh['col'] = "tr_user_id";
        $wh['typ'] = "=";
        $wh['val'] = $tr_user_id;
        array_push($where, $wh);

        $db_result = db_update("tr_user", $data, $where);

        //send notification

        if($db_result['result'] == "ok"){

                  
                   
            $link_href      = $global_domain . "admin/login_set_password.php?user_name=$email&user_secret=$new_secret";

            $link           = "<a href='$link_href'>$link_href</a>";
        
        
            $subject        = "Passwort-Anforderung";
        
            $body           = "<p>Hallo $name,<br> mit dem untenstehenden Link kannst du dein Passwort &auml;ndern:</p>
            
            <p>$link</p>
        
            <p>Alternativ besuche verwende den unten stehenden Sicherheitscode um &uuml;ber die Anmeldemaske das Passwort zu &auml;ndern:<br><pre>$new_secret</pre></p>
            
            <p>Viele Gr&uuml;&szlig;e<br>
            <i>Con-Tafelrunde Administration</i></p>";
            
        
            $rec            = array();
        
            $rec1['mail']   = $email;
            $rec1['name']   = $name;
        
            array_push($rec, $rec1);
        
        
            $mail = phpmailer_send_mail($rec, $subject, $body);
        }



    }

?>








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
      <p class="login-box-msg">Passwort zurücksetzen</p>
      <p class="login-box-msg">Wenn zu der E-Mail-Adresse ein Konto hinterlegt ist, erhalten Sie einen Link zum setzen Ihres Passwortes zugeschickt.</p>
      <p class="login-box-msg"><a href="login.php">zurück zur Anmeldung</a></p>

      
      
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
