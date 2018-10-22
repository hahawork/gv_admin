<?php

  // Inicia la sesion
  session_start();

  $txtUsuario = isset($_POST['txtemail']) ? $_POST['txtemail'] : null;
  $Password = isset($_POST['txtpassword']) ? $_POST['txtpassword'] : null;

  $errores = array();
  $login_error = null;
  $msg_error = null;

  if(isset($_POST['btnEntrar'])){

    require_once("../conexion/conexion.php");
    $cnn = new conexion();
    $conn = $cnn -> conectar();

    $sql = "SELECT * FROM LoginusuarioSesion INNER JOIN clientes ON LoginusuarioSesion.IdCliente = clientes.IdCliente WHERE EmailUC ='" . $txtUsuario . "' AND PasswordUC = '" . md5($Password) . "'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
      $row_cnt = $result->num_rows;
      if ($row_cnt > 0) {
        
        $user = mysqli_fetch_array($result);

        $_SESSION["sUserName"] = $user['NombreUsuario'];
        $_SESSION["sUserId"] = $user['iduc'];
        $_SESSION["sIdCliente"] = $user['IdCliente'];
        $_SESSION["sUserEmail"] = $user['EmailUC'];
		    $_SESSION["simgFotoPerfilUrl"] = $user['imgFotoPerfilUrl'];
        $_SESSION["sessionRol"] = $user['Rol'];
        $_SESSION["sIdUsuario"] = $user['IdUsuario'];
        $_SESSION["sNombCliente"] = $user['RazonSocial'];
        $_SESSION["sNivelAcceso"] = $user['NivelAcceso'];

        $login_error = null;

        if (strlen($_SESSION["sRedireccionar"]) > 0) {
         
          header("Location: " . $_SESSION['sRedireccionar']);
          $_SESSION["sRedireccionar"] = ""; 
        }
        if ($_SESSION["sessionRol"] == "Factura") {
          header('Location: ../tables/asistencia-imprimir.php');
        }
        else{
          header('Location: ../index.php');
        }
        
      }     
     
    }
    else{
      $errores[] = "Verifique sus datos.";
      $login_error = true;

    }

  }

?>

<!DOCTYPE html>
<html>

<head>
  <link rel="icon" type="image/png" href="../favicon.png">

    <meta charset="UTF-8">

    <title>Inicio de sesión</title>

    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css"> 

</head>

<body class="hold-transition skin-blue layout-boxed sidebar-mini" onLoad="document.getElementById('txtemail').focus();">  
    <span href="#" class="button" id="toggle-login">Ingresa tus datos de acceso.</span>

<div id="login">
    
    <div id="triangle"></div>
    <h1>Inicio de Sesión</h1>

    <form method="post" action="index.php">

      
          <?php if ($errores): ?>
            <div id='error_notification'>
              <ul style="color: #f00;">
                <?php foreach ($errores as $error): ?>
                   <li> <?php echo $error ?> </li>
                <?php endforeach; ?>
              </ul>
           </div>     
        <?php endif; ?>

         
      <input type="email" name="txtemail" id="txtemail" placeholder="Correo" value="<?php echo $txtUsuario; ?>" required="required" />
      <input type="password" name="txtpassword" placeholder="Contraseña" required="required"/>

      <div style="margin-bottom: 3px; margin-top: 3px;"><a href="#">Olvidé mi contraseña.</a></div></span>
    
      <input type="submit" name="btnEntrar" value="Entrar" />

    </form>
</div>

  <script src='http://codepen.io/assets/libs/fullpage/jquery.js'></script>

  <script src="js/index.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script language="Javascript">
        $(document).ready(function(){
            $('input').keypress(function(e) { 
                var s = String.fromCharCode( e.which );

                if((s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey) ||
                   (s.toUpperCase() !== s && s.toLowerCase() === s && e.shiftKey)){
                    if($('#capsalert').length < 1) $(this).after('<b style="color: #f00;" id="capsalert"><br>¡Bloqueo de mayúscula Activado!</b>');
                } else {
                    if($('#capsalert').length > 0 ) $('#capsalert').remove();
                }
            });
        });
    </script>

</body>

</html>