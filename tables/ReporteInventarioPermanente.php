<?php
session_start();


if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: ../login/index.php');
    exit;
}
require_once '../customMainDrawer.php';

require_once("../conexion/conexion.php");
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

$FechaIni = isset($_POST['txtFechaDesde']) ? $_POST['txtFechaDesde'] : null;
$FechaFin = isset($_POST['txtFechaHasta']) ? $_POST['txtFechaHasta'] : null;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" type="image/png" href="../favicon.png">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="../dist/css/AdminLTE.css">
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

        <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="buttons.dataTables.min.css">

        <title>Inventario permanente de <?php echo $_SESSION["sNombCliente"]; ?> del: <?php echo $FechaIni . " al " . $FechaFin; ?></title>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <?php
            MainDrawer();
            ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
               <section class="content-header">
                    <h1>Supervisión<small>Inventario Permanente</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Reporte de Inventario Permanente</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">					

                        <div class="col-lg-12 col-md-12 col-xs-12">

                            <div class="box box-solid bg-light-blue-gradient">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Precios</h3>								
                                </div>

                                <form method="post" action="ReporteInventarioPermanente.php">
                                    <div class=" col-xl-12 col-md-12 col-xs-12">
                                        <div class=" col-xl-3 col-md-3 col-xs-1"></div>
                                        <div class="col-xl-6 col-md-9 col-xs-12" style="color: #000;">
                                            <span>Desde: </span>
                                            <input type="date" width="50px" name="txtFechaDesde" placeholder="dd/mm/yyyy" value="<?php echo $FechaIni; ?>" min="2017-04-15" max="<?php echo date("Y-m-d") ?>">
                                            <span>Hasta: </span>
                                            <input type="date" width="50px" name="txtFechaHasta" placeholder="dd/mm/yyyy" value="<?php echo $FechaFin; ?>" min="2017-04-15" max="<?php echo date("Y-m-d") ?>">
                                            <input type="submit" name="btnConsultar" value="Consultar" class="btn btn-primary">
                                        </div>
                                        <div class=" col-xl-3 col-md-1 col-xs-1"></div>
                                    </div>
                                </form>

                                <div class="box-body">
                                        <table style="color: #000; border: 1px solid #000;" id="example" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Cód. Barra</th>
                                                    <th>Presentación</th>
                                                    <th>Marca</th>
                                                    <th>Punto de Venta</th>
                                                    <th>Cant. IP</th>
                                                    <th>Cant. Física</th>
                                                    <th>Observación</th>
                                                    <th>Cant. Averia</th>
                                                    <th>Cant. Vencido</th>
                                                    <th>Cant. etiqRasg</th>
                                                    <th>Cant. Chopiado</th>
                                                    <th>Usuario</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_POST['btnConsultar'])) {

                                                    $idUsu = $_SESSION["sIdUsuario"];
                                                    $idCliente = $_SESSION["sIdCliente"];


                                                    $sql = "SELECT cod_presentacion, cod_barra, presentacion, marca, NombrePdV, cantidad_ip, cantidad_apta, observaciones, 
                                                        cantidad_averiado, cantidad_vencido, cant_etiq_rasgada, cant_sucio_chop, usuario.NombreUsuario
                                                        FROM 
                                                        tbl_inv_permanente INNER JOIN 
                                                        puntosdeventa on tbl_inv_permanente.id_pto_venta = puntosdeventa.IdPdV INNER JOIN usuario on tbl_inv_permanente.id_usuario = usuario.idUsuario
                                                        WHERE cantidad_apta > 0 and (fecha_subido BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY)) AND `id_cliente` = '$idCliente'";

                                                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                                    mysqli_query($conn, "SET NAMES 'utf8'");
                                                    if ($result) {

                                                        while ($row = mysqli_fetch_array($result)) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo strtoupper(($row['cod_presentacion'])); ?></td>
                                                                <td><?php echo strtoupper(($row['cod_barra'])); ?></td>
                                                                <td><?php echo strtoupper(($row['presentacion'])); ?></td>
                                                                <td><?php echo strtoupper(($row['marca'])); ?></td>
                                                                <td><?php echo strtoupper(($row['NombrePdV'])); ?></td>
                                                                <td><?php echo strtoupper(($row['cantidad_ip'])); ?></td>
                                                                <td><?php echo strtoupper(($row['cantidad_apta'])); ?></td>
                                                                <td><?php echo strtoupper(($row['observaciones'])); ?></td>
                                                                <td><?php echo strtoupper(($row['cantidad_averiado'])); ?></td>
                                                                <td><?php echo strtoupper(($row['cantidad_vencido'])); ?></td>
                                                                <td><?php echo strtoupper(($row['cant_etiq_rasgada'])); ?></td>
                                                                <td><?php echo strtoupper(($row['cant_sucio_chop'])); ?></td>
                                                                <td><?php echo strtoupper(($row['NombreUsuario'])); ?></td>
                                                            </tr>
                                                            <?php
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
            </div> <!-- /.row (main row) -->
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
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
            "paging": false,
            "lengthChange": false,
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