<?php
// Inicia la sesion
session_start();

$Servidor = 'http://' . $_SERVER['HTTP_HOST'] . "/admin/";


// si aun no ha iniciado sesion
if (!isset($_SESSION['sUserId'])) {
    
}else {   // si ya inicio sesion  
    
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
            }
            else {
                header("Location: " . $Servidor . $_SESSION['sPaginaInicio']);
                exit;
            }                       
        }
    } else {
        $errores[] = "Verifique sus datos.";
        $login_error = true;
    }
}

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

?>
<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>Iniciar Sesion</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


        <style>
            /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
            @import url(https://fonts.googleapis.com/css?family=Exo:100,200,400);
            @import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);

            body{
                width:100%;
                margin:auto;
                min-width:600px;
                max-width:2000px
            }

            .body{
                position: absolute;
                top: 0px;
                left: 0px;
                right: 0px;
                bottom: 0px;
                width: auto;
                height: auto;
                background-image: url(css/fondo.png);
                background-size: cover;
                -webkit-filter: blur(2px);
                z-index: 0;
            }

            .logo{
                position: absolute;
                top: calc(50% - 180px);
                left: calc(50% - 95px);
                height: 180px;
                width: 380px;
                padding: 10px;
                z-index: 2;
            }

            .login{
                position: absolute;
                top: calc(50% - 50px);
                left: calc(50% - 145px);
                height: 150px;
                width: 350px;
                padding: 10px;
                z-index: 2;
            }

            input[type=email]{
                width: 250px;
                height: 30px;
                background: transparent;
                border: 1px solid rgba(255,255,255,0.6);
                border-radius: 2px;
                color: #fff;
                font-family: 'Exo', sans-serif;
                font-size: 16px;
                font-weight: 400;
                padding: 4px;
                font-family: sans-serif;
            }

            input[type=password]{
                width: 250px;
                height: 30px;
                background: transparent;
                border: 1px solid rgba(255,255,255,0.6);
                border-radius: 2px;
                color: #fff;
                font-family: 'Exo', sans-serif;
                font-size: 16px;
                font-weight: 400;
                padding: 4px;
                margin-top: 10px;
                font-family: sans-serif;
            }

            .login input[type=submit]{
                width: 260px;
                height: 35px;
                background: #fff;
                border: 1px solid #fff;
                cursor: pointer;
                border-radius: 2px;
                color: #a18d6c;
                font-family: 'Exo', sans-serif;
                font-size: 16px;
                font-weight: 400;
                padding: 6px;
                margin-top: 10px;

            }

            .login input[type=submit]:hover{
                opacity: 0.8;
            }

            .login input[type=submit]:active{
                opacity: 0.6;
            }

            .login input[type=email]:focus{
                outline: none;
                border: 1px solid rgba(255,255,255,0.9);
            }

            .login input[type=password]:focus{
                outline: none;
                border: 1px solid rgba(255,255,255,0.9);
            }

            .login input[type=submit]:focus{
                outline: none;
            }

            ::-webkit-input-placeholder{
                color: rgba(255,255,255,0.6);
            }

            ::-moz-input-placeholder{
                color: rgba(255,255,255,0.6);
            }

        </style>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

    </head>

    <body>
        <div class="body"></div>
        <div class="logo">
            <img src="css/ic_logo.png" style="width: 160px;height: 100px;">

        </div>

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

            <div class="login">
                <input type="email" name="txtemail" id="txtemail" placeholder="correo" value="<?php echo $txtUsuario; ?>" required="required" />
                <input type="password" name="txtpassword" placeholder="Contraseña" required="required"/>

                <input type="submit" name="btnEntrar" value="Entrar" />

            </div>
        </form>

        <script src='http://codepen.io/assets/libs/fullpage/jquery.js'></script>

        <script src="js/index.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
        <script language="Javascript">
            $(document).ready(function () {
                $('input').keypress(function (e) {
                    var s = String.fromCharCode(e.which);

                    if ((s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey) ||
                            (s.toUpperCase() !== s && s.toLowerCase() === s && e.shiftKey)) {
                        if ($('#capsalert').length < 1)
                            $(this).after('<b style="color: #f00;" id="capsalert"><br>¡Bloqueo de mayúscula Activado!</b>');
                    } else {
                        if ($('#capsalert').length > 0)
                            $('#capsalert').remove();
                    }
                });
            });
        </script>


    </body>
</html>