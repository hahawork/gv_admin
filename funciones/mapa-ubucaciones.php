<?php
$mapzoom = 8;
$consulta = "";

if ($NivelAcceso == 1) {
    $consulta = "SELECT DISTINCT idUsuario  from `usuario_asistencia` WHERE date_format(`FechaRegistro`,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d') ORDER BY idUsuario";
}

if ($NivelAcceso == 3) {
    $consulta = "SELECT DISTINCT usuario_asistencia.idUsuario  "
            . "from `usuario_asistencia` INNER "
            . "JOIN usuario on usuario_asistencia.idUsuario = usuario.idUsuario "
            . "WHERE usuario.IdCliente = $idCliente AND date_format(`FechaRegistro`,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d') "
            . "ORDER BY idUsuario";
    //$consulta = "SELECT * FROM vw_ultima_asistencia_hoy WHERE IdCliente = $idCliente";
}

if ($NivelAcceso == 4) {

    $consulta = "SELECT DISTINCT usuario_asistencia.idUsuario  "
            . "from `usuario_asistencia` INNER "
            . "JOIN usuario on usuario_asistencia.idUsuario = usuario.idUsuario "
            . "WHERE usuario_asistencia.idUsuario = $idUsuario OR idSupervisor = $idUsuario AND date_format(`FechaRegistro`,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d') "
            . "ORDER BY usuario_asistencia.idUsuario";
    //$consulta = "SELECT * FROM vw_ultima_asistencia_hoy WHERE idUsuario = $idUsuario OR idSupervisor = $idUsuario";
}
//$consulta = "CALL spObtenerUltimoPdVMarcadoMapa($NivelAcceso, $idCliente, $idUsuario)";
//se hace la consulta dfe los usuarios 
$sqlusuario = mysqli_query($conn, $consulta) or die(mysqli_error($conn));

$z = array();
$indice = 0;

$VariarLong = 0.00006;
if (mysqli_num_rows($sqlusuario) > 0) {
    while ($row = mysqli_fetch_array($sqlusuario)) {
        try {
            $iduser = $row["idUsuario"];

            $sqlRegistro = "select `u`.`idUsuario` AS `idUsuario`,`u`.`NumTelefono` AS `NumTelefono`,`u`.`NombreUsuario` AS `NombreUsuario`,`u`.`idSupervisor` AS `idSupervisor`,`pdv`.`IdPdV` AS `IdPdV`,`pdv`.`NombrePdV` AS `NombrePdV`,`t1`.`FechaRegistro` AS `FechaRegistro`,`t1`.`Observacion` AS `Observacion`,`pdv`.`LocationGPS` AS `LocationGPS`,`u`.`LabelPin` AS `LabelPin`,`u`.`IdCliente` AS `IdCliente` "
                    . "from `usuario_asistencia` `t1` "
                    . "join `puntosdeventa` `pdv` on `t1`.`IdPdV` = `pdv`.`IdPdV` "
                    . "join `usuario` `u` on `t1`.`idUsuario` = `u`.`idUsuario` "
                    . "where t1.idUsuario = $iduser AND FechaRegistro =  (SELECT MAX(FechaRegistro) FROM usuario_asistencia WHERE idUsuario = $iduser)";

            $resultReg = mysqli_query($conn, $sqlRegistro) or die(mysqli_error($conn));
            if (mysqli_num_rows($resultReg) > 0) {
                while ($row2 = mysqli_fetch_array($resultReg)) {

                    $y = array();

                    $coordenada = $row2["LocationGPS"];
                    $myArray = explode(',', $coordenada);


                    if ($row2["IdPdV"] == 29) {
                        $coordenadaepe = explode(":", $row2["Observacion"]);
                        $myArray = explode(",", $coordenadaepe[1]);
                    }

                    if (sizeof($myArray) == 2) {
                        $y[] = ($row2["NombreUsuario"]);
                        $y[] = $myArray[0];
                        $y[] = $myArray[1] + $VariarLong;
                        $y[] = $row2["FechaRegistro"];
                        $y[] = ($row2["NombrePdV"]);
                        $y[] = $mapzoom;
                        $y[] = $row2["LabelPin"];
                        $y[] = $row2["idUsuario"];
                        $z[$indice] = $y;
                        $indice++;

                        if ($row2["IdPdV"] == 27) {
                            $VariarLong = $VariarLong - 0.00003;
                        }
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
} else {      //si no se encontro ningun registro
    $y = array();
    $y[] = "Oficinas"; //($row2["NombreUsuario"]);
    $y[] = "12.112408"; //$myArray[0];
    $y[] = "-86.252742"; //$myArray[1] + $VariarLong;
    $y[] = date("Y-m-d H:i:s"); //$row2["FechaRegistro"];
    $y[] = "Marketing One"; //($row2["NombrePdV"]);
    $y[] = $mapzoom;
    $y[] = ""; //$row2["LabelPin"];
    $y[] = "0"; //$row2["idUsuario"];
    $z[$indice] = $y;
}
?>

<div id="map" style="width:100%;height:500px;" ></div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
      integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
      crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"
        integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
crossorigin=""></script>


<script type="text/javascript">

    var arrData = <?php echo json_encode($z); ?>;
    var posic = 0;

    var center = arrData.length > 0 ? [arrData[posic][1], arrData[posic][2]] : [12.4564543, -86.867432];

    // initialize the map on the "map" div with a given center and zoom
    var map = L.map('map').fitWorld();
    /*var map = L.map(
            'map',
            {
                center: center,
                zoom: 8
            });*/



    map.locate({setView: true, maxZoom: 8});
    //var map = L.map('map').setView([12.4564654, -86.09], 13);

    // muestra la escala.
    L.control.scale().addTo(map);   

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //L.tileLayer('https://api.tiles.mapbox.com/v4/MapID/997/256/{z}/{x}/{y}.png', {
    //L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + mapboxAccessToken, {
        id: 'mapbox.satellite',
        attribution: '&copy; <a href="https://www.grupovalor.com.ni/mo">Marketing One </a> HHerrera',
        minZoom: 7, maxZoom: 18,
        updateWhenIdle: true,
        reuseTiles: true
    }).addTo(map);

    var myIcon = L.icon({
        iconUrl: 'dist/pin.png',
        iconSize: [23, 35],
        iconAnchor: [22, 34],
        popupAnchor: [-3, -30]//,
                //shadowUrl: 'my-icon-shadow.png',
                //shadowSize: [68, 95],
                //shadowAnchor: [22, 94]
    });
    for (posic = 0; posic < arrData.length; posic++) {

        L.marker([arrData[posic][1], arrData[posic][2]], {icon: myIcon})
                .addTo(map)
                //.on('click', onClick)
                //.on('mouseover', onClick)
                .bindPopup(arrData[posic][0] + " - " + arrData[posic][4])
        //.openPopup()
        //.bindTooltip(arrData[posic][0] + " - " + arrData[posic][4])
        //.openTooltip();

    }

    function onClick(e) {
        alert(this.getLatLng());
    }
    //esta funcion es para la version movil
    function onLocationFound(e) {
        var radius = e.accuracy / 2;

        /* L.marker(e.latlng).addTo(map)
         .bindPopup("You are within " + radius + " meters from this point").openPopup();
         
         L.circle(e.latlng, radius).addTo(map);*/
    }
    map.on('locationfound', onLocationFound);
    function onLocationError(e) {

        alert(e.message);
    }
    map.on('locationerror', onLocationError);

</script>