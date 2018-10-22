<?php 

	require_once ("../../conexion/conexion.php");
	$cnn = new conexion();
	$conn = $cnn -> conectar();

if ( isset ( $_POST['idppPromocion'] ) ) {
	
	$idppPromocion = $_POST['idppPromocion'];

	$success = 0;
	$error = "";


	$sqlUpdate = "UPDATE planpromo_actividad SET bolAsignado = 1 where IdActividad = ". $idppPromocion;
	
		
	$resultado = mysqli_query ( $conn, $sqlUpdate);

	$error = $error . mysqli_error($conn);

	if ($resultado) {
			
		$success = 1;

	}
		
	$arrayName = array('success' => $success, 'error' => $error);
	echo json_encode($arrayName);

}
 ?>