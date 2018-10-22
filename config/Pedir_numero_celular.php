<?php
session_start();

$Servidor = 'https://' . $_SERVER['HTTP_HOST'] . "/admin/"; //$_SERVER['PHP_SELF'] . "/admin/";// obtiene la ruta del DNS : http://grupovalor.com.ni/

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: ../login/index.php');
    exit;
}

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];

$admin = 'disabled';


if ($NivelAcceso == 1) {
    $admin = '';
}

require_once("../conexion/conexion.php");
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();


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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        
        <link href="<?php echo $Servidor; ?>favicon.png" rel="icon" type="image/png">
        <link href="<?php echo $Servidor; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $Servidor; ?>dist/css/AdminLTE.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $Servidor; ?>dist/css/skins/_all-skins.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $Servidor; ?>plugins/pace/pace.css" rel="stylesheet" type="text/css"/>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">        


        <title>Pedir Número de Celular</title>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">

        <div class="wrapper">
            <header class="main-header">
                <a href="<?php echo $Servidor; ?>index.php" class="logo">
                    <span class="logo-mini"><b>G</b>V</span>
                    <span class="logo-lg"><b>Grupo</b>Valor sa.</span>
                </a>
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                </nav>
            </header>
            
            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo $Servidor . $_SESSION['simgFotoPerfilUrl']; ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $_SESSION["sUserName"]; ?></p>
                            <a href="<?php echo $Servidor; ?>login/logout.php"><i class="fa fa-circle text-success"></i> Cerrar Sesión</a>
                        </div>
                    </div>

                    <ul class="sidebar-menu">
                        <li class="header">Panel de navegación</li>
                        <li class="active treeview">
                            <a href="#">
                                <i class="fa fa-dashboard"></i> <span>Sitios</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo $Servidor; ?>index.php"><i class="fa fa-circle-o"></i> Panel de control.</a></li>                                
                                <li><a href="<?php echo $Servidor; ?>pages/mis_productos.php"><i class="fa fa-cubes"></i>Mis Productos</a></li>
                                <li><a href="<?php echo $Servidor; ?>planpromocional/planpromocional.php"><i class="fa fa-certificate"></i>Plan Promocional</a></li>
                            </ul>			            
                        </li>
                        
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-file-excel-o"></i> <span>Reportes</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            
                            <ul class="treeview-menu">  
                                
                                <?php if ($NivelAcceso == 1) : ?>
                                <li><a href="<?php echo $Servidor; ?>tables/asistenciaoficinaimprimir.php"><i class="glyphicon glyphicon-briefcase"></i> Asistencia de Oficinas</a></li>  
                                <li><a href="<?php echo $Servidor; ?>tables/ReporteAsistenciaPersonal.php"><i class="glyphicon glyphicon-tags"></i>Asistencia de Personal Externo</a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo $Servidor; ?>tables/asistencia-imprimir.php"><i class="glyphicon glyphicon-user"></i> Asistencia de las supervisoras</a></li>
                                <!-- Esto es porque el formato de fechas de vencimiento cambia por marca-->
                                <li><a href="<?php echo getURLFechasVencimiento($idCliente) ?>"><i class="glyphicon glyphicon-exclamation-sign"></i>Fechas de Vencimiento</a></li>
                                <li><a href="<?php echo getURLPrecios($idCliente); ?>"><i class="fa fa-money"></i>Reporte de Precios</a></li>
                                <li><a href="<?php echo $Servidor; ?>tables/ReporteInventarioPermanente.php"><i class="glyphicon glyphicon-tags"></i>Inventario Permanente</a></li>	                                
                            </ul>
                        </li>

                        <?php if ($NivelAcceso == 1) : ?>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-television" aria-hidden="true"></i> <span>Monitores</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo $Servidor; ?>pages/verpdv.php"><i class="fa fa-map"></i> Puntos de venta gráfico</a></li>
                                <li><a href="<?php echo $Servidor; ?>pages/verpdvlist.php"><i class="fa fa-map-pin"></i> Puntos de venta listado</a></li>
                                <li><a href="<?php echo $Servidor; ?>tables/ReporteAsistenciaDiaria.php"><i class="fa fa-pie-chart"></i>Asistencia Diaria</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-cogs" aria-hidden="true"></i> <span>Configuración</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>			          	
                            <ul class="treeview-menu">
                                <li><a href="<?php echo $Servidor; ?>config/frmUsuarioPantallas.php"><i class="fa  fa-check-square"></i>Usuario-Formularios</a></li>	
                                <li><a href="<?php echo $Servidor; ?>config/Formato_registro.php"><i class="glyphicon glyphicon-user"></i>Registro-Usuarios</a></li>
                                <li><a href="<?php echo $Servidor; ?>config/respaldar_base_datos.php"><i class="fa fa-database"></i>Respaldar Base De Datos</a></li>
                                <li class="active"><a href="<?php echo $Servidor; ?>config/Pedir_numero_celular.php"><i class="fa fa-database"></i>Pedir Número Celular de un Usuario.</a></li>
                            </ul>
                        </li>
                        <?php endif; ?>

                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Configuración<small>Pedir número de celular</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="../index.php"><i class="fa fa-sitemap"></i> Home</a></li>
                        <li class="active">Pedir número de celular</li>
                    </ol>
                </section>
                
                <!-- Main content -->
                <section class="content">
                    <div class="row">                       
                        <div class="col-xs-12">
                            <div class="box box-default" >
                                <div class="box-header with-border">
                                    <h3 class="box-title">Solicitar Numero de celular</h3>
                                    <div class="box-tools pull-right">                                 
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                                <div class="box-body">

                                    <div class="form">
                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                            <div class="input-group">
                                                <label for="selListUsuario" class="label-info input-group-addon">Usuario:</label>						                 
                                                <select id="selListUsuario" class="form-control" >
                                                    <option value="0" selected="selected" disabled="disabled">Seleccione un usuario...</option>

                                                    <?php
                                                    $sql = "SELECT * FROM `usuario` WHERE EstadoActivo = 1 ORDER BY `NombreUsuario` ASC";
                                                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                                    while ($row2 = mysqli_fetch_array($result)) :
                                                        ?>
                                                        <option value="<?php echo ($row2['idUsuario']); ?>"><?php echo ($row2['NombreUsuario']); ?></option>;
                                                    <?php endwhile;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-3">
                                            <div class="input-group">
                                                <label for="txtNumeroRecibirSMS" class="label-info input-group-addon">Enviar al:</label>	
                                                <input type="number" id="txtNumeroRecibirSMS" value="86752483" class="form-control" />
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3">
                                            <div class="input-group">
                                                <div class="checkbox">
                                                    <label><input id="chkPedirNumero" type="checkbox">Pedir número</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="col-sm-6 col-md-3">
                                                <input type="button" value="Efectuar" class="btn btn-success" onclick="PedirNumeroCelular();">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>       
                    <!-- /.row (main row) -->
                </section>

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

        <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../dist/js/app.min.js"></script>
        <script src="../plugins/pace/pace.js" type="text/javascript"></script>


        <script type="text/javascript">


            // To make Pace works on Ajax calls
            $(document).ajaxStart(function () {
                Pace.restart();
            });


            function PedirNumeroCelular() {

                var idUsuario = document.getElementById("selListUsuario").value;
                var PedirNumero = document.getElementById("chkPedirNumero").checked;
                if (true === PedirNumero) {
                    PedirNumero = 1;
                } else {
                    PedirNumero = 0;
                }
                var EnviarAlNumero = document.getElementById("txtNumeroRecibirSMS").value;

                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    cache: 'false',

                    data: {idUsuario: idUsuario,
                        estadoPedirNumeroCelular: PedirNumero,
                        EnviarSMSANumero: EnviarAlNumero},

                    url: 'Pedir_numero_celular_script.php',
                    beforeSend: function () {
                        console.log("Guardando... ");
                    },
                    success: function (res) {

                        if (res.success == 1) {
                            console.log("guardado. " + res.error);
                            alert("Guardado...");
                            window.location.reload();
                        } else {
                            console.log("Fallo al guardar. " + res.error);
                            alert("Fallo al guardar. " + res.error);
                        }
                    },
                    error: function (res) {
                        console.log("error ocurrido: " + res);
                    },
                    always: function (res) {}
                });

            }
        </script>

    </body>
</html>