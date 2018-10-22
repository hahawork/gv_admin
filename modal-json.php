<?php 

require_once("conexion/conexion.php");
$cnn = new conexion();
$conn=$cnn->conectar();

$sql = "SELECT usuario_asistencia.idAsistencia, usuario.NombreUsuario, puntosdeventa.NombrePdV, date_format(usuario_asistencia.FechaRegistro, '%H:%i:%s') as Hora, "
        . "(usuario_asistencia.CantGastosMovim + usuario_asistencia.CantGastosMovimTaxi + usuario_asistencia.CantGastosAlim + usuario_asistencia.CantGastosHosped + usuario_asistencia.CantGastosVario) as Gastos,"
        . "date_format(usuario_asistencia.FechaRegistro, '%d-%b-%Y') as FechaRegistro, usuario_asistencia.Observacion "
        . "FROM "
        . "usuario_asistencia INNER JOIN "
        . "usuario ON usuario.idUsuario = usuario_asistencia.idUsuario LEFT JOIN "
        . "puntosdeventa ON puntosdeventa.IdPdV = usuario_asistencia.IdPdV "
        . "WHERE usuario_asistencia.idUsuario = " . $_POST['IdSupervisor'] . " AND "
        . "date_format(usuario_asistencia.FechaRegistro, '%Y-%m-%d') = date_format('" . $_POST['Fecha'] . "', '%Y-%m-%d')";

$resAsis = mysqli_query($conn, $sql);

$CADENA = "<ul class='timeline'>
<li class='time-label'>";

while ($row = mysqli_fetch_array($resAsis)) {
	
	$CADENA = $CADENA . "<span class='bg-yellow'>". $row['FechaRegistro']."</span>
	<li>
	<i class='fa fa-arrow-right bg-blue'></i>
	<div class='timeline-item'>
	<span class='time'>
	<i class='fa fa-clock-o'></i>" . $row['Hora'] . "
	</span>
	<h3 class='timeline-header'>
	<i class='fa fa-angle-double-right'></i>
	" . ($row['NombrePdV']) . "
	</h3>
	<div class='timeline-body'>
	<div>" . ($row['Observacion']) . "</div>
	</div>
	</div>
	</li>";
}

$CADENA = $CADENA . "</li>					    			
</ul>";

$arrayName = array('mensaje' => $CADENA);
echo json_encode($arrayName);
?>