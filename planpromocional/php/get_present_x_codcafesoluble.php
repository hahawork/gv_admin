<?php

  	require_once("../../conexion/conexion.php");

	//Se crea nuevo objeto de la clase conexion
	$cnn = new conexion();
	$conn=$cnn->conectar();


	if (isset($_GET['CodCafeSoluble'] )){
	
		$idp = $_GET['CodCafeSoluble'];

		//$SQL= "SELECT * FROM puntosdeventa WHERE UserSave = '$idp'";
		$sql = "SELECT * FROM planpromo_presentaciones WHERE CodCafeSoluble = $idp";

		$result = mysqli_query($conn, $sql);

		if (($result->num_rows) > 0) {

			$row2 = mysqli_fetch_array($result);

			$arrayName = array(
				'IdPresentacion' => $row2['IdPresentacion'], 
				'IdCliente' => $row2['IdCliente'],
				'IdMarca' => $row2['IdMarca'],
				'CodCafeSoluble' => $row2['CodCafeSoluble'],
				'CodCasaMantica' => $row2['CodCasaMantica'],
				'CodigoWalmart' => $row2['CodigoWalmart'],
				'CodigoBarras' => ($row2['CodigoBarras']),
				'Descripcion' => ($row2['Descripcion']),
				'FechaRegistro' => $row2['FechaRegistro'],
				'IdCanal' => $row2['IdCanal']
				);
			echo json_encode($arrayName);
		}
	}
?>