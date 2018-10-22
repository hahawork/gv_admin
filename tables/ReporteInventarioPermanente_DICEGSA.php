<?php
session_start();

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: ../login/index.php');
    exit;
}

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];


//para el menu lateral
require_once '../customMainDrawer.php';

//para la conexion a la base de datos
require_once '../conexion/conexion.php';
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

$FechaIni = isset($_POST['txtFechaDesde']) ? $_POST['txtFechaDesde'] : null;
$FechaFin = isset($_POST['txtFechaHasta']) ? $_POST['txtFechaHasta'] : null;

$selFecha = isset($_POST["selFecha"]) ? $_POST["selFecha"] : NULL;
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

        <title>Inventario permanente de <?php echo $_SESSION["sNombCliente"]; ?> - Semana del <?= $selFecha?></title>

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
                                    <h3 class="box-title">Primero seleccione la fecha y luego click en consultar</h3>								

                                    <form method="post" action="<?= $_SERVER["SCRIPT_NAME"] ?>">
                                        <div class="input-group input-group-sm col-sm-6">
                                            <select class="form-control" id="selFecha" name="selFecha">
                                                <option value="0" selected="" disabled="">Selecione una fecha...</option>
                                                <?php
                                                //$sql = "​SELECT DISTINCT DATE_FORMAT(fecha_subido, \"%d de %b, %Y a las %l:%i %p\") as fecha_formato, fecha_subido FROM `vw_Reporte_IP_DICEGSA` INNER JOIN usuario ON vw_Reporte_IP_DICEGSA.id_usuario = usuario.idUsuario WHERE id_usuario = '$idUsuario' OR usuario.idSupervisor = '$idUsuario'";
                                                $sql = "SELECT DISTINCT DATE_FORMAT(fecha_subido, \"%d de %b, %Y a las %l:%i %p\") as fecha_formato, DATE_FORMAT(fecha_subido, \"%Y-%m-%d\") fecha_subido FROM `vw_Reporte_IP_DICEGSA` INNER JOIN usuario ON vw_Reporte_IP_DICEGSA.id_usuario = usuario.idUsuario WHERE id_usuario = '$idUsuario' OR usuario.idSupervisor = '$idUsuario'";
                                               
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    //si existe al menos una fecha de subido
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            ?>
                                                            <option value="<?= $row["fecha_subido"] ?>"><?= $row["fecha_formato"] ?></option>
                                                            <?php
                                                        }
                                                    } else{
                                                        ?>
                                                            <option value="0">¡Vaya! ¡Aún no han subido información
                                                                !</option>
                                                            <?php
                                                    }
                                                }
                                                ?>
                                            </select>

                                            <span class="input-group-btn">
                                                <input type="submit" name="btnConsultar" value="Consultar" class="btn btn-success btn-flat">
                                            </span>
                                        </div>
                                    </form>
                                </div>

                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table style="color: #000; border: 1px solid #000;" id="example" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Punto de Venta</th>
                                                    <th>Item</th>      
                                                    <th>Marca</th>
                                                    <th>Presentación</th>
                                                    <th>Sistema</th>
                                                    <th>Cant. Física</th>
                                                    <th>HandHeld</th>
                                                    <th>Observación</th>
                                                    <th>Usuario</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_POST['btnConsultar'])) {

                                                    $idUsu = $_SESSION["sIdUsuario"];
                                                    $idCliente = $_SESSION["sIdCliente"];


                                                    $sql = "SELECT * FROM `vw_Reporte_IP_DICEGSA` WHERE (fecha_subido LIKE '$selFecha%')";
                                                    //echo "<script type='text/javascript'>alert('$sql');</script>";
                                                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                                    mysqli_query($conn, "SET NAMES 'utf8'");
                                                    if ($result) {

                                                        while ($row = mysqli_fetch_array($result)) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo strtoupper(($row['NombrePdV'])); ?></td>
                                                                <td><?php echo strtoupper(($row['cod_presentacion'])); ?></td>
                                                                <td><?php echo strtoupper(($row['marca'])); ?></td>
                                                                <td><?php echo strtoupper(($row['presentacion'])); ?></td>
                                                                <td><?php echo strtoupper(($row['Sistema'])); ?></td>
                                                                <td><?php echo strtoupper(($row['Cantfisica'])); ?></td>
                                                                <td><?php echo strtoupper(($row['ip_handheld'])); ?></td>
                                                                <td><?php echo strtoupper(($row['observaciones'])); ?></td>
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