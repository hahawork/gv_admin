<?php
session_start();

$Servidor = 'https://' . $_SERVER['HTTP_HOST'] . "/admin/"; // obtiene la ruta del DNS : http://grupovalor.com.ni/

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: ../login/index.php');
    exit;
}
// else {
//     
//     header("Location: " . $Servidor . $_SESSION['sPaginaInicio']);
//}

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];

$admin = 'disabled';


if ($NivelAcceso == 1) {
    $admin = '';
    echo "<a href='" . $Servidor . "pages/posicion-supervisores.php'><i class='fa fa-map'></i> Ultima Ubicación Supervisiones</a>";
}


require_once("../conexion/conexion.php");
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

$date = date("Y-m-d");
$dateSelected = isset($_POST["dateSelected"]) ? $_POST["dateSelected"] : $date;
$idUsuarioSelected = isset($_POST["selectUsuario"]) ? $_POST["selectUsuario"] : '0';
$nombreSeleccionado = isset($_POST["NombreUsuario"]) ? $_POST["NombreUsuario"] : '';

$consulta = "SELECT usuario.NombreUsuario,usuario_asistencia.IdPdV,usuario_asistencia.Observacion, date_format(usuario_asistencia.FechaRegistro, '%H:%i') as FechaRegistro, date_format(usuario_asistencia.FechaSalida, '%H:%i') as FechaSalida, usuario.LabelPin, usuario.idUsuario, puntosdeventa.NombrePdV, puntosdeventa.LocationGPS FROM `usuario_asistencia` INNER JOIN puntosdeventa on usuario_asistencia.IdPdV = puntosdeventa.IdPdV INNER JOIN usuario on usuario.idUsuario = usuario_asistencia.idUsuario
WHERE usuario_asistencia.idUsuario = '$idUsuarioSelected' AND date_format(usuario_asistencia.FechaRegistro, '%Y-%m-%d') = '$dateSelected' ORDER by usuario_asistencia.FechaRegistro";


$sql2 = mysqli_query($conn, $consulta) or die(mysqli_error($conn));

$z = array();
$path = array();

$indice = 0;

$VariarLong = 0.00006;

while ($row2 = mysqli_fetch_array($sql2)) {
    $y = array();

    $coordenada = $row2["LocationGPS"];
    $myArray = explode(',', $coordenada);

    if ($row2["IdPdV"] == 29) {
        $coordenadaepe = explode(":", $row2["Observacion"]);
        $myArray = explode(",", $coordenadaepe[1]);
    }

    $y[] = ($row2["NombreUsuario"]);
    $y[] = $myArray[0] + 0;
    $y[] = $myArray[1] + $VariarLong;
    $y[] = $row2["FechaRegistro"];
    $y[] = ($row2["NombrePdV"]);
    $y[] = $row2["LabelPin"];
    $y[] = $row2["idUsuario"];
    $y[] = $row2["FechaSalida"];
    $z[$indice] = $y;
    $indice++;


    $coord = array();
    $coord["lat"] = $myArray[0] + 0;
    $coord["lng"] = $myArray[1] + 0;
    array_push($path, $coord);

    if ($row2["IdPdV"] == 27) {
        $VariarLong = $VariarLong - 0.00003;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Ver mvimientos del usuario.</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes" name="viewport">
        <link rel="icon" type="image/png" href="../favicon.png">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="../dist/css/AdminLTE.css">
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">


        <!--         Material Design  -->
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">


        <style>
            #map {
                height: 100%;
            }

            #floating-panel {
                background-color: #fff;
                padding: 5px;
                border: 1px solid #999;
                text-align: center;
                font-family: 'Roboto','sans-serif';
                padding-left: 10px;
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



            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Supervisión<small>Panel de Control</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-sitemap"></i> Home</a></li>
                        <li class="active">Panel de control</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-danger" >
                                <div class="box-header with-border">
                                    <h3 class="box-title pull-left">Usuarios</h3>                                    
                                    <div class="box-tools pull-right">                                        
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body" style="height: 500px;">                                                                        

                                    <div id="map"></div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div id="floating-panel1" class="col-sm-9">
                                <form class="form-inline" name="frmConsultar" action="Supervisor-Display_get_ruta_diaria.php" method="POST">

                                    <div class="input-group">
                                        <label for="selectUsuario" class="input-group-addon label-info">Usuario</label>
                                        <select class="form-control" name="selectUsuario" id="selectUsuario" onchange="setTextField(this)">                                                
                                            <option value="0" selected="selected" disabled="disabled">Seleccione un usuario...</option>
                                            <?php
                                            $sql = "";
                                            if ($NivelAcceso == 1) {
                                                $sql = "SELECT * FROM `usuario` WHERE EstadoActivo = 1 ORDER BY `NombreUsuario` ASC";
                                            }
                                            if ($NivelAcceso == 3) {
                                                $sql = "SELECT * FROM `usuario` WHERE IdCliente = '$idCliente' AND EstadoActivo = 1 ORDER BY `NombreUsuario` ASC";
                                            }

                                            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                            while ($row2 = mysqli_fetch_array($result)) :
                                                ?>
                                                <option value="<?php echo ($row2['idUsuario']); ?>"><?php echo ($row2['NombreUsuario']); ?></option>;
                                            <?php endwhile;
                                            ?>
                                        </select>
                                        <!-- Script para tomar el nombre de la persona seleccionada en la lista-->
                                        <input id="NombreUsuario" type = "hidden" name = "NombreUsuario" value = "" />
                                        <script type="text/javascript">
                                            function setTextField(ddl) {
                                                document.getElementById('NombreUsuario').value = ddl.options[ddl.selectedIndex].text;
                                            }
                                        </script>  
                                    </div>
                                    <div class="input-group">
                                        <label for="dateSelected" class="input-group-addon label-info">Fecha</label>
                                        <input type="date" name="dateSelected" class="form-control" id="dateSelected" value="<?php echo $dateSelected; ?>" max="<?php echo $date; ?>">
                                    </div>
                                    <button class="btn btn-success">Consultar</button>
                                </form>

                            </div>
                            <div class="col-sm-3">
                                <button onclick="drop()" class="btn btn-danger">Reiniciar</button>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="box box-danger" >
                                <div class="box-header with-border">
                                    <h3 class="box-title pull-left">Puntos de Venta (<span class="label-warning"><?php echo $nombreSeleccionado; ?></span>)</h3>                                    
                                    <div class="box-tools pull-right">                                        
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body w3-theme-l4">                                      
                                    <?php
                                    $pos = 0;
                                    foreach ($z as $value) :
                                        ?>
                                        <div class="col-sm-6 col-md-4 col-lg-3 btn-link" onclick="showPosicion(<?php echo $pos; ?>)">
                                            <div class="w3-white w3-card" style="margin: 4px; padding: 5px;"><?php echo "Ent:" . $value[3] . " - " . $value[4] . " Sal:" . $value[7]; ?><i class="fa fa-arrow-right pull-right" style="color: #00f;"></i></div>
                                        </div>                                   
                                        <?php
                                        $pos = $pos + 1;
                                    endforeach;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>


        <script>

            var arreglo = <?php echo json_encode($z); ?>;
            var coorden = <?php echo json_encode($path); ?>;
            var markers = [];
            var map;
            var directionsService, directionsDisplay, puntoA, puntoB;
            //var flightPath;
            var marcador;
            function myMap() {

                var mapCanvas = document.getElementById("map");
                var myCenter = new google.maps.LatLng(arreglo[0][1], arreglo[0][2]);
                var mapOptions = {center: myCenter, zoom: 13};
                map = new google.maps.Map(mapCanvas, mapOptions);
                // Instantiate a directions service.
                var directionsService = new google.maps.DirectionsService,
                        directionsDisplay = new google.maps.DirectionsRenderer({
                            map: map
                        });
                /*flightPath = new google.maps.Polyline({
                 path: coorden,
                 geodesic: true,
                 strokeColor: "#0000FF",
                 strokeOpacity: 0.8,
                 strokeWeight: 2
                 });*/
                clearMarkers();
                //flightPath.setMap(map);
                for (var i = 0; i < coorden.length; i++) {
                    addMarkerWithTimeout(i, coorden[i], i * 1500);
                }
            }

            function drop() {
                clearMarkers();
                //flightPath.setMap(map);
                for (var i = 0; i < coorden.length; i++) {
                    addMarkerWithTimeout(i, coorden[i], 1500);
                }
            }
            function addMarkerWithTimeout(i, position, timeout) {
                window.setTimeout(function () {
                    markers.push(new google.maps.Marker({
                        position: position,
                        label: arreglo[i][3],
                        map: map,
                        title: arreglo[i][4],
                        animation: google.maps.Animation.DROP
                    }));
                    try {

                        if (i == 0) {
                            puntoA = position;
                        } else {

                            puntoB = position;

                            // get route from A to B
                            calculateAndDisplayRoute(
                                    directionsService,
                                    directionsDisplay,
                                    puntoA,
                                    puntoB
                                    );
                            
                            puntoA = puntoB;
                        }

                    } catch (e) {
                    }
                    
                    map.panTo(position);
                }, timeout);
            }

            function clearMarkers() {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(null);
                }
                //flightPath.setMap(null);
                markers = [];
            }

            function showPosicion(position) {
                try {
                    marcador.setMap(null);
                } catch (err) {
                    console.log(err.message);
                }
                map.panTo(coorden[position]);
                var image = {
                    url: 'https://cdn0.vox-cdn.com/dev/uploads/chorus_asset/file/8108508/sandbox-www-data-ip-10-0-0-66_/sandbox_favicon-32x32.0.png',
                    size: new google.maps.Size(32, 32),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(0, 32)
                };
                var shape = {
                    coords: [0, 0, 0, 32, 18, 20, 18, 1],
                    type: 'poly'
                };
                marcador = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    icon: image,
                    animation: google.maps.Animation.BOUNCE,
                    shape: shape,
                    position: coorden[position]
                });
            }
            
            function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
                directionsService.route({
                    origin: pointA,
                    destination: pointB,
                    avoidTolls: true,
                    avoidHighways: false,
                    travelMode: google.maps.TravelMode.DRIVING
                }, function (response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(response);
                    } else {
                        window.alert('Directions request failed due to ' + status);
                    }
                });
                
                var a = 0;
            }
        </script>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBeAPkXd6qY2mg2QJ0bdMWbqO7Wjgs3diM&callback=myMap" async defer></script>
        <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>       
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../dist/js/app.min.js"></script>        
    </body>
</html>
