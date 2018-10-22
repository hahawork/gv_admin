<?php
session_start();
header("Content-Type: text/html;charset=utf-8");

require_once '../customMainDrawer.php';
require_once("../conexion/sw_conexion.php");
//Se crea nuevo objeto de la clase conexion para la base de datos del sist web
$cnn_sw = new sw_conexion();
$conn_sw = $cnn_sw->sw_conectar();

require_once("../conexion/conexion.php");
//Se crea nuevo objeto de la clase conexion para la base de datos 22334_grupovalordb
$cnn = new conexion();
$conn = $cnn->conectar();

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header("Location: ../login/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" type="image/png" href="../favicon.png">	
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../dist/css/AdminLTE.css">
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
        <title>Configuración de seguridad</title>
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
                    <h1>Supervisión<small>Panel de Control</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo "$Servidor"; ?>index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Panel de control</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">

                        <div class="col-xs-12">

                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Arbol de accesos</h3>
                                </div>
                                <!-- /.box-header -->                                                                
                                <div class="box-body">

                                    <div class="row">

                                        <style type="text/css">
                                            #ulListaUsuario li a {
                                                border: 1px solid #ddd; /* Add a border to all links */
                                                margin: 0px; /* Prevent double borders */
                                                background-color: #f6f6f6; /* Grey background color */
                                                padding: 5px; /* Add some padding */
                                                text-decoration: none; /* Remove default text underline */                                                
                                                color: black; /* Add a black text color */
                                                display: block; /* Make it into a block element to fill the whole list */
                                            }

                                            #ulListaUsuario li a:hover:not(.header) {
                                                background-color: #eee; /* Add a hover effect to all links, except for headers */
                                            }
                                        </style>

                                        <div class="col-sm-12">
                                            <div class="col-sm-4">
                                                <h2>Usuarios</h2>
                                                <div class="box box-solid bg-blue-gradient">
                                                    <div class="box-header">
                                                        <i class="fa fa-user"></i>
                                                        <h4 class="box-title">
                                                            Usuarios
                                                        </h4>
                                                        <input type="text" class="pull-right text-black" id="InputBuscarUsuario">
                                                    </div>

                                                    <div class="box-body no-padding text-black" style="height: 500px; overflow-y: auto;">
                                                        <ul class="list-group" id="ulListaUsuario">
                                                            <?php
                                                            //esto es para cargar la lista de usuariios desde la bease de datos
                                                            $sql_usuario = "SELECT `iduc`,`NombreUsuario`, RazonSocial "
                                                                    . "FROM `LoginusuarioSesion` LEFT OUTER JOIN "
                                                                    . "clientes on LoginusuarioSesion.IdCliente = clientes.IdCliente "
                                                                    . "WHERE EstadoActivo = 1 "
                                                                    . "ORDER BY NombreUsuario";

                                                            $result_usuario = mysqli_query($conn, $sql_usuario);
                                                            if ($result_usuario) {
                                                                echo '<table class="table table-bordered table-condensed" id="tblUsuarios">';
                                                                while ($row1 = mysqli_fetch_assoc($result_usuario)) {
                                                                    $_iduser = $row1['iduc'];
                                                                    ?>
                                                                    <tr>
                                                                        <td>                                                                    
                                                                            <label for="rbUsuario<?= $_iduser ?>"><?php echo ($row1["NombreUsuario"] . " .:. " . $row1["RazonSocial"]); ?></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="radio" name="rbUsuarios" onchange="onRBUsuariosChange(<?= $_iduser ?>)" id="rbUsuario<?= $_iduser ?>" class="pull-righ">
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                echo '</table>';
                                                            }
                                                            ?>                                                                    
                                                        </ul>                                                        
                                                    </div>                                                    
                                                </div>

                                            </div>

                                            <div class="col-sm-8">
                                                <h2>Items</h2>
                                                <form action="" method="get" name="frmcheckboxs">
                                                    <?php
                                                    //esto es cada seccion de la base sistema web
                                                    $sql_seccion = "SELECT `idMenuSecciones`, `NombreSeccion`, ClaseParaIcono FROM `tbl_sistemaweb_menu_secciones`";
                                                    $resultSecciones = mysqli_query($conn_sw, $sql_seccion);
                                                    if ($resultSecciones) {
                                                        while ($row2 = mysqli_fetch_assoc($resultSecciones)) {
                                                            ?>
                                                            <div class="col-sm-6 col-md-4">
                                                                <div class="panel-group" style="margin: 2px;">
                                                                    <div class="panel panel-info">
                                                                        <div class="panel-heading">
                                                                            <h4 class="panel-title">
                                                                                <a data-toggle="collapse" href="#collapse<?php echo $row2['idMenuSecciones']; ?>"> <i class="<?php echo ($row2["ClaseParaIcono"]); ?>"></i> <?php echo ($row2["NombreSeccion"]); ?></a>
                                                                            </h4>
                                                                        </div>
                                                                        <div id="collapse<?php echo $row2['idMenuSecciones']; ?>" class="panel-collapse collapse in">

                                                                            <ul class="list-group">
                                                                                <?php
                                                                                //esto es para obtener cada item de cada seccion
                                                                                $sql_item = "SELECT `idMenuItem`,`idMenuSeccion`,`NombreMenuItem`, ClaseIconoItem FROM `tbl_sistemaweb_menu_items` WHERE `idMenuSeccion` = " . $row2['idMenuSecciones'];
                                                                                $resultItem = mysqli_query($conn_sw, $sql_item);
                                                                                if ($resultItem) {
                                                                                    while ($row3 = mysqli_fetch_assoc($resultItem)) {
                                                                                        $id = $row2['idMenuSecciones'] . "_" . $row3['idMenuItem']; // esto es para el id del checkbox
                                                                                        $onchange = $row2['idMenuSecciones'] . "," . $row3['idMenuItem']; // esto es pra los parametros del cambio d estado del checkbox
                                                                                        ?>
                                                                                        <li class="list-group-item">
                                                                                            <input type="checkbox" class="pull-left" id="<?php echo $id; ?>" onchange="onCHKItemChanged(<?php echo $onchange ?>, this)" name="items"> 
                                                                                            <i class="<?php echo ($row3["ClaseIconoItem"]); ?>"></i> 
                                                                                            <?php echo ($row3["NombreMenuItem"]); ?>
                                                                                        </li>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>                                                                                    
                                                                            </ul>   
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>  
                                                </form>
                                            </div>

                                        </div>                                        
                                    </div>                                
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <input type="submit" class="btn btn-info pull-right" name="btnGuardar" value="Guardar" />
                                </div>
                                <!-- /.box-footer -->                               
                            </div>
                            <!-- /.box -->
                        </div>

                        <div class="col-xs-12 col-md-6">

                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Agregar sección</h3>
                                </div>
                                <!-- /.box-header -->                                                                
                                <div class="box-body">
                                    <!--Nombre de la seccion-->
                                    <div id="divtxtNombreSeccion" class="form-group">
                                        <label for="txtNombreSeccion" class="col-sm-3 control-label">Nombre Sección:</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" name="txtNombreSeccion" id="txtNombreSeccion" placeholder="Ajustes">
                                        </div>
                                        <div class="col-sm-9 col-sm-offset-3">                                                                                                
                                            <span id="spantxtNombreSeccion" class="help-block" style="display: none;">Por favor ingrese el nombre de la sección.</span>
                                        </div>
                                    </div>
                                    <!--**************************************-->
                                    <!--clase para el icono de la seccion-->
                                    <div id="divtxtClaseParaIcono" class="form-group">
                                        <label for="txtClaseParaIcono" class="col-sm-3 control-label">Clase para icono:</label>
                                        <div class="col-sm-9 input-group">                                            
                                            <input class="form-control" name="txtClaseParaIcono" id="txtClaseParaIcono" placeholder="fa fa-setting">
                                            <span class="input-group-btn">
                                                <a href="/admin/pages/UI/icons.html" class="btn btn-warning btn-flat">?</a>
                                            </span>
                                        </div>
                                        <div class="col-sm-9 col-sm-offset-3">                                                                                                
                                            <span id="spatxtClaseParaIcono" class="help-block" style="display: none;">Por favor ingrese la clase de referencia del icono.</span>
                                        </div>
                                    </div>
                                    <!--**************************************-->
                                    <!--clase para el icono de la seccion-->
                                    <div id="divtxtPosicionSeccion" class="form-group">
                                        <label class="col-sm-3 control-label" for="txtPosicionSeccion">Posicion dela sección</label>
                                        <div class="col-sm-9">                                            
                                            <input id="txtPosicionSeccion" class="form-control" type="number" value="0">
                                        </div>
                                        <div class="col-sm-9 col-sm-offset-3">                                                                                                
                                            <span id="spantxtPosicionSeccion" class="help-block" style="display: none;">Por favor ingrese la posicion que se mostrará la sección.</span>
                                        </div>
                                    </div>
                                    <!--**************************************-->
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <input type="submit" class="btn btn-info pull-right" name="btnGuardar" value="Guardar" onclick="guardarEditarSeccion();"/>
                                </div>
                                <!-- /.box-footer -->                               
                            </div>
                            <!-- /.box -->
                        </div>

                        <div class="col-xs-12 col-md-6">

                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Agregar Item de sección</h3>
                                </div>
                                <!-- /.box-header -->                                                                
                                <div class="box-body">
                                    <!--Lista de seccione -->
                                    <div id="divselidMenuSeccion" class="form-group">
                                        <label for="selectNombreSeccionItems" class="col-sm-3 control-label">Nombre Sección:</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="selectNombreSeccionItems" id="selectNombreSeccionItems">
                                                <option value="0" disabled="" selected="">Seleccione una sección</option>
                                                <?php
                                                $result = mysqli_query($conn_sw, "SELECT * FROM `tbl_sistemaweb_menu_secciones` WHERE EstadoActivo = 1");
                                                if ($result and mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_array($result)):
                                                        ?>
                                                        <option value="<?php echo $row["idMenuSecciones"]; ?>"><?php echo ($row["NombreSeccion"]); ?></option>
                                                        <?php
                                                    endwhile;
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-9 col-sm-offset-3">                                                                                                
                                            <span id="spanselidMenuSeccion" class="help-block" style="display: none;">Por favor una sección.</span>
                                        </div>
                                    </div>
                                    <!--**************************************-->
                                    <!--clase para el icono de la seccion-->
                                    <div id="divtxtNombreItem" class="form-group">
                                        <label for="txtNombreItem" class="col-sm-3 control-label">Nombre del Item:</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" name="txtNombreItem" id="txtNombreItem" placeholder="Panel de control">
                                        </div>
                                        <div class="col-sm-9 col-sm-offset-3">                                                                                                
                                            <span id="spantxtNombreItem" class="help-block" style="display: none;">Por favor ingrese un nombre para el item.</span>
                                        </div>
                                    </div>
                                    <!--**************************************-->
                                    <!--clase para el icono de la seccion-->
                                    <div id="divtxtClaseParaIconoItem" class="form-group">
                                        <label for="txtClaseParaIconoItem" class="col-sm-3 control-label">Clase para icono:</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" name="txtClaseParaIconoItem" id="txtClaseParaIconoItem" placeholder="fa fa-circle-o">
                                        </div>
                                        <div class="col-sm-9 col-sm-offset-3">                                                                                                
                                            <span id="spantxtClaseParaIconoItem" class="help-block" style="display: none;">Por favor ingrese la clase de referencia del icono.</span>
                                        </div>
                                    </div>
                                    <!--**************************************-->
                                    <!--clase para el icono de la seccion-->
                                    <div id="divtxtPosicionSeccionItem" class="form-group">
                                        <label class="col-sm-3 control-label" for="txtPosicionSeccionItem">Posicion del item</label>
                                        <div class="col-sm-9">                                            
                                            <input id="txtPosicionSeccionItem" class="form-control" type="number" value="0">
                                        </div>                                        
                                        <div class="col-sm-9 col-sm-offset-3">                                                                                                
                                            <span id="spantxtPosicionSeccionItem" class="help-block" style="display: none;">Por favor ingrese la posicion que se mostrará el item en la sección.</span>
                                        </div>
                                    </div>
                                    <!--**************************************-->
                                    <!--redireccionar al dar click-->
                                    <div id="divtxtClicRedirec" class="form-group">
                                        <label for="txtClicRedirec" class="col-sm-3 control-label">Redireccionar a :</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" name="txtClicRedirec" id="txtClicRedirec" value="/admin/">
                                        </div>
                                        <div class="col-sm-9 col-sm-offset-3">                                                                                                
                                            <span id="spantxtClicRedirec" class="help-block" style="display: none;">Por favor ingrese la referencia de enlace del item</span>
                                        </div>
                                    </div>
                                    <!--**************************************-->
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <input type="submit" class="btn btn-info pull-right" name="btnGuardar" value="Guardar" onclick="guardarEditarSubItemSeccion()"/>
                                </div>
                                <!-- /.box-footer -->                               
                            </div>
                            <!-- /.box -->
                        </div>

                    </div> <!-- /.row (main row) -->
                </section> <!-- /.content -->
            </div> <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>.</b>
                </div>
                <strong>&copy; 2017 <a href="<?php echo "$Servidor"; ?>index.php">Grupo Valor sa.</a>.</strong> Todos los derechos reservados.
            </footer>
        </div>
        <!-- ./wrapper -->

        <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>        
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../dist/js/app.min.js"></script>
        <script src="asignarrolespermisos/AgregarQuitarRolesUsuario.js" type="text/javascript"></script>

        <script type="text/javascript">

                                        function guardarEditarSeccion() {
                                            var idMenuSecciones = 0; // document.getElementById("").value;
                                            var NombreSeccion = document.getElementById("txtNombreSeccion").value;
                                            var ClaseParaIcono = document.getElementById("txtClaseParaIcono").value;
                                            var PosicionSeccion = document.getElementById("txtPosicionSeccion").value;
                                            var EstadoActivo = 1; // document.getElementById("").value;

                                            var isOk = 0;

                                            if (NombreSeccion.length > 0) {
                                                document.getElementById("divtxtNombreSeccion").className = "form-group";
                                                document.getElementById("spantxtNombreSeccion").style.display = "none";
                                                isOk++;
                                            } else {
                                                document.getElementById("divtxtNombreSeccion").className += " has-error";
                                                document.getElementById("spantxtNombreSeccion").style.display = "block";
                                            }

                                            if (ClaseParaIcono.length > 0) {
                                                document.getElementById("divtxtClaseParaIcono").className = "form-group";
                                                document.getElementById("spatxtClaseParaIcono").style.display = "none";
                                                isOk++;
                                            } else {
                                                document.getElementById("divtxtClaseParaIcono").className += " has-error";
                                                document.getElementById("spatxtClaseParaIcono").style.display = "block";
                                            }

                                            if (PosicionSeccion > 0) {
                                                document.getElementById("divtxtPosicionSeccion").className = "form-group";
                                                document.getElementById("spantxtPosicionSeccion").style.display = "none";
                                                isOk++;
                                            } else {
                                                document.getElementById("divtxtPosicionSeccion").className += " has-error";
                                                document.getElementById("spantxtPosicionSeccion").style.display = "block";
                                            }

                                            if (isOk == 3) {
                                                $.ajax({
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    url: "asignarrolespermisos/AgregarEditarSeccionDelMenu.php",
                                                    cache: false,
                                                    data: {idMenuSecciones: idMenuSecciones,
                                                        NombreSeccion: NombreSeccion,
                                                        ClaseParaIcono: ClaseParaIcono,
                                                        PosicionSeccion: PosicionSeccion,
                                                        EstadoActivo: EstadoActivo},
                                                    success: function (response) {
                                                        if (response.success == 1) {
                                                            console.log("Operción realizado con éxito.")
                                                            document.getElementById("txtNombreSeccion").value = "";
                                                            document.getElementById("txtClaseParaIcono").value = "";
                                                            document.getElementById("txtPosicionSeccion").value = "0";
                                                            location.reload();
                                                        } else {
                                                            console.log(response.error);
                                                        }
                                                        // $('#treeview').treeview({data: response});
                                                    }
                                                });
                                            } else {

                                            }
                                        }

                                        function guardarEditarSubItemSeccion() {
                                            var idMenuItem = 0;
                                            var idMenuSeccion = document.getElementById("selectNombreSeccionItems").value;
                                            var NombreMenuItem = document.getElementById("txtNombreItem").value;
                                            var ClaseIconoItem = document.getElementById("txtClaseParaIconoItem").value;
                                            var PosicionItem = document.getElementById("txtPosicionSeccionItem").value;
                                            var ClicRedirec = document.getElementById("txtClicRedirec").value;
                                            var EstadoActivo = 1; // document.getElementById("").value;

                                            var isOk = 0;

                                            if (idMenuSeccion > 0) {
                                                document.getElementById("divselidMenuSeccion").className = "form-group";
                                                document.getElementById("spanselidMenuSeccion").style.display = "none";
                                                isOk++;
                                            } else {
                                                document.getElementById("divselidMenuSeccion").className += " has-error";
                                                document.getElementById("spanselidMenuSeccion").style.display = "block";
                                            }

                                            if (NombreMenuItem.length > 0) {
                                                document.getElementById("divtxtNombreItem").className = "form-group";
                                                document.getElementById("spantxtNombreItem").style.display = "none";
                                                isOk++;
                                            } else {
                                                document.getElementById("divtxtNombreItem").className += " has-error";
                                                document.getElementById("spantxtNombreItem").style.display = "block";
                                            }

                                            if (ClaseIconoItem.length > 0) {
                                                document.getElementById("divtxtClaseParaIconoItem").className = "form-group";
                                                document.getElementById("spantxtClaseParaIconoItem").style.display = "none";
                                                isOk++;
                                            } else {
                                                document.getElementById("divtxtClaseParaIconoItem").className += " has-error";
                                                document.getElementById("spantxtClaseParaIconoItem").style.display = "block";
                                            }

                                            if (PosicionItem > 0) {
                                                document.getElementById("divtxtPosicionSeccionItem").className = "form-group";
                                                document.getElementById("spantxtPosicionSeccionItem").style.display = "none";
                                                isOk++;
                                            } else {
                                                document.getElementById("divtxtPosicionSeccionItem").className += " has-error";
                                                document.getElementById("spantxtPosicionSeccionItem").style.display = "block";
                                            }
                                            if (ClicRedirec.length > 0) {
                                                document.getElementById("divtxtClicRedirec").className = "form-group";
                                                document.getElementById("spantxtClicRedirec").style.display = "none";
                                                isOk++;
                                            } else {
                                                document.getElementById("divtxtClicRedirec").className += " has-error";
                                                document.getElementById("spantxtClicRedirec").style.display = "block";
                                            }

                                            if (isOk == 5) { // 5 es la cantidad de campos a validar
                                                $.ajax({
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    url: "asignarrolespermisos/AgregarEditarItemsSeccionDelMenu.php",
                                                    cache: false,
                                                    data: {idMenuItem: idMenuItem,
                                                        idMenuSeccion: idMenuSeccion,
                                                        NombreMenuItem: NombreMenuItem,
                                                        ClaseIconoItem: ClaseIconoItem,
                                                        PosicionItem: PosicionItem,
                                                        ClicRedirec: ClicRedirec,
                                                        EstadoActivo: EstadoActivo},
                                                    success: function (response) {
                                                        if (response.success == 1) {
                                                            console.log("Operción realizado con éxito.")
                                                            document.getElementById("txtNombreItem").value = "";
                                                            document.getElementById("txtClaseParaIconoItem").value = "";
                                                            document.getElementById("txtPosicionSeccionItem").value = "0";
                                                            document.getElementById("txtClicRedirec").value = "";
                                                            location.reload();
                                                        } else {
                                                            alert("error al guardar item: " + response.error);
                                                        }
                                                        // $('#treeview').treeview({data: response});
                                                    }
                                                });
                                            } else {

                                            }
                                        }
        </script>

        <script>
            // Esto es paa realizar una busqueda eqn una tabla 
            $("#InputBuscarUsuario").keyup(function () {
                var value = this.value.toLowerCase().trim();

                $("#tblUsuarios tr").each(function (index) {
                    if (!index)
                        return;
                    $(this).find("td").each(function () {
                        var id = $(this).text().toLowerCase().trim();
                        var not_found = (id.indexOf(value) == -1);
                        $(this).closest('tr').toggle(!not_found);
                        return not_found;
                    });
                });
            });
        </script>
    </body>
</html>
