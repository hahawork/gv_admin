<?php

require_once ("../conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();

if (isset($_REQUEST['idUsuario'])) {
    try {

        $OPCION_MENSAJE_AL_USUARIO = 1;
        $OPCION_PERMITIR_GUARDAR_PDV_NUEVO = 2;

        $idUsuario = isset($_REQUEST['idUsuario']) ? $_REQUEST['idUsuario'] : 0;
        $opcionEnv = isset($_REQUEST['opcionEnv']) ? $_REQUEST['opcionEnv'] : NULL;

        //Estas son para mensajes al usuario
        $Mensaje = isset($_REQUEST['Mensaje']) ? $_REQUEST['Mensaje'] : NULL;
        $URLimage = isset($_REQUEST['URLimage']) ? $_REQUEST['URLimage'] : NULL;
        $Fecha = isset($_REQUEST['Fecha']) ? $_REQUEST['Fecha'] : NULL;
        $EstadoVisto = isset($_REQUEST['EstadoVisto']) ? $_REQUEST['EstadoVisto'] : NULL;

        //Estas son para permisos de guardar puntos de venta
        $Permitir = isset($_REQUEST['Permitir']) ? $_REQUEST['Permitir'] : NULL;
        $Cantidad = isset($_REQUEST['Cantidad']) ? $_REQUEST['Cantidad'] : NULL;

        $error = "";
        $query = "";

        if ($opcionEnv == $OPCION_MENSAJE_AL_USUARIO and $idUsuario > 0) {
            //verifica si ya existe un registro en la tabla con el usuario
            $resUser = mysqli_query($conn, "select * from appmensajeUsuario where idUsuario = $idUsuario");
            //si se obtiene un resultado mayor que cero
            if (mysqli_num_rows($resUser) > 0) {
                //se acttualia el registro si ya existe el usuario
                $query = "update appmensajeUsuario set Mensaje = '$Mensaje', URLimage = '$URLimage', Fecha = '$Fecha', EstadoVisto = '$EstadoVisto' WHERE idUsuario = '$idUsuario'";
            } else {
                //si no existe un regisro con este usuario, se inserta
                $query = "INSERT INTO  appmensajeUsuario()"
                        . " VALUES ('null','$idUsuario', '$Mensaje','$URLimage','$Fecha','$EstadoVisto')";
            }
            
            $resultado = mysqli_query($conn, $query);
            if ($resultado) {               
                echo json_encode(array('Guardado' => 1, 'error' => ""));
            } else {
                echo json_encode(array('Guardado' => 0, 'error' => "Error: " . mysqli_error($conn)));
            }
        }// fin guardar mensaje al usuario
        
        if ($opcionEnv == $OPCION_PERMITIR_GUARDAR_PDV_NUEVO and $idUsuario > 0) {
            
            //verifica si ya existe un registro en la tabla con el usuario
            $resUser = mysqli_query($conn, "select * from tbl_supervision_GetPermitNuevoPdV where IdUsuario = $idUsuario");
            //si se obtiene un resultado mayor que cero
            if (mysqli_num_rows($resUser) > 0) {
                //se acttualia el registro si ya existe el usuario
                $query = "update tbl_supervision_GetPermitNuevoPdV set Permitir = '$Permitir', CantidadPdvPermitido = '$Cantidad' WHERE IdUsuario = '$idUsuario'";
            } else {
                //si no existe un regisro con este usuario, se inserta
                $query = "INSERT INTO  tbl_supervision_GetPermitNuevoPdV()"
                        . " VALUES ('null','$idUsuario', '$Permitir','$Cantidad')";
            }
            
            $resultado = mysqli_query($conn, $query);
            if ($resultado) {               
                echo json_encode(array('Guardado' => 1, 'error' => ""));
            } else {
                echo json_encode(array('Guardado' => 0, 'error' => "Error: " . mysqli_error($conn)));
            }
            
        }
        
    } catch (Exception $e) {
        $arrayName = array('Guardado' => 0, 'error' => "error: " . $e);
        echo json_encode($arrayName);
    }
} else {
    $arrayName = array('Guardado' => 0, 'error' => "no parametros ");
    echo json_encode($arrayName);
}
?>
