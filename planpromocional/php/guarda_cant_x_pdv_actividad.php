<?php 

	require_once ("../../conexion/conexion.php");
	$cnn = new conexion();
	$conn = $cnn -> conectar();

if ( isset ( $_POST['idppPromocion'] ) ) {
	
	$idppPromocion = $_POST['idppPromocion'];
	$IdPdV	 = utf8_decode($_POST['IdPdV']);
	$Cantidad_x_pdv = $_POST['Cantidad_x_pdv'];
	$Observacion = utf8_decode($_POST['Observacion']);
	$FechaRegistro = utf8_decode($_POST['FechaRegistro']);

	$Total = 0;
	$success = 0;
	$error = "";
	$Mensaje = "";
	$sqlInsertUpdate = "";

	// Verifica si ya esta asigsanada una cantdad al punto de venta y esta actividad
	$sqlcomprobacion = "selec * from planpromo_asignacion_actividad where idppPromocion = ". $idppPromocion . " and PuntoVenta = ". $IdPdV;


	$resultadoComprobacion = mysqli_query($conn, $sqlcomprobacion);

	// si no se ha asignado al punto de venta
	if ($resultadoComprobacion -> num_rows > 0) {

		// se actualiza
		$sqlInsertUpdate = "UPDATE planpromo_asignacion_actividad SET Cantidad_x_pdv = " . $Cantidad_x_pdv . ", PuntoVenta = ". $IdPdV . " where idppPromocion = ". $idppPromocion . " and PuntoVenta = ". $IdPdV;
	}
	else{

		//se inserta uno nuevo
		$sqlInsertUpdate = "INSERT INTO planpromo_asignacion_actividad VALUES (NULL, '$idppPromocion', '$IdPdV', '$Cantidad_x_pdv', '$FechaRegistro', '$Observacion','','','','')";
	}
	
	$Mensaje = $Mensaje . "-" . $sqlInsertUpdate;

	$resultado = mysqli_query ( $conn, $sqlInsertUpdate);

	$error = $error . mysqli_error($conn);

	if ($resultado) {

		$success = 1;

		$sql = "SELECT sum(Cantidad_x_pdv) as total FROM planpromo_asignacion_actividad where idppPromocion = ". $idppPromocion . " and PuntoVenta = ". $IdPdV;

		$res = mysqli_query($conn, $sql);
		mysqli_query($conn, "SET NAMES 'utf8'");


		$error = $error . mysqli_error($conn);

		$row = mysqli_fetch_array($res);

  		$Total = $row['total'];
  		
	}
		
	$arrayName = array('success' => $success,'TotalAsignado' => $Total, 'error' => $error, 'mensaje'=> $Mensaje);
	echo json_encode($arrayName);
}
 ?>