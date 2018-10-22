<?php
/** Error reporting */
error_reporting(E_ALL);

session_start();

ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Managua');
define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once '../plugins/PHPExcel/Classes/PHPExcel.php';
/** PHPExcel_Cell_AdvancedValueBinder */
require_once '../plugins/PHPExcel/Classes/PHPExcel/Cell/AdvancedValueBinder.php';
/** PHPExcel_IOFactory */
require_once '../plugins/PHPExcel/Classes/PHPExcel/IOFactory.php';
// Set value binder
PHPExcel_Cell::setValueBinder(new PHPExcel_Cell_AdvancedValueBinder());
/* lenguaje */
$locale = 'es';
$validLocale = PHPExcel_Settings::setLocale($locale);
if (!$validLocale) {
    //echo 'No se establecio ' . $locale . " - revertir a en_us<br />\n";
}



if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: login/index.php');
    exit;
}

//para el menu lateral
require_once '../customMainDrawer.php';
//para la conexion a la base de datos
require_once '../conexion/conexion.php';
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];



// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("www.grupovalor.com.ni")
        ->setLastModifiedBy($_SESSION["sUserName"])
        ->setTitle("Reporte de precios")
        ->setSubject("Desde: __/__/__ Hasta: __/__/__")
        ->setDescription("Este reporte es generado a solicitud de la parte interesada.")
        ->setKeywords("office 2007 grupo valor informatica")
        ->setCategory("Reporte precios dicegsa");

include_once '../tables/archReportes/reportPrecioDicegsa_Datos.php';


if (isset($_POST["btnDescargarExcel"])) {
    include_once '../tables/archReportes/generaReportExcel.php';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" type="image/png" href="../favicon.png">	
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../dist/css/AdminLTE.css">
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
        
        <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">

        <title></title>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
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
                        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Panel de control</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">

                        <div class="col-xs-12">

                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Exportar información </h3>

                                    <div class="form-horizontal">
                                        <table>
                                            <tr>
                                                <td>
                                                    <form name="frmExportardata" action="ReportePrecios_formato_dicegsa.php" method="POST">
                                                        <input type="submit" class="btn btn-success" id="btnDescargarExcel" name="btnDescargarExcel" value="EXCEL">
                                                    </form>
                                                </td>
                                                <td>
                                                    <form name="frmExportardata" action="ReportePrecios_formato_dicegsa.php" method="POST">
                                                        <input type="submit" class="btn btn-success" id="btnDescargarPDF" name="btnDescargarPDF" value="PDF">
                                                    </form>
                                                </td>
                                            </tr>
                                        </table>

                                    </div>

                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">

                                    


                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                    </div> <!-- /.row (main row) -->
                </section> <!-- /.content -->
            </div> <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>.</b>
                </div>
                <strong>&copy; 2017 <a href="../index.php">Grupo Valor sa.</a>.</strong> Todos los derechos reservados.
            </footer>
        </div>
        <!-- ./wrapper -->

        <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../dist/js/app.min.js"></script>
        
        <!-- date-range-picker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="../plugins/daterangepicker/daterangepicker.js"></script>
        <script src="archReportes/iniciar_tablas_y_calendarios.js" type="text/javascript"></script>
    </body>
</html>
