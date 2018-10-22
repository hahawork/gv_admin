<?php
session_start();

require_once '../customMainDrawer.php';

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: ../login/index.php');
    exit;
}

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];

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

        <title>Ingreso de productos</title>

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
                    <h1>Supervisión<small>Ingreso de productos</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Ingreso de productos</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">

                            <div class="box box-solid bg-green-active">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Productos propios</h3>
                                </div>
                                <form class="form-horizontal">
                                    <div class="box-body">
                                        <div class="form-group col-sm-6">
                                            <label for="selectCliente" class="col-sm-3 control-label" onchange="get_marcas(this.value);">Cliente:</label>
                                            <div class="col-sm-9">
                                                <select id="selectCliente" class="form-control">
                                                    <option disabled="" selected="" value="0">Seleccione...</option>
                                                </select>                                                
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="selectMarcas" class="col-sm-3 control-label">Marca:</label>
                                            <div class="col-sm-9">
                                                <select id="selectMarcas" class="form-control">                                                   
                                                    <option disabled="" selected="" value="0">Seleccione cliente...</option>
                                                </select>
                                            </div>                                            
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="txtCodInterno" class="col-sm-3 control-label">Cód. Interno:</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="txtCodInterno">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="txtCodMantica" class="col-sm-3 control-label">Cód. Mantica:</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="txtCodMantica">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="txtCodWalmart" class="col-sm-3 control-label">Cód. Walmart:</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="txtCodWalmart">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="txtCodBarra" class="col-sm-3 control-label">Cód. Barra:</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="txtCodBarra">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="txtDescripcion" class="col-sm-3 control-label">Descripción:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="txtDescripcion">
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="txtFecha" class="col-sm-3 control-label">Fecha:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="txtFecha" value="<?= date("Y-m-d") ?>" disabled="">
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="selectCanal" class="col-sm-3 control-label">Canal:</label>
                                            <div class="col-sm-9">
                                                <select id="selectCanal" class="form-control">

                                                </select>
                                            </div>                                            
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="selectCategoria" class="col-sm-3 control-label">Categoria:</label>
                                            <div class="col-sm-9">
                                                <select id="selectCategoria" class="form-control">
                                                    <option disabled="" selected="" value="0">Seleccione cliente </option>
                                                </select>
                                            </div>                                            
                                        </div>

                                        <div class="form-group col-sm-6 pull-right">
                                            <div class="col-sm-12">
                                                <div class="checkbox">
                                                    <label for="chkEstado">
                                                        <input type="checkbox" checked="" id="chkEstado"> Activo
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <div class="col-sm-12">
                                                <div class="checkbox">
                                                    <label for="chkAplicaFV">
                                                        <input type="checkbox" checked="" id="chkAplicaFV"> Aplica para fecha Vencim.
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <label for="selectPuntosDispon" class="col-sm-3 control-label">Puntos disponibles:</label>
                                            <div class="col-sm-9">
                                                <select multiple class="form-control" id="selectPuntosDispon">
                                                    <option value="*c*">La Colonia</option>
                                                    <option value="*u*">La Unión</option>
                                                    <option value="*mp*">Maxi Pali</option>
                                                    <option value="*p*">Pali</option>
                                                    <option value="*ws*">Walmart Sur</option>                                                       
                                                </select>
                                                <p class="help-block bg-danger"><sup>**</sup>Para seleccionar mas de uno (Ctrl + click)<sup>**</sup></p>
                                            </div>
                                        </div>

                                        <div id="seccionParaDicegsa" style="display: none;">
                                            <div class="form-group col-sm-6">
                                                <label for="txtDivisionDicegsa" class="col-sm-3 control-label">Division Dicegsa:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="txtDivisionDicegsa">
                                                </div>
                                            </div>                                            
                                            <div class="form-group col-sm-6">
                                                <label for="txtCodDeptoDicegsa" class="col-sm-3 control-label">Cód. Depto. Dicegsa:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="txtCodDeptoDicegsa">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-default" id="btnCancelarPropios">Cancelar</button>
                                        <button type="submit" class="btn btn-info pull-right" id="btnGuardarPropios">Guardar</button>
                                    </div>
                                    <!-- /.box-footer -->
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">

                            <div class="box box-solid bg-light-blue">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Productos competencia</h3>
                                </div>
                                <form class="form-horizontal">
                                    <div class="box-body">
                                        <div class="form-group col-sm-6">
                                            <label for="selectClienteCompet" class="col-sm-3 control-label" onchange="get_marcas(this.value);">Cliente:</label>
                                            <div class="col-sm-9">
                                                <select id="selectClienteCompet" class="form-control">
                                                    <option disabled="" selected="" value="0">Seleccione...</option>
                                                </select>                                                
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="selectCategoriaCompet" class="col-sm-3 control-label">Categoria:</label>
                                            <div class="col-sm-9">
                                                <select id="selectCategoriaCompet" class="form-control">
                                                    <option disabled="" selected="" value="0">Seleccione cliente </option>
                                                </select>
                                            </div>                                            
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="selectMarcasCompet" class="col-sm-3 control-label">Marca:</label>
                                            <div class="col-sm-9">
                                                <select id="selectMarcasCompet" class="form-control">                                                   
                                                    <option disabled="" selected="" value="0">Seleccione cliente...</option>
                                                </select>
                                            </div>                                            
                                        </div>



                                        <div class="form-group col-sm-6">
                                            <label for="selectCanalCompet" class="col-sm-3 control-label">Canal:</label>
                                            <div class="col-sm-9">
                                                <select id="selectCanalCompet" class="form-control">

                                                </select>
                                            </div>                                            
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <label for="txtDescripcionCompet" class="col-sm-3 control-label">Descripción:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="txtDescripcionCompet">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-default" id="btnCancelarCompetencia">Cancelar</button>
                                        <button type="submit" class="btn btn-info pull-right" id="btnGuardarCompetencia">Guardar</button>
                                    </div>
                                    <!-- /.box-footer -->
                                </form>
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
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../dist/js/app.min.js"></script>

        <script type="text/javascript">
                                                var idClienteUsuario = <?= $idCliente ?>;
                                                var NivelAcceso = <?= $NivelAcceso ?>;
                                                $(document).ready(function () {
                                                    //llena al cliente ******************************************
                                                    obtenerClientes(idClienteUsuario, NivelAcceso);
                                                    // llena canales
                                                    obtenerCanales(idClienteUsuario, NivelAcceso)
                                                    //cuando cambia el cliente************************************
                                                    $('#selectCliente').on('change', function () {
                                                        var idClientSelecc = $(this).val();
                                                        if (idClientSelecc) {

                                                            if (idClientSelecc == 6) {
                                                                $("#seccionParaDicegsa").show();
                                                            } else {
                                                                $("#seccionParaDicegsa").hide();
                                                            }
                                                            obtenerMarcas(idClientSelecc, NivelAcceso);
                                                            obtenerCategorias(idClientSelecc, NivelAcceso);
                                                            obtenerMarcasCompetencias(idClientSelecc, NivelAcceso)
                                                        }
                                                    });
                                                    $('#selectClienteCompet').on('change', function () {
                                                        var idClientSelecc = $(this).val();
                                                        if (idClientSelecc) {
                                                            obtenerMarcasCompetencias(idClientSelecc, NivelAcceso)
                                                            obtenerCategorias(idClientSelecc, NivelAcceso)
                                                        }
                                                    });
                                                });
                                                function obtenerClientes(idCliente, NivelAcceso) {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'recursos/frmAgregarProducto_data.php',
                                                        data: {opcion: 'clientes', idCliente: idCliente, NivelAcceso: NivelAcceso},
                                                        success: function (html) {
                                                            $('#selectCliente').html(html);
                                                            $('#selectClienteCompet').html(html);
                                                        }
                                                    });
                                                }
                                                function obtenerCanales(idCliente, NivelAcceso) {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'recursos/frmAgregarProducto_data.php',
                                                        data: {opcion: 'canales', idCliente: idCliente, NivelAcceso: NivelAcceso},
                                                        success: function (html) {
                                                            $('#selectCanal').html(html);
                                                            $('#selectCanalCompet').html(html);
                                                        }
                                                    });
                                                }
                                                function obtenerMarcas(idCliente, NivelAcceso) {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'recursos/frmAgregarProducto_data.php',
                                                        data: {opcion: 'marcas', idCliente: idCliente, NivelAcceso: NivelAcceso},
                                                        success: function (html) {
                                                            $('#selectMarcas').html(html);
                                                        }
                                                    });
                                                }
                                                function obtenerCategorias(idCliente, NivelAcceso) {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'recursos/frmAgregarProducto_data.php',
                                                        data: {opcion: 'categorias', idCliente: idCliente, NivelAcceso: NivelAcceso},
                                                        success: function (html) {
                                                            $('#selectCategoria').html(html);
                                                            $('#selectCategoriaCompet').html(html);
                                                        }
                                                    });
                                                }
                                                function obtenerMarcasCompetencias(idCliente, NivelAcceso) {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'recursos/frmAgregarProducto_data.php',
                                                        data: {opcion: 'marcascompetencias', idCliente: idCliente, NivelAcceso: NivelAcceso},
                                                        success: function (html) {
                                                            $('#selectMarcasCompet').html(html);
                                                        }
                                                    });
                                                }


                                                //cuando se le da clic al boton de guardar productos propios
                                                $("#btnGuardarPropios").click(function () {

                                                    var IdCliente = $("#selectCliente").val();
                                                    var IdMarca = $("#selectMarcas").val();
                                                    var CodCafeSoluble = $("#txtCodInterno").val();
                                                    var CodCasaMantica = $("#txtCodMantica").val();
                                                    var CodigoWalmart = $("#txtCodWalmart").val();
                                                    var CodigoBarras = $("#txtCodBarra").val();
                                                    var Descripcion = $("#txtDescripcion").val();
                                                    var FechaRegistro = $("#txtFecha").val();
                                                    var IdCanal = $("#selectCanal").val();
                                                    var categoria = $("#selectCategoria").val();
                                                    var EstadoActivo = $("#chkEstado").is(":checked") ? 1 : 0;
                                                    var Aplica_FV = $("#chkAplicaFV").is(":checked") ? 1 : 0;
                                                    var Division_Disegsa = $("#txtDivisionDicegsa").val();
                                                    var TipoPDV_disponible = [];
                                                    $("#selectPuntosDispon :selected").each(function () {
                                                        TipoPDV_disponible.push($(this).val());
                                                    });
                                                    var cod_dep_disegsa = $("#txtCodDeptoDicegsa").val();
                                                    if (IdCliente > 0 &&
                                                            IdMarca > 0 &&
                                                            Descripcion.length > 0
                                                            ) {
                                                        $.ajax({
                                                            type: 'POST',
                                                            dataType: 'json',
                                                            url: 'recursos/frmAgregarProducto_data.php',
                                                            data: {opcion: 'guardarpropios',
                                                                IdCliente: IdCliente,
                                                                IdMarca: IdMarca,
                                                                CodCafeSoluble: CodCafeSoluble,
                                                                CodCasaMantica: CodCasaMantica,
                                                                CodigoWalmart: CodigoWalmart,
                                                                CodigoBarras: CodigoBarras,
                                                                Descripcion: Descripcion,
                                                                FechaRegistro: FechaRegistro,
                                                                IdCanal: IdCanal,
                                                                categoria: categoria,
                                                                EstadoActivo: EstadoActivo,
                                                                Aplica_FV: Aplica_FV,
                                                                Division_Disegsa: Division_Disegsa,
                                                                TipoPDV_disponible: TipoPDV_disponible.join(),
                                                                cod_dep_disegsa: cod_dep_disegsa
                                                            },
                                                            success: function (html) {
                                                                if (html.success == 1) {
                                                                    alert(html.Mensaje);
                                                                    location.reload();
                                                                } else {
                                                                    alert(html.Mensaje);
                                                                }
                                                            },
                                                            error: function (jqXHR, textStatus, errorThrown) {
                                                                alert(textStatus + ", error: " + errorThrown);
                                                            }
                                                        });
                                                    }
                                                    return false;
                                                });
                                                //______________________________________________________________

                                                //cuando se le da clic al boton de guardar productos Competencia
                                                $("#btnGuardarCompetencia").click(function () {

                                                    var idMarcaCompete = '0';
                                                    var NombreMarcaCompete = "";
                                                    var idMarcaCompetePadre = $("#selectMarcasCompet").val();
                                                    var NombrePresentCompete = $("#txtDescripcionCompet").val();
                                                    var FechaReg = $("#txtFecha").val();
                                                    var Categoria = $("#selectCategoriaCompet").val();
                                                    var Cliente = $("#selectClienteCompet").val();
                                                    var idCanalCompete = $("#selectCanalCompet").val();
                                                    if (Cliente > 0 &&
                                                            idMarcaCompetePadre > 0 &&
                                                            NombrePresentCompete.length > 0
                                                            ) {
                                                        $.ajax({
                                                            type: 'POST',
                                                            dataType: 'json',
                                                            url: 'recursos/frmAgregarProducto_data.php',
                                                            data: {opcion: 'guardarcompetencia',
                                                                idMarcaCompete: idMarcaCompete,
                                                                NombreMarcaCompete: NombreMarcaCompete,
                                                                idMarcaCompetePadre: idMarcaCompetePadre,
                                                                NombrePresentCompete: NombrePresentCompete,
                                                                FechaReg: FechaReg,
                                                                Categoria: Categoria,
                                                                Cliente: Cliente,
                                                                idCanalCompete: idCanalCompete
                                                            },
                                                            success: function (html) {
                                                                if (html.success == 1) {
                                                                    alert(html.Mensaje);
                                                                    location.reload();
                                                                } else {
                                                                    alert(html.Mensaje);
                                                                }
                                                            },
                                                            error: function (jqXHR, textStatus, errorThrown) {
                                                                alert(textStatus + ", error: " + errorThrown);
                                                            }
                                                        });
                                                    }
                                                    return false;
                                                });
                                                //______________________________________________________________

        </script>
    </body>
</html>