<?php 

	require_once ("../../conexion/conexion.php");
	$cnn = new conexion();
	$conn = $cnn -> conectar();

if ( isset ( $_POST['TipoActividad'] ) ) {
	
	$TipoActividad = $_POST['TipoActividad'];
	$Presentaciones = $_POST['Presentaciones'];
	$FechaInicio = $_POST['FechaInicio'];
	$FechaFin = $_POST['FechaFin'];
	$CantidadDiasActividad = $_POST['CantidadDiasActividad'];
	$Canales = $_POST['Canales'];
	$Departamentos = $_POST['Departamentos'];
	$CantidadPaque = $_POST['CantidadPaque'];
	$DescripcionActiv = $_POST['DescripcionActiv'];
	$MaterialPOP = $_POST['MaterialPOP'];
	$Premios = $_POST['Premios'];
	$IdCliente = $_POST['IdCliente'];
	$IdUsuario = $_POST['IdUsuario'];
	$FechaReg = $_POST['FechaReg'];
	$PDVoUNIDMovil= $_POST['PDVoUNIDMovil'];
	$bolAsignado = $_POST['bolAsignado'];
	$bolRecibido = $_POST['bolRecibido'];
	$bolEntregado = $_POST['bolEntregado'];

	$Cadena = 0;
	$error = "";

		$query = "INSERT INTO planpromo_actividad () VALUES 
			(NULL, '$TipoActividad', '$Presentaciones', '$FechaInicio', '$FechaFin', '$CantidadDiasActividad', '$Canales', '$Departamentos', 
			'$CantidadPaque', '$DescripcionActiv', '$MaterialPOP', '$Premios', '$IdCliente', '$IdUsuario', 
			'$FechaReg', '$PDVoUNIDMovil', '$bolAsignado', '$bolRecibido', '$bolEntregado')";		
		
		$resultado = mysqli_query ( $conn, $query);

		$error = $error . mysqli_error($conn);

		if ($resultado) {
			
			$sql = "SELECT max(IdActividad) as maxIdpromo FROM planpromo_actividad";

			$res = mysqli_query($conn, $sql);

			$error = $error . mysqli_error($conn);

			$row = mysqli_fetch_array($res);

  			$Cadena = $row['maxIdpromo'];
		}
		
		$arrayName = array('maxIdpromo' => $Cadena, 'error' => $error);
		echo json_encode($arrayName);

}
 ?>