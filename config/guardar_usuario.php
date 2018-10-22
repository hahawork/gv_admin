<?php

require_once ("../conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();

if (isset($_REQUEST['IdCliente'])) {
    try {

        $id_cliente = $_REQUEST['IdCliente'];
        $rol = $_REQUEST['Rol'];
        $id_usuario = $_REQUEST['IdUsuario'];
        $nombre = $_REQUEST['NombreUsuario'];
        $email = $_REQUEST['EmailUC'];
        $pass = $_REQUEST['PasswordUC'];
        $img = $_REQUEST['imgFotoPerfilUrl'];
        $acceso = $_REQUEST['NivelAcceso'];
        $pagina = $_REQUEST['PaginaInicio'];

        $pass_encriptada = md5($pass);
        $Guardado = 0;
        $error = "";
        $verificarExistencia = "SELECT * FROM `LoginusuarioSesion` where EmailUC = '" . $email . "' ";
        echo "<script>console.log('$verificarExistencia');</script>";

        $Resul_verificarExist = mysqli_query($conn, $verificarExistencia);
        $error = $error . "error: " . mysqli_error($conn);
        echo "<script>console.log('$error');</script>";

        if ($Resul_verificarExist) {
            if (mysqli_num_rows($Resul_verificarExist) > 0) {
                $error = "el correo ya esta registrado.";
                $arrayName = array('Guardado' => 0, 'error' => "$error " );
                echo json_encode($arrayName);
            } else {
                $query = "INSERT INTO LoginusuarioSesion(iduc,IdCliente,Rol,IdUsuario,NombreUsuario,EmailUC,PasswordUC,imgFotoPerfilUrl,NivelAcceso,PaginaInicio)"
                        . " VALUES ('null','$id_cliente', '$rol','$id_usuario','$nombre','$email','$pass_encriptada','$img','$acceso','$pagina')";


                $resultado = mysqli_query($conn, $query);

                $error = $error . mysqli_error($conn);

                if ($resultado) {

                    $Guardado = 1;
                    $arrayName = array('Guardado' => $Guardado, 'error' => "$error");
                    echo json_encode($arrayName);
                }
            }
        } else {
            $arrayName = array('Guardado' => 0, 'error' => "no sea a realizado la verificacion " . $e);
            echo json_encode($arrayName);
        }
      
    } catch (Exception $e) {
        $arrayName = array('Guardado' => 0, 'error' => "no parametros " . $e);
        echo json_encode($arrayName);
    }
} else {
    $arrayName = array('Guardado' => 0, 'error' => "no parametros " . $_REQUEST['iduc']);
    echo json_encode($arrayName);
}
?>

