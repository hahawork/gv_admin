<?php

require_once("conexion/sw_conexion.php");
//Se crea nuevo objeto de la clase conexion para la base de datos del sist web
$cnn = new sw_conexion();
$conn = $cnn->sw_conectar();

 // Selects all the rows in the markers table.
 $query = 'SELECT id, NombreCliente, PosicionGPS, NumeroPOS FROM tbl_puntos_claro';

 $result = mysqli_query($conn, $query);
 mysqli_query($conn, "SET NAMES 'utf8'");
 if (!$result) 
 {
  die('Invalid query: ' . mysqli_error($conn));
 }

// Creates an array of strings to hold the lines of the KML file.
$kml = array('<?xml version="1.0" encoding="UTF-8"?>');
$kml[] = '<kml xmlns="http://earth.google.com/kml/2.1">';
$kml[] = ' <Document>';
$kml[] = ' <name>puntosdeventa_claro.kml</name>';
$kml[] = ' <open>1</open>';
$kml[] = ' <Style id="pinStyle">';
$kml[] = ' <IconStyle id="barIcon">';
$kml[] = ' <color>ff0000ff</color>';
$kml[] = ' <Icon>';
$kml[] = ' <href>http://grupovalor.com.ni/admin/pages/pin.png</href>';
$kml[] = ' </Icon>';
$kml[] = ' </IconStyle>';
$kml[] = ' <LabelStyle>';
$kml[] = ' <color>ff00ffff</color>';
$kml[] = ' <scale>0.7</scale>';
$kml[] = ' </LabelStyle>';
$kml[] = ' </Style>';

// Iterates through the rows, printing a node for each row.
while ($row = mysqli_fetch_array($result)) 
{

  $coordenada = $row["PosicionGPS"];
    $myArray = explode(',', $coordenada);
    
  $kml[] = ' <Placemark id="placemark' . $row['id'] . '">';
  $kml[] = ' <name>' . ($row['NombreCliente']) . '</name>';
  $kml[] = ' <description></description>';
  $kml[] = ' <styleUrl>#pinStyle</styleUrl>';
  $kml[] = ' <Point>';
  $kml[] = ' <altitudeMode>relativeToGround</altitudeMode>';
  $kml[] = ' <coordinates>' . $myArray[1] . ','. $myArray[0]. ',3</coordinates>';
  $kml[] = ' </Point>';
  $kml[] = ' </Placemark>';
} 

// End XML file
$kml[] = ' </Document>';
$kml[] = '</kml>';
$kmlOutput = join("\n", $kml);
header('Content-type: application/vnd.google-earth.kml+xml');
header('Content-Disposition: attachment; filename=puntosdeventa_claro.kml');
echo $kmlOutput;
?>