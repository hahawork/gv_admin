<?php
session_start();


if (!$_SESSION["sUserId"]) {
    header('Location: ../login/index.php');
    exit;
}

$admin = 'disabled';

if ($_SESSION["sessionRol"] == "Admin") {
    $admin = '';
}

$FechaIni = isset($_POST['txtFechaDesde']) ? $_POST['txtFechaDesde'] : null;
$FechaFin = isset($_POST['txtFechaHasta']) ? $_POST['txtFechaHasta'] : null;

require_once("../conexion/conexion.php");
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

$sql = '';
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


        <title>Regsitro de Accesos</title>

        <style type="text/css">
            .disabled {
                pointer-events:none;/* //This makes it not clickable*/
                opacity:0.6;   /*      //This grays it out to look disabled*/
            }
        </style>

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
                                <li class="<?php echo $admin; ?>" ><a href="../index.php"><i class="fa fa-circle-o"></i> Panel de control.</a></li>
                                <li class="<?php echo $admin; ?>"><a href="../pages/verpdv.php"><i class="fa fa-map"></i> Puntos de venta gráfico</a></li>
                                <li class="<?php echo $admin; ?>"><a href="../pages/verpdvlist.php"><i class="fa fa-map-pin"></i> Puntos de venta listado</a></li>
                                <li><a href="../asistencia-imprimir.php"><i class="fa fa-user"></i> Asistencia de las supervisoras</a></li>
                                <li class="active"><a href="../asistenciaoficinaimprimir.php"><i class="fa fa-certificate"></i> Asistencia de Oficinas</a></li>
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
                    <h1>Registro de Usuarios</h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Personal de Oficina</li>
                    </ol>
                </section>
                <div class="container-fluid">
                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- Custom Tabs (Pulled to the right) -->
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs pull-right">
                                        <li class="active"><a href="#tab_1-1" data-toggle="tab">Acceso sistema</a></li>
                                        <li><a href="#tab_2-2" data-toggle="tab">Usuario común</a></li>                                       
                                        <li class="pull-left header"><i class="fa fa-th"></i> Registro de usuarios</li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1-1">
                                            <div class="form-group">
                                                <label for="txtId_usuario">IdUsuario: </label>

                                                <select class="form-control" id="txtId_usuario" >
                                                    <?php
                                                    require_once ("../conexion/conexion.php");
                                                    $cnn = new conexion();
                                                    $conn = $cnn->conectar();
                                                    $sql = "SELECT * FROM usuario  WHERE EstadoActivo = 1";
                                                    $resultado = mysqli_query($conn, $sql);
                                                    if ($resultado) {
                                                        if (mysqli_num_rows($resultado) > 0) {
                                                            while ($rowTipo = mysqli_fetch_array($resultado)) :
                                                                ?>
                                                                <option value="<?php echo $rowTipo['idUsuario']; ?>"><?php echo ($rowTipo['idUsuario'] . " - " . $rowTipo['NombreUsuario']); ?></option>
                                                                <?php
                                                            endwhile;
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtNombre">Nombre del Usuario : </label>
                                                <input class="form-control" type="text" id="txtNombre" />
                                            </div>

                                            <div class="form-group">
                                                <label for="txtemail">Email:</label>
                                                <input class="form-control" type="email" class="medium" name="txtemail" placeholder="Correo" id="txtemail" required="required"  />
                                            </div>

                                            <div class="form-group">
                                                <label for="txtpassword">Password:</label>
                                                <input class="form-control" type="password" class="medium" id="txtpassword" placeholder="Contraseña" required="required"/>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtPagina">Pagina de Inicio:</label>
                                                <input class="form-control" type="text" id="txtPagina" />
                                            </div>

                                            <div class="form-group">
                                                <label for="nivel_acceso">Rol y Nivel de Acceso:</label>
                                                <select class="form-control" id="nivel_acceso">
                                                    <option value="1">Admin</option>
                                                    <option value="3">Admin Externo</option>
                                                    <option value="4">Supervisor</option>
                                                    <option value="5">Acceso temporal</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="select_cliente">Cliente:</label>
                                                <select class="form-control" id="select_cliente">
                                                    <?php
                                                    require_once ("../conexion/conexion.php");
                                                    $cnn = new conexion();
                                                    $conn = $cnn->conectar();
                                                    $sql = "SELECT * FROM clientes";
                                                    $resultado = mysqli_query($conn, $sql);
                                                    if ($resultado) {
                                                        if (mysqli_num_rows($resultado) > 0) {
                                                            while ($rowTipo = mysqli_fetch_array($resultado)) :
                                                                ?>
                                                                <option value="<?php echo $rowTipo['IdCliente']; ?>"><?php echo ($rowTipo['RazonSocial']); ?></option>
                                                                <?php
                                                            endwhile;
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <br>
                                            <button class="btn" id="btnguardar_usuario" onclick="guardar_usuario()">Guardar</button></td>                                                                                      

                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="tab_2-2">

                                            <div class="box box-info">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Ingrese los datos
                                                    10</h3>
                                                </div>
                                                <form class="form-horizontal">
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                                                            <div class="col-sm-10">
                                                                <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                                                            <div class="col-sm-10">
                                                                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-offset-2 col-sm-10">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox"> Remember me
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.box-body -->
                                                    <div class="box-footer">
                                                        <button type="submit" class="btn btn-default">Cancel</button>
                                                        <button type="submit" class="btn btn-info pull-right">Sign in</button>
                                                    </div>
                                                    <!-- /.box-footer -->
                                                </form>
                                            </div>
                                            <!-- /.box -->

                                        </div>                                        
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                                <!-- nav-tabs-custom -->
                                <!-- /.col -->
                            </div>                            
                        </div>
                </div>
                </section> <!-- /.content -->
            </div>
            <!--    -->
</div> <!-- /.<content-wrapper -->

        <footer class="main-footer">
            <div class="pull-right hidden-xs" id="footer" >
                <h6>.</h6>
            </div>
            <strong>&copy; 2017 <a href="../index.php">Grupo Valor sa.</a>.</strong> Todos los derechos reservados.
        </footer> <!-- /. main-footer -->
    </div> <!-- /.wrapper -->

    <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script>
                                                $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../dist/js/app.min.js"></script>

    <script>

                                                function guardar_usuario() {
                                                    var cliente = document.getElementById("select_cliente").value;
                                                    var select_rol_valores = document.getElementById("nivel_acceso");

                                                    var roles = select_rol_valores.options[select_rol_valores.selectedIndex].text;
                                                    var id_usuario = document.getElementById("txtId_usuario").value;
                                                    var nom = document.getElementById("txtNombre").value;
                                                    var email = document.getElementById("txtemail").value;
                                                    var pass = document.getElementById("txtpassword").value;
                                                    var img = "dist/img/default-masc.jpg";
                                                    var acces = document.getElementById("nivel_acceso").value;
                                                    var pagina = document.getElementById("txtPagina").value;

                                                    $.ajax({
                                                        type: 'post',
                                                        dataType: 'json',
                                                        cache: false,
                                                        data: {IdCliente: cliente, Rol: roles, IdUsuario: id_usuario,
                                                            NombreUsuario: nom, EmailUC: email, PasswordUC: pass,
                                                            imgFotoPerfilUrl: img, NivelAcceso: acces, PaginaInicio: pagina},
                                                        url: 'guardar_usuario.php',
                                                        beforeSend: function () {
                                                            console.log("enviando");
                                                        },
                                                        success: function (res)
                                                        {
                                                            console.log("enviado");
                                                            if (res.Guardado == 1) {
                                                                console.log("Guardado");
                                                                alert('local guardado con exito');
                                                                document.getElementById("select_cliente").value = "";
                                                                document.getElementById("nivel_acceso").value = "";
                                                                document.getElementById("txtId_usuario").value = "";
                                                                document.getElementById("txtNombre").value = "";
                                                                document.getElementById("txtemail").value = "";
                                                                document.getElementById("txtpassword").value = "";
                                                                document.getElementById("nivel_acceso").value = "";
                                                                document.getElementById("txtPagina").value = "";

                                                            } else {

                                                                alert('No se ha podido guardar el registro ' + res.error);

                                                                console.log("error: " + res.error);
                                                            }

                                                        }
                                                    });
                                                }

    </script>

</body>
</html>
