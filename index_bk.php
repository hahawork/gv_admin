<?php
session_start();

$Servidor = 'https://' . $_SERVER['HTTP_HOST'] . "/admin/"; //$_SERVER['PHP_SELF'] . "/admin/";// obtiene la ruta del DNS : http://grupovalor.com.ni/

include_once ("funciones_varias.php");
include_once ("conexion/conexion.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/customMainDrawer.php');
include_once ("funciones/datos_graficos_index.php");

//se instancia la clase con las funciones de loos datos
$datos_graficos = new datos_graficos_index();

//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];


if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: login/index.php');
    exit;
}

$admin = 'disabled';


if ($NivelAcceso == 1) {
    $admin = '';
}

$mapzoom = 8;

//$sql = mysqli_query($conn, "CREATE TEMPORARY TABLE nombreTablaTemporal SELECT usuario.idUsuario,usuario.NumTelefono, usuario.NombreUsuario, puntosdeventa.IdPdV, puntosdeventa.NombrePdV, FechaRegistro, Observacion, puntosdeventa.LocationGPS, usuario.LabelPin, usuario.IdCliente FROM `usuario_asistencia` INNER JOIN usuario on usuario_asistencia.idUsuario = usuario.idUsuario INNER JOIN puntosdeventa on puntosdeventa.IdPdV = usuario_asistencia.IdPdV WHERE usuario.EstadoActivo = 1 ORDER BY FechaRegistro DESC");

$consulta = ""; // "SELECT * FROM nombreTablaTemporal WHERE idUsuario NOT IN (6,20) and IdCliente = '$idCliente' GROUP BY idUsuario ORDER BY FechaRegistro DESC";

mysqli_query($conn, "CREATE TEMPORARY TABLE nombreTablaTemporal SELECT usuario.idUsuario,usuario.NumTelefono, usuario.NombreUsuario, idSupervisor , puntosdeventa.IdPdV, puntosdeventa.NombrePdV, FechaRegistro, Observacion, puntosdeventa.LocationGPS, usuario.LabelPin, usuario.IdCliente FROM `usuario_asistencia` INNER JOIN usuario on usuario_asistencia.idUsuario = usuario.idUsuario INNER JOIN puntosdeventa on puntosdeventa.IdPdV = usuario_asistencia.IdPdV  WHERE usuario.EstadoActivo = 1 ORDER BY FechaRegistro DESC;");
if ($NivelAcceso == 1) {

    $consulta = "SELECT * FROM nombreTablaTemporal GROUP BY idUsuario ORDER BY FechaRegistro DESC;";
}

if ($NivelAcceso == 3) {

    $consulta = "SELECT * FROM nombreTablaTemporal WHERE IdCliente = $idCliente GROUP BY idUsuario ORDER BY FechaRegistro DESC;";
}

if ($NivelAcceso == 4) {

    $consulta = "SELECT * FROM nombreTablaTemporal WHERE idUsuario = $idUsuario OR idSupervisor = $idUsuario GROUP BY idUsuario ORDER BY FechaRegistro DESC;";
}
//$consulta = "CALL spObtenerUltimoPdVMarcadoMapa($NivelAcceso, $idCliente, $idUsuario)";

$sql2 = mysqli_query($conn, $consulta) or die(mysqli_error($conn));

$z = array();
$indice = 0;

$VariarLong = 0.00006;

while ($row2 = mysqli_fetch_array($sql2)) {
    try {
        $y = array();

        $coordenada = $row2["LocationGPS"];
        $myArray = explode(',', $coordenada);


        if ($row2["IdPdV"] == 29) {
            $coordenadaepe = explode(":", $row2["Observacion"]);
            $myArray = explode(",", $coordenadaepe[1]);
        }

        if (sizeof($myArray) == 2) {
            $y[] = ($row2["NombreUsuario"]);
            $y[] = $myArray[0];
            $y[] = $myArray[1] + $VariarLong;
            $y[] = $row2["FechaRegistro"];
            $y[] = ($row2["NombrePdV"]);
            $y[] = $mapzoom;
            $y[] = $row2["LabelPin"];
            $y[] = $row2["idUsuario"];
            $z[$indice] = $y;
            $indice++;

            if ($row2["IdPdV"] == 27) {
                $VariarLong = $VariarLong - 0.00003;
            }
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
}

function getDateDiff($dateSave) {
    $managua = new DateTimeZone("America/Managua");
    $datetime1 = new DateTime($dateSave);
    $datetime2 = new DateTime("now", $managua);
    $difference = $datetime1->diff($datetime2);

    return $difference;

    /* echo 'Difference: '.$difference->y.' years, ' 
      .$difference->m.' months, '
      .$difference->d.' days, '
      .$difference->h.' hours, '
      .$difference->i.' minutes, '
      .$difference->s.' seconds<br>';
      print_r($difference);

      echo $datetime2 -> format("Y-m-d H:i"). ",---" . $difference ->d;//->format('%R%a días'); */
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">        
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes" name="viewport">


        <link rel="icon" type="image/png" href="favicon.png">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">        
        <link rel="stylesheet" href="dist/css/AdminLTE.css">
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

        <title>Supervisión Grupo Valor sa.</title>

        <!-- para tablas -->
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

        <script type="text/javascript" src="floatingdiv/floating-1.12.js"></script>
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="plugins/chartjs/graphs_js/graphs.js" type="text/javascript"></script>

        <style>            
            .no-js #loader { display: none;  }
            .js #loader { display: block; position: absolute; left: 100px; top: 0; }
            .se-pre-con {position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;z-index: 9999;background: url(dist/images/128x128/Preloader_23.gif) center no-repeat #fff;}
        </style>
        <script>$(window).load(function () {
                $(".se-pre-con").fadeOut("slow");
            });</script>
        <!-- fin anim carga de la pagina -->

        <style type="text/css">
            .disabled {
                pointer-events:none; /*This makes it not clickable*/
                opacity:0.6;         /*This grays it out to look disabled*/
            }

            @media only screen and (max-width: 999px) {
                /* rules that only apply for canvases narrower than 1000px */
                .modal {
                    width: 420px;
                    height: 400px;
                    position: absolute;
                    left: 0%;
                    top: 0%; 
                    margin-top: -210px;
                }
            }

            @media only screen and (device-width: 768px) and (orientation: landscape) {
                /* rules for iPad in landscape orientation */
                .modal {
                    width: 768px;
                    height: 400px;
                    position: absolute;
                    left: 0%;
                    top: 0%; 
                    margin-top: -80px;
                }
            }

            @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
                /* iPhone, Android rules here */
                .modal {
                    width: 320px;
                    height: 400px;
                    position: absolute;
                    left: 0%;
                    top: 0%; 
                    margin-top: -50px;
                }

            }

            .wait-modal{
                display: none;
                position: fixed;
                z-index: 1;
                top: 0;
                margin: 15% auto;
                padding: 2%;
                border: 1px solid #888;
                width: 20px;
            }

            /* Modal Header */
            .modal-header {
                padding: 2px 16px;
                background-color: #3c8dbc;
                color: white;
                height: 15%;
            }

            /* Modal Body */
            .modal-body {padding: 2px 16px;}

            /* Modal Footer */
            .modal-footer {
                padding: 2px 16px;
                background-color: #3c8dbc;
                color: white;
            }

            /* Modal Content */
            .modal-content {
                background-color: #fefefe;
                position: fixed; /* se posiciona sobre los elementos*/
                z-index: 1;
                top: 0;			   
                margin: 15% auto; /* 15% from the top and centered */
                padding: 10px;
                border: 1px solid #888;
                /* Could be more or less, depending on screen size */

                display: none;
                /*position: relative;*/  /* se mete enmedio de los otros elementos*/
                box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
                -webkit-animation-name: animatetop;
                -webkit-animation-duration: 0.9s;
                animation-name: animatetop;
                animation-duration: 0.9s
            }

            /* Add Animation */
            @-webkit-keyframes animatetop {
                from {top: -100px; opacity: 0} 
                to {top: 0; opacity: 1}
            }

            @keyframes animatetop {
                from {top: -100px; opacity: 0}
                to {top: 0; opacity: 1}
            }

            /* The Close Button */
            .close {
                color: #333;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
        </style>

        <!-- Smartsupp Live Chat script -->
        <script type="text/javascript">
            var _smartsupp = _smartsupp || {};
            _smartsupp.key = 'af066abb7fe6a518877dcd867093b989941571d8';
            window.smartsupp || (function (d) {
                var s, c, o = smartsupp = function () {
                    o._.push(arguments)
                };
                o._ = [];
                s = d.getElementsByTagName('script')[0];
                c = d.createElement('script');
                c.type = 'text/javascript';
                c.charset = 'utf-8';
                c.async = true;
                c.src = '//www.smartsuppchat.com/loader.js?';
                s.parentNode.insertBefore(c, s);
            })(document);
        </script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">

        <!-- Paste this code after body tag para empezar animacion de la pagikna al cargar-->
        <div class="se-pre-con"><img src="dist/logomko.png" style="position: fixed; left: 50%; top: 50%; width: 120px;height: auto; margin-left: -60px; margin-top: -25px;"></div>
        <!-- Ends -->

        <style type="text/css">
            #divRotacion {
                position: absolute;
                text-align: center;
                top: 50%;
                left: 50%;
            }
        </style>
        <div id="divRotacion" style="width: 128px;height: 128px;background-image: url(dist/images/128x128/Preloader_23.gif);">
            <img src="dist/logomko.png" style="width: 120px;height: auto;margin-top: 40px;">
        </div>

        <div class="wrapper">

            <?php
// funcion se encuentra en MainDrawer.php
            MainDrawer();
            ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Supervisión<small>Panel de Control</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-sitemap"></i> Home</a></li>
                        <li class="active">Panel de control</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <?php include_once 'funciones/index_body_part1.php'; ?>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-danger" >
                                <div class="box-header with-border">
                                    <h3 class="box-title">Personal</h3>
                                    <div class="box-tools pull-right">
                                        <span class="label label-danger"> Miembros Activos</span>
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body" style="background-color: #888;">
                                    <?php
                                    include_once 'funciones/index_body_part2.php';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class = "col-sm-6">
                            <!--DONUT CHART -->
                            <div class = "box box-danger">
                                <div class = "box-header with-border">
                                    <h3 class = "box-title">Asistencia Resumen</h3>

                                    <div class = "box-tools pull-right">
                                        <button type = "button" class = "btn btn-box-tool" data-widget = "collapse"><i class = "fa fa-minus"></i>
                                        </button>
                                        <button type = "button" class = "btn btn-box-tool" data-widget = "remove"><i class = "fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class = "box-body chart-responsive">
                                    <div class = "chart" id = "sales-chart" style = "height: 200px; position: relative;"></div>
                                </div>
                                <!--/.box-body -->
                            </div>
                            <!--/.box -->

                        </div>
                    </div>
                    <!-- /.row -->

                    <div class="row">

                        <div class="col-lg-7 col-md-8 col-sm-12">
                            <div class="box box-default" >
                                <div class="box-header with-border">
                                    <h3 class="box-title">Última Ubicación</h3>
                                    <div class="box-tools pull-right"> 
                                        <button type="button" class="btn btn-box-tool" onclick="window.location.reload();"><i class="fa fa-refresh"></i></button>
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                                <div class="box-body">

                                    <?php
                                    include_once 'funciones/mapa-ubucaciones.php';
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 col-lg-5">

                            <div class="box box-info" >
                                <div class="box-header with-border">
                                    <h3 class="box-title">Hora entrada de Hoy</h3>  

                                    <div class="input-group col-sm-6">
                                        <span class="input-group-addon label-info">Buscar:</span>
                                        <input type="text" id="search" class="form-control">
                                    </div>
                                    <div class="box-tools pull-right">  
                                        <button onclick="selectElementContents(document.getElementById('tablaAsistencia'))">Copiar</button>
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body" style="height: 500px; overflow-y: scroll;">

                                    <table id="tablaAsistencia" class="table-condensed table-bordered table table-striped table-hover">
                                        <thead style="background: rgb(146,208,80);">
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Marca</th>
                                                <th>Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody style="overflow: auto" id="tbodyAsistenciaDiaria">                                                                                              
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.row (main row) -->

                </section>

                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>.</b>
                </div>
                <strong>&copy; 2017 <a href="#">Grupo Valor sa.</a>.</strong> Todos los derechos reservados.
            </footer>
        </div>
        <!-- ./wrapper -->

        <div class=" modal modal-content col col-lg-6 col-md-6 col-xs-12" id="modal">
            <div class="vertical-align-center">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2 id="NombreUsuarioModal">Claudia Portocarrero</h2>
                    <div class="wait-modal box box-danger" id="wait-modal">
                        <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="box box-danger">
                        <div class="box-header with-border">

                        </div>
                        <div id="modalbody" class="box-body" style="background: #ccc; height: 200px; overflow-y: scroll;">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <h3 id="enlaceVerCompleto">Ver Completo. <?php echo $idUsuario; ?></h3>
                </div>
            </div>
        </div>

        <!-- Modal content *¨***************************************************** -->        

        <script type="text/javascript">
            // Get the modal
            var modal = document.getElementById('modal');
            var modalwait = document.getElementById('wait-modal');

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function () {
                modal.style.display = "none";
                modalwait.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                    modalwait.style.display = "none";
                }
            }
        </script>
        <!-- ********************************************************************* -->

        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="dist/js/app.min.js"></script>

        <!-- para tablas -->
        <!-- DataTables -->
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>       

        <!--        para los cuadros de estadistica-->
        <!-- Morris.js charts -->
        <script src="plugins/morris/morris.min.js"></script>

        <script type="text/javascript">
//_________________________________________________________________________________________________________________
            $(function () {
                //DONUT CHART
                var donut = new Morris.Donut({
                    element: 'sales-chart',
                    resize: true,
                    colors: ["#00a65a", "#f56954"],
                    data: <?php echo $datos_graficos->getCantidadEntradas(); ?>,
                    hideHover: 'auto'
                });
            });

//_________________________________________________________________________________________________________________
            var ultimo = 0;

            function notificacionURLImagen() {

                Notification.requestPermission(function (result) {
                    if (result === 'granted') {
                        navigator.serviceWorker.ready.then(function (registration) {
                            registration.showNotification('requireInteraction: true', {
                                body: 'Requires interaction',
                                icon: '../images/touch/chrome-touch-icon-192x192.png',
                                requireInteraction: true,
                                tag: 'require-interaction'
                            });

                            registration.showNotification('requireInteraction: false', {
                                body: 'Does not require interaction',
                                icon: '../images/touch/chrome-touch-icon-192x192.png',
                                requireInteraction: false,
                                tag: 'no-require-interaction'
                            });
                        });
                    }
                });

                var notification = null;

                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    url: 'NotificInformeUltmReg.php',
                    success: function (res) {
                        if (ultimo < res.maxId) {

                            ultimo = res.maxId;


                            if (!('Notification' in window)) {
                                // el navegador no soporta la API de notificaciones
                                alert('Su navegador no soporta la API de Notificaciones :(');
                                return;
                            } else if (Notification.permission === "granted") {
                                // Se puede emplear las notificaciones
                                notification = new Notification(
                                        res.NombreUsuario, {
                                            body: 'Marcó en ' + res.NombrePdV + ' el ' + res.Hora,
                                            dir: 'ltr',
                                            icon: '' + res.Foto_URL
                                        });

                                //notification.onshow = function(){setTimeout(notification.close(), 20000); };
                                notification.onclick = function () {
                                    window.focus();
                                    this.cancel();
                                };

                            } else if (Notification.permission !== 'denied') {
                                // se pregunta al usuario para emplear las notificaciones
                                Notification
                                        .requestPermission(function (permission) {
                                            if (permission === "granted") {
                                                notification = new Notification(
                                                        res.NombreUsuario, {
                                                            body: 'Marcó en ' + res.NombrePdV + ' el ' + res.Hora + ' (Esta notif. solo muestra el último registro.)',
                                                            dir: 'ltr',
                                                            icon: '' + res.Foto_URL
                                                        });
                                                notification.onclick = function () {
                                                    window.focus();
                                                    this.cancel();
                                                };
                                            }
                                        });
                            }

                        }
                    }
                });


            }

            setInterval("notificacionURLImagen()", 10000);

//_________________________________________________________________________________________________________________
            function moveMarker(map, marker) {
                marker.setPosition(new google.maps.LatLng(Lat, Lng));
                map.panTo(new google.maps.LatLng(Lat, Lng));
            }
            ;
//_________________________________________________________________________________________________________________            
        </script>

        <script type="text/javascript">
//_________________________________________________________________________________________________________________
            (function getAsistenciaDiaria() {
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    url: 'getAsistenciadelDia.php',
                    success: function (res) {

//                        console.log(res.success);

                        if (res.success == '1') {


                            document.getElementById("tbodyAsistenciaDiaria").innerHTML = res.table;

                        } else {

                        }

                    }

                });
            })();

            setInterval("getAsistenciaDiaria()", (1000 * 60 * 10));

//_________________________________________________________________________________________________________________
            // Esto es paa realizar una busqueda eqn una tabla 
            $("#search").keyup(function () {
                var value = this.value.toLowerCase().trim();

                $("#tablaAsistencia tr").each(function (index) {
                    if (!index)
                        return;
                    $(this).find("td").each(function () {
                        var id = $(this).text().toLowerCase().trim();
                        var not_found = (id.indexOf(value) == -1);
                        $(this).closest('tr').toggle(!not_found);
                        return not_found;
                    });
                });
            });
//_________________________________________________________________________________________________________________            
        </script>
    </body>
</html>
