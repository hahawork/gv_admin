<?php
session_start();

$Servidor = 'http://' . $_SERVER['HTTP_HOST'] . "/admin/"; //$_SERVER['PHP_SELF'] . "/admin/";// obtiene la ruta del DNS : http://grupovalor.com.ni/


require_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/customMainDrawer.php');

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

        <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>        
        <link href="../plugins/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
        <link href="../tables/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>

        <title>Mis Productos</title>

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
            MainDrawer();
            ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Cliente<small>Mis Productos</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Mis Productos</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">					

                        <div class="col-lg-12 col-md-12 col-xs-12">

                            <div class="box box-solid bg-light-blue-gradient">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Productos</h3>								
                                </div>                               

                                <div class="box-body">
                                    <div class="table-responsive" style="overflow-y: auto;">
                                        <table style="color: #000; border: 1px solid #000;" id="example" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Cliente</th>
                                                    <th>Categoria</th>
                                                    <th>Marca</th>
                                                    <th>Presentacion</th>
                                                    <th>Codigo Interno</th>
                                                    <th>Codigon CM</th>
                                                    <th>Codigo WM</th>
                                                    <th>Codigo de Barra</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($NivelAcceso == 1) { //Admin
                                                    // Esto es para mis productos
                                                    $sql = "SELECT planpromo_presentaciones.IdPresentacion , clientes.RazonSocial as Cliente,  Precios_CatCategorias.DescCategoria as Categorias, planpromo_marcas.Descripcion as marcas, 
                                                            planpromo_presentaciones.Descripcion as Presentaciones, `CodCafeSoluble`, `CodCasaMantica`, `CodigoWalmart`, `CodigoBarras` 
                                                            FROM `planpromo_presentaciones` INNER JOIN Precios_CatCategorias on planpromo_presentaciones.categoria = Precios_CatCategorias.idCategoria INNER JOIN 
                                                            clientes on planpromo_presentaciones.IdCliente = clientes.IdCliente inner join 
                                                            planpromo_marcas on planpromo_presentaciones.IdMarca=planpromo_marcas.IdMarca";

                                                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                                    mysqli_query($conn, "SET NAMES 'utf8'");
                                                    if ($result) {

                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo '<tr>
                                                                <td>' . $row['IdPresentacion'] . '</td>
                                                                <td>' . $row['Cliente'] . '</td>
                                                                <td>' . $row['Categorias'] . '</td>
                                                                <td>' . $row['marcas'] . '</td>
                                                                <td>' . $row['Presentaciones'] . '</td>
                                                                <td>' . $row['CodCafeSoluble'] . '</td>
                                                                <td>' . $row['CodCasaMantica'] . '</td>
                                                                <td>' . $row['CodigoWalmart'] . '</td>
                                                                <td>' . $row['CodigoBarras'] . '</td>
                                                              </tr>';
                                                        }
                                                    }
                                                }
                                                if ($NivelAcceso == 3 or $NivelAcceso == 4) { //Gerente Empresa
                                                    // esto es para mis precios
                                                    $sql = "SELECT clientes.RazonSocial as Cliente,  Precios_CatCategorias.DescCategoria as Categorias, planpromo_marcas.Descripcion as marcas, 
                                                        planpromo_presentaciones.Descripcion as Presentaciones, `CodCafeSoluble`, `CodCasaMantica`, `CodigoWalmart`, `CodigoBarras` 
                                                        FROM `planpromo_presentaciones` INNER JOIN Precios_CatCategorias on planpromo_presentaciones.categoria = Precios_CatCategorias.idCategoria INNER JOIN 
                                                        clientes on planpromo_presentaciones.IdCliente = clientes.IdCliente inner join 
                                                        planpromo_marcas on planpromo_presentaciones.IdMarca=planpromo_marcas.IdMarca WHERE planpromo_presentaciones.IdCliente = $idCliente";


                                                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                                    mysqli_query($conn, "SET NAMES 'utf8'");
                                                    if ($result) {

                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo '<tr>
                                                                <td>' . $row['Cliente'] . '</td>
                                                                <td>' . $row['Categorias'] . '</td>
                                                                <td>' . $row['marcas'] . '</td>
                                                                <td>' . $row['Presentaciones'] . '</td>
                                                                <td>' . $row['CodCafeSoluble'] . '</td>
                                                                <td>' . $row['CodCasaMantica'] . '</td>
                                                                <td>' . $row['CodigoWalmart'] . '</td>															
                                                                <td>' . $row['CodigoBarras'] . '</td>
                                                              </tr>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </tbody>

                                        </table
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
        <script src="../tables/jquery.dataTable.columnFilter.min.js" type="text/javascript"></script>
        <script>

            $(function () {
            $('#example').DataTable({
            "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
            });
        </script>
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