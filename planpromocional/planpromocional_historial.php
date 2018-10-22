<?php

  session_start();

  if (!$_SESSION["sUserId"]) { 
	header('Location: ../login/index.php');
  }
  require_once("../conexion/conexion.php");

	//Se crea nuevo objeto de la clase conexion
	$cnn = new conexion();
	$conn=$cnn->conectar();


	// para seleccionar de manera aleatoria el efecto de carga de la pagina

	/*$iconos_carga = array("Preloader_1", "Preloader_2", "Preloader_3", "Preloader_4", "Preloader_5", "Preloader_6", "Preloader_7", "Preloader_8", "Preloader_9", "Preloader_10", "Preloader_3128");
	$indic_imageload = array_rand($iconos_carga, 10);
	echo $iconos_carga[$indic_imageload[0]];*/

	$iconos_carga = ["Preloader_1", "Preloader_2", "Preloader_3", "Preloader_4", "Preloader_5", "Preloader_6", "Preloader_7", "Preloader_8", "Preloader_9", "Preloader_10", "Preloader_11",
					"Preloader_12", "Preloader_13", "Preloader_14", "Preloader_15", "Preloader_16", "Preloader_17", "Preloader_18", "Preloader_19", "Preloader_20", "Preloader_21", "Preloader_22", "Preloader_23", "Preloader_25"];
	$indic_imageload = $iconos_carga[mt_rand(0, count($iconos_carga) -1 )];
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

	<title>Historia de Actividades</title>

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
	<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
	<script>
		//paste this code under head tag or in a seperate js file.
		// Wait for window load
		$(window).load(function() {
			// Animate loader off screen
			$(".se-pre-con").fadeOut("slow");;
		});
	</script>
	<!-- fin anim carga de la pagina -->

</head>
<body class="hold-transition layout-boxed skin-blue sidebar-mini">
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
						<a href="login/logout.php"><i class="fa fa-circle text-success"></i> Cerrar Sesión</a>
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
							<li><a href="planpromocional.php"><i class="fa fa-book"></i> Nueva Actividad.</a></li>
							<li class="active"><a href="planpromocional_historial.php"><i class="fa fa-database"></i> Lista de Actividades</a></li>
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
					<li><a href="planpromocional.php"> Panel de control</a></li>
					<li class="active">Historial</li>
				</ol>
			</section>

			<div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active">
                    <h3 class="widget-user-username"><?php echo $_SESSION["sUserName"]; ?></h3>
                    <h5 class="widget-user-desc">Developer &amp; CEO</h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="<?php echo '../' . $_SESSION['simgFotoPerfilUrl']; ?>" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">3</h5>
                                <span class="description-text">BANDEO</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header" id="totalasignado">13</h5>
                                <span class="description-text">PRODUCTOS ASIGNADOS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header">5,000</h5>
                                <span class="description-text">UNIDADES</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>

			<!-- Main content -->
			<section class="content">
				<div class="row">
					<!-- Panel de lista de asignaciones -->
					<div class="col-lg-12 col-md-12 col-xs-12">

						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title"> Lista de Bandeos</h3>
								<div class="box-tools pull-right">
	                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                            </div>
							</div>
							<div class="box-body ">
								<table id="example">
							        <thead>
							            <tr>
							                <th>Name</th>
							                <th>Position</th>
							                <th>Office</th>
							                <th>Extn.</th>
							                <th>Start date</th>
							                <th>Salary</th>
							            </tr>
							        </thead>
							        <tfoot>
							            <tr>
							                <th>Name</th>
							                <th>Position</th>
							                <th>Office</th>
							                <th>Extn.</th>
							                <th>Start date</th>
							                <th>Salary</th>
							            </tr>
							        </tfoot>
							    </table>
							</div>
						</div>
					</div>
					<!-- fin del panel de lista de asignaciones  -->

					<!-- Panel de lista detalle bandeo -->
					<div class="col-lg-12 col-md-12 col-xs-12">

						<div class="box box-success">
							<div class="box-header with-border">
								<h3 class="box-title"> Lista de Bandeos</h3>
								<div class="box-tools pull-right">
	                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                            </div>
							</div>
							<div class="box-body ">
								
							</div>
						</div>	
					</div>
					<!-- fin del panel de lista detallle bandeo  -->
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
<script src="../dist/js/app.min.js"></script>

<script src="../plugins/datatables/jquery.dataTables.min.js"></script>

<script>
	$(document).ready(function() {
	    var table = $('#example').DataTable( {
	    	"paging": true,
          	"lengthChange": false,
          	"searching": false,
          	"ordering": false,
          	"info": true,
          	"autoWidth": false,
	      	"columnDefs": [ {
	         	"targets": -1,
	            "data": null,
	            "defaultContent": "<button>Ver</button>"
	        } ]
	    } );
         
	    $('#example tbody').on( 'click', 'button', function () {
	        var data = table.row( $(this).parents('tr') ).data();
	        alert( data[0] +"'s salari es de: "+ data[ 5 ] );
	    } );
	} );
</script>

</body>
</html>
