<?php

session_start();

require_once ("../conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso =$_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];

$retorno = "";
$sql = "";

if ($NivelAcceso == 1) {
    $sql = "SELECT `idUsuario`, `NombreUsuario`, clientes.RazonSocial FROM `usuario` INNER JOIN clientes on usuario.IdCliente = clientes.IdCliente WHERE EstadoActivo = 1  AND MarcaAsistenciaGPS = 1 ORDER BY `usuario`.`NombreUsuario`";
}
if ($NivelAcceso == 3) {
    $sql = "SELECT `idUsuario`, `NombreUsuario`, clientes.RazonSocial FROM `usuario` INNER JOIN clientes on usuario.IdCliente = clientes.IdCliente WHERE usuario.`IdCliente`= '$idCliente' AND EstadoActivo = 1 AND MarcaAsistenciaGPS = 1  
ORDER BY `usuario`.`NombreUsuario`";
}

try {

    $result = mysqli_query($conn, $sql);

    if ($result) {

        while ($row = mysqli_fetch_array($result)) {

            $date = date("Y-m-d");
            $idcl = $row['idUsuario'];
            $tieneAsistencia = 0;
            $row2 = null;

            $consutAsistencia = "SELECT *, date_format(FechaRegistro, '%H:%i:%s') as Hora FROM `usuario_asistencia` WHERE idUsuario = '$idcl' and FechaRegistro LIKE '$date%' order BY FechaRegistro";
            $resultAsistencia = mysqli_query($conn, $consutAsistencia);

            if ($consutAsistencia) {
                if (mysqli_num_rows($resultAsistencia) > 0) {

                    $tieneAsistencia = 1;

                    $row2 = mysqli_fetch_array($resultAsistencia);
                } else {

                    $tieneAsistencia = 0;
                }
            }

            $nombre = ($row['NombreUsuario']);
            $marca = ($row['RazonSocial']) ;
            $fecha = $tieneAsistencia == 1 ? $row2['Hora'] : "N/D";
            $color = $tieneAsistencia == 1 ? 'style="background: #b9f6ca;"' :'style="background: #ff8a80;"';
            
            
            $retorno = $retorno . "<tr><td>$nombre</td><td>$marca</td><td $color>$fecha</td></tr>";
            
        }

        $arrayName = array(
            'success' => '1',
            'table' => $retorno,
            'error' => ""
        );
        echo json_encode($arrayName);
    } else {

        $arrayName = array(
            'success' => '0',
            'table' => '',
            'error' => mysqli_errno($cnn)
        );
        echo json_encode($arrayName);
    }
} catch (Exception $exc) {
    $arrayName = array(
        'success' => '0',
        'table' => '',
        'error' => $exc->getTraceAsString()
    );
    echo json_encode($arrayName);
}
?>
