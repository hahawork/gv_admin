<?php 

	require_once ("../../conexion/conexion.php");
	$cnn = new conexion();
	$conn = $cnn -> conectar();

if ( isset ( $_POST['IdPromoDelete'] ) ) {
	
	$IdActividadDelete = $_POST['IdPromoDelete'];

	$Cadena = 0;
	$error = "";
	$success = 0;

	$query = "DELETE FROM planpromo_actividad WHERE IdActividad = '$IdActividadDelete'";

	$resultado = mysqli_query ( $conn, $query);

	$sqlDeleteAsignaciones="delete from planpromo_asignacion_actividad where idppPromocion = '$IdActividadDelete'";

	$res = mysqli_query($conn, $sqlDeleteAsignaciones);

	$error = $error . mysqli_error($conn);

	if ($resultado) {

		$Cadena = "Cancelado";
		$success = 1;

	}
	
	$arrayName = array('success' => $success, 'mensaje' => $Cadena, 'error' => $error);
	echo json_encode($arrayName);
}
 ?>