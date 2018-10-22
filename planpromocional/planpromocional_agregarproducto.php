<?php
session_start();

 if (!$_SESSION["sUserId"]) { 
  header('Location: ../login/index.php');
  }
require_once("../conexion/conexion.php");

//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idclient_sesion = $_SESSION["sIdCliente"];

$EstadoEnlaces = "";

if ($NivelAcceso == 5) { // acceso temporal
    $EstadoEnlaces = "disabled";
}


// axctualiza los códigos en la bd
if (isset($_POST['btnActualizarCodigos'])) {

    // Escape user inputs for security
    $IdPresentacion = mysqli_real_escape_string($conn, $_REQUEST['IdPresentacion']);
    $codDicegsa = mysqli_real_escape_string($conn, $_REQUEST['txtCodDicecsa']);
    $codMantica = mysqli_real_escape_string($conn, $_REQUEST['txtCodMantica']);
    $codWalmart = mysqli_real_escape_string($conn, $_REQUEST['txtCodWalmart']);
    $codBarras = mysqli_real_escape_string($conn, $_REQUEST['txtCodBarras']);

    // attempt insert query execution
    $sql = "update planpromo_presentaciones set CodCafeSoluble = '$codDicegsa', "
            . "CodCasaMantica='$codMantica', CodigoWalmart = '$codWalmart', CodigoBarras = '$codBarras'"
            . " where IdPresentacion = '$IdPresentacion'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Actualizado con éxito.'); </script>";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
}

// para inserta nueva marca
if (isset($_POST['btnInsertaNuevaMarca'])) {

    // Escape user inputs for security
    $IdCliente = mysqli_real_escape_string($conn, $_REQUEST['IdCliente']);
    $Descripcion = mysqli_real_escape_string($conn, $_REQUEST['txtNuevaMarca']);

    // attempt insert query execution
    $sql = "insert into planpromo_marcas (IdCliente, Descripcion) values ('$IdCliente', '$Descripcion')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Insertada la nueva marca: '$Descripcion' con éxito.'); </script>";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
}


// para inserta nueva Presentacion
if (isset($_POST['btnInsertarNuevaPresentacion'])) {

    // Escape user inputs for security
    $IdCliente = mysqli_real_escape_string($conn, $_REQUEST['IdCliente']);
    $IdMarca = mysqli_real_escape_string($conn, $_REQUEST['selListMarca_AgregProd']);
    $CodCafeSoluble = mysqli_real_escape_string($conn, $_REQUEST['txtCCS_AgregProd']);
    $CodCasaMantica = mysqli_real_escape_string($conn, $_REQUEST['txtCCM_AgregProd']);
    $CodigoWalmart = mysqli_real_escape_string($conn, $_REQUEST['txtCW_AgregProd']);
    $CodigoBarras = mysqli_real_escape_string($conn, $_REQUEST['txtCB_AgregProd']);
    $Descripcion = mysqli_real_escape_string($conn, $_REQUEST['txtDesc_AgregProd']);
    $IdCanal = mysqli_real_escape_string($conn, $_REQUEST['txtCanal_AgregProd']);
    $categoria = mysqli_real_escape_string($conn, $_REQUEST['selListCateg_AgregProd']);

    // attempt insert query execution
    $sql = "insert into planpromo_presentaciones () "
            . "values ('null', '$IdCliente', '$IdMarca', '$CodCafeSoluble', '$CodCasaMantica', '$CodigoWalmart', '$CodigoBarras', '$Descripcion', 'timestamp', '$IdCanal', '$categoria', '1')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Insertada la nueva marca: '$Descripcion' con éxito.'); </script>";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
}

// para seleccionar de manera aleatoria el efecto de carga de la pagina

/* $iconos_carga = array("Preloader_1", "Preloader_2", "Preloader_3", "Preloader_4", "Preloader_5", "Preloader_6", "Preloader_7", "Preloader_8", "Preloader_9", "Preloader_10", "Preloader_3128");
  $indic_imageload = array_rand($iconos_carga, 10);
  echo $iconos_carga[$indic_imageload[0]]; */

$iconos_carga = ["Preloader_1", "Preloader_2", "Preloader_3", "Preloader_4", "Preloader_5", "Preloader_6", "Preloader_7", "Preloader_8", "Preloader_9", "Preloader_10", "Preloader_11",
    "Preloader_12", "Preloader_13", "Preloader_14", "Preloader_15", "Preloader_16", "Preloader_17", "Preloader_18", "Preloader_19", "Preloader_20", "Preloader_21", "Preloader_22", "Preloader_23", "Preloader_25"];
$indic_imageload = $iconos_carga[mt_rand(0, count($iconos_carga) - 1)];

function getListProduct() {
    global $conn;
    $selectOption = "";


    //$sql = "SELECT * FROM puntosdeventa limit 5";
    $sql = "SELECT * FROM planpromo_productos WHERE Cliente = " . $idclient_sesion;

    $result = mysqli_query($conn, $sql);

    if (($result->num_rows) > 0) {

        while ($row2 = mysqli_fetch_array($result)) {

            $selectOption = $selectOption . "<option value='" . $row2['idProducto'] . "'>" . ($row2['Descripcion']) . "</option>";
        }
    } else {

        $selectOption = $selectOption . "<option value='0' disabled >No Disponible (Agregue un producto)</option>";
    }

    return $selectOption;
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
        <link rel="stylesheet" type="text/css" href="css/style.css">	

        <style type="text/css">
            
             /* Paste this css to your style sheet file or under head tag */
            /* This only works with JavaScript, 
            if it's not present, don't show loader */
            .no-js #loader { display: none;  }
            .js #loader { display: block; position: absolute; left: 100px; top: 0; }
            .se-pre-con {
                position: fixed;
                left: 0px;
                top: 0px;
                width: 100%;			
                height: 100%;
                z-index: 9999;
                background: url(../dist/images/128x128/<?php echo $indic_imageload; ?>.gif) center no-repeat #fff;
            }
            
            .disabled {
                pointer-events:none; /*This makes it not clickable*/
                opacity:0.6;         /*This grays it out to look disabled*/
            }

        </style>

    </head>
    <body class="hold-transition skin-blue sidebar-menu">
        <!-- Paste this code after body tag para empezar animacion de la pagikna al cargar-->
        <div class="se-pre-con"></div>
        <!-- Ends -->

        <div class="wrapper">
            <header class="main-header">
                <a class=<?php $EstadoEnlaces; ?> href="planpromocional.php" class="logo">
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
                                <i class="fa fa-dashboard"></i> <span>Menú</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a class=<?php $EstadoEnlaces; ?> href="planpromocional.php"><i class="fa fa-book"></i> Nueva Actividad.</a></li>
                                <li><a class=<?php $EstadoEnlaces; ?> href="planpromocional_historial.php"><i class="fa fa-database"></i> Lista de Actividades</a></li>
                                <li class="active"><a class=<?php $EstadoEnlaces; ?> href="planpromocional_agregarproducto.php"><i class="fa fa-shopping-cart"></i>Agregar Producto</a></li>
                                <li><a class=<?php $EstadoEnlaces; ?> href="#"><i class="fa fa-user"></i>Perfil</a></li>
                                <li><a class=<?php $EstadoEnlaces; ?> href="#"><i class="fa fa-cog"></i>Parámetros y Preferencias</a></li>
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
                    <h1>Interfaz para actualizar los códigos de los productos</h1>
                    <ol class="breadcrumb">
                        <li><a class=<?php echo $EstadoEnlaces; ?> href="planpromocional.php"> Panel de control</a></li>
                        <li class="active"><a href="#NuevoProducto">Nuevo Producto</a></li>
                    </ol>
                </section>                                    

                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-aqua-active">
                        <h3 class="widget-user-username"><?php echo $_SESSION["sUserName"]; ?></h3>
                        <h5 class="widget-user-desc"><?php echo $_SESSION["sessionRol"]; ?></h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="<?php echo '../' . $_SESSION['simgFotoPerfilUrl']; ?>" alt="User Avatar">
                    </div>                   
                </div>

                <!-- efecto de carga -->
                <link rel="stylesheet" type="text/css" href="css/efectoguardando.css">
                <div class="cssload-loader" id="divefectoguardando">Guardando...</div>

                <!-- Main content -->
                <section class="content">			

                    <div class="row">

                        <!-- Panel de edicion de presentacion-->
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title"> Editar Presentación</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>

                                </div>
                                <div class="box-body">                                     

                                    <div class="col-sm-12">
                                        <!-- Producto . -->
                                        <style type="text/css">
                                            #lista3 {
                                            /*counter-reset: li; 
                                            list-style: none; 
                                            *list-style: decimal; */
                                            font: 15px 'trebuchet MS', 'lucida sans';
                                            padding: 0;
                                            margin-bottom: 4em;
                                            text-shadow: 0 1px 0 rgba(255,255,255,.5);
                                            }

                                            #lista3 ol {
                                            margin: 0 0 0 2em; 
                                            }

                                            #lista3 li{
                                            position: relative;
                                            display: block;
                                            padding: .4em .4em .4em .8em;
                                            *padding: .4em;
                                            margin: .5em 0 .5em 2.5em;
                                            background: #ddd;
                                            color: #444;
                                            text-decoration: none;
                                            transition: all .3s ease-out;   
                                            }

                                            #lista3 li:hover{
                                            background: #eee;
                                            }   

                                            #lista3 li:before{
                                            content: counter(li);
                                            counter-increment: li;
                                            position: absolute; 
                                            left: -2.5em;
                                            top: 50%;
                                            margin-top: -1em;
                                            background: #fa8072;
                                            height: 2em;
                                            width: 2em;
                                            line-height: 2em;
                                            text-align: center;
                                            font-weight: bold;
                                            }

                                            #lista3 li:after{
                                            position: absolute; 
                                            /* content: '';*/
                                            border: .5em solid transparent;
                                            left: -1em;
                                            top: 50%;
                                            margin-top: -.5em;
                                            transition: all .3s ease-out;               
                                            }

                                            #lista3 li:hover:after{
                                            left: -.5em;
                                            border-left-color: #fa8072;             
                                            }
                                        </style>
                                        <?php
                                        $marcas_query = "Select * from planpromo_marcas where IdCliente = " . $idclient_sesion;
                                        $result = mysqli_query($conn, $marcas_query);

                                        if ($result) {
                                            if ($result->num_rows > 0) {

                                                while ($row = mysqli_fetch_array($result)):
                                                    ?>

                                                    <ol id="lista3">
                                                        <li ><?php echo ($row['Descripcion']); ?>

                                                            <ol id="lista3">
                                                                <?php
                                                                $present_query = "select * from planpromo_presentaciones where IdMarca = " . $row["IdMarca"];
                                                                $result_present = mysqli_query($conn, $present_query);
                                                                if ($result_present) {
                                                                    if ($result_present->num_rows > 0) {

                                                                        while ($present = mysqli_fetch_array($result_present)):
                                                                            ?>
                                                                            <form action="planpromocional_agregarproducto.php" method="post" class="form-inline">
                                                                                <div class="row">
                                                                                    <div class="col-sm-12 col-md-12">                                                                                        
                                                                                        <li style="color:#fff; background: #0033ff;"><label><?php echo $present['IdPresentacion'] . " - " . $present['Descripcion']; ?></label></li>
                                                                                    </div>
                                                                                    <div class="col-sm-12 col-md-3">
                                                                                        <label for="txtCodDicecsa">Dicecsa:</label>
                                                                                        <input type="number" name="txtCodDicecsa" id="txtCodDicecsa" value=<?php echo $present['CodCafeSoluble']; ?>>
                                                                                    </div>

                                                                                    <div class="col-sm-12 col-md-3">
                                                                                        <label for="txtCodMantica">Mantica:</label>
                                                                                        <input type="number" name="txtCodMantica" id="txtCodMantica" value=<?php echo $present['CodCasaMantica']; ?>>
                                                                                    </div>

                                                                                    <div class="col-sm-12 col-md-3">
                                                                                        <label for="txtCodWalmart">Waltmart:</label>
                                                                                        <input type="number" name="txtCodWalmart" id="txtCodWalmart" value=<?php echo $present['CodigoWalmart']; ?>>
                                                                                    </div>

                                                                                    <div class="col-sm-12 col-md-3">
                                                                                        <label for="txtCodBarras">Barras:</label>
                                                                                        <input type="number" name="txtCodBarras" id="txtCodBarras" value=<?php echo $present['CodigoBarras']; ?>>
                                                                                    </div>

                                                                                    <div class="col-sm-12 col-md-1">
                                                                                        <input type="hidden" name="IdPresentacion" id="IdPresentacion" value=<?php echo $present['IdPresentacion']; ?>>
                                                                                        <input type="submit" name="btnActualizarCodigos" value="Guardar" class="btn btn-default">
                                                                                    </div>
                                                                                </div>
                                                                            </form>

                                                                            <?php
                                                                        endwhile;
                                                                    }
                                                                }
                                                                ?>
                                                            </ol>
                                                        </li>
                                                    </ol>
                                                    <?php
                                                endwhile;
                                            }
                                            else {
                                                
                                            }
                                        }
                                        ?> 
                                    </div>                                

                                </div>                                
                            </div>
                        </div>
                        <!-- fin del panel editar presentaciion  -->


                        <div class="col-md-12 col-sm-12" id="NuevoProducto">
                            <!-- Panel de nueva Presentación-->
                            <div class="col-md-6 col-xs-12">
                                <form action="planpromocional_agregarproducto.php" method="post">
                                    <div class="box box-success">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"> Nueva Presentación</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                                            </div>

                                        </div>
                                        <div class="box-body">

                                            <div class="input-group" style="margin: 5px;">
                                                <span class="label-warning input-group-addon">Categoria:</span>
                                                <select id="selListCateg_AgregProd" name="selListCateg_AgregProd " class="form-control">
                                                    <option disabled="disabled" value="0">Seleccione una Categoria</option>
                                                    <?php
                                                    $categ_query = "select * from Precios_CatCategorias where IdCliente = 'c" . $idclient_sesion . "c'";
                                                    $result_categ = mysqli_query($conn, $categ_query);
                                                    if ($result_categ) {
                                                        if ($result_categ->num_rows > 0) {

                                                            while ($categ = mysqli_fetch_array($result_categ)): ?>
                                                    <option value=<?php echo $categ['idCategoria']; ?>><?php echo ($categ['DescCategoria']); ?></option>
                                                                <?php
                                                            endwhile;
                                                        }
                                                    }
                                                    ?>
                                                </select>        
                                            </div>
                                            <!-- Marca . -->	
                                            <div class="input-group" style="margin: 5px;">
                                                <span class="label-warning input-group-addon">Marca:</span>
                                                <select id="selListMarca_AgregProd" name="selListMarca_AgregProd" class="form-control">
                                                    <option disabled="disabled" value="0">Seleccione una Marca</option>
                                                    <?php
                                                    $present_query = "select * from planpromo_marcas where IdCliente = " . $idclient_sesion;
                                                    echo $present_query;
                                                    $result_present = mysqli_query($conn, $present_query);
                                                    if ($result_present) {
                                                        if ($result_present->num_rows > 0) {

                                                            while ($marca = mysqli_fetch_array($result_present)):
                                                                ?>

                                                    <option value=<?php echo $marca['IdMarca']; ?>><?php echo ($marca['Descripcion']); ?></option>
                                                                <?php
                                                            endwhile;
                                                        }
                                                    }
                                                    ?>
                                                </select>        
                                            </div>

                                            <!-- Presentación . -->	                                            	
                                            <div class="input-group" style="margin: 5px;">
                                                <span class="label-warning input-group-addon">Còd Interno:</span>
                                                <input type="number" name="txtCCS_AgregProd" id="txtCCS_AgregProd" class="form-control" required>                                                                                             
                                            </div>
                                            <div class="input-group" style="margin: 5px;">
                                                <span class="label-warning input-group-addon">Còd C. Mantica:</span>
                                                <input type="number" name="txtCCM_AgregProd" id="txtCCM_AgregProd" class="form-control" required>
                                            </div>	
                                            <div class="input-group" style="margin: 5px;">
                                                <span class="label-warning input-group-addon">Còd Walmart:</span>
                                                <input type="number" name="txtCW_AgregProd" id="txtCW_AgregProd" class="form-control" required>
                                            </div>
                                            <div class="input-group" style="margin: 5px;">
                                                <span class="label-warning input-group-addon">Còd Barra:</span>
                                                <input type="number" name="txtCB_AgregProd" id="txtCB_AgregProd" class="form-control" required>
                                            </div>

                                            <div class="input-group" style="margin: 5px;">
                                                <span class="label-warning input-group-addon">Descripcion:</span>
                                                <input type="text" name="txtDesc_AgregProd" id="txtDesc_AgregProd" class="form-control" required>
                                            </div>										
                                            <div class="input-group" style="margin: 5px;">
                                                <span class="label-warning input-group-addon">Canal:</span>
                                                <input type="text" name="txtCanal_AgregProd" id="txtCanal_AgregProd" list="listCanal" class="form-control" required>
                                                <datalist id="listCanal">
                                                    <?php
                                                    $sql = "SELECT * FROM CatCanales";
                                                    $result = mysqli_query($conn, $sql);
                                                    while ($row2 = mysqli_fetch_array($result)) {
                                                        echo "<option value='" . $row2['IdCanal'] . "'>" . ($row2['NombreCanal']) . "</option>";
                                                    }
                                                    ?>
                                            </div>
                                        </div>

                                        <div class="box-footer">
                                            <input type="hidden" id="IdCliente" name="IdCliente" value=<?php echo $idclient_sesion; ?>>
                                            <input type="submit" name="btnInsertarNuevaPresentacion" id="btnInsertarNuevaPresentacion" value="Insertar" class="btn btn-normal btn-primary">
                                        </div>
                                    </div>	
                                </form>   
                            </div>	

                            <!-- Panel de nueva Marca-->
                            <div class="col-md-6 col-xs-12">

                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"> Nueva Marca</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        </div>

                                    </div>
                                    <div class="box-body">  
                                        <form method="post" action="planpromocional_agregarproducto.php">
                                            <div class="col-lg-12 col-md-12 col-xs-12">                                           

                                                <!-- Marca . -->	
                                                <div class="input-group" style="margin: 5px;">
                                                    <span class="label-warning input-group-addon">Marca:</span>
                                                    <input type="text" name="txtNuevaMarca" id="txtNuevaMarca" class="form-control" required>
                                                </div>	
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-xs-12">                                           
                                                <input type="hidden" name="IdCliente" value=<?php echo $idclient_sesion; ?>>
                                                <input type="submit"  id="btnGuardarMarca" value="Guardar" name="btnInsertaNuevaMarca" class="btn btn-normal btn-primary">
                                            </div>

                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- fin del panel de nueva Marca  -->                       

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
        <script>$.widget.bridge('uibutton', $.ui.button);</script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/planpromocional_agregarproducto.js"></script>
        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>

        <script>
<!-- fin anim carga de la pagina             -->
//paste this code under head tag or in a seperate js file.
                        // Wait for window load
                        $(window).load(function () {
                            // Animate loader off screen
                            $(".se-pre-con").fadeOut("slow");
                        });
        </script>


    </body>
</html>