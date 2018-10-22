<?php

// Inicia la sesion
session_start();

date_default_timezone_set("America/Managua");

// si aun no ha iniciado sesion
/*
  if (!isset($_SESSION['sUserId'])) {

  } else {   // si ya inicio sesion
  header("Location: ../" . $_SESSION['sPaginaInicio']);
  }
 */
if (isset($_POST['txtemail']) and isset($_POST['txtpassword'])) {


    $txtUsuario = isset($_POST['txtemail']) ? $_POST['txtemail'] : null;
    $Password = isset($_POST['txtpassword']) ? $_POST['txtpassword'] : null;

    $response = array();

    try {

        require_once("../../conexion/conexion.php");
        $cnn = new conexion();
        $conn = $cnn->conectar();

        $sql = "SELECT * FROM LoginusuarioSesion as lus INNER JOIN "
                . "clientes as cl ON lus.IdCliente = cl.IdCliente "
                . "WHERE EmailUC ='" . $txtUsuario . "' AND PasswordUC = '" . md5($Password) . "' AND EstadoActivo = 1 ";

        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if ($result) {

            if (mysqli_num_rows($result) > 0) {

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

                if (isset($_SESSION["sRedireccionar"]) and strlen($_SESSION["sRedireccionar"]) > 0) {
                    $response["success"] = 1;
                    $response["direccionar"] = "../../" . $_SESSION['sRedireccionar'];
                    $_SESSION["sRedireccionar"] = NULL;
                    echo json_encode($response);
                    exit;
                } else {

                    $response["success"] = 1;
                    $response["direccionar"] = "../" . $_SESSION['sPaginaInicio'];
                    echo json_encode($response);

                    //header("Location: ../" . $_SESSION['sPaginaInicio']);
                    exit;
                }
            } else {
                $response["success"] = 0;
                $response["message"] = "No se ha encontrado el usuario o verifique sus datos.";
                echo json_encode($response);
            }
        } else {
            $response["success"] = 0;
            $response["message"] = "Verifique sus datos." . mysqli_error($conn);
            echo json_encode($response);
        }
    } catch (Exception $exc) {
        $response["success"] = 0;
        $response["message"] = $exc->getTraceAsString();
        echo json_encode($response);
    }
} else {
    $response = array();
    $response["success"] = 0;
    $response["message"] = "Parámetros requeridos no encontrados";
    echo json_encode($response);
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}
