<?php
$idUsuario = $_GET["IdUsuario"];
$NivelAcceso = $_GET["NivelAcceso"];
$idCliente = $_GET["IdCliente"];
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="../dist/css/AdminLTE.css">
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" type="text/css" href="bootstrap.min.css"> 
    </head>
    <body>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">

                <div class="box box-solid bg-light-blue-gradient">
                    <div class="box-header with-border">
                        <h3 class="box-title">Asistencia de hoy <?php echo date("d-m-Y"); ?></h3>								
                    </div>
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
                                ?>
                            </tbody>                                        
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./wrapper -->

        <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../dist/js/app.min.js"></script>

        <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script>

            $(document).ready(function () {
                $('#example').DataTable({
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


        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    </body>
</html>