<?php 

	require_once ("../../conexion/conexion.php");
	$cnn = new conexion();
	$conn = $cnn -> conectar();

if ( isset ( $_POST['Mes'] ) ) {
	
	$Mes = $_POST['Mes'];
	$Marcas = $_POST['Marcas'];
	$DetallePromo = $_POST['DetallePromo'];
	$ZonasAsignadas = $_POST['ZonasAsignadas'];
	$CantidadTotal = $_POST['CantidadTotal'];
	$Observacion = $_POST['Observacion'];
	$IdPromoUpdate = $_POST['IdPromoUpdate'];

	$Cadena = 0;
	$error = "";

	$error = $error . " estoy en modo " . $metodo;

		$queryupdate = "UPDATE planpromo_promocion SET Mes = '$Mes', Marcas = '$Marcas', DetallePromo = '$DetallePromo', ZonasAsignadas = '$ZonasAsignadas', CantidadTotal = '$CantidadTotal', Observacion = '$Observacion', FechaRegistro = '$FechaRegistro' where IdPromocion = $IdPromoUpdate";

		$error = $error . " cadena a ejecutar" . $queryupdate;

		$resultadoupdate = mysqli_query ( $conn, $queryupdate);

		$error = $error . mysqli_error($conn);

		if ($resultadoupdate) {
  			$Cadena = $IdPromoUpdate;
		}
		
		$arrayNameupd = array('maxIdpromo' => $Cadena, 'error' => $error);
		echo json_encode($arrayNameupd);

}
 ?>