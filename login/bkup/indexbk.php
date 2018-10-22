<?php
// Inicia la sesion
session_start();

$Servidor = 'http://' . $_SERVER['HTTP_HOST'] . "/admin/";


// si aun no ha iniciado sesion
if (!isset($_SESSION['sUserId'])) {
    
} else {   // si ya inicio sesion  
    header("Location: " . $Servidor . $_SESSION['sPaginaInicio']);
}


$txtUsuario = isset($_POST['txtemail']) ? $_POST['txtemail'] : null;
$Password = isset($_POST['txtpassword']) ? $_POST['txtpassword'] : null;

$errores = array();
$login_error = null;
$msg_error = null;

if (isset($_POST['btnEntrar'])) {

    require_once("../conexion/conexion.php");
    $cnn = new conexion();
    $conn = $cnn->conectar();

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
            $_SESSION["sPaginaInicio"] = $user['PaginaInicio'];

            $login_error = null;

            debug_to_console($_SESSION["sRedireccionar"]);

            if (strlen($_SESSION["sRedireccionar"]) > 0) {

                header("Location: ../../" . $_SESSION['sRedireccionar']);
                $_SESSION["sRedireccionar"] = NULL;
                exit;
            } else {
                header("Location: " . $Servidor . $_SESSION['sPaginaInicio']);
                exit;
            }
        }
    } else {
        $errores[] = "Verifique sus datos.";
        $login_error = true;
    }
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}
?>

<html>
    <head>
         <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>GrupoValor - Inicio de Sesión</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
               
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.js"></script>
        <style type="text/css">
            body { background: black; }
        </style>
    </head>

    <body style="background:-webkit-gradient(linear, 100% 30%, 100% 100%, from(#00000F), to(#0046FF))">
           <div class="login-box">
            <div class="login-logo">
                <a href="http://www.grupovalor.com.ni/mo"><b>GrupoValor</b>Nicaragua</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Ingrese sus credenciales para iniciar sesión</p>

                <form method="post" action="index.php">
                    <div class="form-group has-feedback">
                        <input type="email" name="txtemail" class="form-control" placeholder="Correo">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="txtpassword" class="form-control" placeholder="Contraseña">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">                            
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" name="btnEntrar" class="btn btn-primary btn-block btn-flat">Entrar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>                
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->  
      
        }
        
    </body>
</html>
