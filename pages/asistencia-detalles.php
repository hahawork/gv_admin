<?php
session_start();

require_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/customMainDrawer.php');


if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: ../login/index.php');
    exit;
}

require_once("../conexion/conexion.php");
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

$idSupervisor = 0;
$NombreSupervisor = 0;
$fechaConsulta = isset($_POST["rangoFechas"]) ? $_POST["rangoFechas"] : "";
$arrFechaConsulta = explode(",", trim($fechaConsulta, " "));

if (isset($_REQUEST['idSupervisor'])) {
    $NombreSupervisor = $_REQUEST['NombreSupervisor'];
    $idSupervisor = $_REQUEST['idSupervisor'];

    //si el id supervisor o el nombre del supervisor es menorque 1 entonces se regresa al index
    if ($idSupervisor <= 0 or strlen($NombreSupervisor) <= 0){
         header('Location: ../index.php');
         exit;
    }
} else {
    header('Location: ../index.php');
    exit;
}

function getDatesFromSuperv($idSupervisor, $rangoFecha) {

    global $conn;

    $sql = "SELECT date_format(FechaRegistro, '%Y-%m-%d') AS date_formatted FROM usuario_asistencia WHERE idUsuario = '$idSupervisor' AND FechaRegistro BETWEEN '$rangoFecha[0]' AND DATE_ADD('$rangoFecha[1]', INTERVAL 1 DAY)  GROUP BY date_formatted ORDER BY date_formatted DESC ";
    $resultFecha = mysqli_query($conn, $sql);

    if ($resultFecha) {
        return $resultFecha;
    } else {
        
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Mis Asistencias</title>
        <link rel="icon" type="image/png" href="../favicon.png">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="../dist/css/AdminLTE.css">
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css"> 
        <link href="../plugins/pace/pace.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
        <link rel="stylesheet" type="text/css" href="modal.css">

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <?php
            // funcion se encuentra en MainDrawer.php
            MainDrawer();
            ?>

            <div class="content-wrapper">

                <section class="content-header">
                    <h1><?php echo $NombreSupervisor; ?>, Asistencia<small>y Puntos de Venta</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Mis Registros</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- The Modal para ver la foto -->                            

                    <!-- row -->

                    <div class="row">                        
                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->                                        
                        <div class="box box-solid box-danger">
                            <div class="box-header with-border">  
                                <div class="col-sm-4 col-md-4">
                                    <h4 class="box-title">
                                        <span>Mi lista de Asistencia</span>                                        
                                    </h4>
                                </div>
                                <div class="col-sm-8 col-md-8">
                                    <form method="post" action="asistencia-detalles.php" class="form-inline">
                                        <!-- Date and time range -->
                                        <div class="form-group">                                            
                                            <div id="rangofecha" class="input-group">
                                                <label for="rangofecha" class="label-primary input-group-addon">Fecha</label>
                                                <input type="text" name="rangoFechas" value="Seleccione rango de fecha" class="btn btn-default" id="daterange-btn">

                                                <!--                                                volvemos a enviar el nombre y el id de usuario-->
                                                <input type="hidden" name="NombreSupervisor" value="<?= $NombreSupervisor ?>">
                                                <input type="hidden" name="idSupervisor" value="<?= $idSupervisor ?>">

                                            </div>

                                        </div>
                                        <!-- /.form group -->
                                        <input type="hidden" name="idSupervisor" value="<?php echo $idSupervisor; ?>">
                                        <input type="hidden" name="NombreSupervisor" value="<?php echo $NombreSupervisor; ?>">
                                        <input type="submit" class="btn btn-info" name="btnConsultar" value="Consultar">
                                    </form>
                                </div>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse in">
                                <div class="box-body" style="background : #333;">
                                    <div class="col-md-12 col-xs-12 col-lg-12" >
                                        <!-- The time line -->
                                        <ul class="timeline">
                                            <!-- timeline time label -->
                                            <?php
                                            try {
                                                if (isset($_POST["btnConsultar"]) and count($arrFechaConsulta) > 1) {

                                                    $a = getDatesFromSuperv($idSupervisor, $arrFechaConsulta);

                                                    while ($row = mysqli_fetch_array($a)) {

                                                        echo "<li class='time-label'><span class='bg-yellow'>" . $row['date_formatted'] . "</span>";

                                                        global $conn;
                                                        $Fecha = $row['date_formatted'];

                                                        $consAsist = "SELECT usuario_asistencia.idAsistencia, puntosdeventa.IdPdV, usuario.NombreUsuario,ifnull(puntosdeventa.NombrePdV, 'Punto Especial (No es Punto de Venta)') as NombrePdV , 
                                                                            date_format(usuario_asistencia.FechaRegistro, '%H:%i:%s') as Hora,
                                                                            (usuario_asistencia.CantGastosMovim + usuario_asistencia.CantGastosMovimTaxi + usuario_asistencia.CantGastosAlim + usuario_asistencia.CantGastosHosped + usuario_asistencia.CantGastosVario) as Gastos, 
                                                                            usuario_asistencia.FechaRegistro, usuario_asistencia.Observacion FROM usuario_asistencia INNER JOIN 
                                                                            usuario ON usuario.idUsuario = usuario_asistencia.idUsuario LEFT JOIN 
                                                                            puntosdeventa ON puntosdeventa.IdPdV = usuario_asistencia.IdPdV  
                                                                            WHERE date_format(usuario_asistencia.FechaRegistro, '%Y-%m-%d') = '$Fecha' AND usuario_asistencia.idUsuario = $idSupervisor ORDER BY usuario_asistencia.FechaRegistro DESC";

                                                        //echo '<script language="javascript">';
                                                        //echo 'alert("message successfully ".$consAsist.".")';
                                                        //echo '</script>';
                                                        $resAsis = mysqli_query($conn, $consAsist);
                                                        while ($row = mysqli_fetch_array($resAsis)) {
                                                            echo "<li>
                                                                            <i class='fa fa-arrow-right bg-blue'></i>

                                                                            <div class='timeline-item'>
                                                                            <span class='time'><i class='fa fa-clock-o'></i> " . $row['Hora'] . "</span>

                                                                            <h3 class='timeline-header'><a href='#'>
                                                                                    <i class='fa  fa-angle-double-right'></i> Ref: " . $row['IdPdV'] . " " . ($row['NombrePdV']) . "</a>.</h3>

                                                                            <div class='timeline-body col'>";

                                                            $consFotos = "SELECT * FROM asistencia_foto where idUsuAsist ='" . $row['idAsistencia'] . "'";
                                                            $resFoto = mysqli_query($conn, $consFotos);

                                                            $row_cnt = $resFoto->num_rows;
                                                            $RepetirViatico = 1;
                                                            if ($row_cnt > 0) {

                                                                while ($rf = mysqli_fetch_array($resFoto)) {

                                                                    if ($RepetirViatico == 1) {

                                                                        if (strlen($row['Observacion']) > 0) {
                                                                            echo($row['Gastos'] . " C$ Total en: " . ($row['Observacion']) . "<br>");
                                                                        } else {
                                                                            echo $row['Gastos'] . " C$ Total en: ** No especificado** <br>";
                                                                        }
                                                                    }
                                                                    $RepetirViatico = 2;

                                                                    echo '<style type="text/css">
                                                                                        @import url(https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css);
                                                                                        figure.snip0013 {
                                                                                          position: relative;
                                                                                          float: left;
                                                                                          overflow: hidden;
                                                                                          margin: 10px 1%;
                                                                                          min-width: 220px;
                                                                                          min-height: 220px;
                                                                                          max-width: 98%;
                                                                                          max-height: 220px;
                                                                                          width: 100%;
                                                                                          background: #000000;
                                                                                          text-align: center;
                                                                                        }
                                                                                        figure.snip0013 img {
                                                                                          max-width: 100%;
                                                                                          opacity: 1;
                                                                                          -webkit-transition: opacity 0.35s;
                                                                                          transition: opacity 0.35s;
                                                                                        }
                                                                                        figure.snip0013 > div {
                                                                                          left: 0;
                                                                                          right: 0;
                                                                                          top: 0;
                                                                                          bottom: 0;
                                                                                          height: 100%;
                                                                                          position: absolute;
                                                                                        }
                                                                                        figure.snip0013 > div a {
                                                                                          color: #ffffff;
                                                                                        }
                                                                                        figure.snip0013 > div a i {
                                                                                          font-size: 50px;
                                                                                          opacity: 0;
                                                                                          top: 50%;
                                                                                          position: relative;
                                                                                          -webkit-transform: translate3d(0, -50%, 0);
                                                                                          transform: translate3d(0, -50%, 0);
                                                                                          -webkit-transition-delay: 0s;
                                                                                          transition-delay: 0s;
                                                                                          display: inline-block;
                                                                                        }
                                                                                        figure.snip0013 > div a i.left-icon {
                                                                                          -webkit-transform: translate3d(0, -50%, 0);
                                                                                          transform: translate3d(0, -50%, 0);
                                                                                        }
                                                                                        figure.snip0013 > div a i.right-icon {
                                                                                          -webkit-transform: translate3d(0, -50%, 0);
                                                                                          transform: translate3d(0, -50%, 0);
                                                                                        }
                                                                                        figure.snip0013 > div::before {
                                                                                          position: absolute;
                                                                                          top: 30px;
                                                                                          right: 50%;
                                                                                          bottom: 30px;
                                                                                          left: 50%;
                                                                                          border-left: 1px solid rgba(255, 255, 255, 0.8);
                                                                                          border-right: 1px solid rgba(255, 255, 255, 0.8);
                                                                                          content: "";
                                                                                          opacity: 0;
                                                                                          background-color: #ffffff;
                                                                                          -webkit-transition: all 0.4s;
                                                                                          transition: all 0.4s;
                                                                                          -webkit-transition-delay: 0.3s;
                                                                                          transition-delay: 0.3s;
                                                                                        }
                                                                                        figure.snip0013:hover img {
                                                                                          opacity: 0.35;
                                                                                        }
                                                                                        figure.snip0013:hover > div i {
                                                                                          opacity: 0.9;
                                                                                          -webkit-transition: 0.3s ease-in-out;
                                                                                          transition: 0.3s ease-in-out;
                                                                                          -webkit-transition-delay: 0.3s;
                                                                                          transition-delay: 0.3s;
                                                                                        }
                                                                                        figure.snip0013:hover > div i.left-icon {
                                                                                          -webkit-transform: translate3d(-25%, -50%, 0);
                                                                                          transform: translate3d(-25%, -50%, 0);
                                                                                        }
                                                                                        figure.snip0013:hover > div i.right-icon {
                                                                                          -webkit-transform: translate3d(25%, -50%, 0);
                                                                                          transform: translate3d(25%, -50%, 0);
                                                                                        }
                                                                                        figure.snip0013:hover > div::before {
                                                                                          background: rgba(255, 255, 255, 0);
                                                                                          left: 30px;
                                                                                          right: 30px;
                                                                                          opacity: 1;
                                                                                          -webkit-transition-delay: 0s;
                                                                                          transition-delay: 0s;
                                                                                        }
                                                                                    </style>';

                                                                    echo "<div  style='width: 300px; display: inline-block; margin: 1px;'>
                                                                                            <label>" . ($rf['Comentario']) . "</label>
                                                                                            <button id='chkAgregPPtX' name='" . $rf['Foto_URL'] . "' onclick='AgregaraPowerPoint(" . $rf['idAsistFoto'] . ", this,\"" . ($row['NombrePdV']) . "\", \"" . ($rf['Comentario']) . "\");' class='ion-ios-plus-empty right-icon'></button>
                                                                                            <figure class='snip0013'>
                                                                                                <img src='../../../ws/" . $rf['Foto_URL'] . "' alt=''/>
                                                                                                <div>
                                                                                                        <a target='_blank' href='../../../ws/" . $rf['Foto_URL'] . "'><i class='ion-ios-eye-outline left-icon'></i></a>
                                                                                                        <a target='_blank' href='../../../ws/" . $rf['Foto_URL'] . "' download ='../../../ws" . $rf['Foto_URL'] . "'><i class='ion-ios-download-outline right-icon'></i></a>
                                                                                                </div>	                                                                                                
                                                                                            </figure>                                                                                            
                                                                                        </div>";
                                                                }
                                                            } else {
                                                                if (strlen($row['Observacion']) > 0) {
                                                                    echo($row['Gastos'] . " C$ Total en: " . ($row['Observacion']));
                                                                } else {
                                                                    echo $row['Gastos'] . " C$ Total en: ** No especificado**";
                                                                }
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    echo '<script>randomToast("danger", "error", "Seleccione una fecha.");</script>';
                                                }
                                            } catch (Exception $e) {
                                                echo 'Excepción capturada: ', $e->getMessage(), "\n";
                                            }
                                            ?>                                                            
                                            <li>
                                                <i class="fa fa-clock-o bg-gray"></i>
                                                <i class="ion-person-add"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>                                            
                        </div>                                                              
                    </div>
                    <!-- /.row -->

                    <div class="element">
                        <img class="img-circle" src="pptx_icono.png" width="80" height="80" onclick="GenerarPowerPointFile();">
                    </div>
                    <style type="text/css">
                        .element{ 
                            position:fixed; 
                            bottom: 2%; 
                            right:1%; }
                        </style>
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->

                <footer class="main-footer">
                <div class="pull-right hidden-xs" id="footer" >
                    <h6>.</h6>
                </div>
                <strong>&copy; 2017 <a href="../">Grupo Valor sa.</a>.</strong> Todos los derechos reservados.
            </footer>
        </div>


        <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script>
                            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../dist/js/app.min.js"></script>        
        <script src="../plugins/pace/pace.js" type="text/javascript"></script>
        <script src="../plugins/jQuery-Toast/jquery.toaster.js" type="text/javascript"></script>

        <!--        para generar el powerpoint-->        
<!--        <script src="../plugins/PptxGenJS/libs/jszip.min.js" type="text/javascript"></script>
<script src="../plugins/PptxGenJS/dist/pptxgen.js" type="text/javascript"></script>
<script src="../plugins/PptxGenJS/dist/pptxgen.bundle.js" type="text/javascript"></script>-->

        <!-- date-range-picker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="../plugins/daterangepicker/daterangepicker.js"></script>
        <script>
                            //priority: success, info, warning, danger
                            $(document).ajaxStart(function () {
                                Pace.restart();
                                randomToast('info', 'Espere', 'Mientras termina de cargar la página');
                            });
                            $(document).ready(function ()
                            {
                                randomToast('success', 'Ya', 'se ha terminado de cargar la página');
                            });
                            function randomToast(priority, title, message)
                            {
                                var priority = priority;// 'success';
                                var title = title;// '¡Que bien!';
                                var message = message;//'Ya he terminado de cargar!';

                                $.toaster({priority: priority, title: title, message: message});
                            }

                            $('#daterange-btn').daterangepicker(
                                    {
                                        ranges: {
                                            'Hoy': [moment(), moment()],
                                            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                            'Últ. 7 Días': [moment().subtract(6, 'days'), moment()],
                                            'Últ. 30 Dias': [moment().subtract(29, 'days'), moment()],
                                            'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                                            'Últ. mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                                        },
                                        startDate: moment().subtract(29, 'days'),
                                        endDate: moment()
                                    },
                                    function (start, end) {
                                        //$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                                        $('#daterange-btn').val(start.format('YYYY-MM-DD') + ',' + end.format('YYYY-MM-DD'));
                                    }
                            );
        </script>


        <script>

            var IdFotoAsistenciaAgregada = [];
            var ElementosPresentacionPPTX = [];
            var ElementosPresentacionPDV = [];
            var ElementosPresentacionComent = [];


            var chkAgregPPTX = document.getElementById("chkAgregPPtX");

            function AgregaraPowerPoint(idFoto, elemento, puntoVenta, Comentario) {
                if (!FnContieneArray(IdFotoAsistenciaAgregada, idFoto)) {

                    IdFotoAsistenciaAgregada.push(idFoto);
                    ElementosPresentacionPPTX.push("../../ws/" + elemento.name);
                    ElementosPresentacionPDV.push(puntoVenta);
                    ElementosPresentacionComent.push(Comentario);

                    elemento.className = "ion-android-checkbox right-icon";

                    console.log("Elementos agregados: " + elemento.name);
                    console.log("Elementos agregados: " + puntoVenta);
                    console.log("Elementos agregados: " + Comentario);

                } else {

                    var posicion = IdFotoAsistenciaAgregada.indexOf(idFoto)
                    console.log("posicion: " + posicion);
                    IdFotoAsistenciaAgregada.splice(posicion, 1)
                    ElementosPresentacionPPTX.splice(posicion, 1)
                    ElementosPresentacionPDV.splice(posicion, 1)
                    ElementosPresentacionComent.splice(posicion, 1)

                    /*removeElento(ElementosPresentacionPPTX, elemento.name)
                     removeElento(ElementosPresentacionPDV, puntoVenta)
                     removeElento(ElementosPresentacionComent, Comentario)*/
                    elemento.className = "ion-android-checkbox-outline-blank right-icon";
                }

                console.log(IdFotoAsistenciaAgregada);
                console.log(ElementosPresentacionPPTX);
                console.log(ElementosPresentacionPDV);
                console.log(ElementosPresentacionComent);
            }

            function removeElento(arr, item) {
                for (var i = arr.length; i--; ) {
                    if (arr[i] === item) {
                        arr.splice(i, 1);
                        console.log("Elementos removido: " + item);
                        return;
                    }
                }
            }

            function FnContieneArray(arr, obj) {
                var i = arr.length;
                while (i--) {

                    if (arr[i] === obj) {
                        return true;
                    }
                }
                return false;
            }

            function GenerarPowerPointFile() {
                if (ElementosPresentacionPPTX.length > 0) {

                    window.localStorage.setItem("ElementosPresentacionPPTX", JSON.stringify(ElementosPresentacionPPTX)); // Saving
                    window.localStorage.setItem("ElementosPresentacionPDV", JSON.stringify(ElementosPresentacionPDV)); // Saving
                    window.localStorage.setItem("ElementosPresentacionComent", JSON.stringify(ElementosPresentacionComent)); // Saving

                    window.location.href = 'generar-pptx1.php';

                } else {
                    randomToast('danger', 'No Permitido', 'Seleccione al menos 1 imagen');
                }
            }
        </script>
    </body>
</html>
