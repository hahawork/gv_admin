<?php

function getURLPrecios($cliente) {

    global $Servidor;
    $URL = "";
    switch ($cliente) {
        case 7: // Nivea            
            $URL = $Servidor . 'tables/ReportePrecios_formarto_nivea.php';
            break;

        default:
            $URL = $Servidor . 'tables/ReportePrecios.php';
            break;
    }
    return $URL;
}

function getURLFechasVencimiento($cliente) {

    global $Servidor;
    $URL = "";
    switch ($cliente) {
        case 1: // Cafe soluble       
            $URL = $Servidor . 'tables/ReporteFechaVencimientos_formato_cssa.php';
            break;

        default:
            $URL = $Servidor . 'tables/ReporteFechaVencimientos.php';
            break;
    }
    return $URL;
}

function fnGetListaUsuariosMostrarPantallaPrincipal($NivelAcceso, $idCliente, $idUsuario) {

    try {
        require_once("conexion/conexion.php");
        $cnn = new conexion(); //Se crea nuevo objeto de la clase conexion
        $conn = $cnn->conectar();

        $consultasql = "";

        if ($NivelAcceso == 1) {
            $consultasql = "SELECT * FROM vw_listausuariosmarcandoasistencia";
        } elseif ($NivelAcceso == 3) {
            $consultasql = "SELECT * FROM vw_listausuariosmarcandoasistencia WHERE IdCliente = '$idCliente'";
        } elseif ($NivelAcceso == 4) {
            $consultasql = "SELECT * FROM vw_listausuariosmarcandoasistencia WHERE idUsuario = '$idUsuario' OR idSupervisor = '$idUsuario'";
        }

        $resultado = mysqli_query($conn, $consultasql);

        return $resultado;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
}

function fnGetListaUsuarioXCliente($idCliente, $NivelAcceso, $idUsuario) {

    require_once("conexion/conexion.php");
    $cnn = new conexion(); //Se crea nuevo objeto de la clase conexion
    $conn = $cnn->conectar();

    if ($NivelAcceso == 1) {
        $consultasql = "SELECT * FROM vw_listausuariosmarcandoasistencia WHERE IdCliente = '$idCliente'";
    }
    if ($NivelAcceso == 3){
        $consultasql = "SELECT * FROM vw_listausuariosmarcandoasistencia WHERE IdCliente = '$idCliente'";
    }
    if ($NivelAcceso == 4){
        $consultasql = "SELECT * FROM vw_listausuariosmarcandoasistencia WHERE idUsuario = $idUsuario OR idSupervisor = $idUsuario";
    }
    $resultado = mysqli_query($conn, $consultasql);
    $html = "";

    if ($resultado) {
        $html = '<div class="MultiCarousel" data-items="3,6,8,12" data-slide="1" id="MultiCarousel"  data-interval="1000">
            <div class="MultiCarousel-inner">';
        while ($row = mysqli_fetch_assoc($resultado)) {
            if ($idCliente == $row["IdCliente"]) {

                $html .= '<div class="item" style="border: #000 solid 1px; min-width: 70px; max-width: 100px; margin: 1px;">
                    <a href="pages/asistencia-detalles.php?idSupervisor=' . $row['idUsuario'] . '&NombreSupervisor=' . $row['NombreUsuario'] . '">
                        <div class="pad15">
                        <label style="overflow-y: hidden; height: 20px;">' . $row["NombreUsuario"] . '</label><br/>
                        <img style="width: 100%; height: auto;" src="' . $row['Foto_URL'] . '"  alt="Image">
                    </div>
                </a>
            </div>';

                //echo "<script>console.log('" . $row['NombreUsuario'] . "')</script>";
            }
        }
        $html .= '</div>
        <button class="btn btn-primary leftLst"><</button>
        <button class="btn btn-primary rightLst">></button>
        </div>';
    }

    return $html;
}

function getPuntosMarcadosHoy() {

    //primero consulta los usuarios activos
    $sqlConsActivos = "SELECT * FROM `usuario` WHERE EstadoActivo = 1 AND MarcaAsistenciaGPS = 1";
    if ($resultUsua = mysqli_query($conn, $sqlConsActivos)) {
        while ($row = mysqli_fetch_assoc($resultUsua)) {
            
        }
    }
}

?>