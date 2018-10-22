<?php

require_once '../conexion/conexion.php';
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

if (isset($_POST["idUsuario"]) and
        isset($_POST["PdV"]) and
        isset($_POST["date_start"])
) {

    try {
        $idUsuario = mysqli_real_escape_string($conn, $_POST["idUsuario"]);
        $Usuario = mysqli_real_escape_string($conn, $_POST["Usuario"]);
        $diaSemana = mysqli_real_escape_string($conn, $_POST["diaSemana"]);
        $backgroundcolor = mysqli_real_escape_string($conn, $_POST["backgroundcolor"]);
        $bordercolor = mysqli_real_escape_string($conn, $_POST["bordercolor"]);
        $fechaReg = mysqli_real_escape_string($conn, $_POST["fechaReg"]);
        $idPdV = mysqli_real_escape_string($conn, $_POST["idPdV"]);
        $PdV = mysqli_real_escape_string($conn, $_POST["PdV"]);
        $title = mysqli_real_escape_string($conn, $_POST["title"]);
        $date_start = mysqli_real_escape_string($conn, $_POST["date_start"]);
        $date_end = mysqli_real_escape_string($conn, $_POST["date_end"]);
        $TodoElDia = mysqli_real_escape_string($conn, $_POST["TodoElDia"]);
        $url = mysqli_real_escape_string($conn, $_POST["url"]);
        $estadoActivo = mysqli_real_escape_string($conn, $_POST["estadoActivo"]);

        //verificando si el esta activo
        $sqlverificador = "select * from usuario where idUsuario = '$idUsuario' AND EstadoActivo = 1";
        // se realiza la consulta
        $resverificador = mysqli_query($conn, $sqlverificador);
        // si se realizo la conslta
        if ($resverificador) {
            // se  el numero de filas es igual a cero es por que no existe
            if (mysqli_num_rows($resverificador) > 0) {

                $sqlinsertar = "INSERT INTO tbl_horario_enc VALUES ("
                        . "NULL, "
                        . "'$idUsuario', "
                        . "'$diaSemana', "
                        . "'$backgroundcolor', "
                        . "'$bordercolor', "
                        . "'$fechaReg', "
                        . "'$idPdV', "
                        . "'$PdV', "
                        . "'$title', "
                        . "'$date_start', "
                        . "'$date_end', "
                        . "'$TodoElDia', "
                        . "'$url', "
                        . "'$estadoActivo'"
                        . ")";
                $resinsertar = mysqli_query($conn, $sqlinsertar);
                if ($resinsertar) {

                    $nameValue = array('success' => 1, 'message' => "Se ha registrado con éxito.");
                    echo json_encode($nameValue);
                } else {

                    $nameValue = array('success' => 0, 'error' => "No se ha podido guardar " . mysqli_error($conn));
                    echo json_encode($nameValue);
                }
            } else {

                $nameValue = array('success' => 0, 'error' => "El usuario no existe, o no está activo.");
                echo json_encode($nameValue);
            }
        } else { //si no se realizo la consulta
            $nameValue = array('success' => 0, 'error' => "Ha saltado:" . mysqli_error($conn));
            echo json_encode($nameValue);
        }
    } catch (Exception $exc) {

        echo json_encode(array("success" => 0, "error" => $exc->getTraceAsString()));
    }
} else {
    echo json_encode(array("success" => 0, "error" => "Parametros no encontrados."));
}
?>