<?php
session_start();

require_once ("../funciones_varias.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/customMainDrawer.php');
$Servidor = 'http://' . $_SERVER['HTTP_HOST'] . "/admin/"; //$_SERVER['PHP_SELF'] . "/admin/";// obtiene la ruta del DNS : http://grupovalor.com.ni/

if (!$_SESSION["sUserId"]) {
    header('Location: login/index.php');
    exit;
}

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];

$admin = 'disabled';
if ($NivelAcceso == 1) {
    $admin = '';
    echo "<a href='" . $Servidor . "pages/posicion-supervisores.php'><i class='fa fa-map'></i> Ultima Ubicación Supervisiones</a>";
}

require_once("../conexion/conexion.php");
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

$FechaIni = isset($_POST['txtFechaDesde']) ? $_POST['txtFechaDesde'] : null;
$FechaFin = isset($_POST['txtFechaHasta']) ? $_POST['txtFechaHasta'] : null;
$PrecAntFechaIni = isset($_POST['txtPAFechaDesde']) ? $_POST['txtPAFechaDesde'] : null;

if ($FechaIni && $FechaFin) {
    
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
        <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="buttons.dataTables.min.css">

        <title>Reporte de Precios del: <?php echo $FechaIni . " al " . $FechaFin; ?></title>

        <style type="text/css">
            .disabled {
                pointer-events:none; //This makes it not clickable
                opacity:0.6;         //This grays it out to look disabled
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

            <?php
            // funcion se encuentra en MainDrawer.php
            MainDrawer();
            ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Supervisión<small>Reporte de Precios</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Reporte Precio</li>
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

                                <form method="post" action="ReportePrecios.php">
                                    <div class=" col-xl-12 col-md-12 col-xs-12">
                                        <div class=" col-xl-3 col-md-3 col-xs-1"></div>
                                        <div class="col-xl-6 col-md-9 col-xs-12" style="color: #000;">
                                            <span>Desde: </span>
                                            <input type="date" width="50px" name="txtFechaDesde" placeholder="yyyy-mm-dd" value="<?php echo $FechaIni; ?>" min="2017-04-15" max="<?php echo date("Y-m-d") ?>">
                                            <span>Hasta: </span>
                                            <input type="date" width="50px" name="txtFechaHasta" placeholder="yyyy-mm-dd" value="<?php echo $FechaFin; ?>" min="2017-04-15" max="<?php echo date("Y-m-d") ?>">
                                            <span>P. Ant. Desde: </span>
                                            <input type="date" width="50px" name="txtPAFechaDesde" placeholder="yyyy-mm-dd" value="<?php echo $PrecAntFechaIni; ?>" min="2017-04-15" max="<?php echo date("Y-m-d") ?>">
                                            <input type="submit" name="btnConsultar" value="Consultar" class="btn btn-primary">
                                        </div>
                                        <div class=" col-xl-3 col-md-1 col-xs-1">	                                		                                  
                                        </div>
                                    </div>
                                </form>

                                <div class="box-body">
                                    <table style="color: #000; border: 1px solid #000;" id="example" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Punto Venta</th>
                                                <th>Ciudad</th>
                                                <th>Categoria</th>
                                                <th>Código</th>
                                                <th>Marca</th>
                                                <th>Presentacion</th>
                                                <th>P. Anterior</th>
                                                <th>P. Actual</th>
                                                <th>Variación</th>
                                                <th>Fecha Reg.</th>
                                                <th>Usuario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($_POST['btnConsultar'])) {

                                                if ($NivelAcceso == 1) { //Admin
                                                    // Esto es para mi precios
                                                    $sql = "SELECT puntosdeventa.NombrePdV, planpromo_presentaciones.CodCafeSoluble, puntosdeventa.Ciudad, Precios_CatCategorias.DescCategoria, planpromo_marcas.Descripcion as Marca, 
													planpromo_presentaciones.Descripcion as Presentacion, 
													getPrecioAnterior(Precios_MisPrecios.idPdV, idMiPresentacion, DATE_SUB('$PrecAntFechaIni', INTERVAL 1 WEEK), DATE_SUB('$PrecAntFechaIni', INTERVAL 1 DAY)) AS PrecioAnter,
													CASE  WHEN  Precios_MisPrecios.MiPrecio = -1 THEN 'N/H' ELSE  Precios_MisPrecios.MiPrecio END as Precio , Precios_MisPrecios.FechaReg, usuario.NombreUsuario  
													FROM Precios_MisPrecios INNER JOIN puntosdeventa on Precios_MisPrecios.idPdV = puntosdeventa.IdPdV INNER JOIN planpromo_presentaciones on 
													planpromo_presentaciones.IdPresentacion = Precios_MisPrecios.idMiPresentacion INNER JOIN Precios_CatCategorias ON 
													planpromo_presentaciones.categoria = Precios_CatCategorias.idCategoria INNER JOIN planpromo_marcas on 
													planpromo_presentaciones.IdMarca = planpromo_marcas.IdMarca INNER JOIN usuario on 
													Precios_MisPrecios.idUsuario = usuario.idUsuario 
													WHERE (Precios_MisPrecios.FechaReg BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY))";

                                                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                                    mysqli_query($conn, "SET NAMES 'utf8'");
                                                    if ($result) {

                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo '<tr>
																  <td>' . strtoupper(($row['NombrePdV'])) . '</td>
																  <td>' . strtoupper(($row['Ciudad'])) . '</td>
																  <td>' . strtoupper(($row['DescCategoria'])) . '</td>
                                                                                                                                  <td>' . strtoupper(($row['CodCafeSoluble'])) . '</td>
																  <td>' . strtoupper(($row['Marca'])) . '</td>
																  <td>' . strtoupper(($row['Presentacion'])) . '</td>
																  <td>' . strtoupper(($row['PrecioAnter'])) . '</td>
																  <td>' . strtoupper(($row['Precio'])) . '</td>
																  <td>0.0</td>
																  <td>' . strtoupper(($row['FechaReg'])) . '</td>
																  <td>' . strtoupper(($row['NombreUsuario'])) . '</td>
																</tr>';
                                                        }
                                                    }

                                                    // esto es parq los precios de la competencia
                                                    $sqlcomp = "SELECT puntosdeventa.NombrePdV, puntosdeventa.Ciudad, Precios_CatCategorias.DescCategoria, getMarcaCompById(`idMarcaComp`) as Marca, 
													precios_competenciapresentacion.NombrePresentCompete, 
													getPrecioAnteriorComp(precios_competenciaprecio.`idPdv`,precios_competenciaprecio.`idPresentComp`, DATE_SUB('$FechaIni', INTERVAL 1 WEEK), DATE_SUB('$FechaIni', INTERVAL 1 DAY)) as PrecioAnter,
													CASE  WHEN  precios_competenciaprecio.CompPrecio = -1 THEN 'N/H' ELSE  precios_competenciaprecio.CompPrecio END as Precio, 
													precios_competenciaprecio.FechaReg, usuario.NombreUsuario  
													FROM `precios_competenciaprecio` INNER JOIN puntosdeventa ON precios_competenciaprecio.idPdv = puntosdeventa.IdPdV INNER JOIN Precios_CatCategorias on 
													precios_competenciaprecio.idCategComp = Precios_CatCategorias.idCategoria INNER JOIN precios_competenciapresentacion on 
													precios_competenciaprecio.idPresentComp = precios_competenciapresentacion.idPresentComp INNER JOIN usuario on usuario.idUsuario = precios_competenciaprecio.idUsuario

													WHERE (precios_competenciaprecio.FechaReg BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY))";

                                                    $result = mysqli_query($conn, $sqlcomp) or die(mysqli_error($conn));
                                                    mysqli_query($conn, "SET NAMES 'utf8'");
                                                    if ($result) {

                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo '<tr>
																  <td>' . strtoupper(($row['NombrePdV'])) . '</td>
																  <td>' . strtoupper(($row['Ciudad'])) . '</td>
																  <td>' . strtoupper(($row['DescCategoria'])) . '</td>
                                                                                                                                  <td></td>
																  <td>' . strtoupper(($row['Marca'])) . '</td>
																  <td>' . strtoupper(($row['NombrePresentCompete'])) . '</td>
																  <td>' . strtoupper(($row['PrecioAnter'])) . '</td>
																  <td>' . strtoupper(($row['Precio'])) . '</td>
																  <td>0.0</td>
																  <td>' . strtoupper(($row['FechaReg'])) . '</td>
																  <td>' . strtoupper(($row['NombreUsuario'])) . '</td>
																</tr>';
                                                        }
                                                    }
                                                }

                                                if ($NivelAcceso == 3) { //Gerente Empresa
                                                    // Esto es para mi precios
                                                    $sql = "SELECT puntosdeventa.NombrePdV, puntosdeventa.Ciudad, planpromo_presentaciones.CodCafeSoluble, Precios_CatCategorias.DescCategoria, planpromo_marcas.Descripcion as Marca, 
													planpromo_presentaciones.Descripcion as Presentacion, 
													getPrecioAnterior(Precios_MisPrecios.idPdV, idMiPresentacion, DATE_SUB('$PrecAntFechaIni', INTERVAL 1 WEEK), DATE_SUB('$PrecAntFechaIni', INTERVAL 1 DAY)) AS PrecioAnter,
													CASE  WHEN  Precios_MisPrecios.MiPrecio = -1 THEN 'N/H' ELSE  Precios_MisPrecios.MiPrecio END as Precio , Precios_MisPrecios.FechaReg, usuario.NombreUsuario  
													FROM Precios_MisPrecios INNER JOIN puntosdeventa on Precios_MisPrecios.idPdV = puntosdeventa.IdPdV INNER JOIN planpromo_presentaciones on 
													planpromo_presentaciones.IdPresentacion = Precios_MisPrecios.idMiPresentacion INNER JOIN Precios_CatCategorias ON 
													planpromo_presentaciones.categoria = Precios_CatCategorias.idCategoria INNER JOIN planpromo_marcas on 
													planpromo_presentaciones.IdMarca = planpromo_marcas.IdMarca INNER JOIN usuario on 
													Precios_MisPrecios.idUsuario = usuario.idUsuario 
													WHERE (usuario.idCliente = $idCliente) AND (Precios_MisPrecios.FechaReg BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY))";

                                                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                                    mysqli_query($conn, "SET NAMES 'utf8'");
                                                    if ($result) {

                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo '<tr>
																  <td>' . strtoupper(($row['NombrePdV'])) . '</td>
																  <td>' . strtoupper(($row['Ciudad'])) . '</td>
																  <td>' . strtoupper(($row['DescCategoria'])) . '</td>
                                                                                                                                  <td>' . strtoupper(($row['CodCafeSoluble'])) . '</td>
																  <td>' . strtoupper(($row['Marca'])) . '</td>
																  <td>' . strtoupper(($row['Presentacion'])) . '</td>
																  <td>' . strtoupper(($row['PrecioAnter'])) . '</td>
																  <td>' . strtoupper(($row['Precio'])) . '</td>
																  <td>0.0</td>
																  <td>' . strtoupper(($row['FechaReg'])) . '</td>
																  <td>' . strtoupper(($row['NombreUsuario'])) . '</td>
																</tr>';
                                                        }
                                                    }

                                                    // esto es parq los precios de la competencia
                                                    $sqlcomp = "SELECT puntosdeventa.NombrePdV, puntosdeventa.Ciudad, Precios_CatCategorias.DescCategoria, getMarcaCompById(`idMarcaComp`) as Marca, 
													precios_competenciapresentacion.NombrePresentCompete, 
													getPrecioAnteriorComp(precios_competenciaprecio.`idPdv`,precios_competenciaprecio.`idPresentComp`, DATE_SUB('$FechaIni', INTERVAL 1 WEEK), DATE_SUB('$FechaIni', INTERVAL 1 DAY)) as PrecioAnter,
													CASE  WHEN  precios_competenciaprecio.CompPrecio = -1 THEN 'N/H' ELSE  precios_competenciaprecio.CompPrecio END as Precio, 
													precios_competenciaprecio.FechaReg, usuario.NombreUsuario  
													FROM `precios_competenciaprecio` INNER JOIN puntosdeventa ON precios_competenciaprecio.idPdv = puntosdeventa.IdPdV INNER JOIN Precios_CatCategorias on 
													precios_competenciaprecio.idCategComp = Precios_CatCategorias.idCategoria INNER JOIN precios_competenciapresentacion on 
													precios_competenciaprecio.idPresentComp = precios_competenciapresentacion.idPresentComp INNER JOIN usuario on usuario.idUsuario = precios_competenciaprecio.idUsuario

													WHERE (usuario.idCliente = $idCliente) AND (precios_competenciaprecio.FechaReg BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY))";
                                                    $result = mysqli_query($conn, $sqlcomp) or die(mysqli_error($conn));
                                                    mysqli_query($conn, "SET NAMES 'utf8'");
                                                    if ($result) {

                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo '<tr>
																  <td>' . strtoupper(($row['NombrePdV'])) . '</td>
																  <td>' . strtoupper(($row['Ciudad'])) . '</td>
																  <td>' . strtoupper(($row['DescCategoria'])) . '</td>
                                                                                                                                  <td></td>
																  <td>' . strtoupper(($row['Marca'])) . '</td>
																  <td>' . strtoupper(($row['NombrePresentCompete'])) . '</td>
																  <td>' . strtoupper(($row['PrecioAnter'])) . '</td>
																  <td>' . strtoupper(($row['Precio'])) . '</td>
																  <td>0.0</td>
																  <td>' . strtoupper(($row['FechaReg'])) . '</td>
																  <td>' . strtoupper(($row['NombreUsuario'])) . '</td>
																</tr>';
                                                        }
                                                    }
                                                }

                                                if ($NivelAcceso == 4) { //Supervisor
                                                    // Esto es para mi precios
                                                    $sql = "SELECT puntosdeventa.NombrePdV, puntosdeventa.Ciudad, planpromo_presentaciones.CodCafeSoluble, Precios_CatCategorias.DescCategoria, planpromo_marcas.Descripcion as Marca, 
													planpromo_presentaciones.Descripcion as Presentacion, 
													getPrecioAnterior(Precios_MisPrecios.idPdV, idMiPresentacion, DATE_SUB('$PrecAntFechaIni', INTERVAL 1 WEEK), DATE_SUB('$PrecAntFechaIni', INTERVAL 1 DAY)) AS PrecioAnter,
													CASE  WHEN  Precios_MisPrecios.MiPrecio = -1 THEN 'N/H' ELSE  Precios_MisPrecios.MiPrecio END as Precio , Precios_MisPrecios.FechaReg, usuario.NombreUsuario  
													FROM Precios_MisPrecios INNER JOIN puntosdeventa on Precios_MisPrecios.idPdV = puntosdeventa.IdPdV INNER JOIN planpromo_presentaciones on 
													planpromo_presentaciones.IdPresentacion = Precios_MisPrecios.idMiPresentacion INNER JOIN Precios_CatCategorias ON 
													planpromo_presentaciones.categoria = Precios_CatCategorias.idCategoria INNER JOIN planpromo_marcas on 
													planpromo_presentaciones.IdMarca = planpromo_marcas.IdMarca INNER JOIN usuario on 
													Precios_MisPrecios.idUsuario = usuario.idUsuario 
													WHERE (Precios_MisPrecios.idUsuario = $idUsuario or usuario.idSupervisor = $idUsuario) AND (Precios_MisPrecios.FechaReg BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY))";

                                                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                                    mysqli_query($conn, "SET NAMES 'utf8'");
                                                    if ($result) {

                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo '<tr>
																  <td>' . strtoupper(($row['NombrePdV'])) . '</td>
																  <td>' . strtoupper(($row['Ciudad'])) . '</td>
																  <td>' . strtoupper(($row['DescCategoria'])) . '</td>
                                                                                                                                  <td>' . strtoupper(($row['CodCafeSoluble'])) . '</td>
																  <td>' . strtoupper(($row['Marca'])) . '</td>                                                                                                                                  
																  <td>' . strtoupper(($row['Presentacion'])) . '</td>
																  <td>' . strtoupper(($row['PrecioAnter'])) . '</td>
																  <td>' . strtoupper(($row['Precio'])) . '</td>
																  <td>0.0</td>
																  <td>' . strtoupper(($row['FechaReg'])) . '</td>
																  <td>' . strtoupper(($row['NombreUsuario'])) . '</td>
																</tr>';
                                                        }
                                                    }

                                                    // esto es parq los precios de la competencia
                                                    $sqlcomp = "SELECT puntosdeventa.NombrePdV, puntosdeventa.Ciudad, Precios_CatCategorias.DescCategoria, getMarcaCompById(`idMarcaComp`) as Marca, 
													precios_competenciapresentacion.NombrePresentCompete, 
													getPrecioAnteriorComp(precios_competenciaprecio.`idPdv`,precios_competenciaprecio.`idPresentComp`, DATE_SUB('$FechaIni', INTERVAL 1 WEEK), DATE_SUB('$FechaIni', INTERVAL 1 DAY)) as PrecioAnter,
													CASE  WHEN  precios_competenciaprecio.CompPrecio = -1 THEN 'N/H' ELSE  precios_competenciaprecio.CompPrecio END as Precio, 
													precios_competenciaprecio.FechaReg, usuario.NombreUsuario  
													FROM `precios_competenciaprecio` INNER JOIN puntosdeventa ON precios_competenciaprecio.idPdv = puntosdeventa.IdPdV INNER JOIN Precios_CatCategorias on 
													precios_competenciaprecio.idCategComp = Precios_CatCategorias.idCategoria INNER JOIN precios_competenciapresentacion on 
													precios_competenciaprecio.idPresentComp = precios_competenciapresentacion.idPresentComp INNER JOIN usuario on usuario.idUsuario = precios_competenciaprecio.idUsuario

													WHERE (precios_competenciaprecio.idUsuario = $idUsuario or usuario.idSupervisor = $idUsuario) AND (precios_competenciaprecio.FechaReg BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY))";
                                                    $result = mysqli_query($conn, $sqlcomp) or die(mysqli_error($conn));
                                                    mysqli_query($conn, "SET NAMES 'utf8'");
                                                    if ($result) {

                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo '<tr>
																  <td>' . strtoupper(($row['NombrePdV'])) . '</td>
																  <td>' . strtoupper(($row['Ciudad'])) . '</td>
																  <td>' . strtoupper(($row['DescCategoria'])) . '</td>
                                                                                                                                  <td></td>
																  <td>' . strtoupper(($row['Marca'])) . '</td>
																  <td>' . strtoupper(($row['NombrePresentCompete'])) . '</td>
																  <td>' . strtoupper(($row['PrecioAnter'])) . '</td>
																  <td>' . strtoupper(($row['Precio'])) . '</td>
																  <td>0.0</td>
																  <td>' . strtoupper(($row['FechaReg'])) . '</td>
																  <td>' . strtoupper(($row['NombreUsuario'])) . '</td>
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