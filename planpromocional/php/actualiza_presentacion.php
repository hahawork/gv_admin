<?php 

	require_once ("../../conexion/conexion.php");
	$cnn = new conexion();
	$conn = $cnn -> conectar();

if ( isset ( $_POST['IdPresentacion'] ) ) {
	
	$IdPresentacion = $_POST['IdPresentacion'];
	$IdCliente = $_POST['IdCliente'];
	$IdMarca = $_POST['IdMarca'];
	$CodCafeSoluble	 = $_POST['CodCafeSoluble'];
	$CodCasaMantica = $_POST['CodCasaMantica'];
	$CodigoWalmart = $_POST['CodigoWalmart'];
	$CodigoBarras = $_POST['CodigoBarras'];
	$Descripcion = $_POST['Descripcion'];
	$IdCanal = $_POST['IdCanal'];


	$Cadena = 0;
	$Actualizado = 0;
	$error = "";

	$error = $error . " estoy en modo " . $metodo;

		$queryupdate = "UPDATE planpromo_presentaciones SET IdCliente = '$IdCliente', IdMarca = '$IdMarca', CodCafeSoluble = '$CodCafeSoluble', CodCasaMantica = '$CodCasaMantica', CodigoWalmart = '$CodigoWalmart', CodigoBarras = '$CodigoBarras', Descripcion = '$Descripcion', IdCanal = '$IdCanal' where IdPresentacion = $IdPresentacion";

		$error = $error . " cadena a ejecutar" . $queryupdate;

		$resultadoupdate = mysqli_query ( $conn, $queryupdate);

		$error = $error . mysqli_error($conn);


			$Actualizado = 1;
		if ($resultadoupdate) {
  			$Cadena = $IdPromoUpdate;
		}
		
		
		$arrayNameupd = array('Actualizado' => $Actualizado,'maxIdpromo' => $Cadena, 'error' => $error);
		echo json_encode($arrayNameupd);

}
 ?>
