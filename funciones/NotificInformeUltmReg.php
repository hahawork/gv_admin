<?php

session_start();

if (!$_SESSION["sUserId"]) {
    header('Location: login/index.php');
}

require_once ("../conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];

$ultimoIdAgregado = 0;

$sql = "";

if ($NivelAcceso == 1) {

    $sql = "SELECT usuario_asistencia.idAsistencia, usuario.NombreUsuario, puntosdeventa.NombrePdV, puntosdeventa.Ciudad, date_format(FechaRegistro, '%d-%b %H:%i:%s') as Hora, usuario.Foto_URL FROM usuario_asistencia INNER JOIN usuario ON usuario.idUsuario = usuario_asistencia.idUsuario INNER JOIN puntosdeventa ON puntosdeventa.IdPdV = usuario_asistencia.IdPdV ORDER BY usuario_asistencia.idAsistencia DESC LIMIT 1";
}

if ($NivelAcceso == 3){
    
    $sql = "SELECT usuario_asistencia.idAsistencia, usuario.NombreUsuario, puntosdeventa.NombrePdV, puntosdeventa.Ciudad, date_format(FechaRegistro, '%d-%b %H:%i:%s') as Hora, usuario.Foto_URL FROM usuario_asistencia INNER JOIN usuario ON usuario.idUsuario = usuario_asistencia.idUsuario INNER JOIN puntosdeventa ON puntosdeventa.IdPdV = usuario_asistencia.IdPdV WHERE usuario.IdCliente = '$idCliente'  ORDER BY usuario_asistencia.idAsistencia DESC LIMIT 1";
    
}


$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);
$ultimoIdAgregado = $row['idAsistencia'];


$arrayName = array('maxId' => $ultimoIdAgregado, 'NombreUsuario' => ($row['NombreUsuario']),
    'NombrePdV' => ($row['NombrePdV']) . ', ' . ($row['Ciudad']), 'Hora' => $row['Hora'], 'Foto_URL' => ($row['Foto_URL']));

echo json_encode($arrayName);
?>