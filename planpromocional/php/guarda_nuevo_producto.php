<?php 

	require_once ("../../conexion/conexion.php");
	$cnn = new conexion();
	$conn = $cnn -> conectar();

if ( isset ( $_POST['Descripcion'] ) ) {
	
	$Descripcion = $_POST['Descripcion'];
	$IdCliente = $_POST['IdCliente'];

	$Guardado = 0;
	$error = "";

		$query = "INSERT INTO planpromo_productos (Descripcion, Cliente) VALUES ('$Descripcion', '$IdCliente')";		
		
		$resultado = mysqli_query ( $conn, $query);

		$error = $error . mysqli_error($conn);

		if ($resultado) {
			
			$Guardado = 1;
		}
		
		$arrayName = array('Guardado' => $Guardado, 'error' => $error);
		echo json_encode($arrayName);

}
 ?>