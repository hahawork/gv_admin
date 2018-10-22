<?php
session_start();

require_once '../MainDrawer.php';

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: login/index.php');
    exit;
}

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];

$admin = 'disabled';


if ($_SESSION["sessionRol"] == "Admin") {
    $admin = '';
}

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
        <link href="../plugins/pace/pace.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="buttons.dataTables.min.css">

        <title>Reporte de asistencia diaria del <?php echo date("d-m-Y"); ?></title>

        <style type="text/css">
            .disabled {
                pointer-events:none; /*This makes it not clickable*/
                opacity:0.6;         /*This grays it out to look disabled*/
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

        <script>
            function blinktext() {
                var indica1 = document.getElementById('labelIndicador');
                var indica2 = document.getElementById('labelIndicador2');
                setInterval(function () {
                    indica1.style.visibility = (indica1.style.visibility == 'hidden' ? '' : 'hidden');
                    indica2.style.visibility = (indica2.style.visibility == 'hidden' ? '' : 'hidden');
                }, 500);
            }
        </script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini" onload="blinktext();">
        <div class="wrapper">

            <?php
            MainDrawer();
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Supervisión<small>Asistencia Diaria</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Reporte de Asistencia Diaria</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">

                            <div class="box box-solid bg-light-blue-gradient">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Asistencia de hoy <?php echo date("d-m-Y"); ?></h3>								
                                </div>

                                <form method="post" action="ReporteAsistenciaDiaria.php">
                                    <div style="text-align: center;" class=" col-xl-12 col-md-12 col-xs-12">
                                        <span class="label-info" id="labelIndicador"><i class="fa fa-arrow-right"></i></span>
                                        <input type="submit" id="btnConsultar" name="btnConsultar" value="Click para Consultar" class="btn btn-primary">
                                        <span class="label-info" id="labelIndicador2"><i class="fa fa-arrow-left"></i></span>
                                    </div>
                                </form>

                                <div class="box-body">
                                    <table style="color: #000; border: 1px solid #000;" id="example" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Marca</th>
                                                <th>Hora Entrada</th>
                                                <th>Lugar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($_POST['btnConsultar'])) {

                                                $idUsu = $_SESSION["sIdUsuario"];
                                                $cliente = $_SESSION["sIdCliente"];

                                                $sql = "SELECT `idUsuario`, `NombreUsuario`, Rol, clientes.RazonSocial "
                                                        . "FROM `usuario` INNER JOIN "
                                                        . "clientes on usuario.IdCliente = clientes.IdCliente "
                                                        . "WHERE EstadoActivo = 1  and MarcaAsistenciaGPS = 1 "
                                                        . "ORDER BY `usuario`.`NombreUsuario`";


                                                $result = mysqli_query($conn, $sql);

                                                mysqli_query($conn, "SET NAMES 'utf8'");
                                                if ($result) {

                                                    while ($row = mysqli_fetch_array($result)) {

                                                        $date = date("Y-m-d");
                                                        $idcl = $row['idUsuario'];
                                                        $tieneAsistencia = 0;
                                                        $row2 = null;

                                                        $consutAsistencia = "SELECT NombrePdV, date_format(FechaRegistro, '%H:%i:%s') as Hora "
                                                                . "FROM `usuario_asistencia` "
                                                                . "INNER JOIN puntosdeventa on usuario_asistencia.IdPdV = puntosdeventa.IdPdV "
                                                                . "WHERE idUsuario = '$idcl' and FechaRegistro LIKE '$date%' "
                                                                . "order BY FechaRegistro";

                                                        
                                                        $resultAsistencia = mysqli_query($conn, $consutAsistencia);

                                                        if ($consutAsistencia) {
                                                            if (mysqli_num_rows($resultAsistencia) > 0) {
                                                                $tieneAsistencia = 1;
                                                                $row2 = mysqli_fetch_array($resultAsistencia);
                                                            } else {
                                                                $tieneAsistencia = 0;
                                                            }

                                                            echo '<tr>
                                                            <td>' . ($row['NombreUsuario']) . " (" . ($row['Rol']) . ')</td>
                                                            <td>' . ($row['RazonSocial']) . '</td>
                                                            <td>' . ($tieneAsistencia == 1 ? $row2['Hora'] : "N/D") . '</td>
                                                            <td>' . ($row2['NombrePdV']) . '</td>
                                                          </tr>';
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
<script>

        $(document).ready(function () {
            $('#example').DataTable({
                "columnDefs": [
                    {
                        "targets": [2],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": [3],
                        "visible": false
                    }
                ]
            });
        });

        $(function () {
        $('#example').DataTable({
        "paging": false,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
        });</script>


<script src="../plugins/pace/pace.js" type="text/javascript"></script>
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.print.min.js"></script>

<script type="text/javascript">

                // To make Pace works on Ajax calls
                $(document).ajaxStart(function () {
        Pace.restart();
        });
                $(document).ready(function() {
        $('#example').DataTable({
        dom: 'Bfrtip',
                buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                ]
        });
        });
</script>

</body>
</html>