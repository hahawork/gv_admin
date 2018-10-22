<?php

require_once("../../conexion/sw_conexion.php");
//Se crea nuevo objeto de la clase conexion para la base de datos del sist web
$cnn = new sw_conexion();
$conn = $cnn->sw_conectar();

if (isset($_REQUEST["idMenuSecciones"])) {
    $idMenuSecciones = $_REQUEST["idMenuSecciones"];
    $NombreSeccion = $_REQUEST["NombreSeccion"];
    $ClaseParaIcono = $_REQUEST["ClaseParaIcono"];
    $PosicionSeccion = $_REQUEST["PosicionSeccion"];
    $EstadoActivo = $_REQUEST["EstadoActivo"];

    if ($idMenuSecciones > 0) { // ya existe el elemento
        $sql = "UPDATE `tbl_sistemaweb_menu_secciones` "
                . "SET NombreSeccion = '$NombreSeccion', ClaseParaIcono = '$ClaseParaIcono', PosicionSeccion = '$PosicionSeccion', EstadoActivo = '$EstadoActivo' "
                . "WHERE idMenuSecciones = $idMenuSecciones";

        $resultUpdate = mysqli_query($conn, $sql);
        if ($resultUpdate) {
            $arrayName = array("success" => "1");
            echo json_encode($arrayName);
        }
    } else {   //si no existe la seccion
        $sql = "INSERT INTO tbl_sistemaweb_menu_secciones() "
                . "VALUES ('NULL', '$NombreSeccion', '$ClaseParaIcono', '$PosicionSeccion', '$EstadoActivo')";

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
