 <?php


  session_start();


  if (!$_SESSION["sUserId"]) { 
    header('Location: ../login/index.php');   
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    exit;
  }
 
 
	$val1 = "";
	$idpdv=0;
	$mapzoom = 8;
	

	$UserSave = isset($_POST['select1']) ? $_POST['select1'] : '';
	
	require_once("../conexion/conexion.php");

	//Se crea nuevo objeto de la clase conexion
	$cnn = new conexion();
	$conn=$cnn->conectar();
	
	if (isset($_POST['submit1'] ))
	{
		$UserSave = $_POST['select1'];
	}

	$sql2= mysqli_query($conn,"SELECT IdPdV, NombrePdV, LocationGPS, NombreUsuario UserSave FROM puntosdeventa INNER JOIN usuario on usuario.idUsuario = puntosdeventa.UserSave WHERE UserSave LIKE '%$UserSave%'");
	
	if (isset($_GET['clicked'])){
		$idpdv = $_GET['clicked'];
		if ($idpdv > 0){
			$sql2= mysqli_query($conn,"SELECT IdPdV, NombrePdV, LocationGPS, NombreUsuario UserSave FROM puntosdeventa INNER JOIN usuario on usuario.idUsuario = puntosdeventa.UserSave WHERE IdPdV =$idpdv");
			$mapzoom = 17;
		}
		else{
			$sql2= mysqli_query($conn,"SELECT IdPdV, NombrePdV, LocationGPS, NombreUsuario UserSave FROM puntosdeventa INNER JOIN usuario on usuario.idUsuario = puntosdeventa.UserSave WHERE UserSave LIKE '%$UserSave%'");
		}
		
	}
	
		
    $z = array();
    $n=0;
    

    while( $row2 =mysqli_fetch_array($sql2)){
      $y=array(); 

	  $coordenada = $row2["LocationGPS"];
	  $myArray = explode(',', $coordenada);
	  
      $y[]=$row2["UserSave"];
      $y[]=$myArray[0];
      $y[]=$myArray[1];
      $y[]=$row2["IdPdV"];
      $y[]=($row2["NombrePdV"]);
	  $y[]= $mapzoom;
      $z[$n]=$y;
      $n++;
     }

   ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Puntos de Venta registrados</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="icon" type="image/png" href="../favicon.png">
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="../dist/css/AdminLTE.css">
		<link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
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
			            	<i class="fa fa-dashboard"></i> <span>Sitios</span>
			            	<span class="pull-right-container">
			              		<i class="fa fa-angle-left pull-right"></i>
			            	</span>
		          		</a>
			          	<ul class="treeview-menu">
			            	<li ><a href="../index.php"><i class="fa fa-circle-o"></i> Panel de control.</a></li>
			            	<li class="active"><a href="verpdv.php"><i class="fa fa-map"></i> Puntos de venta gráfico</a></li>
			            	<li><a href="verpdvlist.php"><i class="fa fa-map-pin"></i> Puntos de venta listado</a></li>
			            	<li><a href="../tables/asistencia-imprimir.php"><i class="fa fa-user"></i> Asistencia de las supervisoras</a></li>
			            	<li><a href="../tables/asistenciaoficinaimprimir.php"><i class="fa fa-certificate"></i> Asistencia de Oficinas</a></li>
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
				<h1>Supervisión<small>Panel de Control</small></h1>
				<ol class="breadcrumb">
					<li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Puntos de venta registrados</li>
				</ol>
			</section>

				<!-- Main content -->
				<section class="content">
				<!-- Small boxes (Stat box) -->
					<div class="row">
						<div class="box box-solid bg-blue">
							<div class="box-header" style="color:#000;">
								<form action="verpdv.php" method="post">
									<?php
										global $conn;
										$result = mysqli_query($conn, "SELECT DISTINCT UserSave FROM puntosdeventa");
										echo "<select name='select1' id ='select1'>";
										echo "<option value=\"\">Todos</option>";
										while ($row = mysqli_fetch_array($result)) {
											echo "<option value='" . $row['UserSave'] ."'>" . $row['UserSave'] ."</option>";
										}
										echo "</select>";
									?>
										<script >$('#select1').val('<?php echo $UserSave; ?>');</script>

									<input type="submit" name="submit1" value=" VER " />
								</form>
							</div>

							<div class=" box-body">
								<div style="position: relative; height: 800px; color: #000;">
									<table class="table table-bordered" width="100%" height="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#000000">
										<tr> 
											<th style="width:75%; height:30px;">Puntos de Venta</th>
											<th>Listado General</th>
										</tr>
										<tr> 
											<td >
												<div id="map" style="width:100%;height:100%;" ></div>

												<script>
												function myMap() {
													var locationsb = <?php echo json_encode($z);?>;
													var n=0;
                                                                                                        //var locationRio = {lat: -22.915, lng: -43.197};
													var myCenter = new google.maps.LatLng(locationsb[n][1], locationsb[n][2]);
													var mapCanvas = document.getElementById("map");
													var mapOptions = {
                                                                                                            gestureHandling: 'greedy', 
                                                                                                            center: myCenter, 
                                                                                                            zoom: locationsb [n][5]
                                                                                                        };
													var map = new google.maps.Map(mapCanvas, mapOptions);
												  
													var image = {
														url: 'pin.png',
														// This marker is 20 pixels wide by 32 pixels high.
														size: new google.maps.Size(20, 32),
														// The origin for this image is (0, 0).
														origin: new google.maps.Point(0, 0),
														// The anchor for this image is the base of the flagpole at (0, 32).
														anchor: new google.maps.Point(0, 32)
													};
													// Shapes define the clickable region of the icon. The type defines an HTML
													// <area> element 'poly' which traces out a polygon as a series of X,Y points.
													// The final coordinate closes the poly by connecting to the first coordinate.
													var shape = {
														coords: [1, 1, 1, 20, 18, 20, 18, 1],
														type: 'poly'
													};
													
													var marker1;
													for (n = 0; n < locationsb.length; n++) {
														var ur = ''; 
														if (locationsb[n][0].includes("1")){
															ur='pin1.png';
														} 
														else{
															ur='pin.png';
														}
														var img={
															url : ur,
															size: new google.maps.Size(20, 32),
														origin: new google.maps.Point(0, 0),
														anchor: new google.maps.Point(0, 32)
														};
														marker1 = new google.maps.Marker({
															position: new google.maps.LatLng(locationsb[n][1], locationsb[n][2]),
															title: locationsb[n][4],
															map:map,
															icon: img,
															shape: shape
														});

														google.maps.event.addListener(marker1, 'click', (function(marker1, n) {
															return function() {
																infowindow.setContent("id:"+locationsb[n][3] + ".<br/>" + locationsb[n][4] + ".<br/>Guardó: " + locationsb[n][0]);
																infowindow.open(map, marker1);
															}
														})(marker1, n));
												    
														//marker1.setMap(map);
													}
													var infowindow = new google.maps.InfoWindow({
														content: "Puntos de ventas registrados."
													});
													infowindow.open(map,marker1);
												}
												</script>

												<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBeAPkXd6qY2mg2QJ0bdMWbqO7Wjgs3diM&callback=myMap" async defer></script>
											</td>
											<td >
					
												<?php
													global $conn;
													$result = mysqli_query($conn, "SELECT IdPdV, NombrePdV FROM puntosdeventa WHERE UserSave LIKE '%$UserSave%'");
													echo "<ol style=\"max-height:100%; overflow: scroll;\">";
													while ($row = mysqli_fetch_array($result)) {
														echo "<li value='" . $row['IdPdV'] ."'><a href=\"verpdv.php?clicked=". $row['IdPdV'] . "\">" . ($row['NombrePdV']) ."</a></li>";
													}
													echo "</ol>";
												?>					
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
	      			</div>
	      			<!-- /.row (main row) -->

	    		</section>
	    		<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->
	  		<footer class="main-footer">
				<div class="pull-right" id="footer">
					<h6>Si quieres la version para Google Earth haz click <b><a href="../pdv-generarkml.php">aqui</a></b></h6>
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

	</body>
</html>
