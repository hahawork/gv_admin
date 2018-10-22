<?php 

	require_once ("../../conexion/conexion.php");
	$cnn = new conexion();
	$conn = $cnn -> conectar();

if ( isset ( $_POST['IdMarca'] ) ) {
	
	$IdCliente = $_POST['IdCliente'];
	$IdMarca = $_POST['IdMarca'];
	$CodCafeSoluble	 = $_POST['CodCafeSoluble'];
	$CodCasaMantica = $_POST['CodCasaMantica'];
	$CodigoWalmart = $_POST['CodigoWalmart'];
	$CodigoBarras = $_POST['CodigoBarras'];
	$Descripcion = $_POST['Descripcion'];
	$IdCanal = $_POST['IdCanal'];
	

	$Guardado = 0;
	$error = "";


		
		$query = "INSERT INTO planpromo_presentaciones (IdCliente, IdMarca, CodCafeSoluble, CodCasaMantica, CodigoWalmart, CodigoBarras, Descripcion, FechaRegistro, IdCanal) 
		VALUES ('$IdCliente', '$IdMarca', '$CodCafeSoluble', '$CodCasaMantica', '$CodigoWalmart', '$CodigoBarras', '$Descripcion', CURRENT_TIMESTAMP, '$IdCanal')";		
		
		$resultado = mysqli_query ( $conn, $query);

		$error = $error . mysqli_error($conn);

		if ($resultado) {
			
			$Guardado = 1;
		}
		
		$arrayName = array('Guardado' => $Guardado, 'error' => $error);
		echo json_encode($arrayName);

}
 ?>