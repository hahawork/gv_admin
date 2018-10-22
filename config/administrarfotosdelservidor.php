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


$path = "../../ws/uploads";
if (isset($_POST['file']) && is_array($_POST['file'])) {
    foreach ($_POST['file'] as $file) {
        unlink($path . "/" . $file) or die("Failed to <strong class='highlight'>delete</strong> file");
    }
   // header("location: " . $_SERVER['REQUEST_URI']); //redirect after deleting files so the user can refresh without that resending post info message
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
                        <div class="col-xs-12">
                            <form name="form1" method="post">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Listado de fotos en la carpeta uploads</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->

                                    <div class="box-body">

                                        <div class="form-horizontal">                                      

                                            <?php
                                            $files = glob("../../ws/uploads/*.*");
                                            for ($i = 1; $i < count($files); $i++) {
                                                $num = $files[$i];
                                                ?>
                                                <div class="col-sm-6 col-md-3 col-lg-2" style="margin: 2px 2px 2px 2px; min-width: 80px; display: inline-block; padding: 2px; text-align: center;">
                                                    <?php
                                                    if (
                                                            (strpos($num, '201710') !== false)
                                                            or ( strpos($num, '201709') !== false)
                                                            or ( strpos($num, '201708') !== false)
                                                            or ( strpos($num, '201707') !== false)
                                                            or ( strpos($num, '201705') !== false)
                                                            or ( strpos($num, '201706') !== false)
                                                            or ( strpos($num, '201711') !== false)
                                                            or ( strpos($num, '201712') !== false)
                                                    ) {
                                                        echo '<label class="label-danger">' . $num . '</label>';
                                                        echo '<input type="checkbox" name="file[]" value="'.$num.'" checked="checked">';
                                                    } else {

                                                        echo '<label class="label-success">' . $num . '</label>';
                                                        echo '<input type="checkbox" name="file[]" value="'.$num.'">';
                                                    }
                                                    ?>
                                                    
                                                    <img src="<?php echo $num; ?>" alt="random image" class="thumbnail" style="width: 100%;  min-width: 70px; height: auto;"/>    

                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </div>

                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <input type="submit" name="Delete" value="ELIMINAR">
                                    </div>
                                    <!-- /.box-footer -->

                                </div>
                                <!-- /.box -->
                            </form>
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
