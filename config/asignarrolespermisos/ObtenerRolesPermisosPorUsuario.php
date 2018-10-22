<?php

require_once("../../conexion/sw_conexion.php");
//Se crea nuevo objeto de la clase conexion para la base de datos del sist web
$cnn = new sw_conexion();
$conn = $cnn->sw_conectar();

if (isset($_REQUEST["idUsuario"])) {

    $idUsuario = $_REQUEST["idUsuario"];

    if ($idUsuario > 0) {

        $response="";

        $sql = "SELECT * FROM `tbl_sistemaweb_usuario_seccion_item` WHERE idUsuario = '$idUsuario' and EstadoActivo = 1";
        $result = mysqli_query($conn, $sql);
        if ($result and mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {

                $response .= $row["idMenuSeccion"] . "_" . $row["idMenuItem"] . ",";                
            }
            echo ($response);
        } 
    } 
}
?>