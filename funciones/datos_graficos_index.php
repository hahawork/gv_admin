<?php

require_once './conexion/conexion.php';
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

class datos_graficos_index {

    public function getCantidadEntradas() {
        try {

            global $conn;
            $idUsuario = $_SESSION["sIdUsuario"];
            $NivelAcceso = $_SESSION["sNivelAcceso"];
            $idCliente = $_SESSION["sIdCliente"];


            switch ($NivelAcceso) {
                case 1: //usuario con acceso admin
                    $sqlCantUsuarios = "SELECT COUNT(*) as cantidad FROM `usuario` WHERE EstadoActivo = 1 AND `MarcaAsistenciaGPS` = 1";
                    
                    $sqlCantEntroHoy = "SELECT COUNT(*) as cantidad FROM `usuario_asistencia` "
                            . "WHERE `FechaRegistro` LIKE '" . date("Y-m-d") . "%' GROUP BY idUsuario";
                    break;
                
                case 3:
                    
                    $sqlCantUsuarios = "SELECT COUNT(*) as cantidad FROM `usuario` "
                        . "WHERE IdCliente = '$idCliente' AND EstadoActivo = 1 AND `MarcaAsistenciaGPS` = 1";
                    
                    $sqlCantEntroHoy = "SELECT COUNT(*) as cantidad FROM `usuario_asistencia` INNER JOIN "
                            . "usuario on usuario.idUsuario = usuario_asistencia.idUsuario "
                            . "WHERE usuario.IdCliente = '$idCliente' AND `FechaRegistro` LIKE '" . date("Y-m-d") . "%' "
                            . "GROUP BY usuario_asistencia.idUsuario";  
                    break;
                case 4:
                    
                    $sqlCantUsuarios = "SELECT COUNT(*) as cantidad FROM `usuario` "
                        . "WHERE (usuario.idUsuario = '$idUsuario' OR idSupervisor = '$idUsuario') AND EstadoActivo = 1 AND `MarcaAsistenciaGPS` = 1";
                    
                    $sqlCantEntroHoy = "SELECT COUNT(*) as cantidad FROM `usuario_asistencia` INNER JOIN "
                            . "usuario on usuario.idUsuario = usuario_asistencia.idUsuario "
                            . "WHERE (usuario.idUsuario = '$idUsuario' OR idSupervisor = '$idUsuario')  AND `FechaRegistro` LIKE '" . date("Y-m-d") . "%' "
                            . "GROUP BY usuario_asistencia.idUsuario";  
                    break;
                default:
                    break;
            }

            $resultCantUsuarios = mysqli_query($conn, $sqlCantUsuarios);
            $resultCantEntroHoy = mysqli_query($conn, $sqlCantEntroHoy);

            if ($resultCantUsuarios) {
                if ($resultCantEntroHoy) {
                    $row1 = mysqli_fetch_assoc($resultCantUsuarios);
                    $row2 = mysqli_fetch_assoc($resultCantEntroHoy);
                    $cantidadhoy = mysqli_num_rows($resultCantEntroHoy);
                    
                    $datos = "[";
                    $datos .= "{
                        value: " . $cantidadhoy . ",
                        label: 'Marcó entrada'
                    },";
                    $datos .= "{
                        value: " . ($row1["cantidad"] - $cantidadhoy) . ",
                        label: 'No marcó entrada'
                    }";
                    $datos .= "]";

                    return $datos;
                } 
            } 
        } catch (Exception $exc) {
            $datos = "[";
            $datos .= "{
                        value: 0,
                        label: 'Error: '$exc->getTraceAsString()
                    },";
            $datos .= "{
                        value: 0,
                        label: 'Error'
                    }";
            $datos .= "]";

            return;
            $datos;
            echo $exc->getTraceAsString();
        }
    }

}

?>