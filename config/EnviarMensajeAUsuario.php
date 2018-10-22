<?php
session_start();

$Servidor = 'https://' . $_SERVER['HTTP_HOST'] . "/admin/"; //$_SERVER['PHP_SELF'] . "/admin/";// obtiene la ruta del DNS : http://grupovalor.com.ni/

require_once ("../funciones_varias.php");
require_once ("../conexion/conexion.php");
require_once ( '../MainDrawer.php');
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];


if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: ../login/index.php');
    exit;
}

$admin = 'disabled';


if ($NivelAcceso == 1) {
    $admin = '';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" type="image/png" href="<?php echo "$Servidor"; ?>favicon.png">	
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!--        Esto es para el selector multiple-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
        <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
        <!--********************************************************-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo "$Servidor"; ?>bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo "$Servidor"; ?>dist/css/AdminLTE.css">
        <link rel="stylesheet" href="<?php echo "$Servidor"; ?>dist/css/skins/_all-skins.min.css">

        <title></title>

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
                    <h1>Supervisión<small>Panel de Control</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo "$Servidor"; ?>index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Panel de control</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-6">

                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Enviar mensaje al usuario en la aplicacion de supervisor</h3>
                                </div>
                                <!-- /.box-header -->
                                <!-- form start -->

                                <div class="box-body">

                                    <div class="form-horizontal">

                                        <div class="form-group">
                                            <label for="selectUsuario" class="col-sm-2 control-label">Nombre:</label>

                                            <div class="col-sm-10">
                                                <select id="selectUsuario" class="form-control chosen-select"  data-placeholder="Seleccione o escriba un nombre..." name="test">
                                                    <?php
                                                    $sql = "select * from usuario where EstadoActivo = 1";
                                                    $resultado = mysqli_query($conn, $sql);
                                                    if ($resultado) {
                                                        if (mysqli_num_rows($resultado) > 0) {
                                                            while ($rowTipo = mysqli_fetch_array($resultado)) :
                                                                ?>
                                                                <option value="<?php echo $rowTipo['idUsuario']; ?>"><?php echo ($rowTipo['NombreUsuario']); ?></option>
                                                                <?php
                                                            endwhile;
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <script>
                                                    $(".chosen-select").chosen({
                                                        no_results_text: "Oops, no existe "
                                                    })
                                                </script>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="textareaMensaje" class="col-sm-2 control-label">Mensaje</label>
                                            <div class="col-sm-10">
                                                <textarea id="textareaMensaje" class="form-control" rows="6"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtURLMensaje" class="col-sm-2 control-label">URL Foto</label>
                                            <div class="col-sm-10">
                                                <input id="txtURLMensaje" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtFecha" class="col-sm-2 control-label">Fecha</label>
                                            <div class="col-sm-10">
                                                <input id="txtFecha" class="form-control" type="date">
                                            </div>
                                        </div>

                                        <input onclick="guardar_mensaje();" type="submit" class="btn btn-info pull-right" name="btnEnviar" value="Enviar" />
                                    </div>
                                </div>

                                <!-- /.box-body -->
                                <div class="box-footer">

                                </div>
                                <!-- /.box-footer -->

                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-xs-6">

                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Permitir/No permitir Guardar nuevo Punto de venta</h3>
                                </div>
                                <!-- /.box-header -->
                                <!-- form start -->

                                <div class="box-body">

                                    <div class="form-horizontal">

                                        <div class="form-group">
                                            <label for="selectUsuarioPermitir" class="col-sm-2 control-label">Nombre:</label>

                                            <div class="col-sm-10">
                                                <select id="selectUsuarioPermitir" class="form-control chosen-select"  data-placeholder="Seleccione o escriba un nombre..." name="test">
                                                    <?php
                                                    $sql = "select * from usuario where EstadoActivo = 1";
                                                    $resultado = mysqli_query($conn, $sql);
                                                    if ($resultado) {
                                                        if (mysqli_num_rows($resultado) > 0) {
                                                            while ($rowTipo = mysqli_fetch_array($resultado)) :
                                                                ?>
                                                                <option value="<?php echo $rowTipo['idUsuario']; ?>"><?php echo ($rowTipo['NombreUsuario']); ?></option>
                                                                <?php
                                                            endwhile;
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <script>
                                                    $(".chosen-select").chosen({
                                                        no_results_text: "Oops, no existe "
                                                    })
                                                </script>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="chkPermitir" class="col-sm-2 control-label">Permitir: </label>
                                            <div class="col-sm-10">
                                                <input id="chkPermitir" type="checkbox">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="txtCantidadPermitida" class="col-sm-2 control-label">Cantidad: </label>
                                            <div class="col-sm-10">
                                                <input id="txtCantidadPermitida" class="form-control" type="number" value="1">
                                            </div>
                                        </div>

                                        <button onclick="guardar_permiso();" class="btn btn-info pull-right" name="btnEnviar">Enviar</button>
                                    </div>
                                </div>

                                <!-- /.box-body -->
                                <div class="box-footer">

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

        <script src="<?php echo "$Servidor"; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>        
        <script src="<?php echo "$Servidor"; ?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo "$Servidor"; ?>dist/js/app.min.js"></script>

        <script>
                                            function guardar_mensaje() {
                                                var usuario = document.getElementById("selectUsuario").value;
                                                var mensaje = document.getElementById("textareaMensaje").value;
                                                var urlfoto = document.getElementById("txtURLMensaje").value;
                                                var fecha = document.getElementById("txtFecha").value;

                                                if (usuario > 0 && mensaje.length > 0) {
                                                    $.ajax({
                                                        type: 'post',
                                                        dataType: 'json',
                                                        cache: false,
                                                        url: 'guardar_mensaje-usuario.php',
                                                        data: {
                                                            idUsuario: usuario,
                                                            opcionEnv: 1,
                                                            Mensaje: mensaje,
                                                            URLimage: urlfoto,
                                                            Fecha: fecha,
                                                            EstadoVisto: 0},                                                       
                                                        beforeSend: function () {
                                                            console.log("enviando");
                                                        },
                                                        success: function (res)
                                                        {
                                                            console.log("enviado");
                                                            if (res.Guardado == 1) {
                                                                console.log("Guardado");
                                                                alert('local guardado con exito');
                                                                document.getElementById("textareaMensaje").value = "";
                                                                document.getElementById("txtURLMensaje").value = "";
                                                                document.getElementById("txtFecha").value = "";

                                                            } else {

                                                                alert('No se ha podido guardar el registro ' + res.error);

                                                                console.log("error: " + res.error);
                                                            }

                                                        }                                                    
                                                    });
                                                } else {
                                                    alert('Seleccione un usuario o ingrese un mensaje');
                                                }
                                            }

                                            function guardar_permiso() {

                                                var Permiso = document.getElementById("chkPermitir").checked;
                                                if (true === Permiso) {
                                                    Permiso = 1;
                                                } else {
                                                    Permiso = 0;
                                                }

                                                var idUsuario = document.getElementById("selectUsuarioPermitir").value;
                                                var CantidadPermitida = document.getElementById("txtCantidadPermitida").value;

                                                if (idUsuario > 0 && CantidadPermitida > 0) {

                                                    $.ajax({
                                                        dataType: 'json',
                                                        cache: false,
                                                        url: 'guardar_mensaje-usuario.php',
                                                        data: {
                                                            idUsuario: idUsuario,
                                                            opcionEnv: 2,
                                                            Permitir: Permiso,
                                                            Cantidad: CantidadPermitida
                                                        },
                                                        beforeSend: function (xhr) {
                                                        },
                                                        success: function (res) {
                                                            console.log("enviado");
                                                            if (res.Guardado == 1) {
                                                                console.log("Guardado");
                                                                alert('guardado con exito');                                                                
                                                                document.getElementById("txtCantidadPermitida").value = "";
                                                            } else {

                                                                alert('No se ha podido guardar el registro ' + res.error);

                                                                console.log("error: " + res.error);
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    alert('Seleccione un usuario o ingrese un numero en cantidad permitida');
                                                }
                                            }
        </script>
    </body>
</html>
