<?php
session_start();

$Servidor = 'https://' . $_SERVER['HTTP_HOST'] . "/admin/"; //$_SERVER['PHP_SELF'] . "/admin/";// obtiene la ruta del DNS : http://grupovalor.com.ni/

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: login/index.php');
    exit;
}

include_once ("funciones_varias.php");
include_once './conexion/conexion.php';
include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/customMainDrawer.php');

//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" type="image/png" href="favicon.png">
        <title>Supervisión | Inicio </title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">        
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style>            
            .no-js #loader { display: none;  }
            .js #loader { display: block; position: absolute; left: 100px; top: 0; }
            .se-pre-con {position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;z-index: 9999;background: url(dist/images/128x128/Preloader_23.gif) center no-repeat #fff;}
        </style>        
        <!-- fin anim carga de la pagina -->

    </head>
    <body class="hold-transition skin-blue sidebar-mini">

        <!-- Paste this code after body tag para empezar animacion de la pagikna al cargar-->
        <div class="se-pre-con"><img src="dist/logomko.png" style="position: fixed; left: 50%; top: 50%; width: 120px;height: auto; margin-left: -60px; margin-top: -25px;"></div>
        

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
<!-- Ends -->
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
                    <!-- Small boxes (Stat box) -->
                    <?php
                    //include_once 'funciones/index_body_stat_boxes.php'; 
                    ?>

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
                                    include_once 'funciones/index_body_user_list.php';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

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
                                            <tr>
                                                <td colspan="3" style="text-align: center;">
                                                    <img src="dist/images/128x128/Preloader_20.gif" alt="Cargando..."/>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12 col-md-8 col-lg-7">
                            <div class="box box-default" >
                                <div class="box-header with-border">
                                    <h3 class="box-title">Última Ubicación</h3>
                                    <div class="box-tools pull-right">                                             
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                                <div class="box-body" style="height: 510px;">


                                    <?php
                                    include_once 'funciones/mapa-ubucaciones.php';
                                    ?>
                                </div>
                            </div>
                        </div>                            
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Desarrollador</b> Henrry Herrera
                </div>
                <strong>Copyright &copy; 2018 <a href="https://www.grupovalor.com.ni/mo">Grupo Valor</a>.</strong> Nicaragua
                .
            </footer>

        </div>
        <!-- ./wrapper -->

        <!-- jQuery 2-->
        <script src="plugins/jQuery/jquery-2.2.3.min.js" type="text/javascript"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
                                            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.7 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- Slimscroll -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
        <script src="dist/js/app.js" type="text/javascript"></script>

        <script>
            $(window).load(function () {
                $(".se-pre-con").fadeOut("slow");
            });
        </script>
        <script type="text/javascript">
//_________________________________________________________________________________________________________________
                                            (function getAsistenciaDiaria() {
                                                $.ajax({
                                                    type: 'post',
                                                    dataType: 'json',
                                                    cache: false,
                                                    url: 'funciones/getAsistenciadelDia.php',
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

        <script>
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
                    url: 'funciones/NotificInformeUltmReg.php',
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
        </script>
    </body>
</html>
