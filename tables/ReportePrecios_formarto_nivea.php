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

if (isset($_POST['btnDescargar'])) {
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename='ReportePrecios($FechaIni al $FechaFin).xls'");
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

        <title>Reporte de Precios del: <?php echo $FechaIni . " al " . $FechaFin; ?></title>

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

        <!-- Main content -->
        <section class="content">
            <div class="row">					

                <div class="col-lg-12 col-md-12 col-xs-12">

                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Reporte de Precios</h3>								
                        </div>

                        <form method="post" action="ReportePrecios_formarto_nivea.php" id="form_botones">
                            <div class=" col-xl-12 col-md-12 col-xs-12">
                                <div class=" col-xl-3 col-md-3 col-xs-1"></div>
                                <div class="col-xl-6 col-md-9 col-xs-12" style="color: #000;">
                                    <span>Desde: </span>
                                    <input type="date" width="50px" name="txtFechaDesde" placeholder="yyyy-mm-dd" value="<?php echo $FechaIni; ?>" min="2017-04-15" max="<?php echo date("Y-m-d") ?>">
                                    <span>Hasta: </span>
                                    <input type="date" width="50px" name="txtFechaHasta" placeholder="yyyy-mm-dd" value="<?php echo $FechaFin; ?>" min="2017-04-15" max="<?php echo date("Y-m-d") ?>">                                            

                                    <?php
                                    if (isset($_POST['btnDescargar'])) {
                                        
                                    } else {

                                        echo '<input type = "submit" name = "btnConsultar" id = "btnConsultar" value = "Consultar" class = "btn btn-primary">
                                        <!--<button onclick = "$(\'#btnConsultar\').click() || .submit()" class = "btn btn-success">Consultar</button> -->

                                        <input type = "submit" name = "btnDescargar" id = "btnDescargar" value = "Descargar Excel" class = "btn btn-success">


                                        <input type = "button" value = "Copiar Tabla" id = "btnCopiar" class = "btn btn-info" onclick = "selectElementContents(document.getElementById(\'example1\'))">
                                        <button style = "display: none;" onclick = "write_to_excel()" id = "btnExport" class = "btn btn-success">Export to excel</button> ';
                                    }
                                    ?>
                                </div>
                                <div class=" col-xl-3 col-md-1 col-xs-1">	                                		                                  
                                </div>
                            </div>
                        </form>

                        <div class="box-body">
                            <style type="text/css">
                                table, tr, td{
                                    border: 1px solid;
                                }
                            </style>
                            <table id="example1" name="example1" class="example1 table table-bordered table-responsive table-hover table-condensed">

                                <?php
                                $sqlMarcas = "SELECT DISTINCT planpromo_marcas.IdMarca, planpromo_marcas.Descripcion, planpromo_marcas.IdCategoria "
                                        . "FROM `Precios_MisPrecios` INNER JOIN "
                                        . "planpromo_marcas on Precios_MisPrecios.idMiMarca = planpromo_marcas.IdMarca "
                                        . "WHERE idClienteMP = 7 and Precios_MisPrecios.FechaReg between '" . $FechaIni . "' and '" . $FechaFin . "' "
                                        . "ORDER BY Precios_MisPrecios.FechaReg DESC";




                                $resultMarcas = mysqli_query($conn, $sqlMarcas);
                                if ($resultMarcas) {

                                    if (mysqli_num_rows($resultMarcas) > 0) {

                                        while ($row = mysqli_fetch_array($resultMarcas)):
                                            ?>

                                            <tr style="background: #003366; color: #FFF;">
                                                <th>COD</th>
                                                <th>Código barra</th>
                                                <th><?php echo ($row['Descripcion']); ?></th>
                                                <th>Item WM</th>
                                                <th>COD CM</th>
                                                <th>Precio</th>
                                                <th class="noExl">Fecha</th>
                                                <th class="noExl">Usuario</th>
                                                <th class="noExl">Punto Venta</th>
                                            </tr>  

                                            <?php
                                            $sqlPresentaciones = "SELECT DISTINCT planpromo_presentaciones.CodCafeSoluble, planpromo_presentaciones.CodigoBarras, "
                                                    . "planpromo_presentaciones.Descripcion, planpromo_presentaciones.CodigoWalmart, planpromo_presentaciones.CodCasaMantica, "
                                                    . "Precios_MisPrecios.MiPrecio, Precios_MisPrecios.FechaReg, usuario.NombreUsuario, puntosdeventa.NombrePdV FROM `Precios_MisPrecios` INNER JOIN planpromo_presentaciones ON "
                                                    . "Precios_MisPrecios.idMiPresentacion = planpromo_presentaciones.IdPresentacion inner join usuario on Precios_MisPrecios.idUsuario = "
                                                    . "usuario.idUsuario inner join puntosdeventa on puntosdeventa.IdPdV = Precios_MisPrecios.idPdV  WHERE planpromo_presentaciones.IdMarca = " . $row['IdMarca'] .
                                                    " and Precios_MisPrecios.FechaReg between '" . $FechaIni . "' and '" . $FechaFin . "'  "
                                                    . "ORDER BY Precios_MisPrecios.FechaReg DESC";


                                            $resultPresent = mysqli_query($conn, $sqlPresentaciones);
                                            if ($resultPresent) {
                                                if (mysqli_num_rows($resultPresent)) {
                                                    while ($row1 = mysqli_fetch_array($resultPresent)):
                                                        ?>

                                                        <tr>
                                                            <th><?php echo $row1['CodCafeSoluble']; ?></th>
                                                            <th><?php echo $row1['CodigoBarras']; ?></th>
                                                            <th><?php echo ($row1['Descripcion']); ?></th>
                                                            <th><?php echo $row1['CodigoWalmart']; ?></th>
                                                            <th><?php echo $row1['CodCasaMantica']; ?></th>
                                                            <th><?php echo $row1['MiPrecio']; ?></th>
                                                            <th class="noExl"><?php echo $row1['FechaReg']; ?></th>
                                                            <th class="noExl"><?php echo ($row1['NombreUsuario']); ?></th>
                                                            <th class="noExl"><?php echo ($row1['NombrePdV']); ?></th>


                                                        </tr> 
                                                        <?php
                                                    endwhile; // fin while presentaciones
                                                }// fin filas presentaciones
                                            }// fin si consulta presentaciones


                                            $sqlCompetencias = "SELECT precios_competenciapresentacion.NombrePresentCompete, precios_competenciaprecio.CompPrecio, precios_competenciaprecio.FechaReg, "
                                                    . "usuario.NombreUsuario, puntosdeventa.NombrePdV "
                                                    . "FROM `precios_competenciaprecio` INNER "
                                                    . "JOIN precios_competenciapresentacion ON precios_competenciaprecio.idPresentComp = precios_competenciapresentacion.idPresentComp INNER JOIN "
                                                    . " usuario on usuario.idUsuario = precios_competenciaprecio.idUsuario inner join puntosdeventa on "
                                                    . " puntosdeventa.IdPdV = precios_competenciaprecio.idPdv "
                                                    . "WHERE precios_competenciaprecio.idCategComp = " . $row['IdCategoria']
                                                    . " and precios_competenciaprecio.FechaReg between '" . $FechaIni . "' and '" . $FechaFin . "' "
                                                    . "ORDER BY precios_competenciaprecio.FechaReg DESC";


                                            $resulCompet = mysqli_query($conn, $sqlCompetencias);
                                            if ($resulCompet) {
                                                if (mysqli_num_rows($resulCompet) > 0) {

                                                    // crea la linea que dice competencias-->
                                                    echo '<tr>
                                                                <th colspan="9" style="background: #ffcc00; color: #000; text-align:center; ">Competencias</th>                                                        
                                                                </tr>';
                                                    while ($row2 = mysqli_fetch_array($resulCompet)) :
                                                        ?>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th><?php echo ($row2['NombrePresentCompete']); ?></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th><?php echo $row2['CompPrecio']; ?></th>
                                                            <th class="noExl"><?php echo $row2['FechaReg']; ?></th>
                                                            <th class="noExl"><?php echo ($row1['NombreUsuario']); ?></th>
                                                            <th class="noExl"><?php echo ($row1['NombrePdV']); ?></th>
                                                        </tr> 
                                                        <?php
                                                    endwhile;
                                                }
                                            }
                                            ?>


                                            <?php
                                        endwhile; //fin del whie marcas 
                                    } // fin cantidad filas marcas
                                }// fin si consulta marcas
                                ?>                                                                                                                                                               
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /.row (main row) -->

    </section> <!-- /.content -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>.</b>
        </div>
        <strong>&copy; 2017 <a href="#">Grupo Valor sa.</a>.</strong> Todos los derechos reservados.
    </footer>

    <!--------------- seleccionar la tabla para  luego copiar y pegar---------------------->
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

    <!----- Esto descarga una tabla pero sin color ni formato--------->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="jquery.table2excel.js"></script>
    <script>
        $("#btnExport1").click(function () {
            $("#example1").table2excel({
                // exclude CSS class
                include: "style",
                exclude: ".noExl",
                name: "AutoServicios",
                filename: "ReportePrecios" //do not include extension
            });
        });
<!----------------------------------------------------------------------->
    </script>



</body>
</html>