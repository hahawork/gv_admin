<?php
session_start();


if (!$_SESSION["sUserId"]) {
    header('Location: ../login/index.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Puntos de Venta registrados</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" type="image/png" href="../favicon.png">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="../dist/css/AdminLTE.css">
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

        <link rel="stylesheet" href="../../plugins/datatables/dataTables.bootstrap.css">

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <a href="../index.php" class="logo">
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
                            <img src="<?php echo '../' . $_SESSION['simgFotoPerfilUrl']; ?>" class="img-circle" alt="User Image">
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
                                <li ><a href="../index.php"><i class="fa fa-circle-o"></i> Panel de control.</a></li>
                                <li ><a href="verpdv.php"><i class="fa fa-map"></i> Puntos de venta gráfico</a></li>
                                <li class="active"><a href="verpdvlist.php"><i class="fa fa-map-pin"></i> Puntos de venta listado</a></li>
                                <li><a href="../tables/asistencia-imprimir.php"><i class="fa fa-user"></i> Asistencia de las supervisoras</a></li>
                                <li><a href="../tables/asistenciaoficinaimprimir.php"><i class="fa fa-certificate"></i> Asistencia de Oficinas</a></li>
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
                    <h1>Puntos de venta  <small>Información detallada.</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li>Asistencias</li>
                        <li class="active">Vista por listado.</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-xs-12">         
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Mostrar</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example" class="table table-bordered table-striped" border="1" cellpadding="5" cellspacing="1">
                                        <thead>
                                            <tr>
                                                <th>Canal</th>
                                                <th>Departamento</th>
                                                <th>Ciudad</th>
                                                <th>Representante</th>
                                                <th>Nombre Punto de Venta</th>
                                                <th>Registró</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lmyTableBody">
                                            <?php
                                            require_once("../conexion/conexion.php");

                                            //Se crea nuevo objeto de la clase conexion
                                            $cnn = new conexion();
                                            $conn = $cnn->conectar();
                                            $colo = 1;

                                            $sql = "SELECT CatCanales.NombreCanal, Departamentos.NombreDepto, Ciudad, NombreReprPdV,IdPdV, NombrePdV, usuario.NombreUsuario FROM `puntosdeventa` INNER JOIN Departamentos on puntosdeventa.Departamento=Departamentos.IdDepartamento INNER JOIN CatCanales on puntosdeventa.TipoCanal = CatCanales.IdCanal INNER JOIN usuario on puntosdeventa.UserSave = usuario.idUsuario";

                                            $result = mysqli_query($conn, $sql);

                                            if ($result) :?>

                                                <?php while ($row = mysqli_fetch_array($result)) :?>
                                                    <tr>
                                                        <td style="border: 0px solid #000; background: #<?php echo $colo == 1 ? "fdfee0" : "dcf4f9"; ?>;"><?php echo  ($row['NombreCanal']); ?></td>
                                                        <td style="border: 0px solid #000; background: #<?php echo $colo == 1 ? "fdfee0" : "dcf4f9"; ?>;"><?php echo  ($row['NombreDepto']); ?></td>
                                                        <td style="border: 0px solid #000; background: #<?php echo $colo == 1 ? "fdfee0" : "dcf4f9"; ?>;"><?php echo  ($row['Ciudad']); ?></td>
                                                        <td style="border: 0px solid #000; background: #<?php echo $colo == 1 ? "fdfee0" : "dcf4f9"; ?>;"><?php echo  ($row['NombreReprPdV']); ?></td>
                                                        <td style="border: 0px solid #000; background: #<?php echo $colo == 1 ? "fdfee0" : "dcf4f9"; ?>;"><?php echo  ($row['IdPdV']) . ' - ' . ($row['NombrePdV']); ?></td>
                                                        <td style="border: 0px solid #000; background: #<?php echo $colo == 1 ? "fdfee0" : "dcf4f9"; ?>;"><?php echo  ($row['NombreUsuario']); ?></td>
                                                    </tr>                                               
                                                    <?php
                                                       $colo == 1 ? $colo = 2 : $colo = 1;                                                     
                                                    ?>
                                                <?php endwhile; ?>
                                            <?php endif; ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Canal</th>
                                                <th>Departamento</th>
                                                <th>Ciudad</th>
                                                <th>Representante</th>
                                                <th>Nombre Punto de Venta</th>
                                                <th>Registró</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                     <div class="col-md-12 text-center">
                                        <ul class="pagination pagination-lg pager" id="myPager"></ul>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <!-- /.row (main row) -->

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right" id="footer">
                    <h6>Si quieres la version para Google Earth haz click <b><a href="../pdv-generarkml.php">aqui</a></b></h6>
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
        <script src="tablesorter.pager.js"></script>

        <!-- DataTables -->
        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
       

        <!-- page script -->
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
                       
           // $('#myTableBody').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:10});
        </script>
    </body>
</html>
