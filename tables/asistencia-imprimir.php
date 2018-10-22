
<?php
session_start();
$Servidor = 'http://' . $_SERVER['HTTP_HOST'] . "/admin/";

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: login/index.php');
    exit;
}
require_once '../customMainDrawer.php';

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];


$FechaIni = isset($_POST['txtFechaDesde']) ? $_POST['txtFechaDesde'] : null;
$FechaFin = isset($_POST['txtFechaHasta']) ? $_POST['txtFechaHasta'] : null;

require_once("../conexion/conexion.php");
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

$sql = '';

if (isset($_POST['btnConsultar'])) {


    if ($NivelAcceso == 1) {
        $sql = "SELECT ua.idAsistencia, u.NombreUsuario, cl.RazonSocial, ifnull( pv.NombrePdV,'Ver Descripcion') as NombrePdV , ua.CantGastosMovim, ua.CantGastosMovimTaxi, ua.CantGastosAlim, ua.CantGastosHosped, ua.CantGastosVario, 
            (ua.CantGastosMovim + ua.CantGastosMovimTaxi + ua.CantGastosAlim + ua.CantGastosHosped + ua.CantGastosVario) as CantGastosTotal, ua.FechaRegistro, FechaSalida, ua.Observacion, ua.KmActual 
            FROM usuario_asistencia as ua INNER JOIN usuario as u 
            on u.idUsuario = ua.idUsuario LEFT JOIN puntosdeventa as pv 
            on pv.IdPdV = ua.IdPdV INNER JOIN clientes as cl on u.IdCliente = cl.IdCliente WHERE ua.FechaRegistro BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY) ORDER BY ua.FechaRegistro desc";
    }
    if ($NivelAcceso == 3) {

        $sql = "SELECT ua.idAsistencia, u.NombreUsuario, cl.RazonSocial, ifnull( pv.NombrePdV,'Ver Descripcion') as NombrePdV , ua.CantGastosMovim, ua.CantGastosMovimTaxi, ua.CantGastosAlim, ua.CantGastosHosped, ua.CantGastosVario, 
            (ua.CantGastosMovim + ua.CantGastosMovimTaxi + ua.CantGastosAlim + ua.CantGastosHosped + ua.CantGastosVario) as CantGastosTotal, ua.FechaRegistro, FechaSalida, ua.Observacion, ua.KmActual 
            FROM usuario_asistencia as ua INNER JOIN usuario as u 
            on u.idUsuario = ua.idUsuario LEFT JOIN puntosdeventa as pv 
            on pv.IdPdV = ua.IdPdV INNER JOIN clientes as cl on u.IdCliente = cl.IdCliente WHERE u.IdCliente = '$idCliente' and ua.FechaRegistro BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY) ORDER BY ua.FechaRegistro desc";
    }

    if ($NivelAcceso == 4) {

        $sql = "SELECT ua.idAsistencia, u.NombreUsuario, cl.RazonSocial, ifnull( pv.NombrePdV,'Ver Descripcion') as NombrePdV , ua.CantGastosMovim, ua.CantGastosMovimTaxi, ua.CantGastosAlim, ua.CantGastosHosped, ua.CantGastosVario, 
            (ua.CantGastosMovim + ua.CantGastosMovimTaxi + ua.CantGastosAlim + ua.CantGastosHosped + ua.CantGastosVario) as CantGastosTotal, ua.FechaRegistro, FechaSalida, ua.Observacion, ua.KmActual 
            FROM usuario_asistencia as ua INNER JOIN usuario as u 
            on u.idUsuario = ua.idUsuario LEFT JOIN puntosdeventa as pv 
            on pv.IdPdV = ua.IdPdV INNER JOIN clientes as cl on u.IdCliente = cl.IdCliente WHERE ua.idUsuario = '$idUsuario' or idSupervisor = '$idUsuario' and ua.FechaRegistro BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY) ORDER BY ua.FechaRegistro desc";
    }
}

function getResult() {

    global $conn;
    global $sql;

    if (strlen($sql) > 0) {
        $result = mysqli_query($conn, $sql);
        mysqli_query($conn, "SET NAMES 'utf8'");
        if ($result) {

            while ($row = mysqli_fetch_array($result)) {

                $Observ = " ";
                if (strlen(($row['Observacion'])) > 0) {
                    $Observ = " : " . ($row['Observacion']);
                }

                echo '<tr>
                <td> ' . ($row['NombreUsuario']) . '</td>
                <td> ' . ($row['RazonSocial']) . '</td>
                <td> ' . $row['CantGastosMovim'] . '</td>
                <td> ' . $row['CantGastosMovimTaxi'] . '</td>
                <td> ' . $row['CantGastosAlim'] . '</td>
                <td> ' . $row['CantGastosHosped'] . '</td>
                <td> ' . $row['CantGastosVario'] . '</td>
                <td> ' . $row['CantGastosTotal'] . '</td>
                <td> ' . $row['FechaRegistro'] . '</td>
                <td> ' . $row['FechaSalida'] . '</td>
                 <td> ' . $row['KmActual'] . '</td>
                <td> ' . ($row['NombrePdV']) . ' ' . $Observ . '</td>
              </tr>';
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>
    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css"> 

        <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="buttons.dataTables.min.css">

        <title>Asistencia de las supervisoras del: <?php echo $FechaIni . " al " . $FechaFin; ?></title>

        <style type="text/css">
            .disabled {
                pointer-events:none; /*//This makes it not clickable*/
                opacity:0.6;         /*//This grays it out to look disabled*/
            }
        </style>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <?php
            MainDrawer();
            ?>

            <div class="content-wrapper">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Asistencia<small>de Supervisores</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Supervisores</li>
                    </ol>
                </section>

                <section class="content">

                    <div class="box box-solid bg-light-blue-gradient">

                        <div class="box-header" style="color: #000;">

                            <form method="post" action="asistencia-imprimir.php">
                                <div class=" col-xl-12 col-md-12 col-xs-12">
                                    <div class=" col-xl-3 col-md-3 col-xs-1"></div>
                                    <div class="col-xl-6 col-md-9 col-xs-12">
                                        <span>Desde: </span>
                                        <input type="date" width="50px" name="txtFechaDesde" placeholder="yyyy-mm-dd" value="<?php echo $FechaIni; ?>" min="2016-11-28" max="<?php echo date("Y-m-d") ?>">
                                        <span>Hasta: </span>
                                        <input type="date" width="50px" name="txtFechaHasta" placeholder="yyyy-mm-dd" value="<?php echo $FechaFin; ?>" min="2016-11-28" max="<?php echo date("Y-m-d") ?>">
                                        <input type="submit" name="btnConsultar" value="Consultar" class="btn btn-primary">
                                    </div>
                                    <div class=" col-xl-3 col-md-1 col-xs-1"></div>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div style="overflow-x: auto;">
                                <table id="example" class="table table-bordered table-striped"  style="color: #000;"><!--data-order="[[ 7, 'asc' ]]" -> style="color: #000;">-->
                                    <thead>
                                        <tr>
                                            <th style="width:110px;"><i class="fa fa-user"></i> Usuario</th>
                                            <th style="width:110px;"><i class="fa fa-user"></i> Marca</th>
                                            <th style="width:30px;"><i class="fa fa-bus"></i> Bus</th>
                                            <th style="width:30px;"><i class="fa fa-taxi"></i> Taxi</th>
                                            <th style="width:30px;"><i class="fa fa-cutlery"></i> Alimento</th>
                                            <th style="width:30px;"><i class="fa fa-bed"></i> Hospedaje</th>
                                            <th style="width:30px;"><i class="fa fa-question"></i> Otros</th>
                                            <th style="width:30px;"><i class="fa fa-plus"></i> Total</th>
                                            <th style="width:30px;"><i class="fa fa-plus"></i> Fecha Ent.</th>
                                            <th style="width:30px;"><i class="fa fa-plus"></i> Fecha Sal.</th>
                                            <th style="width:80px;"><i class="fa fa-clock-o"></i> KmActual</th>
                                            <th><i class="fa fa-th-list"></i> Observacion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        getResult();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </section>
                <!-- /.content -->
            </div>

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

        <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.print.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#example').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true,
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            });
        </script>
    </body>
</html>
