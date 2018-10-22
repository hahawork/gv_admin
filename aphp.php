<?php 

	require_once ("conexion/conexion.php");
	$cnn = new conexion();
	$conn = $cnn -> conectar();

if ( isset ( $_POST['idUsuario'] ) ) {
	
	$idUsuario = $_POST['idUsuario'];
	$IdPdV = $_POST['IdPdV'];
	$CantGastosMovim = $_POST['CantGastosMovim'];
	$CantGastosMovimTaxi = $_POST['CantGastosMovimTaxi'];
	$CantGastosAlim = $_POST['CantGastosAlim'];
	$CantGastosHosped = $_POST['CantGastosHosped'];
	$CantGastosVario = $_POST['CantGastosVario'];
	$FechaRegistro = $_POST['FechaRegistro'];
        $FechaSalida = $_POST['FechaSalida'];
	$Observacion = $_POST['Observacion'];
        $kmactual = $_POST['kmactual'];

	$Guardado = 0;
	$error = "";

		$query = "INSERT INTO usuario_asistencia(idUsuario,IdPdV,CantGastosMovim,CantGastosMovimTaxi,CantGastosAlim,CantGastosHosped,CantGastosVario,FechaRegistro,Observacion, KmActual, FechaSalida) "
                        . "VALUES ('$idUsuario', '$IdPdV','$CantGastosMovim','$CantGastosMovimTaxi','$CantGastosAlim','$CantGastosHosped','$CantGastosVario','$FechaRegistro','$Observacion', '$kmactual', '$FechaSalida')";		
		
		$resultado = mysqli_query ( $conn, $query);

		$error = $error . mysqli_error($conn);

		if ($resultado) {
			
			$Guardado = 1;
		}
		
		$arrayName = array('Guardado' => $Guardado, 'error' => $error);
		echo json_encode($arrayName);

}
else{
$arrayName = array('Guardado' => 0, 'error' => "no parametros " . $_POST['idUsuario'] );
		echo json_encode($arrayName);
}
 ?>
