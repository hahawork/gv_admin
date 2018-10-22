<?php
session_start();

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = "../planpromocional/";
    header('Location: ../login/index.php');
}
require_once("../conexion/conexion.php");

//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();


// para seleccionar de manera aleatoria el efecto de carga de la pagina

/* $iconos_carga = array("Preloader_1", "Preloader_2", "Preloader_3", "Preloader_4", "Preloader_5", "Preloader_6", "Preloader_7", "Preloader_8", "Preloader_9", "Preloader_10", "Preloader_3128");
  $indic_imageload = array_rand($iconos_carga, 10);
  echo $iconos_carga[$indic_imageload[0]]; */

$iconos_carga = ["Preloader_1", "Preloader_2", "Preloader_3", "Preloader_4", "Preloader_5", "Preloader_6", "Preloader_7", "Preloader_8", "Preloader_9", "Preloader_10", "Preloader_11",
    "Preloader_12", "Preloader_13", "Preloader_14", "Preloader_15", "Preloader_16", "Preloader_17", "Preloader_18", "Preloader_19", "Preloader_20", "Preloader_21", "Preloader_22", "Preloader_23", "Preloader_25"];
$indic_imageload = $iconos_carga[mt_rand(0, count($iconos_carga) - 1)];

//$sql = "SELECT IdPresentacion, concat(planpromo_productos.Descripcion ,', ', planpromo_marcas.Descripcion, ', ' , planpromo_presentaciones.Descripcion) as presentacion FROM `planpromo_presentaciones` INNER JOIN planpromo_marcas ON planpromo_presentaciones.IdMarca = planpromo_marcas.IdMarca INNER JOIN planpromo_productos ON planpromo_productos.idProducto = planpromo_marcas.IdProducto";
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


        <link rel="stylesheet" type="text/css" href="../tables/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">	

        <!-- animacion de carga de la pagina -->
        <style>
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
        </style>

        <script src="js/jquery.min.js"></script>
        <script type="text/javascript" src="../floatingdiv/floating-1.12.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
        <script>
            //paste this code under head tag or in a seperate js file.
            // Wait for window load
            $(window).load(function () {
                // Animate loader off screen
                $(".se-pre-con").fadeOut("slow");
                ;
            });
        </script>
        <!-- fin anim carga de la pagina -->

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div id="floatdiv" style="  
             position:absolute;  
             width:400px;height:100px;top:10px;right:10px;  
             padding:16px;background:#FFFFFF;  
             border:2px solid #2266AA;  
             z-index:100">  

            <div>
                <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <input type="number" value="0" id="cantidadtotal" disabled="disabled" style="width: 100%;"><br>
                            <span class="description-text">TOTAL</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header" id="totalasignado">0</h5>
                            <span class="description-text">PRODUCTOS ASIGNADOS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <div class="description-block">
                            <input type="number" value="0" id="totaldisponible" disabled="disabled" style="width: 100%;"><br>                           	
                            <span class="description-text">DISPONIBLES</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>	   
        </div>  

        <script type="text/javascript">

            floatingMenu.add('floatdiv',
                    {
                        // Represents distance from left or right browser window  
                        // border depending upon property used. Only one should be  
                        // specified.  
                        // targetLeft: 0,  
                        targetRight: 10,

                        // Represents distance from top or bottom browser window  
                        // border depending upon property used. Only one should be  
                        // specified.  
                        targetTop: 50,
                        // targetBottom: 0,  

                        // Uncomment one of those if you need centering on  
                        // X- or Y- axis.  
                        // centerX: true,  
                        // centerY: true,  

                        // Remove this one if you don't want snap effect  
                        snap: true
                    });
        </script>
        <!-- Paste this code after body tag para empezar animacion de la pagikna al cargar-->
        <div class="se-pre-con"></div>
        <!-- Ends -->

        <div class="wrapper">
            <header class="main-header">
                <a href="planpromocional.php" class="logo">
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
                                <li class="active"><a href="planpromocional.php"><i class="fa fa-book"></i> Nueva Actividad.</a></li>
                                <li><a href="planpromocional_historial.php"><i class="fa fa-database"></i> Lista de Actividades</a></li>
                                <li><a href="planpromocional_agregarproducto.php"><i class="fa fa-shopping-cart"></i>Agregar Producto</a></li>
                                <li><a href="#"><i class="fa fa-user"></i>Perfil</a></li>
                                <li><a href="#"><i class="fa fa-cog"></i>Parámetros y Preferencias</a></li>
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
                    <h1>Panel de Control</h1>
                    <ol class="breadcrumb">
                        <li class="active">Panel de control</li>
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


                <div id="divAlertas"></div>

                <!-- efecto de carga -->
                <link rel="stylesheet" type="text/css" href="css/efectoguardando.css">
                <div class="cssload-loader" id="divefectoguardando">Guardando...</div>

                <div id="alertDanger" class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" onclick="on_CerrarAlert(this)">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Problemas!</h4><p id="mensajeD"></p>
                </div>

                <div id="alertInfo" class="alert alert-info alert-dismissible">
                    <button type="button" class="close" onclick="on_CerrarAlert(this)">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Información!</h4><p id="mensajeI"></p>
                </div>

                <div id="alertWarning" class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" onclick="on_CerrarAlert(this)">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Advertencia!</h4><p id="mensajeW"></p>
                </div>

                <div id="alertSuccess" class="alert alert-success alert-dismissible">
                    <button type="button" class="close" onclick="on_CerrarAlert(this)">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Éxito!</h4><p id="mensajeS"></p>
                </div>

                <!-- Main content -->
                <section class="content">

                    <div class="row">

                        <!-- Panel de nueva asignacion -->
                        <div class="col-lg-8 col-md-8 col-xs-12" name = "NuevaAsignacion">

                            <form method="post">

                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"> Nueva Asignación Para Promoción</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                                        </div>

                                    </div>
                                    <div class="box-body" style="background: #999;">

                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <!--
                                                                                                                            <style type="text/css">
                                                                                                                                    table {
                                                                                                                                        border-spacing: 5px;
                                                                                                                                    }
                                                                                                                                    table, th, td {
                                                                                                                                        border: 1px solid black;
                                                                                                                                        border-collapse: collapse;
                                                                                                                                    }
                                                                                                                                    th, td {
                                                                                                                                        text-align: center;
                                                                                                                                    }
                                                                                                                            </style>
                                            
                                                                                                                                    <table style="width:100%">
                                                                                                                                      <tr>
                                                                                                                                        <th>Firstname</th>
                                                                                                                                        <th>Lastname</th> 
                                                                                                                                        <th>Age</th>
                                                                                                                                      </tr>
                                                                                                                                      <tr>
                                                                                                                                        <td>Jill</td>
                                                                                                                                        <td>Smith</td> 
                                                                                                                                        <td>50</td>
                                                                                                                                      </tr>
                                                                                                                                      <tr>
                                                                                                                                        <td>Eve</td>
                                                                                                                                        <td>Jackson</td> 
                                                                                                                                        <td>94</td>
                                                                                                                                      </tr>
                                                                                                                                    </table>-->
                                            <div class="pull-right">
                                                <input type="text" class="form-control" name="txtIdGuardado" id="txtIdGuardado" value="0" disabled="disabled">                                    	
                                            </div>
                                        </div>


                                        <div class="col-lg-6 col-md-12 col-xs-12">																									

                                            <!-- radio button seleccion del tipo de evento-->
                                            <div class="input-group" style="margin: 5px;">
                                                <input type="radio" name="rbTipoActividad" id="rbTipoActividad1" value="0" checked>
                                                Promoción en punto fijo.
                                                <input type="radio" name="rbTipoActividad" id="rbTipoActividad2" value="1">
                                                Actividad en unidad móvil.
                                            </div>							                

                                            <!-- Actividad . -->	
                                            <div class="input-group" style="margin: 5px;">
                                                <span class="label-warning input-group-addon">Ingrese Actividad:</span>						                  
                                                <input type="text" class="form-control" id="txtActividad" placeholder="Bandeo, Promoción, etc..." required="required">
                                            </div>

                                            <!-- Marca . -->	
                                            <div class="input-group" style="margin: 5px;">
                                                <span class="label-warning input-group-addon">Seleccione Marca:</span>						                 
                                                <select id="selListMarcas" class="form-control" onchange="selListMarcas_change()">
                                                    <option value="0" selected="selected" disabled="disabled">0-Seleccione una marca</option>

                                                    <?php
                                                    $sIdCliente = $_SESSION["sIdCliente"];
                                                    echo "id usuario $sIdCliente";
                                                    $sql = "SELECT * FROM planpromo_marcas where IdCliente = '$sIdCliente' ORDER BY Descripcion";
                                                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                                    while ($row2 = mysqli_fetch_array($result)) {
                                                        echo "<option value='" . ($row2['IdMarca']) . "'>" . $row2['IdMarca'] . "- " . ($row2['Descripcion']) . "</option>";
                                                    }
                                                    ?>

                                                </select>
                                            </div>


                                            <!-- Presentacion -->																
                                            <div class="input-group" style="margin: 5px;">
                                                <span class="label-warning input-group-addon">Ingrese Producto:</span>
                                                <input type="text" class="form-control" id="txtProducto" list="listProducto" onblur="txtProducto_onblur()" required="required" placeholder="Escriba o Seleccione">			                
                                                <datalist id="listProducto">												
                                                </datalist>
                                            </div>							            							           							            

                                            <!-- Esto es para mostrar la lista de productos agregados a la actividad -->
                                            <div id="arrayProductPromo" style="display: inline-block;"></div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-xs-12">
                                            <!-- mes . Desde -->	

                                            <div class="input-group" style="margin: 5px;">
                                                <span class="label-warning input-group-addon">Fecha Desde:</span>
                                                <input type="date" id="txtFechaDesde" class="form-control" placeholder="Ej: 2017-05-01" onchange="CalculaCantidadDias()">							            
                                            </div>	
                                            <!-- mes . Hasta -->	
                                            <div class="input-group" style="margin: 5px;">
                                                <span class="label-warning input-group-addon">Fecha Hasta:</span>
                                                <input type="date" id="txtFechaHasta" class="form-control" placeholder="Ej: 2017-05-02" onchange="CalculaCantidadDias()">							            
                                            </div>	
                                            <!-- Cantidad de Dias -->	
                                            <div class="input-group" style="margin: 5px;">
                                                <span class="label-warning input-group-addon">Cantidad dias:</span>
                                                <input type="number" id="txtCantidadDias" class="form-control" placeholder="Incluye no hábiles">							            
                                            </div>

                                            <!-- Canal -->
                                            <div class="input-group" style="margin: 5px;">							                
                                                <span class="label-warning input-group-addon">Canal Asignado:</span>
                                                <select id="selListCanales" class="form-control" onchange="selListCanales_change()">
                                                    <option value="0" selected="selected" disabled="disabled">0-Seleccione un canal</option>
                                                    <?php
                                                    $sIdCliente = $_SESSION["sIdCliente"];
                                                    $sql = "SELECT * FROM CatCanales ORDER BY NombreCanal";
                                                    $result = mysqli_query($conn, $sql);
                                                    while ($row2 = mysqli_fetch_array($result)) {
                                                        echo "<option value='" . ($row2['IdCanal']) . "'>" . $row2['IdCanal'] . "- " . ($row2['NombreCanal']) . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                <!--<input type="text" id="txtCanal" class="form-control" required="required">-->
                                            </div>
                                            <!-- Zonas -->
                                            <div class="input-group" style="margin: 5px;">							                
                                                <span class="label-warning input-group-addon">Zona Asignada:</span>
                                                <input type="text" id="txtZona" class="form-control" required="required">							            	
                                            </div>                                              

                                        </div>									

                                        <div class="col-lg-12 col-md-12 col-xs-12">		
                                            <!-- Descripcion: -->
                                            <div class="input-group" style="margin: 5px;">	
                                                <span class="label-warning input-group-addon">Desc Actividad:</span>
                                                <textarea rows="2" id="txtPromocion" class="form-control" required="required" placeholder="Describa en que consiste la actividad."></textarea>
                                            </div>		

                                            <!-- material POP -->
                                            <div class="input-group" style="margin: 5px;">							                
                                                <span class="label-warning input-group-addon">Recursos :</span>
                                                <input type="text" id="txtMaterialPOP" class="form-control" placeholder="Point of Purchase (Material Utilizado)">							            	
                                            </div>

                                            <!-- Cantidad del producto en promocion -->
                                            <div class="input-group" style="margin: 5px;">							                
                                                <span class="label-warning input-group-addon">Cant. Premios:</span>
                                                <input type="number" id="txtCantidad" class="form-control" min="0" required="required" placeholder="ej: 1,000" onblur="txtCantidad_onBlur()">        
                                            </div>  
                                            
                                            <!-- Premios -->
                                            <div class="input-group" style="margin: 5px;">							                
                                                <span class="label-warning input-group-addon">Desc. Premios:</span>
                                                <input type="text" id="txtPremios" class="form-control" placeholder="Separados por ;">							            	
                                            </div>

                                        </div>																	       
                                    </div>
                                    <!-- botones de asignar y cancelar -->
                                    <div class="box-footer">
                                        <input type="button" id="btnAsignar" value="Asignar" onclick="on_Asignar(<?php echo $_SESSION['sIdCliente'] . ',' . $_SESSION['sUserId']; ?>)" class="btn btn-normal btn-primary">									
                                        <input type="button" id="btnCancelar" value="Cancelar" onclick="on_Cancelar()" class="btn btn-normal btn-primary">		
                                        <div id="divPdVConAsignacion"></div>							
                                    </div>
                                </div>
                            </form>

                        </div>					
                        <!-- fin del panel de nueva Asignacion  -->

                        <!-- panel para asignar cantidad a los puntos de venta -->					
                        <div class="col-xs-12 col-md-4 col-lg-4">
                            <div class="box box-warning">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Asignar a puntos de venta</h3>
                                </div>
                                <div class="box-body">
                                    <div id="divContenedorPdV" style="display: none;">						                						             

                                        <!-- Esto muestra un campo de texto por si el punto de venta no existe -->
                                        <div style="margin-bottom: 20px;">
                                            <table style="width: 100%;">
                                                <tr>
                                                    <th style="column-span: 2;">Nombre del Punto de venta <sub>(Si no esta en la tabla)</sub></th>
                                                    <th>Cantidad</th>
                                                    <th>Acción</th>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" id="txtPdvNuevo" name="" style="width: 100%;"></td>
                                                    <td><input type="number" id="txtCantidadPdvNuevo" name="" style="width: 100%;"></td>
                                                    <td><input type="button" id="btnAgregarPdVNoExiste" name="" value="Agregar" onclick="click_btnAgregarPdVNoExiste()"</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <table id="tablepuntodeventa" class="display" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>				               
                                                    <th>Punto de Venta</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">								        	
                                            </tbody>
                                        </table>
                                        <div>
                                            <input type="button" id="btnGuardarAsignaciones" value="Guardar" onclick="on_btnGuardarAsignacionesClick()" class="btn btn-normal btn-primary">
                                            <input type="button" id="btnFinalizar" value="Finalizar" onclick="GuardaAsignacionFinal()" class="btn btn-normal btn-primary" disabled="disabled">
                                        </div>
                                        <!--<header>Para asignar arrastre de dercha a izquierda</header>
                                        
                                        <div id="subcontenedor2" ondragover="evdragover(event)" ondrop="evdrop(event,this)">
                                                <header>Productos</header>
                                                <img src="presto.jpg" alt="Bandera" 
                                              draggable="true" ondragstart="evdragstart(event)" id="e4"/>
                                                <img src="selecto.jpg" alt="Escudo" 
                                              draggable="true" ondragstart="evdragstart(event)" id="e5"/>
                                                <img src="himnonicaragua.jpg" alt="himnonicaragua" 
                                              draggable="true" ondragstart="evdragstart(event)" id="e6"/>
                                            <div class="producto"  draggable="true" ondragstart="evdragstart(event)" id="e7">
                                                <span>Cafe Toro / 112040</span></div>
                                                <div class="producto"  draggable="true" ondragstart="evdragstart(event)" id="e8">
                                                <span>Avena sasa 360 gr.</span></div>
                                        </div> 

                                        <div id="subcontenedor1" ondragover="evdragover(event)" ondrop="evdrop(event)">
                                                <header>Clientes</header>

                                                582814
                                         
                                                        <div class="clientes col col-xs-6 col-md-4 col-lg-3">Metrocentro</div>
                                                        <div class="clientes col col-xs-6 col-md-4 col-lg-3">Hiper</div>
                                                        <div class="clientes col col-xs-6 col-md-4 col-lg-3">Las Brisas</div>
                                                        <div class="clientes col col-xs-6 col-md-4 col-lg-3">plaza españa</div>
                                                        <div class="clientes col col-xs-6 col-md-4 col-lg-3">multicentro</div>
                                                        <div class="clientes col col-xs-6 col-md-4 col-lg-3">waspan</div>
                                                        <div class="clientes col col-xs-6 col-md-4 col-lg-3">plaza inter</div>
                                                        <div class="clientes col col-xs-6 col-md-4 col-lg-3">ciudad jardin</div>
                                                        <div class="clientes col col-xs-6 col-md-4 col-lg-3">camino de oriente</div>
                                                        <div class="clientes col col-xs-6 col-md-4 col-lg-3">123</div>
                                                        <div class="clientes col col-xs-6 col-md-4 col-lg-3">456</div>
                                                        <div class="clientes col col-xs-6 col-md-4 col-lg-3">789</div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="box-footer">

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
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../dist/js/app.min.js"></script>

        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="js/planpromocional.js" language="JavaScript" type="text/javascript"></script>
        <script type="text/javascript">

                                                var tbl_pdv;
                                                var cant_X_pdv_PDV = [];
                                                var cant_X_pdv_CANT = [];


                                                /*$(document).ready(function(){
                                                 var d = new Date();
                                                 var date1 = new Date("4-3-2017");
                                                 var date2 = new Date("4-5/2017");
                                                 var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                                                 var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
                                                 alert(diffDays);
                                                 //document.getElementById("txtAnio").value = d.getFullYear(); 
                                                 });*/

                                                $(document).ready(function () {

                                                    $('#tablepuntodeventa tbody').on('change', 'input', function () {

                                                        var data1 = tbl_pdv.row($(this).parents('tr')).data();	// fila de la tabla
                                                        var cantidaddisponible = parseInt(document.getElementById("totaldisponible").value);	//Cantidad ingresada de paquetes
                                                        var cantidadAsignada = this.value;		//Cantidad que se va a asignar al pdv

                                                        if (isNumeric(cantidadAsignada)) {

                                                            if (cantidadAsignada > 0) {

                                                                if (cantidaddisponible >= cantidadAsignada) {

                                                                    if (!FnContieneArray(cant_X_pdv_PDV, data1[0])) {

                                                                        cant_X_pdv_PDV.push(data1[0]);
                                                                        cant_X_pdv_CANT.push(cantidadAsignada);
                                                                    } else {

                                                                        var index = cant_X_pdv_PDV.indexOf(data1[0]);

                                                                        if (index !== -1) {
                                                                            cant_X_pdv_CANT[index] = (cantidadAsignada);
                                                                            console.log("Elemento editado.");
                                                                        }
                                                                    }

                                                                    var element = document.createElement("div");
                                                                    element.id = "divPdvs";
                                                                    element.class = "main col-xs-6 col-md-4 col-lg-3";
                                                                    element.style = "background : #ddd;";
                                                                    element.appendChild(document.createTextNode(data1[0] + ', ' + cantidadAsignada));
                                                                    document.getElementById("divPdVConAsignacion").appendChild(element);




                                                                    // calcula y muestra el total asignado y su restante
                                                                    var totalasignado = 0;
                                                                    for (var i = 0; i < cant_X_pdv_CANT.length; i++) {

                                                                        totalasignado = parseFloat(totalasignado) + parseFloat(cant_X_pdv_CANT[i]);
                                                                    }

                                                                    var cantidtotal = document.getElementById("txtCantidad").value;
                                                                    var cantiddispo = parseFloat(cantidtotal - totalasignado);

                                                                    document.getElementById("cantidadtotal").value = cantidtotal;
                                                                    document.getElementById("totalasignado").innerText = totalasignado;
                                                                    document.getElementById("totaldisponible").value = cantiddispo;

                                                                } else {

                                                                    alert("No permitido. La cantidad asignada es mayor que la cantidad disponible.");

                                                                }
                                                            } else {
                                                                alert("No permitido." + cantidadAsignada + " - " + data1[0] + " - " + data1[1]);
                                                            }
                                                        } else {
                                                            alert("error, solo números.");
                                                        }

                                                    });
                                                });

                                                function click_btnAgregarPdVNoExiste() {

                                                    var pdvnuevo = document.getElementById("txtPdvNuevo").value;
                                                    var cantpdvnuevo = document.getElementById("txtCantidadPdvNuevo").value;
                                                    var cantiddisponible = parseInt(document.getElementById("totaldisponible").value);

                                                    if (isNumeric(cantpdvnuevo)) {

                                                        if (pdvnuevo.length > 0) {

                                                            if (cantpdvnuevo > 0) {

                                                                if (cantiddisponible >= cantpdvnuevo) {

                                                                    if (!FnContieneArray(cant_X_pdv_PDV, pdvnuevo)) {

                                                                        cant_X_pdv_PDV.push(pdvnuevo);
                                                                        cant_X_pdv_CANT.push(cantpdvnuevo);
                                                                        console.log("Elementos agregados.");

                                                                    } else {

                                                                        var index = cant_X_pdv_PDV.indexOf(pdvnuevo);

                                                                        if (index !== -1) {
                                                                            cant_X_pdv_CANT[index] = (cantpdvnuevo);
                                                                            console.log("Elemento editado.");
                                                                        }
                                                                    }

                                                                    console.log(pdvnuevo + ', ' + cantpdvnuevo + ' - ' + cant_X_pdv_PDV + ' - ' + cant_X_pdv_CANT);

                                                                    var element = document.createElement("div");
                                                                    element.id = "divPdvs";
                                                                    element.class = "main col-xs-6 col-md-4 col-lg-3";
                                                                    element.style = "background : #ddd;";
                                                                    element.appendChild(document.createTextNode(pdvnuevo + ', ' + cantpdvnuevo));
                                                                    document.getElementById("divPdVConAsignacion").appendChild(element);

                                                                    // calcula y muestra el total asignado y su restante
                                                                    var totalasignado = 0;
                                                                    for (var i = 0; i < cant_X_pdv_CANT.length; i++) {

                                                                        totalasignado = parseFloat(totalasignado) + parseFloat(cant_X_pdv_CANT[i]);
                                                                    }

                                                                    var cantidtotal = document.getElementById("txtCantidad").value;
                                                                    var cantiddispo = parseFloat(cantidtotal - totalasignado);

                                                                    document.getElementById("cantidadtotal").value = cantidtotal;
                                                                    document.getElementById("totalasignado").innerText = totalasignado;
                                                                    document.getElementById("totaldisponible").value = cantiddispo;

                                                                } else {
                                                                    alert("No permitido. La cantidad asignada es mayor que la cantidad disponible.");
                                                                }

                                                            } else {
                                                                alert("No permitido." + cantpdvnuevo + " - " + pdvnuevo);
                                                            }

                                                        } else {
                                                            alert("error, Ingrese un nombre del punto de venta a agregar.");
                                                        }
                                                    } else {
                                                        alert("error, solo números.");
                                                    }
                                                }

                                                function FnContieneArray(arr, obj) {
                                                    var i = arr.length;
                                                    while (i--) {

                                                        if (arr[i] === obj) {
                                                            return true;
                                                        }
                                                    }
                                                    return false;
                                                }


                                                function on_btnGuardarAsignacionesClick() {

                                                    var idplanpromno = document.getElementById("txtIdGuardado").value;
                                                    var FechaRegistro = new Date().toISOString().slice(0, 10);

                                                    if (idplanpromno > 0) {

                                                        if (cant_X_pdv_PDV.length > 0) {

                                                            for (var i = 0; i < cant_X_pdv_PDV.length; i++) {

                                                                var Pdv = cant_X_pdv_PDV[i];
                                                                var cant_X_pdv = cant_X_pdv_CANT[i];

                                                                $.ajax({
                                                                    type: 'post',
                                                                    dataType: 'json',
                                                                    cache: 'false',
                                                                    data: {idppPromocion: idplanpromno,
                                                                        IdPdV: Pdv,
                                                                        Cantidad_x_pdv: cant_X_pdv,
                                                                        Observacion: "",
                                                                        FechaRegistro: FechaRegistro},
                                                                    url: 'php/guarda_cant_x_pdv_actividad.php',
                                                                    beforeSend: function () {
                                                                        console.log("Guardando... " + cant_X_pdv_PDV[i] + '-' + cant_X_pdv_CANT[i]);
                                                                    },
                                                                    success: function (res) {

                                                                        if (res.success == 1) {
                                                                            console.log("guardado. " + res.error);
                                                                        } else {
                                                                            console.log("Fallo al guardar. " + res.error);
                                                                        }
                                                                    },
                                                                    error: function (res) {},
                                                                    always: function (res) {}
                                                                });
                                                            }
                                                            document.getElementById("btnGuardarAsignaciones").style.display = 'none';
                                                            document.getElementById("btnFinalizar").disabled = false;
                                                            alert("Se ha guardado con éxito, Presione Finalizar.");
                                                        } else {
                                                            alert("Favor asignar cantidad al menos a un punto de venta.");
                                                        }
                                                    }

                                                    /*tbl_pdv.rows().every(function(){
                                                     
                                                     var v = this.data();
                                                     
                                                     if (v[1]>0) {
                                                     
                                                     }
                                                     
                                                     });	*/
                                                }

                                                function isNumeric(n) {
                                                    return !isNaN(parseFloat(n)) && isFinite(n);
                                                }
        </script>

        <script type="text/javascript">

            var idpadre1 = null;
            var idpadre2 = null;
            
            var idarrastrado = null; /**/

            /* La primera se corresponde con el evento ondragstart que se aplica a los elementos arrastrables, y la escribiremos así:*/
            function evdragstart(ev) {
                ev.dataTransfer.setData("text", ev.target.id);

                idpadre1 = ev.target.parentNode.id;
                idarrastrado = ev.target.id;/**/
            }

            /* La segunda función se corresponde con el evento ondragover y consiste simplemente en aplicar el método preventDefault() sobre el evento, para que éste no tome el comportamiento por defecto y pueda ser arrastrado el elemento.*/
            function evdragover(ev) {
                ev.preventDefault();
            }

            /* La tercera función se corresponde con el evento ondrop y su misión es hacer que el elemento arrastrado se quede en el receptor de soltado.*/
            function evdrop(ev, el) {

                idpadre2 = ev.target.parentNode.id;

                ev.stopPropagation();
                ev.preventDefault();
                data = ev.dataTransfer.getData("text");
                ev.target.appendChild(document.getElementById(data));
                alert('Padre1: ' + idpadre1 + ', padre2:' + idpadre2);
            }
        </script>
        <!-- Valida input solo numeros positivos -->
        <script type="text/javascript">
            // Select your input element.
            var numInput = document.getElementById('txtCantidad');
            // Listen for input event on numInput.
            numInput.addEventListener('input', function () {
                // Let's match only digits.
                var num = this.value.match(/^\d+$/);
                if (num === null) {
                    // If we have no match, value will be empty.
                    this.value = "";
                }
            }, false)
        </script>
        <script type="text/javascript">

            function CalculaCantidadDias() {

                var FI = document.getElementById("txtFechaDesde").value;
                var FechInic = FI.split('-');

                var date1 = new Date(document.getElementById("txtFechaDesde").value);
                var date2 = new Date(document.getElementById("txtFechaHasta").value);
                var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                var diffDays = 1 + (Math.ceil(timeDiff / (1000 * 3600 * 24)));

                //var diferencia = daydiff(parseDate(document.getElementById("txtFechaDesde").value, parseDate(document.getElementById("txtFechaHasta").value)));
                document.getElementById("txtCantidadDias").value = (diffDays);
            }
        </script>
    </body>
</html>