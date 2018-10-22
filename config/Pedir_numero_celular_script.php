<?php

require_once("../conexion/conexion.php");
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

if (isset($_POST["idUsuario"])) {

    $idUsuario = $_POST["idUsuario"];
    $estadoPedirNumeroCelular = $_POST["estadoPedirNumeroCelular"];
    $EnviarSMSANumero = $_POST["EnviarSMSANumero"];
    $FechaSolicitud = date('Y-m-d h:i:s', time()); //$_POST["FechaSolicitud"];

    $sql = "";

    $verificaExiste = mysqli_query($conn, "select * from tbl_supervision_GetCelularNumber where idUsuario = '$idUsuario'");
    if ($verificaExiste) {
        if (mysqli_num_rows($verificaExiste) > 0) {
            
            $sql="update tbl_supervision_GetCelularNumber set estadoPedirNumeroCelular = '$estadoPedirNumeroCelular', FechaSolicitud = '$FechaSolicitud' where idUsuario = '$idUsuario'";
            
        } else {
            
            $sql = "insert into tbl_supervision_GetCelularNumber values (null, '$idUsuario', '$estadoPedirNumeroCelular', '$EnviarSMSANumero', '$FechaSolicitud' );";
        }
    }


    $resulInsert = mysqli_query($conn, $sql);

    if ($resulInsert) {
        $arrayName = array("success" => 1, "error" => "Ninguno.");
        echo json_encode($arrayName);
    } else {
        $arrayName = array("success" => 0, "error" => "No se ha podido insertar. error: " . mysqli_error($conn) . " Consulta: ". $sql);
        echo json_encode($arrayName);
    }
} else {
    $arrayName = array("success" => 0, "error" => "Parametros requeridos no encontrados.");
    echo json_encode($arrayName);
}
?>