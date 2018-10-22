<?php

require_once("../../conexion/sw_conexion.php");
//Se crea nuevo objeto de la clase conexion para la base de datos del sist web
$cnn = new sw_conexion();
$conn = $cnn->sw_conectar();

if (isset($_REQUEST["idMenuItem"])) {
    $idMenuItem = $_REQUEST["idMenuItem"];
    $idMenuSeccion = $_REQUEST["idMenuSeccion"];
    $NombreMenuItem = $_REQUEST["NombreMenuItem"];
    $ClaseIconoItem = $_REQUEST["ClaseIconoItem"];
    $PosicionItem = $_REQUEST["PosicionItem"];
    $ClicRedirec = $_REQUEST["ClicRedirec"];
    $EstadoActivo = $_REQUEST["EstadoActivo"];

    if ($idMenuItem > 0) { // ya existe el elemento
        $sql = "UPDATE `tbl_sistemaweb_menu_items` "
                . "SET NombreMenuItem = '$NombreMenuItem', ClaseIconoItem = '$ClaseParaIcono', PosicionItem = '$PosicionItem', ClicRedirec = '$ClicRedirec', EstadoActivo = '$EstadoActivo' "
                . "WHERE idMenuSeccion = $idMenuSeccion";

        $resultUpdate = mysqli_query($conn, $sql);
        if ($resultUpdate) {
            $arrayName = array("success" => "1");
            echo json_encode($arrayName);
        }
    } else {   //si no existe la seccion
        $sql = "INSERT INTO `tbl_sistemaweb_menu_items` (`idMenuItem`, `idMenuSeccion`, `NombreMenuItem`, `ClaseIconoItem`, `PosicionItem`, `ClicRedirec`, `EstadoActivo`) "
                . "VALUES (NULL, '$idMenuSeccion', '$NombreMenuItem', '$ClaseIconoItem', '$PosicionItem', '$ClicRedirec', '$EstadoActivo');";

        $resultInsert = mysqli_query($conn, $sql);
        if ($resultInsert) {
            $arrayName = array("success" => "1");
            echo json_encode($arrayName);
        }
    }
} else {
    $arrayName = array("success" => "0", "error" => "Parámetro(s) requerido(s) no encontrado(s).");
    echo json_encode($arrayName);
}
?>
