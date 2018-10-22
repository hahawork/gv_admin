<?php
session_start();

$Servidor = 'http://' . $_SERVER['HTTP_HOST'] . "/admin/"; //$_SERVER['PHP_SELF'] . "/admin/";// obtiene la ruta del DNS : http://grupovalor.com.ni/

if (!$_SESSION["sUserId"]) {
    header('Location: ../login/index.php');
    exit;
}

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];

// esto esc para desavbilitar algunos enlaces
$admin = 'disabled';
if ($NivelAcceso == 1) {
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

        <title>Reporte de Fechas de Vencimientos del: <?php echo $FechaIni . " al " . $FechaFin; ?></title>

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

                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <form method="post" action="ReporteFechaVencimientos_formato_cssa.php">
                                        <div class=" col-xl-12 col-md-12 col-xs-12">
                                            <div class="col-sm-12" style="color: #000;">
                                                <span>Desde: </span>
                                                <input type="date" width="50px" name="txtFechaDesde" placeholder="yyyy-mm-dd" value="<?php echo $FechaIni; ?>" min="2017-03-15" max="<?php echo date("Y-m-d") ?>">
                                                <span>Hasta: </span>
                                                <input type="date" width="50px" name="txtFechaHasta" placeholder="yyyy-mm-dd" value="<?php echo $FechaFin; ?>" min="2017-03-15" max="<?php echo date("Y-m-d") ?>">
                                                <input type="submit" name="btnConsultar" value="Consultar" class="btn btn-primary">
                                                <!--<button onclick = "write_to_excel()" id = "btnExport" class = "btn btn-success">Exportar a excel</button>-->
                                                <input type = "button" value = "Copiar Tabla" id = "btnCopiar" class = "btn btn-info" onclick = "selectElementContents(document.getElementById('example1'))">
                                            </div>
                                            <div class="col-12">
                                                <input type="text" id="txtBuscar" onkeyup="myFunction()" placeholder="Ingrese el filtro...">

                                                <style type="text/css">
                                                    #txtBuscar {
                                                        background-image: url('../dist/css/search.png'); /* Add a search icon to input */
                                                        background-position: 10px 12px; /* Position the search icon */
                                                        background-repeat: no-repeat; /* Do not repeat the icon image */
                                                        width: 100%; /* Full-width */
                                                        font-size: 16px; /* Increase font-size */
                                                        padding: 12px 20px 12px 40px; /* Add some padding */
                                                        border: 1px solid #ddd; /* Add a grey border */
                                                        margin-bottom: 12px; /* Add some space below the input */
                                                    }
                                                </style>
                                                <script>
                                                    function myFunction() {
                                                        // Declare variables 
                                                        var input, filter, table, tr, td, i;
                                                        input = document.getElementById("txtBuscar");
                                                        //filter = input.value.toUpperCase();
                                                        table = document.getElementById("example1");
                                                        tr = table.getElementsByTagName("tr");

                                                        // Loop through all table rows, and hide those who don't match the search query
                                                        for (i = 0; i < tr.length; i++) {
                                                            td = tr[i].getElementsByTagName("td")[2];
                                                            if (td) {
                                                                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                                                    tr[i].style.display = "";
                                                                } else {
                                                                    tr[i].style.display = "Ningún registro encontrado.";
                                                                }
                                                            }
                                                        }
                                                    }
                                                </script>
                                            </div>

                                        </div>
                                    </form>
                                </div>                                

                                <div class="box-body">                                    
                                    <div style="overflow: auto;">
                                        <table  id="example1" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <td style="height: 100px;">
                                                        <img src="cssa.png" alt="" width="100px" height="100px">
                                                    </td>
                                                    <td colspan="8">
                                                        <table style="width: 100%;">
                                                            <tr><td style="color: rgb(51,153,255); text-align: center;" colspan="14"><h4><b>CAFÉ SOLUBLE, S.A</b></h4></td></tr>
                                                            <tr><td style="color: rgb(51,153,255); text-align: center;" colspan="14"><h5>Managua, Nicaragua</h5></td></tr>
                                                            <tr><td style="color: rgb(51,153,255); text-align: center;" colspan="14"><h4><b>REPORTE DE FECHAS DE VENCIMIENTO.</b></h4></td></tr>
                                                            <tr></tr>
                                                            <tr></tr>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr style="background: rgb(91,155,213); color: #fff;  border: 1px solid rgb(91,155,213);">
                                                    <th>Zona</th>
                                                    <th>Cliente</th>
                                                    <th>Grupo</th>
                                                    <th>Display</th>
                                                    <th>ProductoCSSA</th>
                                                    <th>Marca</th>
                                                    <th>Cód ProductoCliente</th>
                                                    <th>Cantidad</th>
                                                    <th>Vencimiento</th>
                                                    <th>Promocional</th>
                                                    <th>Cant. en bandeo</th>
                                                    <th>Marca Promocional</th>
                                                    <th>Presentación</th>
                                                    <th>Cant Promocional</th>
                                                    <th>Observacion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_POST['btnConsultar'])) {

                                                    $idUsu = $_SESSION["sIdUsuario"];
                                                    $cliente = $_SESSION["sIdCliente"];

                                                    $sql = "";

                                                    if ($NivelAcceso == 1) {
                                                        $sql = "SELECT can.NombreCanal,dpt.NombreDepto, pdv.NombrePdV, NombreReprPdV, marc.Descripcion as Marca, present.Descripcion as Presentacion, 
                                                        CONCAT(DAY(fvd.fechaVenc),' ',ELT(DATE_FORMAT(fvd.fechaVenc, '%m'),'Enero','Febrero','Marzo','Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 
                                                        'Septiembre', 'Octubre', 'Noviembre','Diciembre'),' ',YEAR(fvd.fechaVenc)) as fechaVenc, fvd.CantidadExist, fvd.CantidadBandeo, fvd.TipoBandeo, present.CodCafeSoluble, 
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
                                                        WHERE fve.IdCliente = '$idCliente' and 
                                                        fve.fechaReg BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY) 
                                                        GROUP BY fve.idpdv, fve.idPresentacion, fvd.fechaVenc, fve.idUsuario
                                                        ORDER BY fve.fechaReg DESC";
                                                    }

                                                    if ($NivelAcceso == 4) {
                                                        $sql = "SELECT can.NombreCanal,dpt.NombreDepto, pdv.NombrePdV, NombreReprPdV, marc.Descripcion as Marca, present.Descripcion as Presentacion, 
                                                        CONCAT(DAY(fvd.fechaVenc),' ',ELT(DATE_FORMAT(fvd.fechaVenc, '%m'),'Enero','Febrero','Marzo','Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 
                                                        'Septiembre', 'Octubre', 'Noviembre','Diciembre'),' ',YEAR(fvd.fechaVenc)) as fechaVenc, fvd.CantidadExist, fvd.CantidadBandeo, fvd.TipoBandeo, present.CodCafeSoluble, 
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
                                                    } else {
                                                        $sql = "SELECT can.NombreCanal,dpt.NombreDepto, pdv.NombrePdV, NombreReprPdV, marc.Descripcion as Marca, present.Descripcion as Presentacion, 
                                                        CONCAT(DAY(fvd.fechaVenc),' ',ELT(DATE_FORMAT(fvd.fechaVenc, '%m'),'Enero','Febrero','Marzo','Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 
                                                        'Septiembre', 'Octubre', 'Noviembre','Diciembre'),' ',YEAR(fvd.fechaVenc)) as fechaVenc, fvd.CantidadExist, fvd.CantidadBandeo, fvd.TipoBandeo, present.CodCafeSoluble, 
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
                                                        (fve.IdCliente = $idCliente)
                                                        GROUP BY fve.idpdv, fve.idPresentacion, fvd.fechaVenc, fve.idUsuario
                                                        ORDER BY fve.fechaReg DESC";
                                                    }

                                                    $result = mysqli_query($conn, $sql);
                                                    mysqli_query($conn, "SET NAMES 'utf8'");
                                                    if ($result) {

                                                        while ($row = mysqli_fetch_array($result)) :
                                                            ?>
                                                            <tr style="background: rgb(222,234,246);  color: #000; border: 1px rgb(91,155,213);">
                                                                <td><?php echo ($row['NombreDepto']); ?></td>
                                                                <td><?php echo ($row['NombrePdV']); ?></td>
                                                                <td></td>
                                                                <td><?php echo ($row['NombreUsuario']); ?></td>
                                                                <td><?php echo ($row['CodCafeSoluble'] . " - " . $row['Presentacion']); ?></td>
                                                                <td><?php echo ($row['Marca']); ?></td>
                                                                <td><?php echo ($row['CodCasaMantica']); ?></td>
                                                                <td><?php echo ($row['CantidadExist']); ?></td>
                                                                <td><?php echo ($row['fechaVenc']); ?></td>
                                                                <td><?php echo ($row['TipoBandeo']); ?></td>
                                                                <td><?= $row['CantidadBandeo']; ?></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>                                                                
                                                                <td></td>
                                                            </tr>

                                                            <?php
                                                        endwhile;
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

<script>
                                                    function selectElementContents(el) {
                                                        var body = document.body, range, sel;
                                                        if (document.createRange && window.getSelection) {
                                                            range = document.createRange();
                                                            sel = window.getSelection();
                                                            sel.removeAllRanges();
                                                            try {
                                                                range.selectNodeContents(el);
                                                                sel.addRange(range);
                                                            } catch (e) {
                                                                range.selectNode(el);
                                                                sel.addRange(range);
                                                            }
                                                        } else if (body.createTextRange) {
                                                            range = body.createTextRange();
                                                            range.moveToElementText(el);
                                                            range = body.createTextRange();
                                                            range.moveToElementText(el);
                                                            range.select();
                                                        }

                                                        document.execCommand("Copy");

                                                        alert("Se ha copiado la tabla con éxito, En excel seleccione una celda y péguelo!");
                                                    }

                                                    function write_to_excel()
                                                    {
                                                        var tableID = "example1";
                                                        selectElementContents(document.getElementById(tableID));

                                                        var excel = new ActiveXObject("Excel.Application");
                                                        // excel.Application.Visible = true; 
                                                        var wb = excel.WorkBooks.Add();
                                                        var ws = wb.Sheets("Sheet1");
                                                        ws.Cells(1, 1).Select;
                                                        ws.Paste;
                                                        ws.DrawingObjects.Delete;
                                                        ws.Range("A1").Select
                                                        excel.Application.Visible = true;
                                                    }
</script>

</body>
</html>