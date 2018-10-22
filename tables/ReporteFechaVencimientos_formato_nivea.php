<?php
session_start();

if (!$_SESSION["sUserId"]) {
    header('Location: ../login/index.php');
}

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

        <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="buttons.dataTables.min.css">

        <title>Reporte de Fechas de Vencimientos</title>

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

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="index.php" class="logo">
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
                            <img src="<?php echo "../" . $_SESSION['simgFotoPerfilUrl']; ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $_SESSION["sUserName"]; ?></p>
                            <a href="../login/logout.php"><i class="fa fa-circle text-success"></i> Cerrar Sesión</a>
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
                                <li class="active"><a href="../index.php"><i class="fa fa-circle-o"></i> Panel de control.</a></li>
                                <li><a href="../pages/verpdv.php"><i class="fa fa-map"></i> Puntos de venta gráfico</a></li>
                                <li><a href="../pages/verpdvlist.php"><i class="fa fa-map-pin"></i> Puntos de venta listado</a></li>
                                <li><a href="asistencia-imprimir.php"><i class="fa fa-user"></i> Asistencia de las supervisoras</a></li>
                                <li><a href="asistenciaoficinaimprimir.php"><i class="fa fa-certificate"></i> Asistencia de Oficinas</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Supervisión<small>Fecha Vencimiento</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Reporte de Fechas de Vencimiento</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="box box-solid bg-light-blue">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Aplicar Periodo de Cierre</h3>
                                </div>
                                <div class="box-body">
                                    <span>Hola <?php echo $_SESSION["sUserName"]; ?>, entraste como <?php echo $_SESSION["sessionRol"]; ?> el <b>Periodo de cierre </b>consiste en confirmar el reporte para hacerlo oficial, actualmente se extiende en un periodo de 15 dias  </span>

                                    <!-- TRUNCATE FechaVencimientoReporte; 

                                    INSERT INTO FechaVencimientoReporte (IdCanal, IdDepto, Vendedor, idPuntodeVenta, idMarca, idPresentacion, fechavencim, Cantidad, CantBandeo, TipoBandeo, FechaRegistro, Observacion)

                                    SELECT FechaVencimientoEnc.idCanal, FechaVencimientoEnc.idDepto, FechaVencimientoEnc.Vendedor, FechaVencimientoEnc.idpdv,planpromo_presentaciones.IdMarca, FechaVencimientoEnc.idPresentacion, FechaVencimientoDet.fechaVenc, FechaVencimientoDet.CantidadExist, FechaVencimientoDet.CantidadBandeo, FechaVencimientoDet.TipoBandeo, FechaVencimientoEnc.fechaReg, FechaVencimientoEnc.Observacion 

                                    FROM `FechaVencimientoDet` INNER JOIN FechaVencimientoEnc ON FechaVencimientoDet.idFVE = FechaVencimientoEnc.idFVE INNER JOIN planpromo_presentaciones ON FechaVencimientoEnc.idPresentacion = planpromo_presentaciones.IdPresentacion

                                    WHERE FechaVencimientoEnc.fechaReg BETWEEN DATE_SUB(NOW(), INTERVAL 15 DAY) AND DATE_FORMAT(NOW(),'%Y-%m-%d')-->
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-xs-12">

                            <div class="box box-solid bg-light-blue-gradient">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Información</h3>								
                                </div>

                                <form method="post" action="ReporteFechaVencimientos_formato_nivea.php">
                                    <div class=" col-xl-12 col-md-12 col-xs-12">
                                        <div class=" col-xl-3 col-md-3 col-xs-1"></div>
                                        <div class="col-xl-6 col-md-9 col-xs-12" style="color: #000;">
                                            <span>Desde: </span>
                                            <input type="date" width="50px" name="txtFechaDesde" placeholder="yyyy-mm-dd" value="<?php echo $FechaIni; ?>" min="2017-03-15" max="<?php echo date("Y-m-d") ?>">
                                            <span>Hasta: </span>
                                            <input type="date" width="50px" name="txtFechaHasta" placeholder="yyyy-mm-dd" value="<?php echo $FechaFin; ?>" min="2017-03-15" max="<?php echo date("Y-m-d") ?>">
                                            <input type="submit" name="btnConsultar" value="Consultar" class="btn btn-primary">
                                        </div>
                                        <div class=" col-xl-3 col-md-1 col-xs-1"></div>
                                    </div>
                                </form>

                                <div class="box-body">
                                    <table style="color: #000; border: 1px solid #000;" id="example" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Canal</th>
                                                <th>Zona</th>
                                                <th>Representante</th>
                                                <th>Punto de Venta</th>
                                                <th>Marca</th>
                                                <th>Presentación</th>
                                                <th>Mes</th>
                                                <th>Cantidad</th>
                                                <th>Cant. Bandeo</th>
                                                <th>Desc. Bandeo</th>
                                                <th>Fecha Reg.</th>
                                                <th>Usuario</th>
                                                <th>Cód. C Solub.</th>
                                                <th>Cód. C Mant.</th>
                                                <th>Cód. Walmart</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
if (isset($_POST['btnConsultar'])) {

    $idUsu = $_SESSION["sIdUsuario"];
    $cliente = $_SESSION["sIdCliente"];

    $sql = $_SESSION["sessionRol"] == "Admin" ? "SELECT can.NombreCanal,dpt.NombreDepto, pdv.NombrePdV, NombreReprPdV, marc.Descripcion as Marca, present.Descripcion as Presentacion, 
													CONCAT(DAY(fvd.fechaVenc),' ',ELT(DATE_FORMAT(fvd.fechaVenc, '%m'),'Enero','Febrero','Marzo','Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre','Diciembre'),' ',YEAR(fvd.fechaVenc)) as fechaVenc, fvd.CantidadExist, fvd.CantidadBandeo, fvd.TipoBandeo, present.CodCafeSoluble, 
													present.CodCasaMantica, present.CodigoWalmart,  usuario.NombreUsuario, date_format(fve.fechaReg,'%d/%b/%Y %l:%i %p') as fechaReg
													FROM  
													FechaVencimientoDet as fvd INNER JOIN 
													FechaVencimientoEnc as fve ON fve.idFVE = fvd.idFVE INNER JOIN 
													planpromo_presentaciones as present ON fve.idPresentacion = present.IdPresentacion INNER JOIN  
													planpromo_marcas as marc ON present.IdMarca =  marc.IdMarca INNER JOIN 
													CatCanales as can ON fve.idCanal = can.IdCanal INNER JOIN
													Departamentos as dpt ON fve.idDepto = dpt.IdDepartamento INNER JOIN
													puntosdeventa as pdv ON fve.idpdv = pdv.IdPdV INNER JOIN 
                                                    usuario ON usuario.idUsuario = fve.idUsuario													
													WHERE usuario.IdCliente = $cliente AND 
													fve.fechaReg BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY)
													GROUP BY fve.idpdv, fve.idPresentacion, fvd.fechaVenc, fve.idUsuario
													ORDER BY fve.fechaReg DESC" :
            "SELECT can.NombreCanal,dpt.NombreDepto, pdv.NombrePdV, NombreReprPdV, marc.Descripcion as Marca, present.Descripcion as Presentacion, 
													CONCAT(DAY(fvd.fechaVenc),' ',ELT(DATE_FORMAT(fvd.fechaVenc, '%m'),'Enero','Febrero','Marzo','Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre','Diciembre'),' ',YEAR(fvd.fechaVenc)) as fechaVenc, fvd.CantidadExist, fvd.CantidadBandeo, fvd.TipoBandeo, present.CodCafeSoluble, 
													present.CodCasaMantica, present.CodigoWalmart,  usuario.NombreUsuario, date_format(fve.fechaReg,'%d/%b/%Y %l:%i %p') as fechaReg
													FROM  
													FechaVencimientoDet as fvd INNER JOIN 
													FechaVencimientoEnc as fve ON fve.idFVE = fvd.idFVE INNER JOIN 
													planpromo_presentaciones as present ON fve.idPresentacion = present.IdPresentacion INNER JOIN  
													planpromo_marcas as marc ON present.IdMarca =  marc.IdMarca INNER JOIN 
													CatCanales as can ON fve.idCanal = can.IdCanal INNER JOIN
													Departamentos as dpt ON fve.idDepto = dpt.IdDepartamento INNER JOIN
													puntosdeventa as pdv ON fve.idpdv = pdv.IdPdV INNER JOIN 
                                                    usuario ON usuario.idUsuario = fve.idUsuario													
													WHERE 
													fve.fechaReg BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY) AND  
													(fve.idUsuario = $idUsu or usuario.idSupervisor = $idUsu)
													GROUP BY fve.idpdv, fve.idPresentacion, fvd.fechaVenc, fve.idUsuario
													ORDER BY fve.fechaReg DESC";


    $result = mysqli_query($conn, $sql);
    mysqli_query($conn, "SET NAMES 'utf8'");
    if ($result) {

        while ($row = mysqli_fetch_array($result)) {
            echo '<tr>
															  <td>' . ($row['NombreCanal']) . '</td>
															  <td>' . ($row['NombreDepto']) . '</td>
															  <td>' . ($row['NombreReprPdV']) . '</td>
															  <td>' . ($row['NombrePdV']) . '</td>
															  <td>' . ($row['Marca']) . '</td>
															  <td>' . ($row['Presentacion']) . '</td>
															  <td>' . ($row['fechaVenc']) . '</td>
															  <td>' . ($row['CantidadExist']) . '</td>
															  <td>' . ($row['CantidadBandeo']) . '</td>
															  <td>' . ($row['TipoBandeo']) . '</td>
															  <td>' . ($row['fechaReg']) . '</td>
															  <td>' . ($row['NombreUsuario']) . '</td>
															  <td>' . ($row['CodCafeSoluble']) . '</td>
															  <td>' . ($row['CodCasaMantica']) . '</td>
															  <td>' . ($row['CodigoWalmart']) . '</td>
															</tr>';
        }
    }
}
?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Canal</th>
                                                <th>Zona</th>
                                                <th>Representante</th>
                                                <th>Punto de Venta</th>
                                                <th>Marca</th>
                                                <th>Presentación</th>
                                                <th>Mes</th>
                                                <th>Cantidad</th>
                                                <th>Cant. Bandeo</th>
                                                <th>Desc. Bandeo</th>
                                                <th>Fecha Reg.</th>
                                                <th>Usuario</th>
                                                <th>Cód. C Solub.</th>
                                                <th>Cód. C Mant.</th>
                                                <th>Cód. Walmart</th>
                                            </tr>
                                            </tfooot>
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
});
</script>

<script src="jquery-1.12.4.js"></script>
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.3/js/buttons.print.min.js"></script>

<script type="text/javascript">
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