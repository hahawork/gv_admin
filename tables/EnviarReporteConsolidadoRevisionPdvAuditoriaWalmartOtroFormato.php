<?php
session_start();

require_once '../customMainDrawer.php';

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: ../login/index.php');
    exit;
}

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];

//para el tema de la pagina
$a = array("skin-blue", "skin-black", "skin-purple", "skin-yellow", "skin-red", "skin-green");
$random_skin = array_rand($a, 1);

require_once("../conexion/conexion.php");
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

$FechaIni = isset($_POST['txtFechaDesde']) ? $_POST['txtFechaDesde'] : date("Y-m-d");
$FechaFin = isset($_POST['txtFechaHasta']) ? $_POST['txtFechaHasta'] : date("Y-m-d");
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" type="image/png" href="../favicon.png">
        <title>Reporte de Revisión a pdv del: <?php echo $FechaIni . " al " . $FechaFin; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        --> 
        <link href="../dist/css/skins/_all-skins.css" rel="stylesheet" type="text/css"/>

        <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="buttons.dataTables.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <!--
    BODY TAG OPTIONS:
    =================
    Apply one or more of the following classes to get the
    desired effect
    |---------------------------------------------------------|
    | SKINS         | skin-blue                               |
    |               | skin-black                              |
    |               | skin-purple                             |
    |               | skin-yellow                             |
    |               | skin-red                                |
    |               | skin-green                              |
    |---------------------------------------------------------|
    |LAYOUT OPTIONS | fixed                                   |
    |               | layout-boxed                            |
    |               | layout-top-nav                          |
    |               | sidebar-collapse                        |
    |               | sidebar-mini                            |
    |---------------------------------------------------------|
    -->
    <body class="hold-transition <?= $a[$random_skin] ?> sidebar-mini">
        <div class="wrapper">

            <!-- Main Header -->
            <?php
            MainDrawer();
            ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Reportes
                        <small>Revisión a puntos de venta.</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
                        <li class="active">Here</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-warning" >
                                <div class="box-header with-border">
                                    <h3 class="box-title">Revisión a Puntos de Ventas</h3>

                                    <form class="form-horizontal" method="post" >
                                        <div class="form-group col-sm-5">
                                            <label for="inputEmail3" class="col-sm-3  control-label">Desde:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" name="txtFechaDesde" placeholder="yyyy-mm-dd" value="<?php echo $FechaIni; ?>" min="2018-9-15" max="<?php echo date("Y-m-d") ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Hasta:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" name="txtFechaHasta" placeholder="yyyy-mm-dd" value="<?php echo $FechaFin; ?>" min="2018-10-15" max="<?php echo date("Y-m-d") ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <input type="submit" name="btnConsultar" value="Consultar" class="btn btn-primary">
                                        </div>
                                    </form>

                                    <div class="box-tools pull-right">                                        
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="tblReporte" class="table table-bordered table-condensed table-striped table-hover">
                                            <thead>
                                                <tr style="background-color: #0101DF; color: white;">
                                                    <th>Punto de Venta</th>
                                                    <th>Fecha</th>
                                                    <th>Items <br>Tienda</th>
                                                    <th>Items <br>Agotados</th>
                                                    <th>Participación</th>
                                                    <?php
                                                    //para imprimir los indicadores
                                                    $indicadores = array(
                                                        "1" => "ACTIVIDAD COMERCIAL",
                                                        "2" => "REVISION DE MODULARES",
                                                        "3" => "ROTULACIÓN GP-RB-LIQUIDACIONES-REBAJAS",
                                                        "4" => "LLENADO DE GONDOLA CATEGORIA FALT/CON INV.",
                                                        "5" => "AJUSTE DE IP",
                                                        "6" => "AJUSTE NEGATIVA",
                                                        "7" => "REVISIÓN ITEM SIN MOV. 5 SEM.",
                                                        "8" => "USO EMPAQUE EFICIENTE",
                                                        "9" => "PRECIOS GONDOLA",
                                                        "10" => "EVENTOS POR FECHA");
                                                    ?>

                                                    <th>Indicador</th>
                                                    <th>Cant.<br> Aplicada</th>
                                                    <th>Cant <br>Pendiente</th>
                                                    <th>Comentarios</th>
                                                    <th>Responsable <br>Turno</th>
                                                    <th>Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $sqlData = "SELECT * FROM `tbl_audit_mp_walmart_revisionpdv_enc` WHERE FechaVisita BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY)";
                                                if ($resdata = mysqli_query($conn, $sqlData)) {
                                                    if (mysqli_num_rows($resdata) > 0) {
                                                        while ($row1 = mysqli_fetch_assoc($resdata)) {
                                                            $idEnc = $row1["IdRptEnc"];
                                                            $IdPdv = $row1["IdPdv"];
                                                            $FechaVisita = $row1["FechaVisita"];
                                                            $ItemsTienda = $row1["ItemsTienda"];
                                                            $ItemsAgotados = $row1["ItemsAgotados"];
                                                            $Participacion = $row1["Participacion"];
                                                            $HoraVisita = $row1["HoraVisita"];
                                                            $ResponsableTurno = $row1["ResponsableTurno"];
                                                            $Observaciones = $row1["Observaciones"];

                                                            $sqlDetall = "SELECT * FROM `tbl_audit_mp_walmart_revisionpdv_det` WHERE idRptEnc = '$idEnc' ORDER BY idIndicador";
                                                            if ($resdet = mysqli_query($conn, $sqlDetall)) {
                                                                if (mysqli_num_rows($resdet) > 0) {

                                                                    $idIndic = 1;

                                                                    while ($row2 = mysqli_fetch_assoc($resdet)) {
                                                                        $IdRptDet = $row2["IdRptDet"];
                                                                        $idRptEnc = $row2["idRptEnc"];
                                                                        $idIndicador = $row2["idIndicador"];
                                                                        $descIndicador = $row2["descIndicador"];
                                                                        $cantAplicado = $row2["cantAplicado"];
                                                                        $cantPendiente = $row2["cantPendiente"];
                                                                        $comentarios = $row2["comentarios"];
                                                                        ?>
                                                                        <tr style="background-color: <?php echo $idIndic == 1 ? "#CEECF5" : ""; ?>">
                                                                            <td><?= $IdPdv ?></td>
                                                                            <td><?= $FechaVisita ?></td>
                                                                            <td><?= $ItemsTienda ?></td>
                                                                            <td><?= $ItemsAgotados ?></td>
                                                                            <td><?= $Participacion ?></td>
                                                                            <td><?= $idIndic . " - " . $indicadores["$idIndic"] ?></td>
                                                                            <td><?= $cantAplicado ?></td>
                                                                            <td><?= $cantPendiente ?></td>
                                                                            <td><?= $comentarios ?></td>
                                                                            <td><?= $ResponsableTurno ?></td>
                                                                            <td><?= $Observaciones ?></td>
                                                                        </tr>
                                                                        <?php
                                                                        $idIndic ++;
                                                                    }
//                                                                       
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                            
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>                       
                    </div>

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            <?php include_once '../secciones/footer.php'; ?>
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 2.2.3 -->
        <script src="../plugins/jQuery/jquery-2.2.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap 3.3.6 -->
        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <!-- AdminLTE App -->
        <script src="../dist/js/app.js" type="text/javascript"></script>

        <!-- Optionally, you can add Slimscroll and FastClick plugins.
             Both of these plugins are recommended to enhance the
             user experience. Slimscroll is required when using the
             fixed layout. -->

        <!--Se usa para el fixed navbar-->
        <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>

        <script src="jquery-1.12.4.js"></script>
        <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.print.min.js"></script>

        <script type="text/javascript">

            $(document).ready(function () {

                var table = $('#tblReporte').DataTable({
                    "paging": true,
                    "pageLength": 20,
                    "scrollX": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });             
            });
        </script>

    </body>
</html>
