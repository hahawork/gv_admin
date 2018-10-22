<?php 

	require_once ("../../conexion/conexion.php");
	$cnn = new conexion();
	$conn = $cnn -> conectar();

if ( isset ( $_POST['IdProducto'] ) ) {
	
	$IdProducto = $_POST['IdProducto'];
	$Descripcion = $_POST['Descripcion'];
	

	$Guardado = 0;
	$error = "";

		$query = "INSERT INTO planpromo_marcas (IdProducto, Descripcion) VALUES ('$IdProducto', '$Descripcion')";		
		
		$resultado = mysqli_query ( $conn, $query);

		$error = $error . mysqli_error($conn);

		if ($resultado) {
			
			$Guardado = 1;
		}
		
		$arrayName = array('Guardado' => $Guardado, 'error' => $error);
		echo json_encode($arrayName);

}
 ?>