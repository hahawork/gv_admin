<?php

require_once("../../conexion/sw_conexion.php");
//Se crea nuevo objeto de la clase conexion para la base de datos del sist web
$cnn = new sw_conexion();
$conn = $cnn->sw_conectar();

if (isset($_REQUEST["idUsuario"]) and isset($_REQUEST["idMenuSeccion"]) and isset($_REQUEST["idMenuItem"])) {

    $idUsuario = $_REQUEST["idUsuario"];
    $idMenuSeccion = $_REQUEST["idMenuSeccion"];
    $idMenuItem = $_REQUEST["idMenuItem"];
    $EstadoActivo = $_REQUEST["EstadoActivo"];

    $sql = "";

    $sqlVerifExist = "SELECT * FROM `tbl_sistemaweb_usuario_seccion_item` WHERE idUsuario = '$idUsuario' AND idMenuSeccion = '$idMenuSeccion' AND idMenuItem = '$idMenuItem'";
    $resultVerifExis = mysqli_query($conn, $sqlVerifExist);
    
    if ($resultVerifExis and mysqli_num_rows($resultVerifExis) > 0) {
        
        $idMUI = mysqli_fetch_assoc($resultVerifExis);
        
        $sql = "UPDATE `tbl_sistemaweb_usuario_seccion_item` SET `EstadoActivo` = '$EstadoActivo' WHERE `tbl_sistemaweb_usuario_seccion_item`.`idUMI` = ". $idMUI["idUMI"];
    } else { // si aun no existe el registro
        
        $sql = "INSERT INTO `tbl_sistemaweb_usuario_seccion_item` (`idUMI`, `idUsuario`, `idMenuSeccion`, `idMenuItem`, `EstadoActivo`) "
                . "VALUES (NULL, '$idUsuario', '$idMenuSeccion', '$idMenuItem', '$EstadoActivo');";
    }

    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $arrayName = array('success' => "1", 'error' => "");
        echo json_encode($arrayName);
    } else {
        $arrayName = array('success' => "0", 'error' => "");
        echo json_encode($arrayName);
    }
}
?>