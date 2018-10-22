<?php
session_start();
require_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/MainDrawer.php');

if (!$_SESSION["sUserId"]) {
    header('Location: ../login/index.php');
}
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

    $sql = "SELECT TBL_Asistencia_ExternoLite.id_asistencia, TBLPersonaLocalAsistencia.Nombre, TBLPersonaLocalAsistencia.Apellido,puntosdeventa.NombrePdV,TBL_Asistencia_ExternoLite.FechaEntr,TBL_Asistencia_ExternoLite.FechaSal FROM `TBL_Asistencia_ExternoLite` INNER JOIN TBLPersonaLocalAsistencia on TBL_Asistencia_ExternoLite.id_persona=TBLPersonaLocalAsistencia.IdPersona INNER JOIN puntosdeventa on TBL_Asistencia_ExternoLite.id_local= puntosdeventa.IdPdV WHERE FechaEntr BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY) ORDER BY FechaEntr DESC";
} else {
    $sql = "SELECT TBL_Asistencia_ExternoLite.id_asistencia, TBLPersonaLocalAsistencia.Nombre, TBLPersonaLocalAsistencia.Apellido,puntosdeventa.NombrePdV,TBL_Asistencia_ExternoLite.FechaEntr,TBL_Asistencia_ExternoLite.FechaSal FROM `TBL_Asistencia_ExternoLite` INNER JOIN TBLPersonaLocalAsistencia on TBL_Asistencia_ExternoLite.id_persona=TBLPersonaLocalAsistencia.IdPersona INNER JOIN puntosdeventa on TBL_Asistencia_ExternoLite.id_local= puntosdeventa.IdPdV ORDER BY FechaEntr DESC limit 50";
}

function getResult() {

    global $conn;
    global $sql;
    $result = mysqli_query($conn, $sql);

    if ($result) {

        while ($row = mysqli_fetch_array($result)) {

            echo '<tr>
                <td> ' . ($row['id_asistencia']) . '</td>
                <td> ' . ($row['Nombre']) . '</td>
                <td> ' . ($row['Apellido']) . '</td>
                <td> ' . $row['NombrePdV'] . '</td>
                <td> ' . $row['FechaEntr'] . '</td>
                <td> ' . $row['FechaSal'] . '</td>
               
                                                    
              </tr>';
        }
    }
}
//obtener los datos para exportar a excel
$sql_query= "SELECT TBL_Asistencia_ExternoLite.id_asistencia, TBLPersonaLocalAsistencia.Nombre, TBLPersonaLocalAsistencia.Apellido,puntosdeventa.NombrePdV,TBL_Asistencia_ExternoLite.FechaEntr,TBL_Asistencia_ExternoLite.FechaSal FROM `TBL_Asistencia_ExternoLite` INNER JOIN TBLPersonaLocalAsistencia on TBL_Asistencia_ExternoLite.id_persona=TBLPersonaLocalAsistencia.IdPersona INNER JOIN puntosdeventa on TBL_Asistencia_ExternoLite.id_local= puntosdeventa.IdPdV";
$resultset= mysqli_query($conn, $sql_query) or die("datebase error:".mysqli_error($conn));
$developer_records= array();
while($rows= mysqli_fetch_assoc($resultset)){
    $developer_records[]=$rows;
}
if(isset($_POST["export_data"])) {
$filename = "phpzag_data_export_".date('Ymd') . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename='$filename'");
$show_coloumn = false;
if(!empty($developer_records)) {
foreach($developer_records as $record) {
if(!$show_coloumn) {
// display field/column names in first row
echo implode("t", array_keys($record)) . "n";
$show_coloumn = true;
}
echo implode("t", array_values($record)) . "n";
}
}
exit;
}

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
        
        <title>Asistencia de Aplicacion Lite</title>

        <style type="text/css">
            .disabled {
                pointer-events:none; /*This makes it not clickable*/
                opacity:0.6;         /*This grays it out to look disabled*/
            }
        </style>

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
                    <h1>Asistencia Aplicacion Lite</h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Asistencia app lite</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content" id="minutos">
                    <div class="row">
                        <div class="box box-solid bg-light-blue-gradient">

                            <div class="box-header" style="color: #000;">

                                <form method="post" action="ReporteAppLite.php">
                                    <div class=" col-xl-12 col-md-12 col-xs-12">
                                        <div class=" col-xl-3 col-md-3 col-xs-1"></div>
                                        <div class="col-xl-6 col-md-6 col-xs-12">
                                            <span>Desde: </span>
                                            <input type="date" width="50px" name="txtFechaDesde" placeholder="dd/mm/yyyy" value="<?php echo $FechaIni; ?>" min="2016-11-28" max="<?php echo date("Y-m-d") ?>">
                                            <span>Hasta: </span>
                                            <input type="date" width="50px" name="txtFechaHasta" placeholder="dd/mm/yyyy" value="<?php echo $FechaFin; ?>" min="2016-11-28" max="<?php echo date("Y-m-d") ?>">
                                            <input type="submit" name="btnConsultar" value="Consultar" class="btn btn-primary">
                                         <!--   <button type="submit" id="export_data" name="export_data" value="Export to excel" class="btn btn-info">Exportar a excel</button> -->
                                        </div>
                                        
                                        <div class=" col-xl-3 col-md-3 col-xs-1"></div>
                                    </div>
                                </form>
                            </div>                    
                            <div class="box-body">
                                <table id="example" class="table table-bordered table-striped" style="color: #000;">
                                    <thead>
                                        <tr>
                                            <th style="width:110px;"><i class="fa fa-user"></i>IdAsistencia</th>
                                            <th style="width:30px;"><i class="fa fa-clock-o"></i>Nombre</th>
                                            <th style="width:30px;"><i class="fa fa-clock-o"></i>Apellido</th>
                                            <th style="width:30px;"><i class="fa fa-usd"></i> Local</th>
                                            <th style="width:30px;"><i class="fa fa-usd"></i> HoraEntrada</th>
                                            <th style="width:30px;"><i class="fa fa-usd"></i> HoraSalida</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        getResult();
                                        ?>
                                    </tbody>
                                </table>
                            </div> <!-- /.box-body -->
                        </div> <!-- /.box -->

                    </div> <!-- /. row -->

                </section> <!-- /.content -->


</div> <!-- /.<content-wrapper -->

            <footer class="main-footer">
                <div class="pull-right hidden-xs" id="footer" >
                    <h6>.</h6>
                </div>
                <strong>&copy; 2017 <a href="../">Grupo Valor sa.</a>.</strong> Todos los derechos reservados.
            </footer> <!-- /. main-footer -->
        </div> <!-- /.wrapper -->

        <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../dist/js/app.min.js"></script>

        <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
        <script>

            $(function () {
                $('#example').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true
                });
            });
        </script>
        
<!--        <script src="https://cdn.datatables.net/buttons/1.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.print.min.js"></script>-->

        <script type="text/javascript">
            $(document).ready(function () {
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


