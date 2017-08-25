<?php

require '../util/Prototype.php';

$noUser = false;

if(isset($_POST["user"]) && isset($_POST["pass"])){
  $params = array(
    "user" => md5($_POST["user"]), 
    "pass" => md5($_POST["pass"])
  );
  $res = getPrototypeInstance()->select("u.id, ud.name, ud.last_name", "users AS u, user_detail AS ud", "WHERE ud.id = u.type_id AND u.user = :user AND pass = :pass", $params);
  if($res["err"] == null && $res["res"] != null){
    session("start");
    session("set", "id", $res["res"][0]["id"]);
    session("set", "name", $res["res"][0]["name"]);
    session("set", "lastName", $res["res"][0]["last_name"]);
    header('Location: ../');
  }else{
    $noUser = true;
  }
}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../assets/images/favicon.png" rel="shortcut icon">

        <title>Login | Sistema de Cotizaciones</title>

        <link href="../assets/bs3/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/css/bootstrap-reset.css" rel="stylesheet">
        <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="../assets/css/style.css" rel="stylesheet">
        <link href="../assets/css/style-responsive.css" rel="stylesheet" />

        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="login-body">
        <div class="container">
          <form class="form-signin" action="" method="post">
            <h2 class="form-signin-heading">Ingresar al Sistema de Cotizaciones</h2>
            <div class="login-wrap">
                <div class="user-login-info">
                    <input name="user" type="text" class="form-control" placeholder="Usuario" autofocus>
                    <input name="pass" type="password" class="form-control" placeholder="Contraseña">
                </div>
                <button class="btn btn-lg btn-login btn-block" type="submit">Ingresar</button>
            </div>
            <?php if($noUser){ ?>
            <div class="alert alert-block alert-danger fade in">
              <button data-dismiss="alert" class="close close-sm" type="button">
                <i class="fa fa-times"></i>
              </button>
              <strong>Error</strong> Usuario o contraseña incorrectos.
            </div>
            <?php } ?>
          </form>
        </div>
        <script src="../assets/js/jquery.js"></script>
        <script src="../assets/bs3/js/bootstrap.min.js"></script>
        <script src="../assets/js/jquery.dcjqaccordion.2.7.js" class="include" type="text/javascript"></script>
        <script src="../assets/js/jquery.scrollTo.min.js"></script>
        <script src="../assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
        <script src="../assets/js/jquery.nicescroll.js"></script>
        <script src="../assets/js/scripts.js"></script>
    </body>
</html>